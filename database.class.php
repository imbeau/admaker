<?php

class database
{
	private $host;
	private $user;
	private $password;
	private $dbName;

	private static $instance;

	private $connection;
	private $results;
	private $numRows;

	private function __construct()
	{

	}


	/*Singleton.  Insures that if the object has been created
	 *it doesn't create a second one and instead passes the original
	 */

	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	function connect($host, $user, $password, $dbName)
	{
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->dbName = $dbName;

		$this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->dbName);

	}	



	public function doQuery($sql)
	{
		$this->results = mysqli_query($this->connection, $sql);
		return $this->results;
	}
	
	public function checkError()
	{
		return mysqli_error($this->connection);
	}
	
	public function rowsAffected()
	{
		return $numRows;
	}
	
	public function getLastInsertID()
	{
		//return mysqli_insert_id($this->connection);
		
	}


	public function loadObjectList()
	{
		$obj;
		if($this->results)
		{
			while($row = mysqli_fetch_assoc($this->results))
			{
				$obj[] = $row;
			}
		}

		//if(empty($obj))
		//	die("Query returned no results!");

		return $obj;
	}

}

?>
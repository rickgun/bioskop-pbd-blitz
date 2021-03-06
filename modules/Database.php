<?php
	class Database
	{
		private $connect;

		function __construct()
		{
			$this->connect = null;
		}
	
		function connect()
		{
			$database = 'dbBioskop';
			$servername = 'localhost';
			$username = 'root';
			$password = '';

			try
			{
				$this->connect = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
				// Set the PDO error mode to exception
				$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    		}
			catch(PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
			return $this->connect;
		}
	
		function disconnect()
		{
			$this->connect = null;
		}
	}
?>

<?php

define( 'MYSQL_HOST', 'localhost' );
define( 'MYSQL_USER', 'root' );
define( 'MYSQL_PASSWORD', '*@2195ad7bacd' );
define( 'MYSQL_DB_NAME', 'rpa' );

class DataBase {

	private $pdo = null;
	private $stmt = null;
	private $sql = null;

	function __construct($dbname = MYSQL_DB_NAME)
	{
		try {
		   $this->pdo = new PDO("mysql:host=".MYSQL_HOST.";dbname=".$dbname, MYSQL_USER, MYSQL_PASSWORD);  
		} catch (PDOException $e) {
		   echo 'Connection failed: ' . $e->getMessage();
		}
	}

	public function Query($sql, $arrayParams = array()) {
		$this->sql = $sql;
		$this->stmt = $this->pdo->prepare($this->sql);
		if(sizeof($arrayParams) > 0) {

			foreach ($arrayParams as $key => $cada) {

				if(!empty($key) && !empty($cada['value'])) {


					if(!isset($cada['type']) || empty($cada['type']))
						$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_STR);
					else {
						switch ($cada['type']) {
							case 'STR':
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_STR);
								break;
							case 'INT':
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_INT);
								break;
							case 'BOOL':
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_BOOL);
								break;
							case 'NULL':
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_NULL);
								break;
							case 'CHAR':
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_STR_CHAR);
								break;
							
							default:								
								$this->stmt->bindParam(":$key", $cada['value'], PDO::PARAM_STR);
								break;
						}
					}
					

				}

			}

		}
		return $this->stmt->execute();
	}

	
	public function Prepare($sql) {
		if(!empty($sql)){
			$this->stmt = $this->pdo->prepare($sql);
		}
	}

	public function BindParam($name, $val, $type) {

		$this->stmt->bindParam($name, $val, $type);

	}

	public function Execute() {
		return $this->stmt->execute();
	}

	public function FetchAllArray() 
	{
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function AffectedRows() 
	{
		return $this->stmt->rowCount();
	}

	public function NumRows() 
	{
		return $this->stmt->rowCount();
	}

	public function lastID() {
		return $this->pdo->lastInsertId();
	}


}
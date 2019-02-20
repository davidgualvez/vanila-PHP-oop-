<?php

class DBConnection {
    private $connpdo;

	public function connectPDO(){
			require_once 'database/Config.php';
			
			// $this->connpdo = new PDO('sqlsrv:Server='.DB_HOST.';Database='.DB_DATABASE.'', ''.DB_USER.'', ''.DB_PASSWORD.''); //sample conn for sql server
			
			// $this->connpdo = new PDO('mysql:host=localhost;dbname=sampleDB', 'username', 'password');  //default mysql conn
			
			$this->connpdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.'',''.DB_USER.'', ''.DB_PASSWORD.''); 
			
	        return $this->connpdo; 
	}

 }
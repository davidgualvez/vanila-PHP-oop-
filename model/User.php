<?php

class User {

	public $userID;
	public $firstname;
	public $middlename;
	public $lastname;

	public $accountID;
	public $username;
	public $password;
	public $token;
	public $dateCreated;

	private $userDB;

	function __construct(){
		require_once 'database/UserDB.php';
		$this->userDB = new UserDB();
	}


	public function hashPassword(){
		$this->password = md5($this->password);
	}

	public function addNewUserAccount(){

		$this->hashPassword();

		$this->accountID = $this->userDB->addAccount($this);

		if($this->accountID > 0){
			return $this->userDB->addUser($this);//return true
		}
		
		return false;

	}

	public function createToken(){
		$this->token =  md5($this->username.date('Y-m-d H:i:s'));
	}

	public function loginUser(){
		$this->createToken();
		$this->hashPassword();
		return $this->userDB->loginUser($this);
	}

}
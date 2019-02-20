<?php

class UserDB {

	private $connPDO;

	function __construct(){
        
        require_once 'DBConnection.php';
        require_once 'model/User.php';

        $db = new DBConnection();
        $this->connPDO = $db->connectPDO();
    }

    public function getUserByID($id){
    	$sql =  "SELECT * from users where UserID = :userID";
    	$pdh =  $this->connPDO;
    	$sth =  $pdh->prepare($sql);
    	$sth->bindParam(":userID", $id);
    	$sth->execute();

    	$result = $sth->fetchAll();

    	$user = new User();

    	$user->userID = $result[0]['UserID'];
    	$user->firstname = $result[0]['FirstName'];
    	$user->middlename = $result[0]['MiddleName'];
    	$user->lastname = $result[0]['LastName'];
    	$user->accountID = $result[0]['AccountID'];

    	return $user;

    }

    public function getAllUsers(){

        $sql = "SELECT * from users left join accounts on accounts.AccountID = users.AccountID";
        $pdh = $this->connPDO;
        $sth = $pdh->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll();

        if(!$result){
            return false;
        }

        $users = array();

        $queryLength = count($result);

        for($i = 0; $i < $queryLength; $i++){
            $user = new User();

            $user->userID       = $result[$i]['UserID'];
            $user->firstname    = $result[$i]['FirstName'];
            $user->middlename   = $result[$i]['MiddleName'];
            $user->lastname     = $result[$i]['LastName'];
            $user->accountID    = $result[$i]['AccountID'];
            $user->username     = $result[$i]['Username'];
            $user->password     = $result[$i]['Password'];

            array_push($users, $user);
        }

        return $users;
    }

    public function loginUser(User $user){
        $sql = "SELECT * from accounts where Username = :username and Password = :password";
        $pdh = $this->connPDO;
        $sth =$pdh->prepare($sql);
        $sth->bindParam(":username", $user->username);
        $sth->bindParam(":password", $user->password);
        $sth->execute();

        $result = $sth->fetchAll();

        if($result){
            $sql2 = "UPDATE accounts set Token = :token where AccountID = :accountID";
            $pdh2 = $this->connPDO;
            $sth2 =$pdh2->prepare($sql2);
            $sth2->bindParam(":token", $user->token);
            $sth2->bindParam(":accountID", $result[0]['AccountID']);
            $result2 = $sth2->execute();

            if($result2){
                return true;
            }

            return false;
        }

        return false;

    }

    public function addAccount(User $user){

    	$sql = "Insert into accounts (Username, Password) VALUES (:username, :password)";
    	$pdh = $this->connPDO;
    	$sth =$pdh->prepare($sql);
    	$sth->bindParam(":username", $user->username);
    	$sth->bindParam(":password", $user->password);
    	$sth->execute(); 
    	$id =  $pdh->lastInsertId(); 

    	return $id;
    	
    }

    public function addUser(User $user){
    	$sql = "Insert into users (AccountID, FirstName, MiddleName, LastName) VALUES (:accountiD, :firstname, :middlename, :lastname)";
    	$pdh = $this->connPDO;
    	$sth =$pdh->prepare($sql);
    	$sth->bindParam(":accountiD", $user->accountID);
    	$sth->bindParam(":firstname", $user->firstname);
    	$sth->bindParam(":middlename", $user->middlename);
    	$sth->bindParam(":lastname", $user->lastname);
    	$result = $sth->execute(); 

    	return $result;
    	// return $pdh->lastInsertId(); 
    }

}
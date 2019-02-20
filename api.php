<?php
header('Access-Control-Allow-Origin: *');  
header('Content-type: application/json');

require_once 'database/UserDB.php';
require_once 'model/User.php';

$db = new UserDB;

$tag = $_POST['tag'];

if($tag=="getUserByID"){
  $id       = $_POST['userID'];

  $response = $db->getUserByID($id);//, $status);

  // if($activate){
  //   echo json_encode(
  //     array(
  //       "statusCode"=>0,
  //       "statusDescription"=>"Activate Success"
  //       )
  //     );
  // }else{
  //   echo json_encode(
  //     array(
  //       "statusCode"=>1,
  //       "statusDescription"=>"Activate Error"
  //       )
  //     );
  // }
}

if($tag=="login"){

	$username = $_POST['username'];
	$password = $_POST['password'];

	$user = new User();

	$user->username = $username;
	$user->password = $password;

	$result = $user->loginUser();

	if($result){ //true || > 0
		echo json_encode(
	      	array(
		        "statusCode"=>1,
		        "statusDescription"=>"Successful login!",
		        "token" => $user->token
	        )
	    );

	    return;
	}

	echo json_encode(
	      	array(
		        "statusCode"=>0,
		        "statusDescription"=>"Error in login!"
	        )
	    );
}

if($tag=="addNew"){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];

	$user = new User();

	$user->username = $username;
	//$username = $user->username; //get
	$user->password = $password;
	$user->firstname = $firstname;
	$user->middlename = $middlename;
	$user->lastname = $lastname;

	$result = $user->addNewUserAccount();

	if($result){ //true || > 0
		echo json_encode(
	      	array(
		        "statusCode"=>1,
		        "statusDescription"=>"Success!"
	        )
	    );

	    return;
	}

	echo json_encode(
	      	array(
		        "statusCode"=>0,
		        "statusDescription"=>"Error!"
	        )
	    );
	// echo $db->addAccount($user);
}

if($tag=="getAllUsers"){
	// $token = $_POST[]
	$userDB = new UserDB();

	$result = $userDB->getAllUsers();

	if(count($result) == 0 ){
		echo json_encode(
	      	array(
		        "statusCode"=>0,
		        "statusDescription"=>"No data found!"
	        )
	    );

	    return;
	}

	if(!$result){
		echo json_encode(
	      	array(
		        "statusCode"=>0,
		        "statusDescription"=>"No data found!"
	        )
	    );

	    return;
	}

	echo json_encode(
	      	array(
		        "statusCode"=>1,
		        "statusDescription"=>"Success!",
		        "data" => $result
	        )
	    );
}



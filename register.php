<?php
	$username = $_GET['username'];
	$password = $_GET['password'];
	
	require "DB.php";
	
	if( count( DB::query( 'SELECT id FROM user WHERE username=?', $username ) ) > 0 ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "user already exists";
		echo json_encode($returnvalue);
	}
	else{
		$password = sha1($password);
		DB::query( 'INSERT INTO user(username,password) VALUES(?,?)', $username, $password );
		$returnvalue['status'] = true;
		$returnvalue['message'] = "user created";
		echo json_encode($returnvalue);
	}
	
?>
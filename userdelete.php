<?php
	$token = $_GET['token'];
	$password = sha1($_GET['password']);
	
	require "DB.php";
	
	
	$user = DB::query( 'SELECT * FROM user WHERE token=? AND password=?', $token, $password );
	
	if( empty( $user ) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "access denied";
		echo json_encode($returnvalue);
	}
	else{
		DB::query('DELETE FROM user WHERE username=?', $user[0]["username"]);
		$returnvalue['status'] = true;
		$returnvalue['message'] = "user deleted";
		echo json_encode($returnvalue);
	}
?>
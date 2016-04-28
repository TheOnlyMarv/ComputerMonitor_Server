<?php
	$username = $_GET['username'];
	$password = sha1($_GET['password']);
	
	require "DB.php";
	
	
	$userid = DB::query( 'SELECT id FROM user WHERE username=? AND password=?', $username, $password );
	
	if( empty( $userid ) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "username or password incorrect";
		echo json_encode($returnvalue);
	}
	else{
		$token = md5(microtime());
		DB::query( 'UPDATE user SET token=? WHERE id=?', $token, $userid[0]["id"] );
		
		$token = DB::query( 'SELECT token FROM user WHERE token=?', $token);
		if( empty( $token ) ){
			$returnvalue['status'] = false;
			$returnvalue['message'] = "something went wrong";
		}
		else{
			$returnvalue['status'] = true;
			$returnvalue['message'] = "login successful";
			$returnvalue['token'] = $token[0]['token'];
		}
		echo json_encode( $returnvalue );
	}
?>
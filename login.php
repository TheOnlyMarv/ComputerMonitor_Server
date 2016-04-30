<?php
	$username = $_GET['username'];
	$password = sha1($_GET['password']);
	
	require "DB.php";
	
	
	$user = DB::query( 'SELECT * FROM user WHERE username=? AND password=?', $username, $password );
	
	if( empty( $user ) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "username or password incorrect";
		echo json_encode($returnvalue);
	}
	else{
		$token = $user[0]["token"];
		if( empty($token) ){
			$token = md5(microtime());
			DB::query( 'UPDATE user SET token=?, last_used=? WHERE id=?', $token, date("Y-m-d H:i:s"),$user[0]["id"] );
			$token = DB::query( 'SELECT token FROM user WHERE token=?', $token)[0]["token"];
		}
		
		if( empty( $token ) ){
			$returnvalue['status'] = false;
			$returnvalue['message'] = "something went wrong";
		}
		else{
			DB::query( 'UPDATE user SET last_used=? WHERE id=?', date("Y-m-d H:i:s"),$user[0]["id"] );
			$returnvalue['status'] = true;
			$returnvalue['message'] = "login successful";
			$returnvalue['token'] = $token;
		}
		echo json_encode( $returnvalue );
	}
?>
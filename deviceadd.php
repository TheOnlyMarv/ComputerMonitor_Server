<?php
	require "DB.php";
	
	$token = $_GET['token'];
	$name = $_GET['name'];
	
	$device = DB::query( 'SELECT d.id, d.name FROM device AS d JOIN user AS u ON d.user_id=u.id WHERE u.token=? AND d.name=?', $token, $name );
	
	if( empty($device) ){
		$userid = DB::query( 'SELECT id FROM user WHERE token=?', $token);
		if( empty($userid) ){
			$returnvalue['status'] = false;
			$returnvalue['message'] = "access denied";
			echo json_encode($returnvalue);
		}
		else{
			$userid = $userid[0]['id'];
			DB::query( 'INSERT INTO device(user_id,name) VALUES(?,?)', $userid, $name );
			$returnvalue['status'] = true;
			$returnvalue['message'] = "device created";
		echo json_encode($returnvalue);
		}
	}
	else{
		$returnvalue['status'] = false;
		$returnvalue['message'] = "device already exists";
		echo json_encode($returnvalue);
	}
?>
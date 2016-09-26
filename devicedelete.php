<?php
	$token = $_GET['token'];
	$deviceId = $_GET['deviceid'];
	
	require "DB.php";
	
	
	$user = DB::query( 'SELECT * FROM user WHERE token=?', $token );
	
	if( empty( $user ) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "invalid token";
		echo json_encode($returnvalue);
	}
	else{
		$user = $user[0];
		$device = DB::query( 'SELECT * FROM device WHERE user_id=? AND id=?', $user["id"], $deviceId);
		if( empty( $device ) ){
			$returnvalue['status'] = false;
			$returnvalue['message'] = "access not found";
			echo json_encode($returnvalue);
		}
		else{
			DB::query('DELETE FROM device WHERE id=?', $device[0]["id"]);
			$returnvalue['status'] = true;
			$returnvalue['message'] = "device deleted";
			echo json_encode($returnvalue);
		}
	}
?>
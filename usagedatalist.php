<?php
	require "DB.php";
	
	$token = $_GET['token'];
	$deviceid = $_GET['deviceid'];
	
	$accessable = DB::query("SELECT d.id FROM device AS d JOIN user AS u ON u.id=d.user_id WHERE u.token=? AND d.id=?", $token, $deviceid);
	
	if( empty($accessable) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "access denied or device does not exists";
		echo json_encode($returnvalue);
	}
	else{
		$usage = DB::query( 'SELECT us.device_id, us.upload, us.download, us.date FROM usage_data AS us JOIN device AS d ON d.id=us.device_id JOIN user AS u ON u.id=d.user_id WHERE d.id=? AND u.token=?', $deviceid, $token );
		echo json_encode($usage);
	}
	
?>
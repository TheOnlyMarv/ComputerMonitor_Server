<?php
	require "DB.php";
	
	$token = $_GET['token'];
	$deviceid = $_GET['deviceid'];
	$upload = $_GET['upload'];
	$download = $_GET['download'];
	$date = $_GET['date'];
	
	$accessable = DB::query("SELECT d.id FROM device AS d JOIN user AS u ON u.id=d.user_id WHERE u.token=? AND d.id=?", $token, $deviceid);
	
	if( empty($accessable) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "access denied or device not exists";
		echo json_encode($returnvalue);
	}
	else{
		$deviceinformation = DB::query("INSERT INTO usage_data(device_id, upload, download, date) VALUES(?, ?, ?, ?)", $deviceid, $upload, $download, $date);
		$returnvalue['status'] = true;
		$returnvalue['message'] = "usage data created";
		echo json_encode($returnvalue);
	}
	
?>
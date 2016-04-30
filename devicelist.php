<?php
	require "DB.php";
	
	$token = $_GET['token'];
	
	$accessable = DB::query("SELECT id FROM user WHERE token=?", $token);
	
	if( empty($accessable) ){
		$returnvalue['status'] = false;
		$returnvalue['message'] = "access denied";
		echo json_encode($returnvalue);
	}
	else{
		$devices = DB::query( 'SELECT d.id, d.name, d.last_used FROM device AS d JOIN user AS u ON d.user_id=u.id WHERE u.token=?', $token );
		
		echo json_encode($devices);
	}
?>
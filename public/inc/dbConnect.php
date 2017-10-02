<?php
	error_reporting(0);
	
	$user = '';
	$password = '';
	$db = 'DealerInspireTest';
	$host = 'localhost';
	$port = 3306;
	
	
	$conn = new mysqli($host, $user, $password, $db);

	if( mysqli_connect_errno() ){
		$resp = array(
			"status" => -1,
			"message" => "Oops! Well, this is embarrassing. We seem to be having some administrator issues at the moment. Not to fear! Our team has been alerted and is fixing the issue!"
		);
				
		echo json_encode($resp);
		die;
	}
	
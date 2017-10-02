<?php
	require("./dbConnect.php");
	require("./class.process.php");
	
	//Check if REQUEST_METHOD is POST
	if( $_SERVER['REQUEST_METHOD'] == "POST" ){
		
		//Instantiate Process Class
		$process = new Process($_POST["full_name"], $_POST["email_address"], $_POST["phone_number"], $_POST["message"], $conn);
		
		//Call Validation method from Process Class
		$validation = $process->validate( );
		
		//Check if Validation method return with errors - if so, send message back to front end
		if( $validation["status"] == 0 ){
			echo json_encode($validation);
			die;
		}
		//Validation was successfull
		
		//Insert Contact info into DB.  If returns true, input was successful
		if( $process->insertRecordIntoDb( ) ){
			
			//Email Guy Smiley
			$process->mailNewContactNotice( );
			
			//Set up Return Array
			$resp = array(
				"status" => 1,
				"message" => "Thanks for contacting us!"
			);
			
			//Send JSON object back to Front End
			echo json_encode($resp);
			die;	
		}else{
			//Insert did not work due to DB Issue - Inform user there are issues.
			return $process->adminWarning( );
			die;
		}
	}else{
		//Someone is trying to use GET - tell them it was a Nice Try.
		$resp = array(
			"status" => 0,
			"message" => "Nice try."
		);
		print_r( $resp );
		echo json_encode($resp);
		die;
	}
	
	
	
	
	
	
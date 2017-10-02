<?php
/**
class Process;

author: Michael Realmuto
**/
class Process{
		
	private $fullName = "";
	private $emailAddress = "";
	private $phoneNumber = "";
	private $message = "";
	private $dbConn;
	
	/**
	name: __construct
	
	@param string $name
	@param string $email
	@param string $phone
	@param string $message
	@param obj	$conn
	**/
	public function __construct($name, $email, $phone, $message, $conn ){
		
		$this->fullName = $name;
		$this->emailAddress = $email;
		$this->phoneNumber = $phone;
		$this->message = $message;
		$this->dbConn = $conn;
		
	}
	
	/**
	name: validate
	
	@return array
	**/
	public function validate( ){
		
		$status = 1;
		$errors = [];
		
		if( empty($this->fullName) ){
			$errors['full_name'] = 'Please Enter your Full Name';
			$status = 0;
		}
		
		if( empty($this->emailAddress) ){
							
			$errors['email_address'] = 'Please Enter your E-Mail';
			$status = 0;
		}else{						
			
			if( ! filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL)){					
				$errors['email_address'] = 'Your E-Mail is not formatted correctly';
				$status = 0;
			}
		}
		
		if( empty($this->message) ){
			$errors["message"] = "We would like to hear from you. Please Leave us a message!";
			$status = 0;
		}
		
		return array("status"=>$status, "error"=>$errors);
	}
	
	/**
	name insertRecordIntoDb
	
	@return boolean
	**/
	public function insertRecordIntoDb( ){
		
		if( $stmt = $this->dbConn->prepare(	"INSERT INTO ContactForm(FullName, EmailAddress, PhoneNumber, Message) VALUES(?, ?, ?, ?)") ){
			
			if( ! empty( $this->phoneNumber ) ){
				$strippedNumber = preg_replace("/\D/", "''", $this->phoneNumber);
			}else{
				$strippedNumber = $this->phoneNumber;
			}
			
			$stmt->bind_param("ssss", $this->fullName, $this->emailAddress, $strippedNumber, $this->message );
							
			if( $stmt->execute() ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	/**
	name: mailNewContactNotice
	
	@return boolean
	**/
	public function mailNewContactNotice( ){
		$patterns = array("/%FULLNAME%/", "/%EMAIL%/", "/%PHONE%/", "/%MESSAGE%/");
		$replacements = array($this->fullName, $this->emailAddress, $this->phoneNumber, $this->message);
		$to = "guy-smiley@example.comm";
		$subject = "New Contact";
		$adminEmailBody = "";
		
		/** Send to Guy Smiley **/
		if(file_exists("./emailTemplates/adminTemplate.php")){
			ob_start( );
			require_once("./emailTemplates/adminTemplate.php");
			$adminEmailBody = ob_get_contents( );
			ob_end_clean( );
			
			$emailBody = preg_replace($patterns, $replacements, $adminEmailBody);
			
			$headers[] = "MIME-Version: 1.0";
			$headers[] = "Content-type: text/html; charset=iso-8859-1";
			
			// Additional headers
			$headers[] = "To: Guy Smiley <guy-smiley@example.com>";
			$headers[] = 'From: Administrators <email@example.com>';
			
			if( mail($to, $subject, $emailBody, implode("\r\n", $headers)) ){
				return true;
			}else{
				return false;
			}
		}else{
			$emailBody = "Guy Smiley: \r\n";
			$emailBody .= $this->fullName . " has made contact with you!\r\n";
			$emailBody .= "Listed Below is their information: \r\n";
			$emailBody .= "\r\n";
			$emailBody .= "- Full Name: " . $this->fullName . "\r\n";
			$emailBody .= "- Email Address: " . $this->emailAddress . "\r\n";
			$emailBody .= "- Phone Number: " . $this->phoneNumber . "\r\n";
			$emailBody .= "- Message: " . $this->message . "\r\n";
			$emailBody .= "\r\n";
			$emailBody .= "\r\n";
			$emailBody .= "Your's Truly,\r\n";
			$emailBody .= "Your Email Monkeys";
			
			
			if( mail($to, $subject, $emailBody) ){
				return true;
				
			}else{
				return false;
			}	
		}
	}
	
	/**
	name: adminWarning
	
	@return json
	**/
	public function adminWarning( ){
		$resp = array(
			"status" => -1,
			"message" => "Oops! Well, this is embarrassing. We seem to be having some administrator issues at the moment. Not to fear! Our team has been alerted and is fixing the issue!"
		);
				
		return json_encode($resp);
	}
}
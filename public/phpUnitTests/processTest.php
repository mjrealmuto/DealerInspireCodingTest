<?php

class ProcessTest extends \PHPUnit_Framework_TestCase
{
    //
    
    public function testValidatePasses( ){
	    
	    $fullName = "michael realmuto";
	    $emailAddress = "michael.realmuto@gmail.com";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );
	    $validation = $process->validate( );
	    $this->assertEquals(1, $validation["status"]);
	}
    
    public function testValidateFailsWithNoName( ){
		$fullName = "";
	    $emailAddress = "michael.realmuto@gmail.com";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );
	    $validation = $process->validate( );
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("Please Enter your Full Name", $validation["error"]["full_name"]);
    }
    
    public function testValidateFailsWithNoEmail( ){
	    $fullName = "michael realmuto";
	    $emailAddress = "";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );	
	    $validation = $process->validate( );
	    
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("Please Enter your E-Mail", $validation["error"]["email_address"]);
    }
    
    public function testValidateFailsWithBadEmailNoDotCom( ){
	    $fullName = "michael realmuto";
	    $emailAddress = "mreal@gmail";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );	
	    $validation = $process->validate( );
	    
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("Your E-Mail is not formatted correctly", $validation["error"]["email_address"]);
    }
    
    public function testValidateFailsWithBadEmailJustString( ){
	    $fullName = "michael realmuto";
	    $emailAddress = "mreal";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );	
	    $validation = $process->validate( );
	    
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("Your E-Mail is not formatted correctly", $validation["error"]["email_address"]);
    }
    
    public function testValidateFailsWithBadEmailJustDotCom( ){
	    $fullName = "michael realmuto";
	    $emailAddress = "mreal.com";
	    $phoneNumber = "123.456.7890";
	    $message = "hello, there!";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );	
	    $validation = $process->validate( );
	    
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("Your E-Mail is not formatted correctly", $validation["error"]["email_address"]);
    }
    
    public function testValidateFailsWithNoMessage( ){
	    $fullName = "michael Realmuto";
	    $emailAddress = "michael.realmuto@gmail.com";
	    $phoneNumber = "123.456.7890";
	    $message = "";
	    
	    $process = new Process($fullName, $emailAddress, $phoneNumber, $message, null );
	    $validation = $process->validate( );
	    $this->assertEquals(0, $validation["status"]);
	    
	    $this->assertEquals("We would like to hear from you. Please Leave us a message!", $validation["error"]["message"]);
    }
    
    public function testIfAdminEmailTemplateExists( ){
	    $this->assertFileExists(__DIR__ . "/../inc/emailTemplates/adminTemplate.php");
    }
    
}
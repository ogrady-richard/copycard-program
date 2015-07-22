<?php
    // Start our PHP session to access session variables
    session_start();
    
    // Open our database connection
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    // Strip any suspicious HTML from the input fields
    $oldPassword = strip_tags($_POST["old-pass"]);
    $newPassword = strip_tags($_POST["new-pass"]);
    $repeatPassword = strip_tags($_POST["repeat-pass"]);
    $employeeID = $_SESSION["EMPLOYEE_ID"];
    
    // Check to see if we have any empty fields
    if( $oldPassword == "" || $newPassword == "" || $repeatPassword == "" ) {
        $stat = "false";
        $msg = "Empty fields detected. Please review input and try again.";
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    
    // Check to see if we our new passwords match
    if( $newPassword != $repeatPassword ) {
        $stat = "false";
        $msg = "Your new passwords do not match. Please review input and try again.";
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    
    // Check to see if our old password matched our new password
    if( $newPassword == $oldPassword ) {
        $stat = "false";
        $msg = "Your new password and old password must be different. Please review input and try again.";
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    
    // Get the users existing password hash for verification
    $dbconn = $dbase->prepare( "SELECT Hash FROM Employees WHERE EmployeeID = :employeeID LIMIT 1" );
    
    $dbconn->execute( array( ":employeeID"=> $employeeID ) );
    
    $currentHash = $dbconn->fetch(PDO::FETCH_NUM);
    
    // Check to see if our passwords match
    if( !password_verify( $oldPassword, $currentHash[0] ) ) {
        $stat = "false";
        $msg = "Invalid current password. Please review input and try again. Field:".$oldPassword." Old Hash:".$currentHash[0];
        
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    
    // If everything is in order, change the users password
    $newPasswordHash = password_hash( $newPassword, PASSWORD_DEFAULT );
    
    $dbconn = $dbase->prepare( "UPDATE Employees SET Hash = :newPassHash, PasswordReset = NOW() WHERE EmployeeID = :employeeID LIMIT 1" );
    
    $dbconn->execute( array( ":newPassHash"=>$newPasswordHash, ":employeeID"=>$employeeID ) );
    
    if( session_destroy() ) {
        $stat = "true";
        $msg = "Password updated successfully.";
        
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    else
    {
        $stat = "false";
        $msg = "Internal Server Error. Password reset, but session is still active. Please logout.";
        
        echo JSON_encode( array( "stat"=>$stat,"msg"=>$msg ));
        exit();
    }
    
    
?>
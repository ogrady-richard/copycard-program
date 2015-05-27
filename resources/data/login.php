<?php
// Start the PHP Session Object
session_start();

// Initialize variables
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$user = $_POST['username'];
$pass = $_POST['password'];

// Check to see if our user variables are set appropriately
if( isset($user) && isset($pass) ) {
        // Prepare our database query
        $dbconn = $dbase->prepare('SELECT Hash FROM Employees WHERE Username=:username LIMIT 1;');

        // Bind our username parameter to the query and execute it
        $dbconn->bindParam(':username', $user);
        $dbconn->execute();

        // TEST Display results
        $result = $dbconn->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify( $pass, $result['Hash'] )) {
            // Issue a session token to this user. 
        }
        else {
            echo 'invalid';
        }
}
?>

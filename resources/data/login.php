<?php
// Start the PHP Session Object
session_start();

// Initialize variables
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$user = $_POST['username'];
$pass = $_POST['password'];

// Check to see if our user variables are set appropriately
if( isset($user) && isset($pass) ) {
        // Prepare our database query
        $dbconn = $dbase->prepare('SELECT * FROM Employees WHERE Username=:username AND Active = 1 LIMIT 1;');

        // Bind our username parameter to the query and execute it
        $dbconn->bindParam(':username', $user);
        $dbconn->execute();

        // Get the results into a dictionary for easier reading
        $result = $dbconn->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify( $pass, $result['Hash'] )) {
            // Issue a session token to this user. 
            $_SESSION['NAME'] = $result['Name'];
            $_SESSION['STYLE'] = $result['DefaultStyle'];
            $_SESSION['EMPLOYEE_ID'] = $result['EmployeeID'];
            
            $dbconn = $dbase->prepare('SELECT PermissionID FROM EmployeePermissions WHERE EmployeeID=:eid LIMIT 1;');
            
            $dbconn->bindParam(':eid', $_SESSION['EMPLOYEE_ID']);
            $dbconn->execute();
            
            $result = $dbconn->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['PERMISSION_LEVEL'] = $result['PermissionID'];
            
        }
        else {
            echo 'invalid';
        }
}
?>

<?php
if( $_SESSION['PERMISSION_LEVEL'] != "4") {
    // Initialize variables
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $username = $_POST['username'];
    
    $dbconn = $dbase->prepare('SELECT * FROM Employees WHERE Username = :employeeUsername LIMIT 1;');
    
    $dbconn->execute( array( ':employeeUsername' => $username ) );
    
    $result = $dbconn->fetch(PDO::FETCH_NUM);
    
    if( isset( $result[0] ))
        echo("success");
    else
        echo("failure");
}

?>
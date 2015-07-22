<?php
    session_start();

    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $employeeID = $_SESSION['EMPLOYEE_ID'];
    
    $dbconn = $dbase->prepare("SELECT NOW() > DATE_ADD(PasswordReset, INTERVAL 1 YEAR) FROM Employees WHERE EmployeeID = :employeeID LIMIT 1");
    
    $dbconn->execute( array( ":employeeID"=>$employeeID ));
    
    $isOver = $dbconn->fetch(PDO::FETCH_NUM);
    
    if( $isOver[0] == 1 )
        echo json_encode(array("msg"=>"true", "isOver"=>$isOver[0]));
    else
        echo json_encode(array("msg"=>"false", "isOver"=>$isOver[0]));
?>
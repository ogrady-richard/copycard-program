<?php
    session_start();
    
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $employeeID = $_SESSION["EMPLOYEE_ID"];
    
    $dbconn = $dbase->prepare("SELECT DATE_FORMAT(PasswordReset,'%b %d, %Y') FROM Employees WHERE EmployeeID = :employeeID LIMIT 1");
    
    $dbconn->execute( array( ":employeeID"=>$employeeID ));
    
    $lastResetDate = $dbconn->fetch(PDO::FETCH_NUM);
    
    $dbconn = $dbase->prepare("SELECT NOW() > DATE_ADD(PasswordReset, INTERVAL 1 YEAR) FROM Employees WHERE EmployeeID = :employeeID LIMIT 1");
    
    $dbconn->execute( array( ":employeeID"=>$employeeID ));
    
    $isOver = $dbconn->fetch(PDO::FETCH_NUM);
    
    $return=array("lastDate"=>$lastResetDate, "overYear"=>$isOver);
    
    echo json_encode($return);
?>
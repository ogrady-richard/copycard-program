<?php
session_start();

if( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] == "4" )  {
    echo json_encode("Error. Please refresh your session and try again.");
    header('HTTP/1.0 401 Unauthorized');
    exit();
}

    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $dbconn = $dbase->prepare('SELECT BlackWhiteCopies, ColorCopies FROM Customers WHERE CustomerID=:customerID');
    
    $dbconn->execute( array( ':customerID' => $_POST['customerID'] ) );
    
    $copyCount = $dbconn->fetch(PDO::FETCH_NUM);
    
    $historyString = '';
    
    if( $_POST['bwCopiesToAdd'] > 0 || $_POST['colorCopiesToAdd'] > 0 ) {
            if( $_POST['bwCopiesToAdd'] > 0 ) {
                $copyCount[0] += $_POST['bwCopiesToAdd'];
                $historyString .= "Added ".$_POST['bwCopiesToAdd']." B/W. ";
            }
            if( $_POST['colorCopiesToAdd'] > 0 ) {
                $copyCount[1] += $_POST['colorCopiesToAdd'];
                $historyString .= "Added ".$_POST['colorCopiesToAdd']." Color. ";
            }
            $historyString .= "Receipt ID: ".$_POST['receiptID'].". Store Location: ".$_POST['storeLocation'];
            
            $dbconn = $dbase->prepare('UPDATE Customers SET BlackWhiteCopies=:bwAdd WHERE CustomerID=:customerID');
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':bwAdd' => $copyCount[0] ) );
            
            $dbconn = $dbase->prepare('UPDATE Customers SET ColorCopies=:colorAdd WHERE CustomerID=:customerID');
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':colorAdd' => $copyCount[1] ) );
            
            $dbconn = $dbase->prepare('INSERT INTO History(EmployeeID, CustomerID, Action) VALUES( :employeeID, :customerID, :action)' );
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':employeeID' => $_SESSION['EMPLOYEE_ID'], ':action' => $historyString ) );
            
            $historyString = '';
    }
    
    if( $_POST['bwCopiesToUse'] > 0 || $_POST['colorCopiesToUse'] > 0 ) {
            if( $_POST['bwCopiesToUse'] > 0 ) {
                $copyCount[0] -= $_POST['bwCopiesToUse'];
                $historyString .= "Used ".$_POST['bwCopiesToUse']." B/W. ";
            }
            if( $_POST['colorCopiesToUse'] > 0 ) {
                $copyCount[1] -= $_POST['colorCopiesToUse'];
                $historyString .= "Used ".$_POST['colorCopiesToUse']." Color. ";
            }
            $historyString .= "Job Description: ".$_POST['jobDescription'].". Store Location: ".$_POST['storeLocation'];
            
            $dbconn = $dbase->prepare('UPDATE Customers SET BlackWhiteCopies=:bwSubtract WHERE CustomerID=:customerID');
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':bwSubtract' => $copyCount[0] ) );
            
            $dbconn = $dbase->prepare('UPDATE Customers SET ColorCopies=:colorSubtract WHERE CustomerID=:customerID');
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':colorSubtract' => $copyCount[1] ) );
            
            $dbconn = $dbase->prepare('INSERT INTO History(EmployeeID, CustomerID, Action) VALUES( :employeeID, :customerID, :action)' );
            
            $dbconn->execute( array( ':customerID' => $_POST['customerID'], ':employeeID' => $_SESSION['EMPLOYEE_ID'], ':action' => $historyString ) );
            
    }
    
    echo json_encode("Success.");
?>
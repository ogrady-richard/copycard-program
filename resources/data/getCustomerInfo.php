<?php 
session_start();
if( $_SESSION['PERMISSION_LEVEL'] != "4") {
    // Initialize variables
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $customerID = $_POST['cid'];
    
    $dbconn = $dbase->prepare('SELECT * FROM Customers WHERE CustomerID = :custid LIMIT 1;');
    
    $dbconn->execute( array( ':custid' => $customerID ) );
    
    $result = $dbconn->fetch(PDO::FETCH_NUM);
    
    $dbase = null;
    
    $result = json_encode($result);
    
    echo $result;
}

else {
    $response_array['status'] = 'error'; 
}
?>
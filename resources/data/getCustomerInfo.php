<?php 
session_start();
if( $_SESSION['PERMISSION_LEVEL'] != "4") {
    // Initialize variables
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $customerID = $_POST['cid'];
    
    $dbconn = $dbase->prepare('SELECT * FROM Customers JOIN History ON Customers.CustomerID = History.CustomerID WHERE Customers.CustomerID = :custid ORDER BY ts;');
    
    $dbconn->execute( array( ':custid' => $customerID ) );
    
    $result = $dbconn->fetchAll(PDO::FETCH_BOTH);
    
    $created = $result[0]['ts'];
    
    $modified = end($result)['ts'];
    
    $dbase = null;
    
    $returnArray = array();
    
    $returnArray['custData'] = $result[0];
    $returnArray['created'] = $created;
    $returnArray['modified'] = $modified;
    
    $result = json_encode($returnArray);
    
    echo $result;
}

else {
    $response_array['status'] = 'error'; 
}
?>
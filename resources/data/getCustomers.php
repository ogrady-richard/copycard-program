<?php
session_start();

// Initialize variables
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Prepare our database query
$dbconn = $dbase->prepare('SELECT CustomerID, CONCAT(FirstName," ",LastName),Phone,Email,Business,BlackWhiteCopies,ColorCopies FROM Customers');

// Bind our username parameter to the query and execute it
$dbconn->execute();

// TEST Display results
$result = $dbconn->fetchAll(PDO::FETCH_NUM);

$result = json_encode($result);

$dbase = null;

echo $result;


?>

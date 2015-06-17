<?php
session_start();

// Initialize variables
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Prepare our database query
$dbconn = $dbase->prepare('SELECT CustomerID, CONCAT(FirstName," ",LastName) AS Name,Phone,Email,Business,BlackWhiteCopies,ColorCopies FROM Customers ORDER BY Name');

// Execute our new query
$dbconn->execute();

$result = $dbconn->fetchAll(PDO::FETCH_NUM);

$result = json_encode($result);

// Clear the database object
$dbase = null;

echo $result;
?>

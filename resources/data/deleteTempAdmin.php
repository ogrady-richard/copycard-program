<?php
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$dbconn = $dbase->prepare("SELECT COUNT(*) FROM Employees JOIN EmployeePermissions ON Employees.EmployeeID = EmployeePermissions.EmployeeID WHERE EmployeePermissions.PermissionID = 1");

$dbconn->execute();

$employeeCount = $dbconn->fetch(PDO::FETCH_NUM);

$dbconn = $dbase->prepare("SELECT COUNT(*) FROM Employees WHERE EmployeeID = -1 AND Active = 1 LIMIT 1");

$dbconn->execute();

$hasAdmin = $dbconn->fetch(PDO::FETCH_NUM);

if( $employeeCount[0] > 1 && $hasAdmin[0] ) {
    $dbconn = $dbase->prepare("UPDATE Employees SET Active=0, Hash='' WHERE EmployeeID = -1");
    $dbconn->execute();
}
?>

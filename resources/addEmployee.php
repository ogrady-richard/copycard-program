<?php 
session_start();
if( !isset($_SESSION['NAME'])){
    header('HTTP/1.0 401 Unauthorized');
    echo "<h1>Unauthorized</h1>";
    echo "<p>You do not have sufficient permissions. Please <a href='index.html'>login</a> and try to access this page again.</p>";
    exit();
}
?>


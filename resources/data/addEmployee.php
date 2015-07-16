<?php
// Open the session socket to begin testing session variables 
session_start();

if( !isset($_SESSION['NAME']) ){
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
else {
    include_once 'placeholder.php';
}
?>


<?php
// Open the session socket to begin testing session variables 
session_start();

if( $_SESSION['PERMISSION_LEVEL'] == "4" ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
else {
    include_once 'data/getHistory.php';
}
?>
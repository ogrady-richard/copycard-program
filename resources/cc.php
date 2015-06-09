<?php 
// Open the session socket to begin testing session variables 
session_start();
// Function declarations
function isAuth() {
    return isset($_SESSION['NAME']);
}

if( ! isAuth() ){
    header('HTTP/1.0 401 Unauthorized');
    include_once '404.php';
    exit();
} else {
    include_once 'copyCardTemplate.php';
}
?>

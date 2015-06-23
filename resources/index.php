<?php
session_start();

if ( isset( $_SESSION['PERMISSION_LEVEL'] ) && $_SESSION['PERMISSION_LEVEL'] < 3 ) {
   header( 'Location: cc.php' ) ;
   exit;
}
?>

<!doctype html>
<html lang="us">
<head>
    <title>ZNet - Copycard Program</title>
    <meta charset="utf-8">
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type ="text/javascript" src="./js/login.js"></script>
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/default-theme/style.css">
</head>
<body>
    <div id="container">
    <h1 id="auth" style="padding-top: .5em; font-size: 4em; text-align: center; color:white;text-shadow:3px 3px black;">Waiting for Authentication...</h1>
    </div>
    <div id="dialog" title="You need to login">
    <p id="validateTips" style="font-size: 0.8em; padding: 5px;">Please enter your ZhongNet Login Credentials</p>
	<form id="login-form" method="POST">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username"></input><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password"></input>
    <p>Can't login? Get help <a href="http://45.55.248.93/osTicket/osTicket-1.8/">here</a>.</p>
    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
    </div>
</body>
</html>

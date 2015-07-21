<?php
session_start();
if ( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] > 3 ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
?>

<html>
<head>
    <title>Reset your Password</title>
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="js/passwordReset.js"></script>
</head>
<body>
    <div class="content control">
        <h1>Reset Password</h1>
        <button class="user-btn" onclick="location.href='cc.php'">Return to Copy Card</button>
        <hr>
        <h3>Logged in as <?php echo $_SESSION['NAME']; ?></h3>
        <div id="last-reset" style='width:400px; height:120px;'>Loading last reset date...</div>
        <form id="password-fields">
            <p><label for="old-pass">Old password: </label></p><input type="password" id="old-pass" name="old-pass">
            <p><label for="new-pass">New password: </label></p><input type="password" id="new-pass" name="new-pass">
            <p><label for="repeat-pass">New password (Repeat): </label></p><input type="password" id="repeat-pass" name="repeat-pass"><br><br>
            <input type="submit" value="Submit Password" method="POST" id="submit-password" class="user-btn"><br><br>
        </form>
        <div id="submit-state" style="width:500px" >Please fill out the fields above to reset your password.</div>
    </div>
</body>
</html>
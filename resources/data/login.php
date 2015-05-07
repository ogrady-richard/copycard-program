<?php
/*
// Check an employees username and password, and if there is a match, issue a session id for that user.
$db = new PDO( 'mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) );
$a = $_POST["username"];
$b = $_POST["password"];

try {
    //connect as appropriate as above
    $blob = $db->prepare('SELECT Hash FROM Employees WHERE Username=:username LIMIT 1;');
} catch(PDOException $ex) {
    print '<p>A Database issue occurred!</p>'; //user friendly message
}

$blob->bindParam(":username", $a);
$blob->execute();

if (!$phash = $blob->rowCount()) {
    print('<p> Username not found. Please try again.</p>');
	$pass_hash = array('NULL');
}
else {
    $pass_hash = $blob->fetch(PDO::FETCH_NUM);
}

if (password_verify( $b , $pass_hash[0] )) {
    print '<p>Login successful.</p><br>';
}
else {
	print '<p>Login unsuccessful. Check login details.</p><br>';
}

print "<b>User: ".htmlspecialchars($a).'<br>Password hash: '.htmlspecialchars($pass_hash[0])."</b>";
*/
// -- //

// Initialize variables
$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$user = $_POST['username'];
$pass = $_POST['password'];
$return = NULL;
// Check to see if our user variables are set appropriately
if( isset($user) && isset($pass) ) {
        // Prepare our database query
        $dbconn = $dbase->prepare('SELECT Hash FROM Employees WHERE Username=:username LIMIT 1;');
        
        // Bind our username parameter to the query and execute it
        $dbconn->bindParam(':username', $user);
        $dbconn->execute();
        
}
// If not, inform the calling page that we were not given valid credentials
else {
    $return = "invalid";
    echo $return;
}

echo $return;

// -- //
?>
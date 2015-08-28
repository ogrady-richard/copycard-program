<?php
    $permLevel = $_POST['permissionID'];
    
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $dbconn = $dbase->prepare('SELECT LongDescription FROM Permissions WHERE Description = :permissionLevel LIMIT 1;');
    
    $dbconn->execute( array( ':permissionLevel' => $permLevel ) );
    
    $longDescription = $dbconn->fetch(PDO::FETCH_NUM);
    
    echo json_encode($longDescription[0]);

?>
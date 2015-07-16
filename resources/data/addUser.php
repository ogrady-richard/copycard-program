<?php
    if( $_SESSION['PERMISSION_LEVEL'] != "4") {
        // Initialize variables
        $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        $username = $_POST['username'];
        
        $dbconn = $dbase->prepare('SELECT * FROM Employees WHERE Username = :employeeUsername LIMIT 1;');
        
        $dbconn->execute( array( ':employeeUsername' => $username ) );
        
        $userExists = $dbconn->fetch(PDO::FETCH_NUM);
        
        if( !isset( $userExists[0] )) { 
            $passHash = password_hash( $_POST['pass'], PASSWORD_DEFAULT );
            
            $dbconn = $dbase->prepare('INSERT INTO Employees(Name, Username, Hash, DefaultStyle) VALUES( :name, :username, :hash, "default-theme");');
            
            $dbconn->execute( array( ':name' => $_POST['name'], ':username' => $_POST['username'], ':hash' => $passHash ) );
            
            $lastID = $dbase->lastInsertId();
            
            $permissionValues = array( 'Administrator' => '1', 'Manager' => '2', 'Associate' => '3', 'Customer' => '4');
            
            $dbconn = $dbase->prepare('INSERT INTO EmployeePermissions VALUES (:employeeID, :permissionID)');
            
            $dbconn->execute( array( ':employeeID' => $lastID, ':permissionID' => $permissionValues[$_POST['permissions']] ) );
            
            echo("success");   
        }
        else
            echo("failure");
    }
?>
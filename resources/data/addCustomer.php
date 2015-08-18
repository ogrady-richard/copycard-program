<?php 
session_start();
if( $_SESSION['PERMISSION_LEVEL'] != "4") {
    // Initialize variables
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $clean = array_map('strip_tags', $_POST);
    
    if( $clean['cust-bw'] != '' && $clean['cust-color'] != '' ) {
    // Prepare our database query to insert the new customer
    $dbconn = $dbase->prepare('INSERT INTO Customers(FirstName, LastName, Business, Phone, TelExtension, Email, BlackWhiteCopies, ColorCopies) 
                               VALUES (?,?,?,?,?,?,?,?)');
    
    $dbconn->execute( array( $clean['cust-f-name'], $clean['cust-l-name'], $clean['cust-business'], 
                      $clean['cust-phone'], $clean['cust-phone-ext'], $clean['cust-email'], $clean['cust-bw'], 
                      $clean['cust-color'] ) );
    
    $dbconn = $dbase->prepare('SELECT LAST_INSERT_ID()');
    
    $dbconn->execute( );
    
    $result = $dbconn->fetch(PDO::FETCH_NUM);
    
    $dbconn = $dbase->prepare('INSERT INTO History(CustomerID, EmployeeID, Action) VALUES (?,?,?)');
    
    if( $clean['cust-f-name'] == '' && $clean['cust-f-name'] == '' ) {
        $dbconn->execute( array( $result[0], $_SESSION['EMPLOYEE_ID'], "Added business {$clean['cust-business']}, with {$clean['cust-bw']} black and white copies, and {$clean['cust-color']} color copies, and no primary user." )  );
    }
    
    else {
        $dbconn->execute( array( $result[0], $_SESSION['EMPLOYEE_ID'], "Added customer {$clean['cust-f-name']} {$clean['cust-l-name']}, with {$clean['cust-bw']} black and white copies, and {$clean['cust-color']} color copies." )  );
    }
    
    $dbase = null;
    }
    else {
        echo "invalid";
    }
}
else {
    echo "invalid";
}
?>

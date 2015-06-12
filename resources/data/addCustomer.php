<?php 
    session_start();
    
    // Initialize variables
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $fname = $_POST['cust-f-name'];
    $lname = $_POST['cust-l-name'];
    $business = $_POST['cust-business'];
    $phone = $_POST['cust-phone'];
    $email = $_POST['cust-email'];
    $bwcopies = $_POST['cust-bw'];
    $colcopies = $_POST['cust-color'];
    
    
    
    // Prepare our database query to insert the new customer
    $dbconn = $dbase->prepare('INSERT INTO Customers(FirstName, LastName, Business, Phone, Email, BlackWhiteCopies, ColorCopies) 
                               VALUES (?,?,?,?,?,?,?)');
    
    $dbconn->execute( array( $fname, $lname, $business, $phone, $email, $bwcopies, $colcopies )  );
    
    $dbconn = $dbase->prepare('SELECT LAST_INSERT_ID()');
    
    $dbconn->execute( );
    
    $result = $dbconn->fetch(PDO::FETCH_NUM);
    
    echo $result;
    
    $dbconn = $dbase->prepare('INSERT INTO History(CustomerID, EmployeeID, Action) VALUES (?,?,?)');
    
    $dbconn->execute( array( $result[0], $_SESSION['EMPLOYEE_ID'], "Added customer {$fname} {$lname}, with {$bwcopies} black and white copies, and {$colcopies} color copies." )  );
    
    $dbase = null;
    
    
?>
<?php
require('../vendors/fpdf.php');

if( isset($_GET['customerID'])) {
    $customerID = $_GET['customerID'];
    
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $dbconn = $dbase->prepare('SELECT * FROM Customers WHERE CustomerID=:customerID');
    
    $dbconn->execute( array( ':customerID' => $customerID ) );
    
    $customerInfo = $dbconn->fetch(PDO::FETCH_NUM);
    
    $dbconn = $dbase->prepare('SELECT DATE_FORMAT(History.ts,"%b-%d-%Y %h:%i %p"), History.Action FROM Customers JOIN History ON Customers.CustomerID=History.CustomerID WHERE Customers.CustomerID=:customerID ORDER BY History.ts DESC');
    
    $dbconn->execute( array( ':customerID' => $customerID ) );
    
    $customerHistory = $dbconn->fetchAll();
}
else {
    echo( "No customer ID supplied." );
    exit();
}

if( empty($customerHistory) ) {
    echo( "No customer with given ID found." );
    exit();
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Write(8,'UPS Store');
$pdf->Ln();
$pdf->SetFont('Arial','B',24);
$pdf->Write(8,'Copy Card Account');
$pdf->Ln();
$pdf->Line();
$pdf->SetFont('Arial','',12);
$pdf->Write(8,'Date Printed: '.date("M-d-Y"));
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',14);
$pdf->Write(8,'Account Information');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->Write(8,'Customer ID: '.$customerID);
$pdf->Ln();
$pdf->Write(8,'Customer Name: '.$customerInfo[2].', '.$customerInfo[1]);
$pdf->Ln();
$pdf->Write(8,'Customer Business: '.$customerInfo[3]);
$pdf->Ln();
if( $customerInfo[4] != '' )
    $pdf->Write(8,'Customer Phone: ('.substr($customerInfo[4], 0, 3).') '.substr($customerInfo[4], 2, 3).' - '.substr($customerInfo[4], 5, 4) );
else
    $pdf->Write(8,'Customer Phone: ');
$pdf->Ln();
$pdf->Write(8,'Customer Email: '.$customerInfo[5]);
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Write(8,'Remaining Black/White Copies: '.$customerInfo[6]);
$pdf->Ln();
$pdf->Write(8,'Remaining Color Copies: '.$customerInfo[7]);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',14);
$pdf->Write(8,'Customer History');
$pdf->SetFont('Arial','',8);
foreach( $customerHistory as $historyObject ) {
    $pdf->Ln();
    $pdf->Write(6,$historyObject[0].' - '.$historyObject[1]);
}
$pdf->Output();
?>
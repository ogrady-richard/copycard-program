<?php
// Open the session socket to begin testing session variables 
session_start();

if( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] > 1 ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.php">
    
    <style type="text/css">
        .container {
            width: 500px;
            clear: both;
        }
        .container input {
            width: 100%;
            clear: both;
        }
    </style>
    
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="js/consolidateCustomers.js"></script>
    
    <title>Consolidate Customer Accounts</title>
</head>
<body>
    <div class="content control">
        <h1>Consolidate Customers</h1>
        <button class="user-btn" onclick="location.href='cc.php'">Return to Copy Card</button>
        <hr>
        <form id="consolidateCustomersForm">
            <label for="firstID"><p>Customer ID #1: </p></label>
            <input type="number" class="custField" name="firstID" id="firstID"><br>
            <div class="container" id="firstIDCustomerData">
                Name: <input id="custName" disabled><br>
                Phone: <input id="custPhone" disabled><br>
                Business: <input id="custBusiness" disabled><br>
                Email: <input id="custEmail" disabled><br>
                BW Copies: <input id="custBW" disabled><br>
                Color Copies: <input id="custColor" disabled><br>
            </div>
            <hr>
            <label for="secondID"><p>Customer ID #2: </p></label>
            <input type="number" class="custField" name="secondID" id="secondID"><br>
            <div class="container" id="secondIDCustomerData">
                Name: <input id="custName" disabled>
                Phone: <input id="custPhone" disabled>
                Business: <input id="custBusiness" disabled>
                Email: <input id="custEmail" disabled>
                BW Copies: <input id="custBW" disabled><br>
                Color Copies: <input id="custColor" disabled><br>
            </div>
            <hr>
            <div class="container">
                New BW Copies: <input id="totalBW" disabled><br>
                New Color Copies: <input id="totalColor" disabled><br>
            </div>
            <input type="submit" id="process" class="user-btn" value="Consolidate these users" >
        </form>
    </div>
</body>
</html>


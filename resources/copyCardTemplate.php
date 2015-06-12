<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>ZNet - Copycard Program</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">

    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="../vendors/jquery.dataTables.min.js"></script>
    <script src="js/copyCard.js"></script>
</head>
<body>
    <div id="header">
        <div id="leftSeperator">
            <span id="user"><h4>Logged in as <?php echo $_SESSION['NAME']; ?></h4></span> &squf;
            <?php
                if($_SESSION['NAME'] == "Richard O'Grady") echo "<span class=\"userControl\"><a href=\"adminControls.php\">Administrator</a></span> &squf;";
            ?>
            <span class="userControl"><a href="#">Change Theme</a></span> &squf;
            <span class="userControl"><a href="#">Change Password</a></span> &squf;
            <span class="userControl"><a href="logout.php">Log out</a></span> &squf;
        </div>
        <div id="middleSeperator">
            <button id="add-new-customer">Add new Customer</button>
        </div>
    </div>
    <div id="tableContainer">
        <table id="customer-table" class="display noselect"><thead><th>ID</th><th>Customer</th><th>Phone</th><th>Email</th><th>Business</th><th>Black and White Copies</th><th>Color Copies</th></thead><tbody></tbody></table>
        <div id='display-BW'><h3>B/W</h3>---</div>
        <div id='display-color'><h3>Color</h3>---</div>
    </div>
    <div id="dialog" title="Foo">
        <p id="foo"></p>
    </div>
    
    <div id="add-modal" title="Add a New Customer">
    <p> Please fill out the customer information below.</p>
	<form id="customer-information-form" method="POST"> <!-- Method is not important at the moment -->
    <label for="cust-f-name">Customer First Name</label><br>
    <input type="text" name="cust-f-name" id="cust-f-name"></input><br>
    <label for="cust-l-name">Customer Last Name</label><br>
    <input type="text" name="cust-l-name" id="cust-l-name"></input><br>    
    <label for="cust-phone">Customer Phone Number</label><br>
    <input type="tel" name="cust-phone" id="cust-phone"></input><br>
    <label for="cust-email">Customer Email</label><br>
    <input type="email" name="cust-email" id="cust-email"></input><br>
    <label for="cust-business">Customer Business</label><br>
    <input type="text" name="cust-business" id="cust-business"></input><br>
    <label for="cust-bw">Customer Black and White Copies</label><br>
    <input type="number" name="cust-bw" id="cust-bw"></input><br>
    <label for="cust-color">Customer Color Copies</label><br>
    <input type="number" name="cust-color" id="cust-color"></input><br>
    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
    </div>
</body>
</html>

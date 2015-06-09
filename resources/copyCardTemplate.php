<!doctype html>
<html lang="us">
<head>
    <title>ZNet - Copycard Program</title>
    <meta charset="utf-8">
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="../vendors/jquery.dataTables.min.js"></script>
    <script src="js/copyCard.js"></script>
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/<?php echo $_SESSION['STYLE']; ?>/style.css">
    <script>
    $(document).ready(function(){
    customerTable = $('#customer-table').DataTable({"columnDefs":[{"targets":[0,5,6],"visible":false,"searchable":false}]});
    
        $( "#dialog" ).dialog({
        autoOpen: false,
        buttons: [
            {
                text: "Ok",
                click: function() {
                    $( "#dialog" ).dialog( "close" );
                }
            }]
        }
    );
    
    $('#customer-table tbody').on('dblclick', 'tr', function () {
        $( "#dialog" ).dialog( "open" );
        $( "#foo").html( customerTable.row( this ).data() + "  " + "<?php echo $_SESSION['NAME']; ?>" );
    } );
    
    $('#customer-table tbody').on('mouseenter', 'tr', function () {
        if( customerTable.row( this ).data() != undefined ) {
            $('#display').html( '<h3 style="color:white">Black and White Copies Remaining: '+customerTable.row( this ).data()[5]+'</h3>' );
        }
    } );
    
    });</script>
    
</head>
<body>
    <div id="header">
        <div id="leftSeperator">
            <span id="user"><h4>Logged in as <?php echo $_SESSION['NAME']; ?></h4></span>
            <span id="userControl"><a href="logout.php">Log out</a></span>
        </div>
        <div id="middleSeperator">
            <span id="new-customer"><button id="add-new-customer">Add new Customer</button></span><br>
        </div>
    </div>
    <div id="tableContainer">
        <table id="customer-table" class="display noselect"><thead><th>ID</th><th>Customer</th><th>Phone</th><th>Email</th><th>Business</th><th>Black and White Copies</th><th>Color Copies</th></thead><tbody></tbody></table>
        <div id='display'></div>
    </div>
    <div id="dialog" title="Foo">
        <p id="foo"></p>
    </div>
    
    <div id="add-modal" title="Add a New Customer">
	<form id="customer-information-form" method="POST"> <!-- Method is not important at the moment -->
    <label for="cust-id">Customer ID</label><br>
    <input type="number" name="cust-id" id="cust-id"></input><br>
    <label for="cust-name">Customer Name</label><br>
    <input type="text" name="cust-name" id="cust-name"></input><br>
    <label for="cust-ph">Customer Phone Number</label><br>
    <input type="text" name="cust-ph" id="cust-ph"></input><br>
    <label for="cust-email">Customer Email</label><br>
    <input type="text" name="cust-email" id="cust-email"></input><br>
    <label for="cust-business">Customer Business</label><br>
    <input type="text" name="cust-business" id="cust-business"></input><br>
    <label for="cust-bw">Customer Black and White Copies</label><br>
    <input type="text" name="cust-bw" id="cust-bw"></input><br>
    <label for="cust-color">Customer Color Copies</label><br>
    <input type="text" name="cust-color" id="cust-color"></input><br>
    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
    </div>
    <div id='display'></div>
</body>
</html>

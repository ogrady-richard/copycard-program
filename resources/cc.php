<?php session_start() ?>

<!doctype html>
<html lang="us">
<head>
    <title>ZNet - Copycard Program</title>
    <meta charset="utf-8">
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="../vendors/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/<?php echo $_SESSION['STYLE']; ?>/style.css">
    <script>
    $(document).ready(function(){
    myTable = $('#hi').DataTable();
    
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
    
    $('#hi tbody').on('dblclick', 'tr', function () {
        $( "foo" ).html("Bar");
        $( "#dialog" ).dialog( "open" );
    } );
    });</script>
    
</head>
<body>
    <div id="header">
        <div id="leftSeperator">
            <span id="user"><h4>Logged in as <?php echo $_SESSION['NAME']; ?></h4></span>
            <span id="userControl"><a href="../resources/">Log out</a></span>
        </div>
        <div id="middleSeperator">
            <span id="new user"><button>Add new Customer</button></span>
        </div>
    </div>
    <div id="tableContainer">
        <table id="hi" class="display noselect"><thead><th>Customer</th><th>Phone</th><th>Email</th><th>Business</th></thead><tbody></tbody></table>
    </div>
    <div id="dialog" title="Foo">
        <p id="foo"></p>
    </div>
</body>
</html>
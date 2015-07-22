<?php
if( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] > 3 ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once './401.php';
    exit();
}

$dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$dbconn = $dbase->prepare('SELECT TransactionID, CustomerName, User, DATE_FORMAT(Date,"%b-%d-%Y %h:%i %p"), Action FROM AllHistory;');

$dbconn->execute( );

$result = $dbconn->fetchAll(PDO::FETCH_BOTH);
echo '<head>
      <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="css/style.php">
      <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
      <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
      <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
      <script src="../vendors/jquery.dataTables.min.js"></script>
      <script>$( function() {
        
            $(\'#x-table tfoot th\').each( function () {
            var title = $(\'#x-table thead th\').eq( $(this).index() ).text();
            if( title != "Timestamp" ) {
                $(this).html( \'<input type="text" placeholder="Search \'+title+\'..." />\' );
            }
            else {
                $(this).html( \'<input type="text" id="chooseDate" placeholder="Search \'+title+\'..." />\' );
            }
            } );
              
                historyTable = $("#x-table").DataTable( {"columnDefs":[{"type":"date","targets":2 },{"orderable":false,"targets":[0,1,3]}],"lengthChange": false, "pageLength":10, order: [[2, "desc"]]} );                
                
            historyTable.columns().every( function () {
            var that = this;

            $( \'input\', this.footer() ).on( \'keyup change\', function () {
                that
                    .search( this.value )
                    .draw();
            } );
            } );
            $("#chooseDate").datepicker();
            $("#chooseDate").datepicker( "option", "dateFormat", "M-dd-yy" );
        });

      </script></head>';

echo 
    "<body><div class=\"content control\"><h1>Transaction History</h1>
    <button class=\"user-btn\" onclick=\"location.href='cc.php'\">Return to Copy Card</button>
    <button class=\"user-btn\" onclick=\"location.href='adminControls.php'\">Return to Admin Menu</button>
    <div style='width:80%'><table id='x-table' width=80%><thead><th>Customer</th><th>User</th><th>Timestamp</th><th>Action</th></thead><tfoot><tr><th>Customer</th><th>User</th><th>Timestamp</th><th>Action</th></tr></tfoot><tbody></div>";
foreach( $result as $entry ) {
    echo "<tr>";
        echo "<td>{$entry[1]}</td><td>{$entry[2]}</td><td>{$entry[3]}</td><td>{$entry[4]}</td>";
    echo "</tr>";
}
echo "</tbody></table></div></body>";

?>
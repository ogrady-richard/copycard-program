<?php
if( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] != "1" ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once './401.php';
    exit();
}
else
{
    $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'root', 'Aboriginal$16', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $dbconn = $dbase->prepare('SELECT * FROM History;');

    $dbconn->execute( );

    $result = $dbconn->fetchAll(PDO::FETCH_BOTH);
    echo '<head>
          <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">
          <link rel="stylesheet" type="text/css" href="css/style.php">
          <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
          <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
          <script src="../vendors/jquery.dataTables.min.js"></script>
          <script>$( function() {$("#x-table").DataTable();} )</script></head>';

    echo "<body><h1>Transaction History</h1><h2>Return to the <a href='cc.php'>Copy Card Program</a></h2><div style='width:80%'><table id='x-table' width=80%><thead><th>Customer ID</th><th>Employee ID</th><th>Timestamp</th><th>Action</th></thead><tbody>";
    foreach( $result as $entry ) {
        echo "<tr>";
            echo "<td>{$entry[1]}</td><td>{$entry[2]}</td><td>{$entry[3]}</td><td>{$entry[4]}</td>";
        echo "</tr>";
    }
    echo "</tbody></table></div></body>";
}
?>
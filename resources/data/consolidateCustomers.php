<?php
    function returnBad( $msg ) {
        $return = array( "status" => "Bad", "msg" => $msg );
        $return = json_encode( $return );
        echo $return;
        exit();
    }
    
    function returnGood( $msg ) {
        $return = array( "status" => "Good", "msg" => $msg );
        $return = json_encode( $return );
        echo $return;
        exit();
    }
    
    // Main
    if( !isset($_POST["firstID"]) || !isset($_POST["secondID"]) ) {
        returnBad( "Missing one or more IDs from calling page." );
    }

    $consolidateID[0] = $_POST["firstID"];
    $consolidateID[1] = $_POST["secondID"];

    if( $consolidateID[0] == $consolidateID[1] ) {
        returnBad( "Customer IDs provided to server are identical." );
    }
    
    // --Check that users actually exist--

    returnGood( "Customers #10599 and #10675 merged successfully. New customer ID: #10775" );
?>
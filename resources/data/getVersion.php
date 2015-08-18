<?php 
    $file = "../../VERSION.md";
    
    $f = fopen($file, 'r');
    $version = trim(fgets($f));
    $summary = trim(fgets($f));
    fclose($f);

    $result = json_encode(array( 'v' => $version, 's' => $summary ));
    
    echo $result;
    
?>
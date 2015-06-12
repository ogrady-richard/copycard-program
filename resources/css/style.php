<?php
session_start();
header("Content-type: text/css; charset: UTF-8");
$userStyle = $_SESSION['STYLE'];
$bodyColor = array( 'default-theme' => '-color: #C63D0F;', 'bird-theme' => ': linear-gradient(#1e130c,#9a8478);' );
$bgImage = array( 'default-theme' => 'https://wiki.documentfoundation.org/images/thumb/8/88/LibreOffice_MotifScatter_RGB.png/300px-LibreOffice_MotifScatter_RGB.png',
                  'bird-theme' => 'https://cdn0.iconfinder.com/data/icons/black-icon-social-media/128/099374-twitter-bird3.png');
$bgColor = array( 'default-theme' => '#FDF3E7', 'bird-theme' => '#87CEEB' );
$textColor = array( 'default-theme' => '#3B3738', 'bird-theme' => '#000000' );
?>

html {
    height: 100%
    overflow:hidden;
}

body {
    height: 100%;
    width: 85%;
    border: 0px;
    background<?php echo "{$bodyColor[$userStyle]}";?>
    background-repeat: no-repeat;
    background-attachment: fixed;
    overflow: hidden;
}

#tableContainer {
    <?php
        echo "background-color: {$bgColor[$userStyle]};";
        echo "background-image: url( {$bgImage[$userStyle]} );";
        echo "color: {$textColor[$userStyle]};";
    ?>
    border: 3px solid black;
    opacity: 0.7;
    padding: 8px;
    margin: auto;
    margin-top: 10px;
    margin-bottom: 10px;
    width: 90%;
    height: 550px;
}

tr {
    color: #000000;
}

#display-BW {
    width: 60px;
    float: left;
    border: 1px solid black;
    text-align:center;
    background-color:#ffffff;
}

#display-color {
    width: 60px;
    margin-left: 90px;
    border: 1px solid black;
    text-align:center;
    background-color:#ffffff;
}

#tableContainer:hover {
    transition: opacity 1s;
    opacity: 1;
}

#header {
    position: relative;
    width: 80%;
    height: 80px;
    margin: auto;
    padding: 10px;
    border: 5px solid black;
    border-radius: 5px;
    <?php
        echo "background-color: {$bgColor[$userStyle]};";
    ?>
    opacity: 0.6;
}

#header:hover {
    transition: opacity 1s;
    opacity: 1;
}

#leftSeperator {
    left: 50px;
    position: absolute;
    height: 75px;
}

#middleSeperator {
    left: 450px;
    position: absolute;
    height: 75px;
}

#rightSeperator {
    left: 450px;
    position: absolute;
    height: 75px;
}

.noselect {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
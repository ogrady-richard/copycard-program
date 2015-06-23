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

.user-btn {
  background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #175c87);
  background-image: -moz-linear-gradient(top, #3498db, #175c87);
  background-image: -ms-linear-gradient(top, #3498db, #175c87);
  background-image: -o-linear-gradient(top, #3498db, #175c87);
  background-image: linear-gradient(to bottom, #3498db, #175c87);
  -webkit-border-radius: 10;
  -moz-border-radius: 10;
  border-radius: 10px;
  font-family: Arial;
  color: #ffffff;
  font-size: 14px;
  padding: 4px 20px 5px 20px;
  text-decoration: none;
}

.user-btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #286f9e);
  background-image: -moz-linear-gradient(top, #3cb0fd, #286f9e);
  background-image: -ms-linear-gradient(top, #3cb0fd, #286f9e);
  background-image: -o-linear-gradient(top, #3cb0fd, #286f9e);
  background-image: linear-gradient(to bottom, #3cb0fd, #286f9e);
  text-decoration: none;
  outline: none;
}

#tableContainer {
    <?php
        echo "background-image: url( {$bgImage[$userStyle]} );";
    ?>
    border: 3px solid black;
    border-radius: 5px;
    padding: 8px;
    margin: auto;
    margin-top: 10px;
    margin-bottom: 10px;
    width: 90%;
    height: 550px;
}

#header {
    position: relative;
    width: 80%;
    height: 100px;
    margin: auto;
    padding: 10px;
    border: 4px solid black;
    border-radius: 5px;
}

.content {
    <?php
        echo "background-color: {$bgColor[$userStyle]};";
        echo "color: {$textColor[$userStyle]};";
    ?>
    opacity: 0.8;
}

.content:hover {
    transition: opacity 1s;
    opacity: 1;
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

#leftSeperator {
    left: 50px;
    position: absolute;
    height: 75px;
}

#rightSeperator {
    left: 525px;
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
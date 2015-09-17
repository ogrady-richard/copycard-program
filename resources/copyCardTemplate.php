<?php
if ( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] > 3 ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
?>

<!DOCTYPE html>
<html class="no-overflow" xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>ZNet - Copy Card Program</title>
    <meta charset="utf-8">
    
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery.dataTables.min.css">
    
    <link rel="icon" type="image/ico" href="/favicon.ico">

    <script type="text/javascript">
         if (typeof console === "undefined") var console = {log: function(logMsg) {}};
    </script>
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script src="../vendors/jquery.dataTables.min.js"></script>
    <script src="js/copyCard.js"></script>
</head>
<body>
    <div id="header" class="content">
        <div id="leftSeperator">
            <h4>Logged in as <?php echo $_SESSION['NAME']; ?></h4>
            <?php
                if($_SESSION['PERMISSION_LEVEL'] == "1") echo "<button class='user-btn' onclick='location.href=\"adminControls.php\"'>Admin Menu</button>";
                if($_SESSION['PERMISSION_LEVEL'] == "2") echo "<button class='user-btn' onclick='location.href=\"adminControls.php\"'>Manager Menu</button>";
                if($_SESSION['PERMISSION_LEVEL'] == "3") echo "<button class='user-btn' onclick='location.href=\"adminControls.php\"'>User Menu</button>";?>
            <button class="user-btn" onclick="location.href='logout.php'">Logout</button>
            <button class="user-btn" onclick="location.href='http://45.55.248.93/osTicket/osTicket-1.8/'">Helpdesk/Support</button>

            <button id="add-new-customer" class="user-btn">Add new Customer</button>
        </div>
    </div>
    <div id="tableContainer" class="content">
        <table id="customer-table" class="display noselect cell-border"><thead><th>ID</th><th>Customer</th><th>Phone</th><th>Email</th><th>Business</th><th>Black and White Copies</th><th>Color Copies</th></thead><tbody></tbody></table>
        <div id='display-BW' class="bw-input"><h3>B/W</h3>---</div>
        <div id='display-color' class="color-input"><h3>Color</h3>---</div>
    </div>
    
    <div id="add-modal" title="Add a New Customer">
        <p> Please fill out the customer information below.</p>
        <form id="customer-information-form" method="POST">
            <label for="cust-f-name">Customer First Name</label><br>
                <input type="text" name="cust-f-name" id="cust-f-name" maxlength=35></input><br>
            <label for="cust-l-name">Customer Last Name</label><br>
                <input type="text" name="cust-l-name" id="cust-l-name" maxlength=35></input><br>    
            <label for="cust-phone">Customer Phone Number</label><br>
                <input type="tel" name="cust-phone" id="cust-phone" maxlength=10></input><br>
            <label for="cust-phone">Customer Phone Extension</label><br>
                <input type="tel" name="cust-phone-ext" id="cust-phone-ext" maxlength=8></input><br>
            <label for="cust-email">Customer Email</label><br>
                <input type="email" name="cust-email" id="cust-email"></input><br>
            <label for="cust-business">Customer Business</label><br>
                <input type="text" name="cust-business" id="cust-business" maxlength=70></input><br>
            <label for="cust-bw">Customer Black and White Copies</label><br>
                <input type="number" class="bw-input"name="cust-bw" id="cust-bw" value=0 required></input><br>
            <label for="cust-color">Customer Color Copies</label><br>
                <input type="number" class="color-input" name="cust-color" id="cust-color" value=0 required></input><br>
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </form>
    </div>
    
    <div id="cust-dialog" title="Customer Information">
        <center><img id="loading-cust-info" src="images/loading.gif" width=200px height=200px></center>
        <div id="show-cust-info">
            <h1 id="cust-name-disp" ></h1>
            <span id="cust-id-disp" style="color:gray"></span>
            <p id="created-disp" ></p>
            <p id="cust-phone-disp" ></p>
            <p id="cust-email-disp" ></p>
            <p id="cust-business-disp" ></p>
            <p id="cust-bw-disp" ></p>
            <p id="cust-color-disp" ></p>
            <p id="auth-users-disp" ></p>
            <div align="center">
                <button class="user-btn" id="add-use-copies">Add/Use Copies</button>
                <button class="user-btn no-function" id="authorized-user-access">Add/Remove Authorized Users</button><br>
                <button class="user-btn no-function" id="view-customer-history">View Customer History</button> <!-- Send our post data -->
            </div>
        </div>
    </div>
    
    <div id="manipulate-copies" title="Add/Use Copies">
        <div id="copy-tabs">
            <ul>
            <li style="outline:none"><a href="#add-copies">Add</a></li>
            <li style="outline:none"><a href="#use-copies">Use</a></li>
            <li id="process-transaction-tab"><a href="#process-transaction">Process</a></li>
            </ul>
            <form id="manipulate-copies-fields">
            <div id="add-copies">
                <div id="confirm-add">
                    <h1>Is the customer<br>ADDING<br>any copies?</h1>
                    <button class="user-btn" id="adding-copies-button">Yes</button>
                    <button class="user-btn" id="not-adding-copies-button">No</button>
                </div>
                <div id="confirm-add-black-white" class="copies-left">
                    <h2>Is the customer adding any<br>BLACK AND WHITE<br>copies?</h2>
                    <button class="user-btn" id="adding-bw-copies-button">Yes</button>
                    <button class="user-btn" id="not-adding-bw-copies-button">No</button>
                </div>
                <div id="confirm-add-color" class="copies-right">
                    <h2><br>Is the customer adding any<br><span style="color:#fb6630;">COLOR</span><br>copies?</h2>
                    <button class="user-btn" id="adding-color-copies-button">Yes</button>
                    <button class="user-btn" id="not-adding-color-copies-button">No</button>
                </div>
                <br>
                <h2>Enter the Quantity of Copies to Add</h2><br>
                    <div class="copies-left" id="adding-bw-copies">
                        <h3>B/W Copies</h3>
                        <p><input id="bw-copies-added" class="bw-input" type="number" placeholder="Quantity..."></p>
                    </div>
                    <div class="copies-right" id="adding-color-copies">
                        <h3><span style="color:#fb6630;">C</span><span style="color:#fc6a47;">o</span><span style="color:#fd6d5f;">l</span><span style="color:#fe7176;">o</span><span style="color:#ff748d;">r</span><span style="color:#ec69af;"> </span><span style="color:#d85fd1;">C</span><span style="color:#c554f3;">o</span><span style="color:#b05bf3;">p</span><span style="color:#9a62f4;">i</span><span style="color:#8568f4;">e</span><span style="color:#6f6ff4;">s</span></h3>
                        <p><input id="color-copies-added" class="color-input" type="number" placeholder="Quantity..."></p>
                    </div>
                    <h3>Receipt ID</h3>
                    <p><input id="receipt-ID" class="wide-input" type="text" placeholder="Scan payment receipt here..."></p>
                
            </div>
            <div id="use-copies">
                <div id="confirm-use">
                    <h1>Is the customer<br>USING<br>any copies?</h1>
                    <button class="user-btn" id="using-copies-button">Yes</button>
                    <button class="user-btn" id="not-using-copies-button">No</button>
                </div>
                <div id="confirm-use-black-white" class="copies-left">
                    <h2>Is the customer using any<br>BLACK AND WHITE<br>copies?</h2>
                    <button class="user-btn" id="using-bw-copies-button">Yes</button>
                    <button class="user-btn" id="not-using-bw-copies-button">No</button>
                </div>
                <div id="confirm-use-color" class="copies-right">
                    <h2><br>Is the customer using any<br><span style="color:#fb6630;">COLOR</span><br>copies?</h2>
                    <button class="user-btn" id="using-color-copies-button">Yes</button>
                    <button class="user-btn" id="not-using-color-copies-button">No</button>
                </div>
                <br>
                <h2>Enter the Quantity of Copies to Use</h2><br>
                <div id="using-bw-copies" class="copies-left">
                    <h3>B/W Copies</h3>
                    <p><input id="bw-copies-used" class="bw-input" type="number" placeholder="Quantity..."></p>
                </div>
                <div id="using-color-copies" class="copies-right">
                    <h3><span style="color:#fb6630;">C</span><span style="color:#fc6a47;">o</span><span style="color:#fd6d5f;">l</span><span style="color:#fe7176;">o</span><span style="color:#ff748d;">r</span><span style="color:#ec69af;"> </span><span style="color:#d85fd1;">C</span><span style="color:#c554f3;">o</span><span style="color:#b05bf3;">p</span><span style="color:#9a62f4;">i</span><span style="color:#8568f4;">e</span><span style="color:#6f6ff4;">s</span></h3>
                    <p><input id="color-copies-used" class="color-input" type="number" placeholder="Quantity..."></p>
                </div>
                <h3>Job Description</h3>
                <p><input id="job-description" class="wide-input" type="text" placeholder="Enter a job description..."></p>
            </div>
            <div id="process-transaction">
                <h2>Confirm the Transaction Information Below</h2>
                    <center><img id="database-loading" src="images/loading.gif" width=200px height=200px></center>
                    <p id="transaction-details"></p>
                    <div id="select-store-location">
                            Store location:
                            <input type="radio" id="b1" name="location" value="5314"><label for="b1">5314</label>
                            <input type="radio" id="b2" name="location" value="3120"><label for="b2">3120</label>
                            <input type="radio" id="b3" name="location" value="4290"><label for="b3">4290</label>
                    </div>
                    <button class="user-btn" id="process-transaction-button">Process</button>
                </div>
                </form>
                <center><p id="transaction-submission-status"></p></center>
            </div>
        </div>
    
        <div id="password-reset-dialog" title="Reset your Password!">
            <p class="ui-state-error" style="font-size:20px;">Our records indicate it has been a year since your last password reset.</p>
            <p>Please use the button below to reset your password.</p>
        </div>
    
</body>
</html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    
    <title>
        <?php
        if( $_SESSION["PERMISSION_LEVEL"] == 3)
            echo 'User';
        elseif( $_SESSION["PERMISSION_LEVEL"] == 2)
            echo 'Manager';
        else
            echo 'Admin';
        ?> Menu
    </title>
    
    <script>
        function deleteAdmin() {
            $.ajax({
                url: 'data/deleteTempAdmin.php',
                success: function() {
                    location.href='logout.php';
                }
            } );
        }
    </script>
</head>
<body>
    <div id="container">
        <?php
        if( $_SESSION["PERMISSION_LEVEL"] < 4) {
            echo '
            <div id="user-level" class="content control">
                <h1>Account Settings</h1>
                <button class="user-btn" onclick="location.href=\'passwordReset.php\'">Change Password</button>
                <button class="user-btn no-function">Change Theme</button><br>
                <button class="user-btn" onclick="location.href=\'cc.php\'">Return to Copy Card</button>
                <button class="user-btn" onclick="location.href=\'logout.php\'">Logout</button>
            </div>';
        }

        if( $_SESSION["PERMISSION_LEVEL"] < 2 ) {
            echo '
            <div id="top-level" class="content control">
                <h1>Admin Only</h1>
                <h2>User Controls</h2>';
            
            $dbase = new PDO('mysql:host=localhost;dbname=CopyCardProgram;charset=utf8', 'ccdb', 'ccdb$2015!', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            
            $dbconn = $dbase->prepare("SELECT COUNT(*) FROM Employees JOIN EmployeePermissions ON Employees.EmployeeID = EmployeePermissions.EmployeeID WHERE EmployeePermissions.PermissionID = 1");
            
            $dbconn->execute();
            
            $employeeCount = $dbconn->fetch(PDO::FETCH_NUM);
            
            $dbconn = $dbase->prepare("SELECT COUNT(*) FROM Employees WHERE EmployeeID = -1 AND Active = 1");
            
            $dbconn->execute();
            
            $hasAdmin = $dbconn->fetch(PDO::FETCH_NUM);
            
            if( $employeeCount[0] > 1 && $hasAdmin[0] ) {
                echo '<button class="user-btn config-button" onclick="deleteAdmin()">Delete Temporary Admin Account</button>';
            }
            
            echo '
                <button class="user-btn" onclick="window.location.href=\'addNewUser.php\'">Add a User</button>
                <button class="user-btn no-function" onclick="">Remove a User</button>
            </div>';
        }
        
        if( $_SESSION["PERMISSION_LEVEL"] < 3) {
            echo '
            <div id="bottom-level" class="content control">
                <h1>Manager Only</h1>
                <h2>History</h2>
                <button class="user-btn" onclick="location.href=\'transaction_history.php\'">View Customer History</button>
                <h2>Customer Controls</h2>
                <button class="user-btn no-function">Modify Customer Information</button>
            </div>';
        }


        ?>
    </div>
</body>
</html>


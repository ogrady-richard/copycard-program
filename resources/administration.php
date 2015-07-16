<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.php">
</head>
<body>
    <div id="container">
        <?php
        if( $_SESSION["PERMISSION_LEVEL"] < 4) {
            echo '
            <div id="user-level" class="content control">
                <h1>Account Settings</h1>
                <button class="user-btn no-function">Change Password</button>
                <button class="user-btn no-function">Change Theme</button>
                <button class="user-btn" onclick="location.href=\'cc.php\'">Return to Copy Card</button>
            </div>';
        }

        if( $_SESSION["PERMISSION_LEVEL"] < 2 ) {
            echo '
            <div id="top-level" class="content control">
                <h1>Admin Only</h1>
                <h2>User Controls</h2>';
                
            // Implement 'Delete Temporary Admin' PHP here.
            
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


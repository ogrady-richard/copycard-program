<?php
// Open the session socket to begin testing session variables 
session_start();

if( !isset( $_SESSION['PERMISSION_LEVEL'] ) || $_SESSION['PERMISSION_LEVEL'] > 1 ) {
    header('HTTP/1.0 401 Unauthorized');
    include_once '401.php';
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" type="text/css" href="../vendors/jquery-ui-1.11.4/jquery-ui.min.css">
    
    <script src="../vendors/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="../vendors/jquery-ui-1.11.4/jquery-ui.min.js"></script>

    <script type="text/javascript">
        function makeid() {
            var text = "";
            var possible = "abcdef1234567890";

            for( var i=0; i < 8; i++ )
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
        
        function userExists( user ) {
            var userExistsBool;
            
            $.ajax({
                url: './data/userExists.php',
                async: false,
                type: 'POST',
                data: ({username:user}),
                success: function( ajaxReturn ){
                    if( ajaxReturn == "success" ) {
                        console.log( "Server: " + user + " returns value of " + ajaxReturn + " (Username is currently in use)" );
                        userExistsBool = true;
                    }
                    else {
                        userExistsBool = false;
                        console.log( "Server: " + user + " returns value of " + ajaxReturn + " (Username is free)");
                    }
                },
                failure: function(e) {
                    console.log(e);
                }
            });
            
            return userExistsBool;
        }
        
        function updateDisplayFields() {
            $("#displayName").html( $("#firstName").val() + ' ' + $("#lastName").val() );
            //Check to see if this username already exists
            var currentUsername = ($("#firstName").val()[0] + $("#lastName").val()).toLowerCase().replace(/[^a-z0-9\s]/gi, '');
            var incrementValue = 0;
            while( userExists ( currentUsername ) ) {
                currentUsername = currentUsername + '-' + incrementValue.toString();
                incrementValue++;
            }
            $("#displayUsername").html( currentUsername );
            $("#displayTempPass").html( $("#tempPass").val() );
            $("#displayPermissionLevel").html( $("#permLevel").val() );
        }
        
        function submitAddUserRequest() {
            var userAddedBool;
            
            var user = $('#displayUsername').html();
            
            $.ajax({
                url: './data/addUser.php',
                async: false,
                type: 'POST',
                data: ({username: $('#displayUsername').html(),
                        name: $('#displayName').html(),
                        pass: $("#displayTempPass").html(),
                        permissions: $("#displayPermissionLevel").html()}),
                success: function( ajaxReturn ){
                    if( ajaxReturn == "success" ) {
                        userAddedBool = true;
                        console.log( "Server: '" + user + "' added successfully" );
                    }
                    else {
                        userAddedBool = false;
                        console.log( "Server: error adding user '" + user + "', responce code: " + ajaxReturn );
                    }
                },
                failure: function(e) {
                    console.log(e);
                }
            });
            
            return userAddedBool;
        }
        
        $( function() {
            var temporaryPassword = makeid();
            
            $("#tempPass").val(temporaryPassword);
                
            $( "#dialog-confirm" ).dialog({
                resizable: false,
                modal: true,
                width: 500,
                autoOpen: false,
                buttons: {
                    "Add User": function() {
                        if (submitAddUserRequest() ) {
                            alert( "User added successfully! Write down temporary password: '" + temporaryPassword + "' - it will not be accessible again! Logging out current user...");
                            setTimeout( function() {  window.location.href = "logout.php"; }, 3000 )
                        }
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
            
            $("#regenerate").on( "click", function() {
                temporaryPassword = makeid();
                $("#tempPass").val(temporaryPassword); 
            } );
            
            $("#addUser").on( "click", function() {
                if( $("#firstName").val() != '' 
                &&  $("#lastName").val() != '' 
                &&  $("#tempPass").val() != '' ) {
                    updateDisplayFields();
                    $( "#dialog-confirm" ).dialog("open")
                }
                else {
                    alert( "All fields are not completed. Please fill out the form and try again.");
                }
            } );
        });
    </script>
    </head>
<body>
    <div class="content control">
        <h1>Add A New Employee</h1>
        <h2 class="ui-state-highlight ui-corner-all">Caution: This form is only for authorized users of 'Administrator' level and above. If you are below 'Administrator' permissions, please contact your lead Administrator immediately and inform them of this, or subit a ticket on the <a href="http://45.55.248.93/osTicket/osTicket-1.8/">helpdesk</a>.</h2><hr>
        <button class="user-btn" onclick="window.location.href='cc.php'">Return to Copy Card</button>
        <p>First Name: <input type="text" id="firstName"></p>
        <p>Last Name: <input type="text" id="lastName"></p>
        <p>Temporary Password: <input type="text" id="tempPass" disabled></p>
        <p>Permission Level: 
            <select name="permLevel" id="permLevel">
                <option value="Administrator">Administrator</option>
                <option value="Manager">Manager</option>
                <option value="Associate" selected="selected">Associate</option>
                <option value="Customer">Customer</option>
            </select></p>
        <button class="user-btn" id="regenerate">Get New Password</button><br>
        <button class="user-btn" id="addUser">Add New User</button><br>
    </div>
    
    <div id="dialog-confirm" title="Add New User?">
      <h4>Are you sure you want to add the following user?</h4><hr>
      <p>Name: <span id="displayName"></span></p>
      <p>Username: <span id="displayUsername"></span></p>
      <p>Password: <span id="displayTempPass"></span></p>
      <p>Permissions: <span id="displayPermissionLevel"></span></p>
      <p><i><span id="displayPermissionDescription" style="font-size: 12px;">they can do stuff</span></i></p>
    </div>
    
</body>
</html>
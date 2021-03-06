var currentVersion = '';

function getCurrentVersion() {
    $.ajax({
        url: './data/getVersion.php',
        type: 'JSON',
        success: function(data) {
            returnData = JSON.parse(data);
            currentVersion = returnData['v'];
            },
        error: function() {
            alert("Warning! Error retrieving version data. You may be running on an outdated version of CopyCard. Please contact your administrator immediately. Continued use of CopyCard is not recommended until this issue is resolved.");
        },
        async: false
    });
}

$( function() {
    
    getCurrentVersion();
    
    if( currentVersion != "" ) {
        $('#currentVersionDisplay').html("Current version: " + currentVersion );
    }
    else {
        $('#currentVersionDisplay').addClass("ui-state-error ui-corner-all");
    }
    
    $( '#dialog' ).dialog( {
        dialogClass: 'no-close',
        modal: true,
        closeOnEscape: false,
        autoOpen: true,
        width: 400,
        draggable: false,
        buttons: [ {
            text: 'Login to ZN',
            click: tryLogin
        } ]
        } );
    // Prevent the form from submitting with the Enter key is pressed while in the form.
    $('#login-form').submit( function(event) {tryLogin(); event.preventDefault();});

});

/*
    Function
    Name:
        submitError
    Paramaters:
        text - A string with optional HTML tags.
    Usage:
        This function is used to tell the user there was an error processing
        their AJAX request while logging in. The error message can be
        customized to inform the user where the error occurred.
*/
function submitError( text ) {
    $("#validateTips").html('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>'+text)
                      .addClass("ui-state-error ui-corner-all");
    setTimeout(function() { $("#validateTips").removeClass( "ui-state-error", 1500 ); }, 500 );
}

/*
    Function
    Name:
        isEmpty
    Paramaters:
        inputElement - A string
    Usage:
        Check if the given string is empty.
*/
function isEmpty( inputElement ) {
    return ( $( inputElement ).val() == '' || $( inputElement ).val() == undefined );
}

function tryLogin() {
    if( isEmpty( '#username' ) || isEmpty( '#password' ) ) {
        submitError( 'One or more fields are empty.<br>Please check your login details and try again.<p style="text-align: right; width:500;"><i>(ERR200)</i></p>' );
    }
    else {
        $.ajax({
            url: './data/login.php',
            type: 'POST',
            data: $( '#login-form' ).serialize(),
            success: function( ajaxReturn ) {
                if( ajaxReturn == 'invalid') {
                    submitError( 'Authentication error. Please check your username and password and try again. If this issue persists, please contact the administrator.<p style="text-align: right; width:500;"><i>(ERR300)</i></p>');
                }
                else {
                    $( '#dialog' ).dialog( 'close' );
                    $( "#auth" ).html( "Authentication successful.<br>You are being redirected." ); 
                    setTimeout(function(){window.location="cc.php";},1200);
                }
            },
            error: function() {
                submitError( 'Something went wrong. Please refresh the page and try again. If this issue continues, please contact the administrator.<p style="text-align: right; width:500;"><i>(ERR100)</i></p>');
            }
        });

    }
}
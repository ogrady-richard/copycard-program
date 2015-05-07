   $( function(){
   $( "#dialog" ).dialog({
    dialogClass: "no-close",
    modal: true,
    closeOnEscape: false,
    autoOpen: false,
    width: 400,
    draggable: false,
    buttons: [
        {
            text: "Login to ZN",
            click: function() {
        $.ajax({
            url: 'login.php',
            type: 'POST', // GET or POST
            data: $("#login").serialize(), // will be in $_POST on PHP side
			success: function(output) {
			$( "#dialog" ).dialog( "close" );
			},
			error: function() {
                if( $("#username").val() == "snake") {
                $( "#dialog" ).dialog( "close" );
                $( "#auth" ).html( "Authentication successful.<br>You are being redirected." ); 
                setTimeout(function(){window.location="cc.html";},500);
                }
                else {
			    $("#validateTips").html('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Error. Please try again.').addClass("ui-state-error ui-corner-all");
                setTimeout(function() { $("#validateTips").removeClass( "ui-state-error", 1500 ); }, 500 );
                }
            }
        });
            }
        }
    ]
    });
 
    $( "#dialog" ).dialog( "open" );
    });
    
    //Rewrite ----------------------
    
$( function() {
    $( '#dialog' ).dialog( {
        dialogClass: 'no-close',
        modal: true,
        closeOnEscape: false,
        autoOpen: true,
        width: 400,
        draggable: true,
        buttons: [ {
            text: 'Login to ZN',
            click: function() {
                if( isEmpty( '#username' ) || isEmpty( '#password' ) ) {
                    submitError( 'One or more fields are empty.<br>Please check your login details and try again.<p style="text-align: right; width:500;"><i>(ERR200)</i></p>' );
                }
                else {
                    $.ajax({
                        url: './data/login.php',
                        type: 'POST',
                        data: $( '#login-form' ).serialize(),
                        success: function( logStatus ) {
                            if( logStatus == 'invalid') {
                                submitError( 'Authentication error. Please check your username and password and try again. If this issue persists, please contact the administrator.<p style="text-align: right; width:500;"><i>(ERR300)</i></p>');
                            }
                            else {
                                $( '#dialog' ).dialog( 'close' );
                                $( "#auth" ).html( "Authentication successful.<br>You are being redirected." ); 
                                setTimeout(function(){window.location="cc.html";},1200);
                            }
                        },
                        error: function() {
                            submitError( 'Something went wrong. Please refresh the page and try again. If this issue continues, please contact the administrator.<p style="text-align: right; width:500;"><i>(ERR100)</i></p>');
                        }
                    });

                }
            }
        
        } ]
        } );
});

/*
    Function
    Name:
        submitError
    Paramaters:
        text - A string with optional HTML tags.
    Usage:
        This function is used to tell the user there was an error processing their AJAX request while logging in. The error message can be customized to inform the user where the error occured.
*/
function submitError( text ) {
    $("#validateTips").html('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>'+text)
                      .addClass("ui-state-error ui-corner-all");
    setTimeout(function() { $("#validateTips").removeClass( "ui-state-error", 1500 ); }, 500 );
};

function isEmpty( inputElement ) {
    return ( $( inputElement ).val() == '' );
}
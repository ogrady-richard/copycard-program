function getEmployeeResetDate() {
    $.ajax({
        url: './data/getLastResetDate.php',
        type: 'POST',
        success: function(ajaxReturn) {
            var ajaxParsed = JSON.parse(ajaxReturn);
            var showHTML = '';
            if(ajaxParsed["overYear"] == "1") {
                showHTML = "<b>Last Password Reset: <p>" + ajaxParsed["lastDate"] + "</p><p>Password needs to be reset.</p></b>";
                $('#last-reset').addClass("ui-state-highlight");
            }
            else {
                showHTML = "<b>Last Password Reset: <p>" + ajaxParsed["lastDate"] + "</p><p>Password is up to date</p></b>";
                $('#last-reset').addClass("ui-success");
            }
            
            $('#last-reset').html(showHTML);
            console.log(ajaxParsed["overYear"]);
        },
        error: function(ajaxReturn) {
            $('#last-reset').html("Error accessing database. If this issue persists, submit an error on the <a href='http://45.55.248.93/osTicket/osTicket-1.8/'>helpdesk</a> or contact the administrator.");
            console.log("No connection to server extablished. Error: " + ajaxReturn);
        }
    });
}

$( function() {
    $('#submit-password').on("click", function(e) {
        e.preventDefault();
        $.ajax({
            url: 'data/resetPassword.php',
            type: 'POST',
            data: $('#password-fields').serialize(),
            success: function(data) {
                var results = JSON.parse(data);
                if( results["stat"]=="false") {
                    console.log(data);
                    $('#submit-state').html(results["msg"]).addClass("ui-state-error");
                } 
                else {
                    console.log(data);
                    alert("Password successfully changed. Returning to login screen.");
                    setTimeout( function() { location.href="logout.php" }, 500);
                }
            },
            error: function() {
                $('#submit-state').html();
            }
        });
    });
    
    getEmployeeResetDate();
});
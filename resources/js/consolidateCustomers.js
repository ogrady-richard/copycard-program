    var totalBWCopies = ["",""]; 
    var totalColorCopies = ["",""];

$( function() {    
    $('#consolidateCustomersForm').on( "submit", function(e) {
        e.preventDefault();
        return false;
    });
    
    $('.custField').on( "change", function() {
        var selectedField = this.id;
        $.ajax({
            url: "data/getCustomerInfo.php",
            type: "POST",
            data: { "cid": $('#'+this.id).val() },
            success: function(ajaxReturn) {
                customerData = JSON.parse(ajaxReturn)['custData'];
                $('#'+selectedField+'CustomerData > #custName').val(customerData['FirstName'] + ' ' + customerData['LastName']);
                $('#'+selectedField+'CustomerData > #custPhone').val(customerData['Phone']);
                $('#'+selectedField+'CustomerData > #custEmail').val(customerData['Email']);
                $('#'+selectedField+'CustomerData > #custBusiness').val(customerData['Business']);
                $('#'+selectedField+'CustomerData > #custBW').val(customerData['BlackWhiteCopies']);
                $('#'+selectedField+'CustomerData > #custColor').val(customerData['ColorCopies']);
                if( selectedField == "firstID" )
                    totalBWCopies[0] = customerData['BlackWhiteCopies'];
                else
                    totalBWCopies[1] = customerData['BlackWhiteCopies'];
                
                if( selectedField == "firstID" )
                    totalColorCopies[0] = customerData['ColorCopies'];
                else
                    totalColorCopies[1] = customerData['ColorCopies'];
                if( totalBWCopies[0] != "" && totalBWCopies[1] != "" && totalColorCopies[0] != "" && totalColorCopies[1] != "" ) {
                    $("#totalBW").val( parseInt(totalBWCopies[0]) + parseInt(totalBWCopies[1]) );
                    $("#totalColor").val( parseInt(totalColorCopies[0]) + parseInt(totalColorCopies[1]) );
                }
            },
            failure: function() {
                alert("Error contacting server. Please contact the administrator.");
            }
        });
        

    });
    
    $('#process').on( "click", function() {
        if( $('#firstID').val() == "" || $('#secondID').val() == "" || $('#firstID').val() == $('#secondID').val() ) {
            alert( "You must enter two unique customer IDs in order to consolidate the accounts. Please check your entries and try again." );
        }
        else {
            $.ajax({
                url: "data/consolidateCustomers.php",
                type: "POST",
                data: {
                    "firstID" : $('#firstID').val(), 
                    "secondID" : $('#secondID').val()
                },
                success: function(ajaxReturn) {
                    serverData = JSON.parse( ajaxReturn );
                    if( serverData["status"] == "Good" ) {
                        alert( serverData["msg"] );
                    }
                    else {
                        alert( serverData["msg"] );
                    }
                },
                failure: function() {
                    alert("Error contacting server. Please contact the administrator.");
                }
            });
        }
    });
});
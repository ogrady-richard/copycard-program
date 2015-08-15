var selectedCustomer = '';

function refreshCustomerTable() {
    $.ajax({
        url: './data/getCustomers.php',
        type: 'POST',
        success: function( ajaxReturn ) {
            customerTable.clear();
            customerTable.rows.add(JSON.parse(ajaxReturn)).draw();
        },
        error: function() {
            alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
            console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
        }
    });
}

function refreshCustomerDialogInformation() {
    $.ajax({
        url: './data/getCustomerInfo.php',
        type: 'POST',
        data: ({cid : selectedCustomer}),
        success: function( ajaxReturn ) {
            customerData = JSON.parse(ajaxReturn)['custData'];
            dateCreated = JSON.parse(ajaxReturn)['created'];
            dateModified = JSON.parse(ajaxReturn)['modified'];
            if( customerData['FirstName'] == '' && customerData['LastName'] == '' ) {
                $("#cust-name-disp").html("<b>Name: </b> <i>-Business Account-</i>");
            }
            else { 
                $("#cust-name-disp").html("<b>Name: </b>" + customerData['FirstName'] + ' ' + customerData['LastName']);
            }
            $("#created-disp").html("<b>Created: </b>" + dateCreated.slice(0,10) + " | <b>Modified:</b> " + dateModified.slice(0,10));
            if( customerData['Phone'] != '' ) {
                $("#cust-phone-disp").html("<b>Phone: </b>" + customerData['Phone']);
                if(customerData['TelExtension'] != '')
                    $("#cust-phone-disp").html($("#cust-phone-disp").html + " +" + customerData['TelExtension']);
            }
            else
                $("#cust-phone-disp").html("<b>No Phone Provided</b>" );
            if( customerData['Email'] != '' )
                $("#cust-email-disp").html("<b>Email: </b>" + customerData['Email'] );
            else
                $("#cust-email-disp").html("<b>No Email Provided</b>" );
            if( customerData['Business'] != '' )
                $("#cust-business-disp").html("<b>Business: </b>" + customerData['Business'] );
            else
                $("#cust-business-disp").html("<b>No Business Provided</b>" );
            $("#cust-bw-disp").html("<b>Black/White: </b>" + customerData['BlackWhiteCopies'] );
            $("#cust-color-disp").html("<b>Color: </b>" + customerData['ColorCopies'] );
            $("#auth-users-disp").html("<b>Authorized users:</b><br><textarea style='height:75px; resize:none;' disabled>Coming soon...</textarea>" );
            
            $('#loading-cust-info').hide();
            $('#show-cust-info').show();
        },
        error: function() {
            alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
            console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
        }
    });
}

function addCustomer() {
        $.ajax({
            url: './data/addCustomer.php',
            type: 'POST',
            data: $('#customer-information-form').serialize(),
            success: function( ajaxReturn ) {
                refreshCustomerTable();
                if( ajaxReturn == 'invalid' ) {
                    alert('There was a problem adding the user to the database. Please consult the administrator.');
                    console.log('User not added successfully.');
                }
            },
            error: function() {
                alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
                console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
            }
        });

    refreshCustomerTable();
    $('#add-modal').dialog( 'close' );
}

function resetForm( resetForm ) {
    $(resetForm).trigger('reset');
}

$( function() {
    // COPYCARD SETTINGS
    var RECEIPT_ID_LENGTH = 20;
    var customerData = '';
    // Create the customer table DataTable object
    customerTable = $('#customer-table').DataTable({
                                        "columnDefs": [{"targets":[0,5,6],
                                        "visible": false,
                                        "searchable": false,
                                        }],
                                        "lengthChange": false
                    });
    
    // Create the "Add Customer" modal object
    $('#add-modal').dialog({modal:true, autoOpen: false, 
                            buttons: { "Add Customer": function() { $('#customer-information-form').submit() } }, 
                            close: function() {resetForm('#customer-information-form')},
                            width: 500
                            } );
    
    $('#select-store-location').buttonset();
    
    // Allow use of 'Enter' to submit a new customer from the add customer form
    $('#customer-information-form').submit( function(event) {addCustomer(); event.preventDefault();});
    
    // Populate the table with data from our database
    refreshCustomerTable();

    // Create our debug dialog object, for testing purposes only
    $( "#cust-dialog" ).dialog({
    autoOpen: false,
    width: 700,
    position: {my:"center top", at:"center top", of:window},
    buttons: [
        {
            text: "Ok",
            click: function() {
                $( "#cust-dialog" ).dialog( "close" );
            }
        }]
    });
    
    // Create the password reset dialog
    $( '#password-reset-dialog' ).dialog( {
        dialogClass: 'no-close',
        modal: true,
        closeOnEscape: false,
        autoOpen: false,
        width: 400,
        draggable: false,
        buttons: [ {
            text: 'Reset Password',
            click: function(){window.location.href="passwordReset.php";}
        } ]
        } );
    // Prevent the form from submitting with the Enter key is pressed while in the form.
    $('#login-form').submit( function(event) {tryLogin(); event.preventDefault();});
    
    // Click event for the Add Customer button
    $('#add-new-customer').click( function() {
        $('#add-modal').dialog( 'open' );
    });
    
    $('#add-use-copies').click( function() {
        $('#manipulate-copies').dialog( 'open' );
        $('#copy-tabs').tabs("option", "active", 0);
    });
    
    $("#manipulate-copies" ).dialog({
    autoOpen: false,
    width: 700,
    modal: true
    });
    
    $("#process-transaction-tab").on( 'click', function() {
        $.ajax({
            url: './data/getCustomerInfo.php',
            type: 'POST',
            data: ({cid : selectedCustomer}),
            success: function( ajaxReturn ) {
                $('#transaction-details').show();
                $('#database-loading').hide();
                customerData =  JSON.parse(ajaxReturn)['custData'];
                
                var str = "";
                var totalBW = 0;
                var totalColor = 0;
                
                str = str + "Existing B/W Copies: "
                str = str + customerData['BlackWhiteCopies'] + "<br>";
                totalBW = parseInt(customerData['BlackWhiteCopies']);
                
                if( $("#bw-copies-added").val() > 0 ) {
                    str = str + "B/W Copies to Add: "
                    str = str + $("#bw-copies-added").val() + "<br>";
                    totalBW = totalBW + parseInt($("#bw-copies-added").val());
                }
                
                if( $("#bw-copies-used").val() > 0 ) {
                    str = str + "B/W Copies to Use: "
                    str = str + $("#bw-copies-used").val() + "<br>";
                    totalBW = totalBW - parseInt($("#bw-copies-used").val());
                }
                
                str = str + "<hr>"
                
                str = str + "Existing Color Copies: "
                str = str + customerData['ColorCopies'] + "<br>";
                totalColor = parseInt(customerData['ColorCopies']);
                
                if( $("#color-copies-added").val() > 0 ) {
                    str = str + "Color Copies to Add: "
                    str = str + $("#color-copies-added").val() + "<br>";
                    totalColor = totalColor + parseInt($("#color-copies-added").val());
                }
                
                if( $("#color-copies-used").val() > 0 ) {
                    str = str + "Color Copies to Use: "
                    str = str + $("#color-copies-used").val() + "<br>";
                    totalColor = totalColor - parseInt($("#color-copies-used").val());
                }
                str = str + "<hr>"
                str = str + "<b>Remaining B/W After Transaction: "
                str = str + totalBW + "</b><br>";
                str = str + "<b>Remaining Color After Transaction: "
                str = str + totalColor + "<br>";
                str = str + "</b><hr>"
                
                $("#transaction-details").html(str);
                    
            },
            error: function() {
                alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
                console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
            }
        });
        
    });
    
    $("#copy-tabs").tabs();
    
    // Debug function - Call our debug modal to show the selected customers info
    $('#customer-table tbody').on('dblclick', 'tr', function () {
        selectedCustomer = customerTable.row(this).data()[0];
        $('#loading-cust-info').show();
        $('#show-cust-info').hide();
        refreshCustomerDialogInformation();
        $( "#cust-dialog" ).dialog( "open" );
    });
    
    $('#process-transaction-button').on('click', function () {
        //Check the value of Receipt ID field
        var hasReceiptID = ( $('#receipt-ID').val().length == RECEIPT_ID_LENGTH );
        //Check the value of the job description field.
        var hasJobDescription = ($('#job-description').val().length > 0);
        //Create the transaction status value
        var transactionIsGood = true;
        
        //Check to see if we are adding copies    
        if( $("#color-copies-added").val() > 0 || $("#bw-copies-added").val() > 0 ) {
            if( !hasReceiptID ) {
                console.log('No Reciept ID Provided.');
                $('#receipt-ID').val( 'None' );
            }
        }
        
        //Check to see if we are using copies
        if( $("#color-copies-used").val() > 0 || $("#bw-copies-used").val() > 0 ) {
            if( !hasJobDescription ) {
                console.log('No Job Description Provided.');
                $('#job-description').val( 'None' );
            }
        }
        
        //Make sure we have a store location checked
        if( typeof $('input[name="location"]:checked').val() == 'undefined' ) {
            transactionIsGood = false;
        }

        if( transactionIsGood ) {
            $('#transaction-details').hide();
            $('#database-loading').show();
            $.ajax({
                 url: 'data/processTransaction.php', //This is the current doc
                 type: "POST",
                 dataType:'json', // add json datatype to get json
                 data: ({customerID: selectedCustomer,
                         bwCopiesToAdd: $("#bw-copies-added").val(),
                         colorCopiesToAdd: $("#color-copies-added").val(),
                         bwCopiesToUse: $("#bw-copies-used").val(),
                         colorCopiesToUse: $("#color-copies-used").val(),
                         receiptID: $('#receipt-ID').val(),
                         jobDescription: $('#job-description').val(),
                         storeLocation: $('input[name="location"]:checked').val()}),
                 success: function(data){
                     $("#transaction-submission-status").html('');
                     console.log(data);
                     $('#manipulate-copies').dialog( 'close' );
                     refreshCustomerTable();
                     refreshCustomerDialogInformation()
                 }
            });
        } else {
            $("#transaction-submission-status").html('We have encountered an error. Please check transaction details again.<br>If the issue persists, please contact the administrator via the <a href="http://45.55.248.93/osTicket/osTicket-1.8/" target="_blank">helpdesk</a>')
                              .addClass("ui-state-error ui-corner-all");
            setTimeout(function() { $("#transaction-submission-status").removeClass( "ui-state-error", 1500 ); }, 500 );
        }
    });
    
    // Unrefined copy customer quick display
    $('#customer-table tbody').on('mouseenter', 'tr', function () {
        if( customerTable.row( this ).data() != undefined ) {
            $('#display-BW').html( '<h3>B/W</h3>'+customerTable.row( this ).data()[5] );
            $('#display-color').html( '<h3>Color</h3>'+customerTable.row( this ).data()[6] );
        }
    });
    
    // Check to see if the user needs to reset their password
    $.ajax({
        url: 'data/checkPasswordReset.php',
        success: function( data ) {
            ajaxReturn = JSON.parse ( data );
            if( ajaxReturn["msg"] == "true" ) {
                $( '#password-reset-dialog' ).dialog( "open" );
            }
            console.log(ajaxReturn["msg"] + ', ' + ajaxReturn["isOver"]);
        },
        error: function( e ) {
            console.log( "Error: " + e );
        }
    });
});
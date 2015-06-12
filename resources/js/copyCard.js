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

function addCustomer() {
    sanitize = function(input) {
		var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
					 replace(/<[\/\!]*?[^<>]*?>/gi, '').
					 replace(/<style[^>]*?>.*?<\/style>/gi, '').
					 replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
	    return output;
	};
    
        $.ajax({
        url: './data/addCustomer.php',
        type: 'POST',
        data: $('#customer-information-form').serialize(),
        success: function( ajaxReturn ) {
            refreshCustomerTable();
        },
        error: function() {
            alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
            console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
        }
        });
    
    $('#add-modal').dialog( 'close' );
    
    refreshCustomerTable();
}

function resetForm( resetForm ) {
    $(resetForm).trigger('reset');
}

$( function() {
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
    
    // Allow use of 'Enter' to submit a new customer from the add customer form
    $('#customer-information-form').submit( function(event) {addCustomer(); event.preventDefault();});
    
    // Populate the table with data from our database
    refreshCustomerTable();

    // Create our debug dialog object, for testing purposes only
    $( "#dialog" ).dialog({
    autoOpen: false,
    buttons: [
        {
            text: "Ok",
            click: function() {
                $( "#dialog" ).dialog( "close" );
            }
        }]
    });
    
    // Click event for the Add Customer button
    $('#add-new-customer').click( function() {
        $('#add-modal').dialog( 'open' );
    });
    
    // Debug function - Call our debug modal to show the selected customers info
    $('#customer-table tbody').on('dblclick', 'tr', function () {
        $( "#dialog" ).dialog( "open" );
        $( "#foo").html( customerTable.row( this ).data().join('; ') );
    });
    
    // Unrefined copy customer quick display
    $('#customer-table tbody').on('mouseenter', 'tr', function () {
        if( customerTable.row( this ).data() != undefined ) {
            $('#display-BW').html( '<h3>B/W</h3>'+customerTable.row( this ).data()[5] );
            $('#display-color').html( '<h3>Color</h3>'+customerTable.row( this ).data()[6] );
        }
    });
});
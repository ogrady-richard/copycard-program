function addCustomer() {
    
    sanitize = function(input) {
		var output = input.replace(/<script[^>]*?>.*?<\/script>/gi, '').
					 replace(/<[\/\!]*?[^<>]*?>/gi, '').
					 replace(/<style[^>]*?>.*?<\/style>/gi, '').
					 replace(/<![\s\S]*?--[ \t\n\r]*>/gi, '');
	    return output;
	};
    
    customerTable.row.add([sanitize($('#cust-id').val()), sanitize($('#cust-f-name').val() + ' ' + $('#cust-l-name').val()) ,
                           sanitize($('#cust-ph').val()), sanitize($('#cust-email').val()),
                           sanitize($('#cust-business').val()), sanitize($('#cust-bw').val()),
                           sanitize($('#cust-color').val())]).draw();
}

function resetForm( resetForm ) {
    $(resetForm).trigger('reset');
}

$( function() {
    
    $('#add-modal').dialog({modal:true, autoOpen: false, buttons: { "Add Customer": function() {addCustomer(); $('#add-modal').dialog( 'close' );} }, close: function() {resetForm('#customer-information-form')} } );
    
    $('#add-new-customer').click( function() {
        $('#add-modal').dialog( 'open' );
    });

    $.ajax({
        url: './data/getCustomers.php',
        type: 'POST',
        success: function( ajaxReturn ) {
            customerTable.rows.add(JSON.parse(ajaxReturn)).draw();
        },
        error: function() {
            alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");
            console.error( "Issues communicating with the server. Please refresh and try again. (404 Not Found)" );
        }
    });    

    });
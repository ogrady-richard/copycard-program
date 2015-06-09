function addCustomer() {
    customerTable.row.add([$('#cust-id').val(), $('#cust-name').val(), $('#cust-ph').val(), $('#cust-email').val(), $('#cust-business').val(), $('#cust-bw').val(), $('#cust-color').val()]).draw();
}

$( function() {
    
    $('#add-modal').dialog({modal:true, autoOpen: false, buttons: { "alrighty": addCustomer}, close: function() {$('#customer-information-form').trigger( 'reset' );} });
    
    $('#add-new-customer').click( function() {
        $('#add-modal').dialog( 'open' );
    });
});
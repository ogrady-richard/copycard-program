var selectedCustomer="";var currentVersion="";var versionSummary="";var sessionTimeout=600*1000;var alertTimeout=sessionTimeout*0.8;var today=new Date();startTime=Date.now();endTime=startTime+sessionTimeout;function refreshCustomerTable(){$.ajax({url:"./data/getCustomers.php",type:"POST",success:function(a){customerTable.clear();customerTable.rows.add(JSON.parse(a)).draw()},error:function(){alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");console.error("Issues communicating with the server. Please refresh and try again. (404 Not Found)")}})}function getCurrentVersion(){$.ajax({url:"./data/getVersion.php",type:"JSON",success:function(a){returnData=JSON.parse(a);currentVersion=returnData.v;versionSummary=returnData.s},error:function(){alert("Warning! Error retrieving version data. You may be running on an outdated version of CopyCard. Please contact your administrator immediately. Continued use of CopyCard is not recommended until this issue is resolved.")},async:false})}function refreshCustomerDialogInformation(){$.ajax({url:"./data/getCustomerInfo.php",type:"POST",data:({cid:selectedCustomer}),success:function(a){customerData=JSON.parse(a)["custData"];dateCreated=JSON.parse(a)["created"];dateModified=JSON.parse(a)["modified"];if(customerData.FirstName==""&&customerData.LastName==""){$("#cust-name-disp").html("<b>Name: </b> <i>-Business Account-</i>")}else{$("#cust-name-disp").html("<b>Name: </b>"+customerData.FirstName+" "+customerData.LastName)}$("#cust-id-disp").html("<i>ID: "+customerData.CustomerID+"</i>");$("#created-disp").html("<b>Created: </b>"+dateCreated.slice(0,10)+" | <b>Modified:</b> "+dateModified.slice(0,10));if(customerData.Phone!=""){$("#cust-phone-disp").html("<b>Phone: </b>"+customerData.Phone.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/,"$1.$2.$3"));if(customerData.TelExtension!=""){$("#cust-phone-disp").html("<b>Phone: </b>"+customerData.Phone.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/,"$1.$2.$3")+" ex: "+customerData.TelExtension)}}else{$("#cust-phone-disp").html("<b>No Phone Provided</b>")}if(customerData.Email!=""){$("#cust-email-disp").html("<b>Email: </b>"+customerData.Email)}else{$("#cust-email-disp").html("<b>No Email Provided</b>")}if(customerData.Business!=""){$("#cust-business-disp").html("<b>Business: </b>"+customerData.Business)}else{$("#cust-business-disp").html("<b>No Business Provided</b>")}$("#cust-bw-disp").html("<b>Black/White: </b>"+customerData.BlackWhiteCopies);$("#cust-color-disp").html("<b>Color: </b>"+customerData.ColorCopies);$("#auth-users-disp").html("<b>Authorized users:</b><br><textarea style='height:75px; resize:none;' disabled>Coming soon...</textarea>");$("#loading-cust-info").hide();$("#show-cust-info").show()},error:function(){alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");console.error("Issues communicating with the server. Please refresh and try again. (404 Not Found)")}})}function addCustomer(){$.ajax({url:"./data/addCustomer.php",type:"POST",data:$("#customer-information-form").serialize(),success:function(a){refreshCustomerTable();if(a=="invalid"){alert("There was a problem adding the user to the database. Please consult the administrator.");console.log("User not added successfully.")}},error:function(){alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");console.error("Issues communicating with the server. Please refresh and try again. (404 Not Found)")}});refreshCustomerTable();$("#add-modal").dialog("close")}function resetForm(a){$(a).trigger("reset")}$(function(){var d=setTimeout(function(){$("<div title='Session expiring!' style='background-color: #d69999;'><p>Your session is about to expire. Please refresh the page to renew your session, or logout if you are no longer using this session.</p></div>").dialog({width:500})},alertTimeout);var b=setTimeout(function(){window.location.href="logout.php"},sessionTimeout);var c=20;var a="";getCurrentVersion();if(currentVersion==""){alert("Warning! Version information is invalid. You may be running on an outdated version of CopyCard. Please contact your administrator immediately. Continued use of CopyCard is not recommended until this issue is resolved.")}$("#manipulate-copies-fields").on("submit",function(f){f.preventDefault();return false});if(!(document.cookie.indexOf("version="+currentVersion)>=0)){$("<div title='New Update' style='background-color: #D65C33;'><p>There has been an update since your last login.</p><p>Version changes: "+versionSummary+"</p><p><a href='https://github.com/ogrady-richard/copycard-program/blob/master/VERSION.md' target='_blank'>Official Change List</a></p> </div>").dialog({width:700});document.cookie="version="+currentVersion}customerTable=$("#customer-table").DataTable({columnDefs:[{targets:[0,5,6],visible:false,searchable:false,}],lengthChange:false});$("#add-modal").dialog({modal:true,autoOpen:false,buttons:{"Add Customer":function(){$("#customer-information-form").submit()}},close:function(){resetForm("#customer-information-form")},width:500});$("#select-store-location").buttonset();$("#customer-information-form").submit(function(e){addCustomer();e.preventDefault()});refreshCustomerTable();$("#cust-dialog").dialog({autoOpen:false,width:700,position:{my:"center top",at:"center top",of:window},buttons:[{text:"Ok",click:function(){$("#cust-dialog").dialog("close")}}]});$("#password-reset-dialog").dialog({dialogClass:"no-close",modal:true,closeOnEscape:false,autoOpen:false,width:400,draggable:false,buttons:[{text:"Reset Password",click:function(){window.location.href="passwordReset.php"}}]});$("#login-form").submit(function(e){tryLogin();e.preventDefault()});$("#add-new-customer").click(function(){$("#add-modal").dialog("open")});$("#add-use-copies").click(function(){$("#manipulate-copies").dialog("open");$("#copy-tabs").tabs("option","active",0)});$("#manipulate-copies").dialog({autoOpen:false,width:700,modal:true,open:function(){resetForm("#manipulate-copies-fields")}});$("#process-transaction-tab").on("click",function(){$.ajax({url:"./data/getCustomerInfo.php",type:"POST",data:({cid:selectedCustomer}),success:function(e){$("#transaction-details").show();$("#database-loading").hide();a=JSON.parse(e)["custData"];var h="";var f=0;var g=0;h=h+"Existing B/W Copies: ";h=h+a.BlackWhiteCopies+"<br>";f=parseInt(a.BlackWhiteCopies);if($("#bw-copies-added").val()>0){h=h+"B/W Copies to Add: ";h=h+$("#bw-copies-added").val()+"<br>";f=f+parseInt($("#bw-copies-added").val())}if($("#bw-copies-used").val()>0){h=h+"B/W Copies to Use: ";h=h+$("#bw-copies-used").val()+"<br>";f=f-parseInt($("#bw-copies-used").val())}h=h+"<hr>";h=h+"Existing Color Copies: ";h=h+a.ColorCopies+"<br>";g=parseInt(a.ColorCopies);if($("#color-copies-added").val()>0){h=h+"Color Copies to Add: ";h=h+$("#color-copies-added").val()+"<br>";g=g+parseInt($("#color-copies-added").val())}if($("#color-copies-used").val()>0){h=h+"Color Copies to Use: ";h=h+$("#color-copies-used").val()+"<br>";g=g-parseInt($("#color-copies-used").val())}h=h+"<hr>";h=h+"<b>Remaining B/W After Transaction: ";h=h+f+"</b><br>";h=h+"<b>Remaining Color After Transaction: ";h=h+g+"<br>";h=h+"</b><hr>";$("#transaction-details").html(h)},error:function(){alert("Unable to retrieve customer information at this time. Please contact the administrator if this issue persists.");console.error("Issues communicating with the server. Please refresh and try again. (404 Not Found)")}})});$("#copy-tabs").tabs();$("#customer-table tbody").on("dblclick","tr",function(){selectedCustomer=customerTable.row(this).data()[0];$("#loading-cust-info").show();$("#show-cust-info").hide();refreshCustomerDialogInformation();$("#cust-dialog").dialog("open")});$("#process-transaction-button").on("click",function(){var f=($("#receipt-ID").val().length==c);var e=($("#job-description").val().length>0);var g=true;if($("#color-copies-added").val()>0||$("#bw-copies-added").val()>0){if(!f){console.log("No Reciept ID Provided.");$("#receipt-ID").val("None")}}if($("#color-copies-used").val()>0||$("#bw-copies-used").val()>0){if(!e){console.log("No Job Description Provided.");$("#job-description").val("None")}}if(typeof $('input[name="location"]:checked').val()=="undefined"){g=false}if(g){$("#transaction-details").hide();$("#database-loading").show();$.ajax({url:"data/processTransaction.php",type:"POST",dataType:"json",data:({customerID:selectedCustomer,bwCopiesToAdd:$("#bw-copies-added").val(),colorCopiesToAdd:$("#color-copies-added").val(),bwCopiesToUse:$("#bw-copies-used").val(),colorCopiesToUse:$("#color-copies-used").val(),receiptID:$("#receipt-ID").val(),jobDescription:$("#job-description").val(),storeLocation:$('input[name="location"]:checked').val()}),success:function(h){$("#transaction-submission-status").html("");console.log(h);$("#manipulate-copies").dialog("close");refreshCustomerTable();refreshCustomerDialogInformation()}})}else{$("#transaction-submission-status").html('We have encountered an error. Please check transaction details again.<br>If the issue persists, please contact the administrator via the <a href="http://45.55.248.93/osTicket/osTicket-1.8/" target="_blank">helpdesk</a>').addClass("ui-state-error ui-corner-all");setTimeout(function(){$("#transaction-submission-status").removeClass("ui-state-error",1500)},500)}});$("#customer-table tbody").on("mouseenter","tr",function(){if(customerTable.row(this).data()!=undefined){$("#display-BW").html("<h3>B/W</h3>"+customerTable.row(this).data()[5]);$("#display-color").html("<h3>Color</h3>"+customerTable.row(this).data()[6])}});$.ajax({url:"data/checkPasswordReset.php",success:function(e){ajaxReturn=JSON.parse(e);if(ajaxReturn.msg=="true"){$("#password-reset-dialog").dialog("open")}console.log(ajaxReturn.msg+", "+ajaxReturn.isOver)},error:function(f){console.log("Error: "+f)}})});
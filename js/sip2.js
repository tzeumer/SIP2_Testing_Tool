/**
 * All stuff needed for the SIP2 communication
 */
$(document).ready(function() {
    // Hide alt buttons
    $('#btn_server_disconnect').hide();

    // Monitor Item Barcode
    $('#itemID').bind('keypress keyup blur', function() {
        $('#itemID_checkout').val($(this).val());
        $('#itemID_checkin').val($(this).val());
        $('#itemID_renew').val($(this).val());
        $('#itemID_statusUpdate').val($(this).val());
        //...
    });

    /* Monitor Patron id
    $('#patronID').bind('keypress keyup blur', function() {
        $('#patronID_pay').val($(this).val());
        //...
    });
    */

    // Clean up if user leaves page
    $(window).bind('beforeunload', function(){
        $('#btn_server_disconnect2').trigger('click');
        return 'Cleaning up';
    });

    /**
     * @brief   Button with sip2cmd class clicked
     */
    $('.sip2cmd').on('click', function( event ) {
        event.preventDefault();

        // Serialize form data; set unset checkboxes to false
        //var formData = $('#form_server').serialize({ checkboxesAsBools: true });
        var formData = $(this).closest('form').serializeArray({ checkboxesAsBools: true });

        // Add command from button to form data
        var command = $(this).val();
        formData.push({name: 'sip2cmd', value: $(this).val()});

        // Testing
        console.log( formData );

        // Send ajax request to this file (yeah, I know...)
        $.ajax({
            type: 'POST',
            url: 'inc/response.php',
            data: formData,
            dataType:'json',
            success:function(data){
                if (data['status'] == 'success') {
                    toggle_buttons_success(command);
                    $('#logwindow pre').append( JSON.parse(data['log']) );
                    $('#readable pre').empty().append( data['data'] );
                    // Show screen message for patron
                    var xpar = JSON.parse(data['data_all']);
                    if (xpar.variable.AF !== undefined) {
                        $('#screen_message pre').empty().append("Last screen message:\n" + xpar.variable.AF );
                    } else {
                        $('#screen_message pre').empty().append("\n\n");
                    }
                }
                else if (data['status'] == 'failure') {
                    $('#logwindow pre').append( JSON.parse(data['log']) );
                    $('#btn_server_connect').show();
                    $('#btn_server_disconnect').hide();
                } else {
                    alert(data['msg']);
                }
            },
            error: function(data) {
                alert("Failure!");
            }
        });
    });

});


// Toggle buttons by command
function toggle_buttons_success(command) {
    switch (command) {
        case 'connect':
            $('#btn_server_disconnect').show();
            $('#btn_server_connect').hide();
            $('#btn_device_connect').prop('disabled', false);
            break;
        case 'login':
            $('#btn_getAcsStatus').prop('disabled', false);
            $('#btn_startPatronSession').prop('disabled', false);
            $('#btn_feePay').prop('disabled', false);
            $('#btn_itemGetInformation').prop('disabled', false);
            $('#btn_itemCheckin').prop('disabled', false);
            break;
        case 'startPatronSession':
            $('#btn_endPatronSession').prop('disabled', false);
            $('.btnGetPatron').prop('disabled', false);
            $('#btn_itemCheckout').prop('disabled', false);
            $('#btn_itemRenew').prop('disabled', false);
            $('#btn_itemRenewAll').prop('disabled', false);
            $('#btn_itemStatusUpdate').prop('disabled', false);
            //$('#noLoginFee').toggle();
            break;
        case 'endPatronSession':
            $('#btn_endPatronSession').prop('disabled', true);
            $('.btnGetPatron').prop('disabled', true);
            $('#btn_itemCheckout').prop('disabled', true);
            $('#btn_itemRenew').prop('disabled', true);
            $('#btn_itemRenewAll').prop('disabled', true);
            $('#btn_itemStatusUpdate').prop('disabled', true);
            //$('#noLoginFee').toggle();
            break;
        case 'disconnect':
        case 'kill':
            $('#btn_server_disconnect').hide();
            $('#btn_server_connect').show();
            $('#btn_device_connect').prop('disabled', true);
            $('#btn_getAcsStatus').prop('disabled', true);
            $('#btn_startPatronSession').prop('disabled', true);
            $('#btn_endPatronSession').prop('disabled', true);
            $('.btnGetPatron').prop('disabled', true);
            $('#btn_feePay').prop('disabled', true);
            $('#btn_itemGetInformation').prop('disabled', true);
            $('#btn_itemCheckin').prop('disabled', true);
            $('#btn_itemCheckout').prop('disabled', true);
            $('#btn_itemRenew').prop('disabled', true);
            $('#btn_itemRenewAll').prop('disabled', true);
            $('#btn_itemStatusUpdate').prop('disabled', true);
            break;
    };

    return true;
}
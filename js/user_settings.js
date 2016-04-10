function testConfig() {
    // Test config
    $("input[name='sip2[property][hostname]']").val('sip2.myserver.de');
    $("input[name='sip2[property][port]']").val('1290');
    $("input[name='sip2[property][socket_tls_enable]']").prop('checked', false);
    $("input[name='sip2[parameter][use_gossip]']").prop('checked', false);
    $("input[name='sip2[property][socket_timeout]']").val('2');
    $('#hide_server_settings').click();

    $("input[name='sip2[parameter][sipLogin]']").val('1234');
    $("input[name='sip2[parameter][sipPassword]']").val('test123');
    $('#hide_sc_settings').click();

    $("input[name='sip2[parameter][patronId]']").val('08300173390');
    $("input[name='sip2[parameter][patronPass]']").val('123456');

    $("input[name='sip2[parameter][itemID]']").val('830$24590745');

    $("input[name='sip2[parameter][feeType]']").val('01');
}
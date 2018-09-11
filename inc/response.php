<?php
//error_reporting(0);
//ini_set('display_errors','Off');

//require('vendor/autoload.php');
require('vendor/tzeumer/Sip2Wrapper/Sip2Wrapper.php');
require('vendor/tzeumer/Sip2Wrapper/Gossip.class.php');

// BEGIN -- Start session
session_name('SIP2_TEST_TOOL');
session_start();

$autoconnect = ($_POST['sip2cmd'] == 'disconnect') ? false : true;
$autoconnect =false;

if (isset($_SESSION['sip2'])) {
    $sip2 =& $_SESSION['sip2'];
    $message = 'Reused object!';
} else {
    $message = 'Created new object - grmpf!';
    // set some default options (for (NOW)
    $option =array(
                'withCrc' => true,
                'language' => '001',

                'socket_tls_enable' => true,
                'socket_tls_options' => array(
                    'verify_peer'               => true,
                    'verify_peer_name'          => true,
                    'allow_self_signed'         => true,
                    'ciphers'                   => 'HIGH:!SSLv2',
                    'capture_peer_cert'         => true,
                    'capture_peer_cert_chain'   => true,
                    'disable_compression'       => true
                ),

                'maxretry' => 0,
                'debug' => false
              );
    $version = ($_POST['sip2']['parameter']['use_gossip']) ? 'Gossip' : 'Sip2';

    $sip2 = new Sip2Wrapper($option, $autoconnect, $version);
    // Track changes to sip2 object in session
    $_SESSION['sip2'] =& $sip2;
}
// END -- Start session


// BEGIN -- Ajax processing
if (is_ajax()) {
    //Reset Log for each request
    $sip2->sip2->log = '';
    $cmd_result = true;

    if (isset($_POST['sip2'])) {
        // No command received
        if (!isset($_POST['sip2cmd'])) {
            // Return status and stuff
        	$return['status']  = 'Failure';
            $return['msg']      = 'No SIP2 command given';
            $return['log']      = '';
            $return['cmd']      = '';
            $return['data']     = '';
            $return['data_all'] = '';
            echo json_encode($return);
            exit;
        }

        // Map all form 'properties' as SIP2Wrapper properties
        if (isset($_POST['sip2']['property'])) {
            $status = map_form_to_object($_POST['sip2']['property']);
        }

        // For now we kill everything on a disconnect
        // Remember: SIP2Wrapper would be ok without killing object and session
        if ($_POST['sip2cmd'] == 'disconnect') {
            // Disconnect from server
            $sip2->disconnect();
            // Kill object and session
            unset($_SESSION['sip2']);
            unset($sip2);
            // kill session
            session_destroy();

            // Return status and stuff
            $log = date('Y-m-d H:i:s')." - No SIP2 object (connection terminated)\n";
        	$return['status']  = 'success';
            $return['msg']      = 'Command worked fine. '.$message;
            $return['log']      = json_encode($log);
            $return['cmd']      = 'Your command was: '.$_POST['sip2cmd'];
            $return['data']     = '';
            $return['data_all'] = '';
        }
        // otherwise, run the command
        else {
            $function   = $_POST['sip2cmd'];
            $parameters = (isset($_POST['sip2']['parameter'])) ? $_POST['sip2']['parameter'] : array();
            $cmd_result = call_user_func_array(array($sip2, $function), $parameters);
            // Also get the full result
            $sip2reponse = $sip2->getSip2_parsedResult();
        }

        $status = ($cmd_result !== false) ? 'success' : 'failure';
        // Return status and stuff
    	$return['status']  = $status;
        $return['msg']      = 'Command worked fine. '.$message;
        $return['log']      = (isset($sip2)) ? json_encode($sip2->sip2->log) : json_encode($log);
        $return['cmd']      = 'Your command was: '.$_POST['sip2cmd'];
        $return['data']     = json_encode($cmd_result);
        $return['data_all'] = (isset($sip2reponse)) ? json_encode($sip2reponse) : '';
    }
    else {
    	$return['status']  = 'failure';
        $return['msg']      = 'Nothing was send.';
        $return['log']      = '';
        $return['cmd']      = '';
        $return['data']     = '';
        $return['data_all'] = '';
    }

    echo json_encode($return);
    exit;
} else {
    die('Ajax requests only');
}
// END -- Ajax processing


/**
 * @brief   Map form variables to class properties
 */
function map_form_to_object($properties) {
    global $sip2;

    foreach ($properties as $propertyName => $propertyVal) {
        if (property_exists($sip2->sip2, $propertyName)) {
            $sip2->sip2->{$propertyName} = $propertyVal;
        }
    }
    return true;
}

/**
 * @brief   Helper function to check if the request is an AJAX request
 */
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
// END Ajax Save





?>
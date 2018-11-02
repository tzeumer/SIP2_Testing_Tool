<?php
/*
todo
- automatically add
    > data-toggle="help_hostname"   TO input fields with aria-describedby
    > data-dropdown data-hover="true" data-hover-pane="true"    TO dropdown-pane help-text

@note: Nearly everything from the SIP2 protocol definition is included in these
       form. Only patronBlock(), patronEnable(), hold() are missing.
*/
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html lang="en" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SIP2 Testing Tool</title>
        <link rel="stylesheet" href="js/vendor/foundation-sites/dist/foundation.min.css" />
        <link rel="stylesheet" href="css/local.css" />
    </head>
<body>

<!-- Navigation -->
<nav>
    <div class="top-bar">
        <div class="top-bar-title"><a href="index.php"><img src="img/logo.jpg" alt="SIP2 Testing Tool with Gossip Extension (Logo)" /></a></div>
        <div class="top-bar-left">
            <ul class="dropdown menu" data-dropdown-menu>
            <!-- Probaly add something to load/save configs etc.
                <li>
                <a href="#">Later</a>
                <ul class="menu vertical">
                    <li><a href="#">One</a></li>
                    <li><a href="#">Two</a></li>
                </ul>
                </li>
                <li>x</li>
            -->
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="menu">
                <li><a data-open="about">About</a></li>
                <!-- Hmm, what could be searched?
                <li><input type="search" placeholder="Search"></li>
                <li><button type="button" class="button">Search</button></li>
                -->
            </ul>
        </div>
    </div>
</nav>
<!-- End Navigation -->

<!-- Asides (modals and offscreen content) -->
<aside>
    <!-- About page -->
    <div class="reveal" id="about" data-reveal>
        <h1>SIP2 Testing Tool</h1>
        <p class="lead">With Gossip Extension.</p>
        <p>Not much "about" for now. Based on the <a href="https://github.com/tzeumer/Sip2Wrapper">Sip2Wrapper with Gossip support</a> by Tobias Zeumer which is based on the <a href="https://github.com/nathanejohnson/Sip2Wrapper">Sip2Wrapper</a> by Nathane Johnson.</p>
        <p>Just insert you information. Then (1) Connect Sever, (2) Connect Device, (3) Login Patron</p>
        <p>Currently there is no way to save a config. But you can edit js/user_settings.js for a little convenience</p>
        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- End About -->
</aside>
<!-- end Asides -->

<!-- Header -->
<header class="expanded row">
    <div class="small-12 columns"></div>
</header>
<!-- End Header -->

<!-- Main body -->
<main class="expanded row">
    <div id="connection_forms" class="expanded row">
        <!-- start CONNECTION FORM -->
        <form id="form_connect_srv" class="small-12 columns">
            <!-- start SERVER SETTINGS -->
            <fieldset>
                <legend class="small-12 columns">Automatic Circulation System (ACS) Server Settings</legend>
                <div class="small-4 columns">
                    <div class="input-group">
                        <span class="input-group-label">Server Name</span>
                        <input name="sip2[property][hostname]" class="input-group-field" type="text" placeholder="Server Name" aria-describedby="help_hostname" data-toggle="help_hostname">
                        <span id="help_hostname" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Name of server. Without TLS it might be an IP.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Port</span>
                        <input name="sip2[property][port]" class="input-group-field" type="text" aria-describedby="help_port" data-toggle="help_port">
                        <span id="help_port" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">SIP2 port of server.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Enable TLS</span>&nbsp;
                        <input name="sip2[property][socket_tls_enable]" class="input-group-field" type="checkbox" aria-describedby="help_socket_tls_enable" data-toggle="help_socket_tls_enable">
                        <span id="help_socket_tls_enable" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Enable encrypted connection.</span>
                    </div>
                </div>
                <div class="small-2 columns end">
                    <div class="input-group">
                        <span class="input-group-label">Gossip extension</span>&nbsp;
                        <input name="sip2[parameter][use_gossip]" class="input-group-field" type="checkbox" value="Gossip" aria-describedby="help_version" data-toggle="help_version">
                        <span id="help_version" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Use Gossip instead of regular SIP2.</span>
                    </div>
                </div>
            </fieldset>
            <!-- end   SERVER SETTINGS -->
            <!-- start CUSTOM SETTINGS -->
            <fieldset>
                <legend class="small-12 columns">Custom settings</legend>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Timeout</span>
                        <input name="sip2[property][socket_timeout]" class="input-group-field" type="number" value="5" aria-describedby="help_socket_timeout" data-toggle="help_socket_timeout">
                        <span id="help_socket_timeout" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Time before next retry is started. Note: usually a response only takes milliseconds.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Max Retries</span>
                        <input name="sip2[property][maxretry]" class="input-group-field" type="number" value="0" aria-describedby="help_maxretry" data-toggle="help_maxretry">
                        <span id="help_maxretry" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Maximum times a message is resend if server does not answer. Note: retries are most likely very useless. Either the server responds to a correct message or it probably won't for a retry neither.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">CRC</span>&nbsp;
                        <input name="sip2[property][withCrc]" class="input-group-field" type="checkbox" checked="checked" aria-describedby="help_withCrc" data-toggle="help_withCrc">
                        <span id="help_withCrc" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">In times of TCP pretty useless kind of check if a message was transmitted correctly. Still has to be set if set on server.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Seq. Numbers</span>&nbsp;
                        <input name="sip2[property][withSeq]" class="input-group-field" type="checkbox" checked="checked" aria-describedby="help_withSeq" data-toggle="help_withSeq">
                        <span id="help_withSeq" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Ensures that no message was lost.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Field Terminator</span>
                        <input name="sip2[property][fldTerminator]" class="input-group-field" type="text" value="|" disabled="disabled" aria-describedby="help_fldTerminator" data-toggle="help_fldTerminator">
                        <span id="help_fldTerminator" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Separator between message fields. Probably always '|'.</span>
                    </div>
                </div>
                <div class="small-2 columns end">
                    <div class="input-group">
                        <span class="input-group-label">Message Terminator</span>
                        <input name="sip2[property][msgTerminator]" class="input-group-field" type="text" value="\r" disabled="disabled" aria-describedby="help_msgTerminator" data-toggle="help_msgTerminator">
                        <span id="help_msgTerminator" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Should most likely always be \r (or \x0D).</span>
                    </div>
                </div>
            </fieldset>
            <!-- end CUSTOM SETTINGS -->

            <div>
                <div class="small-12 columns">
                    <button class="button small cmdDefWidth sip2cmd" id="btn_server_connect" value="connect">Connect Server</button>
                    <button class="button small cmdDefWidth sip2cmd" id="btn_server_disconnect" value="disconnect">Disconnect Server</button>
                    <button class="button small sip2cmd" id="btn_server_disconnect2" value="disconnect">Kill</button>
                    <button id="hide_server_settings" class="minimize_form button small secondary">Hide form</button>
                </div>
            </div>
        </form>
        <!-- end CONNECTION FORM -->

        <!-- start SC LOGIN -->
        <form id="form_connect_sc" class="small-12 columns">
            <fieldset>
                <legend class="small-12 columns">SelfCheck (SC) device login</legend>
                <div class="small-3 columns">
                    <div class="input-group">
                        <span class="input-group-label">SC User</span>
                        <input name="sip2[parameter][sipLogin]" class="input-group-field" type="text" aria-describedby="help_sipLogin" data-toggle="help_sipLogin">
                        <span id="help_sipLogin" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">The user id for the SC to use to login to the ACS. It is possible for this field to be encrypted; see the UID algorithm field’s definition.</span>
                    </div>
                </div>
                <div class="small-3 columns">
                    <div class="input-group">
                        <span class="input-group-label">SC Password</span>
                        <input name="sip2[parameter][sipPassword]" class="input-group-field" type="password" aria-describedby="help_sipPassword" data-toggle="help_sipPassword">
                        <span id="help_sipPassword" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">The password for the SC to use to login to the ACS. It is possible for this field to be encrypted; see the PWD algorithm field’s definition.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">Location</span>
                        <input name="sip2[property][scLocation]" class="input-group-field" type="text" aria-describedby="help_scLocation" data-toggle="help_scLocation">
                        <span id="help_scLocation" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">the Location code of the SC unit. This code will be configurable on the SC.</span>
                    </div>
                </div>
                <div class="small-2 columns">
                    <div class="input-group">
                        <span class="input-group-label">UID Algorithm</span>
                        <input name="sip2[property][UIDalgorithm]" class="input-group-field" type="number" value="0" disabled="disabled" aria-describedby="help_UIDalgorithm" data-toggle="help_UIDalgorithm">
                        <span id="help_UIDalgorithm" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Specifies the algorithm, if any, used to encrypt the login user id field of the Login Message. 0 means the login user id is not encrypted. The SC and the ACS must agree on an algorithm to use and must agree on the value to be used in this field to represent that
    algorithm. Few, if any, systems will want to encrypt the user id. (0 = plain text).</span>
                    </div>
                </div>
                <div class="small-2 columns end">
                    <div class="input-group">
                        <span class="input-group-label">PWD Algorithm</span>
                        <input name="sip2[property][PWDalgorithm]" class="input-group-field" type="number" value="0" disabled="disabled" aria-describedby="help_PWDalgorithm" data-toggle="help_PWDalgorithm">
                        <span id="help_PWDalgorithm" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Specifies the algorithm, if any, used to encrypt the login password field of the Login Message. ‘0’ means the login password is not encrypted. The SC and the ACS must agree on an algorithm to use and must agree on the value to be used in this field to represent that algorithm.</span>
                    </div>
                </div>
            </fieldset>

            <div>
                <div class="small-12 columns">
                    <button class="button small cmdDefWidth sip2cmd" id="btn_device_connect" disabled="disabled" value="login">Connect Device</button>
                    <button class="button small cmdDefWidth sip2cmd" id="btn_getAcsStatus" disabled="disabled" value="getAcsStatus">Get ACS Status</button>
                    <button id="hide_sc_settings" class="minimize_form button small secondary">Hide form</button>
                    <!-- NOTE: Skipping manual msgSCStatus for now - do the automatic one with default values to get ACS status -->
                </div>
            </div>
        </form>
        <!-- end SC LOGIN -->
    </div>

    <hr />

    <div id="responses">
        <div class="small-6 columns" id="logwindow">
            <pre>Hello<br></pre>
        </div>
        <div class="small-6 columns" id="readable">
            <pre>Readable
            </pre>
        </div>
        <div class="small-12 columns" id="screen_message">
            <pre> </pre>
        </div>
    </div>

    <hr />

    <div id="action_area" class="expanded row" data-equalizer>
        <!-- start PATRON LOGIN -->
        <form id="form_patronConnect" class="small-3 columns" data-equalizer-watch>
            <fieldset>
                <legend>Patron login</legend>
                <div class="input-group">
                    <span class="input-group-label">Patron ID</span>
                    <input id="patronID" name="sip2[parameter][patronId]" class="input-group-field" type="text" aria-describedby="help_patronId" data-toggle="help_patronId">
                    <span id="help_patronId" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">An identifying value for the patron.</span>
                </div>
                <div class="input-group">
                    <span class="input-group-label">Patron Pass</span>
                    <input name="sip2[parameter][patronPass]" class="input-group-field" type="password" aria-describedby="help_patronPass" data-toggle="help_patronPass">
                    <span id="help_patronPass" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">If the ACS stores the patron password in its database then the SC will prompt the patron for their password (PIN) and it will be sent to the ACS in this field. If this feature is not used by the ACS in the library then the field should be zero length if it is required in the command, and can be omitted entirely if the field is optional in the command.</span>
                </div>
                <div class="input-group">
                    <span class="input-group-label">Terminal Pass</span>
                    <input name="sip2[property][ac]" class="input-group-field" type="password" aria-describedby="help_ac" data-toggle="help_ac">
                    <span id="help_ac" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This is the password for the SC unit. If this feature is not used by the ACS in the library then the field should be zero length if it is required in the command, and can be omitted entirely if the field is optional in the command.</span>
                </div>
            </fieldset>

            <div>
                <button class="button small cmdDefWidth sip2cmd" id="btn_startPatronSession" disabled="disabled" value="startPatronSession">Login patron</button>
                <button class="button small cmdDefWidth sip2cmd" id="btn_endPatronSession" disabled="disabled" value="endPatronSession">Logout patron</button>
                <button class="button small cmdDefWidth sip2cmd" id="btn_getPatronScreenMessages" value="getPatronScreenMessages">Screen message</button>
            </div>
        </form>
        <!-- end PATRON LOGIN -->

        <div id="patronAction" class="small-3 columns" data-equalizer-watch>
            <!-- start PATRON INFO -->
            <div>
                <form id="form_patronInfo" class="small-12 columns">
                    <fieldset>
                        <legend>Patron Information</legend>
                        <div class="input-group">
                            <span class="input-group-label">Language</span>
                            <select name="sip2[property][language]" class="input-group-field" aria-describedby="help_language" data-toggle="help_language">
                                <option value="000">Server default</option>
                                <option value="001">English</option>
                                <option value="002">French</option>
                                <option value="003">German</option>
                            </select>
                            <span id="help_language" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">The ACS may use this field’s information to format screen and print messages in the language as requested by the Patron. Code 000 in this field means the language is not specified.</span>
                        </div>
                    </fieldset>
                    <div>
                        <button class="button small sip2cmd btnGetPatron" id="btn_fetchPatronInfo" value="fetchPatronInfo" disabled="disabled">Info</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronHoldItems"value="getPatronHoldItems" disabled="disabled">Hold</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronOverdueItems" value="getPatronOverdueItems" disabled="disabled">Overdue</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronChargedItems" value="getPatronChargedItems" disabled="disabled">Charged</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronFineItems" value="getPatronFineItems" disabled="disabled">Fines</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronRecallItems" value="getPatronRecallItems" disabled="disabled">Recall</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronUnavailableItems" value="getPatronUnavailableItems" disabled="disabled">Unav.</button>
                        <button class="button small sip2cmd btnGetPatron" id="btn_getPatronFeeItems" value="getPatronFeeItems" disabled="disabled">Fee list</button>
                    </div>
        <!--
                $summary['none']     = '       '; Info
                $summary['hold']     = 'Y      '; Hold
                $summary['overdue']  = ' Y     '; Overdue
                $summary['charged']  = '  Y    '; Charged
                $summary['fine']     = '   Y   '; Fines (items)
                $summary['recall']   = '    Y  '; Recall
                $summary['unavail']  = '     Y '; Unavailable
                $summary['feeItems'] = '      Y'; GOSSIP
        -->
                </form>
            </div>
            <!-- end PATRON INFO -->

            <!-- start PAYMENT -->
            <div>
                <form id="form_payment" class="small-12 columns">
                    <fieldset>
                        <legend>Payment</legend>
                        <div>
                            <button class="button small cmdDefWidth cmdDefWidth cmdDefWidth cmdDefWidth cmdDefWidth cmdDefWidth sip2cmd" id="btn_feePay" value="feePay" disabled="disabled">Pay fee(s)</button> <button class="form_more_options button small secondary">More options</button>
                        </div>
<!-- No payment without login for now... Needs easy way to set property
                        <div id="noLoginFee" class="input-group btnGetPatron">
                            <span class="input-group-label">Patron ID</span>
                            <input id="patronID_pay" name="sip2[property][patronId]" class="input-group-field" type="text" aria-describedby="help_patronId" data-toggle="help_patronId">
                            <span id="help_patronId" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">An identifying value for the patron.</span>
                        </div>
-->
                        <div class="input-group more_options">
                            <span class="input-group-label">Fee Type</span>
                            <input name="sip2[parameter][feeType]" class="input-group-field" type="text" aria-describedby="help_feeType" data-toggle="help_feeType">
                            <span id="help_feeType" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">2-char, fixed-length field. Enumerated type of fee. Note: Gossip ignores this; anyway it might be good to use FE from the fee list.</span>
                        </div>
                        <div class="input-group more_options">
                            <span class="input-group-label">Payment type</span>
                            <select name="sip2[parameter][pmtType]" class="input-group-field" aria-describedby="help_pmtType" data-toggle="help_pmtType">
                                <option value="00">Cash</option>
                                <option value="01">VISA</option>
                                <option value="02">Credit Card</option>
                            </select>
                            <span id="help_pmtType" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">An enumerated value for the type of payment, from the following table: 00 cash / 01 VISA / 02 credit card</span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-label">Amount</span>
                            <input name="sip2[parameter][pmtAmount]" class="input-group-field" type="text" aria-describedby="help_pmtAmount" data-toggle="help_pmtAmount">
                            <span id="help_pmtAmount" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This contains a money amount in whatever currency type is specified by the currency type field of the same message. (Always use dot as decimal separator)</span>
                        </div>
                        <div class="input-group more_options">
                            <span class="input-group-label">Currency type</span>
                            <select name="sip2[parameter][curType]" class="input-group-field" aria-describedby="help_curType" data-toggle="help_curType">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                            <span id="help_curType" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">The value for currency type follows ISO Standard 4217:1995, using the 3-character alphabetic code part of the standard. Gossip supports only EUR.</span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-label">Fee identifier</span>
                            <input name="sip2[parameter][feeId]" class="input-group-field" type="text" aria-describedby="help_feeId" data-toggle="help_feeId">
                            <span id="help_feeId" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Identifies a specific fee, possibly in combination with fee type. This identifier would have to be user-selected from a list of fees. (Gossip: first use fee list and select an CG-id, use the right amount to only pay this position. Leave empty to pay whole or partial - if enabled in Gossip - fee sum).</span>
                        </div>
                        <div class="input-group more_options">
                            <span class="input-group-label">Transaction id</span>
                            <input name="sip2[parameter][transId]" class="input-group-field" type="text" aria-describedby="help_transId" data-toggle="help_transId">
                            <span id="help_transId" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">A transaction id assigned by the payment device. (ACS/Gossip returns it own additional id)</span>
                        </div>
                    </fieldset>
                </form>
            </div>
            <!-- end PAYMENT -->
        </div>



        <!-- start CIRCULATION -->
        <div id="circualtion" class="small-6 columns" data-equalizer-watch>
            <!-- start ITEM INFO -->
            <div>
                <form id="form_itemInfo" class="small-12 columns">
                    <fieldset>
                        <legend>Item Info</legend>
                        <div class="input-group">
                            <span class="input-group-label">Item ID</span>
                            <input id="itemID" name="sip2[parameter][itemID]" class="input-group-field" type="text" aria-describedby="help_itemID" data-toggle="help_itemID">
                            <span id="help_itemID" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">The article bar-code. This information is needed by the SC to verify that the article that was checked in matches the article bar-code at the SC.</span>
                            <div class="input-group-button">
                                <button class="button sip2cmd" id="btn_itemGetInformation" value="itemGetInformation" disabled="disabled">GetItemInfo</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <!-- end ITEM INFO -->
            </div>

            <div data-equalizer-watch>
                <!-- start LEFT ROW BELOW BARCODE -->
                <div  class="small-6 columns">
                    <!-- start ITEM CHECKOUT -->
                    <form id="form_itemCheckout">
                        <fieldset>
                            <legend>Item Checkout</legend>
                            <div>
                                <button class="button small cmdDefWidth sip2cmd" id="btn_itemCheckout" value="itemCheckout" disabled="disabled">Checkout Item</button> <button class="form_more_options button small secondary">More options</button>
                            </div>
                            <input id="itemID_checkout" name="sip2[parameter][itemID]" class="input-group-field" type="hidden">
                            <div class="input-group more_options">
                                <span class="input-group-label">Item Properties</span>
                                <input name="sip2[parameter][itmProp]" class="input-group-field" type="text" aria-describedby="help_itmProp" data-toggle="help_itmProp">
                                <span id="help_itmProp" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field may contain specific item information that can be used for identifying a item, such as item weight, size, security marker, etc. It may possibly used for security reasons. ACSs are encouraged to store this information in their database.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Fee Acknowledged</span>
                                <select name="sip2[parameter][fee]" class="input-group-field" aria-describedby="help_fee" data-toggle="help_fee">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                    <option value=""> </option>
                                </select>
                                <span id="help_fee" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">If this field is N in a Checkout message and there is a fee associated with checking out the item, the ACS should tell the SC in the Checkout Response that there is a fee, and refuse to check out the item. If the SC and the patron then interact and the patron agrees to pay the fee, this field will be set to Y on a second Checkout message.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block</span>
                                <select name="sip2[parameter][noBlock]" class="input-group-field" aria-describedby="help_noBlock" data-toggle="help_noBlock">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                                <span id="help_noBlock" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field notifies the ACS that the article was already checked in or out while the ACS was not on-line. When this field is Y, the ACS should not block this transaction because it has already been executed. The SC can perform transactions while the ACS is off-line. These transactions are stored and will be sent to the ACS when it comes back on-line.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block Due Date</span>
                                <input name="sip2[parameter][nbDateDue]" class="input-group-field" type="text" aria-describedby="help_nbDateDue" data-toggle="help_nbDateDue">
                                <span id="help_nbDateDue" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">YYYYMMDDZZZZHHMMSS. This is the no block due date that articles were given during off-line (store and forward) operation.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">SC renewal policy</span>
                                <select name="sip2[parameter][scRenewal]" class="input-group-field" aria-describedby="help_scRenewal" data-toggle="help_scRenewal">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                                <span id="help_scRenewal" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">If this field contains a 'Y ' then the SC has been configured by the library staff to do renewals. ‘N’ means the SC has been configured to not do renewals.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Cancel</span>
                                <select name="sip2[parameter][cancel]" class="input-group-field" aria-describedby="help_cancel" data-toggle="help_cancel">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                    <option value=""> </option>
                                </select>
                                <span id="help_cancel" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field should be set to Y for a Checkout command being used to cancel a failed Checkin command, or for a Checkin command being used to cancel a failed Checkout command. It should be set to N for all other Checkout or Checkin commands.</span>
                            </div>
                        </fieldset>
                    </form>
                    <!-- end ITEM CHECKOUT -->

                    <!-- start RENEW ALL -->
                    <form id="form_itemRenewAll">
                        <fieldset>
                            <legend>Renew all items</legend>
                            <div>
                                <button class="button small cmdDefWidth sip2cmd" id="btn_itemRenewAll" value="itemRenewAll" disabled="disabled">Renew All Items</button> <button class="form_more_options button small secondary">More options</button>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Fee Acknowledged</span>
                                <select name="sip2[parameter][fee]" class="input-group-field" aria-describedby="help_fee2" data-toggle="help_fee2">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                    <option value=""> </option>
                                </select>
                                <span id="help_fee2" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">If this field is N in a Checkout message and there is a fee associated with checking out the item, the ACS should tell the SC in the Checkout Response that there is a fee, and refuse to check out the item. If the SC and the patron then interact and the patron agrees to pay the fee, this field will be set to Y on a second Checkout message.</span>
                            </div>
                        </fieldset>
                    </form>
                    <!-- end RENEW ALL -->
                </div>
                <!-- end LEFT ROW BELOW BARCODE -->

                <!-- start RIGHT ROW BELOW BARCODE -->
                <div  class="small-6 columns">
                    <!-- start ITEM CHECKIN -->
                    <form id="form_itemCheckin">
                        <fieldset>
                            <legend>Item Checkin</legend>
                            <div>
                                <button class="button small cmdDefWidth sip2cmd" id="btn_itemCheckin" value="itemCheckin" disabled="disabled">Checkin Item</button> <button class="form_more_options button small secondary">More options</button>
                            </div>
                            <input id="itemID_checkin" name="sip2[parameter][itemID]" class="input-group-field hidden" type="hidden">
                            <div class="input-group more_options">
                                <span class="input-group-label">Return Date</span>
                                <input name="sip2[parameter][itmReturnDate]" class="input-group-field" type="text" aria-describedby="help_itmReturnDate" data-toggle="help_itmReturnDate">
                                <span id="help_itmReturnDate" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">YYYYMMDDZZZZHHMMSS. The date that an item was returned to the library, which is not necessarily the same date that the item was checked back in. NOTE: Use timestamp here for now.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Item Location</span>
                                <input name="sip2[parameter][itmLocation]" class="input-group-field" type="text" aria-describedby="help_itmLocation" data-toggle="help_itmLocation">
                                <span id="help_itmLocation" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">the current location of the item. 3M SelfCheck system software could set this field to the value of the 3M SelfCheck system terminal location on a Checkin message.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Item Properties</span>
                                <input name="sip2[parameter][itmProp]" class="input-group-field" type="text" aria-describedby="help_itmProp" data-toggle="help_itmProp">
                                <span id="help_itmProp" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field may contain specific item information that can be used for identifying a item, such as item weight, size, security marker, etc. It may possibly used for security reasons. ACSs are encouraged to store this information in their database.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block</span>
                                <select name="sip2[parameter][noBlock]" class="input-group-field" aria-describedby="help_noBlock" data-toggle="help_noBlock">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                                <span id="help_noBlock" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field notifies the ACS that the article was already checked in or out while the ACS was not on-line. When this field is Y, the ACS should not block this transaction because it has already been executed. The SC can perform transactions while the ACS is off-line. These transactions are stored and will be sent to the ACS when it comes back on-line.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block Due Date</span>
                                <input name="sip2[parameter][nbDateDue]" class="input-group-field" type="text" aria-describedby="help_nbDateDue" data-toggle="help_nbDateDue">
                                <span id="help_nbDateDue" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">YYYYMMDDZZZZHHMMSS. This is the no block due date that articles were given during off-line (store and forward) operation.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Cancel</span>
                                <select name="sip2[parameter][cancel]" class="input-group-field" aria-describedby="help_cancel" data-toggle="help_cancel">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                    <option value=""> </option>
                                </select>
                                <span id="help_cancel" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field should be set to Y for a Checkout command being used to cancel a failed Checkin command, or for a Checkin command being used to cancel a failed Checkout command. It should be set to N for all other Checkout or Checkin commands.</span>
                            </div>
                        </fieldset>
                    </form>
                    <!-- end ITEM CHECKIN -->

                    <!-- start ITEM RENEWS -->
                    <form id="form_itemRenew">
                        <fieldset>
                            <legend>Renew Single Item</legend>
                            <div>
                                <button class="button small cmdDefWidth sip2cmd" id="btn_itemRenew" value="itemRenew" disabled="disabled">Renew Item</button> <button class="form_more_options button small secondary">More options</button>
                            </div>
                            <input id="itemID_renew" name="sip2[parameter][itemID]" class="input-group-field" type="hidden">
                            <div class="input-group more_options">
                                <span class="input-group-label">Title Identifier</span>
                                <input name="sip2[parameter][title]" class="input-group-field" type="text" aria-describedby="help_title" data-toggle="help_title">
                                <span id="help_title" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Identifies a title; could be a bibliographic number or a title string.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Item Properties</span>
                                <input name="sip2[parameter][itmProp]" class="input-group-field" type="text" aria-describedby="help_itmProp2" data-toggle="help_itmProp2">
                                <span id="help_itmProp2" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field may contain specific item information that can be used for identifying a item, such as item weight, size, security marker, etc. It may possibly used for security reasons. ACSs are encouraged to store this information in their database.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Fee Acknowledged</span>
                                <select name="sip2[parameter][fee]" class="input-group-field" aria-describedby="help_fee3" data-toggle="help_fee3">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                    <option value=""> </option>
                                </select>
                                <span id="help_fee3" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">If this field is N in a Checkout message and there is a fee associated with checking out the item, the ACS should tell the SC in the Checkout Response that there is a fee, and refuse to check out the item. If the SC and the patron then interact and the patron agrees to pay the fee, this field will be set to Y on a second Checkout message.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block</span>
                                <select name="sip2[parameter][noBlock]" class="input-group-field" aria-describedby="help_noBlock2" data-toggle="help_noBlock2">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                                <span id="help_noBlock2" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field notifies the ACS that the article was already checked in or out while the ACS was not on-line. When this field is Y, the ACS should not block this transaction because it has already been executed. The SC can perform transactions while the ACS is off-line. These transactions are stored and will be sent to the ACS when it comes back on-line.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">No Block Due Date</span>
                                <input name="sip2[parameter][nbDateDue]" class="input-group-field" type="text" aria-describedby="help_nbDateDue2" data-toggle="help_nbDateDue2">
                                <span id="help_nbDateDue2" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">YYYYMMDDZZZZHHMMSS. This is the no block due date that articles were given during off-line (store and forward) operation.</span>
                            </div>
                            <div class="input-group more_options">
                                <span class="input-group-label">Third Party</span>
                                <select name="sip2[parameter][thirdParty]" class="input-group-field" aria-describedby="help_thirdParty" data-toggle="help_thirdParty">
                                    <option value="N">No</option>
                                    <option value="Y">Yes</option>
                                </select>
                                <span id="help_thirdParty" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">Y or N. If this field contains an 'N ' then the ACS should not allow third party renewals. This allows the library staff to prevent third party renewals from this terminal.</span>
                            </div>
                        </fieldset>
                    </form>
                    <!-- end ITEM RENEWS -->

                    <!-- start ITEM STATUS UPDATE -->
                    <form id="form_itemStatusUpdate">
                        <fieldset>
                            <legend>Update Item Status</legend>
                            <div>
                                <button class="button small cmdDefWidth sip2cmd" id="btn_itemStatusUpdate" value="itemStatusUpdate" disabled="disabled">Update Item</button> <button class="form_more_options button small secondary">More options</button>
                            </div>
                            <input id="itemID_statusUpdate" name="sip2[parameter][itemID]" class="input-group-field" type="hidden">
                            <div class="input-group more_options">
                                <span class="input-group-label">Item Properties</span>
                                <input name="sip2[parameter][itmProp]" class="input-group-field" type="text" aria-describedby="help_itmProp3" data-toggle="help_itmProp3">
                                <span id="help_itmProp3" class="dropdown-pane help-text" data-dropdown data-hover="true" data-hover-pane="true">This field may contain specific item information that can be used for identifying a item, such as item weight, size, security marker, etc. It may possibly used for security reasons. ACSs are encouraged to store this information in their database.</span>
                            </div>
                        </fieldset>
                    </form>
                    <!-- end ITEM STATUS UPDATE -->

                </div>
                <!-- end RIGHT ROW BELOW BARCODE -->

            </div>
        </div>
        <!-- end CIRCULATION -->

    </div>
</main>
<!-- End main body -->

<!-- Footer --
<footer style="visibility:hidden;">
    <!-- Footer that is hidden before 'sticky' is ready and appears at the bottom of the page onload -- >
    <div class="row">
        <div class="small-12 columns">
            <p><em>SIP2 Testing Tool</em> (c) 2016 Gott und die Welt</p>
        </div>
    </div>
</footer>
< !-- End Footer -->

<!-- Basic vendor scripts -->
<script src="js/vendor/jquery/dist/jquery.min.js"></script>
<script src="js/vendor/what-input/what-input.min.js"></script>
<script src="js/vendor/foundation-sites/dist/foundation.min.js"></script>
<script src="js/vendor/foundation-sites/js/foundation.dropdown.js"></script>

<!-- Special purpose vendor scripts -->
<!-- script src="js/vendor/foundationStickyFooter/stickyFooter.js"></script -->
<script src="js/vendor/JQuerySerializeCheckbox/index.js"></script>

<!-- Local scripts -->
<script src="js/common.js"></script>
<script src="js/user_settings.js"></script>
<script src="js/sip2.js"></script>

</body>
</html>
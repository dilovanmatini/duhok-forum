<?php

/*//////////////////////////////////////////////////////////
// ######################################################///
// # Duhok Forum 2.0                                    # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #  === Programmed & developed by Dilovan Matini ===  # //
// # Copyright © 2007-2020 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # Website: github.com/dilovanmatini/duhok-forum      # //
// # Email: df@lelav.com                                # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

// denying calling this file without landing files.
defined('_df_script') or exit();

$df_config = [];

// Database Configuration
$df_config['database'] = [
    'host' => 'localhost',                      // database host name or host IP address
    'name' => 'duhokforum_db',                  // datebase name
    'user' => 'root',                           // database user name
    'pass' => '0000',                           // datebase user's password
    'prefix' => 'df_',                          // prefix of database's tables
    'port' => 3306                              // datebase port. don't change the port if have not changed the datebase port in your server.
];

// Global Configuration
$df_config['global'] = [
    'local' => true,                            // defining the script environment, whether it is running online or in localhost. TRUE means localhost, FALSE means online.
    'timezone' => 'GMT'                         // defining timezone. the supported timezones are listed here: https://www.php.net/manual/en/timezones.php
];

// Cookie Configuration
$df_config['cookie'] = [
    'prefix' => "df_", 				            // adding prefix to all cookies names. for example, if you set "df_", all cookies names become df_cookiename
    'expire' => 365, 				            // login's remember expire in days.
    'path' => "/", 					            // the path on the server which cookie will be available on it. if you set '/', cookie will be available within the entire domain. if you set '/foo/', the cookie will only be available within the /foo/ directory and all sub-directories such as /foo/bar/ of domain.
    'domain' => '', 				            // the domain that the cookie is available on it.
    'secure' => false, 				            // if it is TRUE, cookie will only be sent over secure connections.
    'httponly' => false 			            // if it is TRUE, PHP will attempt to send the httponly, This means that the cookie won't be accessible by scripting languages, such as JavaScript. This setting can effectively help to reduce identity theft through XSS attacks (although it is not supported by all browsers).
];

// Email Configuration
$df_config['mail'] = [
    'folder' => "folders/PHPMailer/", 		    // PHPMailer library folder.
    'subject' => "Duhok Forum", 			    // Subject of system emails.
    'host' => "",                    		    // the server host.
    'port' => 587,							    // Set the SMTP port number - likely to be 25, 465 or 587
    'smtpauth' => true,
    'smtpautotls' => true,
    'username' => "", 				            // the email address, note: if you don't set email address the messages will not send to inbox. for example, noreply@yourdomain.com
    'password' => ""						    // the password of email address, note: if you don't set password of the email address the messages will not send to inbox.
];

?>
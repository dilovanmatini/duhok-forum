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

define( '__script_version', '2.0' );

// denying calling this file without landing files.
defined('_df_script') or exit();

// denying requests come from curl or other engines, and crawlers.
if(
	!isset($_SERVER['HTTP_USER_AGENT']) || strlen($_SERVER['HTTP_USER_AGENT']) <  30 ||
	!isset($_SERVER['HTTP_CONNECTION']) || strtolower($_SERVER['HTTP_CONNECTION']) != 'keep-alive' ||
	!isset($_SERVER['HTTP_ACCEPT']) || ( stripos( $_SERVER['HTTP_ACCEPT'], "text/html" ) === false && stripos( $_SERVER['HTTP_ACCEPT'], "application/json" ) === false ) ||
	!isset($_SERVER['HTTP_ACCEPT_ENCODING']) || stripos( $_SERVER['HTTP_ACCEPT_ENCODING'], "gzip" ) === false ||
	!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || $_SERVER['HTTP_ACCEPT_LANGUAGE'] == ''
){
	define( "_is_robot", true );
}
else{
	define( "_is_robot", false );
}

// denying the X-Frame-Options HTTP response header wich can be allowed to render a page in a <frame>, <iframe> or <object>
@header( 'X-Frame-Options: Deny' );

error_reporting( E_ALL & ~E_NOTICE );

session_start();

// include globals functions.
require_once _df_path.'includes/func.df.php';

// including and creating global class.
require_once _df_path.'includes/class.df.php';
$DF = new DF();

// including Database class.
require_once _df_path.'includes/class.mysql.pdo.php';
$mysql = new MySQL($DF);
$mysql->connect();

if( _df_script != 'install' ){
    // setting script variable.
    $DF->define_config_table();
    // including script variables.
    require_once _df_path.'includes/var.df.php';

    require_once _df_path.'includes/admin_function.php';

    require_once _df_path.'icons.php';

    require_once _df_path.'converts.php';
}

// define Datetime vars
$datetime_obj = new DateTime('NOW');
define( '_unixtime', 		$datetime_obj->getTimestamp() );
define( '_timestamp', 		$datetime_obj->getTimestamp() );
define( '_tformat', 		'H:i:s' );
define( '_dformat', 		'Y-m-d' );
define( '_dtformat', 		'Y-m-d H:i:s' );
define( '_time', 			$datetime_obj->format(_tformat) );
define( '_time_null', 		'00:00:00' );
define( '_date', 			$datetime_obj->format(_dformat) );
define( '_date_null', 		'0000-00-00' );
define( '_datetime', 		$datetime_obj->format(_dtformat) );
define( '_datetime_null', 	'0000-00-00 00:00:00' );

// get all of date time variables.
preg_match('/([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', _datetime, $matches);
define( '_this_year', 		intval($matches[1]) );
define( '_this_month', 		intval($matches[2]) );
define( '_this_day', 		intval($matches[3]) );
define( '_this_hour', 		intval($matches[4]) );
define( '_this_minute', 	intval($matches[5]) );
define( '_this_second', 	intval($matches[6]) );

// define $_GET variables
define( '_tag', 		$DF->clean($_GET['tag'], CLEAN_NOHTML) );
define( '_type', 		$DF->clean($_GET['type'], CLEAN_NOHTML) );
define( '_mode', 		$DF->clean($_GET['mode'], CLEAN_NOHTML) );
define( '_method', 		$DF->clean($_GET['method'], CLEAN_NOHTML) );
define( '_action', 		$DF->clean($_GET['action'], CLEAN_NOHTML) );
define( '_search', 		intval($_GET['search']) );
define( '_searchfor', 	$DF->clean($_GET['searchfor'], CLEAN_NOHTML ) );
define( '_afterlogin', 	$DF->clean($_GET['afterlogin'], CLEAN_NOHTML ) );
define( '_step', 		$DF->clean($_GET['step'], CLEAN_NOHTML) );
define( '_page', 		intval($_GET['page']) );
define( '_id', 			intval($_GET['id']) );

// define $_SERVER variables
define( '_ip', 			( $_SERVER['REMOTE_ADDR'] == '::1' ) ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'] );
define( '_longip', 		ip2long(_ip) );
define( '_uri', 		$_SERVER['REQUEST_URI'] );
define( '_useragent', 	$_SERVER['HTTP_USER_AGENT'] );

if( _df_script != 'install' ){
    // dm datetime is updated datetime after check system timezone and user timezone
    define( '_df_time', 		$DF->datetime(_tformat) );
    define( '_df_date', 		$DF->datetime(_dformat) );
    define( '_df_datetime', 	$DF->datetime(_dtformat) );
    preg_match( '/([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', _df_datetime, $matches );
    define( '_df_this_year', 	intval($matches[1]) );
    define( '_df_this_month', 	intval($matches[2]) );
    define( '_df_this_day', 	intval($matches[3]) );
    define( '_df_this_hour', 	intval($matches[4]) );
    define( '_df_this_minute', 	intval($matches[5]) );
    define( '_df_this_second', 	intval($matches[6]) );
}

?>
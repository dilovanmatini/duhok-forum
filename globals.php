<?php
/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

define( '_script_version', '3.0' );

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
//@header( 'X-Frame-Options: Deny' );

error_reporting( E_ALL & ~E_NOTICE );

session_start();

define('time', time());
define('rand', mt_rand(1,999999999));

// include globals functions.
require_once _df_path."includes/class.df.php";
$DF = new DF();

// include image functions.
require_once _df_path."includes/class.df.image.php";
$DFImage = new DFImage($DF);
$DF->DFImage = $DFImage;

require_once _df_path."includes/class.mysql.old.php";
require_once _df_path."includes/class.mysql.pdo.php";
$mysql = new MySQL($DF);
$DF->mysql = $mysql;
$mysql->connect();

/************* Include and create template class ****************/
require_once _df_path."includes/class.template.php";
$Template = new Template($DF);
$DF->Template = $Template;
$Template->mysql = $mysql;

require_once _df_path."includes/class.df.output.php";
$DFOutput = new DFOutput( $DF, $mysql );
$DF->DFOutput = $DFOutput;
$Template->DFOutput = $DFOutput;

/************* Include and create browser class ****************/
require_once _df_path."includes/class.browser.php";
$Browser = new Browser($DF);

require_once _df_path.'includes/class.photos.php';
$DFPhotos = new DFPhotos();

require_once _df_path.'includes/class.html.php';
HTML\Elements::$mainDarkColor = '#ddd';

function cmpsort($a,$b){
	global $DF;
	foreach($DF->catch['sortTypeArrays'] as $val){
		$first=$a[$val[0]];
		$last=$b[$val[0]];
		$sort=$val[1];
		if($last>$first){
			return ($sort == 'desc' ? 1 : -1);
		}
		elseif($first>$last){
			return ($sort == 'desc' ? -1 : 1);
		}
	}
	return 0;
}

session_start();

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

/************* Converts ****************/
define('host',$_SERVER['HTTP_HOST']);
define('ip', ( $_SERVER['REMOTE_ADDR'] == '::1' ) ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'] );
define('ip2', ip2long(ip));
define('self',$DF->cleanQuery($_SERVER['REQUEST_URI']));
define('local',$DF->indexOf(host,"localhost")>=0?true:false);
define('referer',$_SERVER['HTTP_REFERER']);
define('qstring',trim($_SERVER['QUERY_STRING']));
define('method',trim($_GET['method']));
define('option',trim($_GET['option']));
define('search',trim($_GET['search']));
define('scope',trim($_GET['scope']));
define('type',trim($_GET['type']));
define('mail',trim($_GET['mail']));
define('code',trim($_GET['code']));
define('svc',trim($_GET['svc']));
define('app',trim($_GET['app']));
define('err',trim($_GET['err']));
define('src',trim($_GET['src']));
define('pm',trim($_GET['pm']));
define('defredeclare', isset($_GET['defredeclare']) ? (int)trim($_GET['defredeclare']) : 0);
define('change', isset($_GET['change']) ? (int)trim($_GET['change']) : 0);
define('days', isset($_GET['days']) ? (int)trim($_GET['days']) : 0);
define('auth', isset($_GET['auth']) ? (int)trim($_GET['auth']) : 0);
define('vote', isset($_GET['vote']) ? (int)trim($_GET['vote']) : 0);
define('pg', isset($_GET['pg']) ? (int)trim($_GET['pg']) : 1);
define('id', isset($_GET['id']) ? (int)trim($_GET['id']) : 0);
define('c', isset($_GET['c']) ? (int)trim($_GET['c']) : 0);
define('f', isset($_GET['f']) ? (int)trim($_GET['f']) : 0);
define('t', isset($_GET['t']) ? (int)trim($_GET['t']) : 0);
define('p', isset($_GET['p']) ? (int)trim($_GET['p']) : 0);
define('y', isset($_GET['y']) ? (int)trim($_GET['y']) : 0);
define('m', isset($_GET['m']) ? (int)trim($_GET['m']) : 0);
define('d', isset($_GET['d']) ? (int)trim($_GET['d']) : 0);
define('w', isset($_GET['w']) ? (int)trim($_GET['w']) : 0);
define('u', isset($_GET['u']) ? (int)trim($_GET['u']) : 0);
define('a', isset($_GET['a']) ? (int)trim($_GET['a']) : 0);
define('l', isset($_GET['l']) ? (int)trim($_GET['l']) : 0);
define('s', isset($_GET['s']) ? (int)trim($_GET['s']) : 0);

/************* Config ****************/
$sql=$mysql->query("SELECT variable,value FROM ".prefix."config WHERE type = 1", __FILE__, __LINE__);
while($rs=$mysql->fetchAssoc($sql)){
	define($rs['variable'],$rs['value']);
}

/************* Check login and logout users ****************/
$DF->setLogin();
if(type == "logout"||type == "adminlogout"){
	$DF->setLogout();
}

/************* Set cookies and session ****************/
$DF->cookies();
$DF->session();

//set timezone
define('gmttime',time+(repair_timezone*60*60));
$DF->timezone=((choosed_timezone+repair_timezone)*60*60);
$DF->timezonegmt=(((int)choosed_timezone)*60*60);
$DF->checkZiroPointDate=-(60*60*27);

if(local||ulv == 4){
	error_reporting(E_ALL & ~E_NOTICE);
}
else{
	error_reporting(0);
}

/************* Set img url to arrays ****************/
$DFImage->setArrays();

$DFOutput->setOnline();

// Set user login details
if( ulv > 0 ){
	$DFOutput->setLoginDetails();
}

$DF->setImportantData();

// Check show status tools for moderators and monitors and administration
$_this_forum = 0;
switch( _df_script ){
	case 'forums':
		$_this_forum = f;
	break;
	case 'foruminfo':
		$_this_forum = f;
	break;
	case 'options':	
		if( type == 'topicusers' ){
			$_this_forum = (int)$mysql->get( "topic", "forumid", t );
		}
		elseif( type == 'topicstats'){
			$_this_forum = (int)$mysql->get( "topic", "forumid", t );
		}
		elseif( type == 'edituserfolders' ){
			$_this_forum=abs($_POST['fid']);
		}
		elseif( type == 'movepm' ){
			$_this_forum = abs(f);
		}
		elseif( type == 'restorepm' ){
			$_this_forum = abs(f);
		}

	break;
	case 'pm':
		$_this_forum = abs(f);
	break;
	case 'ajax':
		if( $_POST['type'] == 'deleteUserFromTopic' ){
			$_this_forum = $_POST['forumid'];
		}
	break;
	case 'editor':
		if( type == 'newtopic' ){
			$_this_forum = f;
		}
		elseif( type == 'edittopic' || type == 'newpost' || type == 'quotepost' ){
			$_this_forum = (int)$mysql->get( "topic", "forumid",t );
		}
		elseif( type == 'editpost'){
			$_this_forum = (int)$mysql->get( "post", "forumid",p );
		}
		elseif( type == 'sendpm' || type == 'replypm'){
			$_this_forum = abs(f);
		}
	break;
	case 'setpost':
		if( $_POST['type'] == 'newtopic' ){
			$_this_forum = (int)$_POST['forumid'];
		}
		elseif( $_POST['type'] == 'edittopic' || $_POST['type'] == 'newpost' || $_POST['type'] == 'quotepost' ){
			$_this_forum = (int)$mysql->get( "topic", "forumid", (int)$_POST['topicid'] );
		}
		elseif( $_POST['type'] == 'editpost' ){
			$_this_forum = (int)$mysql->get( "post", "forumid", (int)$_POST['postid'] );
		}
		elseif( $_POST['type'] == 'sendpm' ){
			$_this_forum = abs((int)$_POST['forumid']);
		}
	break;
	case 'topics':
		$_this_forum = (int)$mysql->get( "topic", "forumid", t );
	break;
	case 'print':
	case 'sendtopic':
		$_this_forum = (int)$mysql->get( "topic", "forumid", t );
	break;
	default:
		$_this_forum = 0;
}
$is_moderator = false;
$is_monitor = false;
if( $_this_forum > 0 ){
	$show_tools = $DF->showTools($_this_forum);
	if( $show_tools == 2 ){
		$is_moderator = true;
		$is_monitor = true;
	}
	elseif( $show_tools == 1 ){
		$is_moderator = true;
	}
}
$DF->catch['is_moderator'] = $is_moderator;
$DF->catch['is_monitor'] = $is_monitor;
$DF->catch['_this_forum'] = $_this_forum;

// Check operations
$DF->checkOperation();

require_once _df_path."styles/style.php";
?>
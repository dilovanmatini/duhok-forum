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

 // denying calling this file without landing files.
defined('_df_script') or exit();

// ############################## $DM->clean() types #########################################
define('TYPE_NO',				-1); // no change
define('TYPE_INT',				1); // become integer
define('TYPE_FLOAT',			2); // become float
define('TYPE_BOOL',				3); // become boolean
define('TYPE_STR',				4); // become string
define('TYPE_TRIM',				5); // become string (with trim)
define('TYPE_ARRAY',			6); // become array
define('TYPE_ARRAYBLANK',		7); // delete array's blank keys & blank values
define('TYPE_ARRAYKEYBLANK',	8); // delete array's blank keys
define('TYPE_ARRAYVALBLANK',	9); // delete array's blank values
define('TYPE_FULLHTML',			10); // check HTML
define('TYPE_NOHTML',			11); // delete all HTML with trim string
define('TYPE_EASYHTML',			12); // delete blocked tags & attributes & check HTML
define('TYPE_ENCODEHTML',		13); // convert " and > and < to escape text
define('TYPE_DECODEHTML',		14); // convert escape text to " and > and <
define('TYPE_INLINE',			15); // string become in one line (delete \t \r \n)
define('TYPE_FILE',				16); // force file
define('TYPE_BINARY',			17); // force binary string
define('TYPE_SERIALIZE',		18); // array become serialize string
define('TYPE_UNSERIALIZE',		19); // array become unserialize (become array)
define('TYPE_STRTOUPPER',		20); // convert string to upper case
define('TYPE_STRTOLOWER',		21); // convert string to lower case

class DF{
	var $x;
	var $mysql;
	var $cnf;
	var $DFImage;
	var $Template;
	var $gmttime = 0;
	var $timezone = 0;
	var $timezonegmt = 0;
	var $checkZiroPointDate = 0;
	var $browser = array();
	var $catch = array();
	var $vars = array();
	var $length = "9876543210987654";
	var $keys = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":");
	var $numCode = array(
		"0" => array("gx", "k1", "gr", "k3", "gc", "k5", "gu", "k7", "gx", "k9"),
		"1" => array("n0", "ju", "n2", "jc", "n4", "jr", "n6", "jx", "n8", "ju"),
		"2" => array("su", "w1", "sx", "w3", "sr", "w5", "sc", "w7", "su", "w9"),
		"3" => array("l0", "tx", "l2", "tu", "l4", "tc", "l6", "tr", "l8", "tx"),
		"4" => array("au", "z1", "ax", "z3", "ar", "z5", "ac", "z7", "au", "z9"),
		"5" => array("i0", "fu", "i2", "fc", "i4", "fr", "i6", "fx", "i8", "fu"),
		"6" => array("hx", "v1", "hr", "v3", "hc", "v5", "hu", "v7", "hx", "v9"),
		"7" => array("o0", "du", "o2", "dc", "o4", "dr", "o6", "dx", "o8", "du"),
		"8" => array("mu", "y1", "mx", "y3", "mr", "y5", "mc", "y7", "mu", "y9"),
		"9" => array("b0", "ex", "b2", "eu", "b4", "ec", "b6", "er", "b8", "ex"),
		":" => array("pu", "q1", "px", "q3", "pr", "q5", "pc", "q7", "pu", "q9")
	);
	var $config = []; 		// The config variables: $df->config
    function __construct(){
        try{
            if( file_exists(_df_path.'includes/config.php') ){
                require_once _df_path.'includes/config.php';
            }
            else{
                throw new Exception("Config file does not exist");
            }

            if( !is_array($df_config) ){
				throw new Exception("Config file is not defined");
            }

			if( !is_array($df_config['database']) ){
				throw new Exception("Database Configuration does not exist");
            }

            if( is_dir("install") ){
				//throw new Exception("You should remove \"install\" folder otherwise the script will be under high risks");
            }
            
            if( is_array($df_config['global']) && isset($df_config['global']['timezone']) ){
                date_default_timezone_set($df_config['global']['timezone']);
            }
            else{
                throw new Exception("Timezone does not exist");
            }

			$this->config = $df_config;
			define('_is_local', $df_config['global']['local'] === true );
			define('x', '?x='.$df_config['global']['xcode']);
			define('prefix',	trim($df_config['database']['prefix']));
			define('expire', time + ( 86400 * intval( $df_config['cookie']['expire'] ) ) );
		}
		catch( Exception $e ){
			die( "DF Error: {$e->getMessage()}" );
		}
    }
	function setCookie($name, $val, $expire = -1){
		$expire = ($expire >= 0) ? $expire : expire;
		@setcookie($this->config['cookie']['prefix'].$name, $val, $expire);
	}
	function getCookie($name){
		$val = $_COOKIE[$this->config['cookie']['prefix'].$name];
		return $val;
	}
	function setSession($name, $val){
		$_SESSION["{$this->config['cookie']['prefix']}{$name}"] = $val;
	}
	function getSession($name){
		$val = $_SESSION["{$this->config['cookie']['prefix']}{$name}"];
		return $val;
	}
	function quick($url = 'index.php'){
		header("Location: {$url}");
		exit();
	}
	function goTo($url = 'index.php'){
		echo"<script type=\"text/javascript\">window.location='{$url}';</script>";
		exit();
	}
	function confirm($text, $var = false){
		$sure = " onclick=\"return confirm(".($var ? $text : "'{$text}'").");\"";
		return $sure;
	}
	function choose($v1, $v2, $type){
		if($v1 == $v2){
			$text = array('s' => ' selected', 'c' => ' checked');
			return $text["{$type}"];
		}
	}
	function pgLimit($max, $pg = 0){
		$pg = ($pg > 0) ? $pg : ((pg > 0) ? pg : 1);
		$limit = (($pg * $max) - $max);
		return $limit;
	}
	function time($time, $gmt = false){
		$time = $time + (($gmt) ? $this->timezonegmt : $this->timezone);
		return $time;
	}
	function date($date, $type = '', $num = false, $year = false, $sec = false, $gmt = false){
		if(!$date){
			return '----';
		}
		$date=$this->time($date,$gmt);
		$nowTime=$this->time(time,$gmt);
		$time=date("H:i".($sec?":s":""),$date);
		if($type == 'time'){
			return $time;
		}
		else{
			$y=date("Y",$date);
			$m=date("m",$date);
			$d=date("d",$date);
			$yy=date("Y",$nowTime);
			$mm=date("m",$nowTime);
			$dd=date("d",$nowTime);
			$yesterday=date("d",$nowTime-86400);
			if($d == $dd&&$m == $mm&&$y == $yy&&!$num){
				$date="اليوم";
			}
			elseif($d == $yesterday&&($dd == 1||$m == $mm)&&$y == $yy&&!$num){
				$date="يوم أمس";
			}
			else{
				$year=($year||$type == "date"||$y!=$yy?$y.'/':"");
				$date=$year.$m."/".$d;
				$date="<span dir=\"ltr\">$date</span>";
			}
			if($type == "date"){
				return $date;
			}
			else{
				return $time." - ".$date;
			}
		}
	}
	function getDays($from,$y,$m=0,$d=0){
		$yy=((($y%4 == 0)&&($y%100!=0))||($y%400 == 0)); $mm=array(0,31,28,31,30,31,30,31,31,30,31,30,31); $days=0;
		if($from == 'm'){ //month's days
			if($m == 2&&$yy) $days=29;
			else $days=(int)$mm[$m];
		}
		elseif($from == 'yl'){ // day left in year
			for($x=1;$x<=$m;$x++){
				if($x == $m) $days+=$d;
				else $days+=($m == 2&&$yy ? 29 : $mm[$x]);
			}
		}
		else{ // year's days
			$days=($yy ? 366 : 365);
		}
		return $days;
	}
	function getThisWeek($time){
		$time=(int)$time;
		if($time<=0) $time=time;
		$d=explode("-",date("Y-m-d",$time));
		$l=$this->getLimitDaysOfYear($d[0]);
		$yl=$this->getDays('yl',$d[0],$d[1],$d[2]);
		$yl-=$l;
		$w=ceil($yl/7);
		return $w;
	}
	function getYearWeeks($y){
		$y=(int)$y;
		if($y<=0) $y=date("Y",time);
		$l=$this->getLimitDaysOfYear($y);
		$yd=$this->getDays('yd',$y);
		$yd-=$l;
		$w=ceil($yd/7);
		return $w;
	}
	function getTimeOfWeek($y,$w){
		$t=mktime(0,0,0,1,1,$y);
		$l=$this->getLimitDaysOfYear($y);
		$t+=($l*(60*60*24));
		$t+=(60*60*24*($w*7-7));
		return $t;
	}
	function getLimitDaysOfYear($y){
		$t=mktime(0,0,0,1,1,$y);
		$f=date("w",$t);
		$l=(6-$f);
		return $l;
	}
	function picError( $size = 100, $type = '' ){
		$sizes = [ 1, 32, 64, 100 ];
		if( !in_array($size, $sizes) ){
			$size = 100;
		}
		$path = $size == 1 ? "images/upics/" : "images/upics/{$size}/";
		$url = "{$path}default.gif";
		if( $type == 'src' ){
			$error = $url;
		}
		else{
			$error = " onerror=\"this.src='{$url}';\"";
		}
		return $error;
	}
	function setLogin(){
		$login_user_name = '';
		$login_user_pass = '';
		$login_user_hash = '';
		$login_cp_name = '';
		$login_cp_pass = '';
		$login_save = 0;
		if(type == 'login' and isset($_POST['login_user_name']) and isset($_POST['login_user_pass'])){
			$login_user_name = $this->cleanText(trim($_POST['login_user_name']));
			$login_user_pass = $this->cleanText(trim($_POST['login_user_pass']));
			$login_user_hash = md5($login_user_name.time().mt_rand(1,99999999));
			$login_save = intval($_POST['login_save']);
		}
		if(type == 'adminlogin' and isset($_POST['login_cp_name']) and isset($_POST['login_cp_pass'])){
			$login_cp_name = $this->cleanText(trim($_POST['login_cp_name']));
			$login_cp_pass = $this->cleanText(trim($_POST['login_cp_pass']));
		}

		if(type == 'login' and !empty($login_user_name) and !empty($login_user_pass)){
			if($this->indexOf($login_user_name, '@') >= 0){
				$rs = $this->mysql->queryRow("SELECT u.code
				FROM ".prefix."userflag AS uf
				LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
				WHERE uf.email = '{$login_user_name}' GROUP BY uf.id LIMIT 1", __FILE__, __LINE__);
				$code = $rs[0];
			}
			else{
				$code = $this->mysql->get("user", "code", $login_user_name, "entername");
			}
			setcookie('login_user_name', $login_user_name, expire);
			setcookie('login_user_pass', md5($code.$login_user_pass), ($login_save == 1 ? expire : 0));
			setcookie('login_user_hash', $login_user_hash, expire);
			$this->quick("index.php?type=dologin");
		}
		if(type == 'adminlogin' and !empty($login_cp_name) && !empty($login_cp_pass)){
			if($this->indexOf($login_cp_name, '@') >= 0){
				$rs = $this->mysql->queryRow("SELECT u.code
				FROM ".prefix."userflag AS uf
				LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
				WHERE uf.email = '{$login_cp_name}' GROUP BY uf.id LIMIT 1", __FILE__, __LINE__);
				$code = $rs[0];
			}
			else{
				$code = $this->mysql->get("user", "code", $login_cp_name, "entername");
			}
			setcookie('login_cp_name', $login_cp_name, expire);
			setcookie('login_cp_pass', md5($code.$login_cp_pass), 0);
			$this->quick("admin_login.php?type=adminlogin&src=".urlencode(src));
		}

		$user_name = addslashes($_COOKIE['login_user_name']);
		$user_pass = addslashes($_COOKIE['login_user_pass']);
		$user_hash = addslashes($_COOKIE['login_user_hash']);
		$cp_name = addslashes($_COOKIE['login_cp_name']);
		$cp_pass = addslashes($_COOKIE['login_cp_pass']);
		if(type == 'dologin'){
			$login_field = ($this->indexOf($user_name, '@') >= 0) ? 'uf.email' : 'u.entername';
			$rs = $this->mysql->queryRow("SELECT u.id
			FROM ".prefix."user AS u
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
			WHERE {$login_field} = '{$user_name}' AND u.password = '{$user_pass}' AND u.status = 1 AND u.active = 1", __FILE__, __LINE__);
			$uid = intval($rs[0]);
			if($uid > 0){
				$this->mysql->insert("loginsession (hash, userid, ip, useragent, lastdate, date) VALUES ('{$user_hash}', {$uid}, '".ip2."', '{$_SERVER['HTTP_USER_AGENT']}', ".time.", ".time.")", __FILE__, __LINE__);
			}
			$this->quick("index.php?type=login");
		}
		else{
			if(!empty($user_name) and !empty($user_pass)){
				if(_df_script == 'favorite'){
					$userField = ",up.hidefavorite";
				}
				elseif(_df_script == 'yourtopics'){
					$userField = ",up.hideselftopics,up.hideuserstopics";
				}
				elseif(_df_script == 'yourposts'){
					$userField = ",up.hideselfposts,up.hideusersposts";
				}
				elseif(_df_script == 'editor'){
					$userField = ",up.stopaddpost,up.stopsendpm,up.uneditsignature";
				}
				elseif(_df_script == 'setpost'){
					$userField = ",up.stopaddpost,up.postsundermon,up.stopsendpm,up.uneditsignature";
				}
				elseif(_df_script == 'users'){
					$userField = ",up.hideusers";
				}
				elseif(_df_script == 'options' && type == 'complain'){
					$userField = ",up.sendcomplain";
				}
				elseif(_df_script == 'topics'){
					$userField = ",u.date";
				}
				if($this->getCookie('importantData') != 1){
					$userField .= ",uf.sex,uf.country,uf.brithday";
				}
				$login_field = ($this->indexOf($user_name, '@') >= 0) ? 'uf.email' : 'u.entername';
				$rs = $this->mysql->queryAssoc("SELECT u.id, u.name, u.entername, u.level, u.submonitor, uf.email, uf.posts, uf.picture, up.hidebrowse, up.dochat, u.password, uf.ip {$userField}
				FROM ".prefix."user AS u
				LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
				LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
				LEFT JOIN ".prefix."loginsession AS ls ON(ls.userid = u.id AND ls.hash = '{$user_hash}' AND ls.status = 0)
				WHERE {$login_field} = '{$user_name}' AND u.password = '{$user_pass}' AND u.status = 1 AND u.active = 1 AND ls.id > 0 ", __FILE__, __LINE__);
			}
			// field name, var name, (1 = integer, 0 = string)
			$fields = array(
				'id',				'',				1,
				'name',				'',				0,
				'entername',		'',				0,
				'password',			'upass',		0,
				'level',			'ulv',			1,
				'submonitor',		'submonitor',	1,
				'posts',			'',				1,
				'picture',			'',				0,
				'date',				'',				1,
				'sex',				'',				1,
				'ip',				'',				1,
				'country',			'',				0,
				'brithday',			'',				0,
				'hidebrowse',		'',				1,
				'hidefavorite',		'',				1,
				'hideselftopics',	'',				1,
				'hideuserstopics',	'',				1,
				'hideselfposts',	'',				1,
				'hideusersposts',	'',				1,
				'stopaddpost',		'',				1,
				'stopsendpm',		'',				1,
				'postsundermon',	'',				1,
				'hideusers',		'',				1,
				'sendcomplain',		'',				1,
				'email',			'',				0,
				'uneditsignature',	'',				1,
				'dochat',			'',				1
			);
			for($x = 0; $x < count($fields); $x+=3){
				$defname = (!empty($fields[$x + 1]) ? $fields[$x + 1] : "u{$fields[$x]}");
				if($fields[$x + 2] == 1){
					define($defname, intval($rs["{$fields[$x]}"]));
				}
				else{
					define($defname, ($val = $rs["{$fields[$x]}"]) ? $val : '');
				}
			}
			if(type == 'login' && ulv > 0){
				$this->quick();
			}
			define('cplogin', (($cp_name == uentername || $cp_name == uemail) and $cp_pass == upass && ulv == 4) ? true : false);
			if(_df_script == 'admin_login' && cplogin === true){
				$this->quick(src != '' ? src : 'admincp.php');
			}
		}
	}
	function setLogout(){
		if(type == 'adminlogout'){
			setcookie('login_cp_name', '');
			setcookie('login_cp_pass', '');
			$this->quick();
		}
		if(type == 'logout'){
			$user_hash = addslashes($_COOKIE['login_user_hash']);
			$this->mysql->update("loginsession SET status = 1, lastdate = ".time." WHERE hash = '{$user_hash}' AND userid = ".uid."", __FILE__, __LINE__);
			setcookie('login_user_name', '');
			setcookie('login_user_pass', '');
			setcookie('login_cp_name', '');
			setcookie('login_cp_pass', '');
			$this->quick(src);
		}
	}
	function setImportantData(){
		if( ulv > 0 && ulv != 4 && $this->getCookie('importantData') != 1 ){
			$error = false;
			require_once _df_path."countries.php";
			$cCode = array_keys($country);
			if(!in_array(ucountry, $cCode)){
				$error = true;
			}
			if(usex == 0){
				$error = true;
			}
			$Y = intval(date("Y",time));
			$fY = ($Y - 100);
			$lY = ($Y - 12);
			$ex = explode('-', ubrithday);
			$year = intval($ex[0]);
			if($year <= $fY or $year > $lY){
				$error = true;
			}
			if($error){
				if(_df_script != 'update'){
					$this->quick('update.php?type=userdetails');
				}
			}
			else{
				$this->setCookie('importantData', 1);
			}
		}
	}
	function checkAndForHTTP($url,$clear=''){
		if($this->indexOf($url,'?')>=0){
			return "$url&";
		}
		else{
			return "$url?";
		}
	}
	function indexOf($txt,$find,$word=false,$case=false){
		$pos=stripos($txt,$find);
		$get=(is_int($pos)?$pos:-1);
		if($word){
			$sub=substr($txt,$get,strlen($find));
			return ($case?strtolower($sub):$sub);
		}
		else{
			return $get;
		}
	}
	function browse($msg=''){
		global $_SERVER;
		if(!isset($_SERVER)) $_SERVER=$HTTP_SERVER_VARS;
		$agent=strtolower($_SERVER['HTTP_USER_AGENT']);
		if(empty($msg)){
			if($this->indexOf($agent,'msie')>=0) return true;
			else return false;
		}
		elseif($msg == 'type'){
			if($this->indexOf($agent,'msie')>=0) return 'msie';
			elseif($this->indexOf($agent,'chrome')>=0) return 'chrome';
			elseif($this->indexOf($agent,'safari')>=0&&$this->indexOf($agent,'chrome') == -1) return 'safari';
			elseif($this->indexOf($agent,'firefox')>=0&&$this->indexOf($agent,'navigator') == -1) return 'firefox';
			elseif($this->indexOf($agent,'navigator')>=0) return 'navigator';
			elseif($this->indexOf($agent,'opera')>=0) return 'opera';
			elseif($this->indexOf($agent,'mac')>=0) return 'mac';
			else return 'unknown';
		}
		else{
			return $agent;
		}
	}
	function isOurSite(){
		$refer = referer;
		if( empty($refer) ){
			return false;
		}
		else{
			return true; // fixing this issue is important
			$domains = unserialize(site_domains);
			if( !is_array($domains) ) $domains = [];
			$url = explode("/", $refer );
			$count = 0;
 			for( $x = 0; $x < count($domains); $x++ ){
				$myDomain = $domains[$x];
				if( $url[2] == $myDomain || $url[2] == "www.".$myDomain ){
					$count++;
				}
			}
			if( $count > 0 ){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function ip(){
		global $_SERVER;
		$adder='REMOTE_ADDR';
		$for='HTTP_X_FORWARDED_FOR';
		$client='HTTP_CLIENT_IP';
		if(isset($_SERVER)){
			if(isset($_SERVER["{$adder}"])){
				$ip=$_SERVER["{$adder}"];
			}
			elseif(isset($_SERVER["{$for}"])){
				$ip=$_SERVER["{$for}"];
			}
			elseif(isset($_SERVER["{$client}"])){
				$ip=$_SERVER["{$client}"];
			}
		}
		else{
			if(getenv($for)){
				$ip=getenv($for);
			}
			elseif(getenv($client)){
				$ip=getenv($client);
			}
			else{
				$ip=getenv($adder);
			}
		}
		return $ip;
	}
	function numToHash($n){
		$number=(int)$n;
		$len=(15-strlen($number));
		$number=$number.':'.substr($this->length,0,$len);
		$arr=str_split($number,1);
		for($x=0;$x<16;$x++){
			$num=$arr[$x];
			$index=substr($n,strlen($n)-1,1)+$x*$x;
			$index=substr($index,strlen($index)-1,1);
			$hash.=$this->numCode[$num][$index];
		}
		return $hash;
	}
	function hashToNum($hash){
		for($x=0;$x<count($this->keys);$x++){
			$key=$this->keys[$x];
			$hash=str_replace($this->numCode["{$key}"],$key,$hash);
		}
		$number=explode(":",$hash);
		return $number[0];
	}
	function getOpenTime(){
		$time=microtime();
		$time=explode(' ',$time);
		$time2=$time[1]-time;
		$time=round($time2+$time[0],2);
		return $time;
	}
	function checkOperation(){
		// Check User Country
		if(ulv > 1){
			$code=($catchCode=$this->catch['countryCode']) ? $catchCode : ($this->catch['countryCode']=(local ? 'LH' : $this->getCountryByIP()));
			$getCookie=explode(":",$this->getCookie('userCountryDetails'));
			if($code!=$getCookie[0]){
				$this->catch['countryName']=$this->mysql->get("country","name",$code,"code");
				$this->setCookie('userCountryDetails',$code.':'.$this->catch['countryName']);
			}
			else{
				$this->catch['countryName']=$getCookie[1];
			}

		}
	}
	function getSitePath(){
		$path=(local ? 'http://localhost/' : 'http://'.site_address.'/');
		return $path;
	}
	function getCountryHostName(){
		$hostName=(local ? '127.0.0.1' : site_address);
		return $hostName;
	}
	function getCountryByIP( $ip = ip, $type = 'code' ){

		if( local ){
			return '';
		}

		$target = "http://ip-api.com/json/";
		$content = @file_get_contents("{$target}{$ip}");
		$json = json_decode($content, true);

		$country = '';
		$country_code = '';
		if( is_array($json) && isset($json['status']) && $json['status'] == 'success' ){
			$country = isset($json['country']) ? $json['country'] : '';
			$country_code = isset($json['countryCode']) ? $json['countryCode'] : '';
		}

		if( $type == 'img' ){
			if( $country_code != '' ){
				return "images/flags/".strtolower($country_code).".png";
			}
		}
		elseif( $type == 'all' ){
			return [
				'name' => $country,
				'code' => $country_code
			];
		}
		elseif( $type == 'name' ){
			return $country;
		}
		elseif( $type == 'code' ){
			return $country_code;
		}
		else{
			return isset($json["{$type}"]) ? $json["{$type}"] : '';
		}
	}
	function getFlagByCode($code){
		$flag="images/flags/".strtolower($code).".png";
		return $flag;
	}
	function hashIP($ip){
		$ip=explode(".",$ip);
		$ip[3]="XXX";
		$ip=implode(".",$ip);
		$ip="<span dir=\"ltr\">$ip</span>";
		return $ip;
	}
	function striplines($details,$ret=false){
		$striplines=array("\n","\t","\r");
		$details=str_replace($striplines,"",$details);
		if($ret) return $details;
		else echo $details;
	}
	function cookies(){
		$varList=array();
		if(_df_script == 'forums'){
			$varList['topicsOrderBy']=array('define'=>'topics_order_by','default'=>'posts','link'=>self);
		}
		if(_df_script == 'topics'){
			$varList['topicsSignature']=array('define'=>'topics_signature','default'=>'hidden','link'=>self);
		}
		if(_df_script == 'active'){
			$varList['activeType']=array('define'=>'active_type','default'=>'active','link'=>self);
		}
		if(_df_script == 'editor'){
			$varList['editorType']=array('define'=>'editor_type','default'=>'old','link'=>self);
		}
		if(_df_script == 'yourposts'){
			$varList['postsSortType']=array('define'=>'posts_sort_type','default'=>'posts','link'=>self);
			$varList['postsSortLast']=array('define'=>'posts_sort_last','default'=>'post','link'=>self);
			$varList['postsSortForum']=array('define'=>'posts_sort_forum','default'=>0,'link'=>self);
		}
		$varList['refreshPage']=array('define'=>'refresh_page','default'=>0,'link'=>self);
		$varList['postNumPage']=array('define'=>'post_num_page','default'=>30,'link'=>self);
		foreach($varList as $key=>$val){
			if(!empty($_POST["{$key}"])){
				$cookValue=($val['']);
				$this->setCookie($key,$_POST["{$key}"]);
				$this->quick($val['link']);
			}
			define($val['define'],($getVal=$this->getCookie("{$key}")) ? $getVal : $val['default']);
		}
		//Check choosed style
		$getStyle=$this->cleanText($_GET["style"]);
		$styles=array('blue','green','red','purple');
		if(!empty($getStyle)&&in_array($getStyle,$styles)){
			$this->setCookie('choosedStyle',$getStyle);
			$this->quick(src);
		}
		define('choosed_style',($getVal=$this->getCookie("choosedStyle"))&&in_array($getVal,$styles) ? $getVal : default_style);
		//Check choosed home view
		$getHomeView=$this->cleanText($_GET["home_view"]);
		$homeViews=array('details','grid');
		if(!empty($getHomeView)&&in_array($getHomeView,$homeViews)){
			$this->setCookie('homeView',$getHomeView);
			$this->quick();
		}
		define('home_view',($getVal=$this->getCookie("homeView"))&&in_array($getVal,$homeViews) ? $getVal : 'details');
		//Check choosed style font
		$getStyleFont=$this->cleanText($_GET["stylefont"]);
		$fonts=array('arial','tahoma','sans');
		if(!empty($getStyleFont)&&in_array($getStyleFont,$fonts)){
			$this->setCookie('choosedStyleFont',$getStyleFont);
			$this->quick(src);
		}
		define('choosed_stylefont',($getVal=$this->getCookie("choosedStyleFont"))&&in_array($getVal,$fonts) ? $getVal : default_stylefont);
		//Check choosed timezone
		$timezone = $this->cleanText($_GET["timezone"]);
		$zones = array(-12,-11,-10,-9,-8,-7,-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6,7,8,9,10,11,12);
		if(!empty($timezone) && in_array($timezone, $zones)){
			$this->setCookie('choosedTimezone', $timezone);
			$this->quick(src);
		}
		define('choosed_timezone', (($val = $this->getCookie("choosedTimezone")) && in_array($val, $zones)) ? $val : default_timezone);
	}
	function session(){
		$varList=array();
		if(_df_script == 'users'){
			$varList['usersSortBy'] = array(
				'define' => 'users_sort_by',
				'default' => 'desc'
			);
			if(search != ''){
				$default_type = 'name';
			}
			else{
				$default_type = (ulv == 4) ? 'online' : 'posts';
			}
			$varList['usersSortType'] = array(
				'define' => 'users_sort_type',
				'default' => $default_type
			);
		}
		foreach($varList as $key=>$val){
			if($val['define'] == 'users_sort_type'&&type!=''){
				$this->setSession($key,type);
				$this->quick("users.php".(search!='' ? "?search=".search : ""));
			}
			elseif(!empty($_POST["{$key}"])){
				$this->setSession($key,$_POST["{$key}"]);
				$this->quick(($url=$val['link']) ? $url : self);
			}
			define($val['define'], ($getVal=$this->getSession($key)) ? $getVal : $val['default']);
		}
		define('checkredeclare',(int)$_SESSION['checkredeclare']);
		if(_df_script == 'svc'||_df_script == 'options') $_SESSION['checkredeclare']=rand;
	}
	function iff($condition,$if,$else=''){
		return ($condition ? $if : $else);
	}
	function sort($arr,$sort=array()){
		$this->catch['sortTypeArrays']=$sort;
		usort($arr,'cmpsort');
		return $arr;
	}
	function charset($char='utf-8',$type='text/html',$text=false){
		if($text){
			echo"<meta http-equiv=\"Content-Type\" content=\"$type;charset=$char\">";
		}
		else{
			header("Content-type: $type; charset=$char");
		}
	}
	function checkLink($file,$el,$added){
		$link="";
		if(!is_array($el)) $el=array();
		if(!is_array($added)) $added=array();
		foreach($el as $key=>$val){
			if(!in_array($key,array_keys($added))&&!empty($val)&&$val!=0){
				$link.="&{$key}={$val}";
			}
		}
		foreach($added as $key=>$val){
			if(!empty($val)){
				$link.="&{$key}={$val}";
			}
		}
		if($this->indexOf($file,"?") == -1&&!empty($link)){
			$file.="?";
			$link=substr($link,1);
		}
		$link="{$file}{$link}";
		return $link;
	}
	function between($num, $start, $end){
		$in = ($num == $start or $num == $end or $num > $start and $num < $end) ? true : false;
		return $in;
	}
	function getMonStatus($type, $f){
		$montype = array(
			'monforum'		=> 1,
			'forbidforum'	=> 3
		);
		$monid = intval($montype["{$type}"]);
		$rs = $this->mysql->queryRow("SELECT id FROM ".prefix."mon WHERE montype = '$monid' AND status = 1 AND userid = '".uid."' AND forumid = '$f'", __FILE__, __LINE__);
		if($rs){
			return 1;
		}
		else{
			return 0;
		}
	}
	function userTitle($uid, $posts, $level, $title, $sex, $oldlevel, $submonitor){
		if(isset($this->catch['starsNumber'][$uid])){
			$starsNumber = $this->catch['starsNumber'][$uid];
		}
		else{
			$starsNumber = $this->catch['starsNumber'][$uid] = unserialize(stars_number);
		}
		if(isset($this->catch['sexTitles'][$uid])){
			$titles = $this->catch['sexTitles'][$uid];
		}
		else{
			$titles = $this->catch['sexTitles'][$uid] = unserialize(($sex == 2) ? female_titles : male_titles);
		}
		if(isset($this->catch['userTitles'][$uid])){
			return $this->catch['userTitles'][$uid];
		}
		if(!empty($title) and $level > 1){
			$userTitle = $title;
		}
		elseif(is_array($starsNumber) and is_array($titles)){
			if($level == 1){
				if($oldlevel > 1){
					$oldLevelTitle = array(
						2 => array($titles[2][0][1], $titles[2][1][1]),
						3 => array($titles[3][1]),
						4 => array($titles[4][1])
					);
					$userTitle = "<span class=\"asC4\">{$oldLevelTitle[$oldlevel][$submonitor]}</span>";
				}
				else{
					for($x = 0; $x <= 10; $x++){
						$number = $starsNumber[$x];
						$lastNumber = ($x == 10) ? true : ($posts < $starsNumber[$x + 1]);
						if($posts >= $number and $lastNumber){
							$userTitle = (!empty($titles[1][$x])) ? $titles[1][$x] : $titles[1][5];
							break;
						}
					}
				}
			}
			else{
				if($level == 2){
					$userTitle = $titles[2][$submonitor][0];
				}
				else{
					$userTitle = $titles[$level][0];
				}
			}
		}
		$this->catch['userTitles'][$uid] = $userTitle;
		return $userTitle;
	}
	function userStars($posts, $level, $submonitor){
		$stars_color = ($starsColor = $this->catch['stars_color']) ? $starsColor : ($this->catch['stars_color'] = unserialize(stars_color));
		$stars_number = ($starsNumber = $this->catch['stars_number']) ? $starsNumber : ($this->catch['stars_number'] = unserialize(stars_number));
		if(isset($this->catch['userStars'][$posts][$level])){
			return $this->catch['userStars'][$posts][$level];
		}
		if(is_array($stars_color) and is_array($stars_number)){
			if($level == 2){
				$color = $stars_color[2][$submonitor];
			}
			else{
				$color = $stars_color[$level][1];
			}
			$src = "images/icons/star_{$color}.gif";
			if($level > 0 and $level < 4){
 				for($x = 0; $x <= 10; $x++){
					$number = $stars_number[$x];
					$lastNumber = ($x == 10) ? true : ($posts < $stars_number[$x + 1]);
					if($posts >= $number and $lastNumber){
						for($i = 0; $i < $x; $i++){
							if($i == 5){
								$stars .= "<br>";
							}
							$stars .= "<img src=\"{$src}\">";
						}
					}
				}
			}
			$this->catch['userStars'][$posts][$level] = $stars;
			return $stars;
		}
	}
	function getAllowForumId($inSql = false, $admin = false){
		global $mysql;
		$forums = array();
		if(ulv == 2 || ulv == 3){
			$sql = $mysql->query("SELECT forumid FROM ".prefix."moderator WHERE userid = '".uid."'", __FILE__, __LINE__);
			while($rs = $mysql->fetchRow($sql)){
				if(!in_array($rs[0], $forums)){
					$forums[] = $rs[0];
				}
			}
		}
		if(ulv == 3){
			$sql=$mysql->query("SELECT f.id FROM ".prefix."category AS c
			LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id)
			WHERE c.monitor = ".uid." GROUP BY f.id", __FILE__, __LINE__);
			while($rs=$mysql->fetchRow($sql)){
				if(!in_array($rs[0],$forums)){
					$forums[]=$rs[0];
				}
			}
		}
		if(ulv == 2){
			$sql=$mysql->query("SELECT f.id FROM ".prefix."category AS c
			LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id)
			WHERE c.submonitor = ".uid." GROUP BY f.id", __FILE__, __LINE__);
			while($rs=$mysql->fetchRow($sql)){
				if(!in_array($rs[0],$forums)){
					$forums[]=$rs[0];
				}
			}
		}
		if($admin&&ulv == 4){
			$sql=$mysql->query("SELECT id FROM ".prefix."forum", __FILE__, __LINE__);
			while($rs=$mysql->fetchRow($sql)){
				if(!in_array($rs[0],$forums)){
					$forums[]=$rs[0];				
				}
			}
		}
		if($inSql&&count($forums) == 0){
			$forums[]=0;
		}
		return $forums;
	}
	function showTools($f = f, $uid = uid){
		if($f>0&&$uid>0){
			$ulv=($uid == uid?ulv:$this->mysql->get("user","level",$uid));
			if($ulv < 2){
				return 0;
			}
			elseif($ulv == 4){
				return 2;
			}
			elseif($ulv == 3){
				$rs=$this->mysql->queryRow("SELECT IF(ISNULL(c.monitor),0,c.monitor),IF(ISNULL(m.id),0,1)
				FROM ".prefix."forum AS f
				LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)
				LEFT JOIN ".prefix."moderator AS m ON(m.userid = $uid AND m.forumid = $f)
				WHERE f.id = '$f'", __FILE__, __LINE__);
				if($rs[0] == $uid){
					return 2;
				}
				elseif($rs[1] == 1){
					return 1;
				}
				else{
					return 0;
				}
			}					elseif($ulv == 2){				$rs=$this->mysql->queryRow("SELECT IF(ISNULL(c.submonitor),0,c.submonitor),IF(ISNULL(m.id),0,1)				FROM ".prefix."forum AS f				LEFT JOIN ".prefix."category AS c ON(c.id = f.catid)				LEFT JOIN ".prefix."moderator AS m ON(m.userid = $uid AND m.forumid = $f)				WHERE f.id = '$f'", __FILE__, __LINE__);				if($rs[0] == $uid){					return 1;				}				elseif($rs[1] == 1){					return 1;				}				else{					return 0;				}			}
			elseif($ulv == 2){
				$count=$this->DFOutput->count("moderator WHERE userid = '$uid' AND forumid = '$f' and block = 0");
				if($count>0){
					return 1;
				}
				else{
					return 0;
				}
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	function allowForum($f,$uid=uid){
		$ulv=($uid == uid ? ulv : $this->mysql->get("user","level",$uid));
		if($ulv == 4){
			return true;
		}
		else{
			$forum=$this->mysql->queryAssoc("SELECT
				IF( ($ulv > 1 AND NOT ISNULL(m.id)) OR ($ulv = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismod,
				IF( (f.hidden = 0 AND $ulv >= f.level OR NOT ISNULL(fu.id)) ,1,0) AS allowforum
			FROM ".prefix."forum AS f
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = $uid)
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = $uid)
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = $uid)
			WHERE f.id = '$f'
			HAVING allowforum = 1 OR ismod = 1", __FILE__, __LINE__);
			if($forum){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function allowTopic($t,$uid=uid){
		$ulv=($uid == uid ? ulv : $this->mysql->get("user","level",$uid));
		if($ulv == 4){
			return true;
		}
		else{
			$topic=$this->mysql->queryAssoc("SELECT t.trash AS trash,
				IF( ($ulv > 1 AND NOT ISNULL(m.id)) OR ($ulv = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismod,
				IF( ($ulv = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismon,
				IF( (f.hidden = 0 AND $ulv >= f.level OR NOT ISNULL(fu.id)) ,1,0) AS allowforum,
				IF( (t.trash = 0 AND (t.moderate = 0 OR t.author = $uid) AND (t.hidden = 0 OR t.author = $uid OR NOT ISNULL(tu.id))) ,1,0) allowtopic
			FROM ".prefix."topic AS t
			LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = $uid)
			LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = $uid)
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = $uid)
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = $uid)
			WHERE t.id = '$t'
			HAVING (allowforum = 1 AND allowtopic = 1) OR (ismod = 1 AND trash = 0) OR ismon = 1", __FILE__, __LINE__);
			if($topic){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function allowPost($p,$uid=uid){
		$ulv=($uid == uid ? ulv : $this->mysql->get("user","level",$uid));
		if($ulv == 4){
			return true;
		}
		else{
			$post=$this->mysql->queryAssoc("SELECT p.trash AS posttrash,t.trash AS topictrash,
				IF( ($ulv > 1 AND NOT ISNULL(m.id)) OR ($ulv = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismod,
				IF( ($ulv = 3 AND NOT ISNULL(c.id)) ,1,0) AS ismon,
				IF( (f.hidden = 0 AND $ulv >= f.level OR NOT ISNULL(fu.id)) ,1,0) AS allowforum,
				IF( (t.trash = 0 AND (t.moderate = 0 OR t.author = $uid) AND (t.hidden = 0 OR t.author = $uid OR NOT ISNULL(tu.id))) ,1,0) allowtopic,
				IF( (p.trash = 0 AND (p.moderate = 0 OR p.author = $uid) AND (p.hidden = 0 OR p.author = $uid)) ,1,0) allowpost
			FROM ".prefix."post AS p
			LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)
			LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
			LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = $uid)
			LEFT JOIN ".prefix."topicusers AS tu ON(tu.topicid = t.id AND tu.userid = $uid)
			LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = $uid)
			LEFT JOIN ".prefix."category AS c ON(c.id = f.catid AND c.monitor = $uid)
			WHERE p.id = '$p'
			HAVING (allowforum = 1 AND allowtopic = 1 AND allowpost) OR (ismod = 1 AND topictrash = 0 AND posttrash = 0) OR ismon = 1", __FILE__, __LINE__);
			if($post){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function sendMail($to,$subject,$message,$from='',$fromname='',$toname=''){
		global $mysql;
		if(empty($to)){
			return false;
		}
		$headers="";
		$charset='utf-8';
		$message=str_replace("\n","<br>",$message);
		$message=$this->mailEnCode($message,$charset,false);
		$subject=$this->mailEnCode($subject,$charset);
		$forumTitle=$this->mailEnCode(forum_title,$charset);
		if(!empty($toname)){
			$to="To: {$this->mailEnCode($toname,$charset)} <$to>";
		}
		if(empty($from)){
			$headers.="From: $forumTitle <".forum_email.">\r\n";
		}
		else{
			if(!empty($fromname)){
				$forumTitle.=":{$this->mailEnCode($fromname,$charset)}";
			}
			$headers.="From: $forumTitle <$from>\t\n";
		}
		$headers.="Sender: ".forum_email."\t\n";
		$headers.="Return-Path: ".forum_email."\t\n";
		$headers.="MIME-Version: 1.0\t\n";
		$headers.="Content-Type: text/html; charset=\"$charset\"\t\n";
		$headers.="Content-Transfer-Encoding: 8bit\t\n";
		$headers.="X-Priority: 3\t\n";
		$headers.="X-Mailer: DuhokForum Mail By PHP\t\n";
		@ini_set('sendmail_from',forum_email);
		$result=@mail($to,$subject,$message,trim($headers));
		return $result;
	}
	function mailEnCode($text,$charset,$base=true){
		if($base){
			$text="=?$charset?B?".base64_encode($text)."?=";
		}
		return $text;
	}
	function fullNumber($int,$dig=2){
		$int=(string)$int;
		$len=strlen($int);
		$min=($dig-$len);
		for($x=0;$x<$min;$x++){
			$int="0{$int}";
		}
		return $int;
	}
	function inlineText($text){
		$tabs=array("\n","\t","\r");
		$text=str_replace($tabs,"",trim($text));
		return $text;
	}
	function arrayDeleteValue($array, $value){
		if(!is_array($array)){
			return array();
		}
		$new_array = array();
		foreach($array as $key => $val){
			if($val != $value){
				$new_array["{$key}"] = $val;
			}
		}
		return $new_array;
	}
	function deleteArrayBlanks($array){
		if(is_array($array)){
			$arr=array();
			foreach($array as $key=>$val){
				$val=trim($val);
				if(!empty($val)){
					$arr[$key]=$val;
				}
			}
			return $arr;
		}
		else{
			return $array;
		}
	}
	function search( $text, $properties = [] ){
		if( !is_array($properties) ){
			$properties = [];
		}
		if( !isset($properties['strip_symbols']) ){
			$properties['strip_symbols'] = true;
		}
		if( !isset($properties['strip_space']) ){
			$properties['strip_space'] = true;
		}
		$properties['search'] = true;
		return $this->text_convert( $text, $properties );
	}
	function text_convert( $text, $properties = [] ){
		$text = "{$text}";
		if( strlen($text) == 0 ){
			return '';
		}
		
		if( !is_array($properties) ){
			$properties = [];
		}
		
		$except = ( gettype($properties['except']) == 'array' ) ? $properties['except'] : [];
		$strip = ( gettype($properties['strip']) == 'array' ) ? $properties['strip'] : [];
		$strip_symbols = ( $properties['strip_symbols'] === true ) ? true : false;
		$strip_space = ( $properties['strip_space'] === true ) ? true : false;
		$inline = ( $properties['inline'] === true ) ? true : false;
		$search = ( $properties['search'] === true ) ? true : false;
		$post = ( $properties['post'] === true ) ? true : false;
		
		$symbols = [
			'`', '~', '!', '@', '#', '$', '%', '^', '&', '\\',
			'(', ')', '{', '}', '[', ']', '<', '>', "'", '"',
			'=', '+', '-', '*', '/', '_', '.', ',', '?', '|',
			':', ';'
		];
		
		$strips = [];
		
		if( count($strip) > 0 ){
			$strips = array_merge($strips, $strip);
		}
		
		if( $strip_symbols ){
			$strips = array_merge($strips, $symbols);
		}
	
		if( count($except) > 0 ){
			$new_strips = [];
			foreach( $strips as $strip_value ){
				if( in_array($strip_value, $except) ){
					continue;
				}
				$new_strips[] = $strip_value;
			}
			$strips = $new_strips;
		}
		
		if( $strip_space ){
			$text = preg_replace('/(\s*)/', '', $text);
		}
		
		if( $search ){
			$new_strips = [];
			foreach( $strips as $strip_value ){
				if( $strip_value == '*' ){
					continue;
				}
				$new_strips[] = $strip_value;
			}
		   	$strips = $new_strips;
		}
		
		if( $post ){
			$text = preg_replace( '/([\%])/', '*', $text);
		}
		
		if( count($strips) > 0 ){
			$text = preg_replace('/('.implode("|\\", $strips).')/', '', $text);
		}

		if( $inline ){
			$text = $this->inline_string($text);
		}
		
		if( $search ){
			$text = preg_replace( '/([\*])/', '%', $text);
		}

		return $text;
	}
	function inline_string($string){
		$string = str_replace(
			array("\n", "\t", "\r"),
			'',
			$string
		);
		return $string;
	}
	function preg_except( $regexp, $text ){
		preg_match_all( $regexp, $text, $matches);
		$text = trim( iconv( 'utf-8', 'utf-8//IGNORE', implode("", $matches[0]) ) );
		return $text;
	}
	function cleanCharacters($name){
		$name=str_replace(array("\r","\t","\n","\xA0","\0","\x0B"," ","&nbsp;"),"",$name);
		return $name;
	}
	function findBadWords( $str, $bads2 = [] ){
		$bads = ["\"","@","'","|","\\",".","ـ","[","]","{","}","(",")","<",">","?","؟",",","~","!","#","$","%","^","&","*","=","+","_","-","`","/",":",";","،","‘","÷","×","؛","’"];
		if( !is_array($bads2) ) $bads2 = [];
		$bads = array_merge( $bads, $bads2 );
		foreach( $bads as $val ){
			if( $this->indexOf( $str, $val ) >= 0 ){
				return $val;
			}
		}
		return 1;
	}
	function findUrl($text){
		$find=(preg_match("/<a/i",$text) ? true : false);
		return $find;
	}
	/**
     * If the mysql found any error will write to the error's forlder by this function.
     */
	function error( $subject = '[Error Subject]', $message = '[Error Message]', $file = '[No File]', $line = '[No Line]', $display = true ){
		$error_number = mt_rand(1000000, 9999999);
		$error_number_text = "Error No: {$error_number}";
		if( $display ){
			// if( mlv == 4 ){
				echo "
                <div dir=\"ltr\">
                    <table dir=\"ltr\" cellpadding=\"5\" width=\"500\" style=\"margin:10px;background-color:#fff\">
                        <tr>
							<td style=\"color:#000;\">Platform: {$this->config['mail']['subject']}<br>{$error_number_text}</td>
                        </tr>
                        <tr>
                            <td style=\"color:#000;\">{$subject}</td>
                        </tr>
                        <tr>
                            <td style=\"color:#000;\">
                                <hr>
                                {$message}<br>
                                <div style=\"color:#888\">&gt; File Name: {$file}</div>
                                <div style=\"color:#888\">&gt; Line Number: {$line}</div>
                            </td>
                        </tr>
                    </table>
                </div>";
			// }
			// else{
			// 	echo "<div dir=\"ltr\" style=\"font:normal 12px tahoma,arial;\">{$error_number_text}</div>";
			// }
		}
	}
	function checkHTML($text,$blockLinks=false){
		$SQ="{s}";
		$EQ="{e}";
		$deleteWords=array($SQ,$EQ,"<d>","</d>");
		$singleTags=array('img','br','hr');
		$block=array('script','style','textarea');
		$blockPreg=implode("|",$block);
		$blockTags=unserialize(blocked_tags);
		$blocked_attributes=unserialize(blocked_attributes);
		$text=str_replace($deleteWords,"",$text);
		$text=preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/i",'<\\1>',$text);
		$text=preg_replace("/<($blockPreg)[^>]*>(.*)($blockPreg)([[:space:]]*)>/siU",'',$text);
		$blocked_attributes_text = implode("|",$blocked_attributes);
		$text=preg_replace("/$blocked_attributes_text/i",'NOOP',$text);
		$single_tags_text = implode("|",$singleTags);
		$text=preg_replace("/<(".preg_quote($single_tags_text, '/')."*)[[:space:]]*([^>]*)>/i",$SQ.'\\1 \\2'.$EQ,$text);
		if(count($blockTags)>0){
			$block_tags_text = implode("|",$blockTags);
			$text=preg_replace("/<(".preg_quote($block_tags_text, '/')."*)[[:space:]]*([^>]*)>/i",'',$text);
		}
		if($blockLinks){
			$text=preg_replace("/<a(.*)>/i",'-- الروابط ممنوعة --',$text);
		}
		while(preg_match("/<([[:alpha:]]*)[[:space:]]*([^>]*)>/",$text,$reg)){
			$fullTag=$reg[0];
			$tag=$reg[1];
			$close="</$reg[1]>";
			$att=$reg[2];
			if($tag == ''||!preg_match("/".preg_quote($close, '/')."/",$text)){
				$i=strpos($text,$fullTag);
				$text=substr($text,0,$i).substr($text,$i+strlen($fullTag));
			}
			else{
				$i=strpos($text,$fullTag);
				$i2=$i+strlen($fullTag);
				$text1=substr($text,0,$i).(!empty($att) ? "{$SQ}$tag $att{$EQ}" : "{$SQ}$tag{$EQ}");
				$textB=substr($text,$i2);
				$s=strpos($textB,$close);
				$s2=$s+strlen($close);
				$text2=substr($textB,0,$s)."{$SQ}/$tag{$EQ}";
				$text3=substr($textB,$s2);
				$text="$text1$text2$text3";
			}
		}
		$text=str_replace($SQ,"<",$text);
		$text=str_replace($EQ,">",$text);
		$text=$this->convertBadWords($text);
		return $text;
	}
	function cleanHTML($text, $inline = false){
        $text=preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/i",'<\\1>',$text);
		$text=str_replace(array("<d>","</d>"),"",$text);
        $text=preg_replace("/<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>/i",'',$text);
        $text=preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?javascript[[:punct:]]*\"?[^>]*>/i",'',$text);
        $temp="";
        while(preg_match("/<(\/?[[:alpha:]]*)[[:space:]]*([^>]*)>/",$text,$reg)){
                $i=strpos($text,$reg[0]);
                $l=strlen($reg[0]);
                if($reg[1][0] == "/"){
					$tag=strtolower(substr($reg[1],1));
				}
                else{
					$tag=strtolower($reg[1]);
				}
                $temp.=substr($text,0,$i);
                $text=substr($text,$i+$l);
        }
        $text = $temp.$text;
		if($inline){
			$text = $this->inlineText($text);
		}
        return trim($text);
	}
	function cleanText($text, $icnov = false){
		$text = $this->cleanHTML($text);
		$text = $this->convertBadWords($text);
		return $text;
	}
	function clean($array){
		if(!is_array($array)){
			$array = array();
		}
		$_VARS = array(
			'p' => $GLOBALS['_POST'],
			'g' => $GLOBALS['_GET'],
			'f' => $GLOBALS['_FILES'],
			'c' => $GLOBALS['_COOKIE'],
			's' => $GLOBALS['_SERVER'],
			'e' => $GLOBALS['_ENV'],
			'r' => $GLOBALS['_REQUEST'],
			'a' => $GLOBALS,
			'v' => $GLOBALS
		);
		foreach($array as $name => $properties){
			$method = $properties[0];
			$type = $properties[1];
			$mydata = (isset($properties[2]) ? $properties[2] : '');
			$data = (!empty($mydata) ? $mydata : $_VARS["{$method}"]["{$name}"]);
			if(is_array($type)){
				$types = $type;
			}
			else{
				$types = array();
				$types[] = $type;
			}
			foreach($types as $type){
				if(is_array($data)){
					$data = $this->cleanArray($data, $type);
				}
				else{
					$data = $this->doClean($data, $type);
				}
			}
			$this->vars["{$name}"] = $data;
		}
	}
	function cleanArray($data, $type){
		if(is_array($data)){
			foreach($data as $name => $sub_data){
				$data["{$name}"] = $this->cleanArray($sub_data, $type);
			}
		}
		else{
			return $this->doClean($data, $type);
		}
		return $data;
	}
 	function doClean($data, $type){
		switch($type){
			case TYPE_INT:				$data = intval($data);																break;
			case TYPE_FLOAT:			$data = floatval($data);															break;
			case TYPE_BOOL:				$data = in_array(strtolower($data), array('1', 'true')) ? 1 : 0;					break;
			case TYPE_STR:				$data = "{$data}";																	break;
			case TYPE_TRIM:				$data = trim("{$data}");															break;
			case TYPE_ARRAY:			$data = (is_array($data)) ? $data : array();										break;
			case TYPE_ARRAYBLANK:		$data = (is_array($data)) ? $this->cleanArrayBlank($data,'all') : array();			break;
			case TYPE_ARRAYKEYBLANK:	$data = (is_array($data)) ? $this->cleanArrayBlank($data,'key') : array();			break;
			case TYPE_ARRAYVALBLANK:	$data = (is_array($data)) ? $this->cleanArrayBlank($data,'val') : array();			break;
			case TYPE_SERIALIZE:		$data = $this->serialize($data);													break;
			case TYPE_UNSERIALIZE:		$data = $this->unserialize($data);													break;
			case TYPE_STRTOUPPER:		$data = strtoupper("{$data}");														break;
			case TYPE_STRTOLOWER:		$data = strtolower("{$data}");														break;
			case TYPE_BINARY:			$data = "{$data}";																	break;
			case TYPE_NOHTML:			$data = $this->noHTML($data);														break;
			case TYPE_EASYHTML:			$data = $this->easyHTML($data);														break;
			case TYPE_FULLHTML:			$data = $this->fullHTML($data);														break;
			case TYPE_ENCODEHTML:		$data = $this->encodeHTML($data);													break;
			case TYPE_DECODEHTML:		$data = $this->decodeHTML($data);													break;
			case TYPE_INLINE:			$data = $this->inlineString($data);													break;
			case TYPE_BADWORDS:			$data = $this->convertBadWords($data);												break;
			case TYPE_FILE:{
				if(is_array($data)){
					if(is_array($data['name'])){
						$files = count($data['name']);
						for($x = 0; $x < $files; $x++){
							$data['name']["{$x}"] = trim(strval($data['name']["{$x}"]));
							$data['type']["{$x}"] = trim(strval($data['type']["{$x}"]));
							$data['tmp_name']["{$x}"] = trim(strval($data['tmp_name']["{$x}"]));
							$data['error']["{$x}"] = intval($data['error']["{$x}"]);
							$data['size']["{$x}"] = intval($data['size']["{$x}"]);
						}
					}
					else{
						$data['name'] = trim(strval($data['name']));
						$data['type'] = trim(strval($data['type']));
						$data['tmp_name'] = trim(strval($data['tmp_name']));
						$data['error'] = intval($data['error']);
						$data['size'] = intval($data['size']);
					}
				}
				else{
					$data = array(
						'name'     => '',
						'type'     => '',
						'tmp_name' => '',
						'error'    => 0,
						'size'     => 4,
					);
				}
				break;
			}
			case TYPE_NO:{
				break;
			}
			default:{
				trigger_error("<strong>DM->clean()</strong> unknown type", E_USER_ERROR);
			}
		}
		return $data;
	}
	function convertBadWords($text){
		if(is_array($this->catch['badwords'])){
			$badwords = $this->catch['badwords'];
		}
		else{
			$badwords = array();
			$sql = $this->mysql->query("SELECT code,val FROM ".prefix."bad_words", __FILE__, __LINE__);
			while($rs = $this->mysql->fetchRow($sql)){
				$badwords["{$rs[0]}"] = $rs[1];
			}
		}
		foreach($badwords as $code => $val){
			$text = preg_replace('/'.preg_quote($code, '/').'/i', $val, $text);
		}
		return $text;
	}
	function inlineString($string){
		$string = str_replace(
			array("\n", "\t", "\r"),
			'',
			$string
		);
		return $string;
	}
	function easyHTML($html){
		if(!isset($this->catch['blocked_tags'])){
			$this->catch['blocked_tags'] = $this->unserialize($this->DFOutput->getCnf('blocked_tags'));
		}
		if(!isset($this->catch['blocked_attributes'])){
			$this->catch['blocked_attributes'] = $this->unserialize($this->DFOutput->getCnf('blocked_attributes'));
		}
		$html = $this->fullHTML(
			$html,
			array(
				'maintags' => array('script','style','textarea'), // Block main tags
				'tags' => $this->catch['blocked_tags'], // Block tags
				'attr' => $this->catch['blocked_attributes'] // Block attributes
			)
		);
		return $html;
	}
	function fullHTML($text, $block=array()){
		$SQ = "{s}";
		$EQ = "{e}";
		$single_tags = array('img', 'br', 'hr');
		$text = preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/i", '<\\1>', $text);
		if(is_array($block['maintags']) && count($block['maintags']) > 0){
			$maintags = implode("|", $block['maintags']);
			$text = preg_replace("#<({$maintags})[^>]*>(.*)({$maintags})([[:space:]]*)>#siU", '', $text);
		}
		if(is_array($block['tags']) && count($block['tags']) > 0){
			$tags = implode("|", $block['tags']);
			$text = preg_replace("/<({$tags}$*)[[:space:]]*([^>]*)>/i", '', $text);
		}
		if(is_array($block['attr']) && count($block['attr']) > 0){
			$attr = implode("|", $block['attr']);
			$text = preg_replace("/{$attr}/i", 'NOOP', $text);
		}
		$text = preg_replace("/<({$single_tags}$*)[[:space:]]*([^>]*)>/i", $SQ.'\\1 \\2'.$EQ, $text);
		while(preg_match("/<([[:alpha:]]*)[[:space:]]*([^>]*)>/", $text, $reg)){
			$fullTag = $reg[0];
			$tag = $reg[1];
			$close = "</{$reg[1]}>";
			$att = $reg[2];
			if($tag == '' || !preg_match("/$close/", $text)){
				$i = strpos($text, $fullTag);
				$text = substr($text, 0, $i).substr($text, $i+strlen($fullTag));
			}
			else{
				$i = strpos($text, $fullTag);
				$i2 = $i+strlen($fullTag);
				$text1 = substr($text, 0, $i).(!empty($att) ? "{$SQ}$tag $att{$EQ}" : "{$SQ}$tag{$EQ}");
				$textB = substr($text, $i2);
				$s = strpos($textB, $close);
				$s2 = $s+strlen($close);
				$text2 = substr($textB, 0, $s)."{$SQ}/$tag{$EQ}";
				$text3 = substr($textB, $s2);
				$text = "$text1$text2$text3";
			}
		}
		$text = str_replace($SQ, "<", $text);
		$text = str_replace($EQ, ">", $text);
		return $text;
	}
	function noHTML($text){
        $text = preg_replace("/<[[:space:]]*([^>]*)[[:space:]]*>/", '<\\1>', $text);
        $text = preg_replace("/<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>/", '', $text);
        $text = preg_replace("/<a[^>]*href[[:space:]]*=[[:space:]]*\"?javascript[[:punct:]]*\"?[^>]*>/", '', $text);
        $temp = "";
		while(preg_match("/<(\/?[[:alpha:]]*)[[:space:]]*([^>]*)>/", $text, $reg)){
                $i = strpos($text, $reg[0]);
                $l = strlen($reg[0]);
                if($reg[1][0] == "/"){
					$tag = strtolower(substr($reg[1], 1));
				}
                else{
					$tag = strtolower($reg[1]);
				}
                $temp .= substr($text, 0, $i);
                $text = substr($text, $i+$l);
        }
        $text = $temp.$text;
        return trim($text);
	}
	function encodeHTML($text){
		$text = stripslashes($text);
		return str_replace(
			array('<', '>', '"'),
			array('&lt;', '&gt;', '&quot;'),
			$text
		);
	}
	function decodeHTML($text){
		return str_replace(
			array('&lt;', '&gt;', '&quot;', "\n"),
			array('<', '>', '"', '<br>'),
			$text
		);
	}
	function cleanArrayBlank($data, $type = 'all'){
		if(is_array($data)){
			foreach($data as $key => $sub_data){
				if(($type == 'all' or $type == 'key') and gettype($key) == 'string'){
					$key = trim($key);
					if(empty($key)){
						$data = array_diff_key($data, array('' => true));
						continue;
					}
				}
				if(is_array($sub_data)){
					$data["{$key}"] = $this->cleanArrayBlank($sub_data, $type);
				}
				else{
					if(($type == 'all' or $type == 'val') and gettype($sub_data) == 'string'){
						$sub_data = trim($sub_data);
						if(empty($sub_data)){
							unset($data["{$key}"]);
							continue;
						}
					}
				}
			}
		}
		return $data;
	}
	function serialize($array){
		if(!is_array($array)){
			$array = array();
		}
		$string = serialize($array);
		return $string;
	}
	function unserialize($string){
		$string = trim($string);
		if(!empty($string)){
			$array = unserialize($string);
		}
		else{
			$array = array();
		}
		if(!is_array($array)){
			$array = array();
		}
		return $array;
	}
	function cleanQuery($string){
		$hackerKeys=array(
			'chr(','chr=','chr%20','%20chr','wget%20','%20wget','wget(','cmd=','%20cmd','cmd%20','rush=','%20rush',
			'rush%20','union%20','%20union','union(','union=','echr(','%20echr','echr%20','echr=','esystem(',
			'esystem%20','cp%20','%20cp','cp(','mdir%20','%20mdir','mdir(','mcd%20','mrd%20','rm%20','%20mcd',
			'%20mrd','%20rm','mcd(','mrd(','rm(','mcd=','mrd=','mv%20','rmdir%20','mv(','rmdir(','chmod(',
			'chmod%20','%20chmod','chmod(','chmod=','chown%20','chgrp%20','chown(','chgrp(','locate%20','grep%20',
			'locate(','grep(','diff%20','kill%20','kill(','killall','passwd%20','%20passwd','passwd(','telnet%20',
			'vi(','vi%20','insert%20into','select%20','nigga(','%20nigga','nigga%20','fopen','fwrite','%20like',
			'like%20','$_request','$_get','$request','$get','.system','http_php','&aim','%20getenv','getenv%20',
			'new_password','/etc/password','/etc/shadow','/etc/groups','/etc/gshadow','http_user_agent',
			'http_host','/bin/ps','wget%20','uname\x20-a','/usr/bin/id','/bin/echo','/bin/kill','/bin/','/chgrp',
			'/chown','/usr/bin','g\+\+','bin/python','bin/tclsh','bin/nasm','perl%20','traceroute%20','ping%20',
			'.pl','/usr/x11r6/bin/xterm','lsof%20','/bin/mail','.conf','motd%20','http/1.','.inc.php','config.php',
			'cgi-','.eml','file\://','window.open','<script>','javascript\://','img src','img%20src','.jsp',
			'ftp.exe','xp_enumdsn','xp_availablemedia','xp_filelist','xp_cmdshell','nc.exe','.htpasswd','servlet',
			'/etc/passwd','wwwacl','~root','~ftp','.js','.jsp','.history','bash_history','.bash_history','~nobody',
			'server-info','server-status','reboot%20','halt%20','powerdown%20','/home/ftp','/home/www',
			'secure_site,ok','chunked','org.apache','/servlet/con','<script','/robot.txt','/perl',
			'mod_gzip_status','db_mysql.inc','.inc','select%20from','select from','drop%20','.system','getenv',
			'http_','_php','<?php','?>','sql=','_global','global_','global[','_server','server_','server[',
			'phpadmin','root_path','_globals','globals_','globals[','iso-8859-1','http://www.google.de/search',
			'?hl=','.txt','.exe','union','google.de/search','yahoo.de','lycos.de','fireball.de','iso-'
		);
		$string = strtolower($string);
		$proString = str_replace($hackerKeys, '******', $string);
		if($string != $proString){
			$place = $_SERVER['REQUEST_URI'];
			$ip = ip;
			$date = $this->date(time, "", true, true, true);
			$file = "attempts/attempts.log";
			$content = @file($file);
			$content = @array_slice($content, 0, 1000);
			$content = @implode("", $content);
			$f = @fopen($file, "w");
			@chmod($file, 0777);
			@fwrite($f, "{$place}{>:c:<}{$ip}{>:c:<}{$date}{>:r:<}\r\n{$content}");
			@chmod($file, 0640);
			@fclose($f);
			echo"
			<html dir=\"rtl\">
			<head>
			<title>عملية غير مصرح بها</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
			<meta http-equiv=\"Content-Language\" content=\"ar-iq\" />
			<meta name=\"description\" content=\"Powered by DuhokForum 2.0\" />
			<meta name=\"copyright\" content=\"DuhokForum 2.0: Copyright © 2007-2010 Dilovan\" />
			<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/reset.css".x."\" />
			<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/blue/style.css".x."\" />
			<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/arial.css".x."\" />
			<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/globals.css".x."\" />
			<link rel=\"stylesheet\" type=\"text/css\" href=\"js/dm/assets/style-1.0.css".x."\" />
			</head>
			<body>
			<center><br>
			<table width=\"99%\" border=\"1\">
				<tr>
					<td class=\"asNormalB asCenter\">
						<br><br><span class=\"asC4\">الرابط الدي اتبعثه غير صحيح أو بها عملية غير مصرحة.</span>
						<br><br>تم تشفير أكواد غير مصرحة بها:-<br><br>
						<span dir=\"ltr\">http://{$_SERVER['HTTP_HOST']}$proString</span><br><br>
						<hr width=\"60%\">{{ تم حفظ هذه العملية مع جميع معلوماتك, وإذا تتكرر مرة اخرى سيتم منعك من الموقع بأكمله }}<hr width=\"60%\">
						<br>قال الله تعالى : <font color=\"#000000\">((مايلفظ من قول إلا لديه رقيب عتيد ))</font> صدق الله العظيم.<br><br><br>
					</td>
				</tr>
			</table>
			</center>";
			exit();
		}
		return $proString;
	}
}

?>
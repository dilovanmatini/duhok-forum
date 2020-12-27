<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

function df_url_parts( $full_url, $part ){
	$parts = array(
		'ssl',				// true | false
		'protocol',			// http | https | ftp
		'host',				// sub.example.com | sub.example.com:2082 | example.com | example.com:2082 | 127.0.0.1 | 127.0.0.1:82
		'address',			// sub.example.com | example.com | localhost | 127.0.0.1
		'hostname',			// example.com | example.com | localhost | 127.0.0.1
		'port',				// 1 - 65535 | empty
		'url',				// http://example.com/
		'urldir',			// http://example.com/folder/subfolder/
		'urldirfile',		// http://example.com/folder/subfolder/index.php
		'dir',				// folder/subfolder/
		'dirfile',			// folder/subfolder/index.php
		'dirfileqs',		// folder/subfolder/index.php?one=1&two=2
		'file',				// index.php
		'fileqs',			// index.php?one=1&two=2
		'qs',				// one=1&two=2
		'fragment',			// #wertefgd
	);
	if( in_array($part, $parts) && !empty($full_url) ){
		if( $part == 'ssl' ){
			return preg_match("/^https/i", $full_url) ? true : false;
		}
		elseif( $part == 'protocol' ){
			preg_match("/^([a-z]*):\/\//i", $full_url, $matches);
			return strtolower($matches[1]);
		}
		elseif( $part == 'host' ){
			preg_match("/^(?:[a-z]*:\/\/)?([a-z0-9\.\-\:]+)/i", $full_url, $matches);
			return strtolower($matches[1]);
		}
		elseif( $part == 'address' ){
			preg_match("/^(?:[a-z]*:\/\/)?([a-z0-9\.\-]+)/i", $full_url, $matches);
			return strtolower($matches[1]);
		}
		elseif( $part == 'hostname' ){
			preg_match("/^(?:[a-z]*:\/\/)?([a-z0-9\.\-]+)/i", $full_url, $matches);
			$hostname = strtolower($matches[1]);
			$is_ip_address = filter_var( $hostname, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
			if( $is_ip_address ){
				return $hostname;
			}
			$hostname_parts = explode( ".", $hostname );
			if( count($hostname_parts) > 2 ){
				$hostname_parts = array_reverse($hostname_parts);
				$hostname = $hostname_parts[1].'.'.$hostname_parts[0];
			}
			return $hostname;
		}
		elseif( $part == 'port' ){
			preg_match("/:([0-9]+)/", $full_url, $matches);
			return intval($matches[1]);
		}
		elseif( $part == 'url' ){
			preg_match("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)/i", $full_url, $matches);
			return $matches[1].'/';
		}
		elseif( $part == 'urldir' ){
			preg_match("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)/i", $full_url, $matches);
			$url = $matches[1];
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)/i", "", $full_url);
			while( strpos($full_url, '?') !== false ){
				$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
			}
			$full_url = preg_replace("/([^\/]+)$/", "", $full_url);
			if( !preg_match("/\/+$/", $full_url) ){
				$full_url = $full_url.'/';
			}
			return $url.$full_url;
		}
		elseif( $part == 'urldirfile' ){
			preg_match("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)/i", $full_url, $matches);
			$url = $matches[1];
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)/i", "", $full_url);
			if( strpos($full_url, '?') === false ){
				while( strpos($full_url, '?') !== false ){
					$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
				}
				if( empty($full_url) ){
					$full_url = $full_url.'/';
				}
			}
			else{
				while( strpos($full_url, '?') !== false ){
					$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
				}
			}
			return $url.$full_url;
		}
		elseif( $part == 'dir' ){
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)(\/?)/i", "", $full_url);
			while( strpos($full_url, '?') !== false ){
				$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
			}
			$full_url = preg_replace("/([^\/]+)$/", "", $full_url);
			$full_url = preg_replace("/([\/]?)$/", "", $full_url);
			return $full_url.'/';
		}
		elseif( $part == 'dirfile' ){
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)(\/?)/i", "", $full_url);
			while( strpos($full_url, '?') !== false ){
				$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
			}
			if( empty($full_url) ){
					$full_url = $full_url.'/';
			}
			return $full_url;
		}
		elseif( $part == 'dirfileqs' ){
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)(\/?)/i", "", $full_url);
			return $full_url;
		}
		elseif( $part == 'file' ){
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)(\/?)/i", "", $full_url);
			while( strpos($full_url, '?') !== false ){
				$full_url = preg_replace("/(\?+)([^\?]*)$/", "", $full_url);
			}
			preg_match("/([^\/]*)$/", $full_url, $matches);
			$full_url = $matches[1];
			return $full_url;
		}
		elseif( $part == 'fileqs' ){
			$full_url = preg_replace("/^([a-z]*:?\/?\/?[a-z0-9\.\-\:]+)(\/?)/i", "", $full_url);
			$qs = preg_replace("/^([^\?]+)/", "", $full_url);
			while( strpos($full_url, '?') !== false ){
				$full_url = preg_replace("/(\??)([^\?]*)$/", "", $full_url);
			}
			preg_match("/([^\/]*)$/", $full_url, $matches);
			$full_url = $matches[1].$qs;
			return $full_url;
		}
		elseif( $part == 'qs' ){
			$full_url = preg_replace("/^([^\?]+)(\??)/", "", $full_url);
			while( strpos($full_url, '#') !== false ){
				$full_url = preg_replace("/(#?)([^#]*)$/", "", $full_url);
			}
			return $full_url;
		}
		elseif( $part == 'fragment' ){
			return preg_replace("/^([^#]+)(#?)/", "", $full_url);
		}
	}
	return '';
}
function df_get_url( $type = '', $options = [] ){
	if( !is_array($options) ){
		$options = [];
	}
	
	$types = array(
		'ssl',
		'protocol',
		'host',
		'address',
		'hostname',
		'port',
		'url'
	);
	if( !in_array($type, $types) ){
		$type = 'url';
	}

	$url = isset($options['url']) ? trim($options['url']) : '';

	if( isset($options['ssl']) ){
		$ssl = is_bool($options['ssl']) ? $options['ssl'] : false;
	}
	else{
		if( !empty($url) ){
			$ssl = df_url_parts( $url, 'ssl' );
		}
		else{
			$ssl = ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? true : false;
		}
	}
	
	if( $type == 'ssl' ){
		return $ssl;
	}

	if( isset($options['protocol']) ){
		$protocol = $options['protocol'];
	}
	else{
		if( !empty($url) ){
			$protocol = df_url_parts( $url, 'protocol' );
		}
		else{
			$server_protocol = strtolower($_SERVER['SERVER_PROTOCOL']);
			$protocol = substr($server_protocol, 0, strpos($server_protocol, '/')) . ( $ssl ? 's' : '' );
		}
	}
	if( empty($protocol) ){
		$protocol = 'http';
	}

	if( $type == 'protocol' ){
		return $protocol;
	}
	
	if( isset($options['port']) ){
		$port = $options['port'];
	}
	else{
		if( !empty($url) ){
			$port = df_url_parts( $url, 'port' );
			if( $port == 0 ){
				if( $ssl ){
					$port = 443;
				}
				else{
					$port = 80;
				}
			}
		}
		else{
			$port = $_SERVER['SERVER_PORT'];
			$port = ( ( !$ssl && $port=='80' ) || ( $ssl && $port == '443' ) ) ? '' : ':'.$port;
		}
	}
	$port = intval($port);
	if( $port < 1 && $port > 65535 ){
		$port = 0;
	}
	
	if( $type == 'port' ){
		return $port;
	}
	
	$port_str = ( $port == 0 || ( !$ssl && $port == '80' ) || ( $ssl && $port == '443' ) ) ? '' : ':'.$port;

	if( isset($options['address']) ){
		$address = $options['address'];
	}
	else{
		if( !empty($url) ){
			$address = df_url_parts( $url, 'address' );
		}
		else{
			$address = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
			$address = preg_replace("/[:]+[^:]*+/", "", $address);
		}
	}
	
	if( $type == 'address' ){
		return $address;
	}
	
	if( isset($options['hostname']) ){
		$hostname = $options['hostname'];
	}
	else{
		if( !empty($url) ){
			$hostname = df_url_parts( $url, 'hostname' );
		}
		else{
			$hostname = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
			$hostname = preg_replace("/[:]+[^:]*+/", "", $hostname);
			$hostname = df_url_parts( $hostname, 'hostname' );
		}
	}
	
	if( $type == 'hostname' ){
		return $hostname;
	}
	
	if( isset($options['host']) ){
		$host = $options['host'];
	}
	else{
		$host = $address.$port_str;
	}
	
	if( $type == 'host' ){
		return $host;
	}
		
	if( $type == 'url' ){
		return $protocol.'://'.$host.'/';
	}
}
function df_url( $type = '', $options = [] ){
	if( !is_array($options) ){
		$options = [];
	}
	$types = array(
		'ssl',				// true | false
		'protocol',			// http | https | ftp
		'host',				// sub.example.com | sub.example.com:2082 | example.com | example.com:2082 | 127.0.0.1 | 127.0.0.1:82
		'address',			// sub.example.com | example.com | localhost | 127.0.0.1
		'hostname',			// example.com | localhost | 127.0.0.1
		'port',				// 1 - 65535 | empty
		'url',				// http://example.com/
		'urldir',			// http://example.com/folder/subfolder/
		'urldirfile',		// http://example.com/folder/subfolder/index.php
		'fullurl',			// http://example.com/folder/subfolder/index.php?index.php?one=1&two=2#wertefgd
		'dir',				// folder/subfolder/
		'dirfile',			// folder/subfolder/index.php
		'dirfileqs',		// folder/subfolder/index.php?one=1&two=2
		'file',				// index.php
		'fileqs',			// index.php?one=1&two=2
		'qs',				// one=1&two=2
		'fragment',			// #wertefgd
	);
	
	if( !in_array($type, $types) ){
		$type = 'fullurl';
	}
	
	if(
		$type == 'ssl' ||
		$type == 'protocol' ||
		$type == 'host' ||
		$type == 'address' ||
		$type == 'hostname' ||
		$type == 'port' ||
		$type == 'url'
	){
		return df_get_url( $type, $options );
	}
	else{
		if(
			$type == 'urldir' ||
			$type == 'urldirfile' ||
			$type == 'fullurl'
		){
			$url = df_get_url( 'url', $options );
		}
		else{
			$url = 'http://example.com/';
		}
		
		$full_url = ( isset($options['url']) && !empty($options['url']) ) ? trim($options['url']) : $url.preg_replace("/^\/+/", "", $_SERVER['REQUEST_URI']);
		
		if(
			$type == 'urldir' ||
			$type == 'urldirfile' ||
			$type == 'fullurl' ||
			$type == 'dir' ||
			$type == 'dirfile' ||
			$type == 'dirfileqs'
		){
			if( isset($options['dir']) ){
				$dir = $options['dir'];
			}
			else{
				$dir = df_url_parts( $full_url, 'dir' );
			}
		}
		
		if(
			$type == 'urldir' ||
			$type == 'urldirfile' ||
			$type == 'fullurl'
		){
			if( $dir == '/' ){
				$dir = '';
			}
		}
		
		if(
			$type == 'urldirfile' ||
			$type == 'fullurl' ||
			$type == 'dirfile' ||
			$type == 'dirfileqs' ||
			$type == 'file' ||
			$type == 'fileqs'
		){
			if( isset($options['file']) ){
				$file = $options['file'];
			}
			else{
				$file = df_url_parts( $full_url, 'file' );
			}
		}
		
		if(
			$type == 'fullurl' ||
			$type == 'dirfileqs' ||
			$type == 'fileqs' ||
			$type == 'qs'
		){
			if( isset($options['qs']) ){
				$qs = $options['qs'];
			}
			else{
				$qs = df_url_parts( $full_url, 'qs' );
			}
			if( !empty($qs) ){
				$qs = '?'.$qs;
			}
		}
		
		if(
			$type == 'fullurl' ||
			$type == 'dirfileqs' ||
			$type == 'fileqs' ||
			$type == 'fragment'
		){
			if( isset($options['fragment']) ){
				$fragment = $options['fragment'];
			}
			else{
				$fragment = df_url_parts( $full_url, 'fragment' );
			}
			if( !empty($fragment) ){
				$fragment = '#'.$fragment;
			}
		}

		if( $type == 'urldir' ){
			return $url.$dir;
		}
		elseif( $type == 'urldirfile' ){
			return $url.$dir.$file;
		}
		elseif( $type == 'dir' ){
			return $dir;
		}
		elseif( $type == 'dirfileqs' ){
			return $dir.$file.$qs;
		}
		elseif( $type == 'file' ){
			return $file;
		}
		elseif( $type == 'fileqs' ){
			return $file.$qs;
		}
		elseif( $type == 'qs' ){
			return $qs;
		}
		elseif( $type == 'fragment' ){
			return $fragment;
		}
		elseif( $type == 'fullurl' ){
			return $url.$dir.$file.$qs.$fragment;
		}
	}
	return '';
}

function moderate($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(count($rs)>0){
		$moderate = [
			$rs['FORUM_ID'],
			$rs['SHOW_PROFILE'] 
		];
	}
	if($name == "ID"){$nom = 0;}
	if($name == "SHOW"){$nom = 1;}
	
	return($moderate[$nom]);
}


function member_view($ppMemberID){
	global $mysql;
	$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET view = view + 1 where  MEMBER_ID = '$ppMemberID'  ", [], __FILE__, __LINE__);
	return true;
}
function header_alert(){
echo'
			<td class="optionheader_selected"><nobr>المنتدى مقفول حاليا</nobr></td>
<tr>
';
}
function chk_admin_svc_class(){
    if(num_user_wait() > 0 || changename_count > 0){
		$class = "optionsbar_menus2";
    }
    else {
		$class = "optionsbar_menus";
    }
	return($class);
}

function admin_list(){
	echo'
	<td class="optionsbar_menus" rowspan="2">
	<select name="speed_tools" onchange="window.location = this.value" style="width:125px">
	<option value="">-- خيارات سريعة --</option>
	<option value="index.php?mode=svc&method=svc&svc=medals&app=ok&scope=mod">اوسمة مظافة مفتوحة</option>
	<option value="index.php?mode=svc&method=svc&svc=medals&app=wait&scope=mod">اوسمة مظافة تنتظر الموافقة</option>
	<option value="index.php?mode=svc&method=add&svc=medals">اضف وسام جديد</option>
	<option value="index.php">------------------------</option>
	<option value="index.php?mode=svc&svc=medals&app=ok&scope=mod&days=30">اوسمة موزعة تمت الموافقة عليها</option>
	<option value="index.php?mode=svc&svc=medals&app=wait&scope=mod&days=30">اوسمة موزعة تنتظر الموافقة</option>
	<option value="index.php?mode=svc&svc=medals&app=ok&scope=all&days=30">جميع الاوسمة الموزعة</option>
	<option value="index.php">------------------------</option>
	<option value="index.php?mode=svc&method=add&svc=titles">اضف وصف جديد</option>
	<option value="index.php?mode=svc&method=svc&svc=titles&app=wait&scope=all">اوصاف تنتظر الموافقة</option>
	<option value="index.php?mode=svc&method=svc&svc=titles&app=all&scope=all">جميع الاوصاف</option>
	<option value="index.php">------------------------</option>
	<option value="index.php?mode=admin_svc&type=change_name">الاسماء التي تنتظر الموافقة</option>
	<option value="index.php?mode=admin_svc&type=approve">عضويات تنتظر الموافقة</option>
	<option value="index.php?mode=members&type=lock">عضويات مقفولة</option>
	<option value="index.php">------------------------</option>
	<option value="index.php?mode=svc&method=svc&svc=surveys">استفساءات جارية الان</option>
	<option value="index.php?mode=svc&method=add&svc=surveys">اضف استفتاء الان</option>
	<option value="index.php">------------------------</option>
	<option value="index.php?mode=svc&method=svc&svc=mon&show=mon_pending">طلبات رقابة تنتظر الموافقة</option>
	<option value="index.php?mode=svc&method=svc&svc=mon&sel=5&show=cur">طلبات قفل العضوية</option>
	</select>
	</td>';
}

function visitor_show_forum(){
	global $CAN_SHOW_FORUM,$mode,$details,$lang;

	if($mode != "register" AND $mode != "policy"){
		if($CAN_SHOW_FORUM == 1 AND mlv == 0){
			die('<br><center>
			<table width="99%" border="1">
			<tr class="normal">
			<td class="list_center" colSpan="10"><font size="5" color="red"><br>لا يمكنك مشاهدة المنتديات لانك لست عضوا بالمنتدى  </font><br>ان كنت عضوا معنا فبرجاء تسجيل الدخول الى حسابك من الخيار اعلاه<br>وان لم تكن مسجلا , اضغط على الرابط اسفله للتسجيل .<br><br><a href="index.php?mode=policy">'.icons($details).'<br>'.$lang['header']['register'].'</a><br><br>
			</td>
			</tr>
			</table>
			</center>');
		}
	}
}

function confirm($confirm){
	$confirm = 'onclick="return confirm(\''.$confirm.'\');"';
	return $confirm;
}

function schat_online_num(){
	global $mysql;
	$count = 0;//$mysql->execute("select COUNT(*) from {$mysql->prefix}chat_online")->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	return $count;
}

function is_baned(){
	global $mysql;
	if(getenv('HTTP_X_FORWARDED_FOR')){ 
		$ip=getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('HTTP_CLIENT_IP')){ 
		$ip=getenv('HTTP_CLIENT_IP'); 
	}
	else{
		$ip=getenv('REMOTE_ADDR'); 
	}

	$check = $mysql->execute("SELECT * FROM {$mysql->prefix}IP_BAN WHERE IP = '$ip'")->fetch();

	if( is_array($check) ){
		if($check['DATE_UNBAN'] > time() || $check['DATE_UNBAN'] == 0){
			$ban = true;
		}
		else{
			$mysql->execute("DELETE FROM {$mysql->prefix}IP_BAN WHERE ID = '{$check['ID']}' ");
			$ban = false;
		}
		if($ban){
			die("
			<br>
			<center>
			<table width=\"99%\" border=\"1\">
			<tr class=\"normal\">
			<td class=\"list_center\" colSpan=\"10\"><font size=\"5\" color=\"red\"><br>لا تستطيع الدخول للمنتدى لانه قد تم حضرك</font><br><br><font size=\"3\" color=\"gray\"> السبب :</font> $check[WHY] <br><br>
			</td>
			</tr>
			</table>
			</center>
			");
		}
		return true;
	}
	return false;
}

// ########################################### Template Engine By The Picasso ##################################


function xml_parser($xml){
	global $mysql;
	// Get File Path
	$xml = file_get_contents($xml);

	// Get The Title Of Style And Fix it
	preg_match("/<style_name>(.*)<\/style_name>/i",$xml,$style_name);
	$S_Name = $style_name[0];
	$S_Name = preg_replace("#<style_name>(.*)</style_name>#si","$1",$S_Name);

	// Search All thing related to <template> </template> or between them
	preg_match_all("#<template>(.*?)</template>#s",$xml,$template);  
	$count = count($template[0]);

	for($i=0;$i<$count;$i++){

		$TMP = $template[0][$i];
		// Template Name
		preg_match("/<tmp_name>(.*)<\/tmp_name>/i",$TMP,$tmp_name);

		// array and replace delete some code because we dont have to use them

		$tmp_r = array("- <![CDATA[","<![CDATA[","]]>","<template>","</template>");

		$TMP = preg_replace("#<tmp_name>(.*)</tmp_name>#si","",$TMP);
		$TMP = str_replace($tmp_r,"",$TMP);
		$TMP = str_replace("]]>","",$TMP);

		// final round !!
		$TMP = addslashes($TMP);
		$TMP_NAME = preg_replace("#<tmp_name>(.*)</tmp_name>#si","$1",$tmp_name[0]);
		$mysql->execute("INSERT INTO {$mysql->prefix}TEMPLATES SET NAME = '$TMP_NAME',SOURCE = '$TMP',STYLE_NAME = '$S_Name'   ");

	}
}

// ########################################### Moderator Ip By The Picasso ##################################

function modo_ip($ip){
	$site_api = @file_get_contents("http://api.hostip.info/?ip=".$ip);
	preg_match("@<countryName>(.*?)</countryName>@si",$site_api,$match);
	$country=$match[1];
	return $country;
}

function my_ip(){
	global $mysql;
	if(mlv > 1){
		$result = $mysql->execute("SELECT * FROM {$mysql->prefix}IP WHERE M_ID = '".m_id."' ORDER BY ID DESC LIMIT 1 ")->fetch();
		$msg = ''.$result['IP'].' - '.$result['COUNTRY'].' <img src="http://api.hostip.info/flag.php" border="0" width="20" height="15">';
		if(getenv('HTTP_X_FORWARDED_FOR'))
		$ip=getenv('HTTP_X_FORWARDED_FOR'); elseif(getenv('HTTP_CLIENT_IP')) $ip=getenv('HTTP_CLIENT_IP'); else $ip=getenv('REMOTE_ADDR'); 
		if(!$result){
		$msg = $ip;
		}
		echo '<tr>
		<td class="user" align="left"><nobr><a href="index.php?mode=svc&svc=ip">تتبع الدخول: </a></nobr></td>
		<td class="user"><nobr><a href="index.php?mode=svc&svc=ip">&nbsp;<font color="gray">'.$msg.'</font></a></nobr></td>
		</tr>';
	}
}

function update_ip($type,$DBMemberID){
	global $mysql;
	if(getenv('HTTP_X_FORWARDED_FOR')){
		$ip=getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('HTTP_CLIENT_IP')){
		$ip=getenv('HTTP_CLIENT_IP');
	}
	else{
		$ip=getenv('REMOTE_ADDR'); 
	}
	$date=time();
	if($type==0){
		$num=$mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}IP WHERE M_ID = '$DBMemberID' AND IP = '$ip' AND TYPE = 0 ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
		$num=intval($num[0]);
	}
	elseif($type==1){
		$c_num=$mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}IP WHERE  IP = '$ip' AND TYPE = 1 ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
		$c_num=intval($c_num[0]);
		$num=0;
	}
	if($num == 0){
		$country=modo_ip($ip);
		if($type==1){
			$and=", TYPE = 1";
		}
		if($c_num==0){
			$mysql->execute("INSERT INTO {$mysql->prefix}IP SET M_ID = '$DBMemberID', IP = '$ip',DATE = '$date',COUNTRY = '$country' ".$and." ", [], __FILE__, __LINE__);
		}
	}
}


function redirect(){
	echo'
	<script language="JavaScript" type="text/javascript">
	window.location="index.php";
	</script>';
}

function head($link){
	header('Location: '.$link);
	exit();
}

function go_to($link){
	echo'
	<script language="JavaScript" type="text/javascript">
	window.location="'.$link.'";
	</script>';
}

function icons($url, $title = "", $any = ""){
    $icon="<img border='0' src='".$url."' alt='".$title."' ".$any.">";
    return($icon);
}

function abs2($num){
 $number = "-".$num;
 return($number);
}

//#################### members mysql function ##########################
function members($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$members = Array(
			$rs['M_NAME'], $rs['M_STATUS'], $rs['M_PASSWORD'], $rs['M_EMAIL'],
			$rs['M_COUNTRY'], $rs['M_LEVEL'], $rs['M_POSTS'], $rs['M_DATE'],
			$rs['M_LAST_HERE_DATE'], $rs['M_LAST_POST_DATE'], $rs['M_RECEIVE_EMAIL'], $rs['M_LAST_IP'],
			$rs['M_IP'], $rs['M_OCCUPATION'], $rs['M_SEX'], $rs['M_AGE'],
			$rs['M_BIO'], $rs['M_SIG'], $rs['M_MARSTATUS'], $rs['M_CITY'],
			$rs['M_STATE'], $rs['M_PHOTO_URL'], $rs['M_TITLE'], $rs['M_MEDAL'],
			$rs['M_LOGIN'], $rs['M_PMHIDE'], $rs['M_CHANGENAME_COUNT'], $rs['M_BROWSE'],
			$rs['M_ALLOWCHAT'], $rs['M_HIDE_SIG'], $rs['M_HIDE_PHOTO'], $rs['M_HIDE_DETAILS'],
			$rs['M_HIDE_POSTS'], $rs['M_HIDE_PM'],
			$rs['M_FONT_FAMILY'], $rs['M_FONT_SIZE'], $rs['M_FONT_COLOR'], $rs['M_FONT_ALIGN'],  $rs['M_OLD_MOD'],
			$rs['P_INDEX'] , $rs['P_ARCHIVE'], $rs['P_MEMBERS'], $rs['P_POSTS'] , $rs['P_POSTS_MEMBERS'] ,
			$rs['P_TOPICS'] , $rs['P_TOPICS_MEMBERS'] , $rs['P_ACTIVE'] , $rs['P_MONITORED'] ,
			$rs['P_SEARCH'] , $rs['P_DETAILS'] , $rs['P_PASS']  , $rs['P_DETAILS_EDIT']  , 
			$rs['P_MEDALS']  , $rs['P_CHANGE_NAME'] , $rs['P_LIST'] , $rs['P_SIG'], $rs['P_FORUM'], 
			$rs['P_FORUM_ARCHIVE'],$rs['P_TOPICS_SHOW'] ,$rs['P_POSTS_SHOW']  ,$rs['P_QUICK_POSTS'] ,
			$rs['P_ADD_POSTS'] , $rs['P_ADD_TOPICS'],$rs['P_EDIT_POSTS'], $rs['P_EDIT_TOPICS'],
			$rs['P_SEND_TOPICS'] ,$rs['P_NOTIFY'],$rs['LOCK_TOPICS'],$rs['LOCK_POSTS'],$rs['MEMBER_ID'],$rs['M_IHDAA']
		);
	}
	if($name == "NAME"){$nom = 0;}
	if($name == "STATUS"){$nom = 1;}
	if($name == "PASSWORD"){$nom = 2;}
	if($name == "EMAIL"){$nom = 3;}
	if($name == "COUNTRY"){$nom = 4;}
	if($name == "LEVEL"){$nom = 5;}
	if($name == "POSTS"){$nom = 6;}
	if($name == "DATE"){$nom = 7;}
	if($name == "LAST_HERE_DATE"){$nom = 8;}
	if($name == "LAST_POST_DATE"){$nom = 9;}
	if($name == "RECEIVE_EMAIL"){$nom = 10;}
	if($name == "LAST_IP"){$nom = 11;}
	if($name == "IP"){$nom = 12;}
	if($name == "OCCUPATION"){$nom = 13;}
	if($name == "SEX"){$nom = 14;}
	if($name == "AGE"){$nom = 15;}
	if($name == "BIO"){$nom = 16;}
	if($name == "SIG"){$nom = 17;}
	if($name == "MARSTATUS"){$nom = 18;}
	if($name == "CITY"){$nom = 19;}
	if($name == "STATE"){$nom = 20;}
	if($name == "PHOTO_URL"){$nom = 21;}
	if($name == "TITLE"){$nom = 22;}
	if($name == "MEDAL"){$nom = 23;}
	if($name == "LOGIN"){$nom = 24;}
	if($name == "PMHIDE"){$nom = 25;}
	if($name == "CHANGENAME_COUNT"){$nom = 26;}
	if($name == "BROWSE"){$nom = 27;}
	if($name == "ALLOWCHAT"){$nom = 28;}
	if($name == "HIDE_SIG"){$nom = 29;}
	if($name == "HIDE_PHOTO"){$nom = 30;}
	if($name == "HIDE_DETAILS"){$nom = 31;}
	if($name == "HIDE_POSTS"){$nom = 32;}
	if($name == "HIDE_PM"){$nom = 33;}

	if($name == "FONT_FAMILY"){$nom = 34;}
	if($name == "FONT_SIZE"){$nom = 35;}
	if($name == "FONT_COLOR"){$nom = 36;}
	if($name == "FONT_ALIGN"){$nom = 37;}
	if($name == "OLD_MOD"){$nom = 38;}
	
	if($name == "INDEX"){$nom = 39;}
	if($name == "ARCHIVE"){$nom = 40;}
	if($name == "MEMBERS"){$nom = 41;}
	if($name == "P_POSTS"){$nom = 42;}
	if($name == "P_POSTS_MEMBERS"){$nom = 43;}
	if($name == "P_TOPICS"){$nom = 44;}
	if($name == "P_TOPICS_MEMBERS"){$nom = 45;}
	if($name == "ACTIVE"){$nom = 46;}
	if($name == "MONITORED"){$nom = 47;}
	if($name == "SEARCH"){$nom = 48;}
	if($name == "DETAILS"){$nom = 49;}
	if($name == "PASS"){$nom = 50;}
	if($name == "DETAILS_EDIT"){$nom = 51;}
	if($name == "MEDALS"){$nom = 52;}
	if($name == "CHANGE_NAME"){$nom = 53;}
	if($name == "LIST"){$nom = 54;}
	if($name == "EDIT_SIG"){$nom = 55;}
	if($name == "FORUM"){$nom = 56;}
	if($name == "FORUM_ARCHIVE"){$nom = 57;}
	if($name == "TOPICS_SHOW"){$nom = 58;}
	if($name == "POSTS_SHOW"){$nom = 59;}
	if($name == "QUICK_POSTS"){$nom = 60;}
	if($name == "POSTS_ADD"){$nom = 61;}
	if($name == "TOPICS_ADD"){$nom = 62;}
	if($name == "POSTS_EDIT"){$nom = 63;}
	if($name == "TOPICS_EDIT"){$nom = 64;}
	if($name == "SEND_TOPICS"){$nom = 65;}
	if($name == "NOTIFY"){$nom = 66;}
	if($name == "LOCK_TOPICS"){$nom = 67;}
	if($name == "LOCK_POSTS"){$nom = 68;}
	if($name == "THE_ID"){$nom = 69;}
	if($name == "IHDAA"){$nom = 70;}


	return($members[$nom]);
}
//#################### members mysql function ##########################

//#################### topics mysql function ##########################
function topics($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$topics = Array(
			$rs['CAT_ID'], $rs['FORUM_ID'], $rs['T_STATUS'], $rs['T_SUBJECT'],
			$rs['T_MESSAGE'], $rs['T_REPLIES'], $rs['T_COUNTS'], $rs['T_AUTHOR'],
			$rs['T_DATE'], $rs['T_LAST_POST_AUTHOR'], $rs['T_LAST_POST_DATE'], $rs['T_ARCHIVE_FLAG'],
			$rs['T_STICKY'], $rs['T_HIDDEN'], $rs['T_TOP'], $rs['T_LINKFORUM'],
			$rs['T_LASTEDIT_DATE'], $rs['T_LASTEDIT_MAKE'], $rs['T_LOCK_DATE'], $rs['T_LOCK_MAKE'],
			$rs['T_OPEN_DATE'], $rs['T_OPEN_MAKE'], $rs['T_ENUM'], $rs['T_SURVEYID'],
			$rs['T_UNMODERATED'], $rs['T_MODERATED_BY'], $rs['T_MODERATED_DATE'], 
			$rs['T_HOLDED'], $rs['T_HOLDED_BY'], $rs['T_HOLDED_DATE'], 
			$rs['T_MOVED'], $rs['T_MOVED_BY'], $rs['T_MOVED_DATE'], 
			$rs['T_HIDDEN_BY'], $rs['T_HIDDEN_DATE'], 
			$rs['T_DELETED_BY'], $rs['T_DELETED_DATE'], $rs['T_ARCHIVED'], $rs['T_UNHIDDEN_BY'], $rs['T_UNHIDDEN_DATE'],
			$rs['T_STICKY_BY'], $rs['T_STICKY_DATE'], $rs['T_UNSTICKY_BY'], $rs['T_UNSTICKY_DATE']
		);
	}
	if($name == "CAT_ID"){$nom = 0;}
	if($name == "FORUM_ID"){$nom = 1;}
	if($name == "STATUS"){$nom = 2;}
	if($name == "SUBJECT"){$nom = 3;}
	if($name == "MESSAGE"){$nom = 4;}
	if($name == "REPLIES"){$nom = 5;}
	if($name == "COUNTS"){$nom = 6;}
	if($name == "AUTHOR"){$nom = 7;}
	if($name == "DATE"){$nom = 8;}
	if($name == "LAST_POST_AUTHOR"){$nom = 9;}
	if($name == "LAST_POST_DATE"){$nom = 10;}
	if($name == "ARCHIVE_FLAG"){$nom = 11;}
	if($name == "STICKY"){$nom = 12;}
	if($name == "HIDDEN"){$nom = 13;}
	if($name == "TOP"){$nom = 14;}
	if($name == "LINKFORUM"){$nom = 15;}
	if($name == "LASTEDIT_DATE"){$nom = 16;}
	if($name == "LASTEDIT_MAKE"){$nom = 17;}
	if($name == "LOCK_DATE"){$nom = 18;}
	if($name == "LOCK_MAKE"){$nom = 19;}
	if($name == "OPEN_DATE"){$nom = 20;}
	if($name == "OPEN_MAKE"){$nom = 21;}
	if($name == "ENUM"){$nom = 22;}
	if($name == "SURVEYID"){$nom = 23;}
	if($name == "UNMODERATED"){$nom = 24;}
	if($name == "MODERATED_BY"){$nom = 25;}
	if($name == "MODERATED_DATE"){$nom = 26;}
	if($name == "HOLDED"){$nom = 27;}
	if($name == "HOLDED_BY"){$nom = 28;}
	if($name == "HOLDED_DATE"){$nom = 29;}
	if($name == "MOVED"){$nom = 30;}
	if($name == "MOVED_BY"){$nom = 31;}
	if($name == "MOVED_DATE"){$nom = 32;}
	if($name == "HIDDEN_BY"){$nom = 33;}
	if($name == "HIDDEN_DATE"){$nom = 34;}
	if($name == "DELETED_BY"){$nom = 35;}
	if($name == "DELETED_DATE"){$nom = 36;}
	if($name == "ARCHIVED"){$nom = 37;}
	if($name == "UNHIDDEN_BY"){$nom = 38;}
	if($name == "UNHIDDEN_DATE"){$nom = 39;}
	if($name == "STICKY_BY"){$nom = 40;}
	if($name == "STICKY_DATE"){$nom = 41;}
	if($name == "UNSTICKY_BY"){$nom = 40;}
	if($name == "UNSTICKY_DATE"){$nom = 41;}

	return($topics[$nom]);
}
//#################### topics mysql function ##########################

//#################### replies mysql function ##########################
function replies($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE REPLY_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['CAT_ID'], $rs['FORUM_ID'], $rs['TOPIC_ID'], $rs['R_AUTHOR'],
			$rs['R_MESSAGE'], $rs['R_DATE'], $rs['R_HIDDEN'], $rs['R_LASTEDIT_DATE'],
			$rs['R_LASTEDIT_MAKE'], $rs['R_ENUM'], $rs['R_STATUS'],
			$rs['R_UNMODERATED'], $rs['R_MODERATED_BY'], $rs['R_MODERATED_DATE'],
			$rs['R_HOLDED'], $rs['R_HOLDED_BY'], $rs['R_HOLDED_DATE'],
			$rs['R_HIDDEN_BY'], $rs['R_HIDDEN_DATE'],
			$rs['R_DELETED_BY'], $rs['R_DELETED_DATE']
		);
	}
	if($name == "CAT_ID"){$nom = 0;}
	if($name == "FORUM_ID"){$nom = 1;}
	if($name == "TOPIC_ID"){$nom = 2;}
	if($name == "AUTHOR"){$nom = 3;}
	if($name == "MESSAGE"){$nom = 4;}
	if($name == "DATE"){$nom = 5;}
	if($name == "HIDDEN"){$nom = 6;}
	if($name == "LE_DATE"){$nom = 7;}
	if($name == "LE_MAKE"){$nom = 8;}
	if($name == "EDIT_NUM"){$nom = 9;}
	if($name == "STATUS"){$nom = 10;}
	if($name == "UNMODERATED"){$nom = 11;}
	if($name == "MODERATED_BY"){$nom = 12;}
	if($name == "MODERATED_DATE"){$nom = 13;}
	if($name == "HOLDED"){$nom = 14;}
	if($name == "HOLDED_BY"){$nom = 15;}
	if($name == "HOLDED_DATE"){$nom = 16;}
	if($name == "HIDDEN_BY"){$nom = 17;}
	if($name == "HIDDEN_DATE"){$nom = 18;}
	if($name == "DELETED_BY"){$nom = 19;}
	if($name == "DELETED_DATE"){$nom = 20;}
	return($arr[$nom]);
}
//#################### replies mysql function ##########################

//#################### forums mysql function ##########################
function forums($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$forums = Array(
			$rs['CAT_ID'], $rs['F_STATUS'], $rs['F_SUBJECT'], $rs['F_DESCRIPTION'],
			$rs['F_TOPICS'], $rs['F_REPLIES'], $rs['F_LAST_POST_DATE'], $rs['F_LAST_POST_AUTHOR'],
			$rs['F_ORDER'], $rs['F_LOGO'], $rs['F_TOTAL_TOPICS'], $rs['F_TOTAL_REPLIES'],
			$rs['F_HIDE'], $rs['F_HIDE_PHOTO'], $rs['F_HIDE_SIG'], $rs['F_HIDE_MOD'], $rs['F_SEX'],$rs['DAY_ARCHIVE'],$rs['CAN_ARCHIVE'], $rs['F_LEVEL'],
			$rs['MODERATE_TOPIC'],$rs['MODERATE_REPLY'],$rs['SHOW_INDEX'],$rs['SHOW_FRM'],$rs['SHOW_INFO'],$rs['SHOW_PROFILE']
			);
	}
	if($name == "CAT_ID"){$nom = 0;}
	if($name == "STATUS"){$nom = 1;}
	if($name == "SUBJECT"){$nom = 2;}
	if($name == "DESCRIPTION"){$nom = 3;}
	if($name == "TOPICS"){$nom = 4;}
	if($name == "REPLIES"){$nom = 5;}
	if($name == "LAST_POST_DATE"){$nom = 6;}
	if($name == "LAST_POST_AUTHOR"){$nom = 7;}
	if($name == "ORDER"){$nom = 8;}
	if($name == "LOGO"){$nom = 9;}
	if($name == "TOTAL_TOPICS"){$nom = 10;}
	if($name == "TOTAL_REPLIES"){$nom = 11;}
	if($name == "HIDE"){$nom = 12;}
	if($name == "HIDE_PHOTO"){$nom = 13;}
	if($name == "HIDE_SIG"){$nom = 14;}
	if($name == "HIDE_MOD"){$nom = 15;}
    if($name == "SEX"){$nom = 16;}
    if($name == "DAY_ARCHIVE"){$nom = 17;}
    if($name == "CAN_ARCHIVE"){$nom = 18;}
    if($name == "F_LEVEL"){$nom = 19;}
    if($name == "MODERATE_TOPIC"){$nom = 20;}
    if($name == "MODERATE_REPLY"){$nom = 21;}
    if($name == "SHOW_INDEX"){$nom = 22;}
    if($name == "SHOW_FRM"){$nom = 23;}
    if($name == "SHOW_INFO"){$nom = 24;}
    if($name == "SHOW_PROFILE"){$nom = 25;}

	return($forums[$nom]);
}
//#################### forums mysql function ##########################

//#################### categories mysql function ##########################
function cat($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$cat = Array(
			$rs['CAT_STATUS'], $rs['CAT_NAME'], $rs['CAT_ORDER'], $rs['CAT_MONITOR'], $rs['CAT_HIDE'],
			$rs['SHOW_INDEX'], $rs['SHOW_INFO']			
		);
	}
	if($name == "STATUS"){$nom = 0;}
	if($name == "NAME"){$nom = 1;}
	if($name == "ORDER"){$nom = 2;}
	if($name == "MONITOR"){$nom = 3;}
	if($name == "HIDE"){$nom = 4;}
    if($name == "SHOW_INDEX"){$nom = 5;}
    if($name == "SHOW_INFO"){$nom = 6;}
	return($cat[$nom]);
}
//#################### categories mysql function ##########################

//#################### online mysql function ##########################
function online($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE WHERE ONLINE_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$online = Array(
			$rs['O_MEMBER_ID'], $rs['O_FORUM_ID'], $rs['O_MEMBER_LEVEL'], $rs['O_MEMBER_BROWSE'],
			$rs['O_IP'], $rs['O_MODE'], $rs['O_DATE'], $rs['O_LAST_DATE']
		);
	}
	if($name == "MEMBER_ID"){$nom = 0;}
	if($name == "FORUM_ID"){$nom = 1;}
	if($name == "MEMBER_LEVEL"){$nom = 2;}
	if($name == "MEMBER_BROWSE"){$nom = 3;}
	if($name == "IP"){$nom = 4;}
	if($name == "MODE"){$nom = 5;}
	if($name == "DATE"){$nom = 6;}
	if($name == "LAST_DATE"){$nom = 7;}
	return($online[$nom]);
}
//#################### online mysql function ##########################

//#################### hide forum mysql function ##########################
function hide_forum($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}HIDE_FORUM WHERE HF_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$hide_forum = Array(
			$rs['HF_MEMBER_ID'], $rs['HF_FORUM_ID']
		);
	}
	if($name == "MEMBER_ID"){$nom = 0;}
	if($name == "FORUM_ID"){$nom = 1;}
	return($hide_forum[$nom]);
}
//#################### hide forum mysql function ##########################

//#################### prv topic mysql function ##########################
function prv_topic($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}PRIVATE_TOPICS WHERE P_MEMBERID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$prv_topic = Array(
			$rs['PTOPIC_ID'], $rs['P_MEMBERID'], $rs['P_CATID'], $rs['P_FORUMID'], $rs['P_TOPICID'],
			$rs['P_MAKE'], $rs['P_DATE']
		);
	}
	if($name == "PTOPIC_ID"){$nom = 0;}
	if($name == "P_MEMBERID"){$nom = 1;}
	if($name == "P_CATID"){$nom = 2;}
	if($name == "P_FORUMID"){$nom = 3;}
	if($name == "P_TOPICID"){$nom = 4;}
	if($name == "P_MAKE"){$nom = 5;}
	if($name == "P_DATE"){$nom = 6;}
	return($prv_topic[$nom]);
}
//#################### prv topic mysql function ##########################

//#################### fav topic mysql function ##########################
function fav_topic($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}FAVOURITE_TOPICS WHERE F_TOPICID = '$id' AND F_MEMBERID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$fav_topic = Array(
			$rs['FAVT_ID'], $rs['F_MEMBERID'], $rs['F_CATID'], $rs['F_FORUMID'], $rs['F_TOPICID']
		);
	}
	if($name == "PTOPIC_ID"){$nom = 0;}
	if($name == "MEMBERID"){$nom = 1;}
	if($name == "CATID"){$nom = 2;}
	if($name == "FORUMID"){$nom = 3;}
	if($name == "TOPICID"){$nom = 4;}
	return($fav_topic[$nom]);
}
//#################### fav topic mysql function ##########################

//#################### medal files mysql function ##########################
function mf($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDAL_FILES WHERE MF_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['FORUM_ID'], $rs['ADDED'], $rs['SUBJECT'], $rs['DATE']
		);
	}
	if($name == "FORUM_ID"){$nom = 0;}
	if($name == "ADDED"){$nom = 1;}
	if($name == "SUBJECT"){$nom = 2;}
	if($name == "DATE"){$nom = 3;}
	return($arr[$nom]);
}
//#################### medal files mysql function ##########################

//#################### global medals mysql function ##########################
function gm($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_MEDALS WHERE MEDAL_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['FORUM_ID'], $rs['STATUS'], $rs['SUBJECT'], $rs['DAYS'],
			$rs['POINTS'], $rs['URL'], $rs['CLOSE'], $rs['ADDED'],
			$rs['DATE']
		);
	}
	if($name == "FORUM_ID"){$nom = 0;}
	if($name == "STATUS"){$nom = 1;}
	if($name == "SUBJECT"){$nom = 2;}
	if($name == "DAYS"){$nom = 3;}
	if($name == "POINTS"){$nom = 4;}
	if($name == "URL"){$nom = 5;}
	if($name == "CLOSE"){$nom = 6;}
	if($name == "ADDED"){$nom = 7;}
	if($name == "DATE"){$nom = 8;}
	return($arr[$nom]);
}
//#################### global medals mysql function ##########################

//#################### medals mysql function ##########################
function medals($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDALS WHERE MEDAL_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)>0){
		$arr = Array(
			$rs['GM_ID'], $rs['FORUM_ID'], $rs['MEMBER_ID'], $rs['STATUS'],
			$rs['ADDED'], $rs['DAYS'], $rs['POINTS'], $rs['URL'],
			$rs['DATE']
		);
	}
	if($name == "GM_ID"){$nom = 0;}
	if($name == "FORUM_ID"){$nom = 1;}
	if($name == "MEMBER_ID"){$nom = 2;}
	if($name == "STATUS"){$nom = 3;}
	if($name == "ADDED"){$nom = 4;}
	if($name == "DAYS"){$nom = 5;}
	if($name == "POINTS"){$nom = 6;}
	if($name == "URL"){$nom = 7;}
	if($name == "DATE"){$nom = 8;}
	return($arr[$nom]);
}
//####################  medals mysql function ##########################

//#################### global titles mysql function ##########################
function gt($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_TITLES WHERE TITLE_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['FORUM_ID'], $rs['STATUS'], $rs['CLOSE'], $rs['FORUM'],
			$rs['ADDED'], $rs['SUBJECT'], $rs['DATE']
		);
	}
	if($name == "FORUM_ID"){$nom = 0;}
	if($name == "STATUS"){$nom = 1;}
	if($name == "CLOSE"){$nom = 2;}
	if($name == "FORUM"){$nom = 3;}
	if($name == "ADDED"){$nom = 4;}
	if($name == "SUBJECT"){$nom = 5;}
	if($name == "DATE"){$nom = 6;}
	return($arr[$nom]);
}
//#################### global titles mysql function ##########################

//####################  titles mysql function ##########################
function titles($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}TITLES WHERE TITLE_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['GT_ID'], $rs['MEMBER_ID'], $rs['STATUS'], $rs['DATE']
		);
	}
	if($name == "GT_ID"){$nom = 0;}
	if($name == "MEMBER_ID"){$nom = 1;}
	if($name == "STATUS"){$nom = 2;}
	if($name == "DATE"){$nom = 3;}
	return($arr[$nom]);
}
//####################  titles mysql function ##########################

//####################  used titles mysql function ##########################
function ut($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}USED_TITLES WHERE ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['TITLE_ID'], $rs['MEMBER_ID'], $rs['STATUS'], $rs['ADDED'],
			$rs['DATE']
		);
	}
	if($name == "TITLE_ID"){$nom = 0;}
	if($name == "MEMBER_ID"){$nom = 1;}
	if($name == "STATUS"){$nom = 2;}
	if($name == "ADDED"){$nom = 3;}
	if($name == "DATE"){$nom = 4;}
	return($arr[$nom]);
}
//####################  used titles mysql function ##########################              

//####################  survey mysql function ##########################
function surveys($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEYS WHERE SURVEY_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['FORUM_ID'], $rs['SUBJECT'], $rs['QUESTION'], $rs['STATUS'],
			$rs['SECRET'], $rs['DAYS'], $rs['MIN_DAYS'], $rs['MIN_POSTS'],
			$rs['ADDED'], $rs['START'], $rs['END']
		);
	}
	if($name == "FORUM_ID"){$nom = 0;}
	if($name == "SUBJECT"){$nom = 1;}
	if($name == "QUESTION"){$nom = 2;}
	if($name == "STATUS"){$nom = 3;}
	if($name == "SECRET"){$nom = 4;}
	if($name == "DAYS"){$nom = 5;}
	if($name == "MIN_DAYS"){$nom = 6;}
	if($name == "MIN_POSTS"){$nom = 7;}
	if($name == "ADDED"){$nom = 8;}
	if($name == "START"){$nom = 9;}
	if($name == "END"){$nom = 10;}
	return($arr[$nom]);
}
//####################  survey mysql function ##########################

//####################  survey option mysql function ###################
function survey_option($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEY_OPTIONS WHERE SO_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['SURVEY_ID'], $rs['OPTION_ID'], $rs['VALUE'], $rs['OTHER']
		);
	}
	if($name == "SURVEY_ID"){$nom = 0;}
	if($name == "OPTION_ID"){$nom = 1;}
	if($name == "VALUE"){$nom = 2;}
	if($name == "OTHER"){$nom = 3;}
	return($arr[$nom]);
}
//####################  survey option mysql function ##################

//####################  survey option where survey_id mysql function ##
function option_survey_id($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEY_OPTIONS WHERE SURVEY_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['SO_ID'], $rs['OPTION_ID'], $rs['VALUE'], $rs['OTHER']
		);
	}
	if($name == "SO_ID"){$nom = 0;}
	if($name == "OPTION_ID"){$nom = 1;}
	if($name == "VALUE"){$nom = 2;}
	if($name == "OTHER"){$nom = 3;}
	return($arr[$nom]);
}
//####################  survey option where survey_id mysql function ##

//####################  survey option where option_id mysql function ##
function option_value($id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}SURVEY_OPTIONS WHERE SO_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$value = $rs['VALUE'];
	}
	return($value);
}
//####################  survey option where option_id mysql function ##

//####################  votes mysql function ##########################
function votes($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}VOTES WHERE VOTE_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['SURVEY_ID'], $rs['OPTION_ID'], $rs['FORUM_ID'], $rs['TOPIC_ID'],
			$rs['MEMBER_ID'], $rs['DATE']
		);
	}
	if($name == "SURVEY_ID"){$nom = 0;}
	if($name == "OPTION_ID"){$nom = 1;}
	if($name == "FORUM_ID"){$nom = 2;}
	if($name == "TOPIC_ID"){$nom = 3;}
	if($name == "MEMBER_ID"){$nom = 4;}
	if($name == "DATE"){$nom = 5;}
	return($arr[$nom]);
}
//####################  votes mysql function ##########################

//####################  topic members mysql function ##########################
function topic_members($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPIC_MEMBERS WHERE TM_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['MEMBER_ID'], $rs['TOPIC_ID'], $rs['ADDED'], $rs['DATE']
		);
	}
	if($name == "MEMBER_ID"){$nom = 0;}
	if($name == "TOPIC_ID"){$nom = 1;}
	if($name == "ADDED"){$nom = 2;}
	if($name == "DATE"){$nom = 3;}
	return($arr[$nom]);
}
//####################  topic members mysql function ##########################

//####################  moderation mysql function ##########################
function moderation($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATION WHERE MODERATION_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$moderation = Array(
			$rs['M_STATUS'], $rs['M_MEMBERID'], $rs['M_FORUMID'], $rs['M_TOPICID'],
			$rs['M_REPLYID'], $rs['M_ADDED'], $rs['M_MODERATOR_NOTES'], $rs['M_TYPE'],
			$rs['M_RAISON'], $rs['M_DATE'], $rs['M_DATEAPP'], $rs['M_DATEFIN'],
			$rs['M_EXECUTE'], $rs['M_END'], $rs['M_PM']
		);
	}
	if($name == "STATUS"){$nom = 0;}
	if($name == "MEMBERID"){$nom = 1;}
	if($name == "FORUMID"){$nom = 2;}
	if($name == "TOPICID"){$nom = 3;}
	if($name == "REPLYID"){$nom = 4;}
	if($name == "ADDED"){$nom = 5;}
	if($name == "NOTES"){$nom = 6;}
	if($name == "TYPE"){$nom = 7;}
	if($name == "RAISON"){$nom = 8;}
	if($name == "DATE"){$nom = 9;}
	if($name == "DATEAPP"){$nom = 10;}
	if($name == "DATEFIN"){$nom = 11;}
	if($name == "EXECUTE"){$nom = 12;}
	if($name == "END"){$nom = 13;}
	if($name == "PM"){$nom = 14;}
	return($moderation[$nom]);
}
//####################  moderation mysql function ##########################

//####################  edits_info mysql function ##########################
function edits($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}EDITS_INFO WHERE EDIT_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['MEMBER_ID'], $rs['TOPIC_ID'], $rs['REPLY_ID'], $rs['OLD_SUBJECT'],
			$rs['OLD_MESSAGE'], $rs['NEW_SUBJECT'], $rs['NEW_MESSAGE'], $rs['DATE']
		);
	}
	if($name == "MEMBER_ID"){$nom = 0;}
	if($name == "TOPIC_ID"){$nom = 1;}
	if($name == "REPLY_ID"){$nom = 2;}
	if($name == "OLD_SUBJECT"){$nom = 3;}
	if($name == "OLD_MESSAGE"){$nom = 4;}
	if($name == "NEW_SUBJECT"){$nom = 5;}
	if($name == "NEW_MESSAGE"){$nom = 6;}
	if($name == "DATE"){$nom = 7;}
	return($arr[$nom]);
}
//####################  edits_info mysql function ##########################

//####################  notifys mysql function #############################
function notifys($name, $id){
	global $mysql;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}NOTIFYS WHERE NOTIFY_ID = '$id' ", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$arr = Array(
			$rs['STATUS'], $rs['SOLVED'], $rs['FORUM_ID'], $rs['TOPIC_ID'],
			$rs['REPLY_ID'], $rs['N_AUTHOR'], $rs['P_AUTHOR'], $rs['TYPE'],
			$rs['NOTES'], $rs['DATE'], $rs['REPLY_BY'], $rs['REPLY_MSG'], $rs['REPLY_DATE'],
			$rs['NOTES_BY'], $rs['NOTES_TEXT'], $rs['NOTES_DATE'], $rs['TRANSFER_BY'], $rs['TRANSFER_DATE']
		);
	}
	if($name == "STATUS"){$nom = 0;}
	if($name == "SOLVED"){$nom = 1;}
	if($name == "FORUM_ID"){$nom = 2;}
	if($name == "TOPIC_ID"){$nom = 3;}
	if($name == "REPLY_ID"){$nom = 4;}
	if($name == "N_AUTHOR"){$nom = 5;}
	if($name == "P_AUTHOR"){$nom = 6;}
	if($name == "TYPE"){$nom = 7;}
	if($name == "NOTES"){$nom = 8;}
	if($name == "DATE"){$nom = 9;}
	if($name == "REPLY_BY"){$nom = 10;}
	if($name == "REPLY_MSG"){$nom = 11;}
	if($name == "REPLY_DATE"){$nom = 12;}
	if($name == "NOTES_BY"){$nom = 13;}
	if($name == "NOTES_TEXT"){$nom = 14;}
	if($name == "NOTES_DATE"){$nom = 15;}
	if($name == "TRANSFER_BY"){$nom = 16;}
	if($name == "TRANSFER_DATE"){$nom = 17;}
	return($arr[$nom]);
}
//####################  notifys mysql function #############################

//#################### check allowed ##########################
function allowed($f, $n){ // note: if($n = 1) the number is just monitor but if($n = 2)  the number is monitor and moderator.
    global $mysql, $DBMemberID, $Mlevel;
	$c = forums("CAT_ID", $f);
	$monitor = cat("MONITOR", $c);
    $count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '$DBMemberID' AND FORUM_ID = '$f' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
    $count = intval($count[0]);
	if($Mlevel == 4){
		$allowed = 1;
	}
	else if($Mlevel == 3){
		if($DBMemberID == $monitor){
			$allowed = 1;
		}
		else{
			$allowed = 0;
		}
	}
	else if($Mlevel == 2){
		if($n == 2){
			if($count > 0){
				$allowed = 1;
			}
			else{
				$allowed = 0;
			}
		}
		else{
			$allowed = 0;
		}
	}
	if($Mlevel < 2){
		$allowed = 0;
	}
return($allowed);
}
//#################### check allowed ##########################

function info_text($id,$txt,$title){
    $txt = str_replace("{n}","<br>",$txt);
    $tr = '<tr style="display: none;" id="'.$id.'">';
    $tr .=  '<td class="deleted" colspan="20">';
    $tr .=  '<fieldset style="width: 100%">';
    $tr .=    '<legend>&nbsp;<font color="black">معلومات حول خيار&nbsp;( <font color="#cc0033">'.$title.'</font> )</font></legend>';
    $tr .=      '<br><font style="FONT-WEIGHT: NORMAL;  FONT-SIZE: 12px; COLOR: black; FONT-FAMILY: tahoma,arial">'.$txt.'</font><br><br>';
    $tr .=  '</fieldset>';
    $tr .=  '</td>';
    $tr .='</tr>';
    return($tr);
}

function info_icon($id){
    global $icon_question, $lang;
    $url = "&nbsp;&nbsp;<a href=\"javascript:show_info(".$id.");\">".icons($icon_question, $lang['function']['more_info'])."</a>";
    return($url);
}

function to_kb($num){
	$num = ceil($num / 1024);
    return($num);
}

function before_days($n){
	$before_days = ceil(time() - 60*60*24*$n);
	return($before_days);
}

function normal_profile($m_name,$m_id){
    $normal_profile="<a href=\"index.php?mode=profile&id=".$m_id."\">".$m_name."</a>";
    return($normal_profile);
}

function nofity_wait($f,$mode){
	global $mysql;
	if($mode == "admin"){
		$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}NOTIFY WHERE FORUM_ID = '".$f."' AND STATUS = '2' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
		$count = intval($count[0]);
	}
	if($mode == "wait"){
		$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}NOTIFY WHERE FORUM_ID = '".$f."' AND STATUS  = '1' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
		$count = intval($count[0]);
	}
	return $count;
}

function link_profile($m_name,$m_id){
	global $mysql, $color_0, $color_1, $color_2, $color_3, $color_4;
    $rsLP = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID='$m_id' ", [], __FILE__, __LINE__)->fetch();
    if(is_array($rsLP)){
        $LP_MemberLevel=$rsLP['M_LEVEL'];
        $LP_MemberStatus=$rsLP['M_STATUS'];
    }
    if($LP_MemberLevel==1&&$LP_MemberStatus==1){
		if($color_1){
				$link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color=\"$color_1\">".$m_name."</font></a>";
		}
		else{
				$link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\">".$m_name."</a>";
		}
    }
    if($LP_MemberLevel==1&&$LP_MemberStatus==0){
        $link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color=\"$color_0\">".$m_name."</font></a>";
    }
    if($LP_MemberLevel==2){
        $link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color=\"$color_2\">".$m_name."</font></a>";
    }
    if($LP_MemberLevel==3){
        $link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color=\"$color_3\">".$m_name."</font></a>";
    }
    if($LP_MemberLevel==4){
        $link_profile="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color=\"$color_4\">".$m_name."</font></a>";
    }
    return($link_profile);
}

function member_normal_link($m){
	$link = '<a href="index.php?mode=profile&id='.$m.'">'.members("NAME", $m).'</a>';
	return($link);
}

function member_color_link($m){
	$name = members("NAME", $m);
	$status = members("STATUS", $m);
	$level = members("LEVEL", $m);
	if($status == 0){
		$link = '<a href="index.php?mode=profile&id='.$m.'"><font color="#999999">'.$name.'</font></a>';
	}
	if($level == 1 && $status != 0){
		$link = '<a href="index.php?mode=profile&id='.$m.'">'.$name.'</a>';
	}
	if($level == 2 && $status != 0){
		$link = '<a href="index.php?mode=profile&id='.$m.'"><font color="#cc0033">'.$name.'</font></a>';
	}
	if($level == 3 && $status != 0){
		$link = '<a href="index.php?mode=profile&id='.$m.'"><font color="#cc8811">'.$name.'</font></a>';
	}
	if($level == 4 && $status != 0){
		$link = '<a href="index.php?mode=profile&id='.$m.'"><font color="blue">'.$name.'</font></a>';
	}
	return($link);
}

function admin_link($m){
	$name = members("NAME", $m);
	$link = '
	<table class="optionsbar" width="100%">
		<tr>
			<td><font size="4"><a href="index.php?mode=profile&id='.$m.'"><font color="white">'.$name.'</font></a></font></td>
		</tr>
	</table>';
	return($link);
}

function normal_time($date){
    global $Mlevel, $lang, $chk_timezone;
    $date=$date+$chk_timezone;
    $DateYear=date("Y/",$date);
    $NowYear=date("Y/");
    $NormalMonth=date("m/",$date);
    $DateDay=date("d",$date);
    $NowDay=date("d");
    $yesterday=time()-(60*1440);
    $NowDay2=date("d",$yesterday);
	if($Mlevel > 1){
		$DateTime=date("H:i:s",$date);
	}
	else {
		$DateTime=date("H:i",$date);
	}
    if($DateYear==$NowYear){
        $NormalYear="";
    }
    else{
        $NormalYear=$DateYear;
    }
    if($DateDay==$NowDay&&$DateYear==$NowYear){
        $normal_time=$DateTime." - ".$lang['function']['to_day'];
    }
    elseif($DateDay==$NowDay2&&$DateYear==$NowYear){
        $normal_time=$DateTime." - ".$lang['function']['yesterday'];
    }
    else{
        $normal_time=$DateTime." - ".$NormalYear.$NormalMonth.$DateDay;
    }
    return($normal_time);
}

function members_time($m_date){
    global $lang, $chk_timezone;
    $m_date=$m_date+$chk_timezone;
    $DateYear=date("Y/",$m_date);
    $NowYear=date("Y/");
    $NormalMonth=date("m/",$m_date);
    $DateDay=date("d",$m_date);
    $NowDay=date("d");
    $yesterday=time()-(60*1440);
    $NowDay2=date("d",$yesterday);
    if($DateYear==$NowYear){
        $NormalYear="";
    }
    else{
        $NormalYear=$DateYear;
    }
    if($DateDay==$NowDay && $DateYear == $NowYear){
        $normal_date = $lang['function']['to_day'];
    }
    elseif($DateDay == $NowDay2 && $DateYear==$NowYear){
        $normal_date = $lang['function']['yesterday'];
    }
    else{
        $normal_date = $NormalYear.$NormalMonth.$DateDay;
    }
    return($normal_date);
}

function normal_date($date){
   	global $chk_timezone;
	$date = $date+$chk_timezone;
	$date = date("Y/m/d", $date);
	return($date);
}

function date_and_time($date, $s=""){
   	global $chk_timezone;
	$date = $date+$chk_timezone;
	if(!empty($s)){
		$date = date("H:i:s - d/m/Y", $date);
	}
	else{
		$date = date("H:i - d/m/Y", $date);
	}
	return($date);
}

function chk_moderator($m,$f){
	if($m > 0){
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__);
		$m_num = mysql_num_rows($sql);
		$m_rows = mysql_fetch_array($sql);
		if($m_num > 0){
			if($m_rows['M_LEVEL'] > 1){
				$m_level = 1;
			}
			else {
				$m_level = 0;
			}
		}
		else{
			$m_level = 0;
		}
		$resultChkMod=$mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID='$m' AND FORUM_ID='$f' ", [], __FILE__, __LINE__);
		if(mysql_num_rows($resultChkMod)>0){
			if($m_level == 1){
				$chk_mod=1;
			}
		}
		else{
			$chk_mod=0;
		}
	}
	return($chk_mod);
}

function chk_monitor($m,$c){
  if($m > 0){
    $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__);
    $m_num = mysql_num_rows($sql);
    $m_rows = mysql_fetch_array($sql);
    if($m_num > 0){
      if($m_rows['M_LEVEL'] > 1){
        $m_level = 1;
      }
      else {
        $m_level = 0;
      }
    }
    else {
      $m_level = 0;
    }

    $resultChkMon = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_ID='$c' AND CAT_MONITOR='$m' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($resultChkMon)>0){
      if($m_level == 1){
        $chk_mon=1;
      }
    }
    else{
        $chk_mon=0;
    }
  }
    return($chk_mon);
}

function member_total_days($m_date){    $m_date=time()-$m_date;    $m_date=$m_date/84600;    $m_date=ceil($m_date);    return($m_date);}function member_middle_posts($m_posts, $m_date){    $mtd=member_total_days($m_date);    $mmp=$m_posts/$mtd;    $mmp=ceil($mmp);    return($mmp);}


function open_mysql($variable){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CONFIG WHERE VARIABLE = '".$variable."' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$rs = mysql_fetch_array($sql);
		$value = $rs['VALUE'];
	}
return($value);
}

function updata_mysql($variable, $value){
	$sql = $mysql->execute("UPDATE {$mysql->prefix}CONFIG SET VALUE = '".$value."' WHERE VARIABLE = '".$variable."' ", [], __FILE__, __LINE__);
}

function insert_mysql($variable, $value){
	$sql = $mysql->execute("INSERT INTO {$mysql->prefix}CONFIG (ID, VARIABLE, VALUE) VALUES (NULL, '".$variable."', '".$value."') ", [], __FILE__, __LINE__);
}

function check_radio($value1, $value2){
 if($value1 == $value2){
    $value = 'CHECKED';
 }
 else {
    $value = '';
 }
return($value);
}

function check_select($value1, $value2){
 if($value1 == $value2){
    $value = 'selected';
 }
 else {
    $value = '';
 }
return($value);
}

function chk_cmd($val1, $val2, $val3){
	if($val1 == $val2){
		$value = $val3;
	}
	else {
		$value = "";
	}
return($value);
}

function pg_limit($max){
	global $pg;
	if(empty($pg)){
		$pg = 1;
	}
	$limit = (($pg * $max) - $max);
return($limit);
}

function member_name($id){
 $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '".$id."' ", [], __FILE__, __LINE__);
 if(mysql_num_rows($sql) > 0){
 $rs = mysql_fetch_array($sql);
 $MemberName = $rs['M_NAME'];
 }
return($MemberName);
}

function smarty_member_name($id){
$id = $id['id'];
 $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '".$id."' ", [], __FILE__, __LINE__);
 if(mysql_num_rows($sql) > 0){
 $rs = mysql_fetch_array($sql);
 $MemberName = $rs['M_NAME'];
 }
return($MemberName);
}

function forum_name($id){
 $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '".$id."' ", [], __FILE__, __LINE__);
 if(mysql_num_rows($sql) > 0){
 $rs = mysql_fetch_array($sql);

 $Forum_Subject = $rs['F_SUBJECT'];
 }
return($Forum_Subject);
}

function cat_id($f_id){
 $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '".$f_id."' ", [], __FILE__, __LINE__);
 if(mysql_num_rows($sql) > 0){
 $rs = mysql_fetch_array($sql);
 $Cat_ID = $rs['CAT_ID'];
 }
return($Cat_ID);
}

function text_replace($message){
global $BanWords;
/*
$no_spam = array("script","meta","SCRIPT","META");
*/
$no_spam = explode(",",$BanWords);
//$message = htmlspecialchars($message);

//$message=str_replace("\n","<br>",$message);
$message=stripslashes($message);
$message=str_replace("[]","",$message);
$message = preg_replace("#<meta(.*)>#","",$message);
$message = preg_replace("#<META(.*)>#","",$message);
$message=str_replace($no_spam,"***",$message);
return ($message);

}

function old_mod($id, $size, $small){
 
 $ProMemberOldMod = members("OLD_MOD", $id);
 $ProMemberSex = members("SEX", $id);


if($ProMemberOldMod == 1 AND $ProMemberSex == 1){
$old_mod = "مشرف سابق";
}
if($ProMemberOldMod == 1 AND $ProMemberSex == 2){
$old_mod = "مشرفة سابقة";
}
if($ProMemberOldMod == 1 AND $ProMemberSex == 0){
$old_mod = "مشرف سابق";
}

if($ProMemberOldMod == 2  AND $ProMemberSex == 0){
$old_mod = "مراقب سابق";
}
if($ProMemberOldMod == 2  AND $ProMemberSex == 1){
$old_mod = "مراقب سابق";
}

if($ProMemberOldMod == 2  AND $ProMemberSex == 2){
$old_mod = "مراقبة سابقة";
}


if(member_title($id) != ""){
$to_br = "<br>";
} else {
$to_br = "";
}
if($small == "small"){
$old_mod_title = '<div><font size="'.$size.'" color ="red"><small>'.$old_mod.'</small></font></div>';
} else {
$old_mod_title = '<div><font size="'.$size.'" color ="red">'.$old_mod.'</font></div>';
}


return ($old_mod_title);

}


function member_stars($m_id){

    global $mysql, $StarsNomber,$StarsColor,$Stars;

    $rs_S=$mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID='$m_id' ", [], __FILE__, __LINE__)->fetch();

    if(is_array($rs_S)){
        $S_MemberID=$rs_S['MEMBER_ID'];
        $S_MemberLevel=$rs_S['M_LEVEL'];
        $S_MemberStatus=$rs_S['M_STATUS'];
        $S_MemberPosts=$rs_S['M_POSTS'];
    }
if($S_MemberLevel==1){$star_color=$Stars[$StarsColor[1]];
}
if($S_MemberLevel==2){$star_color=$Stars[$StarsColor[2]];
}
if($S_MemberLevel==3){$star_color=$Stars[$StarsColor[3]];
}
if($S_MemberLevel==4){$star_color=$Stars[$StarsColor[4]];
}
if($S_MemberPosts<$StarsNomber[1]){$M_Stars="";
}
if($S_MemberPosts>=$StarsNomber[1]&&$S_MemberPosts<$StarsNomber[2]){$M_Stars=icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[2]&&$S_MemberPosts<$StarsNomber[3]){$M_Stars=icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[3]&&$S_MemberPosts<$StarsNomber[4]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[4]&&$S_MemberPosts<$StarsNomber[5]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[5]&&$S_MemberPosts<$StarsNomber[6]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[6]&&$S_MemberPosts<$StarsNomber[7]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").'<br>'.icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[7]&&$S_MemberPosts<$StarsNomber[8]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").'<br>'.icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[8]&&$S_MemberPosts<$StarsNomber[9]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").'<br>'.icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[9]&&$S_MemberPosts<$StarsNomber[10]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").'<br>'.icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
if($S_MemberPosts>=$StarsNomber[10]){$M_Stars=icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").'<br>'.icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","").icons($star_color,"","");
}
return($M_Stars);
}

function member_title($m){
	global $Title, $Title_Female, $StarsNomber;
    if(members("SEX", $m) == 2){
    $titles = $Title_Female;
    } else {
    $titles = $Title;
    }
	$star_num = $StarsNomber;
	$level = members("LEVEL", $m);
	$status = members("STATUS", $m);
	$posts = members("POSTS", $m);
	$member_title = members("TITLE", $m);

	if($member_title == ""){
		if($posts < $star_num[1]){
			$m_title = $titles[0];
		}
		if($posts >= $star_num[1] AND $posts < $star_num[2]){
			$m_title = $titles[1];
		}
		if($posts >= $star_num[2] AND $posts < $star_num[3]){
			$m_title = $titles[2];
		}
		if($posts >= $star_num[3] AND $posts < $star_num[4]){
			$m_title = $titles[3];
		}
		if($posts >= $star_num[4] AND $posts < $star_num[5]){
			$m_title = $titles[4];
		}
		if($posts >= $star_num[5] AND $posts < $star_num[6]){
			$m_title = $titles[5];
		}
		if($posts >= $star_num[6] AND $posts < $star_num[7]){
			$m_title = $titles[6];
		}
		if($posts >= $star_num[7] AND $posts < $star_num[8]){
			$m_title = $titles[7];
		}
		if($posts >= $star_num[8] AND $posts < $star_num[9]){
			$m_title = $titles[8];
		}
		if($posts >= $star_num[9] AND $posts < $star_num[10]){
			$m_title = $titles[9];
		}
		if($posts >= $star_num[10]){
			$m_title = $titles[10];
		}
		if($level == 1){
			$title = $m_title;
		}
		if($level == 2){
			$title = $titles[11];
		}
		if($level == 3){
			$title = $titles[12];
		}
		if($level == 4){
			$title = $titles[13];
		}
	}
	else{
		$title = $member_title;
	}
	$title = text_replace($title);
return($title);
}

function normal_time_last($date){
   global $chk_timezone;
    $date=$date+$chk_timezone;
    $DateYear=date("Y/",$date);
    $NowYear=date("Y/");
    $NormalMonth=date("m/",$date);
    $DateDay=date("d",$date);
    $NowDay=date("d");
    $yesterday=time()-(60*1440);
    $NowDay2=date("d",$yesterday);
    $DateTime=date("H:i",$date);
    $normal_time=$DateTime." - ".$NormalYear.$NormalMonth.$DateDay;
    return($normal_time);
}

function normal_time_files($date){
   global $chk_timezone;
    $date=$date+$chk_timezone;
    $DateYear=date("Y/",$date);
    $NormalMonth=date("m/",$date);
    $DateDay=date("d",$date);
    $DateTime=date("H:i:s",$date);
    $normal_time=$DateTime." - ".$DateYear.$NormalMonth.$DateDay;
    return($normal_time);
}

function forum_online_num($f){
	global $mysql;
	$count = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '1' AND O_FORUM_ID = '$f' OR O_MEMBER_LEVEL = '2' AND O_FORUM_ID = '$f'  ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
    return $count;
}

function forum_online_name($text){
	global $mysql;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE ".$text." ", [], __FILE__, __LINE__);
	$i = 0;
	$check_br = 0;
	while( $result = $sql->fetch() ){
		$member_id = $result["O_MEMBER_ID"];
		$member_name = normal_profile(members("NAME", $member_id), $member_id);
			if($i > 0){
				echo'&nbsp;<font color="red">+</font>&nbsp;';
			}
			echo $member_name;
			$check_br = $check_br + 1;
			if($check_br == 5){
				echo'<br>';
				$check_br = 0;
			}
		++$i;
	}
}

function member_topics_today($id, $f){
	
	$yesterday = time()-(60*60*24);
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_AUTHOR = '$id' AND FORUM_ID = '$f' AND T_DATE > '$yesterday'  ", [], __FILE__, __LINE__);
	$topics = mysql_num_rows($sql);
	return($topics );
}

function member_replies_today($id, $f){
	
	$yesterday = time()-(60*60*24);
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = '$id' AND FORUM_ID = '$f' AND R_DATE > '$yesterday'  ", [], __FILE__, __LINE__);
	$topics = mysql_num_rows($sql);
	return($topics );
}

function member_is_online($id){

	$online_sql = $mysql->execute("SELECT * FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_ID = '$id' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($online_sql) > 0){
		$is_online = 1;
	}
	else{
		$is_online = 0;
	}
    return($is_online);
}

function check_cat_login($c){
	global $mysql, $DBMemberID, $Mlevel;
	
	$chk_mon = chk_monitor($DBMemberID, $c);
	$chk_mod = chk_moderator($DBMemberID, $f);

	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}HIDE_FORUM WHERE HF_MEMBER_ID = '$DBMemberID' AND HF_CAT_ID = '$c' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	if( $count > 0 ){
		$login = 1;
	}
	else{
		if($Mlevel == 4 OR $chk_mon == 1 OR $chk_mod == 1){
			$login = 1;
		}
		else{
			$login = 0;
		}
	}
    return($login);
}

function check_forum_login($f){
	global $mysql, $DBMemberID;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}HIDE_FORUM WHERE HF_MEMBER_ID = '$DBMemberID' AND HF_FORUM_ID = '$f' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	if( $count > 0 ){
		$login = 1;
	}
	else{
		if(allowed($f, 2) == 1){
			$login = 1;
		}
		else{
			$login = 0;
		}
	}
return($login);
}

function go_to_forum(){
	global $lang, $Prefix;
		echo'
		<form>
		<td class="optionsbar_menus"><b><nobr>'.$lang['go_to']['go_to_forum'].':</nobr></b><br>
		<select class="forumSelect" style="WIDTH: 140px" size="1" onchange="if(this.options[this.selectedIndex].value>0){window.location=\'index.php?mode=f&f=\'+this.options[this.selectedIndex].value;}else{this.selectedIndex=0;return;}">
			<option value="0">&nbsp;'.$lang['go_to']['choose_forum'].'</option>';
	$cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC ", [], __FILE__, __LINE__);

	while ($r_cat = mysql_fetch_array($cat)){
		$cat_id = $r_cat['CAT_ID'];
		$cat_name = $r_cat['CAT_NAME'];
		$cat_level = $r_cat['CAT_LEVEL'];

                                    if($cat_level == 0 OR $cat_level > 0 AND $cat_level <= mlv){
		
			echo'
			<option value="0">------------------------------------------------------------------------</option>';
		
		$forum = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$cat_id' ORDER BY F_ORDER ASC ", [], __FILE__, __LINE__);

		while ($r_forum = mysql_fetch_array($forum)){
			$forum_id = $r_forum['FORUM_ID'];
			$f_subject = $r_forum['F_SUBJECT'];
			$f_level = $r_forum['F_LEVEL'];
			$f_hide = forums("HIDE", $forum_id);
			$check_forum_login = check_forum_login($forum_id);

		if($f_level == 0 OR $f_level > 0 AND $f_level <= mlv){
		if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
			echo'
			<option value="'.$forum_id.'">'.$f_subject.'</option>';
		}}
		
		}
	
	}}
		echo'
		</select>
		</td>
		</form>';
}

function refresh_time(){
	global $refresh_time;
	echo'
	<form name="reload_frm" method="post" action="'.$_SERVER['REQUEST_URI'].'">
	<td class="optionsbar_menus"><nobr>تحديث الصفحة:</nobr><br>
		<select style="WIDTH: 75px" name="refresh_time" onchange="this.form.submit();">
			<option value=00 '.check_select($refresh_time, 00).'>لا تحديث</option>
			<option value="1" '.check_select($refresh_time, 1).'>كل دقيقة</option>
			<option value="5" '.check_select($refresh_time, 5).'>كل 5 دقائق</option>
			<option value="10" '.check_select($refresh_time, 10).'>كل 10 دقائق</option>
			<option value="15" '.check_select($refresh_time, 15).'>كل 15 دقيقة</option>
		</select>
	</td>
	</form>
	<script language="javascript" type="text/javascript">
		var ref_time = document.reload_frm.refresh_time.value
		if(ref_time > 0){
			self.setInterval(\'document.reload_frm.submit()\', 60000 * ref_time)
		}
	</script>';
}

function order_by(){
	global $order_by;
			echo'
			<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<td class="optionsbar_menus"><nobr>الترتيب بتاريخ:</nobr><br>
				<select style="WIDTH: 70px" name="order_by" onchange="submit();">
					<option value="post" '.check_select($order_by, "post").'>آخر مشاركة</option>
					<option value="topic" '.check_select($order_by, "topic").'>الموضوع</option>
				</select>
			</td>
			</form>';
}

function topic_paging($t){
	global $Prefix, $reply_num_page, $icon_unhidden;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
	$cols = ceil($num / $reply_num_page);
	if($cols > 1){
		echo'
		<table border="0" cellpadding="0" cellspacing="1">
			<tr>
				<td valign="bottom">'.icons($icon_unhidden).'</td>';
			$i = 0;
			while($i < $cols){
				$topic_id = mysql_result($sql, $i, "TOPIC_ID");
				$count = 0;
				$counter += 1;
				echo'
				<td align="right" valign="bottom">
					<font size="1">
						<a href="index.php?mode=t&t='.$topic_id.'&pg='.$counter.'">'.$counter.'</a>
					</font>
				</td>';
				$page = $page + 1;
				if($page == 17){
					echo'</tr><tr>';
					$page = 0;
				}
			++$i;
			}
			echo'
			</tr>
		</table>';
	}
}

function reply_num_page(){
	global $reply_num_page;
	echo'
	<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
	<td class="optionsbar_menus" vAlign="top"><nobr>حجم الصفحة:<br>
	<select style="WIDTH: 65px" name="reply_num_page" onchange="submit();">
		<option value="10" '.check_select($reply_num_page, "10").'>10 ردود</option>
		<option value="30" '.check_select($reply_num_page, "30").'>30 رد</option>
		<option value="50" '.check_select($reply_num_page, "50").'>50 رد</option>
		<option value="70" '.check_select($reply_num_page, "70").'>70 رد</option>
	</select></nobr>
	</td></form>';
}

function chk_mf_id($id){
    
    $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEDAL_FILES WHERE MF_ID = '$id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($sql) > 0){
		$chk_id = 1;
	}
	else{
		$chk_id = 0;
	}
return($chk_id);
}

function chk_member_id($id){
    
    $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($sql) > 0){
		$chk_id = 1;
	}
	else{
		$chk_id = 0;
	}
return($chk_id);
}

function chk_gm_id($id){
    
    $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}GLOBAL_MEDALS WHERE MEDAL_ID = '$id' ", [], __FILE__, __LINE__);
    if(mysql_num_rows($sql) > 0){
		$chk_id = 1;
	}
	else{
		$chk_id = 0;
	}
return($chk_id);
}

function chk_allowed_forums(){
	if(mlv == 2){
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '".m_id."' ", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num  > 0){
			$x = 0;
			while($x < $num){
				$all_forums[] = mysql_result($sql, $x, "FORUM_ID");
			++$x;
			}
		}
		else{
			$all_forums = "";
		}
	}
	else if(mlv == 3){
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_MONITOR = '".m_id."' ", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num  > 0){
			$x = 0;
			while($x < $num){
				$c = mysql_result($sql, $x, "CAT_ID");
				$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$c' ", [], __FILE__, __LINE__);
				$row = mysql_num_rows($forums);
				if($row > 0){
					$i = 0;
					while($i < $row){
						$all_forums[] = mysql_result($forums, $i, "FORUM_ID");
					++$i;
					}
				}
			++$x;
			}
		}
		else{
			$all_forums = "";
		}
	}
	else if(mlv == 4){
		$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ", [], __FILE__, __LINE__);
		$num = mysql_num_rows($sql);
		if($num  > 0){
			$x = 0;
			while($x < $num){
				$all_forums[] = mysql_result($sql, $x, "FORUM_ID");
			++$x;
			}
		}
		else{
			$all_forums = "";
		}
	}
	else{
		$all_forums = "";
	}
return($all_forums);
}

function chk_allowed_forum_id($f){
	$all_forums = chk_allowed_forums();
	for($x = 0; $x < count($all_forums); $x++){
		$f_id = $all_forums[$x];
		if($f_id == $f){
			$chk = $chk + 1;
		}
	}
	if($chk > 0){
		$chk_id = 1;
	}
	else{
		$chk_id = 0;
	}
return($chk_id);
}

function chk_allowed_forums_all_id(){
	$forums = chk_allowed_forums();
	for($x = 0; $x < count($forums); $x++){
		$all_id .= $forums[$x];
		if($x+1 != count($forums)){
			$all_id .= ', ';
		}
	}
return($all_id);
}

function multi_page($sql, $max){
	global $lang, $pg, $_GET;
	$sql = $mysql->execute("SELECT COUNT(*) FROM ".prefix.$sql." ", [], __FILE__, __LINE__);
	$sql = mysql_result($sql, 0, "COUNT(*)");
	$all_pg = ceil($sql / $max);
	if($all_pg == 0){
		$multi_page = "";
	}
	else{
		$multi_page .= '
		<form>
		<td class="optionsbar_menus">'.$lang['forum']['page'].'&nbsp;:
		<select size="1" onchange="window.location = \'index.php?'.chk_get_self($_GET).'pg=\'+this.options[this.selectedIndex].value;">';
		for($i = 1; $i <= $all_pg; $i++){
			$multi_page .= '
			<option value="'.$i.'" '.check_select($pg, $i).'>'.$i.' '.$lang['forum']['from'].' '.$all_pg.'</option>';
		}
		$multi_page .= '
		</select>
		</td>
		</form>';
	}
return($multi_page);
}

function chk_get_self($x){
	foreach(array_keys($x) as $keys){
		if($keys != "pg"){
			$get .= $keys.'='.$x[$keys].'&';
		}
	}
return($get);
}

function days_added($days, $date){
   global $chk_timezone;
	$date = $date+$chk_timezone;
	$all_days = $days*60*60*24;
	$normal_date = $date + $all_days;
	if(time() > $normal_date){
		$ays_added = '<font color="orange">إنتهى</font>';
	}
	else{
		$ays_added = normal_date($normal_date);
	}
return($ays_added);
}

function member_all_points($m){
	
	$sql = $mysql->execute("SELECT SUM(POINTS) FROM {$mysql->prefix}MEDALS WHERE MEMBER_ID = '$m' AND STATUS = '1' ", [], __FILE__, __LINE__);
	$all = mysql_result($sql, 0, "SUM(POINTS)");
return($all);
}

function online_numbers($x){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}ONLINE WHERE O_MEMBER_LEVEL = '$x' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function users_number($l, $s){
	if($l > 0){
		$level = " AND M_LEVEL = '$l'";
	}
	else{
		$level = "";
	}
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '$s' ".$level." ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function topics_numbers(){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function topics_numbers_for_24_h($x){
	$time = time() - 60*60*24*$x;
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS WHERE T_DATE > '$time' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function topics_numbers_middle(){
   global $chk_timezone;
	$date = $date+$chk_timezone;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS ORDER BY T_DATE ASC ", [], __FILE__, __LINE__);
	$rs = mysql_fetch_array($sql);
	$date = $rs['T_DATE'];
	$all_days = time() - $date;
	$all_days = $all_days / 60;
	$all_days = $all_days / 60;
	$all_days = $all_days / 24;
	$mid = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}TOPICS ", [], __FILE__, __LINE__);
	$count = mysql_result($mid, 0, "count(*)");
	$normal_mid = round($count / $all_days, 2);
return($normal_mid);
}

function replies_numbers_middle(){
   global $chk_timezone;
	$date = $date+$chk_timezone;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS ORDER BY T_DATE ASC ", [], __FILE__, __LINE__);
	$rs = mysql_fetch_array($sql);
	$date = $rs['T_DATE'];
	$all_days = time() - $date;
	$all_days = $all_days / 60;
	$all_days = $all_days / 60;
	$all_days = $all_days / 24;
	$mid = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY ", [], __FILE__, __LINE__);
	$count = mysql_result($mid, 0, "count(*)");
	$normal_mid = round($count / $all_days, 2);
return($normal_mid);
}

function replies_numbers_for_24_h($x){
	$time = time() - 60*60*24*$x;
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE R_DATE > '$time' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function replies_numbers(){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function num_user_wait(){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '2' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
	if($count == ""){
		$count = 0;
	}
return($count);
}

function num_user_not_agree(){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}MEMBERS WHERE M_STATUS = '3' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
	if($count == ""){
		$count = 0;
	}
return($count);
}



function msg_numbers_for_24_h($x){
	$time = time() - 60*60*24*$x;
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_DATE > '$time' ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function msg_numbers(){
	$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM ", [], __FILE__, __LINE__);
	$count = mysql_result($sql, 0, "count(*)");
return($count);
}

function msg_numbers_middle(){
   global $chk_timezone;
	$date = $date+$chk_timezone;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}PM ORDER BY PM_DATE ASC ", [], __FILE__, __LINE__);
	$rs = mysql_fetch_array($sql);
	$date = $rs['PM_DATE'];
	$all_days = time() - $date;
	$all_days = $all_days / 60;
	$all_days = $all_days / 60;
	$all_days = $all_days / 24;
	$mid = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM", [], __FILE__, __LINE__);
	$count = mysql_result($mid, 0, "count(*)");
	$normal_mid = round($count / $all_days, 2);
return($normal_mid);
}

function error_message($txt){
	global $lang;
	echo'<br>
	<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10">
				<font size="5" color="red"><br><b>'.$txt.'</b><br><br></font>
				<a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
			</td>
		</tr>
	</table>
	</center><xml>';
}

function error_msg($txt){
	global $lang;
	echo'<br>
	<center>
	<table width="100%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10">
							<br>
<font size="4" color="red" ><b><br>'.$txt.'<br><br></b></font>

<a href="JavaScript:history.go(-1)">
											<br>
<span style="font-size: 14pt">'.$lang['profile']['click_here_to_go_normal_page'].'</font>
<font size="4" color="red" ><b><br> <br><br></b></font>
			</td>

		</tr>
	</table>
	</center><xml>';
}


function error_admin($txt){
	global $lang;
	echo'<br><p align="left">
: WARNING 
<p align="left">!! Invalid hacking attempt detected</p>
<p align="left">.&nbsp;Your IP address and details have been registered in our system</p>
<p align="left">.&nbsp;Continuous attempts will be reported to the relevant authorities</p>

                           <meta http-equiv="Refresh" content="4; URL=index.php">
	</center><xml></p>';
}

function error_pass($txt){
	global $lang;
	echo'<br>
	<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10">
				<font size="5" color="red"><br><b>'.$txt.'</b>
				<font size="5" color="red"><br><b>يمكنك إسترجاع كلمتك السرية عبر الوصلة أدناه</b><br><br></font>
				<a href="index.php?mode=forget_pass">إسترجع كلمتك السرية</a><br><br>
			</td>
		</tr>
	</table>
	</center><xml>';
}

function chk_id($val1, $val2, $id){
	$sql = $mysql->execute("SELECT * FROM ".prefix.$val1." WHERE ".$val2." = '$id' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$chk_id = 1;
	}
	else{
		$chk_id = 0;
	}
return($chk_id);
}

function chk_login_topic($t){
	global $DBMemberID;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPIC_MEMBERS WHERE MEMBER_ID = '$DBMemberID' AND TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$status = 1;
	}
	else{
		$status = 0;
	}
return($status);
}

function chk_load_topic($t){
	global $Mlevel, $DBMemberID;
	$f = topics("FORUM_ID", $t);
	$f_hide = forums("HIDE", $f);
	$status = topics("STATUS", $t);
	$t_hide = topics("HIDDEN", $t);
	$t_unmoderated = topics("UNMODERATED", $t);
	$t_holded = topics("HOLDED", $t);
	$author = topics("AUTHOR", $t);
	if(chk_id("TOPICS", "TOPIC_ID", $t) == 1){
		if($f_hide == 0 OR check_forum_login($f) == 1){
			if($status == 0 OR $status == 1 OR ($status == 2 && allowed($f, 1) == 1)){
				if(($t_hide == 0 OR chk_login_topic($t) == 1 OR allowed($f, 2) == 1 OR $author == $DBMemberID) AND ($t_unmoderated == 0 OR chk_login_topic($t) == 1 OR allowed($f, 2) == 1 OR $author == $DBMemberID) AND ($t_holded == 0 OR chk_login_topic($t) == 1 OR allowed($f, 2) == 1 OR $author == $DBMemberID)){
					$load = 1;
				}
				else{
					$load = 0;
				}
			}
			else {
				$load = 0;			
			}
		}
		else{
			$load = 0;
		}
	}
	else{
		$load = 0;
	}
return($load);
}

function chk_load_reply($r){
	global $Mlevel, $DBMemberID;
	$f = replies("FORUM_ID", $r);
	$f_hide = forums("HIDE", $f);
	$t = replies("TOPIC_ID", $r);
	$t_hide = topics("HIDDEN", $t);
	$t_author = topics("AUTHOR", $t);
	$r_hide = replies("HIDDEN", $r);
	$r_unmoderated = replies("UNMODERATED", $r);
	$r_holded = replies("HOLDED", $r);
	$r_status = replies("STATUS", $r);
	$author = replies("AUTHOR", $r);
	if(chk_id("REPLY", "REPLY_ID", $r) == 1){
		if($f_hide == 0 OR check_forum_login($f) == 1){
			if(($r_status == 2 AND allowed($f, 2) == 1) OR $r_status == 1){
				if($t_hide == 0 OR chk_login_topic($t) == 1 OR allowed($f, 2) == 1 OR $t_author == $DBMemberID){
					if(($r_hide == 0 OR allowed($f, 2) == 1 OR $author == $DBMemberID) AND (($r_unmoderated == 0 OR allowed($f, 2) == 1 OR $author == $DBMemberID)) AND (($r_holded == 0 OR allowed($f, 2) == 1 OR $author == $DBMemberID))){
						$load = 1;
					}
					else{
						$load = 0;
					}
				}
				else{
					$load = 0;
				}
			}
			else{
				$load = 0;
			}
		}
		else{
			$load = 0;
		}
	}
	else{
		$load = 0;
	}
return($load);
}

function chk_is_topic_in_topic_members($t){
	global $DBMemberID;
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPIC_MEMBERS WHERE MEMBER_ID = '$DBMemberID' AND TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($sql) > 0){
		$status = 1;
	}
	else{
		$status = 0;
	}
return($status);
}

function chk_update_login_members(){
	global $mysql;
	$mysql->execute("UPDATE {$mysql->prefix}MEMBERS SET M_LAST_IP = '"._ip."', M_LAST_HERE_DATE = '".time()."' WHERE MEMBER_ID = '".m_id."' ", [], __FILE__, __LINE__);
}

function members_new_pm($m){
	$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$m' AND PM_OUT = '0' AND PM_READ = '0' AND PM_STATUS = '1' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
return($count);
}

function chk_login_ip($name,$pass){
	global $mysql;
	$rs=$mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = '$name'", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$u_pass=$rs['M_PASSWORD'];
		$mlv=$rs['M_LEVEL'];
		if($u_pass!=$pass&&$mlv>1){
			update_ip(1,$rs['MEMBER_ID']);
		}
	}
}

function chk_login_name($userName,$userPass){
	global $mysql;
	$rs=$mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME = '$userName'", [], __FILE__, __LINE__)->fetch();
	if(is_array($rs)){
		$status=$rs['M_STATUS'];
		$pass=$rs['M_PASSWORD'];
		$level=$rs['M_LEVEL'];
		if($pass!=$userPass){
			$login="pass";
		}
		elseif($pass!=$userPass&&$level>1){
			$login="waw";
		}
		elseif($pass!=$userPass&&$level==4){
			$login="noo";
		}
		elseif($status==0){
			$login="lock";
		}
		elseif($status==2){
			$login="wait";
		}
		elseif($status==3){
			$login="bad";
		}
		else{
			$login="";
		}
	}
	else{
		$login="name";
	}
	return $login;
}

function login_error_msg($login){
	global $admin_email;
	if($login=="name"){
		error_message("لا يمكنك الدخول بهذا الاسم لأنه ليس مسجل لدينا");
	}
	elseif($login=="pass"){
		error_message("لا يمكنك الدخول للمنتديات لأن الكلمة السرية ليست مطابقة لسجلاتنا‌‌");
	}
	elseif($login=="lock"){
		error_message("لا يمكنك الدخول للمنتديات لأن هذه العضوية مقفولة من قبل الإدارة");
	}
	elseif($login=="wait"){
		error_message("لايمكنك الدخول الى المنتديات بسبب<br>لم يتم مراجعة والموافقة لعضويتك من قبل الإدارة حتى الآن<br>اذا لم يتم الموافقة لأكتر من 48 ساعة<br>ارسل رسالة لنا عبر هذا الايميل: <a href='mailto:".$admin_email."'>".$admin_email."</a>");
	}
	elseif($login=="waw"){
		error_msg("قد تم إكتشاف محاولة دخول بإسم مشرف أو مدير بكلمة سرية <br> غير صحيحة. لقد تم تسجيل بيانات جهازك واتصالك في سجلاتنا الدائمة.‌‌");
	}
	elseif($login=="bad"){
		error_message("لايمكنك الدخول الى المنتديات بسبب<br>تم رفض طلب عضويتك من قبل الإدارة<br>لأنه غير مطابق لقوانين المنتدى<br>نتمنى ان تقوم بتسجيل عضوية أخرى ومطابقة لقوانين المنتدى ليتم موافقة عليه.");
	}
	elseif($login=="noo"){
		error_admin(":WARNING<br>!! Invalid hacking attempt detected<br>.Your IP address and details have been registered in our system<br>.Continuous attempts will be reported to the relevant authorities");
	}
}

//############################### MODERATIONS FUNCTIONS ###############################

function chk_new_member_posts($m){
    global $mysql, $new_member_min_posts;
	$rs = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$m' ", [], __FILE__, __LINE__)->fetch();
	if( is_array($rs) ){
	   $posts = $rs['M_POSTS'];
	}
	if($posts > $new_member_min_posts){
		$chk_mposts = 1;
	}
	else {
	   $chk_mposts = 0;
	}
    return($chk_mposts);
}

function mod_OneForum($m, $f){
    global $mysql;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATION WHERE M_STATUS = '1' AND M_MEMBERID = '$m' AND M_FORUMID = '$f' AND M_TYPE = '1' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	if( $count > 0 ){
		$chk_mod = 1;
	}
	else {
	    $chk_mod = 0;
	}
    return($chk_mod);
}

function mod_ShowForum($m, $f){
    global $mysql;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATION WHERE M_STATUS = '1' AND M_MEMBERID = '$m' AND M_FORUMID = '$f' AND M_TYPE = '11' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	if( $count > 0 ){
		$chk_mod = 1;
	}
	else {
	    $chk_mod = 0;
	}
    return($chk_mod);
}

function mod_AllForum($m){
    global $mysql;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATION WHERE M_STATUS = '1' AND M_MEMBERID = '$m' AND M_TYPE = '2' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
    if( $count > 0 ){
        $chk_mod = 1;
	}
	else {
	    $chk_mod = 0;
	}
    return($chk_mod);
}

function mon_OneForum($m, $f){
    global $mysql;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATION WHERE M_STATUS = '1' AND M_MEMBERID = '$m' AND M_FORUMID = '$f' AND M_TYPE = '3' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
    if( $count > 0 ){
        $chk_mon = 1;
	}
	else {
	    $chk_mon = 0;
	}
    return($chk_mon);
}

function mon_AllForum($m){
    global $mysql;
	$count = $mysql->execute("SELECT COUNT(*) FROM {$mysql->prefix}MODERATION WHERE M_STATUS = '1' AND M_MEMBERID = '$m' AND M_TYPE = '4' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
    if( $count > 0 ){
        $chk_mon = 1;
	}
	else {
	    $chk_mon = 0;
	}
    return $chk_mon;
}

//############################### SURVEYS FUNCTIONS ###############################

function forum_survey_count($id){
	global $mysql;
	$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}SURVEYS WHERE FORUM_ID = '".$id."' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	return $count;
}

function add_new_option($svid, $option, $other){
	global $mysql;
	die($svid);
	$mysql->execute("INSERT INTO {$mysql->prefix}SURVEY_OPTIONS (SO_ID, SURVEY_ID, OPTION, OTHER) VALUES (NULL,'".$svid."', '".$option."', '".$other."') ", [], __FILE__, __LINE__);
}

function update_option($svid, $option, $other){
	global $mysql;
	$mysql->execute("UPDATE {$mysql->prefix}SURVEY_OPTIONS SET OPTION = '".$option."', OTHER = '".$other."' WHERE SO_ID = '".$svid."' ", [], __FILE__, __LINE__);
}

function vote($sid, $oid, $fid, $tid, $mid, $date){
	global $mysql;
	$mysql->execute("INSERT INTO {$mysql->prefix}VOTES (VOTE_ID, SURVEY_ID, OPTION_ID, FORUM_ID, TOPIC_ID, MEMBER_ID, DATE) VALUES (NULL,'".$sid."', '".$oid."', '".$fid."', '".$tid."', '".$mid."', '".$date."') ", [], __FILE__, __LINE__);
}

function update_vote($oid, $sid, $mid, $date){
	global $mysql;
	$mysql->execute("UPDATE {$mysql->prefix}VOTES SET OPTION_ID = '$oid', DATE = '$date' WHERE SURVEY_ID = '$sid' AND MEMBER_ID = '$mid' ", [], __FILE__, __LINE__);
}

function votes_count($oid){
	global $mysql;
	$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}VOTES WHERE OPTION_ID = '$oid' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	return $count;
}

function total_votes($sid){
	global $mysql;
	$count = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}VOTES WHERE SURVEY_ID = '$sid' ", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$count = intval($count[0]);
	return $count;
}

function option_percentage($oid, $sid){
    $option = votes_count($oid) * 100;
    $total_vote = total_votes($sid) + 0.01;
    $option = $option / $total_vote;
    $option = ceil($option);
    return($option);
}

function pb_percentage($oid, $sid){
    $pb = 100 - option_percentage($oid, $sid);
    $pb = ceil($pb);
    return($pb);
}

//############################### EDITS INFO FUNCTIONS ###############################

function hideReply_info($m, $r, $status){
	global $Prefix, $chk_timezone;
	if($status == "OPEN"){ $status = 1; }
	if($status == "HIDE"){ $status = 0; }
	$date = time();
	$date = $date+$chk_timezone;
	$sql = $mysql->execute("INSERT INTO {$mysql->prefix}HIDE_INFO (HIDE_ID, STATUS, MEMBER_ID, REPLY_ID, DATE) VALUES (NULL, '".$status."', '".$m."', '".$r."', '".$date."') ", [], __FILE__, __LINE__);
}

function hideTopic_info($m, $t, $status){
	global $Prefix, $chk_timezone;
	if($status == "OPEN"){ $status = 1; }
	if($status == "HIDE"){ $status = 0; }
	$date = time();
	$date = $date+$chk_timezone;
	$sql = $mysql->execute("INSERT INTO {$mysql->prefix}HIDE_INFO (HIDE_ID, STATUS, MEMBER_ID, TOPIC_ID, DATE) VALUES (NULL, '".$status."', '".$m."', '".$t."', '".$date."') ", [], __FILE__, __LINE__);
}

function insert_old_topic_data($t, $subject, $message){
	$sql = "INSERT INTO {$mysql->prefix}EDITS_INFO (EDIT_ID, MEMBER_ID, TOPIC_ID, OLD_SUBJECT, OLD_MESSAGE, DATE) VALUES (NULL, ";
	$sql .= " '".m_id."', ";
	$sql .= " '$t', ";
	$sql .= " '$subject', ";
	$sql .= " '$message', ";
	$sql .= " '".time()."') ";
	$mysql->execute($sql, [], __FILE__, __LINE__);
}

function insert_new_topic_data($t, $subject, $message){
	$sql = $mysql->execute("SELECT MAX(EDIT_ID) FROM {$mysql->prefix}EDITS_INFO WHERE TOPIC_ID = '$t' ", [], __FILE__, __LINE__);
	$id = mysql_result($sql, 0, "MAX(EDIT_ID)");

	$up = "UPDATE {$mysql->prefix}EDITS_INFO SET ";
	$up .= "NEW_SUBJECT = '$subject', ";
	$up .= "NEW_MESSAGE = '$message' ";
	$up .= "WHERE EDIT_ID = '$id' ";
	$mysql->execute($up, [], __FILE__, __LINE__);
}

function insert_old_reply_data($r, $message){
	$sql = "INSERT INTO {$mysql->prefix}EDITS_INFO (EDIT_ID, MEMBER_ID, REPLY_ID, OLD_MESSAGE, DATE) VALUES (NULL, ";
	$sql .= " '".m_id."', ";
	$sql .= " '$r', ";
	$sql .= " '$message', ";
	$sql .= " '".time()."') ";
	$mysql->execute($sql, [], __FILE__, __LINE__);
}

function insert_new_reply_data($r, $message){
	$sql = $mysql->execute("SELECT MAX(EDIT_ID) FROM {$mysql->prefix}EDITS_INFO WHERE REPLY_ID = '$r' ", [], __FILE__, __LINE__);
	$id = mysql_result($sql, 0, "MAX(EDIT_ID)");

	$up = "UPDATE {$mysql->prefix}EDITS_INFO SET ";
	$up .= "NEW_MESSAGE = '$message' ";
	$up .= "WHERE EDIT_ID = '$id' ";
	$mysql->execute($up, [], __FILE__, __LINE__);
}

//############################### QUOTE FUNCTION ###############################

function admin($m_name,$m_id,$Prefix)
	{$resultLP2=$mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID='$m_id' ", [], __FILE__, __LINE__);
	if(mysql_num_rows($resultLP2)>0)
	{$rsLP2=mysql_fetch_array($resultLP2);
		$LP2_MemberID=$rsLP2['MEMBER_ID'];
		$LP2_MemberLevel=$rsLP2['M_LEVEL'];
		$LP2_MemberStatus=$rsLP2['M_STATUS'];
		}
	if($LP2_MemberLevel==4)
	{$admin="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color='#FFFFFF'>".$m_name."</font></a>";}
	if($LP2_MemberLevel<4)
	{$admin="<a href=\"index.php?mode=profile&id=".$m_id."\"><font color='#FFFFFF'>".$m_name."</font></a>";}
return($admin);}

function reply_quote($mid, $message, $date){
	global $Prefix;

$reply_quote = '<br>
<center>
<table width="95%" cellspacing="0" cellpadding="0" bordercolor="gray" border="0">
<tbody>
	<tr>
		<td bgcolor="gray" width="5%">
		<nobr><font color="yellow" size="2">&nbsp;&nbsp;&nbsp;إقتباس لمشاركة:&nbsp;</font></nobr>
		</td>
		<td bgcolor="gray" width="5%">
		<nobr><font size="2"><b>'.admin(member_name($mid), $mid, $Prefix).'</b></font></nobr>
		</td>
		<td bgcolor="gray" width="90%">
		<font color="yellow" size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.normal_time($date).'</font>
		</td>
	</tr>
	<tr>
		<td colspan="3">
	<table width="100%" cellpadding="4" bordercolor="gray" border="1">
	<tbody>
	<tr>
		<td>'.$message.'</td>
	</tr>
	</tbody>
	</table>
		</td>
	</tr>
</tbody>
</table>
</center>';

return ($reply_quote);
}

//############################### QUOTE FUNCTION ###############################

function member_replies_in_topic($m, $t, $type){
	if($type == "NORMAL"){
	    $Open_SQL = "AND R_STATUS = '1' AND R_HIDDEN = '0' AND R_UNMODERATED = '0' AND R_HOLDED = '0' ";
	}
	else if($type == "DELETED"){
	    $Open_SQL = "AND R_STATUS = '2' AND R_HIDDEN = '0' AND R_UNMODERATED = '0' AND R_HOLDED = '0' ";
	}
	else if($type == "HIDDEN"){
	    $Open_SQL = "AND R_STATUS = '1' AND R_HIDDEN = '1' AND R_UNMODERATED = '0' AND R_HOLDED = '0' ";
	}
	else if($type == "UNMODERATED"){
	    $Open_SQL = "AND R_STATUS = '1' AND R_HIDDEN = '0' AND R_UNMODERATED = '1' AND R_HOLDED = '0' ";
	}
	else if($type == "HOLDED"){
	    $Open_SQL = "AND R_STATUS = '1' AND R_HIDDEN = '0' AND R_UNMODERATED = '0' AND R_HOLDED = '1' ";
	}
	else if($type == "TOTAL"){
	    $Open_SQL = "";
	}
		$sql = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}REPLY WHERE TOPIC_ID = '$t' AND R_AUTHOR = '$m' ".$Open_SQL." ", [], __FILE__, __LINE__);
		$Count = mysql_result($sql, 0, "count(*)");
		if($Count > 0){
		    $Count = $Count;
		}
		else {
		    $Count = "";
		}
return($Count);
}

//############################### TIMEZONE FUNCTION ###########################

function gmt_time($date){
  global $chk_timezone;
    $gmt_time=$date + $chk_timezone;
    $gmt_time=date("H:i",$gmt_time);
    return($gmt_time);
}

//############################### Forums Order ###########################

function forums_order(){
$query = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE F_HIDE = '0'", [], __FILE__, __LINE__);
$num = mysql_num_rows($query);
$x = 0;
$time =  before_days(30);
while ($x < $num){
$f = mysql_result($query, $x, "FORUM_ID");
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}REPLY WHERE FORUM_ID=".$f." AND R_DATE > ".$time."", [], __FILE__, __LINE__);
$reply_num = mysql_num_rows($sql);
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = ".$f." AND T_DATE > ".$time."", [], __FILE__, __LINE__);
$sql_num = mysql_num_rows($sql);
$topic_num = 3 * $sql_num;
$forum_points = $reply_num + $topic_num;
$forum_order = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM_ORDER WHERE FORUM_ID = ".$f."", [], __FILE__, __LINE__);
$data = mysql_fetch_array($forum_order);
$id = $data['FO_ID'];
if($id == ""){
$insert = $mysql->execute("INSERT INTO {$mysql->prefix}FORUM_ORDER (FO_ID,FORUM_ID,FO_POINTS,FO_OLD_POINTS,FO_ORDER,FO_OLD_ORDER) VALUES (NULL,'$f','$forum_points','$forum_points',NULL,NULL)", [], __FILE__, __LINE__);
}
if($id > 0){
$order = $data['FO_ORDER'];
$points = $data['FO_POINTS'];
$update = $mysql->execute("UPDATE {$mysql->prefix}FORUM_ORDER SET FO_POINTS = '$forum_points', FO_OLD_POINTS = '$points', FO_OLD_ORDER = '$order' WHERE FORUM_ID = ".$f."", [], __FILE__, __LINE__);
}
$x++;
}
$i = 1;
$c = 0;
$forum_order = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM_ORDER ORDER BY FO_POINTS DESC", [], __FILE__, __LINE__);
$forum_order_num = mysql_num_rows($forum_order);
while ($c < $forum_order_num){
$fo_id = mysql_result($forum_order, $c, "FO_ID");
$fo_order = mysql_result($forum_order, $c, "FO_OLD_ORDER");
if($fo_order == ""){
$to = ", FO_OLD_ORDER = ".$i."";
} else {
$to = "";
}
$update = $mysql->execute("update {$mysql->prefix}FORUM_ORDER SET FO_ORDER = ".$i." ".$to." WHERE FO_ID = ".$fo_id."", [], __FILE__, __LINE__);
$i++;
$c++;
}
}

function forum_order($f){
	global $mysql;
	$rs = $mysql->execute("SELECT FO_ORDER FROM {$mysql->prefix}FORUM_ORDER WHERE FORUM_ID = ".$f."", [], __FILE__, __LINE__)->fetch(PDO::FETCH_NUM);
	$order = $rs['FO_ORDER'];
	if( $order == "" ){
		$order = 0;
	}
	return $order;
}

function use_pm(){
	global $user_info;
	if( $user_info['M_USE_PM'] == 1 ){
		go_to("index.php?mode=msg&err=23");
		exit();
	}
}

?>
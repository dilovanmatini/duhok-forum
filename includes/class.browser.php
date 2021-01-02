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

class Browser{
	var $mobile_types = array(
		'os' => array('android', 'blackberry', 'epoc', 'linux armv', 'palmos', 'palmsource', 'symbianos', 'symbian os', 'symbian', 'webos', 'windows phone os', 'windows ce', 'cpu os', 'iphone os'),
		'device' => array('benq', 'blackberry', 'danger hiptop', 'ddipocket', ' droid', 'htc_dream', 'htc espresso', 'htc hero', 'htc halo', 'htc huangshan', 'htc legend', 'htc liberty', 'htc paradise', 'htc supersonic', 'htc tattoo', 'ipad', 'ipod', 'iphone', 'kindle', 'lge-cx', 'lge-lx', 'lge-mx', 'lge vx', 'lg;lx', 'nintendo wii', 'nokia', 'palm', 'pdxgw', 'playstation', 'sagem', 'samsung', 'sec-sgh', 'sharp', 'sonyericsson', 'sprint', 'zunehd', 'zune', 'j-phone', 'milestone', 'n410', 'mot 24', 'mot-', 'htc-', 'htc_',  'htc ', 'lge ', 'lge-', 'sec-', 'sie-m', 'sie-s', 'spv ', 'vodaphone', 'smartphone', 'armv', 'midp', 'mobilephone'),
		'browser' => array('avantgo', 'blazer', 'elaine', 'eudoraweb', 'iemobile',  'minimo', 'mobile safari', 'mobileexplorer', 'opera mobi', 'opera mini', 'netfront', 'opwv', 'polaris', 'semc-browser', 'up.browser', 'webpro/', 'wms pie', 'xiino')
	);
	var $user_agent = '';
	var $catch = null;
	function __construct($DF){
		if(is_object($DF)){
			$DF->browser =& $this;
		}
		else{
			trigger_error("Error: [df]", E_USER_ERROR);
		}
		$this->user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	}
	function get($get = 'full', $user_agent = ''){
		if(is_array($this->catch) && empty($user_agent)){
			if($get == 'full'){
				return $this->catch;
			}
			else{
				if(isset($this->catch[$get])){
					return $this->catch[$get];
				}
			}
		}
		if(!empty($user_agent)){
			$user_agent = strtolower($user_agent);
			$this->user_agent = $user_agent;
		}
		else{
			$user_agent = $this->user_agent;
		}
		$browsers = array(
			array('opera', 1, 1),
			array('msie', 1, 1, array('acoo browser', 'america online browser', 'aol', 'avant browser', 'browzar', 'crazy browser', 'deepnet explorer', 'escape', 'iemobile', 'greenbrowser', 'irider', 'kkman', 'lobo', 'lunascape', 'maxthon', 'myie2', 'sleipnir', 'slimbrowser', 'surf', 'tencenttraveler', 'theworld', 'blazer')),
			array('webkit', 1, 1, array('weltweitimnetzbrowser', 'arora', 'flock', 'fluid', 'comodo_dragon', 'shiira', 'sunrise', 'stainless', 'netnewswire', 'navscape', 'rockmelt', 'qtweb internet browser', 'osb-browser', 'lunascape', 'deskbrowse', 'dooble', 'leechcraft', 'element browser', 'iron', 'blackberry', 'chromeplus', 'chromium', 'epiphany', 'gtklauncher', 'icab', 'abrowse', 'bolt', 'konqueror', 'maxthon', 'midori', 'omniweb', 'rekonq', 'cheshire', 'uzbl', 'hana', 'chrome', 'safari', 'applewebkit', 'webkit')),
			array('gecko', 1, 1, array('bonecho', 'camino', 'epiphany', 'myibrow', 'orca', 'namoroka', 'kmlite', 'madfox', 'palemoon', 'lunascape', 'firebird', 'granparadiso', 'flock', 'cometbird', 'galeon', 'iceape', 'lolifox', 'lorentz', 'icecat', 'k-meleon', 'k-ninja', 'beonex', 'minimo', 'vonkeror', 'multizilla', 'kapiko', 'kazehakase', 'phoenix', 'songbird', 'swiftfox', 'sylera', 'seamonkey', 'shadowfox', 'shiretoko', 'iceweasel', 'conkeror', 'pogo', 'prism', 'wyzo', 'chimera', 'navigator', 'minefield', 'firefox', 'netscape6', 'netscape', 'rv')),
			array('konqueror', 1, 1),
			array('icab', 1),
			array('netpositive', 2),
			array('lynx', 2),
			array('elinks', 2),
			array('links2', 2),
			array('links', 2),
			array('w3m', 2),
			array('webtv', 2),
			array('amaya', 2),
			array('dillo', 2),
			array('ibrowse', 2),
			array('cyberdog', 2),
			array('fireweb navigator', 2),
			array('galaxy', 2),
			array('hotjava', 2),
			array('webexplorer', 2),
			array('inet browser', 2),
			array('mosaic', 2),
			array('omniweb', 2),
			array('oregano', 2),
			array('answerbus'),
			array('ask jeeves'),
			array('teoma'),
			array('baiduspider'),
			array('bingbot'),
			array('boitho.com-dc'),
			array('exabot'),
			array('fast-webcrawler'),
			array('ia_archiver'),
			array('googlebot'),
			array('google web preview'),
			array('mediapartners-google'),
			array('msnbot'),
			array('objectssearch'),
			array('scooter'),
			array('yahoo-verticalcrawler'),
			array('yahoo! slurp'),
			array('yahoo-mm'),
			array('inktomi'),
			array('slurp'),
			array('zyborg'),
			array('almaden'),
			array('comodospider'),
			array('gigabot'),
			array('iltrovatore-setaccio'),
			array('lexxebotr'),
			array('magpie-crawlero'),
			array('naverbot'),
			array('omgilibot'),
			array('openbot'),
			array('psbot'),
			array('sogou'),
			array('sosospider'),
			array('sohu-search'),
			array('surveybot'),
			array('vbseo'),
			array('w3c_validator', 4),
			array('wdg_validator', 4),
			array('libwww-perl', 4),
			array('jakarta commons-httpclient', 4),
			array('python-urllib', 4),
			array('getright', 3),
			array('wget', 3),
			array('mozilla', 2, 0, array('charon'))
		);
		$name = '';
		$dom = 0;
		$safe = 0;
		$build = '';
		$device = 0;
		$childs = '';
		$full_version = 0;
		$msie_version = 0;
		$webkit_version = 0;
		$gecko_rv = 0;
		$gecko_date = 0;
		$opera_build = array();
		$device_type = array(
			0 => 'webbot',
			1 => 'normalbrowser',
			2 => 'simplebrowser',
			3 => 'downloadagent',
			4 => 'httplibrary',
			5 => 'mobile'
		);
		$ns_version = 0;
		$success = false;
		for($i = 0; $i < count($browsers); $i++){
			if(strstr($user_agent, $browsers[$i][0])){
				$safe = 1;
				$name = $browsers[$i][0];
				$build = $browsers[$i][0];
				$device = (isset($browsers[$i][1])) ? $browsers[$i][1] : 0;
				$dom = (isset($browsers[$i][2])) ? $browsers[$i][2] : 0;
				$childs = $browsers[$i][3];
				if($build == 'ns'){
					$ns_version = $this->get_version('mozilla');
					if($ns_version < 5){
						$safe = 0;
					}
					if(is_array($childs)){
						foreach($childs as $child){
							if(strstr($user_agent, $child)){
								$name = $child;
								$full_version = $this->get_version($name);
								break;
							}
						}
					}
					if($full_version == 0){
						$full_version = $ns_version;
					}
				}
				elseif($build == 'gecko'){
					$gecko_rv = $this->get_version('rv:');
					$gecko_date = "{$this->get_version('gecko')}";
					$gecko_date = intval(substr($gecko_date, 0, 8));
					if(is_array($childs)){
						foreach($childs as $child){
							if(strstr($user_agent, $child)){
								$name = $child;
								$full_version = $this->get_version($name);
								break;
							}
						}
					}
					if(($gecko_date < 20020400) || ($gecko_rv < 1)){
						$safe = 0;
					}
				}
				elseif($build == 'msie'){
					$msie_version = $this->get_version($name);
					if(is_array($childs)){
						foreach($childs as $child){
							if(strstr($user_agent, $child)){
								$name = $child;
								$full_version = $this->get_version($name);
								break;
							}
						}
					}
					if($full_version == 0){
						$full_version = $msie_version;
					}
					if($msie_version <= 3){
						$dom = 0;
						$safe = 0;
					}
					elseif(($msie_version > 3) && ($msie_version < 5)){
						$dom = 0;
						$safe = 1;
					}
				}
				elseif($build == 'opera'){
					$full_version = $this->get_version($name);
					if(strstr($full_version, '9.') && strstr($user_agent, 'version/')){
						$full_version = $this->get_version('version/');
					}
					if(floatval($full_version) < 5){
						$safe = 0;
					}
					if(strstr($user_agent, 'msie')){
						$opera_build['msie'] = $this->get_version('msie');
					}
					if(strstr($user_agent, 'gecko')){
						$opera_gecko = array();
						$opera_gecko['date'] = $this->get_version('gecko');
						if(strstr($user_agent, 'rv:')){
							$opera_gecko['rv'] = $this->get_version('rv:');
						}
						$opera_build['gecko'] = $opera_gecko;
					}
					if(strstr($user_agent, 'webkit')){
						$opera_build['webkit'] = $this->get_version('webkit');
					}
				}
				elseif($build == 'webkit'){
					$webkit_version = $this->get_version($name);
					if(is_array($childs)){
						foreach($childs as $child){
							if(strstr($user_agent, $child)){
								$name = $child;
								if(($name == 'safari' && strpos($user_agent, 'version/')) || $name == 'blackberry'){
									$search = 'version/';
								}
								elseif($name == 'leechcraft' && floatval($webkit_version) < 5){
									$search = 'leechcraft/poshuku';
								}
								elseif($name == 'navscape'){
									$search = 'navscape/pre-';
								}
								else{
									$search = $name;
								}
								$full_version = $this->get_version($search);
								if($name == 'safari' && (floatval($full_version) > 50 || floatval($full_version) == 0)){
									if($webkit_version > 400 && $webkit_version < 420){
										$full_version = '2.0';
									}
									elseif($webkit_version > 80 && $webkit_version < 320){
										$full_version = '1.0';
									}
									else{
										$full_version = '0.1';
									}
								}
								break;
							}
						}
					}
				}
				else{
					$full_version = $this->get_version($name);
				}
				$success = true;
				break;
			}
		}
		if(!$success){
			$name = substr($user_agent, 0, strcspn($user_agent , '();'));
			if($name && preg_match('/[^0-9][a-z]*-*\ *[a-z]*\ *[a-z]*/', $name, $unhandled)){
				$name = $unhandled[0];
				$build = $unhandled[0];
				$pos = ($name == 'blackberry') ? 5 : 0;
				$full_version = $this->get_version($name, $pos);
			}
			else{
				$name = 'NA';
				$build = 'NA';
				$full_version = 'NA';
			}
		}
		$version = $this->get_math_version($full_version);
		$gecko_list = '';
		if($build == 'gecko'){
			$gecko_list = array(
				'rv' => $gecko_rv,
				'date' => $gecko_date
			);
		}
		$opera_list = '';
		if(count($opera_build) > 0){
			$opera_list = $opera_build;
		}
		$mobile_name = $this->check_is_mobile();
		$mobile_list = '';
		if($mobile_name){
			$mobile_list = $this->get_mobile_data();
			$device = 5;
		}
		$full_data = array(
			'build' => $build,
			'name' => $name,
			'version' => $version,
			'full_version' => $full_version,
			'device' => $device_type[$device],
			'os' => $this->get_os_data($name, $full_version),
			'dom' => $dom,
			'safe' => $safe,
			'msie' => $msie_version,
			'webkit' => $webkit_version,
			'gecko' => $gecko_list,
			'opera' => $opera_list,
			'mobile' => $mobile_name,
			'mobile_data' => $mobile_list
		);
		$this->catch = $full_data;
		if($get == 'full'){
			return $full_data;
		}
		else{
			if(isset($full_data[$get])){
				return $full_data[$get];
			}
			else{
				die("You passed the browser detector an unsupported option for parameter 1: {$get}");
			}
		}
	}
	function get_os_data($browser_name, $browser_version){
		$user_agent = $this->user_agent;
		$type = '';
		$system = '';
		$version = '';
		$unix_types = array('dragonfly', 'freebsd', 'openbsd', 'netbsd', 'bsd', 'unixware', 'solaris', 'sunos', 'sun4', 'sun5', 'suni86', 'sun', 'irix5', 'irix6', 'irix', 'hpux9', 'hpux10', 'hpux11', 'hpux', 'hp-ux', 'aix1', 'aix2', 'aix3', 'aix4', 'aix5', 'aix', 'sco', 'unixware', 'mpras', 'reliant', 'dec', 'sinix', 'unix');
		$linux_types = array('ubuntu', 'kubuntu', 'xubuntu', 'mepis', 'xandros', 'linspire', 'winspire', 'jolicloud', 'sidux', 'kanotix', 'debian', 'opensuse', 'suse', 'fedora', 'redhat', 'slackware', 'slax', 'mandrake', 'mandriva', 'gentoo', 'sabayon', 'linux');
		$types = array('android', 'blackberry', 'iphone', 'palmos', 'palmsource', 'symbian', 'beos', 'os2', 'amiga', 'webtv', 'mac', 'nt', 'win', $unix_types, $linux_types);
		$count = count($types);
		for($i = 0; $i < $count; $i++){
			$data = $types[$i];
			if(!is_array($data) && strstr($user_agent, $data) && !strstr($user_agent, "linux")){
				$type = $data;
				if($type == 'nt'){
					if(strstr($user_agent, 'nt 6.1')){
						$system = 'windows 7';
						$version = 6.1;
					}
					elseif(strstr($user_agent, 'nt 6.0')){
						$system = 'windows vista/server 2008';
						$version = 6.0;
					}
					elseif(strstr($user_agent, 'nt 5.2')){
						$system = 'windows server 2003';
						$version = 5.2;
					}
					elseif(strstr($user_agent, 'nt 5.1') || strstr($user_agent, 'xp')){
						$system = 'windows xp';
						$version = 5.1;
					}
					elseif(strstr($user_agent, 'nt 5') || strstr($user_agent, '2000')){
						$system = 'windows 2000';
						$version = 5.0;
					}
					elseif(strstr($user_agent, 'nt 4')){
						$system = 'windows 98';
						$version = 4;
					}
					elseif(strstr($user_agent, 'nt 3')){
						$system = 'windows 95';
						$version = 3;
					}
				}
				elseif($type == 'win'){
					if(strstr($user_agent, 'vista')){
						$system = 'windows vista, for opera id';
						$version = 6.0;
						$type = 'nt';
					}
					elseif(strstr($user_agent, 'xp')){
						$system = 'windows xp, for opera id';
						$version = 5.1;
						$type = 'nt';
					}
					elseif(strstr($user_agent, '2003')){
						$system = 'windows server 2003, for opera id';
						$version = 5.2;
						$type = 'nt';
					}
					elseif(strstr($user_agent, 'windows ce')){
						$system = 'windows ce';
						$version = 'ce';
						$type = 'nt';
					}
					elseif(strstr($user_agent, '95')){
						$system = 'windows 95';
						$version = '95';
					}
					elseif((strstr($user_agent, '9x 4.9')) ||(strstr($user_agent, ' me'))){
						$system = 'windows me';
						$version = 'me';
					}
					elseif(strstr($user_agent, '98')){
						$system = 'windows 98';
						$version = '98';
					}
					elseif(strstr($user_agent, '2000')){
						$system = 'windows 2000, for opera id';
						$version = 5.0;
						$type = 'nt';
					}
				}
				elseif($type == 'mac'){
					if(strstr($user_agent, 'os x')){
						if(strstr($user_agent, 'os x ')){
							$system = 'mac os x';
							$version = str_replace('_', '.', $this->get_version('os x'));
						}
						else{
							$system = 'mac os';
							$version = 10;
						}
					}
					elseif($browser_name == 'safari' || (($browser_name == 'mozilla') && ($browser_version >= 1.3)) || (($browser_name == 'msie') && ($browser_version >= 5.2))){
						$system = 'mac os';
						$version = 10;
					}
				}
				elseif($type == 'iphone'){
					$system = 'iphone';
					$version = 10;
				}
				break;
			}
			elseif(is_array($data) && ($i == ($count - 2))){
				for($x = 0; $x < count($data); $x++){
					if(strstr($user_agent, $data[$x])){
						$system = 'unix';
						$type = 'unix';
						$version = ($data[$x] != 'unix') ? $data[$x] : '';
						break;
					}
				}
			}
			elseif(is_array($data) && ($i == ($count - 1))){
				for($x = 0; $x < count($data); $x++){
					if(strstr($user_agent, $data[$x])){
						$system = 'linux';
						$type = 'lin';
						$version = ($data[$x] != 'linux')? $data[$x] : '';
						break;
					}
				}
			}
		}
		$os_data = array(
			'type' => $type,
			'system' => $system,
			'version' => $version
		);
		return $os_data;
	}
	function check_is_mobile(){
		$user_agent = $this->user_agent;
		$type = '';
		foreach($this->mobile_types as $types){
			for($x = 0; $x < count($types); $x++){
				if(strstr($user_agent, $types[$x])){
					$type = $types[$x];
					break;
				}
			}
		}
		return $type;
	}
	function get_mobile_data(){
		$user_agent = $this->user_agent;
		$browser = '';
		$browser_version = '';
		$device = '';
		$device_version = '';
		$os = '';
		$os_version = '';
		foreach($this->mobile_types as $name => $list){
			for($x = 0; $x < count($list); $x++){
				if(strstr($user_agent, $list[$x])){
					if($name == 'browser'){
						$browser = $list[$x];
						$browser_version = $this->get_version($browser);
						break;
					}
					if($name == 'device'){
						$device = trim($list[$x], '-_');
						$device_version = $this->get_version($device);
						$device = trim($device);
						break;
					}
					if($name == 'os'){
						$os = $list[$x];
						if($os != 'blackberry'){
							$os_version = str_replace('_', '.', $this->get_version($os));
						}
						else{
							$os_version = str_replace('_', '.', $this->get_version('version'));
							if(empty($os_version)){
								$os_version = str_replace('_', '.', $this->get_version($os, 5));
							}
						}
						break;
					}
				}
			}
		}
		if(!$os && ($browser || $device) && strstr($user_agent, 'linux')){
			$os = 'linux';
			$os_version = $this->get_version('linux');
		}
		$mobile_data = array(
			'browser' => $browser,
			'browser_version' => $browser_version,
			'device' => $device,
			'device_version' => $device_version,
			'os' => $os,
			'os_version' => $os_version
		);
		return $mobile_data;
	}
	function get_version($name, $pos = 0){
		$user_agent = $this->user_agent;
		$start = strpos($user_agent, $name);
		$version = 0;
		if($start === false){
			$start = -1;
		}
		if($start >= 0){
			$length = strlen($name);
			$user_agent = substr($user_agent, ($start + $length + $pos));
			$chars = array(' ', '/', ':', ';', ')', '(', 'v');
			while(in_array(substr($user_agent, 0, 1), $chars)){
				$user_agent = substr($user_agent, 1);
			}
			$user_agent = trim($user_agent);
			if(!empty($user_agent)){
				if(preg_match('/^([0-9\._]*)/', $user_agent, $new_version)){
					$version = $new_version[0];
				}
			}
		}
		return $version;
	}
	function get_math_version($version){
		if($version && preg_match('/^[0-9]*\.*[0-9]*/', $version, $new_version)){ 
			$version = $new_version[0];
		}
		else{
			$version = 0;
		}
		return $version;
	}
}
?>
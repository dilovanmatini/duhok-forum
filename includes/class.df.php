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

// ############################## $DF->clean() types #########################################
const CLEAN_INT                     = 1;    // become integer
const CLEAN_FLOAT                   = 2;    // become float
const CLEAN_BOOL                    = 3;    // become boolean
const CLEAN_STR                     = 4;    // become string
const CLEAN_TRIM                    = 5;    // become string (with trim)
const CLEAN_ARRAY                   = 6;    // become array
const CLEAN_ARRAYBLANK              = 7;    // delete array's blank keys & blank values
const CLEAN_ARRAYKEYBLANK           = 8;    // delete array's blank keys
const CLEAN_ARRAYVALBLANK           = 9;    // delete array's blank values
const CLEAN_FULLHTML                = 10;   // check HTML
const CLEAN_NOHTML                  = 11;   // delete all HTML with trim string
const CLEAN_EASYHTML                = 12;   // delete blocked tags & attributes & check HTML
const CLEAN_HTMLENCODE              = 13;   // convert " and ' and > and < to escape text
const CLEAN_HTMLDECODE              = 14;   // convert escape text to " and ' and > and <
const CLEAN_INLINE                  = 15;   // string become in one line (delete \t \r \n)
const CLEAN_FILE                    = 16;   // force file
const CLEAN_BINARY                  = 17;   // force binary string
const CLEAN_SERIALIZE               = 18;   // array become serialize string
const CLEAN_UNSERIALIZE             = 19;   // array become unserialize (become array)
const CLEAN_STRTOUPPER              = 22;   // convert string to upper case
const CLEAN_STRTOLOWER              = 23;   // convert string to lower case
const CLEAN_MYSQL                   = 24;   // will use CLEAN_HTMLENCODE and CLEAN_REAL_ESCAPE_STRING
const CLEAN_REAL_ESCAPE_STRING      = 25;   // for characters encode: NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.
const CLEAN_ADDSLASHES              = 26;   // add slashes for example ' to \' and " to \" and \ to \\
const CLEAN_STRIPSLASHES            = 27;   // strip slashes for example \' to ' and \" to " and \\ to \
const CLEAN_LETTERS                 = 28;   // to replace some unicode characters to orginal
const CLEAN_NUMBERS                 = 28;   // to replace arabic numbers to english numbers

class DF{
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
			define( '_is_local', $df_config['local'] === true );
		}
		catch( Exception $e ){
			die( "DF Error: {$e->getMessage()}" );
		}
    }

    /**
     * You can use this for go to another url quickly.
     * You can't use this function after print any thing.
     */
	function goto_quick( $url = '' ){
		@ob_end_clean();
		@header("Location: {$url}");
		exit();
    }
    
    /**
     * You can use this for go to another url slowly.
     * You can use this function after print any thing.
     */
	function goto_slow( $url = '' ){
		echo"<script type=\"text/javascript\">window.location = '{$url}';</script>";
		exit();
    }
    
    /**
     * To set cookies you can use this function.
     * You can't use this function after print any thing.
     */
	function set_cookie( $name, $value = '', $expiry = -1, $params = [] ){
		$config = $this->config['cookies'];
		$name = trim($name);
		if( empty($name) ) return;
		$name = "{$config['prefix']}{$name}";
		if( $expiry > 0 ){
			$date = new DateTime();
			$date->modify("+{$expiry} days");
			$expiry = $date->getTimestamp();
		}
		else{
			$expiry = 0;
		}
		$path = isset($params['path']) ? $params['path'] : null;
		$domain = isset($params['domain']) ? $params['domain'] : null;
		$secure = isset($params['secure']) ? $params['secure'] : null;
		$httponly = isset($params['httponly']) ? $params['httponly'] : null;
		try{
			setcookie( $name, $value, $expiry, $path, $domain, $secure, $httponly );
		}
		catch( Exception $e ){
			$this->error( 'globals::set_cookie', $e->getMessage() );
		}
		return $this;
	}
	
	/**
     * To get cookies you can use this function.
     */
	function get_cookie($name){
		$cookies = $this->config['cookies'];
		$name = trim($name);
		if( empty($name) ) return;
		$name = "{$cookies['prefix']}{$name}";
		if( isset($_COOKIE["{$name}"]) ){
			return $_COOKIE["{$name}"];
		}
		return '';
	}

	/**
     * To get changed date or time, it means date by default timezone or user timezone if it sets.
     */
	function timezone( $custom_timezone = false ){
		$timezone = 0;
		
		// if user change time zone for him or custom timezone.
		if( $custom_timezone !== false ){
			$timezone = $custom_timezone;
		}
		else{
			$config_timezone = intval( __timezone );
			$user_timezone = intval( $this->login->user['timezone'] );
			$timezone = ( $user_timezone < 13 ) ? $user_timezone : $config_timezone;
		}

		return $timezone;
	}
	function create_datetime( $datetime = _datetime ){
		
		$datetime = strval($datetime);
		if( !preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/', $datetime) ){
			if( preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/', $datetime) ){
				$datetime = "{$datetime} 00:00:00";
			}
			else{
				$datetime = '';
			}
		}

		return $datetime;
	}
	function datetime( $format = 'Y-m-d H:i:s', $datetime = _datetime, $custom_timezone = false ){
		
		$datetime = $this->create_datetime( $datetime );
		if( !empty($datetime) ){
			$timezone = $this->timezone( $custom_timezone );
			$datetime_obj = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
			
			if( $datetime_obj ){
				if( $timezone > 0 ){
					$datetime_obj->modify("+{$timezone} hour");
				}
				elseif( $timezone < 0 ){
					$datetime_obj->modify("-{$timezone} hour");
				}

				$datetime = $datetime_obj->format($format);
			}
			else{
				$datetime = '';
			}
		}

		return $datetime;
	}
	function original_datetime( $format, $datetime = _datetime, $custom_timezone = 0 ){
		return $this->datetime( $format, $datetime, $custom_timezone );
	}
	function change_date( $date, $from_format, $to_format = 'Y-m-d' ){
		$date_obj = DateTime::createFromFormat( $from_format, $date );
		if( $date_obj ){
			$date = $date_obj->format( $to_format );
		}
		else{
			$date = '';
		}
		
		return $date;
	}
	function is_date( $date, $format = 'Y-m-d', $year_range = '1800-2099' ){
		if( empty($date) || strlen($date) < 8 || strlen($date) > 10 || strlen($format) != 5 ){
			return false;
		}
		
		$sep = substr( $format, 1, 1 );
		$format_vars = explode( $sep, $format );
		$date_vars = explode( $sep, $date );

		$year = 0;
		$month = 0;
		$day = 0;
		$x = 0;
		foreach( $format_vars as $var ){
			if( $var == 'Y' ){
				$year = intval($date_vars[$x]);
			}
			elseif( $var == 'm' ){
				$month = intval($date_vars[$x]);
			}
			elseif( $var == 'd' ){
				$day = intval($date_vars[$x]);
			}
			else{
				return false;
			}
			$x++;
		}
		
		$year_range = explode( '-', $year_range );
		$year_start = intval($year_range[0]);
		$year_end = intval($year_range[1]);
		
		if( $year < $year_start || $year > $year_end ){
			return false;
		}
		
		return checkdate( $month, $day, $year );
	}
	function is_time( $time, $format = 'H:i:s' ){
		if( empty($time) || strlen($time) < 3 || strlen($time) > 8 || strlen($format) < 3 || strlen($format) > 5 ){
			return false;
		}
		
		$sep = substr($format, 1, 1);
		$format_vars = explode($sep, $format);
		$time_vars = explode($sep, $time);
		
		$is24 = true;
		$hour = 0;
		$minute = 0;
		$second = 0;
		$x = 0;
		foreach( $format_vars as $var ){
			if( $var == 'H' || $var == 'h' || $var == 'G' || $var == 'g' ){
				$hour = intval($time_vars[$x]);
				if( $var == 'h' || $var == 'g' ){
					$is24 = false;
				}
			}
			elseif( $var == 'i' ){
				$minute = intval($time_vars[$x]);
			}
			elseif( $var == 's' ){
				$second = intval($time_vars[$x]);
			}
			else{
				return false;
			}
			$x++;
		}

		if( $is24 && ( $hour < 0 || $hour > 23 ) || !$is24 && ( $hour < 1 || $hour > 12 ) ){
			return false;
		}
		elseif( $minute < 0 || $minute > 59 ){
			return false;
		}
		elseif( $second < 0 || $second > 59 ){
			return false;
		}
		else{
			return true;
		}
	}
	function get_fixed_date( $date, $type = '', $mode = 'first', $modify = "" ){
		$types = ['week', 'month', 'year'];
		if( $this->is_date($date) && in_array($type, $types) ){
			$DT = new DateTime($date);
			if( $modify != "" ) $DT->modify($modify);
			if( $type == 'week' ){
				$reports_week_start_day = __reports_week_start_day;
				if( $mode == 'last' ){
					$last_day = $reports_week_start_day - 1;
					if( $last_day <= 0 ) $last_day += 7;
					$difference = ( $last_day - $DT->format('N') );
					if( $difference >= 0 ) $difference -= 7;
					$difference += 7;
					$DT->modify("$difference days");
				}
				else{ // get first if it is not set
					$difference = ( $reports_week_start_day - $DT->format('N') );
					if( $difference > 0 ) $difference -= 7;
					$DT->modify("$difference days");
				}
			}
			elseif( $type == 'month' ){
				if( $mode == 'last' ){
					$day = intval( $DT->format('d') );
					$days = intval( $DT->format('t') );
					$difference = $days - $day;
					$DT->modify("$difference days");
				}
				else{ // get first if it is not set
					$difference = ( intval( $DT->format('d') ) - 1 ) * -1;
					$DT->modify("$difference days");
				}
			}
			elseif( $type == 'year' ){
				if( $mode == 'last' ){
					$year = intval( $DT->format('Y') );
					$DT = new DateTime("{$year}-12-31");
				}
				else{ // get first if it is not set
					$year = intval( $DT->format('Y') );
					$DT = new DateTime("{$year}-01-01");
				}
			}
			$date = $DT->format('Y-m-d');
			return $date;
		}
		return false;
	}
	function get_startend_datetime( $format = "Y-m-d H:i:s", $start_datetime = "", $end_datetime = "", $modufy = ""  ){
		if( $start_datetime != '' && $end_datetime != '' ){
			$timezone = $this->timezone();
			if( $timezone > 0 ){
				$timezone = $timezone * -1;
			}
			elseif( $timezone < 0 ){
				$timezone = $timezone * 1;
			}
			$start_date = new DateTime( $start_datetime );
			$start_date->modify( "+{$timezone} hours");
			if( $modufy != "" ) $start_date->modify($modufy);
			$start_date = $start_date->format($format);

			$end_date = new DateTime( $end_datetime );
			$end_date->modify( "+{$timezone} hours");
			if( $modufy != "" ) $end_date->modify($modufy);
			$end_date = $end_date->format($format);
		}
		else{
			$start_date = '';
			$end_date = '';
		}
		return [
			'start' => $start_date,
			'end' => $end_date
		];
	}
	/**
	 * @param string $datetime
	 * @param string $endtime
	 * @param string $format
	 * @return int date1 < date2 = positive | date1 > date2 = negative | date1 == date2 = zero
	 */
	function datetime_diff_seconds( $startdate, $enddate, $format = '' ){
		if( empty($format) ){
			$start_datetime = new DateTime($startdate);
			$end_datetime = new DateTime($enddate);
		}
		else{
			$start_datetime = DateTime::createFromFormat( $format, $startdate );
			$end_datetime = DateTime::createFromFormat( $format, $enddate );
		}
		if( $start_datetime && $end_datetime ){
			$negative = ( $start_datetime > $end_datetime ) ? '-' : '';
			$diff = $start_datetime->diff($end_datetime);
			$params = explode( '-', $diff->format('%a-%h-%i-%s') );
			$seconds = intval($params[3]);
			$minutes = intval($params[2]);
			$hours = intval($params[1]);
			$days = intval($params[0]);
			$diff = $negative.( ( $days * ( 24 * 60 * 60 ) ) + ( $hours * ( 60 * 60 ) ) + ( $minutes * ( 60 ) ) + $seconds );
		}
		else{
			$diff = false;
		}
		return $diff;
	}
	function get_numbers_of_time( $seconds, $length = 2, $phrases = [] ){
		$seconds = intval($seconds);
		$second_text = isset($phrases['second']) ? $phrases['second'] : 'second';
		$seconds_text = isset($phrases['seconds']) ? $phrases['seconds'] : 'seconds';
		$minute_text = isset($phrases['minute']) ? $phrases['minute'] : 'minute';
		$minutes_text = isset($phrases['minutes']) ? $phrases['minutes'] : 'minutes';
		$hour_text = isset($phrases['hour']) ? $phrases['hour'] : 'hour';
		$hours_text = isset($phrases['hours']) ? $phrases['hours'] : 'hours';
		$day_text = isset($phrases['day']) ? $phrases['day'] : 'day';
		$days_text = isset($phrases['days']) ? $phrases['days'] : 'days';
		$month_text = isset($phrases['month']) ? $phrases['month'] : 'month';
		$months_text = isset($phrases['months']) ? $phrases['months'] : 'months';
		$year_text = isset($phrases['year']) ? $phrases['year'] : 'year';
		$years_text = isset($phrases['years']) ? $phrases['years'] : 'years';
		
		$seperator = isset($phrases['seperator']) ? $phrases['seperator'] : ', ';
		$kuka_system = $phrases['kuka_system'] === true ? 'ا' : '';
		
		$minutes = 0;
		$hours = 0;
		$days = 0;
		$months = 0;
		$years = 0;
		if( $seconds > 0 ){
			if( $seconds >= 60 ){
				$minutes = floor( $seconds / 60 );
				$seconds = $seconds - ( $minutes * 60 );
				if( $minutes >= 60 ){
					$hours = floor( $minutes / 60 );
					$minutes = $minutes - ( $hours * 60 );
					if( $hours >= 24 ){
						$days = floor( $hours / 24 );
						$hours = $hours - ( $days * 24 );
						if( $days >= 30 ){
							$months = floor( $days / 30 );
							$days = $days - ( $months * 30 );
							if( $months >= 12 ){
								$years = floor( $months / 12 );
								$months = $months - ( $years * 12 );
							}
						}
					}
				}
			}
			
			$start = false;
			$result = [];
			if( $years > 0 ){
				$text = ( $years > 1 ) ? $years_text : $year_text;
				$result[] = "{$years} {$text}";
				$length--;
				$start = true;
			}
			if( $length > 0 && ( $start || $months > 0 ) ){
				if( $months > 0 ){
					$text = ( $months > 1 ) ? $months_text : $month_text;
					$result[] = "{$months} {$text}";
				}
				$length--;
				$start = true;
			}
			if( $length > 0 && ( $start || $days > 0 ) ){
				if( $days > 0 ){
					$text = ( $days > 1 ) ? $days_text : $day_text;
					$result[] = "{$days} {$text}";
				}
				$length--;
				$start = true;
			}
			if( $length > 0 && ( $start || $hours > 0 ) ){
				if( $hours > 0 ){
					$text = ( $hours > 1 ) ? $hours_text : $hour_text;
					$result[] = "{$hours} {$text}";
				}
				$length--;
				$start = true;
			}
			if( $length > 0 && ( $start || $minutes > 0 ) ){
				if( $minutes > 0 ){
					$text = ( $minutes > 1 ) ? $minutes_text : $minute_text;
					$result[] = "{$minutes} {$text}";
				}
				$length--;
				$start = true;
			}
			if( $length > 0 && ( $start || $seconds > 0 ) ){
				if( $seconds > 0 ){
					$text = ( $seconds > 1 ) ? $seconds_text : $second_text;
					$result[] = "{$seconds} {$text}";
				}
				$length--;
				$start = true;
			}

			return implode($seperator, $result).$kuka_system;
		}
		else{
			return '';
		}
	}
	
	/**
     * To test if the string is email or not
     */
	function is_email( $email ){
		if( function_exists('filter_var') ){ //if PHP version is >= 5.2
			if( filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
		}
	}
	
	/**
     * Sending email
     */
	function mail_check_list_vars( $data ){
		if( is_array($data) ){
			if( count($data) >= 2 ){
				$name = $data[0];
				$email = $data[1];
			}
			elseif( count($data) == 1 ){
				$name = '';
				$email = $data[0];
			}
			else{
				$name = '';
				$email = '';
			}
		}
		else{
			$name = '';
			$email = $data;
		}
		return array(
			'name' => $name,
			'email' => $email
		);
	}
	function mail_check_list( $data ){
		$list = [];
		if( !is_array($data) ){
			if( $this->is_email($data) ){
				$list[] = array( '', $data );
			}
		}
		else{
			if( count($data) == 1 ){
				$list_vars = $this->mail_check_list_vars( $data[0] );
				if( $this->is_email($list_vars['email']) ){
					$list[] = array( $list_vars['name'], $list_vars['email'] );
				}
			}
			elseif( count($data) == 2 && !is_array($data[0]) && !is_array($data[1]) ){
				if( $this->is_email($data[0]) ){
					$list[] = array( '', $data[0] );
					if( $this->is_email($data[1]) ){
						$list[] = array( '', $data[1] );
					}
				}
				else{
					if( $this->is_email($data[1]) ){
						$list[] = array( $data[0], $data[1] );
					}
				}
			}
			elseif( count($data) >= 2 ){
				foreach( $data as $cell ){
					$list_vars = $this->mail_check_list_vars( $cell );
					if( $this->is_email($list_vars['email']) ){
						$list[] = array( $list_vars['name'], $list_vars['email'] );
					}
				}
			}
		}
		return $list;
	}
	/**
	 * FROM, TO, CC, BCC, and Reply list can be one of the following types:
	 * $to = "name@domain.com";
	 * $to = ["Full Name", "name@domain.com"];
	 * $to = [
	 * 		"name1@domain.com",
	 * 		"name2@domain.com",
	 * 		...
	 * ];
	 * $to = [
	 * 		["Full Name 1", "name1@domain.com"],
	 * 		["Full Name 2", "name2@domain.com"],
	 * 		...
	 * ];
	*/
	function mail( $subject, $message, $to, $params = [] ){

		$subject = empty($subject) ? $this->config['mail']['subject'] : trim($subject);
		if( empty($subject) ) return 'no_subject';
		
		$message = trim($message);
		if( empty($message) ) return 'no_message';
		
		$to_list = $this->mail_check_list( $to );
		if( count($to_list) == 0 ) return 'no_address_in_to_list';

		if( !is_array($params) ) $params = [];
		
		$from = isset($params['from']) ? $params['from'] : '';
		$reply = isset($params['reply']) ? $params['reply'] : '';
		$cc = isset($params['cc']) ? $params['cc'] : '';
		$bcc = isset($params['bcc']) ? $params['bcc'] : '';
		$attachments = isset($params['attachments']) ? $params['attachments'] : '';
		$host = isset($params['host']) ? $params['host'] : $this->config['mail']['host'];
		$port = isset($params['port']) ? $params['port'] : $this->config['mail']['port'];
		$smtpauth = isset($params['smtpauth']) ? $params['smtpauth'] : $this->config['mail']['smtpauth'];
		$smtpautotls = isset($params['smtpautotls']) ? $params['smtpautotls'] : $this->config['mail']['smtpautotls'];
		$username = isset($params['username']) ? $params['username'] : $this->config['mail']['username'];
		$password = isset($params['password']) ? $params['password'] : $this->config['mail']['password'];
		$charset = isset($params['charset']) ? $params['charset'] : 'utf-8';
		$smtp_auth = ( isset($params['smtp_auth']) && $params['smtp_auth'] === false ) ? false : true;
		$word_wrap = isset($params['word_wrap']) ? intval($params['word_wrap']) : 50;
		
		$from_list = $this->mail_check_list( $from );
		$reply_list = $this->mail_check_list( $reply );
		$cc_list = $this->mail_check_list( $cc );
		$bcc_list = $this->mail_check_list( $bcc );
		
		if( empty($host) ) $host = 'localhost';
		if( empty($port) ) $port = 25;
		
		if( !$this->is_email($username) ) return 'no_server_email';

		require_once 'PHPMailer/Exception.php';
		require_once 'PHPMailer/PHPMailer.php';
		require_once 'PHPMailer/SMTP.php';

		$mail = new PHPMailer\PHPMailer;
		$mail->SMTPSecure = 'tls';
		$mail->Timeout = 60;
		$mail->CharSet		= $charset;								// set charset
		$mail->IsSMTP();											// Sets Mailer to send message using SMTP.
		$mail->SMTPAuth   	= $smtpauth; 							// Sets SMTP authentication. Utilizes the Username and Password variables.
		$mail->SMTPAutoTLS 	= $smtpautotls; 
		$mail->Host       	= $host; 								// server host
		$mail->Port       	= $port; 								// server port
		$mail->Username   	= $username;						 	// server email address
		$mail->Password   	= $password;						 	// server email password
		$mail->WordWrap 	= $word_wrap; 							// Sets word wrapping on the body of the message to a given number of characters.
		$mail->IsHTML(true); 										// If HTML then run
		$mail->Subject 		= $subject; 							// Here is the subject
		$mail->AltBody 		= $this->nohtml($message); 				// This is the body in plain text for non-HTML mail clients
		$mail->msgHTML($message); 									// This is the HTML message body <b>in bold!</b>
		
		foreach( $to_list as $cell ){
			$name = $cell[0];
			$email = $cell[1];
			if( !empty($name) ){
				$mail->AddAddress( $email, $name );
			}
			else{
				$mail->AddAddress( $email );
			}
		}
		
		if( count($from_list) > 0 ){
			foreach( $from_list as $cell ){
				$name = $cell[0];
				$email = $cell[1];
				if( !empty($name) ){
					$mail->setFrom( $email, $name );
				}
				else{
					$mail->setFrom( $email );
				}
			}
		}
		else{
			$name = ( is_object($this->templates) ) ? $this->templates->title() : '';
			if( !empty($name) ){
				$mail->setFrom( $username, $name );
			}
			else{
				$mail->setFrom( $username );
			}
		}
		
		foreach( $reply_list as $cell ){
			$name = $cell[0];
			$email = $cell[1];
			if( !empty($name) ){
				$mail->AddReplyTo( $email, $name );
			}
			else{
				$mail->AddReplyTo( $email );
			}
		}
		
		foreach( $cc_list as $cell ){
			$name = $cell[0];
			$email = $cell[1];
			if( !empty($name) ){
				$mail->addCC( $email, $name );
			}
			else{
				$mail->addCC( $email);
			}
		}
		
		foreach( $bcc_list as $cell ){
			$name = $cell[0];
			$email = $cell[1];
			if( !empty($name) ){
				$mail->addBCC( $email, $name );
			}
			else{
				$mail->addBCC( $email );
			}
		}

		/**
		 * Attachments can be added like:
		 * $attachments = "file.ext";
		 * $attachments = ["file1.ext", "file2.ext", ...];
		 */
		if( is_array($attachments) ){
			foreach( $attachments as $path ){
				if( file_exists($path) ){
					$mail->addAttachment($path);
				}
			}
		}
		elseif( $attachments != '' ){
			if( file_exists($attachments) ){
				$mail->addAttachment($attachments);
			}
		}

 		if( $mail->Send() ){
			return 'sent';
		}
		else{
			return $mail->ErrorInfo;
		}
	}
	
	/**
     * Create config variables from CONFIG table.
     */
	function define_config_table(){
		$sql = $this->mysql->execute("SELECT keyword, text FROM ".$this->mysql->prefix."CONFIG", [], __FILE__, __LINE__);
		while( $result = $sql->fetch(PDO::FETCH_NUM) ){
			if( $result[0] == 'xcode' ){
				define("__xcode", "?x={$result[1]}");
				define("__xcode2", "&x={$result[1]}");
				continue;
			}
			define("__{$result[0]}", $result[1]);
		}
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
                            <td>Platform: {$this->config['mail']['subject']}<br>{$error_number_text}</td>
                        </tr>
                        <tr>
                            <td>{$subject}</td>
                        </tr>
                        <tr>
                            <td>
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

	/*
		Replace PHP array to json code
	*/
	function json_encode($json_array, $encode = true){
		$json = json_encode($json_array);
		if( $encode ){
			$json = urlencode($json);
			$json = str_replace('+', '%20', $json);
		}
		return $json;
	}
	
	/*
		ord number when use utf8
	*/
	function dm_ord_utf8( $string ){
		$offset = 0;
		$code = ord( substr($string, 0, 1) ); 
		if( $code >= 128 ){
			if($code < 224){
				$bytesnumber = 2;
			}
			elseif($code < 240){
				$bytesnumber = 3;
			}
			elseif($code < 248){
				$bytesnumber = 4;
			}
			$codetemp = ( $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0) );
			for( $i = 2; $i <= $bytesnumber; $i++ ){
				$offset++;
				$code2 = ( ord( substr($string, $offset, 1) ) - 128 );
				$codetemp = ( ( $codetemp * 64 ) + $code2 );
			}
			$code = $codetemp;
		}
		return $code;
	}
	
	/*
		chr text when use utf8
	*/
	function dm_chr_utf8( $number ){
		$number = intval($number);
		return mb_convert_encoding("&#{$number};", 'UTF-8', 'HTML-ENTITIES');
	}
	
	/*
		split utf8 text
	*/
	function dm_str_split_utf8( $str, $l = 0 ){
		if( $l > 0 ){
			$ret = [];
			$len = mb_strlen($str, "UTF-8");
			for($i = 0; $i < $len; $i += $l){
				$ret[] = mb_substr($str, $i, $l, "UTF-8");
			}
			return $ret;
		}
		return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
	}
	
	
	public static function preg_strip( $regexp, $text ){
		preg_match_all( $regexp, $text, $matches);
		$text = trim( iconv( 'utf-8', 'utf-8//IGNORE', implode("", $matches[0]) ) );
		return $text;
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

		$symbols = array(
			'`', '~', '!', '@', '#', '$', '%', '^', '&', '\\',
			'(', ')', '{', '}', '[', ']', '<', '>', "'", '"',
			'=', '+', '-', '*', '/', '_', '.', ',', '?', '|',
			':', ';'
		);
		
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
	function search( $text, $properties = [] ){
		if( !is_array($properties) ){
			$properties = [];
		}
		if( !isset($properties['strip_symbols']) ){
			$properties['strip_symbols'] = true;
		}
		if( !isset($properties['strip_kurdish']) ){
			$properties['strip_kurdish'] = true;
		}
		if( !isset($properties['strip_space']) ){
			$properties['strip_space'] = true;
		}
		$properties['search'] = true;
		return $this->text_convert( $text, $properties );
	}
	function arabic_has_invalid_characters( $name ){
		$allowed_characters = array(
			'ا', 'أ', 'إ', 'آ', 'ء',
			'ب', 'ت', 'ث', 'پ',
			'ج', 'ح', 'خ', 'چ',
			'د', 'ذ', 'ر', 'ز', 'ژ', 'ڕ',
			'س', 'ش', 'ص', 'ض',
			'ط', 'ظ',
			'ع', 'غ',
			'ف', 'ق', 'ڤ',
			'ك', 'گ', 'ل', 'ڵ',
			'م', 'ن',
			'ھ', 'ه', 'ة', 'ە',
			'و', 'ؤ', 'ۆ',
			'ي', 'ى', 'ئ', 'ی', 'ێ',
			'َ', // فتحة
			'ِ', // كسرة
			'ُ', // ضمة
			'ً', // تنوين مع فتح
			'ٌ', // تنوين مع كسر
			'ٍ', // تنوين مع ضمة
			'ْ', // سكون
			'ّ', // شدة
			' ' // فراغ
		);
		
		preg_match_all( "/(".implode("|", $allowed_characters).")/", $name, $matches);
		$cleaned_name = trim( iconv( 'utf-8', 'utf-8//IGNORE', implode("", $matches[0]) ) );

		if( $cleaned_name != $name ){
			return 1;
		}
		else{
			return 0;
		}
	}
	public function rewrite_array( $array, $callback ){
		if( is_array($array) && is_callable($callback) ){
			$temp_array = $array;
			$array = [];
			foreach( $temp_array as $key => $value ){
				$array = $callback( $array, $key, $value );
			}
		}
		return $array;
	}
	function gzip( $fromSrc, $toSrc, $fromFile = false){
		if( $fromFile ){
			if( !file_exists($fromSrc) ){
				return;
			}
		    $fp = fopen( $fromSrc, "r" );
			$content = fread( $fp, filesize($fromSrc) );
			fclose($fp);
		}
		else{
			$content = $fromSrc;
		}
		$toSrc = "{$toSrc}.gz";
		if( file_exists($toSrc) ){
			unlink($toSrc);
		}
		$zp = gzopen( $toSrc, "w9" );
		gzwrite( $zp, $content );
		gzclose($zp);
	}
	function ungzip( $fromSrc, $toSrc='', $toFile = false ){
		if( !file_exists($fromSrc) ){
			return;
		}
		$zp = gzopen( $fromSrc, "r" );
		$content = fread( $zp, ( filesize($fromSrc) * 20 ) );
		gzclose($zp);
		if( $toFile ){
			if( file_exists($toSrc) ){
				unlink($toSrc);
			}
			$fp = fopen( $toSrc, "w" );
			fwrite( $fp, $content );
			fclose($fp );
		}
		else{
			return $content;
		}
	}

    /**
     * Cleaning the recieved values from browsers.
     */
	function clean( $data ){
		$arguments = func_get_args();
		unset($arguments[0]);
		
		foreach( $arguments as $type ){
			if( is_array($type) ){
				foreach( $type as $type2 ){
					$data = $this->_do_Clean($data, $type2);
				}
			}
			else{
				$data = $this->_do_Clean($data, $type);
			}
		}

		return $data;
	}
 	private function _do_Clean( $data, $type ){
		switch($type){
			case CLEAN_INT:					$data = intval($data);																break;
			case CLEAN_FLOAT:				$data = floatval($data);															break;
			case CLEAN_BOOL:				$data = in_array(strtolower($data), ['1', 'true']) ? 1 : 0;							break;
			case CLEAN_STR:					$data = "{$data}";																	break;
			case CLEAN_BINARY:				$data = "{$data}";																	break;
			case CLEAN_TRIM:				$data = trim("{$data}");															break;
			case CLEAN_ARRAY:				$data = is_array($data) ? $data : [];												break;
			case CLEAN_ARRAYBLANK:			$data = is_array($data) ? $this->clean_array_blank($data,'all') : [];				break;
			case CLEAN_ARRAYKEYBLANK:		$data = is_array($data) ? $this->clean_array_blank($data,'key') : [];				break;
			case CLEAN_ARRAYVALBLANK:		$data = is_array($data) ? $this->clean_array_blank($data,'val') : [];				break;
			case CLEAN_SERIALIZE:			$data = $this->serialize($data);													break;
			case CLEAN_UNSERIALIZE:			$data = $this->unserialize($data);													break;
			case CLEAN_STRTOUPPER:			$data = strtoupper("{$data}");														break;
			case CLEAN_STRTOLOWER:			$data = strtolower("{$data}");														break;
			case CLEAN_LETTERS:				$data = $this->clean_letters($data);												break;
			case CLEAN_NOHTML:				$data = $this->nohtml($data);														break;
			case CLEAN_EASYHTML:			$data = $this->easyhtml($data);														break;
			case CLEAN_FULLHTML:			$data = $this->fullhtml($data);														break;
			case CLEAN_HTMLENCODE:			$data = $this->html_encode($data);													break;
			case CLEAN_HTMLDECODE:			$data = $this->html_decode($data);													break;
			case CLEAN_INLINE:				$data = $this->inline_string($data);												break;
			case CLEAN_REAL_ESCAPE_STRING:	$data = $this->pdo->real_escape_string($data);									    break;
			case CLEAN_MYSQL:				$data = $this->clean_mysql($data);													break;
			case CLEAN_ADDSLASHES:			$data = addslashes( $data );														break;
			case CLEAN_STRIPSLASHES:		$data = stripslashes( $data );														break;
			case CLEAN_NUMBERS:				$data = $this->numbers_arabic_to_latin( $data );									break;
			case CLEAN_FILE: {
				if( is_array($data) ){
					if( is_array($data['name']) ){
						$files = count($data['name']);
						for( $x = 0; $x < $files; $x++ ){
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
					$data = [
						'name'     => '',
						'type'     => '',
						'tmp_name' => '',
						'error'    => 0,
						'size'     => 4,
					];
				}
				break;
			}
			default:{
				trigger_error("\$DF->clean() unknown type", E_USER_ERROR);
			}
		}
		return $data;
	}
	function inline_string($string){
		$string = str_replace(
			["\n", "\t", "\r"],
			'',
			$string
		);
		return $string;
	}
	function easyhtml($data){
 		$html = $this->fullhtml(
			$data,
			[
				'tags' => ['meta', 'script', 'style', 'textarea', 'frame', 'iframe', 'input', 'button', 'select'], // blocked tags
				'attr' => [ // blocked attributes
					'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
					'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate',
					'onbounce', 'oncellchange', 'onchange', 'onclick', 'onclose', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
					'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondragdrop', 'ondragend',
					'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrag', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange',
					'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
					'onloadonlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
					'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange',
					'onreset', 'onresize', 'onresizeend', 'onresizestartonrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll',
					'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload', 'onblur'
                ]
            ]
		);
		return $html;
	}
	function fullhtml( $text, $block = [] ){
		$SQ = "{s}";
		$EQ = "{e}";
		$block_tags = array(
			'script',
			'div',
			'span',
			'a',
			'textarea',
			'body',
			'head',
			'html',
			'i',
			'title'
		);
		$single_tags = array(
			'img',
			'br',
			'hr',
			'meta',
			'style',
			'link',
			'!'
		);
		$text = preg_replace("/<\s*([^>]*)\s*>/i", '<\\1>', $text);
		$text = preg_replace("/<\s*\/\s*([a-z]*)\s*>/i", '</\\1>', $text);
		if( count($block_tags) > 0 ){
			$text = preg_replace("/<(".implode("|", $block_tags).")\s*([^>]*)>/i", '', $text);
		}
		if( count($single_tags) > 0 ){
			$text = preg_replace("/<(".implode("|", $single_tags).")(\s*)([^>]*)>/i", $SQ.'\\1\\2\\3'.$EQ, $text);
		}
 		while( preg_match("/<([a-z]*)\s*([^>]*)>/i", $text, $matches) ){
			$fullTag = $matches[0];
			$tag = $matches[1];
			$close = "</{$matches[1]}>";
			$attr = $matches[2];
			if( $tag == '' || !preg_match("#{$close}#", $text) ){
				$i = strpos($text, $fullTag);
				$text = substr( $text, 0, $i ).substr( $text, ($i + strlen($fullTag)) );
			}
			else{
				$i = strpos($text, $fullTag);
				$i2 = ($i + strlen($fullTag));
				$text1 = substr( $text, 0, $i ).( !empty($attr) ? "{$SQ}{$tag} {$attr}{$EQ}" : "{$SQ}{$tag}{$EQ}" );
				$textB = substr( $text, $i2 );
				$s = strpos( $textB, $close );
				$s2 = ($s + strlen($close));
				$text2 = substr( $textB, 0, $s )."{$SQ}/{$tag}{$EQ}";
				$text3 = substr( $textB, $s2 );
				$text = "{$text1}{$text2}{$text3}";
			}
		}
		$text = str_replace($SQ, "<", $text);
		$text = str_replace($EQ, ">", $text);
		return $text;
	}
	function nohtml( $text ){
        $text = preg_replace('/<[[:space:]]*([^>]*)[[:space:]]*>/i', '<\\1>', $text);
        $text = preg_replace('/<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>/i', '', $text);
        $text = preg_replace('/<a[^>]*href[[:space:]]*=[[:space:]]*"?javascript[[:punct:]]*"?[^>]*>/i', '', $text);
        $temp = "";
        while( preg_match('/<(\/?[[:alpha:]]*)[[:space:]]*([^>]*)>/', $text, $matches) ){
			$i = strpos($text, $matches[0]);
			$l = strlen($matches[0]);
			$temp .= substr( $text, 0, $i );
			$text = substr( $text, ($i + $l) );
        }
        $text = $temp.$text;
        return trim($text);
	}
	function clean_array_blank( $data, $type = 'all' ){
		if( is_array($data) ){
			foreach( $data as $key => $sub_data ){
				if( ( $type == 'all' || $type == 'key' ) && gettype($key) == 'string' ){
					$key = trim($key);
					if( $key == '' ){
						$data = array_diff_key( $data, ['' => true] );
						continue;
					}
				}
				if( is_array($sub_data) ){
					$data["{$key}"] = $this->clean_array_blank( $sub_data, $type );
				}
				else{
					if( ( $type == 'all' || $type == 'val' ) && gettype($sub_data) == 'string' ){
						$sub_data = trim($sub_data);
						if( $sub_data == '' ){
							unset( $data["{$key}"] );
							continue;
						}
					}
				}
			}
		}
		return $data;
	}
	function serialize( $array ){
		if( !is_array($array) ){
			$array = [];
		}
		$string = serialize($array);
		return $string;
	}
	function unserialize( $string ){
		$string = trim($string);
		if( !empty($string) ){
			$array = unserialize($string);
			if( is_array($array) ){
				return $array;
			}
		}
		return [];
    }
    
    /**
     * Replacing some words with another one
     */
    function clean_letters( $text ){
		$text = preg_replace('/(fuck)/i', '****', $text);
		return $text;
    }
    
	function html_encode( $string, $except = [] ){
		$string = stripslashes($string);
		
		if( !is_array($except) ){
			$except = [];
		}

		if( !in_array( '&', $except ) ){
			$string = str_replace('&', "&amp;", $string);
		}
		if( !in_array( '"', $except ) ){
			$string = str_replace('"', "&quot;", $string);
		}
		if( !in_array( "'", $except ) ){
			$string = str_replace("'", "&#39;", $string);
		}
		if( !in_array( "<", $except ) ){
			$string = str_replace("<", "&lt;", $string);
		}
		if( !in_array( ">", $except ) ){
			$string = str_replace(">", "&gt;", $string);
		}
		return $string;
	}
	function html_decode( $string, $except = [] ){
		$string = stripslashes($string);
		
		if( !is_array($except) ){
			$except = [];
		}
		
		if( !in_array( '&', $except ) ){
			$string = str_replace("&amp;", "&", $string);
		}
		if( !in_array( '"', $except ) ){
			$string = str_replace("&quot;", '"', $string);
		}
		if( !in_array( "'", $except ) ){
			$string = str_replace("&#39;", "'", $string);
		}
		if( !in_array( "<", $except ) ){
			$string = str_replace("&lt;", "<", $string);
		}
		if( !in_array( ">", $except ) ){
			$string = str_replace("&gt;", ">", $string);
		}
		return $string;
	}
	function clean_mysql( $string ){
		$string = $this->html_encode($string);
		$string = $this->pdo->real_escape_string($string);
		return $string;
	}
    
    /**
     * removing everything except pattern.
     */
	function preg_except( $regexp, $text ){
		preg_match_all( $regexp, $text, $matches);
		$text = trim( iconv( 'utf-8', 'utf-8//IGNORE', implode("", $matches[0]) ) );
		return $text;
    }
    
	/**
	 * Converting english numbers to arabic numbers
	 */
	public function numbers_latin_to_arabic( $text, $pdf = false ){
		$numbers = array(
			'0' => '٠',
			'1' => '١',
			'2' => '٢',
			'3' => '٣',
			'4' => '٤',
			'5' => '٥',
			'6' => '٦',
			'7' => '٧',
			'8' => '٨',
			'9' => '٩',
			'.' => ',',
			'%' => '٪'
		);

		$text = "{$text}";
		
		if( $pdf === true && strlen($text) == 1 ){
			$text = "{$text}&nbsp;";
		}
		
		foreach( $numbers as $arabic => $hindi ){
			$text = str_replace( $arabic, $hindi, $text );
		}
	
		return $text;
    }
    
	/**
	 * Converting arabic numbers to english numbers
	 */
	public function numbers_arabic_to_latin( $text ){
		$numbers = array(
			'٠' => '0' ,
			'١' => '1' ,
			'٢' => '2' ,
			'٣' => '3' ,
			'٤' => '4' ,
			'٥' => '5' ,
			'٦' => '6' ,
			'٧' => '7' ,
			'٨' => '8' ,
			'٩' => '9' ,
			',' => '.' ,
			'٪' => '%' 
		);
		
		$text = "{$text}";
		foreach( $numbers as $arabic => $latin ){
			$text = str_replace( $arabic, $latin, $text );
		}
	
		return $text;
	}
}

?>
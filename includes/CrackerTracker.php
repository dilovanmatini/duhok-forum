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

  $file_p = "bets.txt";
  $duhok_track = $_SERVER['QUERY_STRING'];
  $ct_rules = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
 			       'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
                   'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
                   'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
                   'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
                   'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
                   'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
                   'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
                   'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
                   'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
                   '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20',
                   'new_password', '/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
                   'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
                   '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
                   'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
                   '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
                   'file\://', 'window.open', '<SCRIPT>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
                   'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
                   'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', '.history',
                   'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
                   'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
                   '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
                   'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', '<?php', '?>', 'sql=',
                   '_global', 'global_', 'global[', '_server', 'server_', 'server[', 'phpadmin',
                   'root_path', '_globals', 'globals_', 'globals[', 'ISO-8859-1', 'http://www.google.de/search', '?hl=',
                   '.txt', '.exe', 'union','google.de/search', 'yahoo.de', 'lycos.de', 'fireball.de', 'ISO-'
                   );

// , 'admin_', '&icq', 'php_', 'phpinfo()'

  $duhok_track = strtolower($duhok_track);
  $checkworm = str_replace($ct_rules, '*', $duhok_track);

  if($duhok_track != $checkworm)
  {

if(getenv(HTTP_X_FORWARDED_FOR)){ 
  $ip=getenv(HTTP_X_FORWARDED_FOR); 
} 
elseif(getenv(HTTP_CLIENT_IP)){ 
 $ip=getenv(HTTP_CLIENT_IP); 
} 
else { 
 $ip=getenv(REMOTE_ADDR); 
}

$cur_place = $_SERVER['PHP_SELF']; 

$curplace = $_SERVER['REQUEST_URI'];

$temp = @$_SERVER['argv']; 
$temp = @array_pop($temp); 
if($temp != ''){ 
    $cur_place .= '?' . $temp; 
} 
unset($temp); 
$datetime = date("d/m/y,g:i");
$fp = fopen($file_p, "a");
chmod($file_p, 0777);
fwrite($fp, $somecontent);
fclose($fp);

$filename = $file_p;
$somecontent = "$curplace || $ip || $datetime "."\r\n";

if(is_writable($filename)){

   if(!$handle = fopen($filename, 'a')){
         echo "لم يتم فتح الملف ($filename)";
         exit;
   }

   if(fwrite($handle, $somecontent) === FALSE){
       echo "لا يمكن الكتابة على الملف ($filename)";
       exit;
   }
   
   fclose($handle);

} else {
   echo "الملف $filename لا يمكن قرائته";
}

$link_error = $duhok_track;
$link_error = htmlspecialchars($link_error);

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar">
<head>
<title>عملية غير مصرح بها</title>
<META http-equiv=Content-Type content="text/html;charset=windows-1256">
<META NAME="robots" CONTENT="noindex,nofollow">
<style type="text/css">
body{
margin:0px; padding:0px; background-color:#CCCCCC;text-align:center;font-size:17px; font-family:Tahoma;color:white
}
#the_div {
margin:80px 80px 80px 80px;
padding-top:130px;
border : solid;
background-color:#333333;
width:820px;
height:250px;
}
</style>
</head>
<body>
<div id="the_div">: الرابط الدي اتبعثه غير صحيح <br /><br /><span style="color:red"> '.$link_error.' </span> <br /><br /><br /> قال الله تعالى : <font color="#0099CC">((مايلفظ من قول إلا لديه رقيب 
عتيد ))</font> صدق الله العظيم. </div></body></html>';


unset($duhok_track,$ct_rules,$checkworm);
exit;
}
?>
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

const _df_script = "admin_login";
const _df_filename = "admin_login.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv != 4){
	$DF->quick();
	exit();
}
if(cplogin){
	$DF->quick(src != '' ? src : 'admincp.php');
}

$Template->adminHeader();

echo"<br>";
if( !cplogin && type == 'adminlogin' ){
	$Template->msgBox('الكلمة السرية التي دخلت غير صحيح', 'red', 20, 0, true, false);
}

$text="
<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" border=\"0\" align=\"center\" border=\"0\">
<form method=\"post\" action=\"admin_login.php?type=adminlogin&src=".urlencode(src)."\">
	<tr>
		<td>الأسم</td>
		<td align=\"center\" rowspan=\"5\" style=\"padding-left:40px;padding-right:50px\"><img src=\"images/admin/login.jpg\" border=\"0\"></td>
	</tr>
	<tr>
		<td>{$Template->input(300,array('name'=>'login_cp_name','value'=>$DF->getCookie('login_cp_name')),true)}</td>
	</tr>
	<tr>
		<td>الكلمة السرية</td>
	</tr>
	<tr>
		<td>{$Template->input(300,array('type'=>'password','name'=>'login_cp_pass'),true)}</td>
	</tr>
	<tr>
		<td><input type=\"submit\" class=\"button\" value=\"دخول\"></td>
	</tr>
</form>
</table>";
$Template->adminBox("دخول لوحة التحكم", $text, 0, 12, true);

$Template->adminFooter();
?>
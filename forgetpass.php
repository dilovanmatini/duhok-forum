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

const _df_script = "forgetpass";
const _df_filename = "forgetpass.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();
if(type==""){
	$Template->errMsg("<font color=\"black\">الصفحة تحت الصيانة<br>قريباً سنفتح لكم</font>");
}
else{
	$DF->goTo();
}
$Template->footer();
?>
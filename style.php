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

const _df_script = "style";
const _df_filename = "style.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if( ulv > 0 ){
	$s=unserialize($mysql->get("userflag","style",uid));
	if(is_array($s)){
		$content="body{font-weight:{$s['weight']};text-align:{$s['align']};font-family:{$s['family']};font-size:{$s['size']};color:{$s['color']}}";
		header("Content-length: ".strlen($content)."");
		header("Content-type: text/css");
		echo $content;
	}
}
?>
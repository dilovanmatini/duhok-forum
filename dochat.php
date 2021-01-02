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

const _df_script = "dochat";
const _df_filename = "dochat.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv < 2 && (udochat == 0 or ulv == 0)){
	header("location: errorpages.php?e=404");
	exit();
}
define('ac', '[>:DT:<]');
if(type == ''){
	$Template->header();
	$mysql->delete("chat WHERE date < ".(time - (60 * 60 * 3))."", __FILE__, __LINE__);
	echo"<br>
	<script type=\"text/javascript\" src=\"js/chat.js".x."\"></script>
	<input type=\"hidden\" id=\"chatStartTime\" value=\"".time."\">
	<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
		<tr>
			<td class=\"asHeader\">نقاش حي</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table width=\"100%\" cellSpacing=\"4\" cellPadding=\"4\">
				<tr>
					<td class=\"asText\" valign=\"top\" id=\"usersPanel\" rowspan=\"2\" style=\"width:150px;height:400px\">&nbsp;</td>
					<td class=\"asText\" valign=\"top\" style=\"height:300px\">
					<div class=\"chatMessages\" id=\"messagesPanel\" onscroll=\"DF.chatCheckScroll(this);\">
					<table cellspacing=\"2\" cellpadding=\"0\" width=\"100%\"><tbody></tbody></table>
					</div>
					</td>
				</tr>
				<tr>
					<td class=\"asText\" style=\"height:75px\">
					<table width=\"100%\" cellSpacing=\"2\" cellPadding=\"2\">
						<tr>
							<td colspan=\"2\">
							<select class=\"asGoTo\" style=\"width:110px\" id=\"chatFontName\" onchange=\"DF.chatSetStyle('Name');\">
								<option value=\"tahoma\">Tahoma</option>
								<option value=\"arial\" selected>Arial</option>
								<option value=\"arial black\">Arial black</option>‌
								<option value=\"comic sans ms\">Comic Sans MS</option>
								<option value=\"courier new\">Courier New</option>
								<option value=\"diwani letter\">Diwani</option>
								<option value=\"monotype kufi\">Kufi</option>
								<option value=\"andalus\">Andalus</option>
							</select>
							<select class=\"asGoTo\" style=\"width:40px\" id=\"chatFontSize\" onchange=\"DF.chatSetStyle('Size');\">
								<option value=\"10\">10</option>
								<option value=\"11\">11</option>‌
								<option value=\"12\">12</option>
								<option value=\"13\">13</option>
								<option value=\"14\">14</option>
								<option value=\"15\" selected>15</option>
								<option value=\"16\">16</option>
								<option value=\"17\">17</option>
								<option value=\"18\">18</option>
								<option value=\"19\">19</option>
								<option value=\"20\">20</option>
							</select>
							<select class=\"asGoTo\" style=\"width:70px\" id=\"chatFontColor\" onchange=\"DF.chatSetStyle('Color');\">
								<option value=\"#000000\" style=\"background:#000000;\" selected>&nbsp;</option>
								<option value=\"#FF0066\" style=\"background:#FF0066;\">&nbsp;</option>
								<option value=\"#0000FF\" style=\"background:#0000FF;\">&nbsp;</option>
								<option value=\"#CCCC00\" style=\"background:#CCCC00;\">&nbsp;</option>
								<option value=\"#FF00FF\" style=\"background:#FF00FF;\">&nbsp;</option>
								<option value=\"#008000\" style=\"background:#008000;\">&nbsp;</option>
								<option value=\"#000080\" style=\"background:#000080;\">&nbsp;</option>
								<option value=\"#800080\" style=\"background:#800080;\">&nbsp;</option>
								<option value=\"#808080\" style=\"background:#808080;\">&nbsp;</option>
								<option value=\"#008080\" style=\"background:#008080;\">&nbsp;</option>
								<option value=\"#CC0000\" style=\"background:#CC0000;\">&nbsp;</option>
								<option value=\"#996600\" style=\"background:#996600;\">&nbsp;</option>
							</select>
							</td>
						</tr>
					</table>
					<table width=\"100%\" cellSpacing=\"2\" cellPadding=\"2\">
						<tr>
							<td width=\"20%\"><textarea style=\"width:530px;height:70px;font-weight:bold;font-family:arial;font-size:15px;color:#000000\" id=\"messageBox\" onkeypress=\"if(event.keyCode==13){DF.chatSendMsg();return false}\"></textarea></td>
							<td>
							<table>";
							$smiles=array(array('icon','cool','big'),array('angry','blackeye','dissapprove'),array('crying','eyebrows','hearteyes'));
							foreach($smiles as $smile){
								echo"
								<tr>";
								foreach($smile as $s){
									echo"
									<td><img src=\"images/smiles/{$s}.gif\" class=\"hand\" onclick=\"DF.chatInsertSmile('{$s}');\" border=\"0\"></td>";
								}
								echo"
								</tr>";
							}	
							echo"
							</table>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class=\"asBody\">
			<table cellSpacing=\"2\" cellPadding=\"3\">
				<tr>
					<td class=\"asTitle\">ملاحظة</td>
					<td class=\"asText2\">هذه الخدمة متوفرة فقط للمدراء والمراقبين والمشرفين</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>";
	?>
	<script type="text/javascript">
	var userName = '<?=$Template->userColorLink(uid, array(uname, 1, ulv, submonitor), false, '', true)?>';
	$(function(){
		DF.chatSendMsg("@arrow_up@ دخل في نقاش حي", 'font-family:arial;font-size:15;color:green;');
		DF.chatActivity(0);
		DF.chatOnlineUsers();
	});
	$(window).unload(function() {
		DF.chatSendMsg('@arrow_down@ ترك نقاش حي', 'font-family:arial;font-size:15;color:red;');
	});
	//$(window).bind('beforeunload', function(){
	//	return 'You are sure to leave chat ?';
	//});
	</script>
	<?php
	$Template->footer();
}
elseif(type == 'ajax'){
	if(method == 'chatActivity'){
		$time = intval($_POST['time']);
		$limit = intval($_POST['limit']);
		$sql = $mysql->query("SELECT ch.date, ch.message, u.id, u.name, u.status, u.level, u.submonitor
		FROM ".prefix."chat AS ch
		LEFT JOIN ".prefix."user AS u ON(u.id = ch.userid)
		WHERE ch.date > {$time} GROUP BY ch.id ORDER BY ch.date ASC LIMIT {$limit}, 1000", __FILE__, __LINE__);
		echo ac;
		while($rs = $mysql->fetchRow($sql)){
			$uname = $rs[3];
			$message = $rs[1];
			$uname = $Template->userColorLink($rs[2], array($uname, $rs[4], $rs[5], $rs[6]), true, '', true);
			echo "{$uname}[>:c:<]{$DF->date($rs[0], 'time', false, false, true)}[>:c:<]{$message}[>:r:<]";
			$limit++;
		}
		echo ac;
	}
	elseif(method == 'chatGetOnlineUsers'){
		echo ac;
		$sql = $mysql->query("SELECT u.id, u.name, u.status, u.level, u.submonitor
		FROM ".prefix."useronline AS uo
		LEFT JOIN ".prefix."user AS u ON(u.id = uo.userid)
		WHERE uo.url LIKE '%dochat.php%' AND u.level <= ".ulv." GROUP BY uo.ip ORDER BY u.level DESC, uo.userid ASC", __FILE__, __LINE__);
		$users = array();
		while($rs = $mysql->fetchRow($sql)){
			$uname = $rs[1];
			$uname = $Template->userColorLink($rs[0], array($uname, $rs[2], $rs[3], $rs[4]), false, '', true);
			$users[] = $uname;
		}
		echo implode("{AS}", $users);
		echo ac;
	}
	elseif(method == 'chatSendMsg'){
		$style = $DF->cleanText($_POST['style']);
		$message = $DF->cleanText($_POST['message']);
		$message = preg_replace("/\{:([a-z]*):\}/", '<img src="images/smiles/$1.gif" border="0">', $message);
		$message = str_replace("@arrow_up@", '<img src="images/icons/arrow_up.gif" border="0">', $message);
		$message = str_replace("@arrow_down@", '<img src="images/icons/arrow_down.gif" border="0">', $message);
		$message = "<div style=\"{$style}\">{$message}</div>";
		$mysql->insert("chat (userid, message, date) VALUES (".uid.", '{$message}', ".time.")", __FILE__, __LINE__);
		echo ac."yes".ac;
	}
	$Template->footer(false);
}
else{
	echo '0'.ac;
	$Template->footer(false);
}
?>
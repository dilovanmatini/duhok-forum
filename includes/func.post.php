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

function modOptions($num){
	global $isModerator,$isMonitor,$Template;
	if($isModerator){
					// <td>{$Template->button("إختيار كامل"," onClick=\"DF.selectPosts(true)\"",true," asS12")}</td>
				// <td>{$Template->button("مسح الإختيار"," onClick=\"DF.selectPosts(false)\"",true," asS12")}</td>
		echo"
		<td>
		<table border=\"0\">
			<tr>
				<form id=\"frmBar$num\">
				<td>
				<select name=\"selOptions\" class=\"asGoTo asS12\" style=\"width:140px\" onChange=\"DF.checkChoose(this,$num)\">
					<option value=\"\">&nbsp;&nbsp;-- خيارات الردود --</option>
					<option value=\"mo\">موافقة على ردود المختارة</option>
					<option value=\"ho\">تجميد ردود المختارة</option>
					<option value=\"hd\">إخفاء ردود المختارة</option>
					<option value=\"vs\">إظهار ردود المختارة</option>";
				if($isMonitor){
					echo"
					<option value=\"dl\">حذف ردود المختارة</option>
					<option value=\"re\">إرجاع ردود المختارة</option>";
				}
				echo"
				</select>
				</td>
				<td>{$Template->button("تطـبيق"," onClick=\"DF.checkClick()\" name=\"accept\"")}</td>
				<td><input type=\"checkbox\" id=\"checkbox$num\" onclick=\"DF.selectPosts(this)\"></td>
				</form>
			</tr>
		</table>
		</td>";
	}
}
function postNumPageMenu(){
	global $DF;
	$text="
	<form method=\"post\" action=\"".self."\">
	<td class=\"asText asCenter asTop\"><nobr>حجم الصفحة:</nobr>
	<select class=\"asGoTo asS12\" style=\"width:65px\" name=\"postNumPage\" onChange=\"this.form.submit();\">
		<option value=\"10\" {$DF->choose(post_num_page,10,'s')}>10 ردود</option>
		<option value=\"30\" {$DF->choose(post_num_page,30,'s')}>30 رد</option>
		<option value=\"50\" {$DF->choose(post_num_page,50,'s')}>50 رد</option>
		<option value=\"70\" {$DF->choose(post_num_page,70,'s')}>70 رد</option>
	</select>
	</td>
	</form>";
	return $text;
}
function userTotalDays($date){
	$date=time-$date;
	$date=$date/84600;
	$date=ceil($date);
	return $date;
}
function userMiddlePosts($posts,$date){
	$date=userTotalDays($date);
	$posts=$posts/$date;
	$posts=round($posts,2);
	return $posts;
}
function userAllTitles($uid, $ulv, $posts, $title, $sex, $oldlevel, $submonitor){
	global $mysql, $DF;
	if(isset($DF->catch['userAllTitles'][$uid])){
		return $DF->catch['userAllTitles'][$uid];
	}
	$all_titles = array();
	$f = intval($DF->catch['thisForum']);
	if($f < 1){
		return;
	}
	
	if($ulv > 1 or $oldlevel > 1){
		$all_titles[] = $DF->userTitle($uid, $posts, $ulv, $title, $sex, $oldlevel, $submonitor);
	}

	if($ulv < 4){
		$sql = $mysql->query("SELECT tl.subject, tl.global
		FROM ".prefix."title AS t
		LEFT JOIN ".prefix."titlelists AS tl ON(tl.id = t.listid)
		WHERE t.userid = {$uid} AND t.status = 1 AND (tl.global = 1 OR tl.forumid = {$f}) GROUP BY t.id ORDER BY t.id ASC", __FILE__, __LINE__);
		while($rs = $mysql->fetchRow($sql)){
			$all_titles[] = ($rs[1] == 1) ? "<font color=\"blue\">{$rs[0]}</font>" : $rs[0];
		}
	}
	
	$all_titles = implode("<br>", $all_titles);
	$DF->catch['userAllTitles'][$uid] = $all_titles;
	return $all_titles;
}

?>
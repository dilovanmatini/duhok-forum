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
	global $is_moderator,$is_monitor,$Template;
	if($is_moderator){
					//<td>{$Template->button("إختيار كامل"," onClick=\"DF.selectPosts(true)\"",true," asS12")}</td>
			//	<td>{$Template->button("مسح الإختيار"," onClick=\"DF.selectPosts(false)\"",true," asS12")}</td>
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
				if($is_monitor){
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
function signatureMenu(){
	global $DF;
	$text="
	<form method=\"post\" action=\"".self."\">
	<td class=\"asText asCenter asTop\"><nobr>التواقيع:</nobr>
	<select class=\"asGoTo asS12\" style=\"width:57px\" name=\"topicsSignature\" onChange=\"this.form.submit();\">
		<option value=\"hidden\" {$DF->choose(topics_signature,'hidden','s')}>مخفيّة</option>
		<option value=\"visible\" {$DF->choose(topics_signature,'visible','s')}>ظاهرة</option>
	</select>
	</td>
	</form>";
	return $text;
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
function topicFolder($trash,$moderate,$status){
	global $DFImage;
	if($trash==1){
		$imgSrc=$DFImage->f['delete'];
		$imgAlt="موضوع محذوف";
	}
	elseif($moderate==1){
		$imgSrc=$DFImage->f['moderate'];
		$imgAlt="موضوع تنتظر الموافقة";
	}
	elseif($moderate==2){
		$imgSrc=$DFImage->f['held'];
		$imgAlt="موضوع مجمد";
	}
	elseif($status==0){
		$imgSrc=$DFImage->f['lock'];
		$imgAlt="موضوع مقفل";
	}
	else {
		$imgSrc=$DFImage->f['folder'];
		$imgAlt="موضوع مفتوح";
	}
	$image="<img src=\"$imgSrc\" alt=\"$imgAlt\" hspace=\"4\" border=\"0\">";
	return $image;
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
	$f = intval($DF->catch['_this_forum']);
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
	
	if($ulv == 1 && count($all_titles) == 0){
		$all_titles[] = $DF->userTitle($uid, $posts, $ulv, $title, $sex, $oldlevel, $submonitor);
	}
	
	$all_titles = implode("<br>", $all_titles);
	$DF->catch['userAllTitles'][$uid] = $all_titles;
	return $all_titles;
}
if(vote>0){
	function checkUserVote($days,$posts){
		$udays=userTotalDays(udate);
		$canVote=($udays>=$survey['days']&&uposts>=$survey['posts'] ? 1 : 0);
		return $canVote;
	}
	$oid=vote;
	$rs=$mysql->queryAssoc("SELECT s.id,s.status,s.days,s.posts,IF(NOT ISNULL(svfind.id),1,0) AS findvote,
		IF(NOT ISNULL(svold.id),svold.optionid,0) AS oldvote,COUNT(sv.id) AS count
	FROM ".prefix."surveyoptions AS so
	LEFT JOIN ".prefix."survey AS s ON(s.id = so.surveyid)
	LEFT JOIN ".prefix."surveyvotes AS sv ON(sv.optionid = so.id)
	LEFT JOIN ".prefix."surveyvotes AS svfind ON(svfind.optionid = so.id AND svfind.userid = ".uid.")
	LEFT JOIN ".prefix."surveyvotes AS svold ON(svold.surveyid = so.surveyid AND svold.userid = ".uid.")
	WHERE so.id = $oid GROUP BY s.id", __FILE__, __LINE__);
	
	if($rs['findvote']==0&&$rs['status']==1&&ulv>0&&checkUserVote($rs['days'],$rs['posts'])==1){
		if($rs['oldvote']>0){
			$mysql->delete("surveyvotes WHERE optionid = '{$rs['oldvote']}' AND userid = ".uid." AND surveyid = {$rs['id']}", __FILE__, __LINE__);
			$mysql->update("surveyoptions SET votes = votes - 1 WHERE id = '{$rs['oldvote']}'", __FILE__, __LINE__);
		}
		else $DFOutput->setUserActivity('vote',$DF->catch['_this_forum'],(int)$mysql->get("topic","author",t));
		$mysql->insert("surveyvotes (surveyid,optionid,topicid,userid,date) VALUES ('{$rs['id']}','$oid','".t."','".uid."','".time."')", __FILE__, __LINE__);
		$mysql->update("surveyoptions SET votes = '".($rs['count']+1)."' WHERE id = '$oid'", __FILE__, __LINE__);
		$DF->quick("topics.php?t=".t);
	}
}
?>
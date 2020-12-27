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

require_once("./include/forum_func.df.php");

function new_mods_mail($f){
	global $Prefix;
	$f = abs2($f);
	$new_pm = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$f' AND PM_OUT = '0' AND PM_READ = '0' AND PM_STATUS = '1' ", [], __FILE__, __LINE__);
	$count = mysql_result($new_pm, 0, "count(*)");
	if($count > 0){
		$forum_pm = $count;
	}
	else {
		$forum_pm = "0";
	}
return($forum_pm);
}

function first_moderator_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '".m_id."' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$f = mysql_result($sql, $x, "FORUM_ID");
		$subject = forums("SUBJECT", $f);
		$mail = new_mods_mail($f);
        $nofity = nofity_wait($f, "wait");
        $nofity_admin = nofity_wait($f, "admin");
		$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
		if($mail > 0 or $nofity > 0 or $nofity_admin > 0){ $tr_class = "normal"; }
		else { $tr_class = "deleted"; }
		echo'
		<tr class="'.$tr_class.'">
			<td class="list_small">'.$href.'</td>
			<td class="list_center"><a href="index.php?mode=pm&mail=in&m='.abs2($f).'">'.$mail.'</a></td>
            <td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'">'.$nofity.'</a></td>
				<td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'&method=admin">'.$nofity_admin.'</a></td>
		</tr>';
		++$x;
		}
}

function first_monitor_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_MONITOR = '".m_id."' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$c = mysql_result($sql, $x, "CAT_ID");
		$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$c' ", [], __FILE__, __LINE__);
		$rows = mysql_num_rows($forums);
			$i = 0;
			while ($i < $rows){
			$f = mysql_result($forums, $i, "FORUM_ID");
			$subject = forums("SUBJECT", $f);
			$mail = new_mods_mail($f);
            $nofity = nofity_wait($f, "wait");
            $nofity_admin = nofity_wait($f, "admin");
			$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
			if($mail > 0 or $nofity > 0 or $nofity_admin > 0){ $tr_class = "normal"; }
			else { $tr_class = "deleted"; }
			echo'
			<tr class="'.$tr_class.'">
				<td class="list_small">'.$href.'</td>
				<td class="list_center"><a href="index.php?mode=pm&mail=in&m='.abs2($f).'">'.$mail.'</a></td>
				<td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'">'.$nofity.'</a></td>
				<td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'&method=admin">'.$nofity_admin.'</a></td>
			</tr>';
			++$i;
			}
		++$x;
		}
}

function first_administrator_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$f = mysql_result($sql, $x, "FORUM_ID");
		$subject = forums("SUBJECT", $f);
		$mail = new_mods_mail($f);
        $nofity = nofity_wait($f, "wait");
        $nofity_admin = nofity_wait($f, "admin");
		$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
		if($mail > 0 or $nofity > 0 or $nofity_admin > 0){ $tr_class = "normal"; }
		else { $tr_class = "deleted"; }
		echo'
		<tr class="'.$tr_class.'">
			<td class="list_small">'.$href.'</td>
			<td class="list_center"><a href="index.php?mode=pm&mail=in&m='.abs2($f).'">'.$mail.'</a></td>
            <td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'">'.$nofity.'</a></td>
				<td class="list_center"><a href="index.php?mode=notifylist&f='.$f.'&method=admin">'.$nofity_admin.'</a></td>
		</tr>';
		++$x;
		}
}

function second_moderator_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}MODERATOR WHERE MEMBER_ID = '".m_id."' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$f = mysql_result($sql, $x, "FORUM_ID");
		$subject = forums("SUBJECT", $f);
		$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
		$utopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tunmoderated&pg=1">'.unmoderated_topics($f).'</a>';
		$htopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tholded&pg=1">'.holded_topics($f).'</a>';
		$ureplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=runmoderated&pg=1">'.unmoderated_replies($f).'</a>';
		$hreplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=rholded&pg=1">'.holded_replies($f).'</a>';
		if(unmoderated_topics($f) > 0 || holded_topics($f) > 0 || unmoderated_replies($f) > 0 || holded_replies($f) > 0){
		    $tr_class = "normal";
		}
		else {
		    $tr_class = "deleted";
		}
		echo'
		<tr class="'.$tr_class.'">
			<td class="list_small">'.$href.'</td>
			<td class="list_center">'.$utopics.'</td>
			<td class="list_center">'.$htopics.'</td>
			<td class="list_center">'.$ureplies.'</td>
			<td class="list_center">'.$hreplies.'</td>
		</tr>';
		++$x;
		}
}

function second_monitor_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY WHERE CAT_MONITOR = '".m_id."' ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$c = mysql_result($sql, $x, "CAT_ID");
		$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$c' ", [], __FILE__, __LINE__);
		$rows = mysql_num_rows($forums);
			$i = 0;
			while ($i < $rows){
			$f = mysql_result($forums, $i, "FORUM_ID");
			$subject = forums("SUBJECT", $f);
			$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
			$utopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tunmoderated&pg=1">'.unmoderated_topics($f).'</a>';
			$htopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tholded&pg=1">'.holded_topics($f).'</a>';
			$ureplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=runmoderated&pg=1">'.unmoderated_replies($f).'</a>';
			$hreplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=rholded&pg=1">'.holded_replies($f).'</a>';
			if(unmoderated_topics($f) > 0 || holded_topics($f) > 0 || unmoderated_replies($f) > 0 || holded_replies($f) > 0){
			    $tr_class = "normal";
			}
			else {
			    $tr_class = "deleted";
			}
			echo'
			<tr class="'.$tr_class.'">
				<td class="list_small">'.$href.'</td>
				<td class="list_center">'.$utopics.'</td>
				<td class="list_center">'.$htopics.'</td>
				<td class="list_center">'.$ureplies.'</td>
				<td class="list_center">'.$hreplies.'</td>
			</tr>';
			++$i;
			}
		++$x;
		}
}

function second_administrator_info(){
	$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM ", [], __FILE__, __LINE__);
	$num = mysql_num_rows($sql);
		$x = 0;
		while ($x < $num){
		$f = mysql_result($sql, $x, "FORUM_ID");
		$subject = forums("SUBJECT", $f);
		$href = '<a href="index.php?mode=f&f='.$f.'">'.$subject.'</a>';
		$utopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tunmoderated&pg=1">'.unmoderated_topics($f).'</a>';
		$htopics = '<a href="index.php?mode=f&f='.$f.'&mod_option=tholded&pg=1">'.holded_topics($f).'</a>';
		$ureplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=runmoderated&pg=1">'.unmoderated_replies($f).'</a>';
		$hreplies = '<a href="index.php?mode=f&f='.$f.'&mod_option=rholded&pg=1">'.holded_replies($f).'</a>';
		if(unmoderated_topics($f) > 0 || holded_topics($f) > 0 || unmoderated_replies($f) > 0 || holded_replies($f) > 0){
		    $tr_class = "normal";
		}
		else {
		    $tr_class = "deleted";
		}
		echo'
		<tr class="'.$tr_class.'">
			<td class="list_small">'.$href.'</td>
			<td class="list_center">'.$utopics.'</td>
			<td class="list_center">'.$htopics.'</td>
			<td class="list_center">'.$ureplies.'</td>
			<td class="list_center">'.$hreplies.'</td>
		</tr>';
		++$x;
		}
}

function your_forums_info(){
	if(mlv == 2){
		$txt = "ملخص المنتديات التي تشرف عليها";
	}
	if(mlv == 3){
		$txt = "ملخص المنتديات التي تراقبها";
	}
	if(mlv == 4){
		$txt = "ملخص جميع المنتديات";
	}
	echo'
	<center>
	<table cellSpacing="1" cellPadding="2" width="99%" border="0">
		<tr>
			<td class="optionsbar_menus" width="100%">&nbsp;<nobr><font color="red" size="+1">'.$txt.'</font></nobr></td>';
			refresh_time();
			go_to_forum();
		echo'
		</tr>
	</table>
	<br>
	<table class="grid" cellSpacing="1" cellPadding="2" width="60%" border="0">
		<tr>
			<td class="cat">المنتدى</td>
			<td class="cat">رسائل إشرافية جديدة</td>
			<td class="cat">شكاوي تنتظر المراجعة</td>
			<td class="cat">شكاوي تم ترحيلها للمدير</td>
		</tr>';
	if(mlv == 2){
			first_moderator_info();
	}
	if(mlv == 3){
			first_monitor_info();
	}
	if(mlv == 4){
			first_administrator_info();
	}
	echo'
	</table>
	<br>
	<table class="grid" cellSpacing="1" cellPadding="2" width="60%" border="0">
		<tr>
			<td class="cat">المنتدى</td>
			<td class="cat">مواضيع تنتظر الموافقة</td>
			<td class="cat">مواضيع مجمدة</td>
			<td class="cat">ردود تنتظر الموافقة</td>
			<td class="cat">ردود مجمدة</td>
		</tr>';
	if(mlv == 2){
			second_moderator_info();
	}
	if(mlv == 3){
			second_monitor_info();
	}
	if(mlv == 4){
			second_administrator_info();
	}
	echo'
	</table>
	<br>
	<table cellSpacing="1" cellPadding="2" border="0">
		<tr>
			<td align="center">المنتديات التي تظهر باللون التالي</td>
			<td align="center"><table border="1"><tr class="normal"><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
			<td align="center">تحتوي على مواضيع تنتظر الموافقة</td>
		</tr>
		<tr>
			<td align="center" colSpan="6"><br><font color="red">للذهاب مباشرة إلى صفحة المواضيع التي تنتظر الموافقة أو المجمدة في أي منتدى.<br>إضغط على رقم المواضيع من الجدول أعلاه.</font></td>
		</tr>
	</table>
	</center>';
}

if(mlv > 1){
	your_forums_info();
}

?>
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


if($Mlevel > 0){
if($m == 0 or $m == $DBMemberID){
if(members("P_POSTS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][your_posts].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

$m = $DBMemberID;
$text5 = "";
$text = "المواضيع التي شاركت فيها مؤخرا";
$text2 = "لا توجد أية مشاركات لك في المنتدى المختار أعلاه.";
$text6 = "تحتوي على مشاركات جديدة بعد آخر مشاركة لك فيها. ";
} else {
if(members("P_POSTS_MEMBERS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][posts_members].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
$name = members("NAME", $m);
$text5 = $name;
$text = "المواضيع التي شارك فيها مؤخرا:";
$text2 = "لا توجد أية مشاركات لهذا العضو في المنتدى المختار أعلاه.";
$text6 = "تحتوي على مشاركات جديدة بعد آخر مشاركة للعضو فيها. ";

}
$f_n = $_POST[f_n];
echo '<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td width="100%"><font size="4" color="red"><b>'.$text.'</b></font>
				<font size="4" color="black"><b>'.$text5.'</b></font></td>';
				echo'
					<form method="post" action="'.$_SERVER[REQUEST_URI].'">
					<td class="optionsbar_menus"><nobr>عرض المشاركات من:</nobr><br>
						<select size="1" name="f_n" onchange="submit();">
						<option value="0" '.check_select($f_n,0).'>-- جميع المنتديات --</option>';
$cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC", [], __FILE__, __LINE__);
  $c_num = mysql_num_rows($cat);
  $c_i = 0;
				while ($c_i < $c_num){ 
					$cat_id = mysql_result($cat, $c_i, "CAT_ID");
$forum = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = ".$cat_id." ORDER BY F_ORDER ASC ", [], __FILE__, __LINE__);
		$f_num = mysql_num_rows($forum);
		$f_i = 0;
		while ($f_i < $f_num){
			$forum_id = mysql_result($forum, $f_i, "FORUM_ID");
			$f_subject = mysql_result($forum, $f_i, "F_SUBJECT");
			$f_hide = forums("HIDE", $forum_id);
			$check_forum_login = check_forum_login($forum_id);

			if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
				echo'<option value="'.$forum_id.'" '.check_select($f_n, $forum_id).'>'.$f_subject.'</option>';
			}

		$f_i++;
		}
		$c_i++;
		}
						echo'
						</select>
					</td>
					</form>';
				refresh_time();
                go_to_forum();
                

        			echo'
			</tr>
		</table>
		<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
			<tr>
				<td>
				<table cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" width="15%">المنتدى</td>
						<td class="cat">&nbsp;</td>
						<td class="cat" width="45%">المواضيع</td>
						<td class="cat" width="15%">الكاتب</td>
						<td class="cat">الردود</td>
						<td class="cat">قرأت</td>
						<td class="cat" width="15%">آخر رد</td>
						<td class="cat" width="1%">&nbsp;</td>
						</tr>';
	if($f_n > 0){
$query2 = "SELECT * FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = ".$m." AND FORUM_ID = ".$f_n." ORDER BY TOPIC_ID DESC";
} else {
$query2 = "SELECT * FROM {$mysql->prefix}REPLY WHERE R_AUTHOR = ".$m." ORDER BY TOPIC_ID DESC";
}
$result2 = $mysql->execute($query2, [], __FILE__, __LINE__);
$num = mysql_num_rows($result2);
	if($num <= 0){
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$text2.'<br><br><br></td>
</tr>';	
} else {
$i = 0;
$numt = 0;
while ($i < $num){
 if($numt == 50){
$t = $rs2[TOPIC_ID];
} else {
$rs2 = mysql_fetch_array($result2);
$tt = $rs2[TOPIC_ID];
if  ($tt == $t){
$t = $rs2[TOPIC_ID];
} else {
$t = $rs2[TOPIC_ID];
$forum_id = $rs2[FORUM_ID];
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$forum_id' ", [], __FILE__, __LINE__);
$rs3 = mysql_fetch_array($sql);
$f_subject = $rs3[F_SUBJECT]; 
$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_HIDDEN = 0 AND TOPIC_ID = '$t'", [], __FILE__, __LINE__);
$nom = mysql_num_rows($sql);
$rs4 = mysql_fetch_array($sql);
$t = $rs4[TOPIC_ID];
$cat_id = topics("CAT_ID", $t);
$forum_id = topics("FORUM_ID", $t);
$f_hide = forums("HIDE", $forum_id);
$check_forum_login = check_forum_login($forum_id);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$replies = topics("REPLIES", $t);
$counts = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$hidden = topics("HIDDEN", $t);
$author_name = members("NAME", $author);
$lp_author_name = members("NAME", $lp_author);
 if($lp_author == $m){
 $class = "lastposter";
} else {
 $class = "normal";
}
 if(!$nom == 0){
    if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
            echo'
	<tr class="'.$class.'">
		<td class="list_small"><a href="index.php?mode=f&f='.$forum_id.'">'.$f_subject.'</a></td>
		<td class="list_center"><nobr><a href="index.php?mode=f&f='.$forum_id.'">';
		if($status == 0 AND $replies < 20){
			echo icons($folder_new_locked, $lang['forum']['topic_is_locked']);
		}
		elseif($status == 0 AND $replies >= 20){
			echo icons($folder_new_locked, $lang['forum']['topic_is_hot_and_locked']);
		}
		elseif($status == 1 AND $replies < 20){
			echo icons($folder_new);
		}
		elseif($status == 1 AND $replies >= 20){
			echo icons($folder_new_hot, $lang['forum']['topic_is_hot']);
		}
		else {
			echo icons($folder);
		}
		echo'
		</a></nobr></td>
		<td class="list">
		<table cellPadding="0" cellsapcing="0" id="table2">
			<tr>
				<td><a href="index.php?mode=t&t='.$t.'">'.$subject.'</a>&nbsp;'; echo topic_paging($t); echo'</td>
			</tr>
		</table>
		</td>
		<td class="list_small2" noWrap><font color="green">'.normal_time($date).'</font><br>'.member_color_link($author).'</td>
		<td class="list_small2">'.$replies.'</td>
		<td class="list_small2">'.$counts.'</td>
		<td class="list_small2" noWrap><font color="red">';
	if($replies > 0){
		echo normal_time($lp_date).'</font><br>'.member_color_link($lp_author);
	}
		echo'
		</td>';
		echo'
		<td class="list_small2">';
		if($allowed == 1 OR $status == 1){
			echo'<a href="index.php?mode=editor&method=reply&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_reply_topic, "رد على الموضوع", "hspace=\"2\"").'</a>';
		}
		if($allowed == 1 OR $status == 1 AND $DBMemberID == $author){
			echo'<a href="index.php?mode=editor&method=edit&t='.$t.'&f='.$forum_id.'&c='.$cat_id.'">'.icons($icon_edit, "تعديل الموضوع", "hspace=\"2\"").'</a></br>';
		}
		echo'<nobr><a href="index.php?mode=t&t='.$t.'&m='.$m.'">'.icons($icon_group, $lang['topics']['reply_this_member'], "").'</a></nobr>';
		
		echo'
		</td>';
	
	echo'
	</tr>';
	$numt++;
	$t = $rs2[TOPIC_ID];
	}
	}
	$t = $rs2[TOPIC_ID];
	$numt++;
	}
	}
	$i++;
     }
     }
     echo'
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';

echo '<table cellspacing="0" cellpadding="0">
  <TR>
    <TD>المواضيع التي تظهر باللون التالي </TD>
    <TD><TABLE cellSpacing="1" border="1">
      <TBODY>
        <TR class="normal">
          <TD>   </TD>
        </TR>
      </TBODY>
    </TABLE></TD>
    <TD> '.$text6.'</TD>
  </TR>
</table>';		
}
?>
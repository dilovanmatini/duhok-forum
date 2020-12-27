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

require_once("./include/active_func.df.php");
if($active == ""){

if(members("ACTIVE", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][active].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


if($active_type == "active" OR $active_type == "hot" OR $active_type == "read"){
$text = 'المواضيع النشطة';
$text2 = 'لا توجد أية مواضيع نشطة';
}
else if($active_type == "top"){
$text = 'المواضيع المتميزة على المنتديات';
$text2 = 'لا توجد أية مواضيع متميزة على المنتديات';
}
else if($active_type == "mon"){
$text = 'قائمة مواضيعك المفضلة';
$text2 = 'لا توجد أية مواضيع في مفضلتك حاليا<br><br>لإضافة موضوع لقائمة مواضيعك المفضلة إستخدم الأيقونة الخاصة بذلك في صفحة<br><br>الموضوع المراد اضافته للقائمة.';
}
else if($active_type == "prv"){
$text = 'المواضيع المخفية المفتوحة لك';
$text2 = 'لا توجد أية مواضيع مخفية مفتوحة لك';
}

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td width="100%"><font size="4" color="red"><b>'.$text.'</b></font></td>';
				echo'
					<form method="post" action="'.$_SERVER[REQUEST_URI].'">
					<td class="optionsbar_menus"><nobr>خيار عرض المواضيع:</nobr><br>
						<select style="WIDTH: 180px" size="1" name="active_type" onchange="submit();">';		
						echo'<option value="active" '.check_select($active_type, "active").'>آخر المشاركات في كل المواضيع</option>';
						echo'<option value="hot" '.check_select($active_type, "hot").'>آخر المواضيع النشطة بعدد الردود</option>';
						echo'<option value="read" '.check_select($active_type, "read").'>آخر المواضيع النشطة بعدد مرات القراءة</option>';
						echo'<option value="mon" '.check_select($active_type, "mon").'>قائمة مواضيعك المفضلة</option>';
						echo'<option value="top" '.check_select($active_type, "top").'>المواضيع المتميزة على المنتديات</option>';
						echo'<option value="prv" '.check_select($active_type, "prv").'>المواضيع المخفية المفتوحة لك</option>';
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
						<td class="cat" width="15%">آخر رد</td>';
					if($Mlevel > 0){
						echo'<td class="cat" width="1%">&nbsp;</td>';
					}
					echo'
					</tr>';
					
		if($active_type == "active"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}
		else if($active_type == "hot"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '19'";
		}
		else if($active_type == "read"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_COUNTS > '99'";
		}
		else if($active_type == "mon"){
			$sql_open = "INNER JOIN {$mysql->prefix}FAVOURITE_TOPICS AS F WHERE T.T_HIDDEN = '0' AND T.TOPIC_ID = F.F_TOPICID AND F.F_MEMBERID = '$DBMemberID'";
		}
		else if($active_type == "top"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_TOP = '2'";
		}
		else if($active_type == "prv"){
			$sql_open = "INNER JOIN {$mysql->prefix}TOPIC_MEMBERS AS P WHERE T.TOPIC_ID = P.TOPIC_ID AND T.T_HIDDEN = '1' AND P.MEMBER_ID = '$DBMemberID'";
		}
		else{
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}

		$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS AS T ".$sql_open." ORDER BY T.T_LAST_POST_DATE DESC LIMIT 50", [], __FILE__, __LINE__);
		$num = mysql_num_rows($topics);
		if($num <= 0){
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$text2.'<br><br><br></td>
					</tr>';
		}
		else{
			$i = 0;
			while ($i < $num){
				$topic_id = mysql_result($topics, $i, "T.TOPIC_ID");
				$forum_id = topics("FORUM_ID", $topic_id);
				$f_level = forums("F_LEVEL", $forum_id);
				$f_hide = forums("HIDE", $forum_id);
				$check_forum_login = check_forum_login($forum_id);

			if($f_level == 0 OR $f_level > 0 AND $f_level <= mlv){
				if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
					active($topic_id);
				}
			}
				
			++$i;
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

} // active var == ""

if($active == "private"){

if($active_type == "active" OR $active_type == "hot" OR $active_type == "read"){
$text = 'المواضيع النشطة';
$text2 = 'لا توجد أية مواضيع نشطة';
}
else if($active_type == "top"){
$text = 'المواضيع المتميزة على المنتديات';
$text2 = 'لا توجد أية مواضيع متميزة على المنتديات';
}
else if($active_type == "mon"){
$text = 'قائمة مواضيعك المفضلة';
$text2 = 'لا توجد أية مواضيع في مفضلتك حاليا<br><br>لإضافة موضوع لقائمة مواضيعك المفضلة إستخدم الأيقونة الخاصة بذلك في صفحة<br><br>الموضوع المراد اضافته للقائمة.';
}
else if($active_type == "prv"){
$text = 'المواضيع المخفية المفتوحة لك';
$text2 = 'لا توجد أية مواضيع مخفية مفتوحة لك';
}

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td width="100%"><font size="4" color="red"><b>'.$text.'</b></font></td>';
				echo'
					<form method="post" action="'.$_SERVER[REQUEST_URI].'">
					<td class="optionsbar_menus"><nobr>خيار عرض المواضيع:</nobr><br>
						<select style="WIDTH: 180px" size="1" name="active_type" onchange="submit();">';		
						echo'<option value="active" '.check_select($active_type, "active").'>آخر المشاركات في كل المواضيع</option>';
						echo'<option value="hot" '.check_select($active_type, "hot").'>آخر المواضيع النشطة بعدد الردود</option>';
						echo'<option value="read" '.check_select($active_type, "read").'>آخر المواضيع النشطة بعدد مرات القراءة</option>';
						echo'<option value="mon" '.check_select($active_type, "mon").'>قائمة مواضيعك المفضلة</option>';
						echo'<option value="top" '.check_select($active_type, "top").'>المواضيع المتميزة على المنتديات</option>';
						echo'<option value="prv" '.check_select($active_type, "prv").'>المواضيع المخفية المفتوحة لك</option>';
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
						<td class="cat" width="15%">آخر رد</td>';
					if($Mlevel > 0){
						echo'<td class="cat" width="1%">&nbsp;</td>';
					}
					echo'
					</tr>';
					
		if($active_type == "active"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}
		else if($active_type == "hot"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '19'";
		}
		else if($active_type == "read"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_COUNTS > '99'";
		}
		else if($active_type == "mon"){
			$sql_open = "INNER JOIN {$mysql->prefix}FAVOURITE_TOPICS AS F WHERE T.T_HIDDEN = '0' AND T.TOPIC_ID = F.F_TOPICID AND F.F_MEMBERID = '$DBMemberID'";
		}
		else if($active_type == "top"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_TOP = '2'";
		}
		else if($active_type == "prv"){
			$sql_open = "INNER JOIN {$mysql->prefix}TOPIC_MEMBERS AS P WHERE T.TOPIC_ID = P.TOPIC_ID AND T.T_HIDDEN = '1' AND P.MEMBER_ID = '$DBMemberID'";
		}
		else{
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}

		$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS AS T ".$sql_open." ORDER BY T.T_LAST_POST_DATE DESC LIMIT 50", [], __FILE__, __LINE__);
		$num = mysql_num_rows($topics);
		if($num <= 0){
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$text2.'<br><br><br></td>
					</tr>';
		}
		else{
			$i = 0;
			while ($i < $num){
				$topic_id = mysql_result($topics, $i, "T.TOPIC_ID");
				$forum_id = topics("FORUM_ID", $topic_id);
				$f_hide = forums("HIDE", $forum_id);
				$check_forum_login = check_forum_login($forum_id);
				
				if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
					active_private($topic_id);
				}
				
			++$i;
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

} // active var == "private"

if($active == "monitored"){

if($active_type == "active" OR $active_type == "hot" OR $active_type == "read"){
$text = 'المواضيع النشطة';
$text2 = 'لا توجد أية مواضيع نشطة';
}
else if($active_type == "top"){
$text = 'المواضيع المتميزة على المنتديات';
$text2 = 'لا توجد أية مواضيع متميزة على المنتديات';
}
else if($active_type == "mon"){
$text = 'قائمة مواضيعك المفضلة';
$text2 = 'لا توجد أية مواضيع في مفضلتك حاليا<br><br>لإضافة موضوع لقائمة مواضيعك المفضلة إستخدم الأيقونة الخاصة بذلك في صفحة<br><br>الموضوع المراد اضافته للقائمة.';
}
else if($active_type == "prv"){
$text = 'المواضيع المخفية المفتوحة لك';
$text2 = 'لا توجد أية مواضيع مخفية مفتوحة لك';
}

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
				<td width="100%"><font size="4" color="red"><b>'.$text.'</b></font></td>';
				echo'
					<form method="post" action="'.$_SERVER[REQUEST_URI].'">
					<td class="optionsbar_menus"><nobr>خيار عرض المواضيع:</nobr><br>
						<select style="WIDTH: 180px" size="1" name="active_type" onchange="submit();">';		
						echo'<option value="active" '.check_select($active_type, "active").'>آخر المشاركات في كل المواضيع</option>';
						echo'<option value="hot" '.check_select($active_type, "hot").'>آخر المواضيع النشطة بعدد الردود</option>';
						echo'<option value="read" '.check_select($active_type, "read").'>آخر المواضيع النشطة بعدد مرات القراءة</option>';
						echo'<option value="mon" '.check_select($active_type, "mon").'>قائمة مواضيعك المفضلة</option>';
						echo'<option value="top" '.check_select($active_type, "top").'>المواضيع المتميزة على المنتديات</option>';
						echo'<option value="prv" '.check_select($active_type, "prv").'>المواضيع المخفية المفتوحة لك</option>';
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
						<td class="cat" width="15%">آخر رد</td>';
					if($Mlevel > 0){
						echo'<td class="cat" width="1%">&nbsp;</td>';
					}
					echo'
					</tr>';
					
		if($active_type == "active"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}
		else if($active_type == "hot"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '19'";
		}
		else if($active_type == "read"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_COUNTS > '99'";
		}
		else if($active_type == "mon"){
				if(members("MONITORED", $DBMemberID) == 1  ){
	                echo'
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][monitored].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                </center>';
exit();
}
			$sql_open = "INNER JOIN {$mysql->prefix}FAVOURITE_TOPICS AS F WHERE T.T_HIDDEN = '0' AND T.TOPIC_ID = F.F_TOPICID AND F.F_MEMBERID = '$DBMemberID'";
		}
		else if($active_type == "top"){
			$sql_open = "WHERE T_HIDDEN = '0' AND T_TOP = '2'";
		}
		else if($active_type == "prv"){
			$sql_open = "INNER JOIN {$mysql->prefix}TOPIC_MEMBERS AS P WHERE T.TOPIC_ID = P.TOPIC_ID AND T.T_HIDDEN = '1' AND P.MEMBER_ID = '$DBMemberID'";
		}
		else{
			$sql_open = "WHERE T_HIDDEN = '0' AND T_REPLIES > '0'";
		}

		$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS AS T ".$sql_open." ORDER BY T.T_LAST_POST_DATE DESC LIMIT 50", [], __FILE__, __LINE__);
		$num = mysql_num_rows($topics);
		if($num <= 0){
					echo'
					<tr>
						<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>'.$text2.'<br><br><br></td>
					</tr>';
		}
		else{
			$i = 0;
			while ($i < $num){
				$topic_id = mysql_result($topics, $i, "T.TOPIC_ID");
				$forum_id = topics("FORUM_ID", $topic_id);
				$f_hide = forums("HIDE", $forum_id);
				$check_forum_login = check_forum_login($forum_id);
				
				if($f_hide == 0 OR $f_hide == 1 AND $check_forum_login == 1){
					active_monitored($topic_id);
				}
				
			++$i;
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

} // active var == "monitored"

?>

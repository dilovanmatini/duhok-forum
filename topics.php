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

if(mlv > 0){

if($m == "0"){
$m = $DBMemberID;
}

$allowed = 1;
if(members("LEVEL", $m) > "2" AND $Mlevel > "1"){
$allowed = 1;
}
if(members("LEVEL", $m) > "2" AND $show_admin_topics == "1"){
$allowed = 1;
}
if(members("LEVEL", $m) > "2" AND $show_admin_topics == "0" AND $Mlevel < "2"){
$allowed = 0;
}

if($m == "0" OR $m == $DBMemberID){
$word = " مواضيعك الحالية وفي الأرشيف </font>";
if(members("P_TOPICS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][your_topics].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
} else {
if($mlv == 1   AND $DBMemberPosts < $new_member_show_topic){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[sorry][noo].'
'.$lang[sorry][topics].'
'.$lang[sorry][will].'
	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


if(members("P_TOPICS_MEMBERS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][topics_members].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

$word = 'مواضيع العضو: </font><a href="index.php?mode=profile&id='.$m.'"><font color="red" size="+2">'.members("NAME", $m).'</font></a>';
}

function cat_check_topic($cat_id, $id){
         $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE CAT_ID = '$cat_id' AND T_AUTHOR = '$id' ", [], __FILE__, __LINE__);
 $num = mysql_num_rows($sql);
 if($num > "0"){
  $num_topics = 1;
 }
	return($num_topics);
}

function forum_check_topic($forum_id, $id){
         $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$forum_id' AND T_AUTHOR = '$id' ", [], __FILE__, __LINE__);
 $num = mysql_num_rows($sql);
 if($num > "0"){
  $num_topics = 1;
 }
	return($num_topics);
}

function num_topic($forum_id, $id){
         $sql = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE FORUM_ID = '$forum_id' AND T_AUTHOR = '$id' AND T_ARCHIVED = 0 ", [], __FILE__, __LINE__);
  $num_topics = mysql_num_rows($sql);
	return($num_topics);
}

echo '<center><br><table class="grid" dir="rtl" cellSpacing="1" cellPadding="1" border="0">
	<tr>
		<td vAlign="top" align="middle" bgColor="yellow" colSpan="10"><b>
		<font color="black" size="+2">'.$word.'</b></td>
	</tr>
	<tr>
		<td vAlign="top" align="middle" bgColor="orange" colSpan="10">
		<font color="white" size="-1">لتصفح المواضيع في منتدى معين إضغط على عددها</font></td>
	</tr>';
if($allowed == 1){

	$cat = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC", [], __FILE__, __LINE__); // category mysql
$c_num = mysql_num_rows($cat);

$c_i = 0;
				while ($c_i < $c_num){ //category while start
					$cat_id = mysql_result($cat, $c_i, "CAT_ID");
					$cat_name = mysql_result($cat, $c_i, "CAT_NAME");
                    if(cat_check_topic($cat_id, $m) == 1){
                    echo '<tr>
		<td class="cat" vAlign="top">&nbsp;<b>'.$cat_name.'</b></td>
		<td class="cat" align="middle">المواضيع الحالية</td>
		<td class="cat" align="middle">المواضيع في الأرشيف</td>
	</tr>';
            $forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$cat_id' ORDER BY F_ORDER ASC", [], __FILE__, __LINE__); // forum mysql
					$f_num = mysql_num_rows($forums);
                    $f_i = 0;
						while ($f_i < $f_num){ // forum while start
							$forum_id = mysql_result($forums, $f_i, "FORUM_ID");
                            $f_subject = forums("SUBJECT", $forum_id);
                            $f_status = forums("STATUS", $forum_id);
                            if(forum_check_topic($forum_id, $m) == 1){
                            echo '<tr>
								<td class="f1">
								<table width="100%">
									<tr>
										<td class="f1"><a href="index.php?mode=f&f='.$forum_id.'">'.$f_subject.'</a></td>
									</tr>
								</table>
								</td>
								<td class="f2ts" vAlign="center" align="middle">
								<table width="100%">
									<tr>
										<td>';
										if($f_status == 0){
											echo icons($folder_locked, $lang['home']['forum_locked'], "");
										}
										else {
											echo icons($folder, $lang['home']['forum_opened'], "");
										}
$num_a = mysql_num_rows($mysql->execute("select * from {$mysql->prefix}TOPICS where T_ARCHIVED = 1 AND FORUM_ID = '$forum_id' AND T_AUTHOR = '$m' "));
										echo'
										</td>
                                        <td class="f2ts" vAlign="center" align="middle"><a href="index.php?mode=f&f='.$forum_id.'&auth='.$m.'">'.num_topic($forum_id, $m).'</a></td>
									</tr>
								</table>
							</td>
                            <td class="f2ts"><a href="index.php?mode=f&f='.$forum_id.'&auth='.$m.'&type=archive">'.$num_a .'</a></td>';

                            }
                            $f_i++;
                    }
                    }
                    $c_i++;
                    }

} else {
echo '<tr class="normal">
				<td class="list_center" colSpan="10"><br>
				<br>
				لا يمكن تصفح هذه العضوية.<br>
				<br>
&nbsp;</td>
			</tr>';
}
echo '</table></center>';
} else {
redirect();
}









?>

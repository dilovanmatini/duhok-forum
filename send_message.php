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

?>
<script language="javascript">
    function send_msg(id){
	    window.location = "index.php?mode=editor&method=sendmsg&m="+id;
    }
</script>
<?php

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<form method="post" action="index.php?mode=sendmsg&method=search">
			<table width="100%">
				<tr>
					<td class="optionsbar_menus" width="100%"><nobr><font size="+1">'.$lang['send_message']['send_private_message'].'</font></nobr></td>
					<td class="optionsbar_menus"><nobr><font color="red" size="+1">'.$lang['send_message']['member_name'].' </font></nobr></td>
					<td class="optionsbar_menus"><nobr><input style="width: 200px" name="search_member"></nobr></td>
					<td class="optionsbar_menus"><nobr>&nbsp;<input type="submit" value="'.$lang['send_message']['search_member'].'"></nobr></td>
				</tr>
			</table>
		</form>
		<table width="100%" border="1">
			<tr class="normal">
				<td class="list_center" colSpan="10">';
    
    
if($method == ""){
                echo'
                <br><br>'.$lang['send_message']['insert_letter_to_up_field_and_click_here'].'<br><br>
				<a href="index.php?mode=sendmsg&method=mod">'.$lang['send_message']['or_click_here_to_send_pm_to_moderate'].'</a><br><br>&nbsp;';
}


if($method == "search"){

$search_member = $_POST['search_member'];

if($search_member == ""){
   echo'<br><br>'.$lang['send_message']['non_name'].'<br><br>';
}
else {

  $S_M = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_NAME LIKE '%$search_member%' AND M_STATUS = '1' AND M_LEVEL = '1' ", [], __FILE__, __LINE__);
  $S_Mnum = mysql_num_rows($S_M);

  if($S_Mnum == 0){
        echo'<br><br>'.$lang['send_message']['this_name_non'].'<br><br>';
  }
  else {
                echo'
				<br><font color="red"><u>'.$lang['send_message']['please_choose_one_name'].'</u><br><br>&nbsp;
                <table cellPadding="6" border="1">
                  <tr>';

    $i=0;
    while ($i < $S_Mnum){

        $SM_MemberID = mysql_result($S_M, $i, "MEMBER_ID");
        $SM_MemberName = mysql_result($S_M, $i, "M_NAME");


       echo '<td align="center"><nobr><a href="javascript:send_msg('.$SM_MemberID.');">'.$SM_MemberName.'</a></nobr></td>';
            if($i % 2){
               echo '</tr><tr>';
            }
    $i++;
    }
               echo'
                  </tr>
                </table><br><br>';
  }
}
}
if($method == "mod"){


  $Forum = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE F_STATUS = '1' ", [], __FILE__, __LINE__);
  $F_num = mysql_num_rows($Forum);

  if($F_num == 0){
        echo'<br><br>'.$lang['send_message']['non_forum'].'<br><br>';
  }
  else {
                echo'
				<br><font color="red"><u>'.$lang['send_message']['please_choose_one_name'].'</u><br><br>&nbsp;
                <table cellPadding="6" border="1" width="30%"><tr><td align="center"><font color="red">'.$lang['send_message']['forum_list'].'</font></td></tr></table><br>
                <table cellPadding="6" border="1"><tr>';

    $i=0;
    while ($i < $F_num){

        $F_ForumID = mysql_result($Forum, $i, "FORUM_ID");
        $F_ForumSubject = mysql_result($Forum, $i, "F_SUBJECT");


       echo '<td align="center"><nobr><a href="javascript:send_msg(-'.$F_ForumID.');">'.$F_ForumSubject.'</a></nobr></td>';
            if($i % 2){
               echo '</tr><tr>';
            }
    $i++;
    }
               echo'
                </tr></table><br><br>';
  }
  
  $Mod = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE M_LEVEL = '2' AND M_STATUS = '1' ", [], __FILE__, __LINE__);
  $M_num = mysql_num_rows($Mod);

  if($M_num == 0){
        echo'<br><br>'.$lang['send_message']['non_moderator'].'<br><br>';
  }
  else {
                echo'
                <table cellPadding="6" border="1" width="30%"><tr><td align="center"><font color="red">'.$lang['send_message']['moderator_list'].'</font></td></tr></table><br>
                <table cellPadding="6" border="1">
                  <tr>';

    $ii=0;
    while ($ii < $M_num){

        $M_MemberID = mysql_result($Mod, $ii, "MEMBER_ID");
        $M_MemberName = mysql_result($Mod, $ii, "M_NAME");


       echo '<td align="center"><nobr><a href="javascript:send_msg('.$M_MemberID.');">'.$M_MemberName.'</a></nobr></td>';
            if($ii % 2){
               echo '</tr><tr>';
            }
    $ii++;
    }
               echo'
                  </tr>
                </table><br><br>';
  }


}

    $Yesterday = time()-(60*1440);
    
    $TOTAL_MSG = $mysql->execute("SELECT count(*) FROM {$mysql->prefix}PM WHERE PM_MID = '$DBMemberID' AND PM_OUT = '1' AND PM_DATE > '$Yesterday' ", [], __FILE__, __LINE__);
    $TotalMsg = mysql_result($TOTAL_MSG, 0, "count(*)");
    
                echo'
				<table border="1">
					<tr>
						<td bgColor="black" colSpan="2"><font color="white" size="-1">&nbsp;'.$lang['send_message']['pm_who_send_in_24_hour'].'&nbsp;</font></td>
					</tr>
					<tr>
						<td><font size="-1">'.$lang['send_message']['number_of_pm'].'</font></td>
						<td><font color="red" size="-1">'.$TotalMsg.'</font></td>
					</tr>
					<tr>
						<td><font size="-1">'.$lang['send_message']['total_pm'].'</font></td>
						<td><font color="red" size="-1">'.$total_pm_message.'</font></td>
					</tr>
				</table><br><br><br>&nbsp;';

                echo'
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>';

?>

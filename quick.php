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

if(members("THE_ID", $m) == 1 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[out][member_is_admin].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}

$ppMemberID = $m;
if($type == ""){

    if($Mlevel == 4  ){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$ppMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $ProMemberTopics = $rs['LOCK_TOPICS'];
 $ProMemberPosts = $rs['LOCK_POSTS'];
 $ProMemberPm = $rs['M_HIDE_PM'];
 }
 
$Name = link_profile(member_name($m), $m);


echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="index.php?mode=quick&m='.$m.'&type=add">
<input type="hidden" name="user_id" value="'.$ppMemberID.'">

	<tr class="fixed">
	<td class="cat" colspan="4"><nobr>'.$lang[quick][title].'   '.$Name.'  </td>

	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang[lock][topics].'</nobr></td>
		<td class="userdetails_data">
    <input class="radio" type="radio" value="0" name="user_topics" '.check_radio($ProMemberTopics , "0").'>'.$lang[lock][yes].'&nbsp;&nbsp;&nbsp;&nbsp;
       <td class="userdetails_data">
       <input class="radio" type="radio" value="1" name="user_topics" '.check_radio($ProMemberTopics , "1").'>'.$lang[lock][no].'&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang[lock][posts].'</nobr></td>
		<td class="userdetails_data">
    <input class="radio" type="radio" value="0" name="user_posts" '.check_radio($ProMemberPosts , "0").'>'.$lang[lock][yes].'&nbsp;&nbsp;&nbsp;&nbsp;
       <td class="userdetails_data">
       <input class="radio" type="radio" value="1" name="user_posts" '.check_radio($ProMemberPosts , "1").'>'.$lang[lock][no].'&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang[lock][pm].'</nobr></td>
		<td class="userdetails_data">
    <input class="radio" type="radio" value="1" name="user_pm" '.check_radio($ProMemberPm , "1").'>'.$lang[lock][yes].'&nbsp;&nbsp;&nbsp;&nbsp;
       <td class="userdetails_data">
       <input class="radio" type="radio" value="0" name="user_pm" '.check_radio($ProMemberPm , "0").'>'.$lang[lock][no].'&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
 	<tr class="fixed">
		<td align="middle" colspan="3"><input type="submit" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
	</tr>		

';
 }
 else {
 redirect();
 }
}

if($type == "add"){

    if($Mlevel == 4  ){


$ppMemberID = HtmlSpecialchars($_POST["user_id"]);
$user_topics = HtmlSpecialchars($_POST["user_topics"]);
$user_posts = HtmlSpecialchars($_POST["user_posts"]);
$user_pm = HtmlSpecialchars($_POST["user_pm"]);



if($error == ""){

		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";
        $query .= " LOCK_TOPICS = ('$user_topics'), ";
        $query .= " LOCK_POSTS = ('$user_posts'), ";
        $query .= " M_HIDE_PM = ('$user_pm') ";


        $query .= "WHERE MEMBER_ID = '$ppMemberID' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);

	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang[quick][add].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=profile&id='.$m.'">
                           <a href="index.php?mode=profile&id='.$m.'">'.$lang['all']['click_here_to_go_normal_page'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}


    }
    else {
    redirect();
    }

}
?>
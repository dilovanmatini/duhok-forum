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

$ppMemberID = $id;
if($type == ""){
 if($Mlevel == 4){

 $query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$ppMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberID = $rs['MEMBER_ID'];
 $Pemission_Index = $rs['P_INDEX'];
 $Pemission_Archive = $rs['P_ARCHIVE'];
 $Pemission_Members = $rs['P_MEMBERS'];
 $Pemission_Posts = $rs['P_POSTS'];
 $Pemission_Posts_Members = $rs['P_POSTS_MEMBERS'];
 $Pemission_Topics = $rs['P_TOPICS'];
 $Pemission_Topics_Members = $rs['P_TOPICS_MEMBERS'];
 $Pemission_Active = $rs['P_ACTIVE'];
 $Pemission_Monitored= $rs['P_MONITORED'];
 $Pemission_Search = $rs['P_SEARCH'];
 $Pemission_Details = $rs['P_DETAILS'];
 $Pemission_Pass = $rs['P_PASS'];
 $Pemission_Details_Edit = $rs['P_DETAILS_EDIT'];
 $Pemission_Medals = $rs['P_MEDALS'];
 $Pemission_Change_Name = $rs['P_CHANGE_NAME'];
 $Pemission_List = $rs['P_LIST'];
 $Pemission_Sig_Edit = $rs['P_SIG'];
 $Pemission_Forum = $rs['P_FORUM'];
 $Pemission_Forum_Archive = $rs['P_FORUM_ARCHIVE'];
 $Pemission_Topics_Show = $rs['P_TOPICS_SHOW'];
 $Pemission_Posts_Show = $rs['P_POSTS_SHOW'];
 $Pemission_Quick_Posts = $rs['P_QUICK_POSTS'];
 $Pemission_Add_Topics = $rs['P_ADD_TOPICS'];
 $Pemission_Add_Posts = $rs['P_ADD_POSTS'];
 $Pemission_Edit_Topics = $rs['P_EDIT_TOPICS'];
 $Pemission_Edit_Posts = $rs['P_EDIT_POSTS'];
 $Pemission_Send_Topics = $rs['P_SEND_TOPICS'];
 $Pemission_Notify = $rs['P_NOTIFY'];

 }
$Name = link_profile(member_name($ProMemberID), $ProMemberID);

echo '
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
		<table class="optionsbar" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center"></td>
				<td class="optionsbar_title" vAlign="center" width="100%">'.$lang[permission][permission_edit].' '.$Name.'</td>';
            go_to_forum();
            echo'
            </tr>
		</table>
		</td>
	</tr>
</table>
</center>
<br>';


echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="index.php?mode=permission&type=add">
<input type="hidden" name="user_id" value="'.$ppMemberID.'">
	<tr class="fixed">
	<td class="cat" colspan="4"><nobr>'.$lang[permission][permission_edit_title].'</td>

	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][index].'</nobr></td>
		<td class="userdetails_data">
    <input class="radio" type="radio" value="0" name="user_index" '.check_radio($Pemission_Index , "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
       <td class="userdetails_data">
       <input class="radio" type="radio" value="1" name="user_index" '.check_radio($Pemission_Index , "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][archive].'</nobr></td>
		<td class="userdetails_data">
       <input class="radio" type="radio" value="0" name="user_archived" '.check_radio($Pemission_Archive, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_archived" '.check_radio($Pemission_Archive, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>        

		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][members].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_members" '.check_radio($Pemission_Members, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_members" '.check_radio($Pemission_Members, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][posts].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_posts" '.check_radio($Pemission_Posts, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_posts" '.check_radio($Pemission_Posts, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][posts_members].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_posts_members" '.check_radio($Pemission_Posts_Members, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_posts_members" '.check_radio($Pemission_Posts_Members, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][topics].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_topics" '.check_radio($Pemission_Topics, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_topics" '.check_radio($Pemission_Topics, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][topics_members].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_topics_members" '.check_radio($Pemission_Topics_Members, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_topics_members" '.check_radio($Pemission_Topics_Members, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][active].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_active" '.check_radio($Pemission_Active, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_active" '.check_radio($Pemission_Active, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][monitored].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_monitored" '.check_radio($Pemission_Monitored, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_monitored" '.check_radio($Pemission_Monitored, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][search].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_search" '.check_radio($Pemission_Search, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_search" '.check_radio($Pemission_Search, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][details].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_details" '.check_radio($Pemission_Details, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_details" '.check_radio($Pemission_Details, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][pass].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_pass" '.check_radio($Pemission_Pass, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_pass" '.check_radio($Pemission_Pass, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][edit_details].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_edit_details" '.check_radio($Pemission_Details_Edit, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_edit_details" '.check_radio($Pemission_Details_Edit, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][edit_sig].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_edit_sig" '.check_radio($Pemission_Sig_Edit, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_edit_sig" '.check_radio($Pemission_Sig_Edit, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][medals].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_medals" '.check_radio($Pemission_Medals, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_medals" '.check_radio($Pemission_Medals, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][change_name].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_change_name" '.check_radio($Pemission_Change_Name, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_change_name" '.check_radio($Pemission_Change_Name, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][lists].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_list" '.check_radio($Pemission_List, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_list" '.check_radio($Pemission_List, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][FORUM].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_forum" '.check_radio($Pemission_Forum, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_forum" '.check_radio($Pemission_Forum, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][FORUM_ARCHIVE].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_forum_archive" '.check_radio($Pemission_Forum_Archive, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_forum_archive" '.check_radio($Pemission_Forum_Archive, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][TOPICS_SHOW].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_s_topics" '.check_radio($Pemission_Topics_Show, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_s_topics" '.check_radio($Pemission_Topics_Show, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][POSTS_SHOW].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_s_post" '.check_radio($Pemission_Posts_Show, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_s_post" '.check_radio($Pemission_Posts_Show, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][QUICK_POSTS].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_quick" '.check_radio($Pemission_Quick_Posts, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_quick" '.check_radio($Pemission_Quick_Posts, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][add_topics].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_add_topics" '.check_radio($Pemission_Add_Topics, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_add_topics" '.check_radio($Pemission_Add_Topics, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][add_posts].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_add_posts" '.check_radio($Pemission_Add_Posts, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_add_posts" '.check_radio($Pemission_Add_Posts, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][edit_topics].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_edit_topics" '.check_radio($Pemission_Edit_Topics, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_edit_topics" '.check_radio($Pemission_Edit_Topics, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][edit_posts].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_edit_posts" '.check_radio($Pemission_Edit_Posts, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_edit_posts" '.check_radio($Pemission_Edit_Posts, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][send_topics].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_send_topics" '.check_radio($Pemission_Send_Topics, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_send_topics" '.check_radio($Pemission_Send_Topics, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
		<tr class="fixed">
		<td class="cat"><nobr>'.$lang[permission][permission].''.$lang[permission][notify].'</nobr></td>
		<td class="userdetails_data">
        <input class="radio" type="radio" value="0" name="user_notify" '.check_radio($Pemission_Notify, "0").'>'.$lang[permission][permission_yes].'&nbsp;&nbsp;&nbsp;&nbsp;
        <td class="userdetails_data">
        <input class="radio" type="radio" value="1" name="user_notify" '.check_radio($Pemission_Notify, "1").'>'.$lang[permission][permission_no].'&nbsp;&nbsp;&nbsp;&nbsp;        </td>
	</tr>
	
	
 	<tr class="fixed">
		<td align="middle" colspan="3"><input type="submit" value="'.$lang['profile']['insert_info'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['profile']['reset_info'].'"></td>
	</tr>		

</form>
</table>	<br>
</center>';
 }
 else {
 redirect();
 }
}

if($type == "add"){

 if($Mlevel == 4){

$ppMemberID = HtmlSpecialchars($_POST["user_id"]);
 if($ppMemberID > 1){
$user_index = HtmlSpecialchars($_POST["user_index"]);
$user_archived = HtmlSpecialchars($_POST["user_archived"]);
$user_members = HtmlSpecialchars($_POST["user_members"]);
$user_posts = HtmlSpecialchars($_POST["user_posts"]);
$user_posts_members = HtmlSpecialchars($_POST["user_posts_members"]);
$user_topics = HtmlSpecialchars($_POST["user_topics"]);
$user_topics_members = HtmlSpecialchars($_POST["user_topics_members"]);
$user_active = HtmlSpecialchars($_POST["user_active"]);
$user_monitored = HtmlSpecialchars($_POST["user_monitored"]);
$user_search = HtmlSpecialchars($_POST["user_search"]);
$user_details = HtmlSpecialchars($_POST["user_details"]);
$user_pass = HtmlSpecialchars($_POST["user_pass"]);
$user_edit_details = HtmlSpecialchars($_POST["user_edit_details"]);
$user_edit_sig = HtmlSpecialchars($_POST["user_edit_sig"]);
$user_medals = HtmlSpecialchars($_POST["user_medals"]);
$user_change_name = HtmlSpecialchars($_POST["user_change_name"]);
$user_list = HtmlSpecialchars($_POST["user_list"]);
$user_forum = HtmlSpecialchars($_POST["user_forum"]);
$user_forum_archive = HtmlSpecialchars($_POST["user_forum_archive"]);
$user_topics_show = HtmlSpecialchars($_POST["user_s_topics"]);
$user_posts_show = HtmlSpecialchars($_POST["user_s_post"]);
$user_quick_post = HtmlSpecialchars($_POST["user_quick"]);
$user_add_topics = HtmlSpecialchars($_POST["user_add_topics"]);
$user_add_posts = HtmlSpecialchars($_POST["user_add_posts"]);
$user_edit_topics = HtmlSpecialchars($_POST["user_edit_topics"]);
$user_edit_posts = HtmlSpecialchars($_POST["user_edit_posts"]);
$user_send_topics = HtmlSpecialchars($_POST["user_send_topics"]);
$user_notify = HtmlSpecialchars($_POST["user_notify"]);
}


if($error == ""){

		$query = "UPDATE {$mysql->prefix}MEMBERS SET ";

        $query .= "P_INDEX = ('$user_index'), ";
        $query .= "P_ARCHIVE = ('$user_archived'), ";
        $query .= "P_MEMBERS = ('$user_members'), ";
        $query .= "P_POSTS = ('$user_posts'), ";
        $query .= "P_POSTS_MEMBERS = ('$user_posts_members'), ";
        $query .= "P_TOPICS = ('$user_topics'), ";
        $query .= "P_TOPICS_MEMBERS = ('$user_topics_members'), ";
        $query .= "P_ACTIVE = ('$user_active'), ";
        $query .= "P_MONITORED= ('$user_monitored'), ";
        $query .= "P_SEARCH = ('$user_search'), ";
        $query .= "P_DETAILS = ('$user_details'), ";
        $query .= "P_PASS = ('$user_pass'), ";
        $query .= "P_DETAILS_EDIT = ('$user_edit_details'), ";
        $query .= "P_SIG = ('$user_edit_sig'), ";
        $query .= "P_MEDALS = ('$user_medals'), ";
        $query .= "P_CHANGE_NAME = ('$user_change_name'), ";
        $query .= "P_FORUM = ('$user_forum'), ";
        $query .= "P_FORUM_ARCHIVE = ('$user_forum_archive'), ";
        $query .= "P_TOPICS_SHOW = ('$user_topics_show'), ";
        $query .= "P_POSTS_SHOW = ('$user_posts_show'), ";
        $query .= "P_QUICK_POSTS = ('$user_quick_post'), ";
        $query .= "P_ADD_POSTS = ('$user_add_posts'), ";
        $query .= "P_ADD_TOPICS = ('$user_add_topics'), ";
        $query .= "P_EDIT_POSTS = ('$user_edit_posts'), ";
        $query .= "P_EDIT_TOPICS = ('$user_edit_topics'), ";
        $query .= "P_SEND_TOPICS = ('$user_send_topics'), ";
        $query .= "P_NOTIFY = ('$user_notify'), ";
        $query .= "P_LIST = ('$user_list') ";
        $query .= "WHERE MEMBER_ID = '$ppMemberID' ";
		$mysql->execute($query, $connection, [], __FILE__, __LINE__);
                    echo'
	                <center>
	                <table width="99 %" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['profile']['your_details_has_edited'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php?mode=permission&id='.$ppMemberID.'">
                           <a href="index.php?mode=permission&id='.$ppMemberID.'">'.$lang['profile']['click_here_to_go_normal_page'].'</a><br><br>
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
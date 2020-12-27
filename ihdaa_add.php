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
    
 if( mlv == 1 AND $DBMemberPosts < $WHAT_LIMIT ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[sorry][no].'
'.$lang[sorry][what].'
'.$lang[sorry][will].'
	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}


    
    if(mlv < 4 AND $WHAT_ACTIVE == 0 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[ihdaa][close].'

	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
exit();
}

    if(members("IHDAA", $DBMemberID) == 1 ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[ihdaa][go_out].'

	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
exit();
}




if(mlv > 0){



$oforum_ida = $f;

if($type == ""){

$query = "SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '" .$DBMemberID."' ";
 $result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

 if(mysql_num_rows($result) > 0){
 $rs=mysql_fetch_array($result);

 $ProMemberIP = $rs['M_IP'];
 }



echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=ihdaa_add&type=add">

	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>'.$lang['other_cat_forum']['add_forum1'].'</nobr></td>
			<tr class="fixed">

		<td class="cat" colspan="2"><nobr>'.$lang['ihdaa']['remember1'].''.$lang['ihdaa']['remember'].' </nobr></td>

			</tr>
		<input type="hidden"  value="'.$DBMemberID.'"  name="forum_namea" size="80"></td>
				<input  type="hidden" value="'.$ProMemberIP.'"  name="forum_ip" size="80"></td>

	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['forum_url1'].'</nobr></td>
		<td class="userdetails_data">
			<textarea style="WIDTH: 600;HEIGHT: 250;'.M_Style_Form.'" name="message" rows="1" cols="20"></textarea>

	</tr>
	
	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['other_cat_forum']['ok'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "add"){

$Forum_Namea = $_POST["forum_namea"];
$Forum_Urla = $_POST["message"];
$Forum_ip = $_POST["forum_ip"];


	$queryF = "INSERT INTO {$mysql->prefix}CEP_FORUM (O_FORUMIDA, O_FORUM_NAMEA, O_FORUM_URLA, O_FORUM_IP , O_FORUM_DATE ) VALUES (NULL, '$Forum_Namea', '$Forum_Urla' , '$Forum_ip', '$date')";
$mysql->execute($queryF, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['other_cat_forum']['the_forum_was_added1'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}}

?>
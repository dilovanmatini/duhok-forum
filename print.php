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

if($t == ""){
 redirect();
}

$forum_hide = forums("HIDE", topics("FORUM_ID", $t));
$check_forum_login = check_forum_login(topics("FORUM_ID", $t));
if($forum_hide == 1){
	if($check_forum_login == 0){
		redirect();
	}
}

$resultTop = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE TOPIC_ID = '$t' ")
or die (mysql_error());

if(mysql_num_rows($resultTop) > 0){
$rsTop = mysql_fetch_array($resultTop);

$TOP_TopicID = $rsTop['TOPIC_ID'];
$TOP_ForumID = $rsTop['FORUM_ID'];
$TOP_CatID = $rsTop['CAT_ID'];
$TOP_TopicStatus = $rsTop['T_STATUS'];
$TOP_TopicSubject = $rsTop['T_SUBJECT'];
$TOP_TopicMessage = $rsTop['T_MESSAGE'];
$TOP_TopicAuthor = $rsTop['T_AUTHOR'];
$TOP_TopicDate = $rsTop['T_DATE'];
$TOP_TopicHidden = $rsTop['T_HIDDEN'];
$TOP_LastEdit_date = $rsTop['T_LASTEDIT_DATE'];
$TOP_LastEdit_make = $rsTop['T_LASTEDIT_MAKE'];
$TOP_Lock = $rsTop['T_LOCK_MAKE'];
$TOP_Open = $rsTop['T_OPEN_MAKE'];
$TOP_Lock_date = $rsTop['T_LOCK_DATE'];
$TOP_Open_date = $rsTop['T_OPEN_DATE'];
$TOP_Enum = $rsTop['T_ENUM'];
}

$resultMTop = $mysql->execute("SELECT * FROM {$mysql->prefix}MEMBERS WHERE MEMBER_ID = '$TOP_TopicAuthor' ")
or die (mysql_error());

if(mysql_num_rows($resultMTop) > 0){
$rsMTop = mysql_fetch_array($resultMTop);

$MTOP_MemberID = $rsMTop['MEMBER_ID'];
$MTOP_MemberName = $rsMTop['M_NAME'];
$MTOP_MemberStatus = $rsMTop['M_STATUS'];
$MTOP_MemberCountry = $rsMTop['M_COUNTRY'];
$MTOP_MemberTitle = $rsMTop['M_TITLE'];
$MTOP_MemberLevel = $rsMTop['M_LEVEL'];
$MTOP_MemberPosts = $rsMTop['M_POSTS'];
$MTOP_MemberDate = $rsMTop['M_DATE'];
$MTOP_MemberPhotoUrl = $rsMTop['M_PHOTO_URL'];
$MTOP_MemberSig = $rsMTop['M_SIG'];
$MTOP_MemberLogin = $rsMTop['M_LOGIN'];
$MTOP_MemberBrowse = $rsMTop['M_BROWSE'];
}

$resultFTop = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE FORUM_ID = '$TOP_ForumID' ", [], __FILE__, __LINE__);

if(mysql_num_rows($resultFTop) > 0){
$rsFTop = mysql_fetch_array($resultFTop);

$FTOP_ForumID = $rsFTop['FORUM_ID'];
$FTOP_ForumSubject = $rsFTop['F_SUBJECT'];
$FTOP_ForumLogo = $rsFTop['F_LOGO'];
}

echo'
<font color="red"><b><font color="black" size="-1"><center>
<table dir="rtl" cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><a href="index.php">'.icons($logo, $forum_title, "").'&nbsp;</td>
		<td width="100%">&nbsp;</td>
		<td vAlign="top">'.$site_name.'</td>
	</tr>
</table>
<table cellSpacing="0" width="100%" border="0">
	<tr>
		<td align="middle" width="100%"><font size="5">&nbsp;'.$TOP_TopicSubject.'</font></td>
		<td>&nbsp;</td>
	</tr>
</table>
<table dir="rtl" cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
	<tr>
		<td>
		<table dir="rtl" cellSpacing="1" cellPadding="4" width="100%" border="1">
			<tr>
				<td vAlign="top" width="100%" bgColor="black" height="29">
					<a class="menu" href="index.php?mode=f&f='.$FTOP_ForumID.'">
					<font color="#FFFFFF" size="+1">
					<span style="text-decoration: none">'.$FTOP_ForumSubject.'</span></font></a><td bgColor="black" height="29"><font color="#FFFFFF"><nobr>'.normal_time($TOP_TopicDate).'</nobr></font></td>
			</tr>
			<tr>
				<td vAlign="top" bgColor="#ffffff" colSpan="2">
				<table style="table-layout: fixed">
					<tr>
						<td><center>
						'; echo text_replace($TOP_TopicMessage); if 
						($load_show_sig == 1 AND !empty($MTOP_MemberSig)){ echo 
						'<br><br>
                                      <FIELDSET style="width: 100%; text-align: center">
                                      <legend>&nbsp;<font color="black">'.$lang['topics']['the_signature'].'</font></legend>
                                      '.text_replace($MTOP_MemberSig).'
                                      </FIELDSET>
                                      '; } else { echo ''; } echo'
                                </center></td>
					</tr>
				</table>
				</td>
			</tr>
			</table>
<?php
					<tr>
							';
							if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
							  if($TOP_TopicStatus == 1){							  }
							}
							if($Mlevel == 4 OR $Monitor == 1 OR $Moderator == 1){
							  if($TOP_TopicStatus == 0){
							  }
							}
							echo'
							</td>
						</form>
					</tr>	
				</table>
				</td>
			</tr>
		</table>
		<table class="" cellSpacing="2" width="100%" border="0">
			<tr>
				<td vAlign="center">&nbsp;';
				if($TOP_TopicStatus == 1){
				}
				if($TOP_TopicStatus == 0){
				}
				echo'</td>
			</tr>
		</table>
		<table cellSpacing="2" width="100%" border="0">
			<tr>
			<td class="" vAlign="center" width="100%"><a class="footerbar" href="index.php?mode=f&f='.$FTOP_ForumID.'"><font color="red" size="+1"></font></a></td>';
if($DBMemberID > 0){
		echo'	<td class="" vAlign="top"><nobr><a href="index.php?mode=editor&method=reply&t='.$TOP_TopicID.'&f='.$TOP_ForumID.'&c='.$TOP_CatID.'"><br></a></nobr></td>
            		<td class="" vAlign="top"><nobr><a href="index.php?mode=editor&method=topic&f='.$TOP_ForumID.'&c='.$TOP_CatID.'"><br></a></nobr></td>';
}
       echo'<form><nobr><br>
              </select></nobr>
            </td></form>';
		if($pg_sql > 0){;
		}
            ;
            echo'
		</table>
		</td>
</table>
</center>';

?>
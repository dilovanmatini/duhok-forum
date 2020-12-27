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

if($mlv == 1 AND $DBMemberPosts < $new_member_min_search){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
	                       
'.$lang[sorry][noo].'
'.$lang[sorry][search].'
'.$lang[sorry][will].'
	                       </font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}
if(members("SEARCH", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][search].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}



function search_count($m,$h){
$Hour = time() - ($h * 3600);
$Sql = $mysql->execute("SELECT * FROM {$mysql->prefix}SEARCH WHERE MEMBER_ID  = '$m' AND DATE >= $Hour");
$Num = mysql_num_rows($Sql);
return $Num;
}



function search_func(){
	global $lang, $Prefix,$icon_group,$max_search;
$search_count = search_count(m_id,24);

if(mlv < 2){
	echo'<br><br>
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>
			<center>
			<form method="post" action="index.php?mode=search&method=find">
			<table cellSpacing="1" cellPadding="4" bgColor="gray" border="0">
				<tr class="fixed">
					<td class="cat" colspan="4"><nobr>البحث</nobr></td>
				</tr>
				<tr class="fixed">
					<td class="cat"><nobr>اكتب نص المراد هنا</nobr></td>
					<td class="list" colspan="3"><input type="text" size="50" name="search"></td>
				</tr>
				<tr class="fixed">
					<td class="cat"><nobr>حالة البحث</nobr></td>
					<td class="list"><input class="small" type="radio" name="type" value="subject" CHECKED>&nbsp;عنوان الموضوع&nbsp;</td>
					<td class="list" colspan="2"><input class="small" type="radio" name="type" value="message">&nbsp;محتوي الموضوع&nbsp;&nbsp;
				</tr>
				<tr class="fixed">
					<td class="cat"><nobr>البحث في</nobr></td>
					<td class="list"><input class="small" type="radio" name="ch_f" value="0" CHECKED>&nbsp;جميع منتديات&nbsp;</td>
					<td class="list" colspan="2"><input class="small" type="radio" name="ch_f" value="1">&nbsp;فقط منتدى&nbsp;&nbsp;
					<select name="forum_id">
						<option value="">&nbsp;&nbsp;-- اختر المنتدى --</option>';
				$cats = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC ", [], __FILE__, __LINE__);
				$num = mysql_num_rows($cats);
				$i = 0;
				while($i < $num){
					$c = mysql_result($cats, $i, "CAT_ID");
					$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$c' ORDER BY F_ORDER ASC ", [], __FILE__, __LINE__);
					$f_num = mysql_num_rows($forums);
					$f_i = 0;
					while($f_i < $f_num){
						$f = mysql_result($forums, $f_i, "FORUM_ID");
						$subject = forums("SUBJECT", $f);
						$hide = forums("HIDE", $f);
						if($hide == 0 OR check_forum_login($f) == 1){
							echo'<option value="'.$f.'">'.$subject.'</option>';
						}
					++$f_i;
					}
				++$i;
				}		
					echo'
					</select>
					</td>
				</tr>
				<tr class="fixed">
					<td class="list_center" colspan="4">
						<input type="submit" value="ابحث">&nbsp;&nbsp;<input type="reset" value="افراغ الخانات">
					</td>
				</tr>
			</table>
			</form>
			</td>
		</tr>
	</table>
	</center>';
}

                 if(mlv > 1){


		echo '
<form name="search" method="post" action="index.php?mode=search&method=find"><center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td>
				<table cellSpacing="2" width="100%" border="0">
					<tr>
						<td class="optionsbar_menus" vAlign="center"><nobr>ابحث عن :</nobr></td>
						<td class="optionsbar_menus"><input type="text" size="80" name="search"></td>
						<td class="optionsbar_menus"><input type="button" onclick="submit_search('.$search_count.','.$max_search.');" value="ابحث">
</td>
						<td class="optionsbar_menus">ابحث عن : <br>
<select name="where">
<option value="all">كل الكلمات</option>
<option value="this">العبارة بالكامل</option>
</select></td>
						<td class="optionsbar_menus">
ابحث في : <br>
<select name="type">
<option value="subject_msg">نص وعناوين المواضيع الحالية</option>
<option value="reply">الردود الحالية فقط</option>
</select></td>';
					
					echo'
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</center>';

echo'
		<center>
		<table cellSpacing="0" cellPadding="0" width="99%" border="0">
			<tr>
				<td>
				<table cellSpacing="2" width="100%" border="0">
					<tr>
						<td class="optionsbar_menus" vAlign="center"><nobr>في مشاركات <br> العضو :</nobr></td>
						<td class="optionsbar_menus"><input type="text" size="40" name="search_m">'.icons($icon_group,"").'</td>
						<td class="optionsbar_menus"><nobr>تحديد فترة البحث : </nobr></td>
						<td class="optionsbar_menus">
<select name="month">
<option value="this">-- الشهر --</option>
<option value="01">يناير</option>
<option value="02">فبراير</option>
<option value="03">مارس</option>
<option value="04">إبريل</option>
<option value="05">مايو</option>
<option value="06">يونيو</option>
<option value="07">يوليو</option>
<option value="08">اغسطس</option>
<option value="09">سبتمبر</option>
<option value="10">أكتوبر</option>
<option value="11">نوفمبر</option>
<option value="12">ديسمبر</option>
</select></td>
						<td class="optionsbar_menus">
<select name="years">
<option value="this">-- السنة --</option>
<option value="2008">2008</option>
</select></td>

<td class="optionsbar_menus" vAlign="center" width="50%">&nbsp;</td>
<td class="optionsbar_menus" vAlign="center"><nobr>عرض المواضيع من : </nobr><br>
<select name="forum_id">
						<option value="all">&nbsp;&nbsp;-- جميع المنتديات --</option>';
				$cats = $mysql->execute("SELECT * FROM {$mysql->prefix}CATEGORY ORDER BY CAT_ORDER ASC ", [], __FILE__, __LINE__);
				$num = mysql_num_rows($cats);
				$i = 0;
				while($i < $num){
					$c = mysql_result($cats, $i, "CAT_ID");
					$forums = $mysql->execute("SELECT * FROM {$mysql->prefix}FORUM WHERE CAT_ID = '$c' ORDER BY F_ORDER ASC ", [], __FILE__, __LINE__);
					$f_num = mysql_num_rows($forums);
					$f_i = 0;
					while($f_i < $f_num){
						$f = mysql_result($forums, $f_i, "FORUM_ID");
						$subject = forums("SUBJECT", $f);
						$hide = forums("HIDE", $f);
						if($hide == 0 OR check_forum_login($f) == 1){
							echo'<option value="'.$f.'">'.$subject.'</option>';
						}
					++$f_i;
					}
				++$i;
				}		
					echo'
					</select>
</td>
';
					
					echo'
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</center>
		<br></form>';

echo '	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10">
<br><br>
أدخل الكلمات التي تريد البحث عنها اعلاه وثم اضغظ على زر البحث .<br><br>
يمكنك ايضا البحث عن مشاركات عضو معين بدون تحديد كلمات للبحث عنها , فقط اكتب اسم العضو . <br><br>
الخيارات التالية تحدد شروط البحث بشكل أدق : <br><br>
<font color="red">
مشاركات عضو معين <br>
تاريخ بداية البحث <br>
تاريخ نهاية البحث <br>
البحث في منتدى معين <br>
نسبة مطابقة البحث <br><br>
</font>
<font color="black">ملاحظة : لادخال تاريخ اضغط على [?] التابعة للخيار</font><br><br>
<table width="30%" border="1">
<tr>
<td colspan="2" style="background-color:black;text-align:center;color:white">عمليات البحث التي قمت بها في أخر 24 ساعة</td>
</tr>
<tr class="normal">
<td>عدد عمليات البحث :</td>
<td style="color:red">'.$search_count.'</td>
</tr>
<tr class="normal">
<td>الحد الاجمالي لك :</td>
<td style="color:red">'.$max_search.'</td>
</tr>
</table><br><br>
	                       </td>
	                   </tr>
	                </table><br><br>';

              }

}

function search_head(){
	global $lang, $img, $search;
			echo'
			<table cellSpacing="2" width="100%" border="0">
				<tr>
					<td>'.icons($search).'</td>
					<td width="100%" vAlign="center"><a href="index.php?mode=active"><font size="3" color="red"><b>&nbsp;&nbsp;البحث</b></font></a></td>';
					refresh_time();
					go_to_forum();
				echo'
				</tr>
			</table>';
}

function search_topics($t){
	global $Mlevel, $DBMemberID, $lang, $icon_reply_topic, $folder_new_locked, $folder_new, $folder_new_hot, $folder;
	
$f = topics("FORUM_ID", $t);
$status = topics("STATUS", $t);
$subject = topics("SUBJECT", $t);
$author = topics("AUTHOR", $t);
$author_name = members("NAME", $author);
$replies = topics("REPLIES", $t);
$views = topics("COUNTS", $t);
$lp_date = topics("LAST_POST_DATE", $t);
$date = topics("DATE", $t);
$lp_author = topics("LAST_POST_AUTHOR", $t);
$lp_author_name = members("NAME", $lp_author);
$hide = topics("HIDE", $t);
$f_subject = forums("SUBJECT", $f);
$allowed = allowed($forum_id, 2);

						echo'
						<tr class="normal">
							<td class="list_small"><a href="index.php?mode=f&f='.$f.'"><b>'.$f_subject.'</b></a></td>
							<td class="list_center"><nobr><a href="index.php?mode=f&f='.$f.'">';
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
							<table cellPadding="0" cellsapcing="0">
								<tr>
									<td><a href="index.php?mode=t&t='.$t.'"><b>'.$subject.'</b></a>&nbsp;'; echo topic_paging($t); echo'</td>
								</tr>
							</table>
							</td>
							<td class="list_small2" noWrap><font  color="green">'.normal_time($date).'</font><br><b>'.link_profile($author_name, $author).'</b></td>
							<td class="list_small2">'.$replies.'</td>
							<td class="list_small2">'.$views.'</td>
							<td class="list_small2" noWrap><font color="red">';
						if($replies > 0){
							echo normal_time($lp_date).'</font><br><b>'.link_profile($lp_author_name, $lp_author).'<b>';
						}
							echo'
							</td>';
						if($Mlevel > 0){
							echo'
							<td class="list_small2">';
							if($allowed == 1 OR $status == 1){
								echo'<a href="index.php?mode=editor&method=reply&t='.$t.'">'.icons($icon_reply_topic, $lang['forum']['reply_to_this_topic'], "hspace=\"2\"").'</a>';
							}
							echo'
							</td>';
						}	
						echo'
						</tr>';
}

function update_search($query,$type,$in_user,$forum,$month,$year){

             if($type == "subject_msg"){
               $type = 0;
              }else{
               $type = 1;
              }
              $date = time();
              $mlv = mlv;
              $m_id = m_id;
          $mysql->execute("insert into {$mysql->prefix}SEARCH SET QUERY = '$query', DATE = '$date', TYPE = '$type', MEMBER_ID = '$m_id', IN_USER = '$in_user', FORUM = '$forum', M_LEVEL = '$mlv', MONTH = '$month', YEAR = '$year' ", [], __FILE__, __LINE__);
 
}


function search_body(){
	global $Mlevel, $DBMemberID, $lang, $_POST, $Prefix;


			echo'
			<table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
				<tr>
					<td>
					<table cellSpacing="1" cellPadding="2" width="100%" border="0">
						<tr>
							<td class="cat" width="15%">المنتدى</td>
							<td class="cat">&nbsp;</td>
							<td class="cat" width="45%">المواضيع</td>
							<td class="cat" width="15%">'.$lang['forum']['author'].'</td>
							<td class="cat">'.$lang['forum']['posts'].'</td>
							<td class="cat">'.$lang['forum']['reads'].'</td>
							<td class="cat" width="15%">'.$lang['forum']['last_post'].'</td>
							<td class="cat" width="1%">'.$lang['forum']['options'].'</td>
						</tr>';
			                  $search = $_POST[search];
				$ch_f = $_POST['ch_f'];
				$forum_id = $_POST['forum_id'];
				$type = $_POST['type'];
				$search_m = trim($_POST['search_m']);
				$month = trim($_POST['month']);
				$years = trim($_POST['years']);
			if($search == "" AND $search_m != ""){
                                                       $search = " ";
                                                       }

			if($search != ""){
				if($ch_f == 1 AND $forum_id > 0){
					$open_sql = "AND FORUM_ID = '$forum_id' ";
				}
				if($type == "subject"){
					$search_in = "SUBJECT";
				}
				if($type == "message"){
					$search_in = "MESSAGE";
				}


                                                                       if(mlv < 2){
				$topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE T_".$search_in." LIKE '%$search%' ".$open_sql." LIMIT 50", [], __FILE__, __LINE__);
                                                                      }

                                                          if(mlv > 1){
				if($forum_id != "all"){
					$open_sql = "AND FORUM_ID = '$forum_id' ";
				}

				if($search_m != ""){
					$m_sql = mysql_fetch_array($mysql->execute("select MEMBER_ID from {$mysql->prefix}MEMBERS                                                            WHERE M_NAME = '$search_m' "));

                                                                                          $m_id = $m_sql['MEMBER_ID'];

                                                                       if($type == "subject_msg"){
					$open_sql .= "AND T_AUTHOR = '$m_id' ";
                                                                       }
                                                                       if($type == "reply"){
					$open_sql .= "AND R_AUTHOR = '$m_id' ";
                                                                        }
			}

// ######### YEARS ############

                  if($years != "this"){

                         if($type == "subject_msg"){
                    $open_sql .= "AND YEAR(FROM_UNIXTIME(T_DATE)) = '$years'  ";
                          }
                          if($type == "reply"){
                      $open_sql .= "AND  YEAR(FROM_UNIXTIME(R_DATE)) = '$years'  ";
                           }
                }

// ######### MONTH ############

                  if($month != "this"){

                        if($type == "subject_msg"){
                      $open_sql .= "AND MONTH(FROM_UNIXTIME(T_DATE)) = '$month'  ";
                         }
                       if($type == "reply"){
                    $open_sql .= "AND  MONTH(FROM_UNIXTIME(R_DATE)) = '$month'  ";
                       }

             }

				if($type == "subject_msg"){
					$search_in = "T_SUBJECT LIKE '%$search%' ".$open_sql." OR T_MESSAGE LIKE '%$search%' ".$open_sql." ";
                                                                                        $topics = $mysql->execute("SELECT * FROM {$mysql->prefix}TOPICS WHERE ".$search_in."  LIMIT 50", [], __FILE__, __LINE__);

				}
				if($type == "reply"){

$topics = $mysql->execute("SELECT DISTINCT TOPIC_ID from {$mysql->prefix}REPLY WHERE R_MESSAGE LIKE '%$search%' ".$open_sql." LIMIT 50", [], __FILE__, __LINE__);
				}

update_search($search,$type,$m_id,$forum_id,$month,$years);				
}

				$num = mysql_num_rows($topics);
				if($num <= 0){
						echo'
						<tr>
							<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>لم يتم العثور على اي موضوع يطابق للنص الذي دخلت<br><br><br></td>
						</tr>';
				}
				else{
					$i = 0;
					while ($i < $num){
						$t = mysql_result($topics, $i, "TOPIC_ID");
						$t_hide = topics("HIDE", $t);
						$t_author = topics("AUTHOR", $t);
						$f = topics("FORUM_ID", $t);
						$f_hide = forums("HIDE", $f);
						$check_forum_login = check_forum_login($f);
						if(($f_hide == 0 AND $t_hide == 0) OR ($f_hide == 1 AND $t_hide == 0 AND $check_forum_login == 1) OR ($f_hide == 0 AND $t_hide == 1 AND allowed($f, 2) == 1) OR ($f_hide == 0 AND $t_hide == 1 AND $DBMemberID == $t_author) OR ($f_hide == 1 AND $t_hide == 1 AND $DBMemberID == $t_author AND $check_forum_login == 1) OR ($f_hide == 1 AND $t_hide == 1 AND allowed($f, 2) == 1 AND $check_forum_login == 1)){
							search_topics($t);
						}
					++$i;
					}
				}
					echo'
					</table>
					</td>
				</tr>';
			}
			else{
						echo'
						<tr>
							<td class="f1" vAlign="center" align="middle" colspan="20"><br><br>أنت لم دخلت اي نص للبحث عنها<br><br><br></td>
						</tr>';
			}
			echo'
			</table>';
}

function search_find(){
	global $lang;
	echo'
	<center>
	<table cellSpacing="0" cellPadding="0" width="99%" border="0">
		<tr>
			<td>';
			search_head();
			search_body();
			echo'
			</td>
		</tr>
	</table>
	</center>';
}
if($Mlevel > 0){
	if($method == ""){
		search_func();
	}
	if($method == "find"){
		search_find();
	}
}
else{
	go_to("index.php");
}
?>

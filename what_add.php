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

//---------------------------------------------- PAGING -----------------------------------------

if(!isset($_GET['pg']))
{
$pag = 1;
}
else
{
$pag = $_GET['pg'];
}

$start = (($pag * $max_page) - $max_page);
$total_res = mysql_result($mysql->execute("SELECT COUNT(O_FORUMIDA) FROM {$mysql->prefix}CEP_FORUM "),0);
$total_col = ceil($total_res / $max_page);

if($pg == "p"){

$pg = $_POST["numpg"];


 echo'<script language="JavaScript" type="text/javascript">
 window.location = "index.php?mode=what_add&method=forum&type=options&pg='.$pg.'";
 </script>';

}

function paging($total_col, $pag){

		echo '
        <form method="post" action="index.php?mode=what_add&method=forum&type=options&pg=p">
        <td class="optionsbar_menus">

		<b>الصفحة :</b>
        <select name="numpg" size="1" onchange="submit();">';

        for($i = 1; $i <= $total_col; $i++){
            if(($pag) == $i){
		        echo '<option selected value="'.$i.'">'.$i.' من '.$total_col.'</option>';
            }
            else {
		        echo '<option value="'.$i.'">'.$i.' من '.$total_col.'</option>';
            }
        }

		echo '
        </select>

		</td>
		</form>';

}
//---------------------------------------------- PAGING -----------------------------------------

			if(mlv == 4){


if($method == "forum"){

$oforum_ida = $f;

if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=what_add&method=forum&type=add">

	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>'.$lang['other_cat_forum']['add_forum1'].'</nobr></td>
			</tr>
		<input type="hidden"  value="'.$DBMemberID.'"  name="forum_namea" size="80"></td>
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


	$queryF = "INSERT INTO {$mysql->prefix}CEP_FORUM (O_FORUMIDA, O_FORUM_NAMEA, O_FORUM_URLA ) VALUES (NULL, '$Forum_Namea', '$Forum_Urla')";
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
}

if($type == "options"){

echo'
<center>
<table class="optionsbar" dir="rtl" cellSpacing="2" width="99%">
	<tr>
		<td class="optionsbar_title" Align="middle" vAlign="center" width="100%">الإهدائات</td>';
if($total_res){
  paging($total_col, $pag);
}
  go_to_forum();
  echo '
    </tr>
</table>
</center><br>';

	echo'	<table class="grid" dir="rtl" cellSpacing="0" cellPadding="0" width="80%" align="center" border="0">
			<tr>
				<td>
				<table dir="rtl" cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" width="30%">الكاتب</td>
						<td class="cat" width="10%">الأيبي</td>
						<td class="cat" width="20%">التاريخ</td>
						<td class="cat" width="320%">الإهداء</td>
						<td class="cat" width="10%">خيارات</td>
					</tr>';

	$queryDF = "SELECT * FROM {$mysql->prefix}CEP_FORUM ORDER BY O_FORUMIDA ASC LIMIT $start, $max_page ";
	$resultDF = $mysql->execute($queryDF, $connection, [], __FILE__, __LINE__);

	$num = mysql_num_rows($resultDF);


	if($num <= 0){
                      echo'
                      <tr>
                          <td class="f1" vAlign="center" align="middle" colspan="10"><br><br>'.$lang['home']['no_cat'].'<br><br><br></td>
                      </tr>';
	}


$i=0;
while ($i < $num){

    $OForum_IDa = mysql_result($resultDF, $i, "O_FORUMIDA");
    $OForum_Namea = mysql_result($resultDF, $i, "O_FORUM_NAMEA");
    $OForum_Urla = mysql_result($resultDF, $i, "O_FORUM_URLA");
    $OForum_ip = mysql_result($resultDF, $i, "O_FORUM_IP");
    $OForum_Date = mysql_result($resultDF, $i, "O_FORUM_DATE");
$Name = link_profile(member_name($OForum_Namea), $OForum_Namea);
echo'
	<tr class="'.normal.'">
		<td class="list" align="center">'.$Name.'</td>
		<td class="list" align="center" ><a target="_blank" href="http://api.hostip.info/?ip='.$OForum_ip.'">
		'.$OForum_ip.'</td> </a>';
					echo'	<td class="list" align="center">'.normal_time($OForum_Date).' </td>';

		  if(substr($OForum_Urla, 30, 1000)){
		  echo'
		<td class="list" align="center">'.strip_tags(substr($OForum_Urla, 0, 30)).' <font color="gray" size="3">...</font>
</font></td>';
		}
		else{
				  echo'
				<td class="list" align="center">'.$OForum_Urla.'</td>';
		}

echo'

		<td class="list_small">';
	echo'<a href="index.php?mode=requestmon&aid='.$OForum_Namea.'&ihdaa='.$OForum_IDa.'"><img hspace="2" alt="'.$lang['ihdaa']['moderate'].'" src="'.$icon_moderation.'" border="0"></a>';
echo'<a href="index.php?mode=what_add&method=forum&type=edit&f='.$OForum_IDa.'"><img hspace="2" alt="'.$lang['forum']['edit_topic'].'" src="'.$icon_edit.'" border="0"></a>';
echo'<a href="index.php?mode=what_add&method=forum&type=delete&f='.$OForum_IDa.'"><img hspace="2" alt="'.$lang['forum']['edit_topic'].'" src="'.$icon_trash.'" border="0"></a>';

	echo'	</td>';

    ++$i;
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
}

if($type == "edit"){

$queryEF = "SELECT * FROM {$mysql->prefix}CEP_FORUM WHERE O_FORUMIDA = '$oforum_ida' ";
$resultEF = $mysql->execute($queryEF, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultEF) > 0){
$rsEF=mysql_fetch_array($resultEF);

$OForum_Namea = $rsEF['O_FORUM_NAMEA'];
$OFORUM_Urla = $rsEF['O_FORUM_URLA'];

}

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=what_add&method=forum&type=insert">
<input type="hidden" name="e_forum_ida" value="'.$oforum_ida.'">

	<tr class="fixed">
		<td class="cat" colspan="2">تعديل الإهدائات<nobr></nobr></td>
		<input type="hidden" name="e_forum_namea" value="'.$OForum_Namea.'" size="80"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_url1'].'</nobr></td>
		<td class="userdetails_data">
			<textarea style="WIDTH: 600;HEIGHT: 250;" name="e_forum_urla" rows="1"  cols="20">'.$OFORUM_Urla.'</textarea>
 	<tr class="fixed">
		<td align="middle" colspan="2">
		<input type="submit" value="'.$lang['other_cat_forum']['cat_ook'].'">
		&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "insert"){

$oforum_ida = $_POST["e_forum_ida"];
$EForum_Namea = $_POST["e_forum_namea"];
$EForum_Urla = $_POST["e_forum_urla"];

	$queryCE = "UPDATE {$mysql->prefix}CEP_FORUM SET O_FORUM_NAMEA = ('$EForum_Namea'), O_FORUM_URLA = ('$EForum_Urla') WHERE O_FORUMIDA = '$oforum_ida' ";
	$mysql->execute($queryCE, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تغيير البيانات بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php?mode=what_add&method=forum&type=options">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

if($type == "delete"){

		$queryFD = "DELETE FROM {$mysql->prefix}CEP_FORUM WHERE O_FORUMIDA = '$oforum_ida' ";
		$mysql->execute($queryFD, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_cat_is_deleted1'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php?mode=what_add&method=forum&type=options">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}

}

mysql_close();

?>
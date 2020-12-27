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
$total_res = mysql_result($mysql->execute("SELECT COUNT(O_FORUMID) FROM {$mysql->prefix}OTHERS_FORUM "),0);
$total_col = ceil($total_res / $max_page);

if($pg == "p"){

$pg = $_POST["numpg"];


 echo'<script language="JavaScript" type="text/javascript">
 window.location = "index.php?mode=other_cat_add&method=forum&type=options&pg='.$pg.'";
 </script>';

}

function paging($total_col, $pag){

		echo '
        <form method="post" action="index.php?mode=other_cat_add&method=forum&type=options&pg=p">
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

if($Mlevel == 4){

if($method == "cat"){

if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=other_cat_add&method=cat&type=add">

	<tr class="fixed">
		<td class="cat" colspan="2">'.$lang['other_cat_forum']['add_cat'].'<nobr></nobr></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_name'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="add_cat_name" size="40"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_url'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="add_cat_url" size="40"></td>
	</tr>

 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['other_cat_forum']['ok'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "add"){

$queryCA = "SELECT * FROM {$mysql->prefix}OTHERS_CAT ";
$resultCA = $mysql->execute($queryCA, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultCA) > 0){
$rsCA=mysql_fetch_array($resultCA);

$CCat_Name = $rsCA['O_CAT_NAME'];
}

	if($CCat_Name != ""){
                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['other_cat_forum']['error'].'</font><br><br>
                           <a href="JavaScript:history.go(-1)">'.$lang['all']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}
	else {

$Cat_Name = $_POST["add_cat_name"];
$Cat_Url = $_POST["add_cat_url"];

	$queryC = "INSERT INTO {$mysql->prefix}OTHERS_CAT (O_CATID, O_CAT_NAME, O_CAT_URL) VALUES (NULL, '$Cat_Name', '$Cat_Url')";
	$mysql->execute($queryC, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['other_cat_forum']['the_cat_was_added'].'</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
	}

}

if($type == "edit"){

$query = "SELECT * FROM {$mysql->prefix}OTHERS_CAT ";
$result = $mysql->execute($query, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($result) > 0){
$rs=mysql_fetch_array($result);

$OCat_Name = $rs['O_CAT_NAME'];
$OCat_Url = $rs['O_CAT_URL'];
}

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=other_cat_add&method=cat&type=insert">

	<tr class="fixed">
		<td class="cat" colspan="2">'.$lang['other_cat_forum']['add_cat'].'<nobr></nobr></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_name'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="cat_name" value="'.$OCat_Name.'" size="40"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_url'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="cat_url" value="'.$OCat_Url.'" size="40"></td>
	</tr>

 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['other_cat_forum']['ok'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "insert"){

$ECat_Name = $_POST["cat_name"];
$ECat_Url = $_POST["cat_url"];

	$queryCE = "UPDATE {$mysql->prefix}OTHERS_CAT SET O_CAT_NAME = ('$ECat_Name'), O_CAT_URL = ('$ECat_Url') ";
	$mysql->execute($queryCE, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تغيير البايانات بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="2; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

if($type == "delete"){

		$queryCD = "DELETE FROM {$mysql->prefix}OTHERS_CAT ";
		$mysql->execute($queryCD, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_cat_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

}

if($method == "forum"){

$oforum_id = $f;

if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=other_cat_add&method=forum&type=add">

	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>'.$lang['other_cat_forum']['add_forum'].'</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['forum_name'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="forum_name" size="40"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['forum_url'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="forum_url" size="40"></td>
	</tr>

 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['other_cat_forum']['ok'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "add"){

$Forum_Name = $_POST["forum_name"];
$Forum_Url = $_POST["forum_url"];

	$queryF = "INSERT INTO {$mysql->prefix}OTHERS_FORUM (O_FORUMID, O_FORUM_NAME, O_FORUM_URL) VALUES (NULL, '$Forum_Name', '$Forum_Url')";
	$mysql->execute($queryF, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['other_cat_forum']['the_forum_was_added'].'</font><br><br>
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
<table class="optionsbar" dir="rtl" cellSpacing="2" width="99%" border="0" id="table11">
	<tr>
		<td class="optionsbar_title" Align="middle" vAlign="center" width="100%">خيارات المنتديات الفرعية</td>';
if($total_res){
  paging($total_col, $pag);
}
  go_to_forum();
  echo '
    </tr>
</table>
</center><br>';

	echo'	<table class="grid" dir="rtl" cellSpacing="0" cellPadding="0" width="30%" align="center" border="0">
			<tr>
				<td>
				<table dir="rtl" cellSpacing="1" cellPadding="2" width="100%" border="0">
					<tr>
						<td class="cat" colSpan="1" width="1%">الرقم</td>
						<td class="cat" width="10%">اسم المنتدى</td>
						<td class="cat" width="6%">خيارات</td>
					</tr>';

	$queryDF = "SELECT * FROM {$mysql->prefix}OTHERS_FORUM ORDER BY O_FORUMID ASC LIMIT $start, $max_page ";
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

    $OForum_ID = mysql_result($resultDF, $i, "O_FORUMID");
    $OForum_Name = mysql_result($resultDF, $i, "O_FORUM_NAME");
    $OForum_Url = mysql_result($resultDF, $i, "O_FORUM_URL");

echo'
	<tr class="'.normal.'">
		<td class="list_small" noWrap>'.$OForum_ID.'</a></td>
		<td class="list_small">'.$OForum_Name.'</td>
		<td class="list_small">';
echo'<a href="index.php?mode=other_cat_add&method=forum&type=edit&f='.$OForum_ID.'"><img hspace="2" alt="'.$lang['forum']['edit_topic'].'" src="'.$icon_edit.'" border="0"></a>';
echo'<a href="index.php?mode=other_cat_add&method=forum&type=delete&f='.$OForum_ID.'"><img hspace="2" alt="'.$lang['forum']['edit_topic'].'" src="'.$icon_trash.'" border="0"></a>';
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

$queryEF = "SELECT * FROM {$mysql->prefix}OTHERS_FORUM WHERE O_FORUMID = '$oforum_id' ";
$resultEF = $mysql->execute($queryEF, $connection, [], __FILE__, __LINE__);

if(mysql_num_rows($resultEF) > 0){
$rsEF=mysql_fetch_array($resultEF);

$OForum_Name = $rsEF['O_FORUM_NAME'];
$OFORUM_Url = $rsEF['O_FORUM_URL'];
}

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="60%">
<form method="post" action="index.php?mode=other_cat_add&method=forum&type=insert">
<input type="hidden" name="e_forum_id" value="'.$oforum_id.'">

	<tr class="fixed">
		<td class="cat" colspan="2">تعديل المنتديات الفرعية<nobr></nobr></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_name'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="e_forum_name" value="'.$OForum_Name.'" size="40"></td>
	</tr>
	<tr class="fixed">
		<td class="cat"><nobr>'.$lang['other_cat_forum']['cat_url'].'</nobr></td>
		<td class="userdetails_data"><input type="text" name="e_forum_url" value="'.$OFORUM_Url.'" size="40"></td>
	</tr>

 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="'.$lang['other_cat_forum']['ok'].'">&nbsp;&nbsp;&nbsp;<input type="reset" value="'.$lang['other_cat_forum']['reset'].'"></td>
	</tr>
</form>
</table>
</center>';

}

if($type == "insert"){

$oforum_id = $_POST["e_forum_id"];
$EForum_Name = $_POST["e_forum_name"];
$EForum_Url = $_POST["e_forum_url"];

	$queryCE = "UPDATE {$mysql->prefix}OTHERS_FORUM SET O_FORUM_NAME = ('$EForum_Name'), O_FORUM_URL = ('$EForum_Url') WHERE O_FORUMID = '$oforum_id' ";
	$mysql->execute($queryCE, $connection, [], __FILE__, __LINE__);

                    echo'
	                <center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تغيير البيانات بنجاح</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php?mode=other_cat_add&method=forum&type=options">
                           <a href="index.php">'.$lang['all']['click_here_to_go_home'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}

if($type == "delete"){

		$queryFD = "DELETE FROM {$mysql->prefix}OTHERS_FORUM WHERE O_FORUMID = '$oforum_id' ";
		$mysql->execute($queryFD, $connection, [], __FILE__, __LINE__);
  
	                echo'<center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>'.$lang['delete']['the_cat_is_deleted'].'</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php?mode=other_cat_add&method=forum&type=options">
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
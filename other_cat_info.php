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

//------------------------------------------ OTHERS CAT --------------------------------------------

$result = $mysql->execute("SELECT * FROM {$mysql->prefix}OTHERS_CAT ", [], __FILE__, __LINE__)->fetch();

if(is_array($result)){
	$Cat_Name = $result['O_CAT_NAME'];
	$Cat_Url = $result['O_CAT_URL'];
}

$others_cat = "<a target='_blank' href='http://".$Cat_Url."'><font style='font-size: 15px; vertical-align: middle; font-weight: 700'>".$Cat_Name."</font></a></nobr>";

//------------------------------------------ OTHERS CAT --------------------------------------------

//----------------------------------------- OTHERS FORUM -------------------------------------------

$sql = $mysql->execute("SELECT * FROM {$mysql->prefix}OTHERS_FORUM ORDER BY O_FORUMID ASC", [], __FILE__, __LINE__);

$iOF=0;
while ( $result = $sql->fetch()){

	$Forum_Name = $result["O_FORUM_NAME"];
	$Forum_Url = $result["O_FORUM_URL"];

	if($sql->rowCount() == 1){
	$others_forum = "<nobr><a class='menu' target='_blank' href='http://".$Forum_Url."'>".$Forum_Name."</a></nobr>";
	}
	else {
	$others_forum = $others_forum;
	if($others_forum != ""){
	$others_forum .= "<nobr>  <font size='3' color='red'>&nbsp;*</font>  ";
	}
	$others_forum .= "<a class='menu' target='_blank' href='http://".$Forum_Url."'>".$Forum_Name."</a></nobr>";
	}
	++$iOF;
}

//----------------------------------------- OTHERS FORUM -------------------------------------------

if($Cat_Name != ""){

echo'
<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
        <table class="grid" cellSpacing="1" cellPadding="0" width="100%" border="0">
	<tr>
		<td class="cat" width="99%" align="right">'.$others_cat.'</td>';

                      if($Mlevel == 4){
	echo'	<td class="cat" vAlign="middle" align="middle" width="1%">';
	echo'<a href="index.php?mode=other_cat_add&method=forum">'.icons($folder_other_forum, $lang['other_cat_forum']['add_forum'], "hspace=\"3\"").'</a>';
	echo'<a href="index.php?mode=other_cat_add&method=cat&type=edit">'.icons($folder_new_edit, $lang['home']['edit_cat'], "hspace=\"3\"").'</a>';
	echo'<a href="index.php?mode=other_cat_add&method=cat&type=delete">'.icons($folder_new_delete, $lang['home']['delete_cat'], "hspace=\"3\"").'</a>
		</td>';
                      }
echo'	</tr>
        </table>
        	</td>
    	</tr>
</table>
</center>';

echo'<center>
<table cellSpacing="0" cellPadding="0" width="99%" border="0">
	<tr>
		<td>
	<table class="grid" cellSpacing="1" cellPadding="0" width="100%" border="0">
	<tr class="normal">
		<td dir="'.$lang['global']['dir'].'" class="list" vAlign="middle" style="FONT-SIZE: 75%">'.$others_forum.'</td>';

                      if($Mlevel == 4){
	echo'	<td class="list" vAlign="middle" align="middle" width="1%">';
	echo'<a href="index.php?mode=other_cat_add&method=forum&type=options">'.icons($folder_edit, $lang['home']['edit_forum'], "hspace=\"3\"").'</a>
		</td>';
                      }
echo'	</tr>
	</table>
		</td>
	</tr>
</table>';

}



?>
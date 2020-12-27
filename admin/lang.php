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

if($CPMlevel == 4){

if($method == ""){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=lang&type=set">
	<tr class="fixed">
		<td class="cat" colspan="5"><nobr>اعدادات اللغة</nobr></td>
	</tr>';
 
        $ch_lang = $mysql->execute("SELECT * FROM {$mysql->prefix}LANGUAGE ", [], __FILE__, __LINE__);
        $lang_num = mysql_num_rows($ch_lang);

        if($lang_num > 0){

            $lang_i = 0;
            while ($lang_i < $lang_num){

                $lang_id = mysql_result($ch_lang, $lang_i, "L_ID");
                $lang_file_name = mysql_result($ch_lang, $lang_i, "L_FILE_NAME");
                $lang_name = mysql_result($ch_lang, $lang_i, "L_NAME");

                echo'
                <input type="hidden" name="lang_id[]" value="'.$lang_id.'">
	        	<tr class="fixed">
	        		<td class="cat"><nobr>اسم اللغة</nobr></td>
	        		<td class="middle"><input type="text" name="lang_name[]" size="15" value="'.$lang_name.'"></td>
                    <td class="cat"><nobr>اسم ملف اللغة</nobr></td>
                    <td class="middle"><input type="text" name="lang_file[]" size="15" value="'.$lang_file_name.'"></td>
                    <td align="middle">
                    <table>
                        <tr>
                            <td class="optionsbar_menus">
                                <font size="3"><nobr><a href="cp_home.php?mode=lang&method=delete&id='.$lang_id.'">حذف اللغة</a></nobr></font>
                            </td>
                        </tr>
                    </table>
                    </td>
	        	</tr>';

            ++$lang_i;
            }
        }
        else {
            echo'
	        <tr class="fixed">
		        <td class="list_center" colspan="5"><br>لا توجد أي لغة<br><br></td>
	        </tr>';
 
        }
if($lang_num > 0){
    echo'
 	<tr class="fixed">
		<td align="middle" colspan="5"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>';
}
echo'
</form>
</table>
</center>';


 }

 if($type == "set"){

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

$lang_id = $_POST["lang_id"];
$lang_name = $_POST["lang_name"];
$lang_file = $_POST["lang_file"];


$i_l = 0;
$f_l = 0;
$n_l = 0;
while($i_l < count($lang_id)){

		$updatingLang = $mysql->execute("UPDATE {$mysql->prefix}LANGUAGE SET L_FILE_NAME = '".$lang_file[$f_l]."', L_NAME = '".$lang_name[$n_l]."' WHERE L_ID = ".$lang_id[$i_l]." ");
        $n_l++;
        $f_l++;
        $i_l++;

}

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=lang">
                           <a href="cp_home.php?mode=lang">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}



if($method == "add"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=lang&&method=add&type=set">
	<tr class="fixed">
		<td class="cat" colspan="2"><nobr>إضافة لغة جديدة</nobr></td>
	</tr>
	<tr class="fixed">
		<td class="list"><nobr>اسم اللغة</nobr></td>
		<td><input type="text" name="lang_name" size="20"></td>
	</tr>
 	<tr class="fixed">
		<td class="list"><nobr>اسم ملف اللغة</nobr></td>
		<td><input type="text" dir="ltr" name="lang_file" size="20"></td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="2"><input type="submit" value="إضافة اللغة">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';

 }

 if($type == "set"){

    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

$lang_name = $_POST["lang_name"];
$lang_file = $_POST["lang_file"];

     $query = "INSERT INTO {$mysql->prefix}LANGUAGE (L_ID, L_FILE_NAME, L_NAME) VALUES (NULL, ";
     $query .= " '$lang_file', ";
     $query .= " '$lang_name') ";

     $mysql->execute($query, $connection, [], __FILE__, __LINE__);


                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم إضافة لغة بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=lang">
                           <a href="cp_home.php?mode=lang">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }
 }
}

if($method == "lang"){

 if($type == ""){

echo'
<center>
<table class="grid" border="0" cellspacing="1" cellpadding="4" width="80%">
<form method="post" action="cp_home.php?mode=lang&method=lang&type=insert_data">
	</tr>
 	<tr class="fixed">
 			<td class="cat" colspan="4"><nobr>خيارات اللغة الإفتراضية</nobr></td>
 	<tr class="fixed">

		<td class="list"><nobr>اللغة الإفتراضية</nobr></td>
		<td class="middle" colspan="3">
		
        <select class="insidetitle" style="WIDTH: 150px" name="lang_name">';
        $ch_lang = $mysql->execute("SELECT * FROM {$mysql->prefix}LANGUAGE ", [], __FILE__, __LINE__);
        $lang_num = mysql_num_rows($ch_lang);

        if($lang_num > 0){

            $lang_i = 0;
            while ($lang_i < $lang_num){

                $lang_id = mysql_result($ch_lang, $lang_i, "L_ID");
                $lang_file_name = mysql_result($ch_lang, $lang_i, "L_FILE_NAME");
                $lang_name = mysql_result($ch_lang, $lang_i, "L_NAME");

                echo'<option value="'.$lang_file_name.'" '.check_select($default_language, $lang_file_name).'>'.$lang_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';

            ++$lang_i;
            }
        }
        else {
            echo'<option value="">لا توجد أي لغة</option>';
        }
        echo'
        </td>
	</tr>
 	<tr class="fixed">
		<td align="middle" colspan="4"><input type="submit" value="إدخال بيانات">&nbsp;&nbsp;&nbsp;<input type="reset" value="إرجاع نص الأصلي"></td>
	</tr>
</form>
</table>
</center>';
 }

 if($type == "insert_data"){


    if($error != ""){
	                echo'<br><center>
	                <table bordercolor="#ffffff" width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>خطأ<br>'.$error.'..</font><br><br>
	                       <a href="JavaScript:history.go(-1)">-- إضغط هنا للرجوع --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }


    if($error == ""){

updata_mysql("DEFAULT_LANGUAGE", $_POST["lang_name"]);



                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم تعديل بيانات بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=lang&method=lang">
                           <a href="cp_home.php?mode=lang&method=lang">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
    }

 }

}

if($method == "delete"){

$mysql->execute("DELETE FROM {$mysql->prefix}LANGUAGE WHERE L_ID = '$id' ", [], __FILE__, __LINE__);

                    echo'<br><br>
	                <center>
	                <table bordercolor="#ffffff" width="50%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5"><br>تم حذف اللغة بنجاح..</font><br><br>
                           <meta http-equiv="Refresh" content="1; URL=cp_home.php?mode=lang">
                           <a href="cp_home.php?mode=lang">-- انقر هنا للذهاب الى صفحة الاصلية --</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center>';
}
}

else {
    go_to("index.php");
}
?>

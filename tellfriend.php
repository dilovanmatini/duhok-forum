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

if(!$t) redirect();
if(!topics("SUBJECT", $t)) redirect();
if(chk_load_topic(t) == 1){

if(members("SEND_TOPICS", $DBMemberID) == 1  ){
	                echo'<br><center>
	                <table width="99%" border="1">
	                   <tr class="normal">
	                       <td class="list_center" colSpan="10"><font size="5" color="red"><br>
'.$lang[permission][sorry].'
'.$lang[permission][send_topics].'<br>
'.$lang[permission][contact].'
</font><br><br>
	                       <a href="JavaScript:history.go(-1)">'.$lang['profile']['click_here_to_back'].'</a><br><br>
	                       </td>
	                   </tr>
	                </table>
	                </center><xml>';
exit();
}




if(!$_POST['tellfriend']){
echo '
<script type="text/javascript">
function go(){
if(form.tellfriend.value.length == 0)
	{
	confirm(necessary_to_insert_email);
	return;
	}

if(!/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/.test(form.tellfriend.value))
	{
	confirm(necessary_to_insert_true_email);
	return;
	}
form.submit();
}
</script>
<table border="0" cellpadding="0" cellspacing="0"dir="rtl" width="99%">
  <tbody>
    <tr>
      <td>
      <center>إخبار صديق عن موضوع:<br>
      <font color="red" size="+2">'.topics("SUBJECT", $t).'</font>
      <form name="form" action="index.php?mode=tellfriend&t='.$t.'"
 method="post">
        <table bgcolor="gray" border="0"
 cellpadding="4" cellspacing="1">
          <tbody>
            <tr class="fixed">
              <td class="optionheader">لإخبار
صديق لك عن الموضوع <br>
أدخل بريده الإلكتروني<br>
وثم إضغط على الزر أدناه: <br>
              <input class="insidetitle" style="width: 250px;" name="tellfriend">
<input value="'.$t.'" name="t" type="hidden">
</td>
</tr>  <tr class="fixed">
 <td class="list_center"><input value="أرسل الموضوع" type="button" onclick="go()"></td>
            </tr>
          </tbody>
        </table>
      </form>
      </center>
      </td>
    </tr>
  </tbody>
  <table class="footerbar" cellpadding="0"
 cellspacing="1" dir="rtl" width="100%">
    <tbody>
      <tr>
      </tr>
    </tbody>
  </table>';
}

if($_POST['tellfriend']){
$thread = intval($_POST['t']);
$top = topics("SUBJECT", $thread);
$email = $_POST['tellfriend'];
$ref = $_SERVER["REQUEST_URI"];
$ref = str_replace("tellfriend","t",$ref);
$url = "http://".$http_host.$ref;

 $pf_to = $email;
 $pf_sub = 'رسالة من  منتديات '.$forum_title.' : موضوع : '.$top.'';
 $pf_msg = 'الى :'.$email.'\n';
 $pf_msg .= 'هذه رسالة لك من : '.m_name.' \n';
 $pf_msg .= 'وهو عضو في منتديات '.$forum_title.' : ويود ان يلفت انتابهك الى موضوع قد يثير اهتمامك على الوصلة التالية \n';
 $pf_msg .= ''.$url.'';
 $pf_from = $rs['M_EMAIL'];
 
 mail($pf_to, $pf_sub, $pf_msg, "From: ".$pf_from);

	echo'<br>
	<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><br><font size="3">تم إرسال بريد الكتروني الى صديقك حسب العنوان الذي ادخلته.</font><br><br><br>
			</td>
		</tr>
	</table>
	</center>';

}}

?>
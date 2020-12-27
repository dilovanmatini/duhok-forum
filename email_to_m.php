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

if(mlv < 2) redirect();
if(!$id) redirect();
if(!member_name($id)) redirect();

if(!$_POST['send_email']){
echo '
<table border="0" cellpadding="0" cellspacing="0"dir="rtl" width="99%">
  <tbody>
    <tr>
      <td>
      <center>ارسال رسالة عبر البريد للعضو : <br>
      <font color="red" size="+2">'.member_name($id).'</font>
      <form name="form" action="index.php?mode=email_to_m&id='.$id.'"
 method="post">
        <table bgcolor="gray" border="0"
 cellpadding="4" cellspacing="1">
          <tbody>
            <tr class="fixed">
              <td class="optionheader">محتوى الرسالة : <br>
              <textarea name="send_email" rows="7" cols="50"></textarea>
<input value="'.$id.'" name="id" type="hidden">
<input value="'.members("EMAIL",$id).'" name="email" type="hidden">
</td>
</tr>  <tr class="fixed">
 <td class="list_center"><input value="أرسل الرسالة" type="submit"></td>
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

if($_POST['send_email']){
$m = intval($_POST['id']);
$send_email = trim(htmlspecialchars($_POST['send_email']));
$email = $_POST['email'];

 $pf_to = $email;
 $pf_sub = 'رسالة من العضو '.m_name.' الى العضو '.member_name($m).' ';
 $pf_msg = $send_email.'\n';

 $pf_from = $rs['M_EMAIL'];
 
 mail($pf_to, $pf_sub, $pf_msg, "From: ".$pf_from);

	echo'<br>
	<center>
	<table width="99%" border="1">
		<tr class="normal">
			<td class="list_center" colSpan="10"><br><br><font size="3">تم إرسال بريد الكتروني الى العضو '.member_name($m).' .</font><br><br><br>
			</td>
		</tr>
	</table>
	</center>';

}

?>
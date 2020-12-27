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

    $Name = link_profile(member_name($DBMemberID), $DBMemberID);
                    echo'<center>
<meta http-equiv="Refresh" content="2; URL=index.php">
                           <table class="grid" cellSpacing="0" cellPadding="0" width="100%" align="center" border="0">
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="2" width="100%" border="0">
				<tr>
					<td class="cat">
					<p align="right"><b>إعادة التوجيه . . .</b></td>
				</tr>
				<tr class="normal">
					<td class="list_center" vAlign="center">
					<p align="center"><strong>نورت موقعك ومنتداك.</span> 
					<span lang="ar-tn"><font color="#FF0000">'.$Name.'
					</font> </span>&nbsp;أهلا وسهلا بك مرة أخرى يا </strong>
					<font size="5"><br></font><br>
                           <meta http-equiv="Refresh" content="1; URL=index.php">
                       <a href="index.php"> -- إذا كان متصفحك لا يدعم الانتقال التلقائي اضغط هنا -- .</a><br><br>

					</td>
						                       </table>
			</td>
		</tr>
	</form>
</table>
	                </center>';
	                
?>
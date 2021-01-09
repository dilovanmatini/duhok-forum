<?php
/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

const _df_script = "update";
const _df_filename = "update.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

$Template->header();

if( type == 'userdetails' && $DF->getCookie('importantData') != 1 && ulv > 0 ){
	$country = [];
	require('countries.php');
	$cCode = array_keys($country);
	$errCountry = in_array( ucountry, $cCode ) ? false : true;
	$first_year = _this_year - 100;
	$last_year = _this_year - 12;
	$ex = explode( "-", ubrithday );
	$year = intval($ex[0]);
	$errBirthday = ( $year <= $first_year || $year > $last_year ) ? true : false;
	$errSex = ( usex == 0 ? true : false );
	?>
	<script type="text/javascript">
	var errCountry=<?=($errCountry ? 'true' : 'false')?>,errBirthday=<?=($errBirthday ? 'true' : 'false')?>,errSex=<?=($errSex ? 'true' : 'false')?>;
	DF.doSubmit=function(frm){
		var foundError=false;
		if( errCountry && frm.userCountry.value.length == 0 ){
			$I('#userCountryMsg').innerHTML=this.msgBox('نرجوا ان تختار دولة من قائمة الدول','red',1,0,true).code;
			foundError = true;
		}
		if( errBirthday && frm.userBirthdayYear.selectedIndex == 0 ){
			$I('#userBirthdayMsg').innerHTML=this.msgBox('نرجوا أن تختار تاريخ ولادتك الصحيحة.','red',1,0,true).code;
			foundError = true;
		}
		if( errSex && dm.parseInt( $('.details_user_sex').rval() ) < 1 ){
			$I('#userSexMsg').innerHTML=this.msgBox('يجب ان تختار الجنس','red',1,0,true).code;
			foundError = true;
		}
		if( !foundError ){
			frm.submit();
		}
	};
	</script>
	<?php
	echo"<br>
	<table width=\"50%\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\">
	<form method=\"post\" action=\"update.php?type=updateuserdetails\">
		<tr>
			<td class=\"asHeader\">بيانات ضرورية</td>
		</tr>
		<tr>
			<td class=\"asNormal\" style=\"padding:15px\">
			<fieldset class=\"gray\" width=\"98%\">
				<legend>&nbsp;بيانات الشخصية (يجب عليك ان تختارها)&nbsp;</legend><br>
				<table id=\"basicTable\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\">";
				if($errCountry){
					echo"
					<tr>
						<td colspan=\"4\">الدولة:</td>
					</tr>
					<tr>
						<td colspan=\"3\">";
					$countries=array(''=>'-- اختر دولة --');
					foreach($country as $code=>$val){
						$countries["{$code}"]=$val['name'];
					}
					$Template->selectMenu(array(
						'name'=>'userCountry',
						'options'=>$countries,
						'onchange'=>'$I(\'#userCountryMsg\').innerHTML=\'\';',
						'width'=>'200'
					));
						echo"
						</td>
						<td id=\"userCountryMsg\"></td>
					</tr>";
				}
				if($errBirthday){
					echo"
					<tr>
						<td colspan=\"4\">تاريخ الولادة:</td>
					</tr>
					<tr>
						<td>";
						$days=array();
						for($x=1;$x<=31;$x++){
							$days[]=$x;
						}
						$Template->selectMenu(array(
							'name'=>'userBirthdayDay',
							'options'=>$days,
							'single'=>true,
							'width'=>'50'
						));
						echo"
						</td>
						<td>";
						$months=array();
						for($x=1;$x<=12;$x++){
							$months[]=$x;
						}
						$Template->selectMenu(array(
							'name'=>'userBirthdayMonth',
							'options'=>$months,
							'single'=>true,
							'width'=>'50'
						));
						echo"
						</td>
						<td>";
						$curY=(int)date("Y",time);
						$firstY=$curY-100;
						$lastY=$curY-12;
						$years=array();
						for($x=$firstY;$x<=$lastY;$x++){
							$years[]=$x;
						}
						$Template->selectMenu(array(
							'name'=>'userBirthdayYear',
							'options'=>$years,
							'single'=>true,
							'onchange'=>"\$I('#userBirthdayMsg').innerHTML='';",
							'width'=>'90'
						));
						echo"
						</select>
						</td>
						<td id=\"userBirthdayMsg\"></td>
					</tr>";
				}
				if( $errSex ){
					echo"
					<tr>
						<td colspan=\"4\">الجنس:</td>
					</tr>
					<tr>
						<td colspan=\"3\">&nbsp;&nbsp;&nbsp;
							<input type=\"radio\" class=\"none details_user_sex\" value=\"1\" name=\"userSex\" onclick=\"\$('#userSexMsg').html('');\">ذكر&nbsp;&nbsp;&nbsp;
							<input type=\"radio\" class=\"none details_user_sex\" value=\"2\" name=\"userSex\" onclick=\"\$('#userSexMsg').html('');\">أنثى
						</td>
						<td id=\"userSexMsg\"></td>
					</tr>";
				}
				echo"
				</table><br>
			</fieldset>
			<br><div align=\"center\">{$Template->button("حفظ تغيرات"," onClick=\"DF.doSubmit(this.form)\"")}</div>
			</td>
		</tr>
	</form>
	</table><br>";
}
elseif(type == 'updateuserdetails'&&$DF->getCookie('importantData')!=1&&ulv > 0){
	$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في املاء بيانات الضرورية");
	$userCountry=$DF->cleanText($_POST['userCountry']);
	$userDay=(int)$_POST['userBirthdayDay'];
	$userMonth=(int)$_POST['userBirthdayMonth'];
	$userYear=(int)$_POST['userBirthdayYear'];
	$birthDay="{$userYear}-{$DF->fullNumber($userMonth)}-{$DF->fullNumber($userDay)}";
	$userSex = (int)$_POST['userSex'];
	$Y=(int)date("Y",time);
	$fY=$Y-100;
	$lY=$Y-12;
	require('countries.php');
	$cCode=array_keys($country);
	
	if(isset($_POST['userCountry'])&&!in_array($userCountry,$cCode)){
		$Template->errMsg("نرجوا ان تختار دولة من قائمة الدول.");
	}
	elseif(isset($_POST['userBirthdayYear'])&&($userYear<=$fY||$userYear>$lY)){
		$Template->errMsg("نرجوا أن تختار تاريخ ولادتك الصحيحة.");
	}
	elseif(isset($_POST['userSex'])&&$userSex == 0){
		$Template->errMsg("يجب ان تختار الجنس");
	}
	else{
		$sql="userflag SET";
		if(isset($_POST['userCountry'])) $sql.=" country = '{$userCountry}',";
		if(isset($_POST['userBirthdayYear'])) $sql.=" brithday = '{$birthDay}',";
		if(isset($_POST['userSex'])) $sql.=" sex = '{$userSex}',";
		$sql.=" age = age WHERE id = ".uid."";
		$mysql->update($sql, __FILE__, __LINE__);
		$Template->msg("تم حفظ بيانات بنجاح",'index.php','','',120);
	}
}
else{
	$DF->goTo();
}
$Template->footer();
?>
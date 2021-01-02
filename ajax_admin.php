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

const _df_script = "ajax_admin";
const _df_filename = "ajax_admin.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv == 4){
//************ start page *****************
define('ac','[>:DT:<]');
$id=$_POST['id'];
$type=$_POST['type'];
if($type=='modsDeleteUser'){
	if(ulv==4){
		$mysql->delete("moderator WHERE id = '$id'", __FILE__, __LINE__);
		echo '1';
	}
	else{
		echo '0';
	}
	echo ac;
}
elseif($type == 'usersDeleteUser'){
	if(ulv==4){
		$mysql->delete("forumusers WHERE id = '$id'", __FILE__, __LINE__);
		echo '1';
	}
	else{
		echo '0';
	}
	echo ac;
}
elseif($type == 'get_users_by_ip'){
	$longip = intval($_POST['ip']);
	$count = 0;
	$sql = $mysql->query("SELECT u.id, u.name, u.status, u.level, u.submonitor
	FROM ".prefix."userflag AS uf
	LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
	WHERE uf.allip LIKE '%@{$longip}@%' GROUP BY u.id ORDER BY u.id ASC", __FILE__, __LINE__);
	$arr = array();
	while($rs = $mysql->fetchRow($sql)){
		$arr[] = $Template->userColorLink($rs[0], array($rs[1], $rs[2], $rs[3], $rs[4]));
		$count++;
	}
	if($count > 0){
		echo implode(" + ", $arr);
	}
	else{
		echo "empty";
	}
}
elseif($type=='sendGroupMessage'){
	$length=(int)$_POST['length'];
	$page=(int)$_POST['page'];
	$levels=$_POST['levels'];
	$subject=$_POST['subject'];
	$message=stripslashes($_POST['message']);
	$pgLimit=$DF->pgLimit($length,$page);
	$sql=$mysql->query("SELECT id FROM ".prefix."user WHERE status = 1 AND level IN ({$levels}) ORDER BY id ASC LIMIT {$pgLimit},{$length}", __FILE__, __LINE__);
	$y=1;
	while($rs=$mysql->fetchRow($sql)){
		$u=(int)$rs[0];
		$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES ({$u},0,0,{$u},'{$subject}',".time.")", __FILE__, __LINE__);
		$pmid=$mysql->queryRow("SELECT id FROM ".prefix."pm WHERE author = {$u} AND pmfrom = 0 AND date = ".time."", __FILE__, __LINE__);
		$mysql->insert("pmmessage (id,message) VALUES ({$pmid[0]},'{$message}')", __FILE__, __LINE__);
		if($y==$length){
			?>
			<script type="text/javascript">parent.DF.doSendGroupMessage(<?=($page+1)?>,false);</script>
			<?php
			break;
			exit();
		}
		$y++;
	}
	?>
	<script type="text/javascript">parent.DF.doSendGroupMessage(<?=($page+1)?>,true);</script>
	<?php
}
elseif($type == 'save_users_name_color'){
	function checkUsersColor($color){
		$color = trim($color);
		$color = preg_match("/^#([a-fA-F0-9]{6})$/", $color) ? $color : '';
		return $color;
	}
	$color10 = checkUsersColor($_POST['color10']);
	$color11 = checkUsersColor($_POST['color11']);
	$color12 = checkUsersColor($_POST['color12']);
	$color13 = checkUsersColor($_POST['color13']);
	$color20 = checkUsersColor($_POST['color20']);
	$color21 = checkUsersColor($_POST['color21']);
	$color31 = checkUsersColor($_POST['color31']);
	$color41 = checkUsersColor($_POST['color41']);
	
	$scolor10 = trim($DF->cleanText($_POST['scolor10']));
	$scolor11 = trim($DF->cleanText($_POST['scolor11']));
	$scolor12 = trim($DF->cleanText($_POST['scolor12']));
	$scolor13 = trim($DF->cleanText($_POST['scolor13']));
	$scolor20 = trim($DF->cleanText($_POST['scolor20']));
	$scolor21 = trim($DF->cleanText($_POST['scolor21']));
	$scolor31 = trim($DF->cleanText($_POST['scolor31']));
	$scolor41 = trim($DF->cleanText($_POST['scolor41']));
	
	$colors = array(
		1 => array($color10, $color11, $color12, $color13),
		2 => array($color20, $color21),
		3 => array('', $color31),
		4 => array('', $color41),
	);
	
	$scolors = array(
		1 => array($scolor10, $scolor11, $scolor12, $scolor13),
		2 => array($scolor20, $scolor21),
		3 => array('', $scolor31),
		4 => array('', $scolor41),
	);
	
	$colors = serialize($colors);
	$scolors = serialize($scolors);
	$DFOutput->setCnf('user_name_color', $colors);
	$DFOutput->setCnf('stars_color', $scolors);
	echo'1';
}
elseif($type == 'save_stars_number'){
	$star0 = intval($_POST['star0']);
	$star1 = intval($_POST['star1']);
	$star2 = intval($_POST['star2']);
	$star3 = intval($_POST['star3']);
	$star4 = intval($_POST['star4']);
	$star5 = intval($_POST['star5']);
	$star6 = intval($_POST['star6']);
	$star7 = intval($_POST['star7']);
	$star8 = intval($_POST['star8']);
	$star9 = intval($_POST['star9']);
	$star10 = intval($_POST['star10']);
	
	$stars = array(
		0 => $star0,
		1 => $star1,
		2 => $star2,
		3 => $star3,
		4 => $star4,
		5 => $star5,
		6 => $star6,
		7 => $star7,
		8 => $star8,
		9 => $star9,
		10 => $star10
	);
	
	$stars = serialize($stars);
	$DFOutput->setCnf('stars_number', $stars);
	echo'1';
}
elseif($type == 'save_users_titles'){
	$DF->charset("utf-8");
	$titleM10 = trim($DF->cleanText($_POST['titleM10'], true));
	$titleM11 = trim($DF->cleanText($_POST['titleM11'], true));
	$titleM12 = trim($DF->cleanText($_POST['titleM12'], true));
	$titleM13 = trim($DF->cleanText($_POST['titleM13'], true));
	$titleM14 = trim($DF->cleanText($_POST['titleM14'], true));
	$titleM15 = trim($DF->cleanText($_POST['titleM15'], true));
	$titleM200 = trim($DF->cleanText($_POST['titleM200'], true));
	$titleM201 = trim($DF->cleanText($_POST['titleM201'], true));
	$titleM210 = trim($DF->cleanText($_POST['titleM210'], true));
	$titleM211 = trim($DF->cleanText($_POST['titleM211'], true));
	$titleM30 = trim($DF->cleanText($_POST['titleM30'], true));
	$titleM31 = trim($DF->cleanText($_POST['titleM31'], true));
	$titleM40 = trim($DF->cleanText($_POST['titleM40'], true));
	$titleM41 = trim($DF->cleanText($_POST['titleM41'], true));
	
	$titleF10 = trim($DF->cleanText($_POST['titleF10'], true));
	$titleF11 = trim($DF->cleanText($_POST['titleF11'], true));
	$titleF12 = trim($DF->cleanText($_POST['titleF12'], true));
	$titleF13 = trim($DF->cleanText($_POST['titleF13'], true));
	$titleF14 = trim($DF->cleanText($_POST['titleF14'], true));
	$titleF15 = trim($DF->cleanText($_POST['titleF15'], true));
	$titleF200 = trim($DF->cleanText($_POST['titleF200'], true));
	$titleF201 = trim($DF->cleanText($_POST['titleF201'], true));
	$titleF210 = trim($DF->cleanText($_POST['titleF210'], true));
	$titleF211 = trim($DF->cleanText($_POST['titleF211'], true));
	$titleF30 = trim($DF->cleanText($_POST['titleF30'], true));
	$titleF31 = trim($DF->cleanText($_POST['titleF31'], true));
	$titleF40 = trim($DF->cleanText($_POST['titleF40'], true));
	$titleF41 = trim($DF->cleanText($_POST['titleF41'], true));
	$male_titles = array(
		1 => array(
			$titleM10,
			$titleM11,
			$titleM12,
			$titleM13,
			$titleM14,
			$titleM15,
		),
		2 => array(
			array($titleM200, $titleM201),
			array($titleM210, $titleM211)
		),
		3 => array($titleM30, $titleM31),
		4 => array($titleM40, $titleM41),
	);
	$female_titles = array(
		1 => array(
			$titleF10,
			$titleF11,
			$titleF12,
			$titleF13,
			$titleF14,
			$titleF15,
		),
		2 => array(
			array($titleF200, $titleF201),
			array($titleF210, $titleF211)
		),
		3 => array($titleF30, $titleF31),
		4 => array($titleF40, $titleF41),
	);
	$male_titles = serialize($male_titles);
	$female_titles = serialize($female_titles);
	$DFOutput->setCnf('male_titles', $male_titles);
	$DFOutput->setCnf('female_titles', $female_titles);
	echo'1';
}
elseif($type == 'new_users_operations'){
	$id = intval($_POST['id']);
	if($id > 0){
		$method = $DF->cleanText($_POST['method']);
		if($method == 'accept'){
			$mysql->update("user SET status = 1 WHERE id = {$id}", __FILE__, __LINE__);
			$mysql->update("userflag SET agree = ".uid." WHERE id = {$id}", __FILE__, __LINE__);
			echo "1";
		}
		if($method == 'refuse'){
			$mysql->update("user SET status = 3 WHERE id = {$id}", __FILE__, __LINE__);
			echo "1";
		}
	}
}
elseif($type == 'change_names_operations'){
	$DF->charset("utf-8");
	$id = intval($_POST['id']);
	if($id > 0){
		$method = $DF->cleanText($_POST['method']);
		$rs = $mysql->queryRow("SELECT userid, newname FROM ".prefix."changename WHERE id = {$id}", __FILE__, __LINE__);
		$userid = $rs[0];
		$newname = $rs[1];
		if($method == 'accept'){
			$subject = $DF->cleanText("تم تغير اسم عضويتك بنجاح", true);
			$message = $DF->cleanText("الرسالة من ادارة @@forum_title@@ حول طلب تغيير اسم عضويتك@@br@@@@br@@تمت موافقة على طلبك بتغير اسم العضوية الى اسم الذي انت اخترت@@br@@مع تحيات ادارة @@forum_title@@", true);
			$message = str_replace("@@forum_title@@", forum_title, $message);
			$message = str_replace("@@br@@", "<br>", $message);
			$mysql->update("user SET entername = IF(name = entername, '{$newname}', entername), name = '{$newname}' WHERE id = {$userid}", __FILE__, __LINE__);
			$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES ({$userid}, 0, 0, {$userid}, '{$subject}', ".time.")", __FILE__, __LINE__);
			$rs = $mysql->queryRow("SELECT id FROM ".prefix."pm WHERE author = {$userid} AND pmfrom = 0 AND date = ".time."", __FILE__, __LINE__);
			$pmid = intval($rs[0]);
			$mysql->insert("pmmessage (id, message) VALUES ({$pmid}, '{$message}')", __FILE__, __LINE__);
			$mysql->update("changename SET status = 1 WHERE id = {$id}", __FILE__, __LINE__);
			echo "1";
		}
		if($method == 'refuse'){
			$subject = $DF->cleanText("لم يتم تغير اسم عضويتك", true);
			$message = $DF->cleanText("الرسالة من ادارة @@forum_title@@ حول طلب تغيير اسم عضويتك@@br@@@@br@@تم رفض طلب تغيير اسم عضويتك بسبب مخالفة قوانين المنتدى@@br@@لهذا مرجوا محاولة بإسم آخر وموافق عن قوانين المنتدى@@br@@مع تحيات ادارة @@forum_title@@", true);
			$message = str_replace("@@forum_title@@", forum_title, $message);
			$message = str_replace("@@br@@", "<br>", $message);
			$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES ({$userid}, 0, 0, {$userid}, '{$subject}', ".time.")", __FILE__, __LINE__);
			$rs = $mysql->queryRow("SELECT id FROM ".prefix."pm WHERE author = {$userid} AND pmfrom = 0 AND date = ".time."", __FILE__, __LINE__);
			$pmid = intval($rs[0]);
			$mysql->insert("pmmessage (id, message) VALUES ({$pmid}, '{$message}')", __FILE__, __LINE__);
			$mysql->update("changename SET status = 2 WHERE id = {$id}", __FILE__, __LINE__);
			echo "1";
		}
	}
}
else{
	echo '0'.ac;
}
//************ end page *****************
}
else{
	echo '0'.ac;
}
$Template->footer(false);
?>
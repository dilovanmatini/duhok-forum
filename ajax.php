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

const _df_script = "ajax";
const _df_filename = "ajax.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

define('ac', '[>:DT:<]');
$id = intval($_POST['id']);
$type = trim($_POST['type']);
$method = trim($_POST['method']);

if($type == 'set_data_to_database'){
	$method = $DF->cleanText($_POST['method']);
	if($method == 'forumsdotphp'){ // forums.php
		$f = intval($_POST['f']);
		if($f > 0){
			$DFOutput->setForumBrowse($f);
			//echo 'forumsdotphp: $DFOutput->setForumBrowse($f); | ';
		}
	}
	elseif($method == 'topicdotphp'){ // topic.php
		$f = intval($_POST['f']);
		$author = intval($_POST['author']);
		if($f > 0 && $author > 0){
			$DFOutput->setUserActivity('topicview', $f, $author);
			//echo 'topicdotphp: $DFOutput->setUserActivity(\'topicview\', $f, $author); | ';
		}
		if($f > 0){
			$DFOutput->setForumBrowse($f);
			//echo 'topicdotphp: $DFOutput->setForumBrowse($f); | ';
		}
	}
	elseif($method == 'setUserActivity_online'){ // footer function in class_template.php
		$f = intval($_POST['f']);
		$mod = intval($_POST['mod']);
		if($mod == 1){
			$DFOutput->setModActivity('online', $f, true);
			//echo 'setUserActivity_online: $DFOutput->setModActivity(\'online\', $f, true); | ';
		}
		if(ulv > 0 && ulv < 4){
			$DFOutput->setUserActivity('online', $f);
			//echo 'setUserActivity_online: $DFOutput->setUserActivity(\'online\', $f); | ';
		}
	}
	elseif($method == 'setUserActivity_profileview'){ // profile.php
		$u = intval($_POST['u']);
		$DFOutput->setUserActivity('profileview', 0, $u);
		//echo 'setUserActivity_profileview: $DFOutput->setUserActivity(\'profileview\', 0, $u); | ';
	}
}
elseif($type == 'afterLoadOperations'){
	if(ulv > 0){
		$user_hash = addslashes($_COOKIE['login_user_hash']);
		if(strlen($user_hash) == 32){
			$mysql->update("loginsession SET lastdate = ".time." WHERE hash = '{$user_hash}' AND userid = ".uid."", __FILE__, __LINE__);
		}
	}
}
elseif($type == 'stopSession'){
	$id = intval($_POST['id']);
	$u = intval($_POST['u']);
	$uid = ($u > 0 && ulv == 4) ? $u : uid;
	if($id > 0){
		$mysql->update("loginsession SET status = 2, lastdate = ".time." WHERE id = {$id} AND userid = {$uid}", __FILE__, __LINE__);
		echo '1';
	}
}
elseif($type == 'set_user_style'){
	$weight = $DF->cleanText($_POST['weight']);
	$align = $DF->cleanText($_POST['align']);
	$family = $DF->cleanText($_POST['family']);
	$size = $DF->cleanText($_POST['size']);
	$color = $DF->cleanText($_POST['color']);
	$style = array(
		'weight' => $weight,
		'align' => $align,
		'family' => $family,
		'size' => $size,
		'color' => $color
	);
	$style = serialize($style);
	$mysql->update("userflag SET style = '{$style}' WHERE id = ".uid."", __FILE__, __LINE__);
	echo '1';
}
elseif($type=='getForumMedalsPhoto'){
	$DF->charset();
	echo ac;
	$show_tools=$DF->showTools($id);
	if($show_tools==2){
		$is_moderator=true;
		$is_monitor=true;
	}
	elseif($show_tools==1){
		$is_moderator=true;
	}
	if($is_moderator){
		$sql=$mysql->query("SELECT filename FROM ".prefix."medalphotos WHERE forumid = '$id' ORDER BY date DESC", __FILE__, __LINE__);
		while($rs=$mysql->fetchRow($sql)){
			echo"{$DFPhotos->getsrc($rs[0])}[>:r:<]";
		}
		echo 'emp'.ac;
	}
	else{
		echo ac;
	}
}
elseif($type=='deleteUserFromTopic'){
	if($is_moderator){
		$mysql->delete("topicusers WHERE id = '$id'", __FILE__, __LINE__);
		echo '1';
	}
	else{
		echo '0';
	}
	echo ac;
}
elseif($type=='getMonDetails'){
	$DF->charset();
	$rs=$mysql->queryRow("SELECT mf.postid,mf.posttype,mf.usernote,mf.monnote,IF(mf.posttype = 1,p.topicid,0)
	FROM ".prefix."monflag as mf
	LEFT JOIN ".prefix."post AS p ON(mf.posttype = 1 AND p.id = mf.postid)
	WHERE mf.id = '$id'", __FILE__, __LINE__);
	if($rs){
		echo ($rs[1]==3 ? $DF->numToHash($rs[0]) : $rs[0]).ac;
		echo $rs[1].ac;
		echo nl2br($rs[2]).ac;
		echo nl2br($rs[3]).ac;
		echo $rs[4].ac;
	}
	else{
		echo '0'.ac;
	}
}
elseif($type == 'process_phpcode'){
	$DF->charset("utf-8");
	$code = $_POST['code'];
	echo '@@DM@@';
	if(!empty($code)){
		if(!preg_match('#<\?#si', $code)){
			$code = "<?php\r\n{$code}\r\n?>";
		}
		$code = stripslashes($code);
		$code = highlight_string($code, true);
		$html = "
		<div dir=\"ltr\" style=\"margin:20px;margin-top:5px;text-align:left\">
			<div style=\"margin-bottom:2px\">PHP Code:</div>
			<div dir=\"ltr\" style=\"margin:0px;padding:4px;border:1px inset;width:650;height:150px;font-weight:normal;font-size:13px;font-family:'Courier New';text-align:left;overflow:auto\">
				<code style=\"white-space:nowrap\">{$code}</code>
			</div>
		</div>";
		echo $html;
	}
	echo '@@DM@@';
}
elseif($type=='menubarContents'){
	if(ulv>0){
		//textId, otherText, highlight, disabled
		if($method=='u'){
			$rs=$mysql->queryAssoc("SELECT u.status,u.level,uf.posts,uf.points,uf.ip
			FROM ".prefix."user AS u
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
			WHERE u.id = $id", __FILE__, __LINE__);
			$status=($rs['status']==1 ? 0 : (ulv>1 ? 0 : 1));
			$modStatus=($rs['status']==1 ? 0 : 1);
			$details="
			[9,'',1,0],
			".(ulv>1 ? "[1,$id,0,0]," : "")."
			[2,{$rs['posts']},0,0],
			".($rs['points']>0&&$rs['level']<4?"[3,{$rs['points']},0,0],":"")."
			[-1],
			[7,'',1,{$status}],
			[12,'',1,{$status}],
			[8,'',1,{$status}],
			[4,'',1,0],
			[5,'',1,{$status}],
			[6,'',1,{$status}],";
 			if(ulv>1){
				$details .= "[-1],
				[59,'',1,{$modStatus}],
				[58,'',1,0],
				[57,'',1,{$modStatus}],
				[56,'',1,0],
				[55,'',1,{$modStatus}],
				[54,'',1,0],";
			}
			if(ulv == 3 && $rs['level'] < 3){
				$details .= "[-1],
				[97,'',1,0],";
			}
			if(ulv == 4){
				$details .= "[-1],
				[99,'',1,0],
				[98,'',1,0],
				".($rs['level']<4 ? "[97,'',1,0]," : "")."
				[96,'',1,0],
				[95,'',1,0],
				[94,'',1,0],
				[93,'',1,0,'{$rs['ip']}'],
				".($rs['level']<4 ? "[83,'',1,0]," : "")."
				[84,'',1,0],";
			}
			$details=$DF->striplines($details,true);
			$details=substr($details,0,strlen($details)-1);
			echo "[{$details}]";
		}
		if($method=='f'){
			$is_moderator=false;
			$is_monitor=false;
			if($id>0){
				$show_tools=$DF->showTools($id);
				if($show_tools==2){
					$is_moderator=true;
					$is_monitor=true;
				}
				elseif($show_tools==1){
					$is_moderator=true;
				}
			}
			$rs=$mysql->queryAssoc("SELECT status,hidden FROM ".prefix."forum WHERE id = {$id}", __FILE__, __LINE__);
			$status=($rs['status']==1 ? 0 : (ulv==4||$is_moderator ? 0 : 1));
			$details="
			[10,'',1,0],
			[20,'',1,{$status}],
			[21,'',1,{$status}],
			[22,'',1,0],";
			if($is_moderator){
				$details.="[-1],
				[69,{$DFOutput->count("topic WHERE moderate = 1 AND forumid = $id")},1,0],
				[68,{$DFOutput->count("topic WHERE moderate = 2 AND forumid = $id")},1,0],
				[67,{$DFOutput->count("post WHERE moderate = 1 AND forumid = $id")},1,0],
				[66,{$DFOutput->count("post WHERE moderate = 2 AND forumid = $id")},1,0],
				[65,{$DFOutput->count("pm WHERE author = (-$id) AND pmout = 0 AND pmread = 0 AND status = 1 AND pmlist = 0")},1,0],
				[64,{$DFOutput->count("complain WHERE status = 3 AND forumid = $id")},1,0],";
			}
			if(ulv==4){
				$details.="[-1],
				[89,'',1,0],
				{$DF->iff($rs['hidden']==0,"[88,'',1,0],","")}
				{$DF->iff($rs['hidden']==1,"[87,'',1,0],","")}
				{$DF->iff($rs['status']==1,"[86,'',1,0],","")}
				{$DF->iff($rs['status']==0,"[85,'',1,0],","")}";
			}
			$details=$DF->striplines($details,true);
			$details=substr($details,0,strlen($details)-1);
			echo "[{$details}]";
		}
		if($method=='t'){
			$rs=$mysql->queryAssoc("SELECT t.status,t.author,f.id AS fid,f.status AS fstatus
			FROM ".prefix."topic AS t
			LEFT JOIN ".prefix."forum AS f ON(f.id = t.forumid)
			WHERE t.id = $id", __FILE__, __LINE__);
			$is_moderator=false;
			$is_monitor=false;
			if($rs['fid']>0){
				$show_tools=$DF->showTools($rs['fid']);
				if($show_tools==2){
					$is_moderator=true;
					$is_monitor=true;
				}
				elseif($show_tools==1){
					$is_moderator=true;
				}
			}
			$status=($rs['status']==1&&$rs['fstatus']==1||$is_moderator ? 0 : 1);
			$editstatus=($rs['status']==1&&$rs['author']==uid||$is_moderator ? 0 : 1);
			$details="
			[11,'',1,0],
			[30,'',1,{$status}],
			[31,'',1,{$editstatus}],
			[-1],
			[32,'',1,0],
			[33,'',1,0],
			[34,'',1,0],
			[35,'',1,0],
			[36,'',1,0,{$rs['author']}],";
			if($is_moderator){
				$details.="[-1],
				[79,{$DFOutput->count("post WHERE moderate = 1 AND topicid = $id")},1,0],
				[78,{$DFOutput->count("post WHERE moderate = 2 AND topicid = $id")},1,0],
				[-1],
				[77,'',1,0],
				[76,'',1,0],";
			}
			$details=$DF->striplines($details,true);
			$details=substr($details,0,strlen($details)-1);
			echo "[$details]";
		}
	}
}
elseif($type == 'checkUseUserName'){
	$name = $DF->cleanText($_POST['name']);
	$userid = intval($mysql->get("user", "id", $name, "name"));
	if($userid > 0){
		echo'found'.ac;
	}
	else{
		echo'none'.ac;
	}
}
elseif($type=='checkUseUserEmail'){
	$userEmail=$DF->cleanText($_POST['email']);
	$userid=(int)$mysql->get("userflag","id",$userEmail,"email");
	if($userid>0){
		echo'found'.ac;
	}
	else{
		echo'none'.ac;
	}
}
elseif($type=='doLoadMods'){
	$DF->charset("utf-8");
 	$sql=$mysql->query("SELECT m.userid,u.name FROM ".prefix."moderator AS m LEFT JOIN ".prefix."user AS u ON(u.id = m.userid) WHERE m.forumid = '$id'", __FILE__, __LINE__);
	if($mysql->numRows($sql)>0){
		echo"<div class=\"mods2\" style=\"width:150px\"><nobr>المنتدى بإشراف</nobr></div>";
		while($rs=$mysql->fetchRow($sql)){
			echo"<div class=\"mods\" style=\"width:150px\"><nobr>".$Template->userNormalLink($rs[0],$rs[1])."</nobr></div>";
		}
		echo ac;
	}
	else{
		echo"<div class=\"mods\"><nobr>لا يوجد أي مشرف</nobr></div>".ac;
	}
}
elseif($type=='onlineinforums'){
	$forums = $DF->cleanText($_POST['forums'], true);
	$forums = str_replace("|", ",", $forums);
	$sql = $mysql->query("SELECT f.id, IF(".ulv." > 0, COUNT(DISTINCT uo.ip)+COUNT(DISTINCT v.ip), 0)
	FROM ".prefix."forum AS f
	LEFT JOIN ".prefix."useronline AS uo ON(f.id = uo.forumid AND uo.level < 4)
	LEFT JOIN ".prefix."visitors AS v ON(f.id = v.forumid)
	WHERE f.id in ({$forums}) GROUP BY f.id", __FILE__, __LINE__);
	$gets = array();
	while($rs = $mysql->fetchRow($sql)){
		$gets[] = "{$rs[0]}:{$rs[1]}";
	}
	echo implode("|", $gets);
}
elseif($type=='getModerateContetns'){
	$rs=$mysql->queryRow("SELECT COUNT(CASE WHEN moderate = 1 THEN 1 ELSE NULL END),COUNT(CASE WHEN moderate = 2 THEN 1 ELSE NULL END) FROM ".prefix."topic WHERE moderate > 0 AND forumid = {$id} GROUP BY forumid", __FILE__, __LINE__);
	$tModerate=(int)$rs[0];
	$tHold=(int)$rs[1];
 	$rs=$mysql->queryRow("SELECT COUNT(CASE WHEN moderate = 1 THEN 1 ELSE NULL END),COUNT(CASE WHEN moderate = 2 THEN 1 ELSE NULL END) FROM ".prefix."post WHERE moderate > 0 AND forumid = {$id} GROUP BY forumid", __FILE__, __LINE__);
	$pModerate=(int)$rs[0];
	$pHold=(int)$rs[1];
	$pm=$DFOutput->count("pm WHERE author = (-{$id}) AND pmout = 0 AND pmread = 0 AND status = 1 AND pmlist = 0");
	echo "{$tModerate}|{$tHold}|{$pModerate}|{$pHold}|{$pm}";
}
elseif( type == 'doUploadPicture' && ulv > 0 ){

	$json = [
		'status' => ''
	];

	$file = $_FILES['picfile'];
	$coords = $_POST['coords'];
	$coords = explode(",", $coords);

	if( $file['name'] == '' && upicture != '' ){
		$file['name'] = upicture;
		$file['error'] = 0;
		$file['tmp_name'] = "{$DF->config['photos']['folder']}/".$DFPhotos->filename2path(upicture);
	}

	$width = floatval( isset($coords[0]) ? $coords[0] : 0 );
	$height = floatval( isset($coords[1]) ? $coords[1] : 0 );
	$x = floatval( isset($coords[2]) ? $coords[2] : 0 );
	$y = floatval( isset($coords[3]) ? $coords[3] : 0 );

	if( count($file) == 0 || !isset($file['name']) || intval($file['error']) > 0 ){
		$json['status'] = 'file';
	}
	else{
		$file_name = $file['name'];
		$file_source = $file['tmp_name'];

		$sizes = (array)$DF->config['photos']['user_profile']['sizes'];
		$sizes[999] = [
			'width' => $width,
			'height' => $height,
			'x' => $x,
			'y' => $y,
			'src_width' => $width,
			'src_height' => $height
		];

		krsort($sizes);
		$result = $DFPhotos->create($file_name, $file_source, array(
			'phototype' => 'users',
			'targetid' => uid,
			'targettype' => 'profile',
			'allow_types' => $DF->config['photos']['user_profile']['extension'],
			'allow_size' => $DF->config['photos']['user_profile']['allow_size'],
			'getsize' => 999,
			'sizes' => $sizes
		));

		if( $result['error'] == 1 ){
			$json['status'] = $result['errorname'];
		}
		else{
			$mysql->execute("UPDATE {$mysql->prefix}userflag SET picture = :picture WHERE id = ".uid."", [
				'picture' => $result['filename']
			], __FILE__, __LINE__);
			$json['src'] = $DFPhotos->getsrc($result['filename']);
			$json['status'] = 'success';
		}
	}
	echo json_encode($json);
}
elseif($type == 'getAddFriend' && ulv > 0){
	$DF->charset();
	$rs=$mysql->queryRow("SELECT u.id,u.name,u.status,u.level,u.submonitor,uf.picture
	FROM ".prefix."user AS u
	LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
	WHERE u.id = {$id} GROUP BY u.id", __FILE__, __LINE__);
	$user=($rs[0]>0 ? $Template->userColorLink($rs[0], array($rs[1], $rs[2], $rs[3], $rs[4])) : '');
	echo"['{$user}','{$rs[5]}',{$DFOutput->friendStatus($id)}]";
}
elseif($type=='setAddFriend'&&ulv>0){
	if($DFOutput->friendStatus($id)==0){
		$mysql->insert("friends (userid,friendid,date) VALUES (".uid.",{$id},".time.")", __FILE__, __LINE__);
		echo ac.'1'.ac;
	}
}
elseif($type=='checkFriends'&&ulv>0){
	$uid=uid;
	$auth=(int)$_POST['auth'];
	if(ulv==4&&$auth>0&&$auth!=uid) $uid=$auth;
	if($id>0&&$uid>0){
		if($method=='accept'){
			$mysql->update("friends SET status = 1 WHERE friendid = {$uid} AND id = {$id}", __FILE__, __LINE__);
			$author=$mysql->get("friends","userid",$id);
			$DFOutput->setNotification('acf',$author,$author,0,$uid);
		}
		if($method=='refuse') $mysql->update("friends SET status = 2 WHERE (userid = {$uid} OR friendid = {$uid}) AND id = {$id}", __FILE__, __LINE__);
		if($method=='delete') $mysql->delete("friends WHERE userid = {$uid} AND id = {$id}", __FILE__, __LINE__);
		if($method=='deleteblock') $mysql->delete("blocks WHERE userid = {$uid} AND id = {$id}", __FILE__, __LINE__);
		echo ac.'1'.ac;
	}
}
elseif($type=='blockUser' && ulv > 0){
	if($id > 0){
		$rs = $mysql->queryRow("SELECT id FROM ".prefix."blocks WHERE userid = ".uid." AND blockid = {$id}", __FILE__, __LINE__);
		$bid = (int)$rs[0];
		if($bid > 0){
			echo ac.'2'.ac;
		}
		else{
			$mysql->delete("friends WHERE (userid = {$id} AND friendid = ".uid.") OR (userid = ".uid." AND friendid = {$id})", __FILE__, __LINE__);
			$mysql->insert("blocks (userid,blockid,date) VALUES (".uid.",{$id},".time.")", __FILE__, __LINE__);
			echo ac.'1'.ac;
		}
	}
}
elseif($type == 'read_notification' and ulv > 0){
	if($id > 0){
		$mysql->update("notification SET status = 1 WHERE author = ".uid." AND id = {$id}", __FILE__, __LINE__);
		echo "1";
	}
}
elseif($type == 'get_header_details' and ulv > 0){
	$arr = array();
	$arr[] = $DFOutput->count("pm WHERE author = '".uid."' AND pmto = '".uid."' AND status = 1 AND pmout = 0 AND pmread = 0 AND pmlist = 0");
	$arr[] = $DFOutput->count("friends WHERE status = 0 AND friendid = ".uid."");
	$arr[] = $DFOutput->count("notification WHERE status = 0 AND author = ".uid."");
	$arr[] = (ulv == 4) ? $DFOutput->count("user WHERE status = 2") : 0;
	$arr[] = (ulv == 4) ? $DFOutput->count("changename WHERE status = 0") : 0;
	$details = implode("|", $arr);
	echo $details;
}
elseif($type == 'get_header_contents' and ulv > 0){
	$DF->charset();
	$name = $DF->cleanText($_POST['name']);
	if($name == 'messages'){
		$sql = $mysql->query("SELECT pm.id, pm.pmfrom, pm.subject, pm.date, u.id, u.name, u.status, u.level, u.submonitor, uf.picture
		FROM ".prefix."pm AS pm
		LEFT JOIN ".prefix."user AS u ON(u.id = pm.pmfrom)
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = pm.pmfrom)
		WHERE pm.author = ".uid." AND pm.pmto = ".uid." AND pm.status = 1 AND pm.pmout = 0 AND pm.pmread = 0 AND pm.pmlist = 0
		GROUP BY pm.id ORDER BY pm.date DESC LIMIT 6", __FILE__, __LINE__);
		$messages = array();
		while($rs = $mysql->fetchRow($sql)){
			$id = $rs[0];
			$from = $rs[1];
			$subject = trim($rs[2]);
			if(strlen($subject) > 50){
				$subject = substr($subject, 0, 50);
				$subject = explode(" ", $subject);
				array_pop($subject);
				$subject = implode(" ", $subject).'...';
			}
			$subject = str_replace(array("{@@}", "[@@]", "(@@)"), "", $subject);
			$subject = "<a href=\"pm.php?mail=read&pm=".$DF->numToHash($id)."\">{$subject}</a>";
			$date = $DF->date($rs[3]);
			if($from == 0){
				$user = $DF->cleanText('إدارة منتديات', true);
			}
			else{
				$user = $Template->userColorLink($rs[4], array($rs[5], $rs[6], $rs[7], $rs[8]));
			}
			$picture = $DFPhotos->getsrc($rs[9], 48);
			$messages[] = "{$subject}{@@}{$date}{@@}{$user}{@@}{$picture}";
		}
		$messages = implode("[@@]", $messages);
		echo"(@@){$messages}(@@)";
	}
	if($name == 'friends'){
		$sql = $mysql->query("SELECT f.id, u.id, u.name, u.status, u.level, u.submonitor, uf.picture, uf.posts, uf.title, uf.sex, uf.oldlevel
		FROM ".prefix."friends AS f
		LEFT JOIN ".prefix."user AS u ON(u.id = f.userid)
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = f.userid)
		WHERE f.status = 0 AND f.friendid = ".uid." GROUP BY f.id ORDER BY f.date DESC LIMIT 6", __FILE__, __LINE__);
		$friends = array();
		while($rs = $mysql->fetchRow($sql)){
			$id = $rs[0];
			$user = $Template->userColorLink($rs[1], array($rs[2], $rs[3], $rs[4], $rs[5]));
			$picture = $DFPhotos->getsrc($rs[6], 48);
			$title = $DF->userTitle($rs[1], $rs[7], $rs[4], $rs[8], $rs[9], $rs[10], $rs[5]);
			$friends[] = "{$id}{@@}{$user}{@@}{$picture}{@@}{$title}";
		}
		$friends = implode("[@@]", $friends);
		echo"(@@){$friends}(@@)";
	}
	if($name == 'notifies'){
		require_once 'notifications_list.php';
		$sql = $mysql->query("SELECT n.*,u.name AS uname,u.status AS ustatus,u.level AS ulevel,u.submonitor AS usubmonitor, uf.picture,
			IF(NOT ISNULL(t.id),t.subject,'') AS tsubject
		FROM ".prefix."notification AS n
		LEFT JOIN ".prefix."user AS u ON(u.id = n.userid)
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = n.userid)
		LEFT JOIN ".prefix."topic AS t ON(t.id = n.topicid)
		WHERE n.author = ".uid." AND n.status = 0 GROUP BY n.id ORDER BY n.date DESC LIMIT 6", __FILE__, __LINE__);
		$notifies = array();
		while($rs = $mysql->fetchAssoc($sql)){
			$id = $rs['id'];
			$type = $rs['type'];
			$subject = trim($rs['tsubject']);
			if(strlen($subject) > 50){
				$subject = substr($subject, 0, 50);
				$subject = explode(" ", $subject);
				array_pop($subject);
				$subject = implode(" ", $subject).'...';
			}
			$subject = str_replace(array("{@@}", "[@@]", "(@@)"), "", $subject);
			$icon = $notify_types["{$type}"]['icon'];
			$date = $DF->date($rs['date']);
			$tid = intval($rs['topicid']);
			$pid = intval($rs['postid']);
			$url = $notify_types["{$type}"]['url'];
			if($tid > 0){
				$url = str_replace("{1}", $tid, $url);
			}
			if($pid > 0){
				$url = str_replace("{2}", $pid, $url);
			}
			$title = "<a href=\"{$url}\">".$notify_types["{$type}"]['title']."</a>";
			$user = $Template->userColorLink(
				$rs['userid'],
				array($rs['uname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor'])
			);
			$picture = $DFPhotos->getsrc($rs['picture'], 48);
			$notifies[] = "{$id}{@@}{$icon}{@@}{$title}{@@}{$subject}{@@}{$date}{@@}{$user}{@@}{$picture}";
		}
		$notifies = implode("[@@]", $notifies);
		echo"(@@){$notifies}(@@)";
	}
	if($name == 'newusers' && ulv == 4){
		@require_once('countries.php');
		$sql = $mysql->query("SELECT u.id,u.name,uf.email,uf.ip
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE u.status = 2 GROUP BY u.id ORDER BY u.date DESC LIMIT 6", __FILE__, __LINE__);
		$newusers = array();
		while($rs = $mysql->fetchRow($sql)){
			$id = $rs[0];
			$name = $rs[1];
			$email = $rs[2];
			$iplong = $rs[3];
			$ip = long2ip($iplong);
			$details = $DF->getCountryByIP($ip, 'all');
			$code = strtolower(trim($details['code']));
			$flag = $DF->getFlagByCode($code);
			$country_name = (isset($country["{$code}"]) and isset($country["{$code}"]['name']))
				?
			$country["{$code}"]['name']
				:
			(($code != '') ? $details['name'] : $DF->cleanText("غير معروف", true));
			$newusers[] = "{$id}{@@}{$name}{@@}{$email}{@@}{$ip}{@@}{$iplong}{@@}{$flag}{@@}{$country_name}";
		}
		$newusers = implode("[@@]", $newusers);
		echo"(@@){$newusers}(@@)";
	}
	if($name == 'changenames' && ulv == 4){
		$sql = $mysql->query("SELECT
			n.id, n.userid, n.newname, n.oldname, n.date, u.status AS ustatus, u.level AS ulevel, u.submonitor AS usubmonitor, uf.picture
		FROM ".prefix."changename AS n
		LEFT JOIN ".prefix."user AS u ON(u.id = n.userid)
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = n.userid)
		WHERE n.status = 0
		GROUP BY n.id ORDER BY n.date DESC LIMIT 6", __FILE__, __LINE__);
		$changenames = array();
		while($rs = $mysql->fetchAssoc($sql)){
			$id = $rs['id'];
			$user = $Template->userColorLink(
				$rs['userid'],
				array($rs['oldname'], $rs['ustatus'], $rs['ulevel'], $rs['usubmonitor'])
			);
			$picture = $DFPhotos->getsrc($rs['picture'], 48);
			$newname = $rs['newname'];
			$date = $DF->date($rs['date']);
			$changenames[] = "{$id}{@@}{$user}{@@}{$picture}{@@}{$newname}{@@}{$date}";
		}
		$changenames = implode("[@@]", $changenames);
		echo"(@@){$changenames}(@@)";
	}
}
elseif($type == 'get_header_search_users'){
	$DF->charset();
	echo "@=@";
	if(ulv == 0){
		echo "99"; //not user
	}
	else{
		$result = array();
		$search = $DF->cleanText($_POST['search']);
		$search = stripslashes($search);
		if(trim($search) != ''){
			require_once('countries.php');
			$sql = $mysql->query("SELECT
				u.id, u.name, u.status, u.level, u.submonitor, uf.picture, uf.country, uf.posts
			FROM ".prefix."user AS u
			LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
			WHERE u.status = 1 AND u.active = 1 AND u.name REGEXP '^{$search}' GROUP BY u.id ORDER BY binary u.name ASC LIMIT 6", __FILE__, __LINE__);
			while($rs = $mysql->fetchAssoc($sql)){
				$user = $Template->userColorLink(
					$rs['id'],
					array($rs['name'], $rs['status'], $rs['level'], $rs['submonitor'])
				);
				$picture = $DFPhotos->getsrc($rs['picture'], 48);
				if(empty($picture)){
					$picture = 'images/upics/32/default.gif';
				}
				if($rs['country'] != ''){
					$location = $country["{$rs['country']}"]['name'];
				}
				else{
					$location = '';
				}
				$result[] = "{$user}@-@{$picture}@-@{$location}@-@{$rs['posts']}";
			}
		}
 		if(count($result) > 0){
			echo implode("@+@", $result);
		}
		else{
			echo"98"; //no result
		}
	}
	echo "@=@";
}
else{
	echo'';
}

$Template->footer(false);
?>
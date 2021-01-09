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

function checkMedalListsSql(){
	global $DF;
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	if($scope == 'forum'){
		$scopeSql="AND ml.forumid = '".f."'";
	}
	elseif($scope == 'mod'){
		if(ulv < 4){
			$scopeSql="AND ml.forumid IN (".implode(",",$DF->getAllowForumId(true)).")";
		}
		else{
			$scopeSql="";
		}
	}
	elseif($scope == 'own'){
		$scopeSql="AND ml.added = ".uid."";
	}
	elseif($scope == 'all'){
		$scopeSql="";
	}
	
	if($app == 'design'){
		$appSql="AND ml.status = 2 AND ml.close = 0";
	}
	elseif($app == 'wait'){
		$appSql="AND ml.status = 0 AND ml.close = 0";
	}
	elseif($app == 'ok'){
		$appSql="AND ml.status = 1 AND ml.close = 0";
	}
	elseif($app == 'closed'){
		$appSql="AND ml.close = 1";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	$sql="$appSql $scopeSql";
	return $sql;
}
function checkMedalDistributeSql(){
	global $DF;
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$days=(days!=0?days:30);
	if($scope == 'forum'){
		$scopeSql="AND ml.forumid = '".f."'";
	}
	elseif($scope == 'mod'){
		if(ulv < 4){
			$scopeSql="AND ml.forumid IN (".implode(",",$DF->getAllowForumId(true)).")";
		}
		else{
			$scopeSql="";
		}
	}
	elseif($scope == 'own'){
		$scopeSql="AND m.added = ".uid."";
	}
	elseif($scope == 'all'){
		$scopeSql="";
	}
	
	if(m>0){
		$mSql="AND m.listid = '".m."'";
	}
	if(u>0){
		$uSql="AND m.userid = '".u."'";
	}
	
	if($days == 30){
		$daysSql="AND m.date > '".(time-(30*86400))."'";
	}
	elseif($days == 60){
		$daysSql="AND m.date > '".(time-(60*86400))."'";
	}
	elseif($days == 180){
		$daysSql="AND m.date > '".(time-(180*86400))."'";
	}
	elseif($days == 365){
		$daysSql="AND m.date > '".(time-(365*86400))."'";
	}
	elseif($days == -1){
		$daysSql="";
	}
	
	if($app == 'wait'){
		$appSql="AND m.status = 0";
	}
	elseif($app == 'ok'){
		$appSql="AND m.status = 1";
	}
	elseif($app == 'ref'){
		$appSql="AND m.status = 2";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	$sql="$appSql $scopeSql $daysSql $mSql $uSql";
	return $sql;
}
function checkTitleListsSql(){
	global $DF;
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	if($scope == 'forum'){
		$scopeSql="AND tl.forumid = '".f."'";
	}
	elseif($scope == 'mod'){
		if(ulv < 4){
			$scopeSql="AND tl.forumid IN (".implode(",",$DF->getAllowForumId(true)).")";
		}
		else{
			$scopeSql="";
		}
	}
	elseif($scope == 'own'){
		$scopeSql="AND tl.added = ".uid."";
	}
	elseif($scope == 'all'){
		$scopeSql="";
	}
	
	if($app == 'wait'){
		$appSql="AND tl.status = 0";
	}
	elseif($app == 'ok'){
		$appSql="AND tl.status = 1";
	}
	elseif($app == 'close'){
		$appSql="AND tl.status = 2";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	$sql="$appSql $scopeSql";
	return $sql;
}
function checkMonGlobalSql(){
	global $DF;
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'mod');
	$days=(days!=0?days:30);
	if($scope == 'montype'){
		$mSql="AND m.montype = '".m."'";
	}
	elseif($scope == 'forum'){
		$scopeSql="AND m.forumid = '".f."'";
	}
	elseif($scope == 'mod'){
		if(ulv < 4){
			$scopeSql="AND m.forumid IN (".implode(",",$DF->getAllowForumId(true)).")";
		}
		else{
			$scopeSql="";
		}
	}
	elseif($scope == 'own'){
		$scopeSql="AND m.addedby = ".uid."";
	}
	elseif($scope == 'all'){
		$scopeSql="";
	}
	
	if(u>0){
		$uSql="AND m.userid = '".u."'";
	}
	
	if($days == 30){
		$daysSql="AND m.addeddate > '".(time-(30*86400))."'";
	}
	elseif($days == 60){
		$daysSql="AND m.addeddate > '".(time-(60*86400))."'";
	}
	elseif($days == 180){
		$daysSql="AND m.addeddate > '".(time-(180*86400))."'";
	}
	elseif($days == 365){
		$daysSql="AND m.addeddate > '".(time-(365*86400))."'";
	}
	elseif($days == -1){
		$daysSql="";
	}
	
	if($app == 'wait'){
		$appSql="AND m.status = 0";
	}
	elseif($app == 'ok'){
		$appSql="AND m.status = 1";
	}
	elseif($app == 'up'){
		$appSql="AND m.status = 2";
	}
	elseif($app == 'ref'){
		$appSql="AND m.status = 3";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	$sql="$appSql $scopeSql $daysSql $mSql $uSql";
	return $sql;
}
function checkComplainGlobalSql(){
	global $DF;
	$app=(app!=''?app:'ok');
	$scope=(scope!=''?scope:'all');
	$days=(days!=0?days:30);
	if($scope == 'forum'){
		$scopeSql="AND com.forumid = '".f."'";
	}
	elseif($scope == 'all'){
		$scopeSql="";
	}

	if($days == 30){
		$daysSql="AND com.senddate > '".(time-(30*86400))."'";
	}
	elseif($days == 60){
		$daysSql="AND com.senddate > '".(time-(60*86400))."'";
	}
	elseif($days == 180){
		$daysSql="AND com.senddate > '".(time-(180*86400))."'";
	}
	elseif($days == 365){
		$daysSql="AND com.senddate > '".(time-(365*86400))."'";
	}
	elseif($days == -1){
		$daysSql="";
	}
	
	if($app == 'new'){
		$appSql="AND com.status = 3";
	}
	elseif($app == 'ok'){
		$appSql="AND com.status = 1";
	}
	elseif($app == 'send'){
		$appSql="AND com.status = 2";
	}
	elseif($app == 'lock'){
		$appSql="AND com.status = 0";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	$allow=(ulv == 4 ? "" : "AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")");
	$sql="$appSql $scopeSql $daysSql $mSql $uSql $allow";
	return $sql;
}
function checkSurveyGlobalSql(){
	global $DF;
	$app=(app!=''?app:'all');
	
	if($app == 'open'){
		$appSql="AND s.status = 1";
	}
	elseif($app == 'close'){
		$appSql="AND s.status = 0";
	}
	elseif($app == 'all'){
		$appSql="";
	}
	
	$allow=(ulv == 4 ? "" : "AND (".ulv." > 1 AND NOT ISNULL(m.id) OR ".ulv." = 3 AND c.monitor = ".uid.")");
	$sql="$appSql $allow";
	return $sql;
}
function checkMonDays($agree,$up,$ref){
	if($ref>0||$agree == 0){
		return;
	}
	else{
		if($up>0){
			$limit=$up-$agree;
			$days="<font color=\"red\">".ceil($limit/86400)."</font>";
		}
		else{
			$limit=time-$agree;
			$days=ceil($limit/86400);
		}
	}
	return $days;
}
?>
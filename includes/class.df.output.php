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

class DFOutput{
	function __construct( $DF, $mysql ){
		$this->DF = $DF;
		$this->mysql = $mysql;
	}
	function getCnf($var, $type = 0){
		$sql = $this->mysql->query("SELECT value FROM ".prefix."config WHERE variable = '{$var}' AND type = '{$type}'", __FILE__, __LINE__);
		$rs = $this->mysql->fetchRow($sql);
		return $rs[0];
	}
	function setCnf($var,$val,$type='no'){
		$checkType=($type == 'no' ? "" : ", type = '{$type}'");
		$this->mysql->update("config SET value = '$val' $checkType WHERE variable = '$var'", __FILE__, __LINE__);
	}
	function inCnf($var,$val,$type){
		$this->mysql->insert("config (variable,value,type) VALUES ('$var','$val','$type')", __FILE__, __LINE__);
	}
	function count($where,$id='id'){
		$sql=$this->mysql->query("SELECT COUNT($id) FROM ".prefix.$where, __FILE__, __LINE__);
		$rs=$this->mysql->fetchRow($sql);
		return $rs[0];
	}
	function checkLoginName(){
		$user_name = $this->DF->getCookie('login_user_name');
		$user_pass = $this->DF->getCookie('login_user_pass');
		$rs = $this->mysql->queryAssoc("SELECT u.id, u.status, u.active, u.password
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE (u.entername = '{$user_name}' OR uf.email = '{$user_name}')", __FILE__, __LINE__);
		$id = intval($rs['id']);
		if($id == 0){
			$error = 'name';
		}
		else{
			if($rs['password'] != $user_pass){
				$error = 'pass';
				$this->setTryLogin($id);
			}
			elseif($rs['status'] == 0){
				$error = 'lock';
			}
			elseif($rs['status'] == 2){
				$error = 'wait';
			}
			elseif($rs['status'] == 3){
				$error = 'refuse';
			}
			else{
				$error = '';
			}
		}
		return $error;
	}
	function setTryLogin($uid){
		$longip = ip2;
		$expire = time - (60 * 60);
		$count = $this->count("trylogin WHERE userid = {$uid} AND ip = {$longip} AND date > {$expire}");
		if($count > 0){
			$this->mysql->update("trylogin SET count = count + 1, date = ".time." WHERE userid = {$uid} AND ip = {$longip}", __FILE__, __LINE__);
		}
		else{
			$this->mysql->insert("trylogin (userid, ip, count, date) VALUES ({$uid}, {$longip}, 1, ".time.")", __FILE__, __LINE__);
		}
	}
	function setLoginDetails(){
		$uid = uid;
		if($uid > 0){
			$longip = ip2;
			if(uip != $longip){
				$this->mysql->insert("loginip (userid, ip, date) VALUES ({$uid}, {$longip}, ".time.")", __FILE__, __LINE__);
				$other_update = ", ip = {$longip}, allip = IF(allip LIKE '%@{$longip}@%', allip, IF(allip = '', '@{$longip}@', CONCAT('@{$longip}@|', allip)))";
			}
			$this->mysql->update("userflag SET lhdate = ".time."{$other_update} WHERE id = {$uid}", __FILE__, __LINE__);
		}
	}
	function setHackerDetails($subject){
		$count=$this->count("hacker WHERE ip = ".ip2." AND subject = '{$subject}' AND referer = '".referer."'");
		if($count>0){
			$this->mysql->update("hacker SET count = count + 1, date = ".time." WHERE subject = '$subject' AND ip = ".ip2."", __FILE__, __LINE__);
		}
		else{
			$this->mysql->insert("hacker (userid,ip,url,referer,subject,count,date) VALUES (".uid.",".ip2.",'".self."','".referer."','$subject',1,".time.")", __FILE__, __LINE__);
		}
	}
	function onlineInForum($f=f){
		$count=$this->count("online WHERE level < '4' AND forumid = '$f'");
	    return $count;
	}
	function setOnline(){
		$longip = ip2;
		if(f > 0){
			$f = f;
		}
		else{
			$f = (_df_script == 'topics') ? intval($this->DF->catch['_this_forum']) : 0;
		}
		if( ulv > 0 ){
			$url = basename( str_replace("'", "", self) );
			$this->mysql->query("REPLACE INTO ".prefix."useronline(ip, userid, level, forumid, hidebrowse, url, date) VALUES({$longip}, ".uid.", ".ulv.", {$f}, ".uhidebrowse.", '{$url}', ".time.")", __FILE__, __LINE__);
			$this->mysql->delete("useronline WHERE date < ".(time - 3600)."", __FILE__, __LINE__);
		}
		else{
			$this->mysql->query("REPLACE INTO ".prefix."visitors(ip, forumid, date) VALUES('{$longip}', {$f}, ".time.")", __FILE__, __LINE__);
			$this->mysql->delete("visitors WHERE date < ".(time - 3600)."", __FILE__, __LINE__);
		}
	}
	function setForumBrowse($f=f){
		$d=explode("-",date("Y-m-d-H-i",gmttime));
		$sess=ip.".{$d[0]}.{$d[1]}.{$d[2]}.{$d[3]}.{$d[4]}";
		if($_SESSION['forumbrowse'] == $sess){
			$doInsert=false;
		}
		else{
			$doInsert=true;
			$_SESSION['forumbrowse']=$sess;
		}
		if($doInsert){
			$rs=$this->mysql->queryRow("SELECT id FROM ".prefix."forumbrowse WHERE forumid = $f AND year = $d[0] AND month = $d[1] AND day = $d[2] AND hour = $d[3]", __FILE__, __LINE__);
			$id=(int)$rs[0];
			if($id>0){
				$this->mysql->update("forumbrowse SET visit = visit + 1 WHERE id = $id", __FILE__, __LINE__);
			}
			else{
				$this->mysql->insert("forumbrowse (forumid,year,month,day,hour) VALUES ($f,$d[0],$d[1],$d[2],$d[3])", __FILE__, __LINE__);
			}
		}
	}
	function setModActivity( $type, $f, $moderator ){
		if( $moderator && ulv == 2 ){
			if( $type == 'allow' || $type == 'complain' || $type == 'mon' || $type == 'pm' ){
				$points = 1;
			}
			elseif( $type == 'medal' || $type == 'post' ){
				$points = 2;
			}
			elseif( $type == 'survey' ){
				$points = 3;
			}
			elseif( $type == 'topic' ){
				$points = 4;
			}
			elseif( $type == 'online' ){
				$sessName = "modonline".uid;
				if( !isset($_SESSION["{$sessName}"]) ){
					$_SESSION["{$sessName}"] = 0;
				}
				$_SESSION["{$sessName}"] += 0.1;
				if( $_SESSION["{$sessName}"] >= 1 ){
					$points = 1;
					$_SESSION["{$sessName}"] = 0;
				}
				else{
					return;
				}
			}
			else{
				$points = 0;
			}
			$rs = $this->mysql->queryRow("SELECT id,date FROM ".prefix."modactivity WHERE userid = ".uid." AND forumid = $f", __FILE__, __LINE__);
			$id = (int)$rs[0];
			$d = explode( "-", date("Y-m-d", ( $id > 0 ? $rs[1] : 0 ) ) );
			$n = explode( "-", date("Y-m-d", gmttime) );
			if( $id > 0 && $d[0] == $n[0] && $d[1] == $n[1] && $d[2] == $n[2] ){
				$this->mysql->update("modactivity SET points = points + {$points} WHERE id = $id", __FILE__, __LINE__);
			}
			else{
				$c = (int)$this->mysql->get("forum", "catid", $f);
				$this->mysql->insert("modactivity (userid,forumid,catid,points,date) VALUES (".uid.",$f,$c,$points,".gmttime.")", __FILE__, __LINE__);
			}
		}
	}
	function setUserActivity($type,$f=0,$uid=uid,$points=0){
		if($uid>0){
			$ulv=($uid == uid ? ulv : $this->mysql->get("user","level",$uid));
			if($ulv < 4){
				if(
					($type == 'profileview'||$type == 'topicview'||$type == 'topicprint'||$type == 'topicfav'||$type == 'topicsend')&&
					uid!=$uid&&!isset($_SESSION["user{$type}{$uid}"])
				){
					$points=1;
					$_SESSION["user{$type}{$uid}"]=1;
				}
				elseif($type == 'topicpost'&&uid!=$uid||$type == 'complain'||$type == 'vote'){
					$points=1;
				}
				elseif($type == 'post'){
					$points=2;
				}
				elseif($type == 'topic'){
					$points=3;
				}
				elseif($type == 'medal'){
					$points=(int)$points;
				}
				elseif($type == 'online'){
					$sessName="useronline{$uid}";
					if(!isset($_SESSION[$sessName])) $_SESSION[$sessName]=0;
					$_SESSION[$sessName]+=0.1;
					if($_SESSION[$sessName]>=1){
						$points=1;
						$_SESSION[$sessName]=0;
					}
					else{
						return;
					}
				}
				else{
					$points=0;
				}
				if($points>0){
					$rs=$this->mysql->queryRow("SELECT id,date FROM ".prefix."useractivity WHERE userid = {$uid} AND forumid = {$f}", __FILE__, __LINE__);
					$id=(int)$rs[0];
					$d=explode("-",date("Y-m-d",($id>0 ? $rs[1] : 0)));
					$n=explode("-",date("Y-m-d",gmttime));
					if($id>0&&$d[0] == $n[0]&&$d[1] == $n[1]&&$d[2] == $n[2]){
						$this->mysql->update("useractivity SET points = points + {$points} WHERE id = {$id}", __FILE__, __LINE__);
					}
					else{
						if($f>0) $c=(int)$this->mysql->get("forum","catid",$f);
						else $c=0;
						$this->mysql->insert("useractivity (userid,forumid,catid,points,date) VALUES ({$uid},{$f},{$c},{$points},".gmttime.")", __FILE__, __LINE__);
					}
				}
			}
		}
	}
	function friendStatus($uid){
		/*
		status:-
		0  = can you send request
		1  = error in user id
		2  = you and him is one
		3  = he is locked
		4  = he not allow friendship
		5  = you blocked by him
		6  = he blocked by you
		7  = the friendship between you and him is active
		8  = your request wait his accept
		9  = his requset wait your accept
		10 = your request was refused
		11 = his request was refused
		*/
		$status=0;
		if($uid == uid) $status=2;
		else{
			$rs=$this->mysql->queryRow("SELECT u.id,
			IF(u.status <> 1,3,
				IF((up.allowfriendship = 0 AND ".ulv." <= u.level),4,
					IF((NOT ISNULL(b.id) AND b.blockid = ".uid." AND ".ulv." <= u.level),5,
						IF((NOT ISNULL(b.id) AND b.userid = ".uid." AND ".ulv." <= u.level),6,
							IF(ISNULL(f.id),0,
								IF((f.userid = ".uid." OR f.friendid = ".uid.") AND f.status = 1,7,
									IF(f.userid = ".uid." AND f.status = 0,8,
										IF(f.friendid = ".uid." AND f.status = 0,9,
											IF(f.userid = ".uid." AND f.status = 2,10,
												IF(f.friendid = ".uid." AND f.status = 2,11,0)
											)
										)
									)
								)
							)
						)
					)
				)
			)
			FROM ".prefix."user AS u
			LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
			LEFT JOIN ".prefix."friends AS f ON(u.id = f.friendid AND f.userid = ".uid.") OR (u.id = f.userid AND f.friendid = ".uid.")
			LEFT JOIN ".prefix."blocks AS b ON(b.blockid = ".uid." AND b.userid = u.id OR b.userid = ".uid." AND b.blockid = u.id)
			WHERE u.id = {$uid} GROUP BY u.id LIMIT 1", __FILE__, __LINE__);
			$u=(int)$rs[0];
			if($u == 0) $status=1;
			else $status=(int)$rs[1];
		}
		return $status;
	}
	function setNotification($type,$author,$postid=0,$topicid=0,$userid=uid){
		if(strlen($type) == 3&&$author>0) $this->mysql->insert("notification (author,userid,type,topicid,postid,date) VALUES ({$author},{$userid},'{$type}',{$topicid},{$postid},".time.")", __FILE__, __LINE__);
	}
}

?>
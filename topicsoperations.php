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

if(_df_script == 'topics'&&is_object($mysql)&&is_object($DF)&&$is_moderator){
	$id=trim($_POST['id']);
	$type=trim($_POST['type']);
	$other=trim($_POST['other']);
	$other=explode("|",$other);
	$posttype=trim($_POST['posttype']);
	$cmd=(int)$_POST['cmd'];
	$checkTopicOpsString=t."{$id}{$type}{$cmd}";
	if($cmd>0&&!empty($type)&&!empty($id)&&$DF->getCookie('checkTopicOpsString')!=$checkTopicOpsString){
		$DF->setCookie('checkTopicOpsString',$checkTopicOpsString);
		$AllowForumId=implode(",",$DF->getAllowForumId(true));
		$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في خيارات مشرفين بداخل الموضوع");
		if($type == 'mo'){
			$DFOutput->setModActivity('allow',$DF->catch['_this_forum'],true);
		}
		$opType=array(
			'mo'=>array('field'=>'moderate','value'=>'0','type'=>'mo'),
			'ho'=>array('field'=>'moderate','value'=>'2','type'=>'mo'),
			
			'hd'=>array('field'=>'hidden','value'=>'1','type'=>'hd'),
			'vs'=>array('field'=>'hidden','value'=>'0','type'=>'hd'),
			
			'lk'=>array('field'=>'status','value'=>'0','type'=>'lk'),
			'op'=>array('field'=>'status','value'=>'1','type'=>'lk'),
			
			'yv'=>array('field'=>'viewforusers','value'=>'0','type'=>''),
			'nv'=>array('field'=>'viewforusers','value'=>'1','type'=>''),
			
			'dl'=>array('field'=>'trash','value'=>'1','type'=>'dl'),
			're'=>array('field'=>'trash','value'=>'0','type'=>'dl')
		);
		if($cmd == 1){
			if(is_array($oprs=$opType[$type])&&($type!='dl'&&$type!='re'||$is_monitor)){
				$mysql->update("post SET {$oprs['field']} = '{$oprs['value']}' WHERE id IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
				$ids=explode(",",$id);
				if($type == 'mo') $ntype='apr';
				elseif($type == 'ho') $ntype='hor';
				elseif($type == 'hd') $ntype='hir';
				elseif($type == 'vs') $ntype='shr';
				else $ntype='';
				if(!empty($ntype)){
					$posts=array();
					foreach($other as $v){
						$v=explode("-",$v);
						$posts[$v[0]]=array($v[1],$v[2]);
					}
				}
				for($x=0;$x<count($ids);$x++){
					$id=(int)$ids[$x];
					if($id>0){
						$operations=unserialize($mysql->get("postmessage","operations",$id));
						if(!is_array($operations)) $operations=array();
						$operations[]=time."::{$oprs['type']}::{$oprs['value']}::".uid."::".uname;
						$mysql->update("postmessage SET operations = '".serialize($operations)."' WHERE id = '{$id}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						if(!empty($ntype)) $DFOutput->setNotification($ntype,$posts[$id][0],$id,$posts[$id][1]);
					}
				}
				$DF->quick(self);
			}
			else{
				$DF->quick(self);
			}
		}
		elseif($cmd == 2){
			if(is_array($oprs=$opType[$type])&&($type!='dl'&&$type!='re'||$is_monitor)){
				$checkPostType=($posttype == 1 ? 'post' : 'topic');
				$mysql->update("$checkPostType SET {$oprs['field']} = '{$oprs['value']}' WHERE id = '{$id}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
				if($oprs['type']!=''){
					$operations=unserialize($mysql->get("{$checkPostType}message","operations",$id));
					if(!is_array($operations)) $operations=array();
					$operations[]=time."::{$oprs['type']}::{$oprs['value']}::".uid."::".uname;
					$mysql->update("{$checkPostType}message SET operations = '".serialize($operations)."' WHERE id = '{$id}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
					if($type == 'mo') $ntype=($posttype == 1 ? 'apr' : 'apt');
					elseif($type == 'ho') $ntype=($posttype == 1 ? 'hor' : 'hot');
					elseif($type == 'hd') $ntype=($posttype == 1 ? 'hir' : 'hit');
					elseif($type == 'vs') $ntype=($posttype == 1 ? 'shr' : 'sht');
					elseif($type == 'lk'&&$posttype == 0) $ntype='lot';
					elseif($type == 'op'&&$posttype == 0) $ntype='opt';
					else $ntype='';
					if(!empty($ntype)){
						if($posttype == 1) $DFOutput->setNotification($ntype,$other[0],$id,$other[1]);
						else $DFOutput->setNotification($ntype,$other[0],0,$id);
					}
				}
				$DF->quick(self);
			}
			else{
				$DF->quick(self);
			}
		}
		else{
			$DF->quick(self);
		}
	}
}
if(method == 'hidepost'&&ulv > 1&&!$is_moderator){
	$sql=$mysql->query("SELECT p.id,p.author,p.topicid
	FROM ".prefix."post AS p 
	LEFT JOIN ".prefix."topic AS t ON(t.id = p.topicid)
	LEFT JOIN ".prefix."forum AS f ON(f.id = p.forumid)
	WHERE p.id = ".id." AND f.status = 1 AND f.hidden = 0 AND f.level = 0 AND t.hidden = 0 AND t.moderate = 0 AND t.trash = 0 AND t.status = 1 AND p.trash = 0 AND p.hidden = 0 AND p.moderate = 0", __FILE__, __LINE__);
	$hiders=$mysql->fetchRow($sql);
	if($hiders){
		$mysql->update("post SET hidden = 1 WHERE id = ".id."", __FILE__, __LINE__);
		$DFOutput->setNotification('hir',$hiders[1],id,$hiders[2]);
		$operations=unserialize($mysql->get("postmessage","operations",id));
		if(!is_array($operations)) $operations=array();
		$operations[]=time."::hd::1::".uid."::".uname;
		$operations=serialize($operations);
		$mysql->update("postmessage SET operations = '{$operations}' WHERE id = ".id."", __FILE__, __LINE__);
		$DF->quick(urldecode(src));
	}
}
?>
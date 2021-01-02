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

if(_df_script=='forums'&&is_object($mysql)&&is_object($DF)&&$isModerator){
	$id=trim($_POST['id']);
	$type=trim($_POST['type']);
	$other = trim($_POST['other']);
	$cmd=$_POST['cmd'];
	$checkForumOpsString="".f."{$id}{$type}{$cmd}";
	if($cmd>0&&!empty($type)&&!empty($id)&&$DF->getCookie('checkForumOperations')!=$checkForumOpsString){
		$DF->setCookie('checkForumOperations',$checkForumOpsString);
		$AllowForumId=implode(",",$DF->getAllowForumId(true));
		$Template->checkHackerTry("عملية املاء الفورم بطريق غير شرعي في خيارات مشرفين بداخل المنتدى");
		if($type=='mo'){
			$DFOutput->setModActivity('allow',f,true);
		}
		$opType=array(
			'mo'=>array('field'=>'moderate','value'=>'0','type'=>'mo'),
			'ho'=>array('field'=>'moderate','value'=>'2','type'=>'mo'),
			
			'hd'=>array('field'=>'hidden','value'=>'1','type'=>'hd'),
			'vs'=>array('field'=>'hidden','value'=>'0','type'=>'hd'),
			
			'lk'=>array('field'=>'status','value'=>'0','type'=>'lk'),
			'op'=>array('field'=>'status','value'=>'1','type'=>'lk'),
			
			'st'=>array('field'=>'sticky','value'=>'1','type'=>'st'),
			'us'=>array('field'=>'sticky','value'=>'0','type'=>'st'),
			
			't0'=>array('field'=>'top','value'=>'0','type'=>''),
			't1'=>array('field'=>'top','value'=>'1','type'=>''),
			't2'=>array('field'=>'top','value'=>'2','type'=>''),
			
			'yv'=>array('field'=>'viewforusers','value'=>'0','type'=>''),
			'nv'=>array('field'=>'viewforusers','value'=>'1','type'=>''),
			
			'ln'=>array('field'=>'link','value'=>'1','type'=>''),
			'ul'=>array('field'=>'link','value'=>'0','type'=>''),
			
			'mv'=>array('field'=>'move','value'=>f,'type'=>'mv'),
			
			'dl'=>array('field'=>'trash','value'=>'1','type'=>'dl'),
			're'=>array('field'=>'trash','value'=>'0','type'=>'dl'),
			
			'ar'=>array('field'=>'archive','value'=>'1','type'=>''),
			'ua'=>array('field'=>'archive','value'=>'0','type'=>'')
		);
		if($cmd==1){
			$id = explode(",", $id);
			$newid = array();
			for($x = 0; $x < count($id); $x++){
				$newid[] = intval($id[$x]);
			}
			$id = implode(",", $newid);
			if(is_array($oprs=$opType[$type])&&($type!='dl'&&$type!='re'&&$type!='ar'&&$type!='ur'||$isMonitor)){
				if($type=='mv'){
					$mysql->update("topic SET sticky = 0 WHERE id IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
				}
				else{
					$mysql->update("topic SET {$oprs['field']} = '{$oprs['value']}' WHERE id IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
				}
				if($type=='mo') $ntype='apt';
				elseif($type=='ho') $ntype='hot';
				elseif($type=='hd') $ntype='hit';
				elseif($type=='vs') $ntype='sht';
				elseif($type=='lk') $ntype='lot';
				elseif($type=='op') $ntype='opt';
				elseif($type=='st') $ntype='stt';
				elseif($type=='us') $ntype='ust';
				elseif($type=='t1') $ntype='srt';
				elseif($type=='t2') $ntype='met';
				elseif($type=='mv') $ntype='mot';
				else $ntype='';
				if(!empty($ntype)){
					$other = explode("|", $other);
					$topics = array();
					foreach($other as $v){
						$v = explode("-", $v);
						$topics[$v[0]] = $v[1];
					}
				}
				$ids = explode(",", $id);
				$count = 0;
				for($x = 0; $x < count($ids); $x++){
					$tid = (int)$ids[$x];
					if($tid > 0){
						if($oprs['type'] != ''){
							$operations=unserialize($mysql->get("topicmessage","operations",$tid));
							if(!is_array($operations)) $operations=array();
							$operations[]=time."::{$oprs['type']}::{$oprs['value']}::".uid."::".uname;
							$mysql->update("topicmessage SET operations = '".serialize($operations)."' WHERE id = '{$tid}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
							$count++;
						}
						if(!empty($ntype)) $DFOutput->setNotification($ntype,$topics[$tid],0,$tid);
					}
				}
				if($type=='mv'){
					if(($fid=(int)$_POST['definedForumList'])>0){
						$cid=$mysql->get("forum","catid",$fid);
						$sql=$mysql->query("SELECT SUM(posts) FROM ".prefix."topic WHERE id IN({$id})", __FILE__, __LINE__);
						$countPosts=$mysql->fetchRow($sql);
						$mysql->update("post SET catid = '{$cid}', forumid = '{$fid}' WHERE topicid IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("postmessage SET catid = '{$cid}', forumid = '{$fid}' WHERE topicid IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("topic SET catid = '{$cid}', forumid = '{$fid}' WHERE id IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("topicmessage SET catid = '{$cid}', forumid = '{$fid}' WHERE id IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("topicusers SET catid = '{$cid}', forumid = '{$fid}' WHERE topicid IN({$id}) AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("forum SET topics = topics - {$count}, posts = posts - {$countPosts[0]} WHERE id = ".f." AND (".ulv." = 4 OR id IN ({$AllowForumId}))", __FILE__, __LINE__);
						$mysql->update("forum SET topics = topics + {$count}, posts = posts + {$countPosts[0]} WHERE id = '{$fid}' AND (".ulv." = 4 OR id IN ({$AllowForumId}))", __FILE__, __LINE__);
					}
				}
				$DF->quick(self);
			}
			else{
				$DF->quick(self);
			}
		}
		elseif($cmd==2){
			$id = intval($id);
			if(is_array($oprs=$opType[$type])&&($type!='dl'&&$type!='re'||$isMonitor)){
				if($type!='mv'){
					$mysql->update("topic SET {$oprs['field']} = '{$oprs['value']}' WHERE id = '{$id}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
				}
				if($oprs['type']!=''){
					$operations=unserialize($mysql->get("topicmessage","operations",$id));
					if(!is_array($operations)) $operations=array();
					$operations[]=time."::{$oprs['type']}::{$oprs['value']}::".uid."::".uname;
					$mysql->update("topicmessage SET operations = '".serialize($operations)."' WHERE id = '{$id}' AND (".ulv." = 4 OR forumid IN ({$AllowForumId}))", __FILE__, __LINE__);
					if($type=='mo') $ntype='apt';
					elseif($type=='ho') $ntype='hot';
					elseif($type=='hd') $ntype='hit';
					elseif($type=='vs') $ntype='sht';
					elseif($type=='lk') $ntype='lot';
					elseif($type=='op') $ntype='opt';
					elseif($type=='st') $ntype='stt';
					elseif($type=='us') $ntype='ust';
					else $ntype='';
					$author=(int)$other;
					if(!empty($ntype)&&$author>0) $DFOutput->setNotification($ntype,$author,0,$id);
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
?>
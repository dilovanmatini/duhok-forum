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

const _df_script = "wait";
const _df_filename = "wait.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv < 2) $DF->quick();
$is_moderator=$DF->showTools(f,uid);
$f=f;
$ForumSubject=$mysql->get("forum","subject",f);
$ForumLogo=$mysql->get("forum","logo",f);
require_once _df_path."includes/func.post.php";
require_once _df_path."topicsoperations.php";
$Template->header();
if($is_moderator == 0){
$Template->errMsg("المنتدى المطلوب غير متوفر.<br>");
exit();
}

?>
<?php if($is_moderator){ ?>
<script type="text/javascript" src="js/topics_mod.js<?=x?>"></script>
<?php } ?>
<script type="text/javascript" src="js/share.js<?=x?>"></script>
<script type="text/javascript">
var forumid=<?=$f?>,topicid=1,numPages=<?=post_num_page?>,pg=<?=pg?>,link="<?=$pagingLink?>";
</script>
<?php
echo"
<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
	<tr>
		<td class=\"asTopHeader\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1000\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td rowspan=\"2\"><a href=\"foruminfo.php?f=$f\"><img class=\"asWDot\" src=\"{$ForumLogo}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" alt=\"معلومات عن المنتدى\" width=\"30\" height=\"30\" hspace=\"6\" border=\"0\"></a></td>
						<td class=\"asAS18\"><nobr>{$Template->forumLink(f,$ForumSubject,'','sec')}</nobr></td>
					</tr>
				</table>
				</td>";
		
				echo ($goToForum=$Template->goToForum(true));
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">
		<table cellSpacing=\"0\" cellPadding=\"0\">
			<tr>";
				modOptions(1);
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<div id=\"sharePanel1\" style=\"margin:2px;border:gray 1px solid;background-color:#f0f0f0;text-align:center;visibility:hidden;position:absolute;top:2px;left:2px\"></div>
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\">";
if($is_moderator){
	echo"
	<form id=\"optionsFrm\" name=\"optionsFrm\" method=\"post\" action=\"".self."\" style=\"margin:0px\">
	<input type=\"hidden\" name=\"type\">
	<input type=\"hidden\" name=\"other\">
	<input type=\"hidden\" name=\"posttype\">
	<input type=\"hidden\" name=\"id\">
	<input type=\"hidden\" name=\"cmd\">";
}


echo"
<tr>
	<td class=\"asBody asCenter\" colspan=\"2\">";
	echo"
	</td>
</tr>";
$pgLimit=$DF->pgLimit(post_num_page);
$sql=$mysql->query("SELECT p.id,p.forumid,p.topicid,p.hidden,p.moderate,p.trash,p.author,p.editby,p.editdate,p.editnum,p.date,
	u.name AS aname,u.status AS astatus,u.level AS alevel,u.submonitor AS asubmonitor,uf.posts AS aposts,uf.points AS apoints,uf.sex AS asex,
	uf.title AS atitle,uf.oldlevel AS aoldlevel,uf.picture AS apicture,up.hidesignature AS ahidesignature,
	up.hidephoto AS ahidephoto,up.hideposts AS ahideposts,ic.name AS acountry,
	u.date AS adate,uu.name AS editbyname,".(topics_signature == 'visible'?"uf.signature,":"")." pm.message,
	pm.operations,IF(NOT ISNULL(uo.userid),1,0) AS isonline
FROM ".prefix."post AS p
LEFT JOIN ".prefix."postmessage AS pm ON(pm.id = p.id)
LEFT JOIN ".prefix."user AS u ON(u.id = p.author)
LEFT JOIN ".prefix."user AS uu ON(uu.id = p.editby)
LEFT JOIN ".prefix."userflag AS uf ON(uf.id = p.author)
LEFT JOIN ".prefix."userperm AS up ON(up.id = p.author)
LEFT JOIN ".prefix."country AS ic ON(ic.code = uf.country)
LEFT JOIN ".prefix."useronline AS uo ON(uo.userid = p.author AND (up.hidebrowse = 0 OR ".ulv." > 1 AND u.level < 3 OR ".ulv." > 2 AND u.level < 4 OR ".ulv." = 4))
WHERE p.forumid = '".f."' and p.moderate=1 GROUP BY p.id ORDER BY p.date ASC LIMIT 50", __FILE__, __LINE__);
$count=0;
while($post=$mysql->fetchAssoc($sql)){
	//******* start post *************
	$p=$post['id'];
	$t=$post['topicid'];
	if($post['trash'] == 1){
		$rowClass="asDelete";
		$postErrorMsg="** هذه المشاركة محذوفة **";
	}
	elseif($post['ahideposts'] == 1){
		$rowClass="asFirst";
		$postErrorMsg="** تم إخفاء نص هذه المشاركة بواسطة الإدارة **";
	}
	elseif($post['moderate'] == 1){
		$rowClass="asFirst";
		$postErrorMsg="** هذه المشاركة لم يتم مراجعتها والموافقة عليها بواسطة مشرف المنتدى حتى الآن **";
	}
	elseif($post['moderate'] == 2){
		$rowClass="asFirst";
		$postErrorMsg="** هذه المشاركة مجمدة حتى إشعار آخر -- للإستفسار عن سبب الرجاء الإتصال بمشرف المنتدى **";
	}
	elseif($post['hidden'] == 1){
		$rowClass="asHidden";
		$postErrorMsg="** تم اخفاء هذه المشاركة -- للإستفسار عن السبب الرجاء الإتصال بمشرف المنتدى **";
	}
	else{
		$rowClass=($count%2 ? "asFixed" : "asNormal");
		$postErrorMsg="";
	}
	
	if($is_moderator){
		$jsPosts.="posts[{$p}]=[{$post['hidden']},{$post['moderate']},{$post['trash']},{$post['author']}];";
	}

	echo"
	<tr>
		<td id=\"p1Cell{$p}\" class=\"{$rowClass}\" width=\"17%\" align=\"center\" vAlign=\"top\">";
		
	if($post['alevel'] == 4){
		echo"
		<table width=\"100%\" cellspacing=\"0\" cellpadding=\"4\">
			<tr>
				<td class=\"asHeader\">{$Template->userNormalLink($post['author'],$post['aname'],'white')}</td>
			</tr>
			<tr>
				<td class=\"asNormalDot asS12 asCenter\">{$post['atitle']}</td>
			</tr>
		</table>";
	}
	else{
		echo"
		<table width=\"100%\" cellspacing=\"1\" cellpadding=\"4\">
			<tr>
				<td class=\"asDarkDot asAC1\" colspan=\"2\">{$Template->userNormalLink($post['author'],$post['aname'])}</td>
			</tr>";
		if(ulv > 0&&$post['astatus'] == 0){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><font color=\"red\">عضوية مقفولة</font></td>
			</tr>";
		}
		if(ulv > 0&&($post['astatus'] == 1||$is_moderator)&&($topic['hideprofile'] == 0||$is_moderator)){
		/******************* Start user details ********************/
		if($post['ahidephoto'] == 0||$is_moderator){
			echo"
			<tr>
				<td class=\"asNormalDot asCenter\" colspan=\"2\"><img src=\"{$DFPhotos->getsrc($post['apicture'], 200)}\"{$DF->picError(100)} width=\"100\" height=\"100\" class=\"asBGray\" border=\"0\"></td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\">
				{$DF->userStars($post['aposts'], $post['alevel'], $post['asubmonitor'])}<br>
				".userAllTitles($post['author'], $post['alevel'], $post['aposts'], $post['atitle'], $post['asex'], $post['aoldlevel'], $post['asubmonitor'])."
				</td>
			</tr>
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>المشاركات</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>{$post['aposts']}</nobr></td>
			</tr>";
		if($post['alevel'] == 1&&$post['apoints']>0){
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr><font color=\"red\">نقاط التميز</font></nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr><font color=\"red\">{$post['apoints']}</font></nobr></td>
			</tr>";
		}
		if(!empty($post['acountry'])){
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>الدولة</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\">{$post['acountry']}</td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>عدد الأيام</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>".(($userTotalDays=$DF->catch['userTotalDays'][$post['author']]) ? $userTotalDays : ($DF->catch['userTotalDays'][$post['author']]=userTotalDays($post['adate'])))."</nobr></td>
			</tr>
			<tr>
				<td class=\"asNormalDot asS12\"><nobr>معدل مشاركات</nobr></td>
				<td class=\"asNormalDot asS12 asCenter\"><nobr>".(($userMiddlePosts=$DF->catch['userMiddlePosts'][$post['author']]) ? $userMiddlePosts : ($DF->catch['userMiddlePosts'][$post['author']]=userMiddlePosts($post['aposts'],$post['adate'])))."</nobr></td>
			</tr>";
		if($post['isonline'] == 1){
			echo"
			<tr>
				<td class=\"asNormalDot asS12 asCenter\" colspan=\"2\"><img src=\"{$DFImage->i['online']}\" border=\"0\"><br>متصل الآن</td>
			</tr>";
		}
		/******************* End user details ********************/
		}
		echo"
		</table>";
	}
		echo"</td>
		<td id=\"p2Cell{$p}\" class=\"{$rowClass}\" width=\"100%\" vAlign=\"top\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"asPostIcon\">
				<table width=\"100%\" cellSpacing=\"2\">
					<tr>
						<td class=\"asPostIcon\"><nobr>{$DF->date($post['date'])}</nobr></td>
						<td class=\"asPostIcon\"><a href=\"profile.php?u={$post['author']}\"><img src=\"{$DFImage->i['user_profile']}\" alt=\"معلومات عن العضو\" border=\"0\"></a></td>";
			if( ulv > 0 ){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=sendpm&u={$post['author']}&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message']}\" alt=\"أرسل رسالة خاصة لهذا العضو\" border=\"0\"></a></td>";
					if($is_moderator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=sendpm&u={$post['author']}&f=-$f&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['message_forum']}\" alt=\"أرسل رسالة خاصة من الأشراف إلى هذا العضو\" border=\"0\"></a></td>";
					}
					if($topic['status'] == 1||$is_moderator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=quotepost&t=$t&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['reply']}\" alt=\"رد على المشاركة بإضافة نص هذه المشاركة\" border=\"0\"></a></td>";
					}
					if($topic['status'] == 1&&$post['author'] == uid||$is_moderator){
						echo"
						<td class=\"asPostIcon\"><a href=\"editor.php?type=editpost&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['post_edit']}\" alt=\"تعديل المشاركة\" border=\"0\"></a></td>";
					}
					if(uid!=$post['author']){
						echo"
						<td class=\"asPostIcon\"><a href=\"options.php?type=complain&method=post&u={$post['author']}&p=$p&src=".urlencode(self)."\"><img src=\"{$DFImage->i['complain']}\" alt=\"لفت انتباه المشرف الى هذه المشاركة\" border=\"0\"></a></td>";
					}
				if($is_moderator){
					if($post['moderate']>=1){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'mo',1);\"><img src=\"{$DFImage->i['approve']}\" alt=\"موافقة على المشاركة\" border=\"0\"></a></td>";
					}
					if($post['moderate'] == 1){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'ho',1);\"><img src=\"{$DFImage->i['hold']}\" alt=\"تجميد المشاركة\" border=\"0\"></a></td>";
					}
					if($post['hidden'] == 0){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'hd',1);\"><img src=\"{$DFImage->i['hidden']}\" alt=\"إخفاء المشاركة\" border=\"0\"></a></td>";
					}
					else{
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'vs',1);\"><img src=\"{$DFImage->i['visible']}\" alt=\"إظهار المشاركة\" border=\"0\"></a></td>";
					}
					if($post['trash'] == 0&&$is_monitor){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'dl',1);\"><img src=\"{$DFImage->i['post_delete']}\" alt=\"حذف المشاركة\" border=\"0\"></a></td>";
					}
					elseif($post['trash'] == 1&&$is_monitor){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.command($p,'re',1);\"><img src=\"{$DFImage->i['post_up']}\" alt=\"إرجاع المشاركة\" border=\"0\"></a></td>";
					}
					if($post['author']!=uid&&$post['alevel']<=ulv&&$post['alevel']<4){
						echo"
						<td class=\"asPostIcon\"><a href=\"svc.php?svc=mons&type=addmon&method=post&u={$post['author']}&p=$p\"><img src=\"{$DFImage->i['mon']}\" alt=\"تطبيق العقوبة على العضو\" border=\"0\"></a></td>";
					}
				}
				else{
					if(ulv > 1&&$topic['hidden'] == 0&&$topic['moderate'] == 0&&$topic['trash'] == 0&&$topic['status'] == 1&&$post['trash'] == 0&&$post['hidden'] == 0&&$post['moderate'] == 0){
						echo"
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&method=hidepost&id=$p&src=".urlencode(self)."\"{$DF->confirm('هل أنت متأكد بأن تريد إخفاء هذه المشاركة')}><img src=\"{$DFImage->i['hidden']}\" alt=\"إخفاء المشاركة\" border=\"0\"></a></td>";
					}
				}
			}
						echo"
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&p=$p\"><img src=\"{$DFImage->i['single']}\" alt=\"هذا الرد فقط\" border=\"0\"></a></td>
						<td class=\"asPostIcon\"><a href=\"topics.php?t=$t&u={$post['author']}\"><img src=\"{$DFImage->i['users']}\" alt=\"ردود هذا العضو فقط\" border=\"0\"></a></td>
						<td class=\"asPostIcon\" width=\"90%\">&nbsp;</td>";
					if($is_moderator){
						echo"
						<td class=\"asPostIcon\"><a href=\"javascript:DF.selectUserPosts({$post['author']},'{$post['aname']}');\"><img src=\"{$DFImage->i['user_posts']}\" alt=\"وضع علامة الإختيار على جميع مشاركات هذا العضو في هذه الصفحة\" border=\"0\"></a></td>
						<td class=\"asPostIcon\"><input type=\"checkbox\" class=\"none\" name=\"posts\" value=\"$p\" onClick=\"DF.doSelectRow(this,{$p},'{$rowClass}');DF.checkChoose(false);\" author=\"{$post['author']}\" defclass=\"$rowClass\"></td>";
					}
					echo"
					</tr>
				</table>
				</td>
			</tr>
		</table>";
	// if(!empty($postErrorMsg)){
		echo"
		<table width=\"100%\">
			<tr>
				<td class=\"asTitle asWDot asAC2 asAS12\"><nobr><a href=\"topics.php?t={$post['topicid']}\">{$mysql->get("topic","subject",$t)}</a></nobr></td>
			</tr>
		</table>";
	// }
		echo"
		<table style=\"table-layout:fixed\" align=\"center\">
			<tr>
				<td>";
				if($post['ahideposts'] == 0||$post['author'] == uid||$is_moderator){
					echo str_replace("\\\"","",$post['message'])."<br>";
				}
				if( topics_signature == 'visible' && !empty($post['signature']) ){
					echo"
					<fieldset class=\"gray\">
						<legend>&nbsp;التوقيع</legend>";
					if($post['ahidesignature'] == 1) echo"<br><div class=\"asTitle asCenter asWDot asP5\">** تم إخفاء توقيع هذه العضوية بواسطة الإدارة **</div><br>";
					if($post['ahidesignature'] == 0||$post['author'] == uid||$is_moderator) echo $post['signature'];
					echo"
					</fieldset><br><br>";
				}
				echo"
				</td>
			</tr>
		</table>";
if( ulv > 0 ){
		$operMsg=array();
		$operMsg['hd'][1]="تم إخفاء المشاركة بواسطة";
		$operMsg['hd'][0]="تم إظهار المشاركة بواسطة";
		$operMsg['mo'][2]="تم تجميد المشاركة بواسطة";
		$operMsg['mo'][0]="تمت موافقة على المشاركة بواسطة";
		$operMsg['dl'][1]="تم حذف المشاركة بواسطة";
		$operMsg['dl'][0]="تم إسترجاع المشاركة بواسطة";
		$operations=unserialize($post['operations']);
	if(is_array($operations)||$post['editnum']>0){
			echo"
			<table cellspacing=\"2\" cellpadding=\"2\" align=\"{$Template->align}\" border=\"0\">";
		if(is_array($operations)){
			$operations=array_reverse($operations);
			foreach($operations as $val){
				$exp=explode("::",$val);
				$opMessage=$operMsg["{$exp[1]}"][$exp[1] == 'mv'?0:$exp[2]];
				echo"
				<tr>
					<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($exp[0],'',true)} - $opMessage {$Template->userNormalLink($exp[3],$exp[4])}</nobr></td>
				</tr>";
			}
		}
		if($post['editnum']>0){
			$editNumIsMore="";
			if($post['editnum']>1){
				$editNumIsMore="<br><center>عدد مرات تغيير النص {$post['editnum']}</center>";
			}
				echo"
				<tr>
					<td class=\"asTitle asWDot asAC2 asAS12\"><nobr>{$DF->date($post['editdate'],'',true)} - آخر تغيير للنص بواسطة {$Template->userNormalLink($post['editby'],$post['editbyname'])}$editNumIsMore</nobr></td>
				</tr>";
		}
			echo"
			</table>";
	}
}
		echo"
		</td>
	</tr>";
	$count++;
	//********* end post ************
}
if($count == 0){
print $Template->errMsg('لا توجد ردود تنتظر الموافقة',0,true,true,'عفوا');
}
if($is_moderator){
	echo"
	</form>
	<script type=\"text/javascript\">var posts=new Array();{$jsPosts}</script>";
}




		echo"
		</table>
		<div id=\"sharePanel2\" style=\"margin:2px;border:gray 1px solid;background-color:#f0f0f0;text-align:center;visibility:hidden;position:absolute;top:2px;left:2px\"></div>
		</td>
	</tr>
	<tr>
		<td class=\"asHeader\">
		<table cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td></td>";
				modOptions(2);
			echo"
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class=\"asBody\">
		<table cellSpacing=\"3\" cellPadding=\"3\">
			<tr>
				<td width=\"1000\">
				<table cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td rowspan=\"2\"><a href=\"foruminfo.php?f=$f\"><img class=\"asWDot\" src=\"{$ForumLogo}\" onError=\"this.src='{$DFImage->i['errorlogo']}';\" alt=\"معلومات عن المنتدى\" width=\"30\" height=\"30\" hspace=\"6\" border=\"0\"></a></td>
						<td class=\"asAS18\"><nobr>{$Template->forumLink(f,$ForumSubject,'','sec')}</nobr></td>
					</tr>
				</table>
				</td>";
				echo $goToForum;
			echo"
			</tr>
		</table>
		</td>
	</tr>
</table>";
$Template->footer();
?>
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

const _df_script = "admin_stats";
const _df_filename = "admin_stats.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."globals.php";

if(ulv == 4 && cplogin === true){
$Template->adminHeader();
// Start Admin Control Panel
if($Template->adminType=='index'){
	echo"
	<table>
		<tr>
			<td>{$Template->adminToolsBox('setting','الخيارات')}</td>
			<td>{$Template->adminToolsBox('stats','الاحصائيات')}</td>
			<td>{$Template->adminToolsBox('templates','القوالب')}</td>
			<td>{$Template->adminToolsBox('groupmessages','رسائل جماعية')}</td>
			<td>{$Template->adminToolsBox('forums','المنتديات')}</td>
		</tr>
		<tr>
			<td>{$Template->adminToolsBox('users','العضويات')}</td>
			<td>{$Template->adminToolsBox('ip','خيارات IP')}</td>
			<td>{$Template->adminToolsBox('hacker','محاولات اختراق')}</td>
			<td>{$Template->adminToolsBox('block','المنع')}</td>
			<td>{$Template->adminToolsBox('chat','نقاش حي')}</td>
		</tr>
	</table><br><hr width=\"70%\"><br>";
	if(!local){
	?>
	<table>
		<tr>
			<td>
			<script src="http://widgets.alexa.com/traffic/javascript/graph.js?x=<?=rand?>" type="text/javascript"></script>
			<script type="text/javascript">
			<!--
			var sites= ['<?=site_address?>'];
			var opts={
				width:      400,  // width in pixels (max 400)
				height:     220,  // height in pixels (max 300)
				type:       'n',  // "r" Reach, "n" Rank, "p" Page Views
				range:      '3m', // "7d", "1m", "3m", "6m", "1y", "3y", "5y", "max"
				bgcolor:    'ffffff' // hex value without "#" char (usually "e6f3fc")
			};
			AGraphManager.add(new AGraph(sites,opts));
			//-->
			</script>
			</td>
			<td><a href="http://www.alexa.com/siteinfo/<?=site_address?>"><script type="text/javascript" language="JavaScript" src="http://xslt.alexa.com/site_stats/js/s/b?url=<?=site_address?>&x=<?=rand?>"></script></a></td>
		</tr>
	</table>
	<?php
	}
}
elseif($Template->adminType=='setting'){
	if($Template->adminMethod=='mainsetting'){
		if(scope=='change'){
			$DFOutput->setCnf('forum_title',$_POST['forum_title']);
			$DFOutput->setCnf('site_address',$_POST['site_address']);
			$DFOutput->setCnf('forum_logo',$_POST['forum_logo']);
			$DFOutput->setCnf('forum_email',$_POST['forum_email']);
			$DFOutput->setCnf('forum_copy_right',$_POST['forum_copy_right']);
			$DFOutput->setCnf('site_keywords',$_POST['site_keywords']);
			$DFOutput->setCnf('default_style',$_POST['default_style']);
			$DFOutput->setCnf('default_stylefont',$_POST['default_stylefont']);
			$DFOutput->setCnf('help_forum_id',$_POST['help_forum_id']);
			$DFOutput->setCnf('facebook_account',$_POST['facebook_account']);
			$DFOutput->setCnf('twitter_account',$_POST['twitter_account']);
			$DFOutput->setCnf('shut_down_status',$_POST['shut_down_status']);
			$DFOutput->setCnf('shut_down_msg',$_POST['shut_down_msg']);
			
			$site_domains=$DF->inlineText($_POST['site_domains']);
			$site_domains=explode(",",$site_domains);
			$site_domains=$DF->deleteArrayBlanks($site_domains);
			$site_domains=serialize($site_domains);
			$DFOutput->setCnf('site_domains',$site_domains);
			
			$DF->goTo("admincp.php?type=setting&method=mainsetting&change=1");
		}
		if(change==1){
			$Template->msgBox('تم حفظ تغيرات بنجاح','green',15,25,true,false);
		}
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=setting&method=mainsetting&scope=change\">
			<tr>
				<td>عنوان المنتدى</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'forum_title','value'=>forum_title),true)}</td>
			</tr>
			<tr>
				<td>عنوان الموقع</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'site_address','value'=>site_address,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>شعار المنتدي</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'forum_logo','value'=>forum_logo,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>بريد المنتدى</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'forum_email','value'=>forum_email,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>الحقوق في أسفل الصفحة</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'forum_copy_right','value'=>forum_copy_right,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>كلمات مفتاحية</td>
			</tr>
			<tr>
				<td><textarea style=\"width:500px;height:80px\" name=\"site_keywords\" dir=\"ltr\">".site_keywords."</textarea></td>
			</tr>
			<tr>
				<td>الستايل الافتراضي</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'default_style','value'=>default_style,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>الخط الافتراضي</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'default_stylefont','value'=>default_stylefont,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>رقم منتدى المساعدة</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'help_forum_id','value'=>help_forum_id),true)}</td>
			</tr>";
			$site_domains=unserialize(site_domains);
			if( !is_array($site_domains) ) $site_domains = [];
			$site_domains=implode(",",$site_domains);
			$text.="
			<tr>
				<td>اسماء نطاقات</td>
			</tr>
			<tr>
				<td><textarea style=\"width:500px;height:80px\" name=\"site_domains\" dir=\"ltr\">$site_domains</textarea></td>
			</tr>
			<tr>
				<td>صفحة فيسبوك</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'facebook_account','value'=>facebook_account,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>حساب تويتر</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'twitter_account','value'=>twitter_account,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>قفل المنتدى</td>
			</tr>
			<tr>
				<td>";
				$text .= $Template->fieldBox("
					<input type=\"radio\" name=\"shut_down_status\" value=\"1\" ".$DF->choose(shut_down_status,1,'c').">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"shut_down_status\" value=\"0\" ".$DF->choose(shut_down_status,0,'c').">&nbsp;لا
				",200);
				$text .="
				</td>
			</tr>
			<tr>
				<td>رسالة الإدارة حين منتدى مقفول</td>
			</tr>
			<tr>
				<td><textarea style=\"width:500px;height:80px\" name=\"shut_down_msg\">".shut_down_msg."</textarea></td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"حفظ تغيرات\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("خيارات أساسية",$text,50,4);
	}
	elseif($Template->adminMethod=='othersetting'){
		if(scope=='change'){
			$DFOutput->setCnf('register_status',$_POST['register_status']);
			$DFOutput->setCnf('visitor_can_show_forums',$_POST['visitor_can_show_forums']);
			$DFOutput->setCnf('visitor_can_show_topics',$_POST['visitor_can_show_topics']);
			$DFOutput->setCnf('max_change_name',$_POST['max_change_name']);
			$DFOutput->setCnf('max_days_change_name',$_POST['max_days_change_name']);
			$DFOutput->setCnf('num_pages',$_POST['num_pages']);
			$DFOutput->setCnf('reply_num_page',$_POST['reply_num_page']);
			$DFOutput->setCnf('count_pm_for_24_hour',$_POST['count_pm_for_24_hour']);
			$DFOutput->setCnf('topic_max_posts',$_POST['topic_max_posts']);
			$DFOutput->setCnf('new_user_under_moderate',$_POST['new_user_under_moderate']);
			$DFOutput->setCnf('new_user_can_send_pm',$_POST['new_user_can_send_pm']);
			$DF->goTo("admincp.php?type=setting&method=othersetting&change=1");
		}
		if(change==1){
			$Template->msgBox('تم حفظ تغيرات بنجاح','green',15,25,true,false);
		}
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=setting&method=othersetting&scope=change\">
			<tr>
				<td>حالة تسجيل عضويات جديدة</td>
			</tr>
			<tr>
				<td>
				{$Template->fieldBox("
					<input type=\"radio\" name=\"register_status\" value=\"0\" ".$DF->choose(register_status,0,'c').">&nbsp;إيقاف&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"register_status\" value=\"1\" ".$DF->choose(register_status,1,'c').">&nbsp;مفتوح&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"register_status\" value=\"2\" ".$DF->choose(register_status,2,'c').">&nbsp;تفعيل عبر بريد الالكتروني
				",350)}
				</td>
			</tr>
			<tr>
				<td>يمكن للزوار بمشاهدة منتديات</td>
			</tr>
			<tr>
				<td>
				{$Template->fieldBox("
					<input type=\"radio\" name=\"visitor_can_show_forums\" value=\"1\" ".$DF->choose(visitor_can_show_forums,1,'c').">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"visitor_can_show_forums\" value=\"0\" ".$DF->choose(visitor_can_show_forums,0,'c').">&nbsp;لا
				",200)}
				</td>
			</tr>
			<tr>
				<td>يمكن للزوار بمشاهدة مواضيع</td>
			</tr>
			<tr>
				<td>
				{$Template->fieldBox("
					<input type=\"radio\" name=\"visitor_can_show_topics\" value=\"1\" ".$DF->choose(visitor_can_show_topics,1,'c').">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"visitor_can_show_topics\" value=\"0\" ".$DF->choose(visitor_can_show_topics,0,'c').">&nbsp;لا
				",200)}
				</td>
			</tr>
			<tr>
				<td>أقصى عدد مرات لتغيير الاسم</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'max_change_name','value'=>max_change_name),true)}</td>
			</tr>
			<tr>
				<td>أقصى عدد أيام لتغيير اسم عضوية</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'max_days_change_name','value'=>max_days_change_name),true)}</td>
			</tr>
			<tr>
				<td>عدد خيارات بكل صفحة</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'num_pages','value'=>num_pages),true)}</td>
			</tr>
			<tr>
				<td>عدد ردود بكل صفحة</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'reply_num_page','value'=>reply_num_page),true)}</td>
			</tr>
			<tr>
				<td>أقصى عدد رسائل يومياً</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'count_pm_for_24_hour','value'=>count_pm_for_24_hour),true)}</td>
			</tr>
			<tr>
				<td>أقصى عدد ردود ليتم قفل الموضوع بشكل تلقائي</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'topic_max_posts','value'=>topic_max_posts),true)}</td>
			</tr>
			<tr>
				<td>عدد مشاركات لرفع الرقابة على أعضاء الجدد</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'new_user_under_moderate','value'=>new_user_under_moderate),true)}</td>
			</tr>
			<tr>
				<td>عدد مشاركات لرفع الرقابة على رسائل خاصة</td>
			</tr>
			<tr>
				<td>{$Template->input(300,array('name'=>'new_user_can_send_pm','value'=>new_user_can_send_pm),true)}</td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"حفظ تغيرات\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("خيارات إضافية",$text,50,4);
	}
	elseif($Template->adminMethod == 'usersetting'){
		?>
		<script type="text/javascript">
		DF.getColorBox = function(key){
			var input = $I('input:text[name=color'+key+']'), prev = $('#userColor'+key), color = $(input).val();
			DM.container.open({
				header: 'صندوق ألوان',
				body: DM.colorPicker.panel('userColor', {color: color}),
				buttons: [
					{
						value: 'أختار اللون',
						color: 'dark',
						click: function(){
							color = DM.colorPicker.getColor('userColor');
							$(input).val(color);
							$(prev).css('background-color', color);
							DM.container.close();
						}
					},
					{
						value: 'إغلاق',
						click: function(){
							DM.container.close();
						}
					}
				]
			});
		};
		DF.saveUsersColor = function(frm, ajaxTry){
			var bar = $I('#usersColorStatus'),
			doError = function(){
				$(bar).html('<img src="images/icons/error.gif" width="14" height="14"> حدث خطأ أثناء حفظ تغييرات, حاول مرة أخرى.');
			};
			$(bar).html('<img src="images/icons/progress.gif" width="16" height="16">');
 			$.ajax({
				type: 'POST',
				url: adAjaxFile,
				timeout: 3000,
				data: 'type=save_users_name_color'+
				'&color10='+frm.color10.value+'&color11='+frm.color11.value+'&color12='+frm.color12.value+'&color13='+frm.color13.value+
				'&color20='+frm.color20.value+'&color21='+frm.color21.value+'&color31='+frm.color31.value+'&color41='+frm.color41.value+
				'&scolor10='+frm.scolor10.value+'&scolor11='+frm.scolor11.value+'&scolor12='+frm.scolor12.value+'&scolor13='+frm.scolor13.value+
				'&scolor20='+frm.scolor20.value+'&scolor21='+frm.scolor21.value+'&scolor31='+frm.scolor31.value+'&scolor41='+frm.scolor41.value,
				success: function(res){
					if($PI(res) == 1){
						$(bar).html('<img src="images/icons/succeed.gif" width="14" height="14"> تم حفظ تغييرات.');
					}
					else{
						doError();
					}
				},
				error: function(e, request){
					if(request == 'timeout' && $PI(ajaxTry) < 2){
						DF.saveUsersColor(frm , $PI(ajaxTry) + 1);
					}
					else{
						doError();
					}
				}
			});
		};
		DF.saveUsersTitles = function(frm, ajaxTry){
			var bar = $I('#usersTitlesStatus'),
			doError = function(){
				$(bar).html('<img src="images/icons/error.gif" width="14" height="14"> حدث خطأ أثناء حفظ تغييرات, حاول مرة أخرى.');
			};
			$(bar).html('<img src="images/icons/progress.gif" width="16" height="16">');
 			$.ajax({
				type: 'POST',
				url: adAjaxFile,
				timeout: 3000,
				data: 'type=save_users_titles&titleM10='+frm.titleM10.value+'&titleM11='+frm.titleM11.value+'&titleM12='+frm.titleM12.value+
				'&titleM13='+frm.titleM13.value+'&titleM14='+frm.titleM14.value+'&titleM15='+frm.titleM15.value+'&titleM200='+frm.titleM200.value+
				'&titleM201='+frm.titleM201.value+'&titleM210='+frm.titleM210.value+'&titleM211='+frm.titleM211.value+'&titleM30='+frm.titleM30.value+
				'&titleM31='+frm.titleM31.value+'&titleM40='+frm.titleM40.value+'&titleM41='+frm.titleM41.value+
				'&titleF10='+frm.titleF10.value+'&titleF11='+frm.titleF11.value+'&titleF12='+frm.titleF12.value+
				'&titleF13='+frm.titleF13.value+'&titleF14='+frm.titleF14.value+'&titleF15='+frm.titleF15.value+'&titleF200='+frm.titleF200.value+
				'&titleF201='+frm.titleF201.value+'&titleF210='+frm.titleF210.value+'&titleF211='+frm.titleF211.value+'&titleF30='+frm.titleF30.value+
				'&titleF31='+frm.titleF31.value+'&titleF40='+frm.titleF40.value+'&titleF41='+frm.titleF41.value,
				success: function(res){
					if($PI(res) == 1){
						$(bar).html('<img src="images/icons/succeed.gif" width="14" height="14"> تم حفظ تغييرات.');
					}
					else{
						doError();
					}
				},
				error: function(e, request){
					if(request == 'timeout' && $PI(ajaxTry) < 2){
						DF.saveUsersTitles(frm , $PI(ajaxTry) + 1);
					}
					else{
						doError();
					}
				}
			});
		};
		DF.saveStarsNumber = function(frm, ajaxTry){
			var bar = $I('#usersStarsStatus'),
			doError = function(){
				$(bar).html('<img src="images/icons/error.gif" width="14" height="14"> حدث خطأ أثناء حفظ تغييرات, حاول مرة أخرى.');
			};
			$(bar).html('<img src="images/icons/progress.gif" width="16" height="16">');
 			$.ajax({
				type: 'POST',
				url: adAjaxFile,
				timeout: 3000,
				data: 'type=save_stars_number&star0='+frm.star0.value+'&star1='+frm.star1.value+'&star2='+frm.star2.value
				+'&star3='+frm.star3.value+'&star4='+frm.star4.value+'&star5='+frm.star5.value+'&star6='+frm.star6.value
				+'&star7='+frm.star7.value+'&star8='+frm.star8.value+'&star9='+frm.star9.value+'&star10='+frm.star10.value,
				success: function(res){
					if($PI(res) == 1){
						$(bar).html('<img src="images/icons/succeed.gif" width="14" height="14"> تم حفظ تغييرات.');
					}
					else{
						doError();
					}
				},
				error: function(e, request){
					if(request == 'timeout' && $PI(ajaxTry) < 2){
						DF.saveStarsNumber(frm , $PI(ajaxTry) + 1);
					}
					else{
						doError();
					}
				}
			});
		};
		$(function(){
			$('.starsCells').css({
				'padding': '4px 6px',
				'background-color': '#ddd',
				'cursor': 'pointer'
			});
			$('.starsCells').mouseover(function(){
				var color = $(this).attr('color'), key = $(this).attr('key'), scolor = $('#scolor'+key).val();
				$(this).css('border-color', (color == scolor) ? '#000' : '#aaa');
			});
			$('.starsCells').mouseout(function(){
				var color = $(this).attr('color'), key = $(this).attr('key'), scolor = $('#scolor'+key).val();
				$(this).css('border-color', (color == scolor) ? '#000' : '#ddd');
			});
			$('.starsCells').click(function(){
				var color = $(this).attr('color'), key = $(this).attr('key'), scolor = $('#scolor'+key).val();
				$('#scolor'+key).val(color);
				$('#star'+scolor+key).css('border-color', '#ddd');
				$(this).css('border-color', '#000');
			});
		});
		</script>
		<?php
		// user_name_color
		$text = "
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"admincp.php?type=setting&method=usersetting&scope=change\">
			<tr>
				<td class=\"statsHeader\">الرتبة</td>
				<td class=\"statsHeader\">اللون</td>
				<td class=\"statsHeader\"><nobr>اختيار اللون</nobr></td>
				<td class=\"statsHeader\"><nobr>لون النجمة</nobr></td>
			</tr>";
		$scolors = unserialize(stars_color);
		$colors = unserialize(user_name_color);
		$ranks = array(
			10	=> array('العضويات المقفولة', 	$colors[1][0], $scolors[1][0]),
			11	=> array('الأعضاء', 				$colors[1][1], $scolors[1][1]),
			12	=> array('العضويات المنتظرة', 	$colors[1][2], $scolors[1][2]),
			13	=> array('العضويات المرفوضة', 	$colors[1][3], $scolors[1][3]),
			20	=> array('المشرفون', 			$colors[2][0], $scolors[2][0]),
			21	=> array('نواب المراقبون', 		$colors[2][1], $scolors[2][1]),
			31	=> array('المراقبون', 			$colors[3][1], $scolors[3][1]),
			41	=> array('المدراء', 			$colors[4][1], $scolors[4][1])
		);
		$stars_colors = array('blue', 'bronze', 'cyan', 'gold', 'green', 'orange', 'purple', 'red', 'silver');
		foreach($ranks as $key => $arr){
			$name = $arr[0];
			$color = $arr[1];
			$scolor = $arr[2];
			$text.="
			<tr>
				<td class=\"statsText1\"><nobr>{$name}</nobr></td>
				<td class=\"statsText1 asCenter\"><input type=\"text\" class=\"input\" name=\"color{$key}\" style=\"width:80px\" value=\"{$color}\" onblur=\"$('#userColor{$key}').css('background-color', this.value);\" dir=\"ltr\"></td>
				<td class=\"statsText1\" align=\"center\"><div id=\"userColor{$key}\" onclick=\"DF.getColorBox('{$key}');\" style=\"width:20px;border:silver 1px solid;padding:3px;background-color:{$color};cursor:pointer;\">&nbsp;</div></td>
				<td class=\"statsText1\">
				<input type=\"hidden\" id=\"scolor{$key}\" value=\"{$scolor}\">
				<table cellpadding=\"0\" cellspacing=\"2\">
					<tr>";
					foreach($stars_colors as $star_color){
						$checked = ($star_color == $scolor) ? '#000' : '#ddd';
						$text.="
						<td id=\"star{$star_color}{$key}\" class=\"starsCells\" style=\"border:{$checked} 1px solid;\" color=\"{$star_color}\" key=\"{$key}\"><img src=\"images/icons/star_{$star_color}.gif\"></td>";
					}
					$text.="
					</tr>
				</table>
				</td>
			</tr>";
		}
			$text.="
			<tr>
				<td class=\"statsText\" colspan=\"4\">
					<span id=\"usersColorStatus\" style=\"line-height:25px;\">&nbsp;</span>
					<input type=\"button\" class=\"button\" onclick=\"DF.saveUsersColor(this.form);\" style=\"float:left;\" value=\"حفظ تغيرات\">
				</td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("ألوان أسماء العضويات والنجوم", $text, 50, 1);
		echo "<br>";
		// stars_number
		$text = "
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"admincp.php?type=setting&method=usersetting&scope=change\">
			<tr>
				<td class=\"statsHeader\">عدد نجوم</td>
				<td class=\"statsHeader\">عدد مشاركات</td>
			</tr>";
		$stars_number = unserialize(stars_number);
		$stars = array(
			0	=> array('بدون نجمة',		$stars_number[0]),
			1	=> array('نجمة الاولى', 		$stars_number[1]),
			2	=> array('نجمة الثانية', 	$stars_number[2]),
			3	=> array('نجمة الثالثة', 	$stars_number[3]),
			4	=> array('نجمة الرابعة', 	$stars_number[4]),
			5	=> array('نجمة الخامسة', 	$stars_number[5]),
			6	=> array('نجمة السادسة', 	$stars_number[6]),
			7	=> array('نجمة السابعة', 	$stars_number[7]),
			8	=> array('نجمة الثامنة', 	$stars_number[8]),
			9	=> array('نجمة التاسعة', 	$stars_number[9]),
			10	=> array('نجمة العاشرة', 	$stars_number[10])
		);
		foreach($stars as $key => $arr){
			$name = $arr[0];
			$star = $arr[1];
			$text.="
			<tr>
				<td class=\"statsText1\"><nobr>{$name}</nobr></td>
				<td class=\"statsText1 asCenter\"><input type=\"text\" class=\"input\" name=\"star{$key}\" style=\"width:80px;text-align:center;\" value=\"{$star}\" dir=\"ltr\"></td>
			</tr>";
		}
			$text.="
			<tr>
				<td class=\"statsText\" colspan=\"2\">
					<span id=\"usersStarsStatus\" style=\"line-height:25px;\">&nbsp;</span>
					<input type=\"button\" class=\"button\" onclick=\"DF.saveStarsNumber(this.form);\" style=\"float:left;\" value=\"حفظ تغيرات\">
				</td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("عدد مشاركات للحصول على النجوم", $text, 30, 1);
		echo "<br>";
		// male_titles & female_titles
		$text = "
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\">
		<form method=\"post\" action=\"admincp.php?type=setting&method=usersetting&scope=change\">
			<tr>
				<td class=\"statsHeader\">الرتبة</td>
				<td class=\"statsHeader\">الأوصاف للذكور</td>
				<td class=\"statsHeader\">الأوصاف للإناث</td>
			</tr>";
		$male_titles = unserialize(male_titles);
		$female_titles = unserialize(female_titles);
		$titles = array(
			'10'	=> array('الأعضاء - بدون أي نجمة', 		$male_titles[1][0], 	$female_titles[1][0]),
			'11'	=> array('الأعضاء - نجمة الاولى', 		$male_titles[1][1], 	$female_titles[1][1]),
			'12'	=> array('الأعضاء - نجمة الثانية', 		$male_titles[1][2], 	$female_titles[1][2]),
			'13'	=> array('الأعضاء - نجمة الثالثة', 		$male_titles[1][3], 	$female_titles[1][3]),
			'14'	=> array('الأعضاء - نجمة الرابعة', 		$male_titles[1][4], 	$female_titles[1][4]),
			'15'	=> array('الأعضاء - نجمة الخامسة', 		$male_titles[1][5], 	$female_titles[1][5]),
			'200'	=> array('المشرفون - حالياً', 			$male_titles[2][0][0], 	$female_titles[2][0][0]),
			'201'	=> array('المشرفون - في السابق', 		$male_titles[2][0][1], 	$female_titles[2][0][1]),
			'210'	=> array('نواب المراقب - حالياً', 		$male_titles[2][1][0], 	$female_titles[2][1][0]),
			'211'	=> array('نواب المراقب - في السابق', 	$male_titles[2][1][1], 	$female_titles[2][1][1]),
			'30'	=> array('المراقبون - حالياً', 			$male_titles[3][0], 	$female_titles[3][0]),
			'31'	=> array('المراقبون - في السابق', 		$male_titles[3][1], 	$female_titles[3][1]),
			'40'	=> array('المدراء - حالياً', 			$male_titles[4][0], 	$female_titles[4][0]),
			'41'	=> array('المدراء - في السابق', 		$male_titles[4][1], 	$female_titles[4][1])
		);
		foreach($titles as $key => $arr){
			$name = $arr[0];
			$male = $arr[1];
			$female = $arr[2];
			$text.="
			<tr>
				<td class=\"statsText1\"><nobr>{$name}</nobr></td>
				<td class=\"statsText1 asCenter\"><input type=\"text\" class=\"input\" name=\"titleM{$key}\" style=\"width:200px\" value=\"{$male}\"></td>
				<td class=\"statsText1 asCenter\"><input type=\"text\" class=\"input\" name=\"titleF{$key}\" style=\"width:200px\" value=\"{$female}\"></td>
			</tr>";
		}
			$text.="
			<tr>
				<td class=\"statsText\" colspan=\"3\">
					<span id=\"usersTitlesStatus\" style=\"line-height:25px;\">&nbsp;</span>
					<input type=\"button\" class=\"button\" onclick=\"DF.saveUsersTitles(this.form);\" style=\"float:left;\" value=\"حفظ تغيرات\">
				</td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("الأوصاف الافتراضية", $text, 30, 1);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='stats'){
	if($Template->adminMethod=='userstats'){
		echo"<br><br><br>
		<div align=\"center\"><a href=\"admin_stats.php\"><b>انقر هنا للذهاب الى صفحة إحصائيات أعضاء</b></a></div>";
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='templates'){
	if($Template->adminMethod=='edit'){
		if(scope=='change'){
			$tempid=(int)$_POST['tempid'];
			$tempname=trim($_POST['tempname']);
			$temptext=trim($_POST['temptext']);
			if(empty($tempname)){
				$error="يجب عليك كتابة اسم القالب";
			}
			else{
				$error="";
			}
			if(!empty($error)){
				$Template->msgBox($error,'red',15,0,true,false,true);
			}
			else{
				$mysql->update("template SET name = '$tempname', text = '$temptext' WHERE id = $tempid", __FILE__, __LINE__);
				$DF->goTo("admincp.php?type=templates&method=edit&id=$tempid&change=1");
			}
		}
		elseif(scope=='delete'){
			$mysql->delete("template WHERE id = ".id."", __FILE__, __LINE__);
			$DF->goTo("admincp.php?type=templates&method=edit&change=2");
		}
		if(change>0){
			$msg=array(
				1=>'تم حفظ تغيرات بنجاح',
				2=>'تم حذف قالب بنجاح',
				3=>'تم إضافة قالب بنجاح'
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		$rs=$mysql->queryAssoc("SELECT * FROM ".prefix."template WHERE id = ".id."", __FILE__, __LINE__);
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td>";
					$options="";
					$sql=$mysql->query("SELECT id,name FROM ".prefix."template ORDER BY name ASC", __FILE__, __LINE__);
					while($ors=$mysql->fetchRow($sql)){
						$options.="
						<option value=\"$ors[0]\"{$DF->choose($ors[0],id,'s')}>$ors[1]</option>";
					}
					$text.="
					{$Template->fieldBox("<nobr>اختر قالب من قائمة:&nbsp;
					<select style=\"width:400px\" dir=\"ltr\" name=\"temps\" onchange=\"document.location='admincp.php?type=templates&method=edit&id='+this.options[this.selectedIndex].value;\">
					<option value=\"0\">-- Choose Template --</option>
					$options
					</select>
					</nobr>",0)}
				</td>
				<td>".($rs['id']>0 ? "&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" class=\"button\" onclick=\"if(confirm('هل أنت متأكد بأن تريد حذف هذا القالب')){document.location='admincp.php?type=templates&method=edit&scope=delete&id=".$rs['id']."';}\" value=\"حذف قالب\">" : "")."</td>
			</tr>
		</table>";
		$Template->adminBox("قائمة قوالب",$text,0,4);
		echo"<br><br>";
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">";
		if($rs['id']>0){
			$text.="
			<form method=\"post\" action=\"admincp.php?type=templates&method=edit&scope=change&id={$rs['id']}\">
			<input type=\"hidden\" name=\"tempid\" value=\"{$rs['id']}\">
				<tr>
					<td>اسم القالب</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'tempname','value'=>$rs['name'],'dir'=>'ltr'),true)}</td>
				</tr>
				<tr>
					<td>محتوي القالب</td>
				</tr>
				<tr>
					<td><textarea style=\"width:100%;height:500px;font-size:13px;font-weight:normal;font-family:courier new\" wrap=\"virtual\" dir=\"ltr\" name=\"temptext\">{$rs['text']}</textarea></td>
				</tr>
				<tr>
					<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"حفظ تغيرات\"></td>
				</tr>
			</form>";
		}
		else{
			$text.="
			<tr>
				<td align=\"center\"><br>لم يتم العثور على أي قالب<br>يبدو انك لم اخترت أي قالب من قائمة قوالب<br><br></td>
			</tr>";
		}
		$text.="
		</table>";
		$Template->adminBox("تعديل قالب",$text,80,4);
	}
	elseif($Template->adminMethod=='add'){
		if(scope=='change'){
			$tempname=trim($_POST['tempname']);
			$temptext=trim($_POST['temptext']);
			$findName=$mysql->get("template","name",$tempname,"name");
			if(empty($tempname)){
				$error="يجب عليك كتابة اسم القالب";
			}
			elseif(!empty($findName)){
				$error="اسم القالب الذي اخترت موجود مسبقاً, لذا يجب عليك ان تختار اسم آخر";
			}
			else{
				$error="";
			}
			if(!empty($error)){
				$Template->msgBox($error,'red',15,0,true,false,true);
			}
			else{
				$mysql->insert("template (name,text) VALUES ('$tempname','$temptext')", __FILE__, __LINE__);
				$newTempId=$mysql->get("template","id",$tempname,"name");
				$DF->goTo("admincp.php?type=templates&method=edit&id=$newTempId&change=3");
			}
		}
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=templates&method=add&scope=change\">
			<tr>
				<td>اسم القالب</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'tempname','dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>محتوي القالب</td>
			</tr>
			<tr>
				<td><textarea style=\"width:100%;height:500px;font-size:13px;font-weight:normal;font-family:courier new\" wrap=\"virtual\" dir=\"ltr\" name=\"temptext\"></textarea></td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"إضافة قالب\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("إضافة قالب جديد",$text,80,4);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='groupmessages'){
	if($Template->adminMethod=='sendemailtousers'){
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=groupmessages&method=changesendemailtousers\">
		<input type=\"hidden\" name=\"post\" value=\"1\">
			<tr>
				<td>اختيار مجموعة</td>
			</tr>
			<tr>
				<td>
				{$Template->fieldBox("
					<font class=\"small\">
					<input type=\"checkbox\" name=\"tousers\" value=\"1\">&nbsp;الأعضاء&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"checkbox\" name=\"tomoderators\" value=\"1\">&nbsp;المشرفين&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"checkbox\" name=\"tomonitors\" value=\"1\">&nbsp;المراقبين&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"checkbox\" name=\"toadmins\" value=\"1\">&nbsp;المدراء
					</font>
				",500)}
				</td>
			</tr>
			<tr>
				<td>عنوان الرسالة</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'subject'),true)}</td>
			</tr>
			<tr>
				<td>عنوان البريد</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'email','value'=>forum_email,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>محتوي الرسالة</td>
			</tr>
			<tr>
				<td><textarea style=\"width:507px;height:250px\" name=\"message\"></textarea></td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"بدأ إرسال رسائل\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("إرسال رسالة جماعية للأعضاء عبر بريد الالكتروني",$text,50,4);
	}
	elseif($Template->adminMethod=='changesendemailtousers'){
		$waitEnd=true;
		if(isset($_POST['post'])){
			$subject=$_POST['subject'];
			$email=$_POST['email'];
			$message=$_POST['message'];
			$tousers=(int)$_POST['tousers'];
			$tomoderators=(int)$_POST['tomoderators'];
			$tomonitors=(int)$_POST['tomonitors'];
			$toadmins=(int)$_POST['toadmins'];
			$tempDetails=array(
				'subject'=>$subject,
				'email'=>$email,
				'message'=>$message,
				'tousers'=>$tousers,
				'tomoderators'=>$tomoderators,
				'tomonitors'=>$tomonitors,
				'toadmins'=>$toadmins
			);
			$DFOutput->setCnf('temp_details_for_send_message_to_all',serialize($tempDetails));
		}
		else{
			$tempDetails=unserialize(temp_details_for_send_message_to_all);
			$subject=$tempDetails['subject'];
			$email=$tempDetails['email'];
			$message=$tempDetails['message'];
			$tousers=$tempDetails['tousers'];
			$tomoderators=$tempDetails['tomoderators'];
			$tomonitors=$tempDetails['tomonitors'];
			$toadmins=$tempDetails['toadmins'];
		}
		
		$tousersstatus=array();
		if($tousers==1) $tousersstatus[]=1;
		if($tomoderators==1) $tousersstatus[]=2;
		if($tomonitors==1) $tousersstatus[]=3;
		if($toadmins==1) $tousersstatus[]=4;
		
		if(count($tousersstatus)==0){
			$errmsg="انت لم اخترت أي مجموعة ليتم إرسال الرسالة اليهم<br>";
		}
		if(empty($subject)){
			$errmsg.="انت لم كتبت عنوان الرسالة<br>";
		}
		if(empty($email)){
			$errmsg.="انت لم كتبت بريد الالكتروني<br>";
		}
		if(empty($message)){
			$errmsg.="انت لم كتبت محتوي الرسالة<br>";
		}
		
		if(!empty($errmsg)){
			$Template->msgBox("لا يمكنك إرسال رسالة جماعية لأسباب التالية:-<br><br>$errmsg",'red',15,0,true,false,true);
		}
		else{
			$length=300;
			$charset="utf-8";
			$forumTitle=forum_title;
			$message=str_replace("\n","<br>","<div dir=\"rtl\">$message</div>");
			$subject="=?$charset?B?".base64_encode($subject)."?=\n";
			$headers="From: =?$charset?B?".base64_encode($forumTitle)."?= <$email>\r\n";
			$headers.="Content-Type: text/html; charset=$charset;\n";
			$headers.="Return-Path: <$email>\n";
			$headers.="X-Sender: <$email>\n";
			$headers.="MIME-Version: 1.0\n";
			$headers.="X-Mailer: PHP\n";
			$headers.="Content-Transfer-Encoding: 8bit\n";
			$countRows=$DFOutput->count("user WHERE status = 1 AND level in (".implode(",",$tousersstatus).")");
			$Template->myMsg("<br><img src=\"{$DFImage->i['loading']}\" border=\"0\"><br>مرحلة ".pg." من ".ceil($countRows/$length)." مراحل<br>انتظر ليتم إتمام العملية<br><br>","loadingMode");
			$pgLimit=$DF->pgLimit($length);
			$sql=$mysql->query("SELECT uf.email,u.name FROM ".prefix."user AS u LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id) WHERE u.status = 1 AND u.level in (".implode(",",$tousersstatus).") LIMIT $pgLimit,$length", __FILE__, __LINE__);
			$count=0;
			while($rs=$mysql->fetchRow($sql)){
				mail("To: =?$charset?B?".base64_encode($rs[1])."?= <$rs[0]>",$subject,$message,$headers);
				if($count==($length-1)){
					$DF->goTo("admincp.php?type=groupmessages&method=changesendemailtousers&pg=".(pg+1));
					$waitEnd=false;
					break;
				}
				$count++;
			}
			if($waitEnd){
				echo"<script type=\"text/javascript\">if(\$I('#loadingMode')){\$I('#loadingMode').style.display='none';}</script>";
				$DFOutput->setCnf('temp_details_for_send_message_to_all','');
				$Template->msgBox('تم إرسال رسالة جماعية بنجاح','green',15,25,true,false);
			}
		}
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='forums'){
	if($Template->adminMethod=='sortcatforums'){
		if(scope=='change'){
			$catid=$_POST['catid'];
			$csort=$_POST['csort'];
			for($x=0;$x<count($catid);$x++){
				$mysql->update("category SET sort = '$csort[$x]' WHERE id = '$catid[$x]'", __FILE__, __LINE__);
			}
			$forumid=$_POST['forumid'];
			$fsort=$_POST['fsort'];
			for($x=0;$x<count($forumid);$x++){
				$mysql->update("forum SET sort = '$fsort[$x]' WHERE id = '$forumid[$x]'", __FILE__, __LINE__);
			}
			$DF->goTo("admincp.php?type=forums&method=sortcatforums&change=1");
		}
		if(change==1){
			$Template->msgBox('تم حفظ تغيرات بنجاح','green',15,25,true,false);
		}
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=forums&method=sortcatforums&scope=change\">";
		$sql=$mysql->query("SELECT id,subject,sort FROM ".prefix."category ORDER BY sort ASC", __FILE__, __LINE__);
		while($rs=$mysql->fetchArray($sql)){
			$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\"><nobr>{$rs['subject']}</nobr></td>
				<td class=\"statsText2\" align=\"center\">{$Template->input(100,array('name'=>'csort[]','value'=>$rs['sort'],'style'=>'text-align:center'),true)}<input type=\"hidden\" name=\"catid[]\" value=\"{$rs['id']}\"></td>
			</tr>";
			$sql2=$mysql->query("SELECT id,subject,sort FROM ".prefix."forum WHERE catid = '{$rs['id']}' ORDER BY sort ASC", __FILE__, __LINE__);
			while($frs=$mysql->fetchArray($sql2)){
				$f=$frs['id'];
				$text.="
				<tr>
					<td class=\"statsText1\"><nobr>{$frs['subject']}</nobr></td>
					<td class=\"statsText1\" align=\"center\">{$Template->input(100,array('name'=>'fsort[]','value'=>$frs['sort'],'style'=>'text-align:center'),true)}<input type=\"hidden\" name=\"forumid[]\" value=\"{$frs['id']}\"></td>
				</tr>";
			}
		}
			$text.="
			<tr>
				<td class=\"statsText1\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"button\" value=\"تعديل\"></td>
			</tr>";
		$text.="
		</form>
		</table>";
		$Template->adminBox("ترتيب فئات ومنتديات",$text,40,4);
	}
	elseif($Template->adminMethod=='monthlysort'){
		?>
		<script type="text/javascript">
		DF.goToDate=function(){
			var year=$I('#year').options[$I('#year').selectedIndex].value,month=$I('#month').options[$I('#month').selectedIndex].value;
			document.location='admincp.php?type=forums&method=monthlysort&y='+year+'&m='+month;
		};
		</script>
		<?php
		$startYear=2009;
		$yy=(int)date("Y",time);
		$y=$startYear;
		$years=array($y);
		while($y<$yy){
			$y++;
			$years[]=$y;
		}
		$months=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$year=(int)$_GET['y'];
		$year=(in_array($year,$years) ? $year : date("Y",time));
		$month=(int)$_GET['m'];
		$month=(in_array($month,$months) ? $month : date("m",time));
		$stime=strtotime("{$year}-{$month}-1");
		$etime=strtotime("".($month<12 ? $year : $year+1)."-".($month==12 ? 1 : $month+1)."-1");
		// Previous Month
		$lyear=($month>1 ? $year : $year-1);
		$lmonth=($month==1 ? 12 : $month-1);
		$lstime=strtotime("{$lyear}-{$lmonth}-1");
		$letime=strtotime("".($lmonth<12 ? $lyear : $lyear+1)."-".($lmonth==12 ? 1 : $lmonth+1)."-1");
		
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsText2\" align=\"center\">
				<select id=\"year\" class=\"dark\">";
				for($x=0;$x<count($years);$x++){
					$text.="
					<option value=\"$years[$x]\"{$DF->choose($year,$years[$x],'s')}>$years[$x]</option>";
				}
				$text.="
				</select>&nbsp;&nbsp;
				<select id=\"month\" class=\"dark\">";
				for($x=0;$x<count($months);$x++){
					$text.="
					<option value=\"$months[$x]\"{$DF->choose($month,$months[$x],'s')}>$months[$x]</option>";
				}
				$text.="
				</select>&nbsp;&nbsp;
				<input type=\"button\" class=\"button\" onclick=\"DF.goToDate();\" value=\"تنفيذ\">
				</td>
			</tr>";
			
		$text.="
		</table>";
		$Template->adminBox("اختيار تاريخ",$text,40,4);echo"<br>";
		$forums=array();
		$forumssort=array();
		$sql=$mysql->query("SELECT id,subject FROM ".prefix."forum WHERE status = 1 AND hidden = 0 AND level = 0", __FILE__, __LINE__);
		while($rs=$mysql->fetchRow($sql)){
			$ff=array();
			$ff['subject']=$rs[1];
			$topics=($DFOutput->count("topic WHERE forumid = $rs[0] AND date >= $stime AND date < $etime")*3);
			$posts=$DFOutput->count("post WHERE forumid = $rs[0] AND date >= $stime AND date < $etime");
			$posts=($posts>0 ? ceil($posts/3) : 0);
			$prs=$mysql->queryRow("SELECT SUM(ml.points) FROM ".prefix."medal AS m
			LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid AND ml.forumid = $rs[0] AND m.date >= $stime AND m.date < $etime)
			WHERE NOT ISNULL(ml.id)", __FILE__, __LINE__);
			$points=(int)$prs[0];
			$spoints=($topics+$posts+$points);

			$topics=($DFOutput->count("topic WHERE forumid = $rs[0] AND date >= $lstime AND date < $letime")*3);
			$posts=$DFOutput->count("post WHERE forumid = $rs[0] AND date >= $lstime AND date < $letime");
			$posts=($posts>0 ? ceil($posts/3) : 0);
			$prs=$mysql->queryRow("SELECT SUM(ml.points) FROM ".prefix."medal AS m
			LEFT JOIN ".prefix."medallists AS ml ON(ml.id = m.listid AND ml.forumid = $rs[0] AND m.date >= $lstime AND m.date < $letime)
			WHERE NOT ISNULL(ml.id)", __FILE__, __LINE__);
			$points=(int)$prs[0];
			$lpoints=($topics+$posts+$points);
			
			$forumssort[]=array(
				'id'=>$rs[0],
				'points'=>$spoints,
				'lpoints'=>$lpoints
			);
			$forums[$rs[0]]=$ff;
		}
		
		$newsort=$DF->sort($forumssort,array(array('points','desc')));
		$prevsort=$DF->sort($forumssort,array(array('lpoints','desc')));
		$x=1;
		$prevsort2=array();
		foreach($prevsort as $val){
			$prevsort2[$val['id']]=$x;
			$x++;
		}
		
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\" colspan=\"2\"><nobr><b>المركز</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>المنتدى</b></nobr></td>
				<td class=\"statsHeader\" colspan=\"3\"><nobr><b>النقاط</b></nobr></td>
			</tr>";
		$iup="<img src=\"images/icons/sortup.gif\" hspace=\"2\" border=\"0\">";
		$idown="<img src=\"images/icons/sortdown.gif\" hspace=\"2\" border=\"0\">";
		$x=1;
		foreach($newsort as $val){
			$f=$val['id'];
			$lastsort=($prevsort2[$f]-$x);
			$lastsorttext=($lastsort>0 ? "$iup<font color=\"green\">$lastsort</font>" : ($lastsort<0 ? "$idown<font color=\"red\">".abs($lastsort)."</font>" : "&nbsp;"));
			$lastpoints=($val['points']-$val['lpoints']);
			$lastpointstext=($lastpoints>0 ? "$iup<font color=\"green\">$lastpoints</font>" : ($lastpoints<0 ? "$idown<font color=\"red\">".abs($lastpoints)."</font>" : "&nbsp;"));
			$points=($val['points']>0 ? $val['points'] : 1);
			$percent=round(((100/$points)*$lastpoints),3);
			$lastpercenttext=($lastpoints>0 ? "$iup<font color=\"green\">{$percent}%</font>" : ($lastpoints<0 ? "$idown<font color=\"red\">".abs($percent)."%</font>" : "&nbsp;"));
			$text.="
			<tr>
				<td class=\"statsText\" align=\"center\"><nobr><b>$x</b></nobr></td>
				<td class=\"statsText2\"><nobr><b>$lastsorttext</b></nobr></td>
				<td class=\"statsText1\"><nobr><a href=\"forums.php?f=$f\"><b>{$forums[$f]['subject']}</b></a></nobr></td>
				<td class=\"statsText\"><nobr><font color=\"blue\"><b>{$val['points']}</b></font></nobr></td>
				<td class=\"statsText2\"><nobr><b>$lastpointstext</b></nobr></td>
				<td class=\"statsText2\"><nobr><b>$lastpercenttext</b></nobr></td>
			</tr>";
			$x++;
		}
		$text.="
		</table>";
		$Template->adminBox("ترتيب شهر {$Template->monthName[$month]} $year - ".forum_title,$text,40,4);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='users'){
	if($Template->adminMethod == 'allowusers'){
		echo"<div align=\"center\">{$Template->paging("user WHERE status = 1", "admincp.php?type=users&method=allowusers&")}</div>";
		$text = "
		<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\"><nobr><b>الرقم</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم العضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>بريد الالكتروني</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تفعيل عبر البريد</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>IP</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الدولة</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تاريخ</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الموافقة</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>خيارات</b></nobr></td>
			</tr>";
		$pgLimit = $DF->pgLimit(num_pages);
		$sql = $mysql->query("SELECT u.id, u.name, u.level, u.submonitor, u.active, u.date, uf.email, uf.ip, uf.agree, IF(ISNULL(uu.id), 0, uu.id) AS aid,
			IF(ISNULL(uu.id), '', uu.name) AS aname, IF(ISNULL(uu.id), 0, uu.status) AS astatus, IF(ISNULL(uu.id), 0, uu.level) AS alevel,
			IF(ISNULL(uu.id), 0, uu.submonitor) AS asubmonitor
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		LEFT JOIN ".prefix."user AS uu ON(uu.id = uf.agree)
		WHERE u.status = 1 ORDER BY u.id DESC LIMIT {$pgLimit},".num_pages, __FILE__, __LINE__);
		$count = 0;
		while($rs = $mysql->fetchAssoc($sql)){
			$ip = long2ip($rs['ip']);
			$details = $DF->getCountryByIP($ip, 'all');
			$details_code = isset($details['code']) ? $details['code'] : '';
			$details_name = isset($details['name']) ? $details['name'] : '';
			$classNo = ($count%2) ? 1 : 2;
			$name = $Template->userColorLink($rs['id'], array($rs['name'], 1, $rs['level'], $rs['submonitor']));
			$agree = ($rs['aid'] > 0) ? $Template->userColorLink($rs['aid'], array($rs['aname'], $rs['astatus'], $rs['alevel'], $rs['asubmonitor'])) : "--";
			$active = ($rs['active'] == 1) ? "<font color=\"green\">فعال</font>" : "<font color=\"red\">غير فعال</font>";
			$text .= "
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$rs['id']}</nobr></td>
				<td class=\"statsText{$classNo}\"><nobr>{$name}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$rs['email']}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$active}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr><span dir=\"ltr\">{$ip}</span></nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr><img src=\"{$DF->getFlagByCode($details_code)}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"> - {$details_name}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$DF->date($rs['date'])}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$agree}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 9);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count == 0){
			$text .= "
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"9\"><br>لا توجد اي عضوية تمت موافقة عليها<br><br></td>
			</tr>";
		}
		$text .= "
		</table>";
		$Template->adminBox("عضويات تمت موافقة عليها", $text, 70, 0);
	}
	elseif($Template->adminMethod=='waitusers'){
		if(scope=='change'){
			$status=(int)$_POST['status'];
			$users=implode(",",$_POST['userid']);
			if($status==1||$status==3){
				$mysql->update("user SET status = $status WHERE id IN ($users)", __FILE__, __LINE__);
				if($status == 1){
					$mysql->update("userflag SET agree = ".uid." WHERE id IN ({$users})", __FILE__, __LINE__);
				}
			}
			if($status==4){
				$mysql->delete("user WHERE id IN ($users)", __FILE__, __LINE__);
				$mysql->delete("userflag WHERE id IN ($users)", __FILE__, __LINE__);
				$mysql->delete("userperm WHERE id IN ($users)", __FILE__, __LINE__); 
			}
			$DF->goTo("admincp.php?type=users&method=waitusers&change=$status".(pg>1 ? "&pg=".pg : ""));
		}
		if(change>0){
			$msg=array(
				1=>"تمت موافقة على عضويات المختارة بنجاح",
				3=>"تم رفض عضويات المختارة بنجاح",
				4=>"تم حذف عضويات المختارة بنجاح"
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		?>
		<script type="text/javascript">
		DF.userCmd=function(frm,status){
			var el=frm.elements,msg=new Array();
			for(var x=0,y=0;x<el.length;x++){
				if(el[x].type=='checkbox'&&el[x].checked){
					y++;
				}
			}
			if(y>0){
				msg[1]="هل انت متأكد بأن تريد موافقة على عضويات المختارة";
				msg[3]="هل انت متأكد بأن تريد رفض عضويات المختارة";
				msg[4]="هل أنت متأكد بأن تريد حذف عضويات المختارة";
				if(confirm(msg[status])){
					frm.status.value=status;
					frm.submit();
				}
			}
			else{
				alert("انت لم حددت اي عضوية");
			}
		};
		</script>
		<?php
		echo"<div align=\"center\">{$Template->paging("user WHERE status = 2","admincp.php?type=users&method=waitusers&")}</div>";
		$text="
		<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=users&method=waitusers&scope=change".(pg>1 ? "&pg=".pg : "")."\">
		<input type=\"hidden\" name=\"status\">
			<tr>
				<td class=\"statsHeader\"><nobr><input type=\"checkbox\" onclick=\"DF.checkAllByCheck(this,'userid');\"></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الرقم</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم العضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>بريد الالكتروني</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تفعيل عبر البريد</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>IP</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الدولة</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تاريخ</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>خيارات</b></nobr></td>
			</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT u.id,u.name,uf.email,u.date,uf.ip,u.active
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE u.status = 2 ORDER BY u.date DESC LIMIT {$pgLimit},".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$ip = long2ip($rs['ip']);
			$details = $DF->getCountryByIP($ip, 'all');
			$details_code = isset($details['code']) ? $details['code'] : '';
			$details_name = isset($details['name']) ? $details['name'] : '';
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText{$classNo}\" align=\"center\"><input type=\"checkbox\" name=\"userid[]\" value=\"{$rs['id']}\"></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$rs['id']}</nobr></td>
				<td class=\"statsText{$classNo}\"><nobr>{$Template->userNormalLink($rs['id'],$rs['name'])}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$rs['email']}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>".($rs['active']==1 ? "<font color=\"green\">فعال</font>" : "<font color=\"red\">غير فعال</font>")."</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr><span dir=\"ltr\">$ip</span></nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr><img src=\"{$DF->getFlagByCode($details_code)}\" alt=\"{$details_name}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"></nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$DF->date($rs['date'])}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 9);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"9\"><br>لا توجد اي عضوية ينتظر الموافقة<br><br></td>
			</tr>";
		}
		$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"9\"><br>
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,1)\" value=\"موافقة على عضويات المختارة\">&nbsp;&nbsp;&nbsp;
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,3)\" value=\"رفض عضويات المختارة\">&nbsp;&nbsp;&nbsp;
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,4)\" value=\"حذف عضويات المختارة\"><br><br>
				</td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("عضويات ينتظر الموافقة",$text,70,0);
	}
	elseif($Template->adminMethod=='refuseusers'){
		if(scope=='change'){
			$status=(int)$_POST['status'];
			$users=implode(",",$_POST['userid']);
			$msg=array(
				1=>"تمت موافقة على عضويات المختارة بنجاح",
				4=>"تم حذف عضويات المختارة بنجاح"
			);
			if($status==1){
				$mysql->update("user SET status = 1 WHERE id IN ($users)", __FILE__, __LINE__);
			}
			if($status==4){
				$mysql->delete("user WHERE id IN ($users)", __FILE__, __LINE__);
				$mysql->delete("userflag WHERE id IN ($users)", __FILE__, __LINE__);
				$mysql->delete("userperm WHERE id IN ($users)", __FILE__, __LINE__); 
			}
			$DF->goTo("admincp.php?type=users&method=refuseusers&change=$status".(pg>1 ? "&pg=".pg : ""));
		}
		if(change>0){
			$msg=array(
				1=>"تمت موافقة على عضويات المختارة بنجاح",
				4=>"تم حذف عضويات المختارة بنجاح"
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		?>
		<script type="text/javascript">
		DF.userCmd=function(frm,status){
			var el=frm.elements,msg=new Array();
			for(var x=0,y=0;x<el.length;x++){
				if(el[x].type=='checkbox'&&el[x].checked){
					y++;
				}
			}
			if(y>0){
				msg[1]="هل انت متأكد بأن تريد موافقة على عضويات المختارة";
				msg[4]="هل أنت متأكد بأن تريد حذف عضويات المختارة";
				if(confirm(msg[status])){
					frm.status.value=status;
					frm.submit();
				}
			}
			else{
				alert("انت لم حددت اي عضوية");
			}
		};
		</script>
		<?php
		echo"<div align=\"center\">{$Template->paging("user WHERE status = 3","admincp.php?type=users&method=refuseusers&")}</div>";
		$text="
		<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=users&method=refuseusers&scope=change".(pg>1 ? "&pg=".pg : "")."\">
		<input type=\"hidden\" name=\"status\">
			<tr>
				<td class=\"statsHeader\"><nobr><input type=\"checkbox\" onclick=\"DF.checkAllByCheck(this,'userid');\"></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الرقم</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم العضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>بريد الالكتروني</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تفعيل عبر البريد</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>IP</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الدولة</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تاريخ</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>خيارات</b></nobr></td>
			</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT u.id,u.name,uf.email,u.date,uf.ip,u.active
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE u.status = 3 ORDER BY u.date DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$ip=long2ip($rs['ip']);
			$details = $DF->getCountryByIP($ip,'all');
			$details_code = isset($details['code']) ? $details['code'] : '';
			$details_name = isset($details['name']) ? $details['name'] : '';
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText$classNo\" align=\"center\"><input type=\"checkbox\" name=\"userid[]\" value=\"{$rs['id']}\"></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['id']}</nobr></td>
				<td class=\"statsText$classNo\"><nobr>{$Template->userNormalLink($rs['id'],$rs['name'])}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['email']}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>".($rs['active']==1 ? "<font color=\"green\">فعال</font>" : "<font color=\"red\">غير فعال</font>")."</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><span dir=\"ltr\">$ip</span></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><img src=\"{$DF->getFlagByCode($details_code)}\" alt=\"{$details_name}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$DF->date($rs['date'])}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 9);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"9\"><br>لا توجد اي عضوية تمت رفضها<br><br></td>
			</tr>";
		}
		$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"9\"><br>
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,1)\" value=\"موافقة على عضويات المختارة\">&nbsp;&nbsp;&nbsp;
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,4)\" value=\"حذف عضويات المختارة\"><br><br>
				</td>
			</tr>
		</table>
		</form>";
		$Template->adminBox("عضويات تمت رقضها",$text,70,0);
	}
	elseif($Template->adminMethod=='activeusers'){
		if(scope=='change'){
			$status=(int)$_POST['status'];
			$users=implode(",",$_POST['userid']);
			if($status==1){
				$mysql->update("user SET active = 1 WHERE id IN ($users)", __FILE__, __LINE__);
			}
			$DF->goTo("admincp.php?type=users&method=activeusers&change=1".(pg>1 ? "&pg=".pg : ""));
		}
		if(change==1){
			$Template->msgBox('نم تفعيل عضويات المختارة بنجاح','green',15,25,true,false);
		}
		?>
		<script type="text/javascript">
		DF.userCmd=function(frm,status){
			var el=frm.elements;
			for(var x=0,y=0;x<el.length;x++){
				if(el[x].type=='checkbox'&&el[x].checked){
					y++;
				}
			}
			if(y>0){
				if(confirm("هل أنت متأكد بأن تريد تفعيل عضويات المختارة")){
					frm.status.value=status;
					frm.submit();
				}
			}
			else{
				alert("انت لم حددت اي عضوية");
			}
		};
		</script>
		<?php
		echo"<div align=\"center\">{$Template->paging("user WHERE status = 1 AND active = 0","admincp.php?type=users&method=activeusers&")}</div>";
		$text="
		<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=users&method=activeusers&scope=change".(pg>1 ? "&pg=".pg : "")."\">
		<input type=\"hidden\" name=\"status\">
			<tr>
				<td class=\"statsHeader\"><nobr><input type=\"checkbox\" onclick=\"DF.checkAllByCheck(this,'userid');\"></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الرقم</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم العضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>بريد الالكتروني</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>IP</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>الدولة</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تاريخ</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>خيارات</b></nobr></td>
			</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT u.id,u.name,uf.email,u.date,uf.ip
		FROM ".prefix."user AS u
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE u.status = 1 AND u.active = 0 ORDER BY u.date DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$ip=long2ip($rs['ip']);
			$details=$DF->getCountryByIP($ip,'all');
			$details_code = isset($details['code']) ? $details['code'] : '';
			$details_name = isset($details['name']) ? $details['name'] : '';
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText$classNo\" align=\"center\"><input type=\"checkbox\" name=\"userid[]\" value=\"{$rs['id']}\"></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['id']}</nobr></td>
				<td class=\"statsText$classNo\"><nobr>{$Template->userNormalLink($rs['id'],$rs['name'])}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['email']}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><span dir=\"ltr\">$ip</span></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><img src=\"{$DF->getFlagByCode($details_code)}\" alt=\"{$details_name}\" width=\"18\" height=\"12\" hspace=\"3\" border=\"0\"></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$DF->date($rs['date'])}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 8);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"8\"><br>لا توجد اي عضوية غير مفعلة<br><br></td>
			</tr>";
		}
		$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"8\"><br>
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,1)\" value=\"تفعيل عضويات المختارة\"><br><br>
				</td>
			</tr>
		</table>
		</form>";
		$Template->adminBox("عضويات تمت موافقة عليها وغير مفعلة",$text,70,0);
	}
	elseif($Template->adminMethod=='changenamewait'){
		if(scope=='change'){
			$type=$_POST['type'];
			$id=$_POST['id'];
			$userid=$_POST['userid'];
			$ids=implode(",",$id);
			if($type==1){
				$subject="تم تغير اسم عضويتك بنجاح";
				$message="الرسالة من ادارة ".forum_title." حول طلب تغيير اسم عضويتك<br><br>تمت موافقة على طلبك بتغير اسم العضوية الى اسم الذي انت اخترت<br>مع تحيات ادارة ".forum_title;
				for($x=0;$x<count($userid);$x++){
					$mysql->update("user SET
						entername = IF(
							name = entername,
							(SELECT newname FROM ".prefix."changename WHERE id = '$id[$x]'),
							entername
						),
						name = (SELECT newname FROM ".prefix."changename WHERE id = '$id[$x]')
					WHERE id = '$userid[$x]'", __FILE__, __LINE__);
					$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES (
						'$userid[$x]','0','0','$userid[$x]','$subject','".time."'
					)", __FILE__, __LINE__);
					
					$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$userid[$x]' AND pmfrom = '0' AND date = '".time."'", __FILE__, __LINE__);
					$rs=$mysql->fetchRow($sql);
					
					$mysql->insert("pmmessage (id,message) VALUES (
						'$rs[0]','$message'
					)", __FILE__, __LINE__);
				}
				$mysql->update("changename SET status = '1' WHERE id IN ($ids)", __FILE__, __LINE__);
			}
			elseif($type==2){
				$subject="لم يتم تغير اسم عضويتك";
				$message="الرسالة من ادارة ".forum_title." حول طلب تغيير اسم عضويتك<br><br>تم رفض طلب تغيير اسم عضويتك بسبب مخالفة قوانين المنتدى<br>لهذا مرجوا محاولة بإسم آخر وموافق عن قوانين المنتدى<br>مع تحيات ادارة ".forum_title;
				for($x=0;$x<count($userid);$x++){
					$mysql->insert("pm (author,redeclare,pmfrom,pmto,subject,date) VALUES (
						'$userid[$x]','0','0','$userid[$x]','$subject','".time."'
					)", __FILE__, __LINE__);
					
					$sql=$mysql->query("SELECT id FROM ".prefix."pm WHERE author = '$userid[$x]' AND pmfrom = '0' AND date = '".time."'", __FILE__, __LINE__);
					$rs=$mysql->fetchRow($sql);
					
					$mysql->insert("pmmessage (id,message) VALUES (
						'$rs[0]','$message'
					)", __FILE__, __LINE__);
				}
				$mysql->update("changename SET status = '2' WHERE id IN ($ids)", __FILE__, __LINE__);
			}
			elseif($type==4){
				$mysql->delete("changename WHERE id IN ($ids)", __FILE__, __LINE__);
			}
			$DF->goTo("admincp.php?type=users&method=changenamewait&change=$type".(pg>1 ? "&pg=".pg : ""));
		}
		if(change>0){
			$msg=array(
				1=>"تمت موافقة على الأسماء المختارة بنجاح",
				2=>"تم رفض أسماء المختارة بنجاح",
				4=>"تم حذف أسماء المختارة بنجاح"
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		?>
		<script type="text/javascript">
		DF.userCmd=function(frm,status){
			var el=frm.elements,msg=new Array();
			for(var x=0,y=0;x<el.length;x++){
				if(el[x].type=='checkbox'&&el[x].checked){
					y++;
				}
			}
			if(y>0){
				msg[1]="هل انت متأكد بأن تريد موافقة على أسماء المختارة";
				msg[2]="هل انت متأكد بأن تريد رفض أسماء المختارة";
				msg[4]="هل أنت متأكد بأن تريد حذف أسماء المختارة";
				if(confirm(msg[status])){
					frm.type.value=status;
					frm.submit();
				}
			}
			else{
				alert("انت لم حددت اي اسم");
			}
		};
		</script>
		<?php
		echo"<div align=\"center\">{$Template->paging("changename WHERE status = 0","admincp.php?type=users&method=changenamewait&")}</div>";
		$text="
		<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=users&method=changenamewait&scope=change".(pg>1 ? "&pg=".pg : "")."\">
		<input type=\"hidden\" name=\"type\">
			<tr>
				<td class=\"statsHeader\"><nobr><input type=\"checkbox\" onclick=\"DF.checkAllByCheck(this,'id');\"></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم الحالي للعضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>اسم جديد للعضوية</b></nobr></td>
				<td class=\"statsHeader\"><nobr><b>تاريخ</b></nobr></td>
			</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT id,userid,newname,oldname,date FROM ".prefix."changename WHERE status = 0 ORDER BY date DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchRow($sql)){
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr>
				<td class=\"statsText$classNo\" align=\"center\"><input type=\"checkbox\" name=\"id[]\" value=\"$rs[0]\"><input type=\"hidden\" name=\"userid[]\" value=\"$rs[1]\"></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$Template->userNormalLink($rs[1],$rs[3])}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>$rs[2]</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$DF->date($rs[4])}</nobr></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"4\"><br>لا توجد أي اسم تنتظر الموافقة<br><br></td>
			</tr>";
		}
		$text.="
			<tr>
				<td class=\"statsText2\" align=\"center\" colspan=\"4\"><br>
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,1)\" value=\"موافقة على أسماء المختارة\">&nbsp;&nbsp;&nbsp;
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,2)\" value=\"رفض أسماء المختارة\">&nbsp;&nbsp;&nbsp;
					<input type=\"button\" class=\"button\" onclick=\"DF.userCmd(this.form,4)\" value=\"حذف أسماء المختارة\"><br><br>
				</td>
			</tr>
		</table>
		</form>";
		$Template->adminBox("أسماء ينتظر الموافقة",$text,50,0);
	}
	elseif($Template->adminMethod=='edituser'){
		if(scope=='change'){
			$userid=(int)$_POST['userid'];
			$name=$_POST['edUserName'];			$submonitor=$_POST['submonitor'];
			$entername=$_POST['edEnterUserName'];
			$level=(int)$_POST['edUserLevel'];
			$oldlevel=(int)$_POST['edUserOldLevel'];
			$email=$_POST['edUserEmail'];
			$title=($level>1 ? $_POST['edUserTitle'] : '');
			$photo=$_POST['edUserPhoto'];
			$sex=(int)$_POST['edUserSex'];
			$age=(int)$_POST['edUserAge'];
			$country=$_POST['edUserCountry'];
			$state=$_POST['edUserState'];
			$city=$_POST['edUserCity'];
			$marstatus=$_POST['edUserMarstatus'];
			$occupation=$_POST['edUserOccupation'];
			$biography=$_POST['edUserBiography'];
			if(empty($name)){
				$error="يجب عليك ان تكتب اسم العضوية";
			}
			elseif(empty($entername)){
				$error="يجب عليك ان تكتب اسم دخول العضوية";
			}
			elseif(empty($email)){
				$error="يجب ان تكتب عنوان بريد الالكتروني";
			}
			else{
				$error="";
			}
			if(!empty($error)){
				$Template->msgBox($error,'red',15,0,true,false,true);
			}
			else{
				$mysql->update("user SET name = '$name', entername = '$entername', level = '$level' , submonitor='$submonitor' WHERE id = '".u."'", __FILE__, __LINE__);
				$mysql->update("userflag SET
					email = '$email',
					title = '$title',
					photo = '$photo',
					sex = '$sex',
					age = '$age',
					country = '$country',
					state = '$state',
					city = '$city',
					marstatus = '$marstatus',
					occupation = '$occupation',
					{$DF->iff($level!=$oldlevel,"oldlevel = '$oldlevel',","")}
					biography = '$biography'
				WHERE id = $userid", __FILE__, __LINE__);
				$DF->goTo("admincp.php?type=users&method=edituser&change=1&u=$userid");
			}
		}
		if(change==1){
			$Template->msgBox('تم حفظ التغيرات بنجاح','green',15,25,true,false);
		}
		$sql=$mysql->query("SELECT 
			u.id,u.submonitor,u.name,u.entername,u.level,uf.email,uf.title,uf.photo,uf.sex,uf.age,uf.country,uf.state,uf.city,
			uf.marstatus,uf.biography,uf.occupation
		FROM ".prefix."user AS u 
		LEFT JOIN ".prefix."userflag AS uf ON(uf.id = u.id)
		WHERE u.id = '".u."'", __FILE__, __LINE__);
		$rs=$mysql->fetchAssoc($sql);
		if($rs){
			$text="
			<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" border=\"0\">
			<form method=\"post\" action=\"admincp.php?type=users&method=edituser&scope=change&u={$rs['id']}\" onSubmit=\"return confirm('هل أنت متأكد بأن تريد تعديل هذه العضوية ؟');\">
			<input type=\"hidden\" name=\"edUserOldLevel\" value=\"{$rs['level']}\">
			<input type=\"hidden\" name=\"userid\" value=\"{$rs['id']}\">
				<tr>
					<td>اسم العضوية</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserName','value'=>$rs['name']),true)}</td>
				</tr>
				<tr>
					<td>اسم دخول العضوية</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edEnterUserName','value'=>$rs['entername']),true)}</td>
				</tr>
				<tr>
					<td>الرتبة</td>
				</tr>
				<tr>
					<td>
					".$Template->fieldBox("
					<input type=\"radio\" name=\"edUserLevel\" value=\"1\" ".$DF->choose($rs['level'],1,'c').">&nbsp;عضو&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"edUserLevel\" value=\"2\" ".$DF->choose($rs['level'],2,'c').">&nbsp;مشرف&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"edUserLevel\" value=\"3\" ".$DF->choose($rs['level'],3,'c').">&nbsp;مراقب&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"edUserLevel\" value=\"4\" ".$DF->choose($rs['level'],4,'c').">&nbsp;مدير
					",500)."
					</td>
				</tr>	<tr>					<td>نائب  مراقب</td>				</tr>				<tr>					<td>					{$Template->fieldBox("					<input type=\"radio\" name=\"submonitor\" value=\"0\" ".$DF->choose($rs['submonitor'],0,'c').">&nbsp;لا&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					<input type=\"radio\" name=\"submonitor\" value=\"1\" ".$DF->choose($rs['submonitor'],1,'c').">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					",500)}					</td>				</tr
				<tr>
					<td>بريد الالكتروني</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserEmail','value'=>$rs['email'],'dir'=>'ltr'),true)}</td>
				</tr>
				<tr>
					<td>الوصف</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserTitle','value'=>$rs['title']),true)}</td>
				</tr>
				<tr>
					<td>صورة الشخصية</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserPhoto','value'=>$rs['photo'],'dir'=>'ltr'),true)}</td>
				</tr>
				<tr>
					<td>الجنس</td>
				</tr>
				<tr>
					<td>
					".$Template->fieldBox("
						<input type=\"radio\" name=\"edUserSex\" value=\"0\"".$DF->choose($rs['sex'],0,'c').">&nbsp;غير محدد&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=\"radio\" name=\"edUserSex\" value=\"1\"".$DF->choose($rs['sex'],1,'c').">&nbsp;ذكر&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=\"radio\" name=\"edUserSex\" value=\"2\"".$DF->choose($rs['sex'],2,'c').">&nbsp;أنثى
					",500)."
					</td>
				</tr>
				<tr>
					<td>العمر</td>
				</tr>
				<tr>
					<td>{$Template->input(200,array('name'=>'edUserAge','value'=>$rs['age']),true)}</td>
				</tr>
				<tr>
					<td>الدولة</td>
				</tr>
				<tr>
					<td>";
					$countries="";
					require_once _df_path."countries.php";
					foreach($country as $code=>$name){
						$countries.="
						<option value=\"{$code}\"{$DF->choose($rs['country'],$code,'s')}>{$name['name']}</option>";
					}
					$text.="
					{$Template->fieldBox("
					<select style=\"width:180px\" name=\"edUserCountry\">
					$countries
					</select>
					",200)}
					</td>
				</tr>
				<tr>
					<td>المنطقة</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserState','value'=>$rs['state']),true)}</td>
				</tr>
				<tr>
					<td>المدينة</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserCity','value'=>$rs['city']),true)}</td>
				</tr>
				<tr>
					<td>حالة الاجتماعية</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserMarstatus','value'=>$rs['marstatus']),true)}</td>
				</tr>
				<tr>
					<td>المهنة</td>
				</tr>
				<tr>
					<td>{$Template->input(500,array('name'=>'edUserOccupation','value'=>$rs['occupation']),true)}</td>
				</tr>
				<tr>
					<td>سيرة الذاتية</td>
				</tr>
				<tr>
					<td><textarea style=\"width:507;height:100px\" name=\"edUserBiography\">{$rs['biography']}</textarea></td>
				</tr>
				<tr>
					<td align=\"center\">
						<input type=\"submit\" class=\"button\" value=\"حفظ التغيرات\">&nbsp;&nbsp;
						<input type=\"reset\" class=\"button\" value=\"ارجاع بيانات الأصلية\">
					</td>
				</tr>
			</form>
			</table>";
			$Template->adminBox("تغيير بيانات عضوية ({$rs['name']})",$text,50,6);
		}
		else{
			$Template->msgBox("رقم العضوية الذي اخترت هو خاطيء",'red',15,0,true,false,true);
		}
	}
	elseif($Template->adminMethod=='userperm'){
		if(scope=='change'){
			$userid=(int)$_POST['userid'];
			$mysql->update("userperm SET
			receiveemail = '{$_POST['receiveemail']}',
			receivepm = '{$_POST['receivepm']}',
			changename = '{$_POST['changename']}',
			changeentername = '{$_POST['changeentername']}',
			hidephoto = '{$_POST['hidephoto']}',
			hidesignature = '{$_POST['hidesignature']}',
			hidearchive = '{$_POST['hidearchive']}',
			hideusers = '{$_POST['hideusers']}',
			hidesearch = '{$_POST['hidesearch']}',
			hidefavorite = '{$_POST['hidefavorite']}',
			hidebrowse = '{$_POST['hidebrowse']}',
			hidetopics = '{$_POST['hidetopics']}',
			hideposts = '{$_POST['hideposts']}',
			hidepm = '{$_POST['hidepm']}',
			hideselftopics = '{$_POST['hideselftopics']}',
			hideuserstopics = '{$_POST['hideuserstopics']}',
			hideselfposts = '{$_POST['hideselfposts']}',
			hideusersposts = '{$_POST['hideusersposts']}',
			hideselfprofile = '{$_POST['hideselfprofile']}',
			hideusersprofile = '{$_POST['hideusersprofile']}',
			stopsendpm = '{$_POST['stopsendpm']}',
			stopaddpost = '{$_POST['stopaddpost']}',
			postsundermon = '{$_POST['postsundermon']}',
			uneditsignature = '{$_POST['uneditsignature']}',
			sendcomplain = '{$_POST['sendcomplain']}',
			dochat = '{$_POST['dochat']}'
			WHERE id = '$userid'
			", __FILE__, __LINE__);
			$DF->goTo("admincp.php?type=users&method=userperm&change=1&u=$userid");
		}
		if(change==1){
			$Template->msgBox('تم حفظ التغيرات بنجاح','green',15,25,true,false);
		}
		$sql=$mysql->query("SELECT 
			u.name,up.*
		FROM ".prefix."user AS u 
		LEFT JOIN ".prefix."userperm AS up ON(up.id = u.id)
		WHERE u.id = ".u."", __FILE__, __LINE__);
		$rs=$mysql->fetchAssoc($sql);
		if($rs){
			$permlist=array(
				'receiveemail'=>'يستقبل رسائل بريد الالكتروني',
				'receivepm'=>'يستقبل رسائل خاصة',
				'changename'=>'إمكانية طلب تغير اسم العضوية',
				'changeentername'=>'إمكانية تغير اسم دخول للعضوية',
				'hidephoto'=>'إخفاء صورة الشخصية',
				'hidesignature'=>'إخفاء توقيع',
				'hidearchive'=>'إخفاء صفحة أرشيف للعضو',
				'hideusers'=>'إخفاء صفحة أعضاء للعضو',
				'hidesearch'=>'إخفاء محرك بحث للعضو',
				'hidefavorite'=>'إغلاق خاصية مفضلة من العضو',
				'hidebrowse'=>'إخفاء تصفح العضو للأعضاء الآخرين',
				'hidetopics'=>'إخفاء جميع مواضيع العضو',
				'hideposts'=>'إخفاء جميع ردود العضو',
				'hidepm'=>'إخفاء جميع رسائل خاصة للعضو',
				'hideselftopics'=>'إخفاء صفحة مواضيع العضو للآخرين',
				'hideuserstopics'=>'عدم إمكانية مشاهدة صفحة مواضيع الآخرين',
				'hideselfposts'=>'إخفاء صفحة مشاركات العضو للآخرين',
				'hideusersposts'=>'عدم إمكانية مشاهدة صفحة مشاركات الآخرين',
				'hideselfprofile'=>'إخفاء صفحة تفاصيل العضوية للآخرين',
				'hideusersprofile'=>'عدم إمكانية مشاهدة صفحة تفاصيل العضويات',
				'stopsendpm'=>'منع العضو من إرسال رسائل خاصة',
				'stopaddpost'=>'منع العضو من المشاركة في جميع منتديات',
				'postsundermon'=>'رقابة على مشاركات في جميع منتديات',
				'uneditsignature'=>'عدم إمكانية تغير توقيع',
				'sendcomplain'=>'امكانية ارسال شكاوي على الأعضاء',
				'dochat'=>'امكانية دخول الى نقاش حي'
			);
			$text="
			<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" border=\"0\">
			<form method=\"post\" action=\"admincp.php?type=users&method=userperm&scope=change&u={$rs['id']}\" onSubmit=\"return confirm('هل أنت متأكد بأن تريد تعديل تصاريح هذه العضوية ؟');\">
			<input type=\"hidden\" name=\"userid\" value=\"{$rs['id']}\">";
			foreach($permlist as $key=>$val){
				$keyrs=$rs["{$key}"];
				$text.="
				<tr>
					<td>$val</td>
				</tr>
				<tr>
					<td>
					{$Template->fieldBox("
						<input type=\"radio\" name=\"$key\" value=\"1\"".$DF->choose($keyrs,1,'c').">&nbsp;نعم&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=\"radio\" name=\"$key\" value=\"0\"".$DF->choose($keyrs,0,'c').">&nbsp;لا
					",500)}
					</td>
				</tr>";
			}
				$text.="
				<tr>
					<td align=\"center\">
						<input type=\"submit\" class=\"button\" value=\"حفظ التغيرات\">&nbsp;&nbsp;
						<input type=\"reset\" class=\"button\" value=\"ارجاع بيانات الأصلية\">
					</td>
				</tr>
			</form>
			</table>";
			$Template->adminBox("تعديل تصاريح العضوية ({$rs['name']})",$text,50,6);
		}
		else{
			$Template->msgBox("رقم العضوية الذي اخترت هو خاطيء",'red',15,0,true,false,true);
		}
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='ip'){
	if($Template->adminMethod=='checkip'){
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td>عنوان الـ IP</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('id'=>'ipfield','maxlength'=>15,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"document.location='admincp.php?type=ip&method=ipchecking&code='+$I('#ipfield').value;\" value=\"بحــــث\"></td>
			</tr>
		</table>";
		$Template->adminBox("أدخل عنوان الآي بي ليتم مطابقة",$text,50,0);
	}
	elseif($Template->adminMethod=='ipchecking'){
		$longip = (code != '' ? ip2long(code) : id);
		$ip = long2ip($longip);
		$text = "
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\"><nobr>الرقم</nobr></td>
				<td class=\"statsHeader\"><nobr>اسم العضوية</nobr></td>
				<td class=\"statsHeader\"><nobr>المطابقة</nobr></td>
			</tr>";
		$sql = $mysql->query("SELECT u.id, u.name, u.status, u.level, u.submonitor, IF(uf.ip = '{$longip}', 'last', 'all')
		FROM ".prefix."userflag AS uf
		LEFT JOIN ".prefix."user AS u ON(u.id = uf.id)
		WHERE uf.allip LIKE '%@{$longip}@%' ORDER BY u.id ASC", __FILE__, __LINE__);
		$count = 0;
		while($rs = $mysql->fetchRow($sql)){
			if($rs[5] == 'last'){
				$checking = "الآي بي يطابق آخر دخول للعضوية";
			}
			else{
				$checking = "الآي بي يطابق واحد من الآي بي السابقة";
			}
			$classNo = ($count % 2) ? 1 : 2;
			$text .= "
			<tr>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$rs[0]}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$Template->userColorLink($rs[0], array($rs[1], $rs[2], $rs[3], $rs[4]))}</nobr></td>
				<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$checking}</nobr></td>
			</tr>";
			$count++;
		}
		if($count == 0){
			$text .= "
			<tr>
				<td class=\"cellText\" align=\"center\" colspan=\"3\"><nobr><br>لم يتم العثور على اي عضوية يطابق هذا الآي بي<br><br></nobr></td>
			</tr>";
		}
		$text .= "
		</table>";
		$Template->adminBox("عضويات مطابقة للآي بي {$ip}", $text, 50, 0);
	}
	elseif($Template->adminMethod=='blockip'){
		if(scope=='change'){
			$ip=ip2long(trim($_POST['ip']));
			$cause=trim($_POST['cause']);
			$datetype=(int)trim($_POST['datetype']);
			$days=(int)trim($_POST['days']);
			$todate=($datetype==1 ? 0 : time+($days*86400));
			if($ip==0){
				$Template->msgBox("يبدو انك لم كتبت عنوان الـ IP او عنوان الذي كتبت خاطيء",'red',15,0,true,false,true);
			}
			else{
				$mysql->insert("ipban (ip,cause,fromdate,todate) VALUES ('$ip','$cause','".time."','$todate')", __FILE__, __LINE__);
				$DF->goTo("admincp.php?type=ip&method=blockip&change=1");
			}
		}
		elseif(scope=='trash'){
			$mysql->delete("ipban WHERE id = ".id."", __FILE__, __LINE__);
			$DF->goTo("admincp.php?type=ip&method=blockip&change=2".(pg>1 ? "&pg=".pg : ""));
		}
		if(change>0){
			$msg=array(
				1=>"تم حجب الـ IP بنجاح",
				2=>"تم حذف الحجب بنجاح"
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		$ip=(code!='' ? long2ip(code) : '');
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=ip&method=blockip&scope=change\">
			<tr>
				<td>عنوان الـ IP</td>
			</tr>
			<tr>
				<td>{$Template->input(500,array('name'=>'ip','value'=>$ip,'dir'=>'ltr'),true)}</td>
			</tr>
			<tr>
				<td>عدد أيام الحجب</td>
			</tr>
			<tr>
				<td>
				{$Template->fieldBox("
					<input type=\"radio\" name=\"datetype\" value=\"1\" onClick=\"this.form.days.disabled=true\" checked>&nbsp;للأبد&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=\"radio\" name=\"datetype\" value=\"0\" onClick=\"this.form.days.disabled=false\">&nbsp;لفترة معينة&nbsp;&nbsp;&nbsp;
					<input type=\"text\" style=\"width:40px;text-align:center\" maxlength=\"3\" name=\"days\" value=\"0\" disabled>&nbsp;&nbsp;&nbsp;<font class=\"small\">ملاحظة: إذا اخترت فترة معينة, ادخل عدد ايام في الحقل</font>
				",500)}
				</td>
			</tr>
			<tr>
				<td>السبب</td>
			</tr>
			<tr>
				<td><textarea style=\"width:507px;height:100px\" name=\"cause\"></textarea></td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"حجب\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("حجب الـ IP",$text,50,0);
		echo"<br><br>
		<div align=\"center\">{$Template->paging("ipban","admincp.php?type=ip&method=blockip&")}</div>";
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\">الـ IP</td>
				<td class=\"statsHeader\">السبب</td>
				<td class=\"statsHeader\">من</td>
				<td class=\"statsHeader\">الى</td>
				<td class=\"statsHeader\" colspan=\"2\">خيارات</td>
			</tr>";
		$pgLimit=$DF->pgLimit(num_pages);
		$sql=$mysql->query("SELECT id,ip,cause,fromdate,todate FROM ".prefix."ipban ORDER BY id DESC LIMIT $pgLimit,".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			$todate=($rs['todate']==0 ? 'للأبد' : $DF->date($rs['todate'],'date',true));
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText$classNo\" align=\"center\"><nobr>".long2ip($rs['ip'])."</nobr></td>
				<td class=\"statsText$classNo\">".nl2br($rs['cause'])."</td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$DF->date($rs['fromdate'],'date',true)}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>$todate</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\" width=\"1%\"><a href=\"admincp.php?type=ip&method=blockip&scope=trash".(pg>1 ? "&pg=".pg : "")."&id={$rs['id']}\"><img src=\"{$DFImage->i['delete']}\" alt=\"حذف الحجب\" border=\"0\"></a></td>
				<td class=\"statsText$classNo\" align=\"center\" width=\"1%\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 6);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText\" align=\"center\" colspan=\"6\"><nobr><br>لا توجد أي IP محجوب<br><br></nobr></td>
			</tr>";
		}
		$text.="
		</table>";
		$Template->adminBox("عنواين الـ IP المحجوب",$text,70,0);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='hacker'){
	if($Template->adminMethod=='hackersetform'){
		echo"<div align=\"center\">{$Template->paging("hacker","admincp.php?type=hacker&method=hackersetform&")}</div>";
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\"><nobr>نوع المحاولة</nobr></td>
				<td class=\"statsHeader\"><nobr>عدد محاولات</nobr></td>
				<td class=\"statsHeader\"><nobr>اسم العضوية</nobr></td>
				<td class=\"statsHeader\"><nobr>مسار المحاولة</nobr></td>
				<td class=\"statsHeader\"><nobr>جاء من رابط</nobr></td>
				<td class=\"statsHeader\"><nobr>IP</nobr></td>
				<td class=\"statsHeader\"><nobr>تاريخ</nobr></td>
				<td class=\"statsHeader\"><nobr>خيارات</nobr></td>
			</tr>";
		$sql=$mysql->query("SELECT h.*,u.name,u.status,u.level,u.submonitor
		FROM ".prefix."hacker AS h
		LEFT JOIN ".prefix."user AS u ON(u.id = h.userid)
		ORDER BY date DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchAssoc($sql)){
			if($rs['userid']>1000){
				$user=$Template->userColorLink($rs['userid'], array($rs['name'], $rs['status'], $rs['level'], $rs['submonitor']));
			}
			else{
				$user="<font class=\"small\" color=\"red\"><b>زوار</b></font>";
			}
			$ip=long2ip($rs['ip']);
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr id=\"getIpRow{$rs['id']}\">
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['subject']}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$rs['count']}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>$user</nobr></td>
				<td class=\"statsText$classNo\" align=\"left\" dir=\"ltr\">{$rs['url']}</td>
				<td class=\"statsText$classNo\" align=\"left\" dir=\"ltr\">{$rs['referer']}</td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><a href=\"http://".$DF->getCountryHostName()."/ip/?ip=$ip\">$ip</a></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr>{$DF->date($rs['date'],'date',true,true)}</nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$rs['ip']}, {$rs['id']}, this, 8);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"cellText\" align=\"center\" colspan=\"8\"><nobr><br>لا توجد أي محاولة<br><br></nobr></td>
			</tr>";
		}
		$text.="
		</table>";
		$Template->adminBox("محاولات إملاء فورم بطريق غير شرعي",$text,90,0);
	}
	elseif($Template->adminMethod == 'hackerseturl'){
		$file = 'attempts/attempts.log';
		if(file_exists($file)){
			@chmod($file, 0777);
			$content = @file($file, FILE_SKIP_EMPTY_LINES);
			@chmod($file, 0640);
		}
		else{
			$content = array();
		}
		$rows = count($content);
		if($rows > 0){
			echo"<div align=\"center\">{$Template->paging('','admincp.php?type=hacker&method=hackerseturl&', '', 50, $rows)}</div>";
		}
		$text = "
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\"><nobr>مسار المحاولة</nobr></td>
				<td class=\"statsHeader\"><nobr>IP</nobr></td>
				<td class=\"statsHeader\"><nobr>تاريخ</nobr></td>
				<td class=\"statsHeader\"><nobr>خيارات</nobr></td>
			</tr>";
		$y = 0;
		if($rows > 0){
			$i = $DF->pgLimit(50);
			$f = ($i + 50);
			for($x = $i; $x < $f; $x++){
				$val = str_replace('{>:r:<}', '', $content[$x]);
				$hacker = explode("{>:c:<}", $val);
				if(!empty($hacker[0])){
					$longip = (($ip = ip2long($hacker[1])) ? $ip : 0);
					$classNo = ($x % 2) ? 1 : 2;
					$text .= "
					<tr id=\"getIpRow{$x}\">
						<td class=\"statsText{$classNo}\" align=\"left\" dir=\"ltr\">".htmlspecialchars($hacker[0])."</td>
						<td class=\"statsText{$classNo}\" align=\"center\"><nobr><a href=\"http://{$DF->getCountryHostName()}/ip/?ip={$hacker[1]}\">{$hacker[1]}</a></nobr></td>
						<td class=\"statsText{$classNo}\" align=\"center\"><nobr>{$hacker[2]}</nobr></td>
						<td class=\"statsText{$classNo}\" align=\"center\"><img src=\"{$DFImage->i['expand']}\" onclick=\"DF.getUsersByIP({$longip}, {$x}, this, 4);\" style=\"cursor:pointer;\" alt=\"مطابقة IP\"></td>
					</tr>";
					$y++;
				}
				if($x == 100){
					break;
				}
			}
		}
		if($y == 0){
			$text .= "
			<tr>
				<td class=\"cellText\" align=\"center\" colspan=\"4\"><nobr><br>لا توجد أي إدخالات<br><br></nobr></td>
			</tr>";
		}
		$text .= "
		</table>";
		$Template->adminBox("إدخالات كلمات ممنوعة في الروابط", $text, 90, 0);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='block'){
	if($Template->adminMethod=='convertwords'){
		if(scope=='change'){
			$words=$_POST['words'];
			$replace=$_POST['replace'];
			for($x=0;$x<count($words);$x++){
				if(!empty($words[$x])&&!empty($replace[$x])){
					$mysql->insert("bad_words (code,val) VALUES ('$words[$x]','$replace[$x]')", __FILE__, __LINE__);
				}
			}
			$DF->goTo("admincp.php?type=block&method=convertwords&change=1");
		}
		elseif(scope=='trash'){
			$mysql->delete("bad_words WHERE id = ".id."", __FILE__, __LINE__);
			$DF->goTo("admincp.php?type=block&method=convertwords&change=2".(pg>1 ? "&pg=".pg : ""));
		}
		if(change>0){
			$msg=array(
				1=>"تم إضافة كلمات بنجاح",
				2=>"تم حذف الكلمة بنجاح"
			);
			$Template->msgBox($msg[change],'green',15,25,true,false);
		}
		?>
		<script	type="text/javascript">
		DF.setBadUrl=function(x){
			var field=$I('#fieldnum'+x);
			if(field){
				field.value='-- وصلة ممنوعة --';
			}
		};
		DF.addFieldToTable=function(){
			var tab=$I('#getIpTable'),row=tab.insertRow(tab.rows.length-1),cell1,cell2,cell3,cell4;
			// The words fields
			cell1=row.insertCell(0);
			cell1.innerHTML='الكلمة:';
			cell2=row.insertCell(1);
			cell2.innerHTML=this.input(150,['name','words[]'],true);
			// The replaces fields
			cell3=row.insertCell(2);
			cell3.innerHTML='بديلها:';
			cell4=row.insertCell(3);
			cell4.innerHTML=this.input(150,['name','replace[]','id','fieldnum'+row.rowIndex],true);
			// The addon button
			cell5=row.insertCell(4);
			cell5.innerHTML='<input type="button" class="button" onClick="DF.setBadUrl('+(row.rowIndex)+');" value="www">';
		};
		</script>
		<?php
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=block&method=convertwords&scope=change\">
			<tr>
				<td style=\"padding:10px\" colSpan=\"2\">
				<table id=\"getIpTable\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
					<tr>
						<td>الكلمة:</td>
						<td>{$Template->input(150,array('name'=>'words[]'),true)}</td>
						<td>بديلها:</td>
						<td>{$Template->input(150,array('name'=>'replace[]','id'=>'fieldnum0'),true)}</td>
						<td><input type=\"button\" class=\"button\" onClick=\"DF.setBadUrl(0);\" value=\"www\"></td>
					</tr>
					<tr>
						<td align=\"center\" colspan=\"5\"><a href=\"javascript:DF.addFieldToTable();\">-- أضف حقل جديد --</a></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onClick=\"this.form.submit();\" value=\"إدخال كلمات\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("كلمات ممنوعة",$text,50,0);
		echo"<br><br>
		<div align=\"center\">{$Template->paging("bad_words","admincp.php?type=block&method=convertwords&")}</div>";
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"statsHeader\">كلمة</td>
				<td class=\"statsHeader\">بديلها</td>
				<td class=\"statsHeader\">خيارات</td>
			</tr>";
		$sql=$mysql->query("SELECT id,code,val FROM ".prefix."bad_words ORDER BY id DESC LIMIT {$DF->pgLimit(num_pages)},".num_pages, __FILE__, __LINE__);
		$count=0;
		while($rs=$mysql->fetchRow($sql)){
			$classNo=($count%2 ? 1 : 2);
			$text.="
			<tr>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><b>$rs[1]</b></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\"><nobr><b>$rs[2]</b></nobr></td>
				<td class=\"statsText$classNo\" align=\"center\" width=\"1%\"><a href=\"admincp.php?type=block&method=convertwords&scope=trash".(pg>1 ? "&pg=".pg : "")."&id=$rs[0]\"><img src=\"{$DFImage->i['delete']}\" alt=\"حذف الكلمة\" border=\"0\"></a></td>
			</tr>";
			$count++;
		}
		if($count==0){
			$text.="
			<tr>
				<td class=\"statsText\" align=\"center\" colspan=\"3\"><nobr><br>لا توجد أي كلمة<br><br></nobr></td>
			</tr>";
		}
		$text.="
		</table>";
		$Template->adminBox("إستبدال كلمات في جميع مواضيع وردود ورسائل خاصة وحقول بيانات شخصية وعامة",$text,50,0);
	}
	elseif($Template->adminMethod=='blockwords'){
		if(scope=='change'){
			$blocked_tags=$DF->inlineText($_POST['blocked_tags']);
			$blocked_tags=(!empty($blocked_tags) ? explode(",",$blocked_tags) : array());
			$blocked_tags=$DF->deleteArrayBlanks($blocked_tags);
			$blocked_tags=serialize($blocked_tags);
			$DFOutput->setCnf('blocked_tags',$blocked_tags);
			
			$blocked_attributes=$DF->inlineText($_POST['blocked_attributes']);
			$blocked_attributes=(!empty($blocked_attributes) ? explode(",",$blocked_attributes) : array());
			$blocked_attributes=$DF->deleteArrayBlanks($blocked_attributes);
			$blocked_attributes=serialize($blocked_attributes);
			$DFOutput->setCnf('blocked_attributes',$blocked_attributes);
			
			$blocked_names=$DF->inlineText($_POST['blocked_names']);
			$blocked_names=(!empty($blocked_names) ? explode(",",$blocked_names) : array());
			$blocked_names=$DF->deleteArrayBlanks($blocked_names);
			$blocked_names=serialize($blocked_names);
			$DFOutput->setCnf('blocked_names',$blocked_names);
			
			$DF->goTo("admincp.php?type=block&method=blockwords&change=1");
		}
		if(change==1){
			$Template->msgBox('تم حفظ تغيرات بنجاح','green',15,25,true,false);
		}
		$text="
		<table width=\"100%\" cellSpacing=\"1\" cellPadding=\"4\" align=\"center\" border=\"0\">
		<form method=\"post\" action=\"admincp.php?type=block&method=blockwords&scope=change\">";
			$blocked_tags=unserialize(blocked_tags);
			$blocked_tags=implode(",",(is_array($blocked_tags) ? $blocked_tags : array()));
			$text.="
			<tr>
				<td>وسوم ممنوعة</td>
			</tr>
			<tr>
				<td><textarea style=\"width:507px;height:80px\" name=\"blocked_tags\" dir=\"ltr\">$blocked_tags</textarea></td>
			</tr>";
			$blocked_attributes=unserialize(blocked_attributes);
			$blocked_attributes=implode(",",(is_array($blocked_attributes) ? $blocked_attributes : array()));
			$text.="
			<tr>
				<td>أحداث ممنوعة</td>
			</tr>
			<tr>
				<td><textarea style=\"width:507px;height:200px\" name=\"blocked_attributes\" dir=\"ltr\">$blocked_attributes</textarea></td>
			</tr>";
			$blocked_names=unserialize(blocked_names);
			$blocked_names=implode(",",(is_array($blocked_names) ? $blocked_names : array()));
			$text.="
			<tr>
				<td>أسماء ممنوعة في التسجيل</td>
			</tr>
			<tr>
				<td><textarea style=\"width:507px;height:200px\" name=\"blocked_names\" dir=\"ltr\">$blocked_names</textarea></td>
			</tr>
			<tr>
				<td align=\"center\"><input type=\"button\" class=\"button\" onclick=\"this.form.submit();\" value=\"حفظ تغيرات\"></td>
			</tr>
		</form>
		</table>";
		$Template->adminBox("منع كلمات",$text,50,4);
	}
	else{
		$DF->goTo("admincp.php");
	}
}
elseif($Template->adminType=='chat'){
	$mysql->delete("chat WHERE date < ".(time-(60*60*3))."", __FILE__, __LINE__);
	?>
	<script type="text/javascript">
	var userName="<?=uname?>";
	</script>
	<?php
	$text="
	<input type=\"hidden\" id=\"chatStartTime\" value=\"".time."\">
	<table width=\"100%\" style=\"margin-top:2px\">
		<tr>
			<td class=\"statsText1\" valign=\"top\" id=\"usersPanel\" rowspan=\"2\" style=\"width:120px;height:400px;border:#cccccc 1px solid\"></td>
			<td class=\"statsText1\" valign=\"top\" style=\"width:600px;height:400px;border:#cccccc 1px solid\"><div class=\"chatMessages\" id=\"messagesPanel\" onscroll=\"DF.chatCheckScroll(this);\"><table cellspacing=\"2\" cellpadding=\"0\" width=\"100%\"></table></div></td>
		</tr>
		<tr>
			<td class=\"statsText1\" style=\"width:600px;height:75px;border:#cccccc 1px solid\">
			<table width=\"100%\">
				<tr>
					<td colspan=\"2\">
					<select style=\"width:110px\" id=\"chatFontName\" onchange=\"DF.chatSetStyle('Name');\">
						<option value=\"tahoma\" selected>Tahoma</option>
						<option value=\"arial\">Arial</option>
						<option value=\"arial black\">Arial black</option>‌
						<option value=\"comic sans ms\">Comic Sans MS</option>
						<option value=\"courier new\">Courier New</option>
						<option value=\"diwani letter\">Diwani</option>
						<option value=\"monotype kufi\">Kufi</option>
						<option value=\"andalus\">Andalus</option>
					</select>
					<select style=\"width:40px\" id=\"chatFontSize\" onchange=\"DF.chatSetStyle('Size');\">
						<option value=\"10\">10</option>
						<option value=\"11\">11</option>‌
						<option value=\"12\" selected>12</option>
						<option value=\"13\">13</option>
						<option value=\"14\">14</option>
						<option value=\"15\">15</option>
						<option value=\"16\">16</option>
						<option value=\"17\">17</option>
						<option value=\"18\">18</option>
						<option value=\"19\">19</option>
						<option value=\"20\">20</option>
					</select>
					<select style=\"width:70px\" id=\"chatFontColor\" onchange=\"DF.chatSetStyle('Color');\">
						<option value=\"#000000\" style=\"background:#000000;\" selected>&nbsp;</option>
						<option value=\"#FF0066\" style=\"background:#FF0066;\">&nbsp;</option>
						<option value=\"#0000FF\" style=\"background:#0000FF;\">&nbsp;</option>
						<option value=\"#CCCC00\" style=\"background:#CCCC00;\">&nbsp;</option>
						<option value=\"#FF00FF\" style=\"background:#FF00FF;\">&nbsp;</option>
						<option value=\"#008000\" style=\"background:#008000;\">&nbsp;</option>
						<option value=\"#000080\" style=\"background:#000080;\">&nbsp;</option>
						<option value=\"#800080\" style=\"background:#800080;\">&nbsp;</option>
						<option value=\"#808080\" style=\"background:#808080;\">&nbsp;</option>
						<option value=\"#008080\" style=\"background:#008080;\">&nbsp;</option>
						<option value=\"#CC0000\" style=\"background:#CC0000;\">&nbsp;</option>
						<option value=\"#996600\" style=\"background:#996600;\">&nbsp;</option>
					</select>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><textarea style=\"width:530px;height:70px;font-weight:normal;font-family:tahoma;font-size:12px;color:#000000\" id=\"messageBox\" onkeypress=\"if(event.keyCode==13){DF.chatSendMsg();return false}\"></textarea></td>
					<td>
					<table>";
					$smiles=array(array('icon','cool','big'),array('angry','blackeye','dissapprove'),array('crying','eyebrows','hearteyes'));
					foreach($smiles as $smile){
						$text.="
						<tr>
							<td><img src=\"images/smiles/{$smile[0]}.gif\" onclick=\"DF.insertSmile('{$smile[0]}');\" border=\"0\"></td>
							<td><img src=\"images/smiles/{$smile[1]}.gif\" onclick=\"DF.insertSmile('{$smile[1]}');\" border=\"0\"></td>
							<td><img src=\"images/smiles/{$smile[2]}.gif\" onclick=\"DF.insertSmile('{$smile[2]}');\" border=\"0\"></td>
						</tr>";
					}	
					$text.="
					</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>";
	$Template->adminBox("نقاش حي بين المدراء",$text,0,0);
	?>
	<script type="text/javascript">
	setTimeout("DF.chatActivity(0)",1000);
	function ddd(){
		$I('#txt').value=$I('#messagesPanel').innerHTML;
	}
	</script>
	<?php
}
else{
	$DF->goTo("admincp.php");
}
// End Admin Control Panel
$Template->adminFooter();
}
else{
	$DF->goTo("admin_login.php?src=".urlencode(self));
}
?>
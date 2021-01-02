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

class Template{
	var $DF = null;
	var $mysql;
	var $DFImage;
	var $dir = 'rtl';
	var $checkThisScript = '';
	var $noAlign = 'right';
	var $align = 'left';
	var $forumsList = array();
	var $adminType = "";
	var $adminMethod = "";
	var $groups = array(
		'الكل',
		'الأعضاء',
		'المشرفون',
		'المراقبون',
		'المدراء'
	);
	var $monthName = array(
		"",
		"يناير",
		"فبراير",
		"مارس",
		"أبريل",
		"مايو",
		"يونيو",
		"يوليو",
		"أغسطس",
		"سبتمبر",
		"أكتوبر",
		"نوفمبر",
		"ديسمبر"
	);
	var $weekName = array(
		"الأحد",
		"الاثنين",
		"الثلاثاء",
		"الأربعاء",
		"الخميس",
		"الجمعة",
		"السبت"
	);
	function __construct($DF){
		if(is_object($DF)){
			$this->DF =& $DF;
		}
		else{
			trigger_error("<strong>df</strong> class df is not an object", E_USER_ERROR);
		}
		$this->mysql = $this->DF->mysql;
		$this->DFImage = $this->DF->DFImage;
	}
	function header($showContent = true, $otherHead = '', $onload = ''){
		ob_start();
		$bodyEvents = '';
		if(_df_script == 'editor'){
			$bodyEvents.=" onbeforeunload=\"beforeUnload(event);\"";
		}

		$forumTitle = forum_title;
		$subTitle = $this->getSubTitle();

		$eventOnLoad = (!empty($onload)) ? " onload=\"{$onload}\"" : "";
		// head tag children
		$head_rows = "";
		$head_rows .= "\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
		$head_rows .= "\n<meta http-equiv=\"Content-Language\" content=\"ar-iq\" />";
		$head_rows .= "\n<meta name=\"copyright\" content=\"Duhok Forum: Copyright © 2009-2021 Dilovan Matini\" />";
		$head_rows .= "\n<meta name=\"keywords\" content=\"{$forumTitle}{$subTitle}, ".site_keywords."\" />";
		$head_rows .= "\n<meta name=\"description\" content=\"{$forumTitle}{$subTitle}\" />";
		$head_rows .= "\n<link rel=\"icon\" href=\"./favicon.ico\" type=\"image/x-icon\" />";
		$head_rows .= "\n<link rel=\"shortcut icon\" href=\"./favicon.ico\" type=\"image/x-icon\" />";
		$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/reset.css".x."\" />";
		$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/html.css".x."\" />";
		$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/fonts/style.css".x."\" />";
		if(_df_script != 'admincp'){
			$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/".choosed_style."/style.css".x."\" />";
			$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/".choosed_stylefont.".css".x."\" />";
		}
		$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/globals.css".x."\" />";
		$head_rows .= "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"js/dm/assets/style-1.0.css".x."\" />";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/jquery/jquery-1.11.1.min.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/jquery/jquery-migrate-1.2.1.min.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/ui/jquery-ui.min.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/jquery/jquery.plugins.min.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/lib/library.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/lib/plugins.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/dm/dm-1.0.js".x."\"></script>";
		$head_rows .= "\n<script type=\"text/javascript\" src=\"js/globals.js".x."\"></script>";

		//$head_rows .= "\n<script type=\"text/javascript\" src=\"js/basicc.js".x."\"></script>"; // snow falling effect
		if(_df_script == 'profile'){
			$head_rows .= "\n<script type=\"text/javascript\" src=\"build/yahoo-dom-event/yahoo-dom-event.js".x."\"></script>";
			$head_rows .= "\n<script type=\"text/javascript\" src=\"build/element/element-min.js".x."\"></script>";
		}
		if(ulv > 2){
			$head_rows .= "\n<script type=\"text/javascript\" src=\"js/adminiglobals.js".x."\"></script>";
		}
		
		echo str_replace("\t","","<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
		<html dir=\"{$this->dir}\" xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<title>{$forumTitle}{$subTitle}</title>{$head_rows}
		<!--[if IE 6]>
		<style type=\"text/css\">.as-sub-menu{display:none;}</style>
		<script src=\"js/DD_belatedPNG-min.js".x."\"></script>
		<script>DD_belatedPNG.fix('.png, img');</script>
		<script src=\"js/ie6.js".x."\"></script>
		<![endif]-->
		{$this->jsGlobalVariables()}{$otherHead}
		</head>
		<body class=\"yui-skin-sam\" onClick=\"DF.menu.click(event)\"{$bodyEvents}{$eventOnLoad}>\n<img src=\"styles/".choosed_style."/header_right.jpg".x."\" style=\"display:none;\">");
		if(shut_down_status and ulv < 4){
			echo"<br><br>
			<table width=\"50%\" cellSpacing=\"0\" cellPadding=\"6\" align=\"center\">
				<tr>
					<td class=\"asTopHeader2 asAS12 asS15 asC2 asCenter\">";
					if( forum_logo != '' ){
						echo"
						<img src=\"".forum_logo."\" alt=\"".forum_title."\" width=\"70\" border=\"0\">";
					}
					echo"
					<br><br>
					".nl2br(shut_down_msg)."
					<br><br>
					<a class=\"sec\" href=\"".self."\">-- إضغط هنا للمحاولة مرة أخرى --</a>
					</td>
				</tr>
			</table></body></html>";
			exit();
		}
		if( shut_down_status and ulv == 4 and _df_script != 'admincp' and _df_script != 'admin_login' ){
			echo"
			<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"6\">
				<tr>
					<td class=\"asErrorDot\"><nobr>منتديات مقفولة حالياً</nobr></td>
				</tr>
			</table>";
		}
		if( is_dir("installl") ){
			echo"
			<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"6\">
				<tr>
					<td class=\"asErrorDot\"><nobr>أنت لم حذفت مجلد install، يرجى حذفه بأسرع وقت ممكن</nobr></td>
				</tr>
			</table>";
		}
		$rs = $this->mysql->queryRow("SELECT cause FROM ".prefix."ipban WHERE ip = '".ip2."' AND (todate = 0 OR todate > ".time.") ORDER BY id DESC", __FILE__, __LINE__);
		if($rs){
			$this->errMsg('تم منعك من دخول او مشاهدة '.forum_title.(!empty($rs[0]) ? "<br>السبب:-<br>{$rs[0]}" : "<br>من قبل إدارة منتديات"), 1, false, false);
		}
		if(ip2 == 0){
			$this->errMsg("تم منعك من دخول او مشاهدة ".forum_title."<br>بسبب ان الأي بي الخاص بك ممنوع وهو ".ip, 1, false, false);
		}
		if($showContent){
			$this->headerContent();
		}
		if(ulv == 0 and type == 'login'){
			$loginError = $this->DFOutput->checkLoginName();
			if(!empty($loginError)){
				$this->loginErrorMsg($loginError);
			}
		}
		if(visitor_can_show_forums == 0 and ulv == 0){
			$this->errMsg("لا يمكنك مشاهدة المنتديات لانك لست عضوا بالمنتدى<br>ان كنت عضوا معنا فبرجاء تسجيل الدخول الى حسابك من الخيار اعلاه<br>وان لم تكن مسجلا , اضغط على الرابط اسفله للتسجيل .<br><br><a href=\"register.php\"><img src=\"{$this->DFImage->h['details']}\" border=\"0\"><br><font size=\"3\">سجل نفسك كعضو</font></a>");
		}
	}
	function jsGlobalVariables(){
		if(ulv > 1){
			$menuText = "
				[59,['أضف وسام التميز للعضو','svc.php?svc=medals&type=awardforums&u={u}']],
				[58,['تفاصيل أوسمة العضو','svc.php?svc=medals&type=distribute&app=all&scope=all&days=-1&u={u}']],
				[57,['أضف وصف للعضو','svc.php?svc=titles&type=awardforums&u={u}']],
				[56,['تفاصيل أوصاف العضو','svc.php?svc=titles&type=usertitles&u={u}']],
				[55,['تطبيق عقوبة على العضو','svc.php?svc=mons&type=addmon&u={u}']],
				[54,['تفاصيل عقوبات العضو','svc.php?svc=mons&type=global&scope=all&app=all&days=-1&u={u}']],
				[69,['مواضيع تنتظر الموافقة','forums.php?f={f}&option=mo']],
				[68,['مواضيع مجمدة','forums.php?f={f}&option=ho']],
				[67,['ردود تنتظر الموافقة','forums.php?f={f}&option=rmo']],
				[66,['ردود مجمدة','forums.php?f={f}&option=rho']],
				[65,['رسائل إشرافية جديدة','pm.php?mail=new&f=-{f}']],
				[64,['شكاوي جديدة','svc.php?svc=complain&type=global&scope=forum&app=new&f={f}']],
				[79,['ردود تنتظر الموافقة','topics.php?t={t}&option=mo']],
				[78,['ردود مجمدة','topics.php?t={t}&option=ho']],
				[77,['إحصائيات ردود الأعضاء','options.php?type=topicstats&t={t}']],
				[76,['أعضاء مخولين لرؤية الموضوع','options.php?type=topicusers&t={t}']],
			";
		}
		if(ulv == 3){
			$menuText .= "
				[97,['رسائل خاصة للعضو','pm.php?mail=in&auth={u}']],
			";
		}
		if(ulv == 4){
			$menuText .= "
				[99,['سجل دخول للعضوية','profile.php?type=loginbar&u={u}']],
				[98,['محاولات دخول للعضوية','profile.php?type=trylogin&u={u}']],
				[97,['رسائل خاصة للعضو','pm.php?mail=in&auth={u}']],
				[96,['تعديل التوقيع','editor.php?type=signature&u={u}&src=".urlencode(self)."']],
				[95,['تعديل العضوية','admincp.php?type=users&method=edituser&u={u}']],
				[94,['تعديل تصاريح','admincp.php?type=users&method=userperm&u={u}']],
				[93,['مطابقة IP','admincp.php?type=ip&method=ipchecking&u={u}&id={o}']],
				[83,['نشاط العضوية','profile.php?type=activity&auth={u}']],
				[84,['أصدقاء العضوية','friends.php?scope=wait&auth={u}']],
				[89,['تعديل المنتدى','forumadmin.php?type=edit&f={f}']],
				[88,['إخفاء المنتدى','forumadmin.php?type=hidden&f={f}']],
				[87,['إظهار المنتدى','forumadmin.php?type=visible&f={f}']],
				[86,['قفل المنتدى','forumadmin.php?type=lock&f={f}']],
				[85,['فتح المنتدى','forumadmin.php?type=open&f={f}']],
			";
		}
		$menuText = "[{$this->DF->striplines($menuText,true)}[0,['','']]]";
		$variables = "<script type=\"text/javascript\">
		var dir=\"rtl\",
		xcode=\"".x."\",
		userId=".uid.",
		userLevel=".ulv.",
		isModerator=".($isModerator ? "true" : "false").",
		isMonitor=".($isMonitor ? "true" : "false").",
		self=\"".self."\",
		thisFile=\""._df_filename."\","
		.(ulv==4?"adAjaxFile=\"ajax_admin.php\",":"")."
		menubarHighlight=\"".menubar_highlight."\",
		loadingUrl=\"{$this->DFImage->i['loading']}\",
		progressUrl=\"{$this->DFImage->i['progress']}\",
		succeedUrl=\"{$this->DFImage->i['succeed']}\",
		errorUrl=\"{$this->DFImage->i['error']}\",
		nophotoUrl=\"{$this->DFImage->i['nophoto']}\";
		$(document).ready(function(){
			DF.menu.load({$menuText});
			DF.menu.checkElements();
			DF.checkTHLink();
			DF.headerIcons.load();
			DF.searchBar.setEvents();
		});
		</script>";
		$variables=str_replace(array("\n","\r","\t"),"",$variables);
		return $variables;
	}
	function headerContent(){
		echo"
		<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
			<tr>
				<td class=\"header-bg\" style=\"padding:0 2px 0 0\">
					<div class=\"as-main-menu\">
						<div class=\"as-sub-menu\">
							<ul>
								<li class=\"menu-item\"><a href=\"index.php\" main=\"1\">الصفحة الرئيسية</a></li>";
							if(ulv>0){
								echo"
								<li class=\"menu-item\">
									<a href=\"#\"><span>عضويتك</span></a>
									<ul>
										<li class=\"menu-item\">
											<a href=\"profile.php?type=details\" main=\"1\"><span>بياناتك</span></a>
											<ul>
												<li class=\"menu-item\"><a href=\"profile.php?type=editpicture\">صورة الشخصية</a></li>
												<li class=\"menu-item\"><a href=\"friends.php?scope=friends\">الأصدقاء</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=notifications\">الإشعارات</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=editpass\">بريد الالكتروني وكلمة السرية</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=editdetails\">خيارات العضوية وبيانات الشخصية</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=activity\">نشاطك في المنتدى</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=medals\">تفاصيل الأوسمة الممنوحة لك</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=hiddentopics\">المواضيع المخفية المفتوحة لك</a></li>
												<li class=\"menu-item\"><a href=\"editor.php?type=signature&src=".urlencode(self)."\">توقيعك الذي يظهر اسفل مشاركاتك</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=changename\">طلب تغيير اسم العضوية</a></li>";
											if(ulv > 1){
												echo"
												<li class=\"menu-item\"><a href=\"profile.php?type=loginbar\">تفاصيل الاتصال لعضويتك</a></li>
												<li class=\"menu-item\"><a href=\"profile.php?type=trylogin\">محاولات الدخول لعضويتك</a></li>";
											}
											echo"
												<li class=\"menu-item\"><a href=\"profile.php?type=loginsessions\">جلسات دخول لعضويتك&nbsp;&nbsp;<i class=\"asCOrange asS11\" style=\"\">(جديد)</i></a></li>
											</ul>
										</li>
										<li class=\"menu-item\"><a href=\"yourposts.php\" main=\"1\">مشاركاتك</a></li>
										<li class=\"menu-item\"><a href=\"yourtopics.php\" main=\"1\">مواضيعك</a></li>
										<li class=\"menu-item\">
											<a href=\"#\"><span>الرسائل</span></a>
											<ul>
												<li class=\"menu-item\"><a href=\"pm.php?mail=new\">الرسائل الواردة الجديدة</a></li>
												<li class=\"menu-item\"><a href=\"pm.php?mail=in\" main=\"1\">البريد الوارد</a></li>
												<li class=\"menu-item\"><a href=\"pm.php?mail=out\">البريد الصادر</a></li>
												<li class=\"menu-item\"><a href=\"pm.php?mail=trash\">مجلد المحذوفات</a></li>
											</ul>
										</li>
										<li class=\"menu-item\"><a href=\"favorite.php\" main=\"1\">المفضلة</a></li>
									</ul>
								</li>";
							}	
								echo"
								<li class=\"menu-item\"><a href=\"archive.php\" main=\"1\">الأرشيف</a></li>
								<li class=\"menu-item\"><a href=\"users.php\" main=\"1\">الأعضاء</a></li>
								<li class=\"menu-item\"><a href=\"active.php\">مواضيع نشطة</a></li>
								<li class=\"menu-item\"><a href=\"search.php\" main=\"1\">إبحث</a></li>
								<li class=\"menu-item\"><a href=\"forums.php?f=".help_forum_id."\" main=\"1\">المساعدة</a></li>";
							if(ulv==4){
								echo"
								<li class=\"menu-item\"><a href=\"admin_login.php\" main=\"1\">الإدارة</a></li>";
							}
							if(ulv>0){
								echo"
								<li class=\"menu-item\"><a href=\"index.php?type=logout&src=".urlencode(self)."\"{$this->DF->confirm('هل أنت متأكد بأن تريد تسجيل الخروج ؟')} main=\"1\">خروج</a></li>";
							}
							else{
								echo"
								<li class=\"menu-item\"><a href=\"register.php\" main=\"1\">تسجيل</a></li>";
							}
							echo"
							</ul>
						</div>
					</div>
				</td>
				<td class=\"header-bg\" style=\"padding:".( ulv > 0 ? '0 0 0 2px' : '0 0 2px 4px' ).";\" align=\"left\">";
				if( ulv == 0 ){
					echo"
					<script type=\"text/javascript\">
					$(function(){
						$('#login_user_name').focus();
						$('#login_user_name').keypress(function(e){
							if(e.which==13){
								DF.loginSubmit();
							}
						});
						$('#login_user_pass').keypress(function(e){
							if(e.which==13){
								DF.loginSubmit();
							}
						});
					});
					DF.loginSubmit=function(){
						if($('#login_user_name').val()!=''&&$('#login_user_pass').val()!=''){
							\$I('#loginForm').submit();
						}
					};
					</script>
					<form id=\"loginForm\" method=\"post\" action=\"index.php?type=login\">";
				}
					echo"
					<table cellpadding=\"0\" cellspacing=\"0\">
						<tr>";
				if( ulv > 0 ){
						if( ulv == 4 ){
							echo"
							<td id=\"hd-icons-changenames\" class=\"header-icons2 dis-none\"><div class=\"icons\"><img class=\"size-16 cur-pointer\" src=\"images/icons/header-change-name.gif\"></div></td>
							<td id=\"hd-icons-newusers\" class=\"header-icons2 dis-none\"><div class=\"icons\"><img class=\"size-16 cur-pointer\" src=\"images/icons/header-new-user.gif\"></div></td>";
						}
							global $DFPhotos;
							echo"
							<td id=\"hd-icons-notifies\" class=\"header-icons2\"><div class=\"icons\"><img class=\"size-16 cur-pointer\" src=\"images/icons/header-notifications.gif\"></div></td>
							<td id=\"hd-icons-friends\" class=\"header-icons2\"><div class=\"icons\"><img class=\"size-16 cur-pointer\" src=\"images/icons/header-friends.gif\"></div></td>
							<td id=\"hd-icons-messages\" class=\"header-icons2\"><div class=\"icons\"><img class=\"size-16 cur-pointer\" src=\"images/icons/header-messages.gif\"></div></td>
							<td class=\"header-icons\"><div class=\"posts\"><img class=\"arrow\" src=\"images/icons/header-arrow-left.gif\" width=\"5\" height=\"9\"><div class=\"box\">".uposts."</div></div></td>
							<td class=\"header-icons\"><a href=\"yourposts.php\"><img class=\"size-16\" src=\"images/icons/header-posts.gif\"></a></td>
							<td><div style=\"border-left:#ccc 1px solid;\">&nbsp;</div></td>
							<td class=\"asACWhite\" style=\"padding:0 15px 0 5px;\"><nobr><a href=\"profile.php?u=".uid."\">".uname."</a></nobr></td>
							<td class=\"asBSilver\"><a href=\"profile.php?type=editpicture\" title=\"تغيير صورة الشخصية\"><img id=\"hdPic32\" src=\"".$DFPhotos->getsrc(upicture, 48)."\"{$this->DF->picError(32)} alt=\"تغيير صورة الشخصية\" width=\"32\" height=\"32\"></a></td>";
				}
				else{
							echo"
							<td class=\"login-panel\"><nobr>الإسم</nobr></td>
							<td class=\"login-panel\"><input type=\"text\" class=\"input\" style=\"width:100px\" tabindex=\"1\" name=\"login_user_name\" id=\"login_user_name\" dir=\"rtl\"></td>
							<td class=\"login-panel\"><nobr>الكلمة السرية</nobr></td>
							<td class=\"login-panel\"><input type=\"password\" class=\"input\" style=\"width:100px\" tabindex=\"2\" name=\"login_user_pass\" id=\"login_user_pass\" dir=\"rtl\"></td>
							<td class=\"login-panel asS12\" dir=\"rtl\"><input type=\"checkbox\" name=\"login_save\" value=\"1\" checked>&nbsp;إحفظ كلمة السرية&nbsp;</td>
							<td class=\"login-panel\">{$this->button("أدخل"," tabindex=\"3\" onClick=\"DF.loginSubmit();\"")}</td>";
				}
						echo"
						</tr>
					</table>";
				if( ulv == 0 ){
					echo"
					</form>";
				}
				echo"
				</td>
			</tr>
		</table>
		<table class=\"headerbar\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
			<tr>
				<td class=\"right\">";
				if( forum_logo != '' ){
					echo"
					<img src=\"".forum_logo."\">";
				}
					echo"
					<div>".forum_title."</div>
				</td>
				<td class=\"left\">
					<div class=\"left-div\">
						<div class=\"asTopHeader2 toolsbar\">
							<table cellpadding=\"2\" cellspacing=\"2\" width=\"240\">
								<tr>
									<td class=\"asTitle\" align=\"center\" style=\"padding:0\" colspan=\"2\">
										<table cellpadding=\"0\" cellspacing=\"2\" width=\"100%\">
											<tr>
												<td class=\"asTitle\"><div class=\"searchPanel\"><input type=\"text\" class=\"searchInput\" id=\"header_search_inp\"><img class=\"searchIcon\" id=\"header_search_btn\" src=\"images/icons/search.gif\"><div class=\"searchResult\" id=\"header_search_res\"></div></div></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=\"asTitle styles-panel\" align=\"center\">
										<table cellpadding=\"2\" cellspacing=\"3\">
											<tr>
												<td".(choosed_style == 'blue' ? ' class="current"' : '')." style=\"background-color:#02a0f7;\" onclick=\"document.location='index.php?style=blue&src=".urlencode(self)."';\">&nbsp;</td>
												<td".(choosed_style == 'green' ? ' class="current"' : '')." style=\"background-color:#8ee426;\" onclick=\"document.location='index.php?style=green&src=".urlencode(self)."';\">&nbsp;</td>
												<td".(choosed_style == 'red' ? ' class="current"' : '')." style=\"background-color:#e8234d;\" onclick=\"document.location='index.php?style=red&src=".urlencode(self)."';\">&nbsp;</td>
												<td".(choosed_style == 'purple' ? ' class="current"' : '')." style=\"background-color:#ee2fc0;\" onclick=\"document.location='index.php?style=purple&src=".urlencode(self)."';\">&nbsp;</td>
											</tr>
										</table>
									</td>
									<td class=\"asTitle font-panel\" align=\"center\" style=\"padding:0\">
										<table cellpadding=\"2\" cellspacing=\"3\">
											<tr>
												<td class=\"asTitle arial".(choosed_stylefont == 'arial' ? ' current' : '')."\" onclick=\"document.location='index.php?stylefont=arial&src=".urlencode(self)."';\">آريــال</td>
												<td class=\"asTitle tahoma".(choosed_stylefont == 'tahoma' ? ' current' : '')."\" onclick=\"document.location='index.php?stylefont=tahoma&src=".urlencode(self)."';\">تاهوما</td>
												<td class=\"asTitle sans".(choosed_stylefont == 'sans' ? ' current' : '')."\" onclick=\"document.location='index.php?stylefont=sans&src=".urlencode(self)."';\">سانس</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td class=\"asTitle time-panel\" align=\"center\" style=\"padding:0\" colspan=\"2\">
										<table cellpadding=\"2\" cellspacing=\"3\">
											<tr>
												<td class=\"asTitle linktab\" onclick=\"DF.timezone.run(this,".choosed_timezone.");\" self=\"".urlencode(self)."\"><div id=\"timezoneParent\"><nobr>GMT".(choosed_timezone == 0 ? '' : (choosed_timezone > 0 ? '+'.choosed_timezone : choosed_timezone))."</nobr></div></td>
												<td class=\"asTitle\">{$this->DF->date(time,'time')}</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<img class=\"left-img\" src=\"{$this->DFImage->i['blank']}\">
					</div>
				</td>
			</tr>
		</table>";
	}
	function footer($status = true, $admin = false, $xfooter = false){
		if($status){
			$code="";
			if(!$admin){
				if(_df_script == 'index'){
					$user_name_color = unserialize(user_name_color);
					$code.="
					<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
						<tr>
							<td class=\"asHeader\">معلومات</td>
						</tr>
						<tr>
							<td class=\"asBody\">
							<table cellpadding=\"0\" cellspacing=\"2\">
								<tr>
									<td class=\"asTitle\">ألوان أسماء العضويات حسب رتب</td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[4][1]}\">المدراء</font></td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[3][1]}\">المراقبون</font></td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[2][1]}\">نواب المراقبون</font></td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[2][0]}\">المشرفون</font></td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[1][1]}\">الأعضاء</font></td>
										<td class=\"asNormal asS12 asHP6\"><font color=\"{$user_name_color[1][0]}\">العضويات المقفولة</font></td>
								</tr>
							</table>
							</td>
						</tr>
					</table>";
				}
				if(ulv == 4){
					$microtime = explode(' ', microtime());
					$sizetype = "B";
					$memory = memory_get_usage();
					if($memory >= 1000){
						$sizetype = "KB";
						$memory = ($memory / 1024);
					}
					if($memory >= 1000){
						$sizetype = "MB";
						$memory = ($memory / 1024);
					}
					$memory = number_format($memory, 2);
					$code.="
					<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
						<tr>
							<td class=\"asHeader\">إحصائيات تحميل هذه الصفحة</td>
						</tr>
						<tr>
							<td class=\"asBody\">
							<table cellpadding=\"0\" cellspacing=\"2\">
								<tr>
									<td class=\"asTitle\">تم تحميل صفحة خلال</td><td class=\"asText2\">".round($microtime[0], 3)." ثواني</td>
									<td class=\"asTitle\">الحجم البيانات التي قي الصفحة</td><td class=\"asText2\" dir=\"ltr\">{$memory} {$sizetype}</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>";
				}
				$code.="
				<table width=\"100%\" cellpadding=\"8\" cellspacing=\"0\" align=\"center\">
					<tr>
						<td class=\"asMainFooter\">
						<table width=\"80%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
							<tr>
								<td width=\"40%\" dir=\"ltr\" height=\"100\">
								<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
									<tr>
										<td class=\"asC2 asFoText1\" dir=\"ltr\"><img src=\"images/favicon/light/favicon-32x32.png\" style=\"width:24px;\"> Duhok Forum "._script_version."</td>
									</tr>
									<tr>
										<td class=\"asCSilverLight asFoText2\" dir=\"ltr\"><nobr>".forum_copy_right."</nobr></td>
									</tr>
									<tr>
										<td class=\"asC2 asFoText2\" dir=\"ltr\" onclick=\"dm.goTo('http://dilovanmatini.com');\" style=\"cursor:pointer;\"><nobr>Programmed By Dilovan Matini</nobr></td>
									</tr>
								</table>
								</td>
								<td width=\"2%\" align=\"center\"><img src=\"styles/globals/footersep.png\" border=\"0\"></td>
								<td>
								<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
									$rs=$this->mysql->queryRow("SELECT id FROM ".prefix."user ORDER BY id DESC LIMIT 1", __FILE__, __LINE__);
									$allUsers=number_format($rs[0]);
									$rs=$this->mysql->queryRow("SELECT id FROM ".prefix."topic ORDER BY id DESC LIMIT 1", __FILE__, __LINE__);
									$allTopics=number_format($rs[0]);
									$rs=$this->mysql->queryRow("SELECT id FROM ".prefix."post ORDER BY id DESC LIMIT 1", __FILE__, __LINE__);
									$allPosts=number_format($rs[0]);
									$code.="
									<tr>
										<td class=\"asFoCount\"><nobr>{$allUsers}</nobr></td><td class=\"asCSilverLight asFoText2\"><nobr>إجمالي أعضاء مسجلة عندنا</nobr></td>
									</tr>
									<tr>
										<td class=\"asFoCount\"><nobr>{$allTopics}</nobr></td><td class=\"asCSilverLight asFoText2\"><nobr>إجمالي مواضيع في المنتدى</nobr></td>
									</tr>
									<tr>
										<td class=\"asFoCount\"><nobr>{$allPosts}</nobr></td><td class=\"asCSilverLight asFoText2\"><nobr>إجمالي ردود في المنتدى</nobr></td>
									</tr>
								</table>
								</td>
								<td width=\"2%\"><nobr>&nbsp;<img src=\"styles/globals/footersep.png\" border=\"0\"></nobr></td>
								<td width=\"40%\">
								<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
									<tr>
										<td width=\"2%\"><nobr><img src=\"images/icons/facebook.gif\" border=\"0\">&nbsp;</nobr></td>
										<td class=\"asACSilverLight asFoText2 asAFoText2\"><a class=\"dm-middle\" href=\"".( facebook_account != '' ? facebook_account : '#' )."\" target=\"_blank\"><nobr>تابعونا على Facebook</nobr></a></td>
									</tr>
									<tr>
										<td width=\"2%\"><nobr><img src=\"images/icons/twitter.gif\" border=\"0\">&nbsp;</nobr></td>
										<td class=\"asACSilverLight asFoText2 asAFoText2\"><a class=\"dm-middle\" href=\"".( twitter_account != '' ? twitter_account : '#' )."\" target=\"_blank\"><nobr>تابعونا على Twitter</nobr></a></td>
									</tr>";
									if((_df_script=='forums'||_df_script=='topics')&&$this->DF->catch['thisForum']>0&&!empty($this->DF->catch['forumSubject'])){
										$fid="?f={$this->DF->catch['thisForum']}";
										$fsubject=" ({$this->DF->catch['forumSubject']})";
									}
									$code.="
									<tr>
										<td width=\"2%\"><nobr><img src=\"images/icons/rss.gif\" border=\"0\">&nbsp;</nobr></td>
										<td class=\"asACSilverLight asFoText2 asAFoText2\"><a class=\"dm-middle\" href=\"rss.php{$fid}\" target=\"_blank\"><nobr>تغذية RSS{$fsubject}</nobr></a></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
					</tr>
				</table>".(ulv>1 ? "{$this->moderatorsTools()}" :"")."";
				?>
				<script type="text/javascript">
				$(function(){
					$.ajax({
						type: 'POST',
						url: 'ajax.php?x='+Math.random(),
						data: 'type=set_data_to_database&method=setUserActivity_online&f=<?=$this->DF->catch['thisForum']?>&mod=<?=( ($this->DF->catch['isModerator'] === true) ? '1' : '0' )?>'
					});
					var afterLoadOperations = function(){
						$.ajax({
							type: 'POST',
							url: 'ajax.php?x='+Math.random(),
							data: 'type=afterLoadOperations'
						});
					};
					setTimeout(afterLoadOperations, 1000);
				});
				</script>
				<?php
			}
			$code = str_replace(array("\t","\r","\n"), "", $code);
			$footer.=(!empty($code) ? "\n{$code}" : "")."
			</body>
			</html>";
			echo str_replace("\t" , "", $footer);
		}
 		if( _df_script != 'ajax_admin' && _df_script != 'ajax' ){
			if( $this->DF->catch['isModerator'] === true ){
				$this->DFOutput->setModActivity('online', $this->DF->catch['thisForum'], true);
			}
			if( ulv > 0 && ulv < 4 ){
				$this->DFOutput->setUserActivity('online', $this->DF->catch['thisForum']);
			}
		}
		$this->mysql->close();
	}
	function moderatorsTools(){
		$mtRows="";
		if(ulv==4){
			$com=$this->DFOutput->count("complain WHERE status = 2 AND adminread = 0");
			if($com>0){
				$comUrl="&type=global&app=send";
				$comCount=" <span class=\"asC2\">({$com})</span>";
			}
		}
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=complain{$comUrl}\"><nobr>شكاوي{$comCount}</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=moderate\"><nobr>إشرافك</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=mons&type=global&scope=all\"><nobr>عقوبات</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=medals&type=distribute\"><nobr>الأوسمة</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=titles&type=lists\"><nobr>الأوصاف</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=surveys\"><nobr>استفتاءات</nobr></a></td>";
		$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=useractivity\"><nobr>نشاط أعضاء</nobr></a></td>";
		if(ulv>2) $mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=modactivity\"><nobr>نشاط مشرفين</nobr></a></td>";
		if($this->DF->catch['isModerator']&&(_df_script=='forums'||_df_script=='topics')){
			$f=$this->DF->catch['thisForum'];
			$forumPM=$this->DFOutput->count("pm WHERE author = '-{$f}' AND pmout = 0 AND pmread = 0 AND status = 1 AND pmlist = 0");
			$forumPost=$this->DFOutput->count("post WHERE forumid = '{$f}' AND moderate = 1 ");
			$pmUrl="pm.php?mail=".($forumPM>0 ? 'new' : 'in')."&f=-{$f}";
			$pmCount=($forumPM>0 ? " <span class=\"asC2\">({$forumPM})</span>" : "");
			$PostCount=($forumPost>0 ? " <span class=\"asC2\">({$forumPost})</span>" : "");
			$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"{$pmUrl}\"><nobr>بريد المنتدى{$pmCount}</nobr></a></td>";
			$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=medals&type=upphotos&f={$f}\"><nobr>ملفات الأوسمة</nobr></a></td>";
			$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"svc.php?svc=forumbrowse&f={$f}\"><nobr>احصائيات التصفح</nobr></a></td>";
			$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"wait.php?f={$f}\"><nobr>ردود تنتظر الموافقة{$PostCount}</nobr></a></td>";
		}
		if(ulv > 1 || ulv > 0 && udochat == 1){
			$chatOnlineCount = intval($this->DFOutput->count("useronline WHERE url LIKE '%chat%'", "ip"));
			$mtRows.="<td class=\"asTitle asAC1 asAS12\"><a href=\"dochat.php\"><nobr>في نقاش حي حالياً <span class=\"asC2\">({$chatOnlineCount})</span></nobr></a></td>";
		}
		$code = "
		<div id=\"MTContent\" style=\"display:none\"><table cellpadding=\"0\" cellspacing=\"2\"><tr>{$mtRows}</tr></table></div>
		<script type=\"text/javascript\">
		$(function(){
			$(document.body).append('<div id=\"MTPlace\" class=\"asTopHeader\" style=\"bottom:0;right:20px;position:fixed;z-index:1000;\">'+$('#MTContent').html()+'</div>');
		});
		</script>";
		return $code;
	}
	function adminHeader(){
		$rs=$this->mysql->queryRow("SELECT id,userid FROM ".prefix."cpvisit ORDER BY id DESC LIMIT 1", __FILE__, __LINE__);
		if($rs[1]==uid){
			$this->mysql->update("cpvisit SET date = ".time." WHERE id = ".((int)$rs[0])."", __FILE__, __LINE__);
		}
		else{
			$this->mysql->insert("cpvisit (userid,date) VALUES (".uid.",".time.")", __FILE__, __LINE__);
		}
		$head="
		<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admincp.css".x."\" />";
		$this->header(false,$head);
		$menus=array(
			'index'=>array('الصفحة الرئيسية','admincp.php'),
			'setting'=>array('الخيارات','admincp.php?type=setting'),
			'stats'=>array('الاحصائيات','admincp.php?type=stats'),
			'templates'=>array('القوالب','admincp.php?type=templates'),
			'groupmessages'=>array('رسائل جماعية','admincp.php?type=groupmessages'),
			'forums'=>array('المنتديات','admincp.php?type=forums'),
			'users'=>array('العضويات','admincp.php?type=users'),
			'ip'=>array('خيارات IP','admincp.php?type=ip'),
			'hacker'=>array('محاولات اختراق','admincp.php?type=hacker'),
			'block'=>array('المنع','admincp.php?type=block'),
			'chat'=>array('نقاش حي','admincp.php?type=chat')
		);
		$subMenus=array(
			'setting'=>array(
				'mainsetting'=>array('خيارات أساسية','admincp.php?type=setting&method=mainsetting'),
				'othersetting'=>array('خيارات إضافية','admincp.php?type=setting&method=othersetting'),
				'usersetting'=>array('خيارات العضوية','admincp.php?type=setting&method=usersetting')
			),
			'stats'=>array(
				'userstats'=>array('إحصائيات الأعضاء','admin_stats.php')
			),
			'templates'=>array(
				'edit'=>array('إدارة قوالب','admincp.php?type=templates&method=edit'),
				'add'=>array('إضافة قالب جديد','admincp.php?type=templates&method=add')
			),
			'groupmessages'=>array(
				'sendemailtousers'=>array('إرسال رسالة جماعية للأعضاء عبر بريد الالكتروني','admincp.php?type=groupmessages&method=sendemailtousers'),
				'sendpmtousers'=>array('إرسال رسالة جماعية للأعضاء عبر بريد رسائل خاصة','editor.php?type=sendpmtousers&src='.urlencode(self))
			),
			'forums'=>array(
				'sortcatforums'=>array('ترتيب فئات ومنتديات','admincp.php?type=forums&method=sortcatforums'),
				'monthlysort'=>array('ترتيب شهري للمنتديات','admincp.php?type=forums&method=monthlysort'),
				'addnewcat'=>array('إضافة فئة جديدة','catadmin.php?type=add')
			),
			'users'=>array(
				'allowusers'=>array('عضويات تمت موافقة عليها','admincp.php?type=users&method=allowusers'),
				'waitusers'=>array('عضويات المنتظرة','admincp.php?type=users&method=waitusers'),
				'refuseusers'=>array('عضويات تمت رقضها','admincp.php?type=users&method=refuseusers'),
				'activeusers'=>array('عضويات غير مفعلة','admincp.php?type=users&method=activeusers'),
				'changenamewait'=>array('أسماء المنتظرة','admincp.php?type=users&method=changenamewait')
			),
			'ip'=>array(
				'checkip'=>array('مطابقة IP','admincp.php?type=ip&method=checkip'),
				'blockip'=>array('حجب الـ IP','admincp.php?type=ip&method=blockip')
			),
			'hacker'=>array(
				'hackersetform'=>array('محاولات إملاء فورم بطريق غير شرعي','admincp.php?type=hacker&method=hackersetform'),
				'hackerseturl'=>array('إدخالات كلمات ممنوعة في الروابط','admincp.php?type=hacker&method=hackerseturl')
			),
			'block'=>array(
				'convertwords'=>array('استبدال كلمات','admincp.php?type=block&method=convertwords'),
				'blockwords'=>array('منع كلمات','admincp.php?type=block&method=blockwords')
			),
		);
		$this->adminType=(type=='' ? 'index' : type);
		if(method==''){
			if($subMenus["{$this->adminType}"]){
				$getkey=array_keys($subMenus["{$this->adminType}"]);
				$this->adminMethod=$getkey[0];
			}
			else{
				$this->adminMethod='mainoptions';
			}
		}
		else{
			$this->adminMethod=method;
		}
		$rs=$this->mysql->queryAssoc("SELECT cv.userid,cv.date,u.name
		FROM ".prefix."cpvisit AS cv
		LEFT JOIN ".prefix."user AS u ON(u.id = cv.userid)
		ORDER BY cv.id DESC LIMIT 1,1", __FILE__, __LINE__);
		echo"
		<div class=\"admincp\">
		<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
			<tr>
				<td class=\"headerbar\">";
			if( cplogin ){
				echo"
				<span><nobr>مرحباً بك {$this->userNormalLink(uid,uname,'#69cbff')} من جديد&nbsp;&nbsp;|&nbsp;&nbsp; آخر زيارة في لوحة التحكم بواسطة {$this->userNormalLink($rs['userid'],$rs['name'],'#69cbff')} بتاريخ ({$this->DF->date($rs['date'])})</nobr></span>
				<div><nobr>{$this->goToForum(true,true,';background-color:#000000;color:#ffffff')}&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php\">الصفحة الرئيسية للمنتدى</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?type=adminlogout\">خروج من لوحة التحكم</a></nobr></div>";
			}
			else{
				echo"
				<div><nobr><a href=\"index.php\">الصفحة الرئيسية للمنتدى</a></nobr></div>";
			}
				echo"
				</td>
			</tr>
			<tr>
				<td ".(cplogin ? "valign=\"bottom\"" : "")." style=\"height:94px;background-image:url(images/admin/header_back.jpg);background-repeat:repeat-x\"><font color=\"white\" size=\"4\"><b>&nbsp;&nbsp;".forum_title." - لوحة التحكم".(shut_down_status==1 ? "<nobr>&nbsp;<font size=\"2\" color=\"#f4e568\">(المنتدى مقفول حاليا)</font></nobr>" : "")."</b></font>";
			if(cplogin){
				echo"<br><br>
				<table width=\"100%\" cellSpacing=\"0\" cellPadding=\"0\">
					<tr>
						<td style=\"width:20px\">&nbsp;</td>";
					$menu_rows = array();
					foreach($menus as $key => $row){
						$menu_rows[] = "
						<td class=\"menubar ".($this->adminType == $key ? 'white' : 'blue')."-row\"><a href=\"{$row[1]}\"><nobr>{$row[0]}</nobr></a></td>";
					}
						echo implode("<td style=\"width:12px\">&nbsp;</td>", $menu_rows);
						echo"
						<td style=\"width:90%\">&nbsp;</td>
					</tr>
				</table>";
			}
				echo"
				</td>
			</tr>";
		if(cplogin){
			echo"
			<tr>
				<td class=\"submenubar\">";
			if($subMenus["{$this->adminType}"]){
				echo"
				<table cellSpacing=\"1\" cellPadding=\"4\" border=\"0\">
					<tr>";
					foreach($subMenus["{$this->adminType}"] as $key=>$cell){
						echo"
						<td class=\"".($key==$this->adminMethod ? 'over' : 'out')."\"><a href=\"{$cell[1]}\"><nobr>{$cell[0]}</nobr></a></td>";
					}
					echo"
					</tr>
				</table>";
			}
				echo"
				</td>
			</tr>";
		}
			echo"
			<tr>
				<td class=\"body\" align=\"center\">";
	}
	function adminFooter(){
				echo"
				</td>
			</tr>
		</table>
		</div>";
		$this->footer(true,true);
	}
	function adminBox($title, $text, $width = 60, $padding = 12){
		echo"
		<table class=\"box-panel\"".($width > 0 ? " width=\"{$width}%\"" : "")." cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td class=\"title\">{$title}</td>
			</tr>
			<tr>
				<td class=\"text\" style=\"padding:".($padding > 0 ? "{$padding}px" : "0").";\">{$text}</td>
			</tr>
		</table>";
	}
	function adminToolsBox($pic_name,$subject,$ret=true){
		$code="
		<div class=\"tools\"><a href=\"admincp.php?type={$pic_name}\"><img src=\"images/admin/{$pic_name}.gif\" onerror=\"this.src='{$this->DFImage->i['noimage']}';\" width=\"60\" height=\"60\"><br><br>{$subject}</a></div>";
		if($ret){
			return $code;
		}
		else{
			echo $code;
		}
	}
	function forumModerators($f=f,$limit=3){
		global $mysql, $Template;
		$sql=$mysql->query("SELECT m.userid,u.name FROM ".prefix."moderator AS m INNER JOIN ".prefix."user AS u ON(u.id = m.userid) WHERE m.forumid = $f", __FILE__, __LINE__);
		$text="";
		$x=0;
		while($rs=$mysql->fetchRow($sql)){
			$text.=($x==1||$x==2?"&nbsp;+&nbsp;":"").$Template->userNormalLink($rs[0],$rs[1]);
			$x++;
			if($x==$limit){
				$text.="<br>";
				$x=0;
			}
		}
		if(!empty($text)) $text="<nobr>$text</nobr>";
		return $text;
	}
	function goToForum($ret = false, $private = false, $style = ''){
		$text = "";
		if(!$private){
			$text.="
			<td class=\"asText asCenter asTop\"><nobr>إذهب الى منتدى:</nobr>";
		}
		$class=(empty($style) ? "class=\"asGoTo asS12\"" : "");
		$text.="
		<select {$class} style=\"width:170px{$style}\" id=\"goToForumLsit\" onChange=\"if(this.options[this.selectedIndex].value>0){window.location='forums.php?f='+this.options[this.selectedIndex].value;}else{this.selectedIndex=0;}\">
			<option value=\"0\">-- إختار منتدى من القائمة --</option>";

		$checkSqlField="";
		$checkSqlTable="";
		if(ulv==4){
			$checkSqlField="
				,IF(ISNULL(c.id),0,1) AS allowcat
				,IF(ISNULL(f.id),0,1) AS allowforum
			";
		}
		elseif(ulv==3){
			$checkSqlField.="
				,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowcat
				,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id) OR c.monitor = ".uid.",1,0) AS allowforum
			";
			$checkSqlTable.="
				LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
				LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			";
		}
		elseif(ulv==2){
			$checkSqlField.="
				,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowcat
				,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id) OR NOT ISNULL(m.id),1,0) AS allowforum
			";
			$checkSqlTable.="
				LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")
				LEFT JOIN ".prefix."moderator AS m ON(m.forumid = f.id AND m.userid = ".uid.")
			";
		}
		elseif(ulv==1){
			$checkSqlField.="
				,IF(c.hidden = 0 AND ".ulv." >= c.level OR NOT ISNULL(fu.id),1,0) AS allowcat
				,IF(f.hidden = 0 AND ".ulv." >= f.level OR NOT ISNULL(fu.id),1,0) AS allowforum
			";
			$checkSqlTable.="LEFT JOIN ".prefix."forumusers AS fu ON(fu.forumid = f.id AND fu.userid = ".uid.")";
		}
		elseif(ulv==0){
			$checkSqlField.="
				,IF(c.hidden = 0 AND c.level = 0,1,0) AS allowcat
				,IF(f.hidden = 0 AND f.level = 0,1,0) AS allowforum
			";
		}
		$sql=$this->mysql->query("SELECT c.id AS cid, f.id AS fid, f.subject $checkSqlField
		FROM ".prefix."category AS c
		LEFT JOIN ".prefix."forum AS f ON(f.catid = c.id)
		$checkSqlTable
		GROUP BY f.id, c.id ORDER BY c.sort, f.sort ASC", __FILE__, __LINE__);
 		$lastcatid=0;
		while($rs=$this->mysql->fetchAssoc($sql)){
			if($rs['cid']!=$lastcatid&&$rs['allowcat']==1){
				$text.="
				<option value=\"0\">------------------------------------------</option>";
				$lastcatid=$rs['cid'];
			}
			if($rs['allowforum']==1){
				$text.="
				<option value=\"{$rs['fid']}\">{$rs['subject']}</option>";
				$this->forumsList[$rs['fid']]=$rs['subject'];
			}
		}
		$text.="
		</select>";
		if(!$private){
			$text.="
			</td>";
		}
		if($ret){
			return $text;
		}
		else{
			echo $text;
		}
	}
	function msg($msg,$url='',$text='',$othor='',$sec=3){
		$url=(!empty($url)?$url:referer);
		$text=(!empty($text)?$text:'إضغط هنا للرجوع للصفحة الأصلية');
		echo"<br>
		<table width=\"60%\" cellpadding=\"4\" cellspacing=\"0\" align=\"center\">
			<tr>
				<td class=\"asNormal asCenter\"><br>$msg<br><br>
					<script type=\"text/javascript\">
					var defUrl='$url';
					function gotourl(url){
						clearTimeout(goToUrl);
						document.location=(url?url:defUrl);
					}
					var goToUrl=setTimeout(\"gotourl()\",{$sec}000);
					</script>
					<a href=\"javascript:gotourl()\">-- $text --</a><br>";
					if(is_array($othor)){
						for($x=0;$x<count($othor);$x+=2){
							echo"
							<br><a href=\"javascript:gotourl('$othor[$x]')\">-- {$othor[$x+1]} --</a><br>";
						}
					}
					echo"
					<br>
				</td>
			</tr>
		</table><br>";
		$this->footer();
		exit();
	}
	function errMsg($msg, $sec = 1, $ret = true, $content = true, $title = ''){
		if(empty($title)) $title='رسالة إدارية';
		echo"<br>
		<center>
		<table width=\"60%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
			<tr>
				<td class=\"asHeader\">{$title}</td>
			</tr>
			<tr>
				<td class=\"asNormal asCenter\"><font color=\"red\"><br>$msg<br><br></font>";
				if($ret){
					echo"<a href=\"javascript:history.go(-$sec)\">-- انقر هنا للرجوع --</a><br><br>";
				}
				echo"</td>
			</tr>
		</table>
		</center><br>";
		$this->footer($content);
		exit();
	}
	function myMsg($text,$id='myMsg'){
		echo"
		<div id=\"$id\"><br>
		<table class=\"border\" width=\"60%\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\" border=\"0\">
			<tr>
				<td class=\"normalCenter\"><font size=\"2\"><b>$text</b></font></td>
			</tr>
		</table>
		</div>";
	}
	function msgBox($text,$color,$mp=10,$width=0,$logo=false,$ret=true,$back=false){
		global $DFImage;
		$colorsCode=array(
			'gray'=>array('#666666','#ffffff','loading'),
			'yellow'=>array('#666600','#fffaca','alert'),
			'blue'=>array('#000066','#dce3fd','info'),
			'green'=>array('#116600','#d5ffcd','succeed'),
			'red'=>array('#660000','#ffced1','error')
		);
		$backMsg=($back ? "<br><br><div align=\"center\"><a href=\"javascript:history.go(-1)\">-- انقر هنا للرجوع --</a></div>" : "");
		if($logo){
			if($color=='gray'){
				$textCode="
				<td dir=\"rtl\" style=\"padding:{$mp}px;background-color:{$colorsCode[$color][1]}\">
				<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr>
						<td align=\"center\"><img src=\"{$DFImage->i[$colorsCode[$color][2]]}\" border=\"0\"></td>
					</tr>
					<tr>
						<td class=\"asCenter asS12\" style=\"padding-bottom:6px;color:{$colorsCode[$color][0]}\">$text{$backMsg}</td>
					</tr>
				</table>
				</td>";
			}
			else{
				$textCode="
				<td dir=\"rtl\" style=\"padding:{$mp}px;background-color:{$colorsCode[$color][1]}\">
				<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr>
						<td><img src=\"{$DFImage->i[$colorsCode[$color][2]]}\" style=\"margin-left:".($mp+2)."px\" hspace=\"4\" border=\"0\"></td>
						<td class=\"asS12\" style=\"color:{$colorsCode[$color][0]}\">$text{$backMsg}</td>
					</tr>
				</table>
				</td>";
			}
		}
		else{
			$textCode="<td dir=\"rtl\" class=\"asS12\" style=\"padding:{$mp}px;background-color:{$colorsCode[$color][1]};color:{$colorsCode[$color][0]}\">$text{$backMsg}</td>";
		}
		$code="
		<center>
		<table dir=\"ltr\"".(is_int($width)&&$width>0 ? " width=\"{$width}%\"" : (strlen($width)>0 ? " width=\"$width\"" : ""))." cellpadding=\"0\" cellspacing=\"0\" style=\"margin:{$mp}px\" border=\"0\">
			<tr>
				<td style=\"background:url(images/boxes/{$color}_top_left.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>
				<td style=\"background:url(images/boxes/{$color}_top.gif) repeat-x 0px 0px;height:5px;\"></td>
				<td style=\"background:url(images/boxes/{$color}_top_right.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>
			</tr>
			<tr>
				<td style=\"background:url(images/boxes/{$color}_left.gif) repeat-y 0px 0px;width:5px;\"></td>
				$textCode
				<td style=\"background:url(images/boxes/{$color}_right.gif) repeat-y 0px 0px;width:5px;\"></td>
			</tr>
			<tr>
				<td style=\"background:url(images/boxes/{$color}_down_left.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>
				<td style=\"background:url(images/boxes/{$color}_down.gif) repeat-x 0px 0px;height:5px;\"></td>
				<td style=\"background:url(images/boxes/{$color}_down_right.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>
			</tr>
		</table>
		</center>";
		if($ret) return $code;
		else echo $code;
	}
	function input($size=200, $att=array(), $ret=true){
		$input = '';
		if(!in_array('type', array_keys($att))){
			$att['type'] = 'text';
		}
		foreach($att as $tag => $value){
			$input .= " {$tag}=\"{$value}\"";
		}
		$code = "<input{$input} class=\"input\" style=\"width:{$size}px;\">";
		if($ret){
			return $code;
		}
		else{
			echo $code;
		}
	}
	function fieldBox($text, $width = 0){
		$code = "<div class=\"fieldBox\"".($width > 0 ? " style=\"width:{$width}px;\"" : "").">{$text}</div>";
		return $code;
	}
	function basicPaging($sql,$id='id',$ret=false,$numPages=num_pages,$count=-1,$jsFunc='basic'){
		$count=($count>=0 ? $count : $this->DFOutput->count($sql,$id));
		$pages=ceil($count/$numPages);
		$pages=($pages==0?1:$pages);
		if($pages>1){
			$funcName=($jsFunc=='basic' ? "DF.basicPagingGo(this)" : $jsFunc);
			$text="
			<td class=\"asText asCenter asTop\"><nobr>الصفحة:</nobr>
			<select class=\"asGoTo asS12\" onChange=\"$funcName\">";
			for($x=1;$x<=$pages;$x++){
				$text.="
				<option value=\"$x\" {$this->DF->choose(pg,$x,'s')}>$x&nbsp;من&nbsp;$pages</option>";
			}
			$text.="
			</select>
			</td>";
		}
		if($ret){
			return $text;
		}
		else{
			echo $text;
		}
	}
 	function paging($sql,$link,$id='id',$numPage=0,$count=0){
		$count=($count>0 ? $count : $this->DFOutput->count($sql,$id));
		$numPage=($numPage==0 ? num_pages : $numPage);
		$pages=ceil($count/$numPage);
		$pages=($pages==0?1:$pages);
		$pg=(pg>0?pg:1);
		if($pages>1){
			if($pg>1){
				$first=" href=\"{$link}pg=1\" title=\"صفحة الاولى\"";
				$prev=" href=\"{$link}pg=".($pg-1)."\" title=\"صفحة السابقة\"";
			}
			else{
				$firstDis="Dis";
			}
			$code="<br><table cellPadding=\"0\" cellSpacing=\"2\" border=\"0\"><tr>
			<td valign=\"top\"><a$first><div class=\"pgFirst$firstDis\"></div></a></td>
			<td valign=\"top\"><a$prev><div class=\"pgPrev$firstDis\"></div></a></td>";
			if($pg>1){
				$equal=$pg-($pg==2?1:2);
				for($x=$equal;$x<$pg;$x++){
					$code.="<td align=\"center\" valign=\"top\"><a href=\"{$link}pg=$x\"><div valign=\"middle\" class=\"pgOut\">$x</div></a></td>";
				}
			}
			$code.="<td align=\"center\" valign=\"top\"><a title=\"صفحة $pg من $pages صفحات\"><div class=\"pgIn\">$pg</div></a></td>";
			if($pg<$pages){
				$equal=$pg+($pg==($pages-1)?1:2);
				for($x=$pg+1;$x<=$equal;$x++){
					$code.="<td align=\"center\" valign=\"top\"><a href=\"{$link}pg=$x\"><div class=\"pgOut\">$x</div></a></td>";
				}
				$next=" href=\"{$link}pg=".($pg+1)."\" title=\"صفحة التالية\"";
				$last=" href=\"{$link}pg=$pages\" title=\"صفحة الأخيرة\"";
			}
			else{
				$lastDis="Dis";
			}
			$code.="
			<td valign=\"top\"><a$next><div class=\"pgNext$lastDis\"></div></a></td>
			<td valign=\"top\"><a$last><div class=\"pgLast$lastDis\"></div></a></td>
			</tr></table><br>";
		}
		return $code;
	}
	function topicPaging($t,$count){
		global $DFImage;
		$pages=ceil($count/post_num_page);
		$pages=($pages>0?$pages:1);
		if($pages>1){
			$text="
			<table cellpadding=\"0\" cellspacing=\"3\" border=\"0\">
				<tr>";
				$count=0;
				for($x=1;$x<=$pages;$x++){
					$text.="
					<td class=\"asTextLink2 asCenter\"><a href=\"topics.php?t=$t&pg=$x\">$x</a></td>";
					$count++;
					if($count==17){
						$text.="</tr><tr>";
						$count=0;
					}
				}
				$text.="
				</tr>
			</table>";
		}
		return $text;
	}
	function topicsOrderBy(){
		echo"
		<form id=\"TOBFrm\" method=\"post\" action=\"".self."\"><input type=\"hidden\" name=\"topicsOrderBy\" value=\"".topics_order_by."\"></form>
		<td class=\"asText asCenter asTop\"><nobr>الترتيب بتاريخ:</nobr>
		<select class=\"asGoTo asS12\" style=\"width:90px\" onChange=\"\$I('#TOBFrm').topicsOrderBy.value=this.options[this.selectedIndex].value;\$I('#TOBFrm').submit();\">
			<option value=\"posts\" {$this->DF->choose(topics_order_by,'posts','s')}>آخر مشاركة</option>
			<option value=\"topics\" {$this->DF->choose(topics_order_by,'topics','s')}>موضوع</option>
		</select>
		</td>";
	}
	function refreshPage(){
		echo"
		<form id=\"refFrm\" method=\"post\" action=\"".self."\"><input type=\"hidden\" name=\"refreshPage\" value=\"".refresh_page."\"></form>
		<td class=\"asText asCenter asTop\"><nobr>تحديث الصفحة:</nobr>
		<select class=\"asGoTo asS12\" style=\"width:90px\" onChange=\"\$I('#refFrm').refreshPage.value=this.options[this.selectedIndex].value;\$I('#refFrm').submit();\">
			<option value=\"00\" {$this->DF->choose(refresh_page,00,'s')}>لا تحديث</option>
			<option value=\"1\" {$this->DF->choose(refresh_page,1,'s')}>كل دقيقة</option>
			<option value=\"5\" {$this->DF->choose(refresh_page,5,'s')}>كل 5 دقائق</option>
			<option value=\"10\" {$this->DF->choose(refresh_page,10,'s')}>كل 10 دقائق</option>
			<option value=\"15\" {$this->DF->choose(refresh_page,15,'s')}>كل 15 دقيقة</option>
		</select>
		</td>
		<script type=\"text/javascript\">
			var frm=\$I('#refFrm'),refTime=parseInt(frm.refreshPage.value);
			if(refTime>0){
				setInterval('frm.submit()',60000*refTime);
			}
		</script>";
	}
	function setUserStyle($code){
		if($this->DF->indexOf($code, 'asUserStyle') == -1){
			$css = $this->getUserStyle();
			if(!empty($css)){
				$code = "<div class=\"asUserStyle\" style=\"{$css}\">{$code}</div>";
			}
		}
		return $code;
	}
	function getUserStyle($array = false){
		$weight_arr = array('bold', 'normal');
		$align_arr = array('center', 'left', 'right');
		$style = $this->mysql->get("userflag", "style", uid);
		$style = unserialize($style);
		$weight = trim(strtolower($style['weight']));
		$align = trim(strtolower($style['align']));
		$family = trim($style['family']);
		$size = intval($style['size']);
		$color = trim($style['color']);
		$css_arr = array(
			'weight' => '',
			'align' => '',
			'family' => '',
			'size' => '',
			'color' => ''
		);
		$css = '';
		if(in_array($weight, $weight_arr)){
			$css .= "font-weight:{$weight};";
			$css_arr['weight'] = $weight;
		}
		if(in_array($align, $align_arr)){
			$css .= "text-align:{$align};";
			$css_arr['align'] = $align;
		}
		if(!empty($family)){
			$css .= "font-family:{$family};";
			$css_arr['family'] = $family;
		}
		if($size > 0){
			$css .= "font-size:{$size}px;";
			$css_arr['size'] = "{$size}px";
		}
		if(!empty($color)){
			$css .= "color:{$color};";
			$css_arr['color'] = $color;
		}
		return ($array) ? $css_arr : $css;
	}
	function headerMenuRows($code,$seprator=true){
		echo"
		<td class=\"headerMenuCells\" align=\"center\"><nobr>$code</nobr></td>";
		if($seprator){
			echo"
			<td><img src=\"styles/".choosed_style."/hd2.gif\" width=\"2\" height=\"80\" border=\"0\"></td>";
		}
	}
	function resizeImage($src,$type,$newsrc,$newWidth,$newHeight){
		if(preg_match("/jpg|jpeg/",$type)){
			$imgSrc=imagecreatefromjpeg($src);
		}
		if(preg_match("/png/",$type)){
			$imgSrc=imagecreatefrompng($src);
		}
		if(preg_match("/gif/",$type)){
			$imgSrc=imagecreatefromgif($src);
		}
		$oldX=imageSX($imgSrc);
		$oldY=imageSY($imgSrc);
		if ($oldX>$oldY){
			$thumbWidth=$newWidth;
			$thumbHeight=$oldY*($newHeight/$oldX);
		}
		elseif($oldX<$oldY){
			$thumbWidth=$oldX*($newWidth/$oldY);
			$thumbHeight=$newHeight;
		}
		elseif($oldX==$oldY){
			$thumbWidth=$newWidth;
			$thumbHeight=$newHeight;
		}
		$imgNew=ImageCreateTrueColor($thumbWidth,$thumbHeight);
		imagecopyresampled($imgNew,$imgSrc,0,0,0,0,$thumbWidth,$thumbHeight,$oldX,$oldY);
		if(preg_match("/jpg|jpeg/",$type)){
			imagejpeg($imgNew,$newsrc);
		}
		if(preg_match("/png/",$type)){
			imagepng($imgNew,$newsrc);
		}
		if(preg_match("/gif/",$type)){
			imagegif($imgNew,$newsrc);
		}
		imagedestroy($imgNew);
		imagedestroy($imgSrc);
	}
	function ltr($text,$style=''){
		return "<span dir=\"ltr\"".(!empty($style) ? " style=\"{$style}\"" : "").">{$text}</span>";
	}
	function checkHackerTry($msg){
		if(!$this->DF->isOurSite()){
			$this->DFOutput->setHackerDetails($msg);
			$Template->errMsg("لا يمكنك من حفظ المعلومات بهذ الطريقة<br>لأن هذه الطريقة تحسب محاولة اختراق ولهذا السبب تم حفظ معلوماتك الشخصية عندنا.<br><br>تحذير هام: فإذا ان تقوم بتكرار هذه العملية سنقوم بإجراءات اللازمة أمامك.");
			exit();
		}
	}
	function sendpm($author,$from,$to,$subject,$message,$sender=0,$out=0){
		$this->mysql->insert("pm (author,sender,pmfrom,pmto,pmout,pmread,subject,date) VALUES (
			'$author','$sender','$from','$to','$out','$out','$subject','".time."'
		)", __FILE__, __LINE__);

		$pm=$this->mysql->queryRow("SELECT id FROM ".prefix."pm WHERE author = $author AND pmfrom = $from AND date = ".time." ORDER BY id DESC", __FILE__, __LINE__);

		$this->mysql->insert("pmmessage (id,message) VALUES (
			'$pm[0]','$message'
		)", __FILE__, __LINE__);
	}
	function userColorLink($uid, $user = array(), $catch = true, $title = '', $notlink = false){
		if($uid > 0){
			if($catch and isset($this->DF->catch['userColorLink'][$uid])){
				return $this->DF->catch['userColorLink'][$uid];
			}
			else{
				if(count($user) == 0){
					$user = $this->mysql->queryRow("SELECT name, status, level, submonitor FROM ".prefix."user WHERE id = {$uid}", __FILE__, __LINE__);
				}
				$name = $user[0];
				$status = intval($user[1]);
				$level = intval($user[2]);
				$submonitor = intval($user[3]);
				$colors = unserialize(user_name_color);
				$user_name = '';
				if($status == 1){
					if($level == 2){
						$color = $colors[2][$submonitor];
					}
					else{
						$color = $colors[$level][1];
					}
				}
				else{
					$color = $colors[1][$status];
				}
				$user_name = (!empty($color)) ? "<font color=\"{$color}\">{$name}</font>" : $name;
				if(!$notlink){
					$title = (!empty($title)) ? " title=\"{$title}\"" : "";
					$setId = (ulv > 0) ? " id=\"u{$uid}\"" : "";
					$user_name = "<a{$setId} href=\"profile.php?u={$uid}\"{$title}>{$user_name}</a>";
				}
				return $user_name;
			}
		}
	}	
	function userNormalLink($uid, $uname = '', $color = ''){
		if(isset($this->DF->catch['userNormalLink'][$uid])){
			$name = $this->DF->catch['userNormalLink'][$uid];
		}
		else{
			$name = (!empty($uname)) ? $uname : $this->mysql->get('user', 'name', $uid);
		}
		if(!empty($color)){
			$name = "<font color=\"{$color}\">{$name}</font>";
		}
		$setId = (ulv > 0) ? " id=\"u{$uid}\"" : "";
		$link = "<a{$setId} href=\"profile.php?u={$uid}\">{$name}</a>";
		return $link;
	}
	function forumLink($fid,$subject='',$color='',$class='',$get=''){
		if(empty($subject)){
			$subject=$this->mysql->get('forum','subject',$fid);
		}
		if(!empty($color)){
			$subject="<font color=\"$color\">$subject</font>";
		}
		$class=(!empty($class) ? " class=\"$class\"" : "");
		$setId=(ulv>0 ? " id=\"f$fid\"" : "");
		$link="<a{$setId}{$class} href=\"forums.php?f=$fid$get\">$subject</a>";
		return $link;
	}
	function topicLink($tid,$subject='',$color='',$class='',$get=''){
		if(empty($subject)){
			$subject=$this->mysql->get('topic','subject',$tid);
		}
		if(!empty($color)){
			$subject="<font color=\"$color\">$subject</font>";
		}
		$class=(!empty($class) ? " class=\"$class\"" : "");
		$setId=(ulv>0 ? " id=\"t$tid\"" : "");
		$link="<a{$setId}{$class} href=\"topics.php?t=$tid$get\">$subject</a>";
		return $link;
	}
	function button($value,$events='',$ret=true){
		$button="<input type=\"button\" class=\"button\" {$events} value=\"{$value}\">";
		if($ret) return $button;
		else echo $button;
	}
	function nbsp($text){
		$text=trim($text);
		if(empty($text)) $text="&nbsp;";
		return $text;
	}
	function tooltip($text,$v='top'){
		return "<div class=\"asTooltip".ucfirst(strtolower($v))."\"><div class=\"asTooltipText\">{$text}</div></div>";
	}
	function FBLike($url,$w=100,$h=21){
		if( !empty($url) ){
			if( $this->DF->indexOf( $url, site_address ) ==-1 ){
				$url = "http://".site_address."/{$url}";
			}
			$url=urlencode($url);
			$code="<iframe src=\"http://www.facebook.com/plugins/like.php?href={$url}&amp;layout=button_count&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;width={$w}&amp;height={$h}\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\" style=\"border:none;overflow:hidden;width:{$w}px;height:{$h}px\"></iframe>";
			return $code;
		}
	}
	function imageResize($src,$newSrc,$newWidth,$newHeight=0,$basicSize=false,$x=0,$y=0,$dw=-1,$dh=-1){
		$allowMime=array('gif','png','jpg');
		$getMime=array(
			'image/gif'=>'gif',
			'image/x-png'=>'png',
			'image/png'=>'png',
			'image/pjpeg'=>'jpg',
			'image/jpeg'=>'jpg',
			'image/jpg'=>'jpg'
		);
		$type=getimagesize($src);
		$type=strtolower($getMime["{$type['mime']}"]);
		if(in_array($type,$allowMime)){
			if($type=='jpg'||$type=='jpeg'){
				$imgSrc=@imagecreatefromjpeg($src);
			}
			if($type=='png'){
				$imgSrc=@imagecreatefrompng($src);
			}
			if($type=='gif'){
				$imgSrc=@imagecreatefromgif($src);
			}
			$oldW=imagesx($imgSrc);
			$oldH=imagesy($imgSrc);
			if(!$basicSize){
				if($newHeight>0||$oldW==$oldH){
					$thumbWidth=$newWidth;
					$thumbHeight=$newHeight;
				}
				else{
					if($oldW>$oldH){
						$thumbWidth=$newWidth;
						$thumbHeight=$oldH*($newWidth/$oldW);
					}
					if($oldW<$oldH){
						$thumbWidth=$oldW*($newHeight/$oldH);
						$thumbHeight=$newHeight;
					}
				}
			}
			else{
				$thumbWidth=$oldW;
				$thumbHeight=$oldH;
			}
			if($oldW>800){
				$thumbWidth=800;
				$thumbHeight=$oldH*(800/$oldW);
			}
			if($thumbHeight>600){
				$thumbWidth=$thumbWidth*(600/$thumbHeight);
				$thumbHeight=600;
			}
			$oldW=($dw>=0 ? $dw : $oldW);
			$oldH=($dh>=0 ? $dh : $oldH);
			$imgNew=imagecreatetruecolor($thumbWidth,$thumbHeight);
			imagecopyresampled($imgNew,$imgSrc,0,0,$x,$y,$thumbWidth,$thumbHeight,$oldW,$oldH);
			$newSrc=strtolower($newSrc);
			if($type=='jpg'||$type=='jpeg'){
				imagejpeg($imgNew,$newSrc);
			}
			if($type=='png'){
				imagepng($imgNew,$newSrc);
			}
			if($type=='gif'){
				imagegif($imgNew,$newSrc);
			}
			imagedestroy($imgNew);
			imagedestroy($imgSrc);
		}
	}
	function selectMenu($sm){
		// Function paramaters
		/*
		for example:
		$Template->selectMenu(array(
			'name'=>'name',
			'options'=>array(),
			'default'=>'',
			'width'=>100,
			'input'=>false,
			'single'=>false,
			'html'=>false,
			'onchange'=>'',
			'return'=>false
		));
		*/
		$name=(!empty($sm['name']) ? $sm['name'] : 'sm'.mt_rand(100,999));// the name of the select / default: rand name
		$options=(is_array($sm['options']) ? $sm['options'] : array());// the options in the select / default: blank array
		$input=(isset($sm['input']) ? (bool)$sm['input'] : false);// the select become input and select / default: false
		$html=(isset($sm['html']) ? (bool)$sm['html'] : false);// if use any code of html in the select / default: false
		$single=($input ? true : (isset($sm['single']) ? (bool)$sm['single'] : false));// if options not have indexes or indexes = texts / default: false
		$return=(isset($sm['return']) ? (bool)$sm['return'] : false);//if you want return the code / default: false
		$width=(isset($sm['width']) ? (int)$sm['width'] : 100);// width of select / default: 200 pexil
		$default=$sm['default'];// default option / default: empty
		$onchange=$sm['onchange'];// event in select when select on change / default: empty
		$classes=(!empty($sm['classes']) ? " {$sm['classes']}" : "");// CSS classes / default: empty
		$color=(!empty($sm['color']) ? $sm['color'] : "asNormalB");// CSS classes / default: empty
		// Set option to javascript
		$defValue="";
		$oIndex="";
		$oText="";
		$count=0;
		foreach($options as $index=>$value){
			if($html){
				$value=htmlspecialchars($value);
			}
			if($count==0){
				$sep='';
				$first=(!$single ? $index : $value);
			}
			else $sep=',';
			$sep=($count>0 ? ',' : '');
			if(!$single){
				$oIndex.="{$sep}'{$index}'";
				if($default==$index) $defValue=$index;
			}
			else if($default==$value) $defValue=$value;
			$oText.="{$sep}'{$value}'";
			$count++;
		}
		$oIndex=(!empty($oIndex) ? ",oIndex:new Array({$oIndex})" : "");
		$defValue=($input ? $default : (!empty($defValue) ? $defValue : $first));
		// Create Area For Select And Elements
		?><script type="text/javascript">var sm<?=$name?>={oText:new Array(<?=$oText?>)<?=$oIndex?>,defValue:'<?=$defValue?>',width:<?=$width?>,onChange:"<?=$onchange?>",classes:"<?=$classes?>",isInput:<?=($input ? 'true' : 'false')?>,isSingle:<?=($single ? 'true' : 'false')?>,isHtml:<?=($html ? 'true' : 'false')?>};</script><?php
		if($width>0){
			$tableWidth=" width=\"{$width}\"";
			$tdWidth=";width:".($width-25)."px";
			$divWidth=";width:".($width-31)."px";
			$inpWidth=";width:".($width-28)."px";
		}
		$text="
		<div id=\"smDiv{$name}\" style=\"position:relative;\">
		<table id=\"smTab{$name}\" onclick=\"DF.smOpen('{$name}');\"{$tableWidth} cellpadding=\"0\" cellspacing=\"0\">
			<tr>";
			if($input){
				$inputType="<input type=\"text\" style=\"border-width:0px;padding:1px 3px{$inpWidth}\" id=\"inpValue{$name}\" name=\"{$name}\" value=\"{$defValue}\">";
				$padding="0px";
			}
			else{
				$defText=($single ? $defValue : $options["{$defValue}"]);
				if(empty($defText)) $defText='&nbsp;';
				if($html) $defText=htmlspecialchars_decode($defText);
				$inputType="<nobr><div id=\"defText{$name}\" style=\"overflow-x:hidden{$divWidth}\">{$defText}</div><input type=\"hidden\" id=\"inpValue{$name}\" name=\"{$name}\" value=\"{$defValue}\"></nobr>";
				$padding="1px 3px";
			}
				$text.="
				<td class=\"{$color}{$classes}\" style=\"border:#aaaaaa 1px solid;padding:{$padding}{$tdWidth}\">{$inputType}</td>
				<td class=\"asCenter asNormalB\" style=\"border-width:1px 0px 1px 1px;border-style:solid;border-color:#aaaaaa;width:25px\"><img id=\"smArrow{$name}\" src=\"{$this->DFImage->i['blank']}\" class=\"arrowDown\" border=\"0\"></td>
			</tr>
		</table>
		</div>";
		if($return) return $text;
		else echo $text;
	}
	function loginErrorMsg($err){
		if($err == 'name'){
			$message = "لا يمكنك الدخول لأحد أسباب التالية:-<br><br>1- اسم الدخول الذي دخلت هو خاطيء.<br>2- بريد الالكتروني الذي دخلت هو خاطي.<br><br>ارجوا أن تتأكد من كتابة اسم الدخول أو بريد الالكتروني قبل نقر على زر الدخول.";
			$color = 'red';
		}
		elseif($err == 'pass'){
			$message = "لا يمكنك الدخول, لأن الكلمة السرية التي دخلت هي خاطئة<br>إذا نسيت كلمة السرية, يمكنك إسترجاعها بالنقر فوق رابط الأدناه<br><a href=\"fpass.php\">إسترجاع كلمة السرية</a>";
			$color = 'red';
		}
		elseif($err == 'lock'){
			$message = "لا يمكنك الدخول, لأن هذه العضوية مقفولة من قبل الإدارة";
			$color = 'red';
		}
		elseif($err == 'active'){
			$message = "لا يمكنك الدخول, لأن هذه العضوية غير فعالة, يجب عليك الذهاب الى البريد الالكتروني الذي سجلت عندنا لتفعيل العضوية";
			$color = 'yellow';
		}
		elseif($err == 'wait'){
			$message = "لايمكنك الدخول الى المنتديات بسبب لم يتم مراجعة والموافقة لعضويتك من قبل الإدارة حتى الآن, اذا لم يتم الموافقة لأكتر من 48 ساعة ارسل رسالة لنا عبر هذا الايميل: <a href='mailto:".forum_email."'>".forum_email."</a>";
			$color = 'yellow';
		}
		elseif($err == 'refuse'){
			$message = "لايمكنك الدخول الى المنتديات بسبب تم رفض طلب عضويتك من قبل الإدارة, لأنه غير مطابق لقوانين المنتدى, نتمنى ان تقوم بتسجيل عضوية أخرى ومطابقة لقوانين المنتدى ليتم موافقة عليه.";
			$color = 'yellow';
		}
		else{
			$message = '';
			$color = '';
		}
		if(!empty($message)){
			$this->msgBox($message, $color, 10, 0, true, false);
		}
	}
	function getSubTitle($base=false){
		$title="";
		if(_df_script=='forums'){
			$title=$this->DF->catch['forumSubject'];
		}
		elseif(_df_script=='topics'){
			$title=$this->DF->catch['topicSubject'];
		}
		elseif(_df_script=='archive'){
			$title="الأرشيف";
		}
		elseif(_df_script=='yourposts'){
			$title="مشاركاتك";
		}
		elseif(_df_script=='yourtopics'){
			$title="مواضيعك";
		}
		elseif(_df_script=='users'){
			$title="الأعضاء";
		}
		elseif(_df_script=='favorite'){
			$title="المفضلة";
		}
		elseif(_df_script=='pm'){
			$title=(empty($this->DF->catch['menuTitle']) ? "رسائل خاصة" : "رسائل خاصة - {$this->DF->catch['menuTitle']}");
		}
		elseif(_df_script=='active'){
			$title="مواضيع نشطة";
		}
		elseif(_df_script=='search'){
			$title="إبحث";
		}
		elseif(_df_script=='profile'){
			if(type=='details'){
				$title="بيانات العضويتك";
			}
			elseif(type=='editpass'){
				$title="تغيير بيانات - بريد الالكتروني وكلمة السرية";
			}
			elseif(type=='editdetails'){
				$title="تغيير بيانات - خيارات العضوية وبيانات الشخصية";
			}
			elseif(type=='changename'){
				$title="طلب تغيير إسم العضوية";
			}
			elseif(type=='loginbar'){
				$title="سجل اتصال {$this->DF->catch['loginBarUserName']}";
			}
			elseif(type=='trylogin'){
				$title="سجل محاولات دخول {$this->DF->catch['tryloginUserName']}";
			}
			elseif(type=='lists'){
				$title="قوائم خاصة";
			}
			elseif(type=='medals'){
				$title="خدمات عضويتك";
			}
			elseif(type=='hiddentopics'){
				$uid=(auth>0&&ulv==4?auth:uid);
				$title="مواضيع مخفية ومفتوحة ".($uid==uid ? "لك" : "للعضو")."";
			}
			elseif(type=='sendadmin'){
				$title="مراسلة إدارة المنتديات";
			}
			else{
				$title="تفاصيل العضوية";
			}
		}
		elseif(_df_script=='editor'){
			$title=$this->DF->catch['editorTypeTitle'];
		}
		elseif(_df_script=='svc'){
			$title=$this->DF->catch['svcTypeTitle'];
		}
		elseif(_df_script=='admincp'){
			$title="لوحة التحكم";
		}
		elseif(_df_script=='admin_login'){
			$title="دخول لوحة التحكم";
		}
		elseif(_df_script=='catadmin'){
			$title="إدارة فئات";
		}
		elseif(_df_script=='forumadmin'){
			$title="إدارة أقسام";
		}
		elseif(_df_script=='foruminfo'){
			$title="معلومات واحصائيات عن منتديات";
		}
		elseif(_df_script=='options'){
			if(type=='topicusers'){
				$title="إضافة وحذف أعضاء مخولين لرؤية هذا الموضوع";
			}
			elseif(type=='topicstats'){
				$title="إحصائيات ردود الأعضاء في الموضوع";
			}
			elseif(type=='complain'){
				$title="لفت انتباهك للمشرف عن مشاركات";
			}
			elseif(type=='survey'){
				$title="إضافة أو إزالة إستفتاء للموضع";
			}
		}
		elseif(_df_script=='ordercf'){
			$title="ترتيب فئات ومنتديات";
		}
		elseif(_df_script=='print'){
			$title="طباعة موضوع";
		}
		elseif(_df_script=='register'){
			$title="تسجيل عضوية جديدة";
		}
		elseif(_df_script=='rules'){
			$title="شروط المشاركة";
		}
		elseif(_df_script=='sendtopic'){
			$title="ارسل موضوع لصديقك";
		}
		elseif(_df_script==''){
			$title="";
		}
		if(!$base){
			$title=(empty($title) ? "" : " - $title");
		}
		return $title;
	}
	function display($name,$ret=false){
		$html=$this->mysql->get("template","text",$name,"name");
		$html=$this->htmlCode($html);
		if($ret){
			return $html;
		}
		else{
			echo $html;
		}
	}
	function htmlCode($html){
		extract($GLOBALS);
		$html="<code>$html</code>";
		$html=stripslashes($html);
		$html=preg_replace("/{{/","</code>",$html);
		$html=preg_replace("/}}/","<code>",$html);
		$html=$this->condition($html);
		$html=$this->loopEach($html);
		$html=$this->loop($html);
		$html=$this->sql($html);
		$html=addslashes($html);
		$html=preg_replace('/\<code>/i',"echo\"",$html);
		$html=preg_replace('/\<\/code>/i',"\";",$html);
		$html.='return true;';
		ob_start();
		$html=eval($html);
		$html=ob_get_contents();
		ob_end_clean();
		return $html;
	}
	function condition($html){
		$html=preg_replace('/\<if condition\=\"(.*)\">/','</code> if($1){ <code>',$html);
		$html=preg_replace('/\<else>/i','</code>} else{ <code>',$html);
		$html=preg_replace('/\<\/if\>/','</code>} <code>',$html);
		return $html;
	}
	function sql($html){
		$html=preg_replace('#<sql sql="(.*)" result="(.*)" fetch="(.*)">#','</code> $count=0;while($2=@$mysql->fetch$3($1)){ <code>',$html);
		$html=preg_replace('/\<\/sql\>/','</code> $count++;} <code>',$html);
		return $html;
	}
	function loop($html){
		$html=preg_replace('#<loop value="(.*)" star="(.*)" end="(.*)">#','</code> for($1=$2;$1<$3;$1++){ <code>',$html);
		$html=preg_replace('/\<\/loop\>/','</code> } <code>',$html);
		return $html;
	}
	function loopEach($html){
		$html=preg_replace('/\<foreach array\=\"(.*)\" key\=\"(.*)\" val\=\"(.*)\">/','</code> foreach($1 as $2=>$3){ <code>',$html);
		$html=preg_replace('/\<\/foreach\>/','</code> } <code>',$html);
		return $html;
	}
}
?>
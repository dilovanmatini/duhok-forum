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

 const _df_version = '3.0';
 
 $xcode = mt_rand(1000000, 9999999);

 $_step = isset($_GET['step']) ? $_GET['step'] : '';

 require_once '../includes/class.html.php';
 HTML\Elements::$mainDarkColor = '#ddd';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Duhok Forum - Installing</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="copyright" content="Duhok Forum <?=_df_version?>: Copyright © 2009-<?=date("Y")?> Dilovan Matini" />
<link rel="icon" href="../images/dark/favicon/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../images/favicon/dark/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="../styles/reset.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../styles/html.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../styles/fonts/style.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../styles/blue/style.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../styles/arial.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../styles/globals.css?x=<?=$xcode?>" />
<link rel="stylesheet" type="text/css" href="../js/dm/assets/style-1.0.css?x=<?=$xcode?>" />
<script type="text/javascript" src="../js/jquery/jquery-1.11.1.min.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/jquery/jquery-migrate-1.2.1.min.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/ui/jquery-ui.min.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/jquery/jquery.plugins.min.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/lib/library.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/lib/plugins.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/dm/dm-1.0.js?x=<?=$xcode?>"></script>
<script type="text/javascript" src="../js/globals.js?x=<?=$xcode?>"></script>
<script type="text/javascript">
var
dir="rtl",
xcode="?x=<?=$xcode?>",
self="/duhokforum/index.php",
thisFile="index.php",
userLevel=4,
menubarHighlight="#dadada",
loadingUrl="../images/icons/loading.gif",
progressUrl="../images/icons/progress.gif",
succeedUrl="../images/icons/succeed.gif",
errorUrl="../images/icons/error.gif",
nophotoUrl="../images/icons/nophoto.gif";
DF.menu.checkElements();
DF.checkTHLink();
</script>
<style type="text/css">
.in-header{
    margin: 30px 20px 30px;
    text-align: center;
}
.in-header > img{
    width: 100px;
}
.in-header > div{
    display: inline-block;
    margin-left: 30px;
    font: bold 36px 'Droid Arabic Kufi',tahoma,arial;
    color: #fff;
    text-shadow: 1px 3px 7px rgba(0, 0, 0, 0.5);
    vertical-align: middle;
}
.in-header > div > span{
    display: inline-block;
    margin-left: 4px;
    font-size: 20px;
    color: #aaa;
}
</style>
</head>
<body>
<div class="dis-none in-loading-icon"><?=HTML\Elements::iconLoader('three-bounce')?></div>
<div class="in-header" dir="ltr">
    <img src="../images/df-logo-light.png">
    <div>DUHOK FORUM<span>v<?=_df_version?></span></div>
</div>

<?php

if( $_step == '' ){

    ?>
    <script type="text/javascript">
    $(function(){
        $('.in_next').on('click', function(){
            if( $('.in_agree').prop('checked') === true ){
                dm.goTo('index.php?step=database');
            }
            else{
                alert('يجب عليك أن تتأكد على انك قرأت ما ذكر في الرخصة لكي تمضي قدماً');
            }
        });
    });
    </script>
    <table width="1000" cellSpacing="0" cellPadding="0" align="center">
        <tr>
            <td class="asBody" align="center" style="padding:20px;font-size:18px;">
                مرحباً بك في نسخة منتديات Duhok Forum v<?=_df_version?>
            </td>
        </tr>
        <tr>
            <td class="asHeader">الرخصة</td>
        </tr>
        <tr>
            <td class="asBody dm-p10 dm-s15" style="line-height:20px;color:#ccc;">
                نسخة منتديات Duhok Forum هي نسخة مجانية مفتوحة المصدر يمكنك تنصيب على خوادم لينكس وخوادم المحلية التي تحتوي على منصة Apache. يمكن تشغيل النسخة بواسطة جميع متصفحات الويب الحديثة. تم برمجة هذه النسخة بالغة البرمجة الشهيرة PHP وقواعد بيانات MySQL، بالإضافة الى استخدام لغات الأسياسية للويب مثل HTML و CSS و JavaScript و Ajax، أيضا تم استخدام مكتبة شهيرة jQuery والعديد من مكتبات الجافا سكريبت المفتوحة المصدر.
                <br><br>
                تم إصدار أول ثمانية نسخ بواسطة Dilovan Matini، ثم بعدها تم تطوير النسخة من قبل العديد من المبرمجين وتم نزول العديد من النسخ، آخرها نسخة 2.1 التي تحتوي على كثير من التحسينات والتطويرات، لكن بسبب تحديثات الكثيرة في مجال التقنية وتحديث جميع لغات البرمجة المستخدمة في هذه النسخة مثل PHP7 و قواعد البيانات MySQL8، فلا يمكن استعمالها في سيرفرات الحديثة ولهذا السبب، تم إصدار نسخة <?=_df_version?> من قبل مبرمجها الأصلي لكي يتناسب مع جميع اصدارات المحدثة للغات المذكورة المستخدمة. أيضاً تم تحسين النسخة من جميع جوانب الأمنية والأداء والتصميم. 
                <br><br>
                Duhok Forum هي نسخة مجانية مفتوحة المصدر يمكنك إعادة توزيعه أو تعديله بموجب شروط رخصة <a class="sec" href="https://www.gnu.org/licenses">GNU</a> كما تم نشرها بواسطة مؤسسة البرمجيات الحرة ، إما الإصدار 3 من الترخيص ، أو أي إصدار لاحق.
                <br><br>
                النسخة محمية وفقاً لجميع معايير الحماية ويتم توزيعها على أمل أن يكون مفيدًا، ولكن دون أي ضمان؛ حتى بدون الضمان الضمني للتسويق أو الملاءمة لغرض معين. انظر رخصة <a class="sec" href="https://www.gnu.org/licenses">GNU</a> العمومية لمزيد من التفاصيل.
                <br><br><br>
                <div class="dm-center"><input type="checkbox" class="in_agree"> بالنقر هنا، أنت موافق على جميع ما ذكر أعلاه.</div>
            </td>
        </tr>
        <tr>
            <td class="asBody dm-p5 dm-left">
                <input class="button in_next" type="button" value="التالي">
            </td>
        </tr>
    </table>
    <?php

}
elseif( $_step == 'database' ){

    ?>
    <script type="text/javascript">
    dm.dbcheck = false;
    $(function(){
        $('.in_dbcheck').on('click', function(){
            var button = $(this), place = $('.in_dbcheck_status');

            if( button.hasClass('busy') ){
                return;
            }

            button.addClass('busy');
            place.removeClass('dm-cred dm-cgreen').html( $('.in-loading-icon').html() );
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=dbcheck_connection&x='+dm.rand(),
                data: {},
                dataType: 'json',
                cache: false,
                success: function( json ){
                    if( $.type(json) === 'object' && json.status == 'success' ){
                        place.removeClass('dm-cred').addClass('dm-cgreen').html('تم اتصال بقاعدة بيانات بنجاح');
                        dm.dbcheck = true;
                    }
                    else{
                        place.addClass('dm-cred').html('فشل في اتصال بقاعدة البيانات، رجاءً تأكد من ملف config.php');
                        dm.dbcheck = false;
                    }
                },
                error: function(){
                    place.addClass('dm-cred').html('حدث خطأ، أرجوا أن تحاول مرة اخرى');
                    dm.dbcheck = false;
                },
                complete: function(){
                    button.removeClass('busy');
                }
            });
        });
        $('.in_next').on('click', function(){
            if( dm.dbcheck === true ){
                dm.goTo('index.php?step=logininfo');
            }
            else{
                alert('يجب عليك أن تحقق في اتصال بقاعدة البيانات أولاً، ثم النقر على زر التالي.');
            }
        });
    });
    </script>
    <table width="1000" cellSpacing="0" cellPadding="0" align="center">
        <tr>
            <td class="asHeader">قاعدة البيانات</td>
        </tr>
        <tr>
            <td class="asBody dm-p10 dm-s15" style="line-height:20px;color:#ccc;">
                يجب عليك إدخال معلومات الاتصال بقاعدة البيانات في ملف config.php الموجود في مجلد includes أولاً، ثم تحقق من اتصال.<br><br>
                المعلومات المطلوبة هي:-<br><br>
                <ul style="padding-right:20px">
                    <li>الخادم: عادتا يكون localhost.</li>
                    <li>اسم قاعدة البيانات.</li>
                    <li>اسم مستخدم قاعدة بيانات.</li>
                    <li>الكلمة السرية لقاعدة بيانات.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="asBody dm-p10 dm-s15 dm-center" style="line-height:20px;color:#ccc;">
                <div class="in_dbcheck_status">لم يتم البدأ بالتحقق</div>
            </td>
        </tr>
        <tr>
            <td class="asBody dm-p10 dm-s15 dm-center" style="line-height:20px;color:#ccc;">
                <input class="button in_dbcheck" type="button" value="تحقق من إتصال بقاعدة البيانات">
            </td>
        </tr>
        <tr>
            <td class="asBody dm-p5 dm-left">
                <input class="button in_next" type="button" value="التالي">
            </td>
        </tr>
    </table>
    <?php
}
elseif( $_step == 'logininfo' ){

    ?>
    <script type="text/javascript">
    $(function(){
        $('.in_setting_up').on('click', function(){
            var button = $(this), place = $('.in_check_place');

            if( button.hasClass('busy') ){
                return;
            }

            button.addClass('busy');
            place.removeClass('dm-cred dm-cgreen').html( $('.in-loading-icon').html() );
            $.ajax({
                type: 'post',
                url: 'ajax.php?type=setting_up&x='+dm.rand(),
                data: {
                    'forum_title': $('.in_forum_title').val(),
                    'site_address': $('.in_site_address').val(),
                    'forum_email': $('.in_forum_email').val(),
                    'username': $('.in_username').val(),
                    'password1': $('.in_password1').val(),
                    'password2': $('.in_password2').val()
                },
                dataType: 'json',
                cache: false,
                success: function( json ){
                    if( $.type(json) === 'object' ){
                        var sql_error = '';
                        if( $.type(json.sql_error) === 'string' ){
                            sql_error = ' <a class="sec in_sql_error" href="#" sql-error="'+json.sql_error+'">[نسخ وعرض تفاصيل الخطأ]</a>';
                        }
                        if( json.status == 'success' ){
                            if( sql_error != '' ){
                                place.addClass('dm-cred').html('حدث خطأ'+sql_error);
                            }
                            else{
                                place.html('');
                                dm.goTo('index.php?step=done');
                            }
                        }
                        else{
                            place.addClass('dm-cred').html(json.status+sql_error);
                        }
                    }
                    else{
                        place.addClass('dm-cred').html('حدث خطأ، أرجوا أن تحاول مرة اخرى');
                    }
                },
                error: function(){
                    place.addClass('dm-cred').html('حدث خطأ، أرجوا أن تحاول مرة اخرى');
                },
                complete: function(){
                    button.removeClass('busy');
                }
            });
        });
        $('.in_sql_error').livequery(function(){
            $(this).on('click', function(){
                var button = $(this), error = button.attr('sql-error') || '', textarea = $('.in-sqlerror');
                textarea.val(error).show().select();
                try{
                    document.execCommand('copy');
                }
                catch( e ){
                    console.log('Oops, unable to copy');
                }
                textarea.val('').hide();
                alert(error);
                return false;
            });
        });
    });
    </script>
    <textarea class="in-sqlerror" style="display:none;"></textarea>
    <table width="1000" cellSpacing="0" cellPadding="0" align="center">
        <tr>
            <td class="asHeader" colspan="2">معلومات الرئيسية</td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">اسم المنتدى</td>
			<td class="asNormalB dm-p5"><input type="text" style="width:300px;" class="in_forum_title" placeholder="منتديات دهوك فوريوم"></td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">عنوان المنتدى</td>
			<td class="asNormalB dm-p5"><input type="text" style="width:300px;" class="in_site_address" placeholder="www.lelav.com" dir="ltr"></td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">بريد المنتدى</td>
			<td class="asNormalB dm-p5"><input type="text" style="width:300px;" class="in_forum_email" placeholder="df@lelav.com" dir="ltr"></td>
		</tr>
        <tr>
            <td class="asHeader" colspan="2">معلومات الدخول</td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">اسم مدير المنتدى</td>
			<td class="asNormalB dm-p5"><input type="text" style="width:200px;" class="in_username" value="admin"></td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">الكلمة السرية</td>
			<td class="asNormalB dm-p5"><input type="password" style="width:200px;" class="in_password1"></td>
        </tr>
        <tr>
			<td class="asFixedB dm-p5">إعادة كلمة السرية</td>
			<td class="asNormalB dm-p5"><input type="password" style="width:200px;" class="in_password2"></td>
		</tr>
        <tr>
            <td class="asBody dm-p5 dm-left" colspan="2">
                <div class="pos-relative">
                    <div style="position:absolute;right:0;top:0;line-height:24px;"><div class="in_check_place dm-mt3"></div></div>
                    <input class="button in_setting_up" type="button" value="بدأ التثبيت">
                </div>
            </td>
        </tr>
    </table>
    <?php
}
elseif( $_step == 'done' ){
    ?>
    <script type="text/javascript">
    $(function(){
        $('.in_goto_forum').on('click', function(){
            if( confirm('يرجى تأكد من انك حذفت مجلد install') ){
                dm.goTo('../');
            }
        });
    });
    </script>
    <table width="1000" cellSpacing="0" cellPadding="0" align="center">
        <tr>
            <td class="asBody dm-p10 dm-s15 dm-center" style="line-height:20px;color:#ccc;">
                <div style="font: bold 30px 'Droid Arabic Kufi',tahoma,arial;">مبروك</div>
                <div style="font: bold 24px 'Droid Arabic Kufi',tahoma,arial;color:#addd7c;">تم تثبيت المنتدى بنجاح</div><br>
                <div style="color:#db7676;">هام جداً: قبل بدأ باستخدام المنتدى، يجب عليك حذف مجلد install باكمله لكي تفادي اي ضرر بالمنتدى.</div>
            </td>
        </tr>
        <tr>
            <td class="asBody dm-p10 dm-s15 dm-center" style="line-height:20px;color:#ccc;">
                <input class="button in_goto_forum" type="button" value="الذهاب الى صفحة الرئيسية للمنتدى">
            </td>
        </tr>
    </table>
    <?php
}
else{
    ?><script type="text/javascript">window.location = 'index.php';</script><?php
}

?>
<br>
<table width="1000" cellSpacing="0" cellPadding="0" align="center">
    <tr>
        <td class="asBody dm-p10 dm-s15 dm-center" style="line-height:20px;color:#ccc;">
            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td class="asC2" dir="ltr">
                        <img src="../images/favicon/light/favicon-32x32.png" style="width:30px;">
                        <div class="dis-inline-block dm-middle">Duhok Forum <?=_df_version?></div>
                    </td>
                </tr>
                <tr>
                    <td class="asC2" dir="ltr">
                        Programmed By <a class="sec" href="http://dilovanmatini.com">Dilovan Matini</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
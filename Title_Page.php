<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

//////////////////////////////// header titles ///////////////////////////////////////////////
if($mode == "mods") $Page_Name .= " - إشرافك";
if($mode == "members") $Page_Name .= " - قائمة الاعضاء";
if($mode == "files") $Page_Name .= " - ملفاتك";
if($mode == "archive") $Page_Name .= " - الأرشيف";
if(mode == "posts" AND $m == "0") $Page_Name .= " - المواضيع التي شاركت فيها مؤخرا "; 
if(mode == "topics" AND $m == "0") $Page_Name .= " - مواضيعك "; 
if($mode == "pm") $Page_Name .= " - الرسائل الخاصة";
if($mode == "search") $Page_Name .= " - البحث";
if($mode == "profile" AND $type AND !$id) $Page_Name .= " - بياناتك";
if(mode == "active" AND !$active) $Page_Name .= " - مواضيع نشطة";
if($mode == "hide_topics") $Page_Name .= " - المواضيع المخفية المفتوحة لك";
if($mode == "sendmsg") $Page_Name .= " - إرسال رسالة خاصة";

//////////////////////////////// members titles ///////////////////////////////////////////////
if(mode == "members" AND $type == "lock") $Page_Name .= " - العضويات المقفولة";
if(mode == "editor" AND $method == "sig") $Page_Name .= " - تغيير توقيعك"; 
if(mode == "list" AND $method == "index") $Page_Name .= " - قوائم الأعضاء الخاصة بك"; 
if(mode == "list" AND $type == "my_box") $Page_Name .= " - قوائمك الخاصة"; 
if($mode == "changename") $Page_Name .= " - طلب تغيير اسم عضويتك";


//////////////////////////////// admin titles ///////////////////////////////////////////////
if(mode == "admin_svc") $Page_Name .= " - خدمات المدير";
if(mode == "admin_svc" AND $type == "change_name") $Page_Name .= "- الأسماء التي تنتظر الموافقة ";
if(mode == "admin_svc" AND $type == "approve") $Page_Name .= "- العضويات التي تنتظر الموافقة   ";
if(mode == "admin_svc" AND $type == "hold") $Page_Name .= "- العضويات التي تم رفضها";
if(mode == "admin_svc" AND $type == "forumsorder") $Page_Name .= "- ترتيب المنتديات";

//////////////////////////////// svc titles ///////////////////////////////////////////////
if(mode == "active" AND $active == "monitored") $Page_Name .= " - قائمة مواضيعك المفضلة"; 
if(mode == "svc" AND $svc == "type") $Page_Name .= " - خدمات الإشراف"; 
if(mode == "svc" AND $svc == "ip") $Page_Name .= " - اخر بيانات الاتصال "; 
if(mode == "svc" AND $svc == "ip" AND $type == "info") $Page_Name .= " - سجل محاولات الدخول "; 
if(mode == "svc" AND $svc == "medals") $Page_Name .= " - أوسمة التميز "; 
if(mode == "svc" AND $svc == "medals") $Page_Name .= " - أوسمة التميز "; 
if(mode == "svc" AND $method == "svc" AND $svc == "titles") $Page_Name .= " - قائمة الأوصاف  ";
if(mode == "svc" AND $method == "add" AND $svc == "titles") $Page_Name .= " - أضف وصف";
if(mode == "svc" AND $method == "svc" AND $svc == "surveys") $Page_Name .= " - الإستفتاءات";
if(mode == "svc" AND $method == "add" AND $svc == "surveys") $Page_Name .= " - أضف إستفتاء";


//////////////////////////////// editor titles ///////////////////////////////////////////////
if(mode == "editor" AND $method == "topic")  $Page_Name .= " - موضوع جديد";
if(mode == "editor" AND $method == "edit")  $Page_Name .= " - تغيير الموضوع";
if(mode == "editor" AND $method == "reply")  $Page_Name .= " - إضافة رد";
if(mode == "editor" AND $method == "editreply")  $Page_Name .= " - تغيير الرد";
if($mode == "editor" AND $method == "replymsg" )$Page_Name .= " - رد على رسالة";

//////////////////////////////// others titles ///////////////////////////////////////////////
if($mode == "tellfriend")$Page_Name .= " - إخبار صديق عن موضوع";



// Gen
if($mode == "t" AND topics("HIDDEN", $t) == 0){ 
$Page_Name .=" - ".topics("SUBJECT", $t); 
$Meta = topics("SUBJECT", $t);
}

if($mode == "f" AND forums("HIDE", $f) == 0){
$Page_Name .= " - ".forums("SUBJECT", $f); 
$Meta = forums("SUBJECT", $f);
}
if($mode == "profile" AND $id AND mlv != 0 AND !$type){ 
$Page_Name .= " - ".member_name($id);
}

if($mode == "profile" AND $type == "edit_user" AND $id ){ 
$Page_Name .= " - تعديل العضو : ".member_name($id);
}

if($mode == "editor" AND $method == "sendmsg" AND $m ){ 
$Page_Name .= " - رسالة إلى : ".member_name($m);
}


if($mode == "svc" AND $svc == "ip" AND $id ){ 
$Page_Name .= " -  ".member_name($id);
}


if($mode == "svc" AND $svc == "search" AND $id ){ 
$Page_Name .= "عمليات بحث العضو : ".member_name($id);
}

if($mode == "pm" AND $mail == "show" AND $id ){ 
$Page_Name .= " للعضو  : ".member_name($id);
}

?>
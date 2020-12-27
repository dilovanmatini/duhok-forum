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

if($Mlevel == 0 AND $MSG == 1 ){

echo'
</body>
<!-- ابتكار و تطوير و خلق ملك المستقبل  ــ   بداية هاك ــ رسالة أنت غير مسجل -->

<STYLE type=text/css>#topbar {
	BORDER-RIGHT: black 1px solid; PADDING-RIGHT: 4px; BORDER-TOP: black 1px solid; PADDING-LEFT: 4px; VISIBILITY: hidden; PADDING-BOTTOM: 4px; BORDER-LEFT: black 1px solid; WIDTH: 380px; PADDING-TOP: 4px; BORDER-BOTTOM: black 1px solid; POSITION: absolute; BACKGROUND-COLOR: white
}
</STYLE>

<SCRIPT type=text/javascript>
var persistclose = 0 // اذا كان الرقم 0 فان الزائر تفتح له الرسالة في كل صفحة ولما يقفل تظهر في الصفحة الموالية ، اما اذا وضعتها 1 فلما يقفل الزائر ستقفل الرسالة للزائر في جميع الصحفات
var startX = 20 //مكان الرسالة في الشاشة بالبيكسل في العرض
var startY = 4 //مكان الرسالة في الشاشة بالبيكسل في الطول
var verticalpos="fromtop" //غير من  "fromtop" الى  "frombottom" اذا ارت الرسالة تظهر من الأسفل
function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
function get_cookie(Name){
var search = Name + "="
var returnvalue = "";
if(document.cookie.length > 0){
offset = document.cookie.indexOf(search)
if(offset != -1){
offset += search.length
end = document.cookie.indexOf(";", offset);
if(end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}
function closebar(){
if(persistclose)
document.cookie="remainclosed=1"
document.getElementById("topbar").style.visibility="hidden"
}
function staticbar(){
barheight=document.getElementById("topbar").offsetHeight
var ns = (navigator.appName.indexOf("Netscape") != -1) || window.opera;
var d = document;
function ml(id){
var el=d.getElementById(id);
if(!persistclose || persistclose && get_cookie("remainclosed")=="")
el.style.visibility="visible"
if(d.layers)el.style=el;
el.sP=function(x,y){this.style.left=x+"px";this.style.top=y+"px";};
el.x = startX;
if(verticalpos=="fromtop")
el.y = startY;
else{
el.y = ns ? pageYOffset + innerHeight : iecompattest().scrollTop + iecompattest().clientHeight;
el.y -= startY;
}
return el;
}
window.stayTopLeft=function(){
if(verticalpos=="fromtop"){
var pY = ns ? pageYOffset : iecompattest().scrollTop;
ftlObj.y += (pY + startY - ftlObj.y)/8;
}
else{
var pY = ns ? pageYOffset + innerHeight - barheight: iecompattest().scrollTop + iecompattest().clientHeight - barheight;
ftlObj.y += (pY - startY - ftlObj.y)/8;
}
ftlObj.sP(ftlObj.x, ftlObj.y);
setTimeout("stayTopLeft()", 10);
}
ftlObj = ml("topbar");
stayTopLeft();
}
if(window.addEventListener)
window.addEventListener("load", staticbar, false)
else if(window.attachEvent)
window.attachEvent("onload", staticbar)
else if(document.getElementById)
window.onload=staticbar
</SCRIPT>
</HEAD>
<BODY 
onload="if(is_ie || is_moz){ var cpost=document.location.hash;if(cpost){ if(cobj = fetch_object(cpost.substring(1,cpost.length)))cobj.scrollIntoView(true); }}">
<DIV id=topbar><A onclick="closebar(); return false" >
<IMG style="cursor: hand;" src="'.$icon_close.'" border=0>
</A> <SPAN lang=ar-tn><b>'.$FORUM_MSG.'</b>
<font color="#000000"><b><u>'.$forum_title.'</u>
</b></font> </SPAN><b>. 
'.$FORUM_MSG1.'
<A href="index.php?mode=policy"><FONT 
color=#ff0000>'.$FORUM_MSG2.'</FONT></A> </DIV>
</b>
<!-- ابتكار و تطوير و خلق ملك المستقبل  ــ   نهاية هاك ــ رسالة أنت غير مسجل -->
</script>
</html>';
}
?>
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
if(!DF) var DF={};
DF.command = function(id, type, post){
	var frm = $I('#optionsFrm'), myMsg = new Array(), postType = (post) ? ' هذه المشاركة' : ' هذا الموضوع';
	myMsg["mo"] = ["موافقة على", postType];
	myMsg["ho"] = ["تجميد", postType];
	myMsg["hd"] = ["إخفاء", postType];
	myMsg["vs"] = ["إظهار", postType];
	myMsg["lk"] = ["قفل", postType];
	myMsg["op"] = ["فتح", postType];
	myMsg["yv"] = ["عرض موضوع للجميع", ""];
	myMsg["nv"] = ["عرض موضوع فقط لأعضاء مسجلين", ""];
	myMsg["dl"] = ["حذف", postType];
	myMsg["re"] = ["إسترجاع", postType];
	if(confirm("هل أنت متأكد بأن تريد "+myMsg[type][0]+myMsg[type][1]+" ؟")){
		frm.type.value = type;
		frm.other.value = (post) ? posts[id][3]+"|"+topicid : tauthor+"|0";
		frm.posttype.value =(post) ? 1 : 0;
		frm.id.value = id;
		frm.cmd.value = 2;
		frm.submit();
	}
};
DF.getNumSel=function(frm){
	var el=frm.elements;
	for(var x=0,y=0;x<el.length;x++){
		if(el[x].type=='checkbox'&&el[x].checked){
			y++;
		}
	}
	return y;
};
DF.getNumSelPosts=function(frm,type){
	var el=frm.elements,post,arr=new Array(),y=0;
	frm.id.value=0;
	if(type!=''){
		arr["mo"]=[1,1];
		arr["ho"]=[1,1];
		arr["hd"]=[0,0];
		arr["vs"]=[1,0];
		arr["dl"]=[0,2];
		arr["re"]=[1,2];
		var status=arr[type][0],index=arr[type][1];
		for(var x=0,y=0;x<el.length;x++){
			if(el[x].type=='checkbox'&&el[x].checked){
				post=posts[parseInt(el[x].value)];
				if(post[index]==status||type=='mo'&&post[1]==2){
					y++;
					frm.id.value+=(y==0 ? '' : ',')+el[x].value;
					frm.other.value+=(y==0 ? '' : '|')+el[x].value+"-"+post[3]+"-"+topicid;
				}
			}
		}
	}
	return y;
};
DF.checkGetType=function(obj){
	var sel1=$I('#frmBar1').selOptions,sel2=$I('#frmBar2').selOptions;
	if(obj){
		sel1.selectedIndex=obj.selectedIndex;
		sel2.selectedIndex=obj.selectedIndex;
	}
	else{
		sel2.selectedIndex=sel1.selectedIndex;
	}
	return sel1.options[sel1.selectedIndex].value;
};
DF.checkChoose=function(s){
	var frm=$I('#optionsFrm'),type=this.checkGetType(s),numPosts=this.getNumSelPosts(frm,type),acceptVal="تطبيق",
	numSel=this.getNumSel(frm),frm1=$I('#frmBar1'),frm2=$I('#frmBar2');
	if(type!=''&&numSel==0){
		if(s){
			alert("أنت لم حددت أي موضوع");
		}
		frm1.selOptions.selectedIndex=0;
		frm2.selOptions.selectedIndex=0;
	}
	if(type!=''&&numSel>0){
		acceptVal="("+numPosts+") تطبيق";
	}
	frm1.accept.value=acceptVal;
	frm2.accept.value=acceptVal;
};
DF.checkClick=function(){
	var frm=$I('#optionsFrm'),type=this.checkGetType(false),numPosts=this.getNumSelPosts(frm,type),Msg=new Array(),
	errMsg=new Array();
	Msg["mo"]="موافقة على ردود المختارة";
	Msg["ho"]="تجميد ردود المختارة";
	Msg["hd"]="إخفاء ردود المختارة";
	Msg["vs"]="إظهار ردود المختارة";
	Msg["dl"]="حذف ردود المختارة";
	Msg["re"]="إرجاع ردود المختارة";
	errMsg["mo"]="ينتظر الموافقة او مجمّد";
	errMsg["ho"]="ينتظر الموافقة لتجميده";
	errMsg["hd"]="غير مخفي";
	errMsg["vs"]="مخفي";
	errMsg["dl"]="غير محذوف";
	errMsg["re"]="محذوف";
	if(numPosts>0){
		if(confirm("هل أنت متأكد بأن تريد "+Msg[type]+" وعددها: "+numPosts)){
			frm.type.value=type;
			frm.cmd.value=1;
			frm.submit();
		}
	}
	else{
		if(type==''){
			confirm("أنت لم حددت أي خيار من قائمة خيارات الردود");
		}
		else{
			confirm("أنت لم حددت أي رد "+errMsg[type]);
		}
	}
};
DF.doSelectRow=function(s,id,o){
	var cls=(s.checked==true ? 'asSelect' : o),c1=$I('#p1Cell'+id),c2=$I('#p2Cell'+id);
	if(c1&&c2){
		c1.className=cls;
		c2.className=cls;
	}
};
DF.selectUserPosts=function(userid,name){
	var frm=$I('#optionsFrm'),el=frm.elements,id,author;
	for(var x=0,y=0;x<el.length;x++){
		if(el[x].type=='checkbox'){
			id=el[x].value,author=parseInt(el[x].attributes['author'].value);
			if(author==userid){
				el[x].checked=true;
				this.doSelectRow(el[x],id,el[x].attributes['defclass'].value);
				y++;
			}
		}
	}
	this.checkChoose(false);
	alert("تم تحديد جميع ردود العضوية \""+name+"\" وعدد ردودها: "+y);
};
DF.selectPosts=function(s){
	var frm=$I('#optionsFrm'),el=frm.elements,status=(s.checked==true ? true : false);
	for(var x=0;x<el.length;x++){
		if(el[x].type=='checkbox'){
			el[x].checked=status;
			this.doSelectRow(el[x],el[x].value,el[x].attributes['defclass'].value);
		}
	}
	$I('#checkbox1').checked=status;
	$I('#checkbox2').checked=status;
	this.checkChoose(false);
};
DF.checkChooseMove=function(frm){
	var otheroptions=frm.otheroptions.options[frm.otheroptions.selectedIndex].value,place=$I('#moveForumList');
	if(frm.otheroptions.selectedIndex>0){
		if(otheroptions=='mv'){
			DF.getMoveForumList();
		}
		else{
			place.innerHTML='';
		}
	}
};
DF.getMoveForumList=function(){
	var forumsList=$I('#goToForumLsit').options,place=$I('#moveForumList'),text;
	text="&nbsp;<select class=\"asGoTo\" style=\"width:170px\" name=\"definedForumList\" id=\"definedForumList\">"+
	"<option value=\"0\">-- اختر منتدى --</option>";
	for(var x=0;x<forumsList.length;x++){
		var fid=forumsList[x].value,fsubject=forumsList[x].text;
		if(fid>0&&fid!=forumid){
			text+="<option value=\""+fid+"\">"+fsubject+"</option>";
		}
	}
	text+="</select>";
	place.innerHTML=text;
};
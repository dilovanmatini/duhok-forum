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
if(!DF){
	var DF={};
}
var userNameError=true,userPass1Error=true,userPass2Error=true,userEmailError=true,msgInfo=DF.msgBox('','blue',6),
messagesInfo=new Array(),rowsName=new Array('userName','userPass1','userPass2','userEmail');
messagesInfo['userName']=""+
	"* يجب ان يكون الاسم على الأقل مكون من 3 أحرف<br>"+
	"* لا يسمح استخدام الرموز غير الأحرف والأرقام <br>"+
	"* لا يسمح استخدام رمز التمديد ــــ<br>"+
	"* يجب الا يكون الاسم مشابه جدا لاسم عضو حالي<br>"+
	"* لا يسمح بالاسماء التي كلها ارقام<br>"+
	"* لا يسمح بتكرار حرف عدة مرات<br>"+
	"* لا يسمح بوضع الايميل كجزء من الاسم<br>"+
	"* لا يسمح باستخدام اسم الموقع او جزء منه في الاسم<br>"+
	"* لا يسمح باستخدام اسم يوحي بالاشراف او الادارة<br>"+
	"* لا يسمح باستخدام اسم غير لائق بالآداب العامة";
messagesInfo['userPass1']=""+
	"* يجب ان تكون الكلمة السرية على الأقل 6 أحرف<br>"+
	"* يجب الا تكون الكلمة السرية مشابة للإسم<br>"+
	"* يفضل ألا تكون الكلمة السرية مكونة من أرقام فقط";
messagesInfo['userPass2']=""+
	"* يجب أن تتطابق الكلمة السرية مع أعادتها";
messagesInfo['userEmail']=""+
	"* يجب ان تدخل عنوان بريد إلكتروني صحيح<br>"+
	"* سيتم إرسال بريد الى هذا العنوان لإستكمال التسجيل";
DF.checkInfo=function(table,type){
	var tab=$I('#'+table),row=$I('#'+type+"Row"),rowInfo=$I('#'+type+"Info");
	if(rowInfo){
		tab.deleteRow(rowInfo.rowIndex);
	}
	else{
		for(var x=0;rowsName.length>x;x++){
			if($I('#'+rowsName[x]+"Info")) tab.deleteRow($I('#'+rowsName[x]+"Info").rowIndex);
		}
		var newRow=tab.insertRow(row.rowIndex+1);
		newRow.id=type+'Info';
		var cell=newRow.insertCell(0);
		cell.colSpan=2;
		cell.innerHTML=msgInfo.code;
		$I('#'+msgInfo.id).innerHTML=messagesInfo[type];
	}
};
DF.checkUserName=function(s){
	var msg=$I('#userNameMsg');
	userNameError=true;
 	if(s.value.length==0){
		msg.innerHTML=this.msgBox('يجب عليك أن تكتب اسم العضوية.','red',1,0,true).code;
	}
	else if(s.value.length<3){
		msg.innerHTML=this.msgBox('يجب أن يكون الإسم مكون من 3 أحرف على الأقل.','red',1,0,true).code;
	}
	else if(s.value.length>30){
		msg.innerHTML=this.msgBox('يجب أن يكون الإسم لا أكثر من 30 حرفاً.','red',1,0,true).code;
	}
	else if(s.value==parseInt(s.value)){
		msg.innerHTML=this.msgBox('لا يمكن استخدام اسماء تحتوي على أرقام فقط.','red',1,0,true).code;
	}
	else if(this.checkSymbols(s.value)!=1){
		msg.innerHTML=this.msgBox('لا يمكن استخدام هذا الرمز '+this.checkSymbols(s.value)+' في اسم العضوية.','red',1,0,true).code;
	}
	else{
		DF.ajax.play({
			'send':'type=checkUseUserName&name='+s.value,
			'func':function(){
				var obj=DF.ajax.oName,ac=DF.ajax.ac;
				if(obj.readyState==1){
					msg.innerHTML=DF.loadIcon();
				}
				else if(obj.readyState==4){
					var get=obj.responseText.split(ac);
					if(get&&get[0]=='none'){
						msg.innerHTML=DF.msgBox('اسم غير مستخدم ومتاح للتسجيل.','green',1,0,true).code;
						userNameError=false;
					}
					else if(get&&get[0]=='found'){
						msg.innerHTML=DF.msgBox('اسم الذي اخترت غير متاح, يجب ان تختار اسم آخر.','red',1,0,true).code;
					}
					else{
						msg.innerHTML=DF.msgBox('حدث خطأ أثناء تحقق بالاسم, مرجوا إعادة محاولة من جديد.','red',1,0,true).code;
					}
				}
			}
		});
	}
};
DF.checkUserPass1=function(s){
	var msg=$I('#userPass1Msg');
	userPass1Error=true;
	if(s.value.length==0){
		msg.innerHTML=this.msgBox('يجب عليك ان تكتب كلمة السرية.','red',1,0,true).code;
	}
	else if(s.value.length<6){
		msg.innerHTML=this.msgBox('لا يمكنك كتابة كلمة السرية اقل من 6 حروف.','red',1,0,true).code;
	}
	else if(s.value.length>24){
		msg.innerHTML=this.msgBox('لا يمكنك كتابة كلمة السرية اكثر من 24 حرف.','red',1,0,true).code;
	}
	else{
		msg.innerHTML=this.msgBox('كلمة السرية صالحة.','green',1,0,true).code;
		userPass1Error=false;
	}
};
DF.checkUserPass2=function(s){
	var msg=$I('#userPass2Msg');
	userPass2Error=true;
	if(s.value.length==0){
		msg.innerHTML=this.msgBox('يجب عليك ان تكتب تأكيد كلمة السرية.','red',1,0,true).code;
	}
	else if(s.form.regUserPass1.value!=s.value){
		msg.innerHTML=this.msgBox('كلمة السرية للتأكد غير مطابق لكلمة السرية الجديدة.','red',1,0,true).code;
	}
	else{
		msg.innerHTML=this.msgBox('إعادة كلمة السرية للتأكد صالحة.','green',1,0,true).code;
		userPass2Error=false;
	}
};
DF.checkUserEmail=function(s){
	var msg=$I('#userEmailMsg');
	userEmailError=true;
	if(s.value.length==0){
		msg.innerHTML=this.msgBox('يجب عليك ان تكتب عنوان بريد الالكتروني.','red',1,0,true).code;
	}
	else if(!this.checkEmail(s.value)){
		msg.innerHTML=this.msgBox('عنوان بريد الالكتروني الذي دخلت هو خاطيء.','red',1,0,true).code;
	}
	else{
		DF.ajax.play({
			'send':'type=checkUseUserEmail&email='+s.value,
			'func':function(){
				var obj=DF.ajax.oName,ac=DF.ajax.ac;
				if(obj.readyState==1){
					msg.innerHTML=DF.loadIcon();
				}
				else if(obj.readyState==4){
					var get=obj.responseText.split(ac);
					if(get&&get[0]=='none'){
						msg.innerHTML=DF.msgBox('بريد الكتروني صالح للتسجيل.','green',1,0,true).code;
						userEmailError=false;
					}
					else if(get&&get[0]=='found'){
						msg.innerHTML=DF.msgBox('بريد الالكتروني الذي اخترت موجود مسبقاً, نرجوا ان تختار واحد آخر.','red',1,0,true).code;
					}
					else{
						msg.innerHTML=DF.msgBox('حدث خطأ أثناء تحقق بالبريد الالكتروني, نرجوا إعادة محاولة من جديد.','red',1,0,true).code;
					}
				}
			}
		});
	}
};
DF.doRegister=function(frm){
	var foundError=false;
	if(userNameError){
		$I('#userNameMsg').innerHTML=this.msgBox('نرجوا ان تختار اسم مستخدم متاح للتسجيل','red',1,0,true).code;
		foundError=true;
	}
	if(userPass1Error){
		$I('#userPass1Msg').innerHTML=this.msgBox('نرجوا ان تختار كلمة السرية خاصة بك','red',1,0,true).code;
		foundError=true;
	}
	if(userPass2Error){
		$I('#userPass2Msg').innerHTML=this.msgBox('نرجوا ان تكتب إعادة كلمة السرية للتأكد','red',1,0,true).code;
		foundError=true;
	}
	if(userEmailError){
		$I('#userEmailMsg').innerHTML=this.msgBox('نرجوا ان تكتب بريد الكتروني خاص بك','red',1,0,true).code;
		foundError=true;
	}
	if(frm.regUserCountry.value.length==0){
		$I('#userCountryMsg').innerHTML=this.msgBox('نرجوا ان تختار دولة من قائمة الدول','red',1,0,true).code;
		foundError=true;
	}
	if(frm.regUserBrithDayYear.selectedIndex==0){
		$I('#userBrithDayMsg').innerHTML=this.msgBox('نرجوا أن تختار تاريخ ولادتك الصحيحة.','red',1,0,true).code;
		foundError=true;
	}
	if(!this.getChoosedRadio(frm.regUserSex)){
		$I('#userSexMsg').innerHTML=this.msgBox('يجب ان تختار الجنس','red',1,0,true).code;
		foundError=true;
	}
	if(!foundError){
		frm.submit();
	}
};
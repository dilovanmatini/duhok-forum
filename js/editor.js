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
if( !DF ){
	var DF = {};
}
function editorSizeStatus(){
	if( DMEditor.loaded === true ){
		var timer = 500, place = $I('#sizeDetailsPlace'), curSize = parseInt(DMEditor.getContent(true));
		$(place).html( curSize < 1000 ? curSize+" بايت" : DM.round( curSize / 1024, 2 )+" كيلو بايت" );
		$(place).css('color', (curSize > maxSize && userLevel < 4) ? 'red' : 'green');
		if( curSize > 2000 && curSize < 5000 ){
			timer = 750;
		}
		else if( curSize >= 5000 && curSize < 10000 ){
			timer = 1000;
		}
		else if( curSize >= 10000 && curSize < 25000 ){
			timer = 2000;
		}
		else if( curSize >= 25000 && curSize < 50000 ){
			timer = 3000;
		}
		else if( curSize >= 50000 ){
			timer = 5000;
		}
	}
	setTimeout("editorSizeStatus()", timer);
}
function setContent(frm){
 	if( DMEditor.loaded === true ){
		var message = DMEditor.getContent(), types = ['newtopic', 'edittopic', 'sendmsg', 'replymsg', 'sendpmtousers'];
		if( DMEditor.setting.editorMode == "HTML" ){
			alert("HTML الرجاء الغاء خاصية اظهار");
		}
		else if(types.inArray(type) && frm.subject.value.trim().length == 0){
			alert("لا يمكنك إدخال الموضوع بدون عنوان");
		}
		else if(message == '' || message.toLowerCase() == '<p>&nbsp;</p>' || message.toLowerCase() == '<p></p>'){
			alert("لا يمكنك إدخال النص بدون محتويات");
		}
		else if(userLevel < 4 && message.length > maxSize){
			alert("حجم النص أكبر من المساحة المخصصة لك - الرجاء التقليل من النص");
		}
		else{
			if(confirm("هل أنت متأكد من أنك تريد إدخال النص‌ ؟")){
				frm.message.value = message;
				exitPage = true;
				frm.submit();
			}
		}
	}
}
function beforeUnload( e ){
 	e = e || window.event;
	if( !exitPage && DMEditor && DMEditor.getContent().length > 0 ){
		e.returnValue="الذهاب الى صفحة أخرى سيخسر النص الجديد الذي ادخلته\r\n\r\n هل أنت متأكد من رغبتك في الذهاب الى صفحة أخرى ؟";
	}
}
function chkReset( url ){
	if( confirm("هل أنت متأكد أنك تريد إعادة النص الأصلي ؟") ){
		exitPage = true;
		window.location=url;
	}
}
$(function(){
	editorSizeStatus();
});
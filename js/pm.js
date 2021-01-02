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
DF.chkBox=function(frm,s){
	var el=frm.elements;
	if(typeof document.body.flag=="undefined"){
		document.body.flag=false;
	}
	if(!document.body.flag){
		for(var x=0,y=0;x<el.length;x++){
			el[x].checked=true;
			if(el[x].type=="checkbox"){
				y++;
				this.chkTrClass(el[x],el[x].value,$I("#bg"+el[x].value).value);
			}
		}
		document.body.flag=true;
		if(y==0){
			alert("لا توجد اي رسالة بالصفحة");
		}
		s.value='إلغاء تحديد الكل';
	}
	else{
		for(var x=0;x<el.length;x++){
			el[x].checked=false;
			if(el[x].type=="checkbox"){
				this.chkTrClass(el[x],el[x].value,$I("#bg"+el[x].value).value);
			}
		}
		document.body.flag=false;
		s.value='تحديد الكل';
	}
};
DF.chkTrClass=function(s,id,name){
	var frm=s.form;
	if(s.checked){
		$I('#tr'+id).className='select';
	}
	else{
		$I('#tr'+id).className=name;
	}
};
DF.checkMovePM=function(frm){
	if(confirm("هل أنت متأكد بأن تريد نقل رسائل المختارة الى مجلد المختار ؟")){
		frm.submit();
	}
};
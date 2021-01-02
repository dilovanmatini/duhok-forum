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
DF.checkRowClass=function(s,id,cname){
	var row=$I('#row'+id);
	row.className=(s.checked ? 'select': (cname ? cname : 'fixed'));
};
DF.checkAllBox=function(s){
	var el=s.form.elements,id=0;
	if(typeof document.body.flag=='undefined'){
		document.body.flag=false;
	}
	if(!document.body.flag){
		for(var x=0,y=0;x<el.length;x++){
			el[x].checked=true;
			if(el[x].type=='checkbox'){
				y++;
				id=parseInt(el[x].value);
				this.checkRowClass(el[x],id);
			}
		}
		if(y>0){
			document.body.flag=true;
			s.value="إلغاء التحديد";
		}
	}
	else{
		for(var x=0;x<el.length;x++){
			el[x].checked=false;
			if(el[x].type=="checkbox"){
				id=parseInt(el[x].value);
				this.checkRowClass(el[x],id);
			}
		}
		document.body.flag=false;
		s.value="تحديد الكل";
	}
};
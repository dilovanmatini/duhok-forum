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
DF.onlineInForums=function(){
	var obj=DF.ajax2.connect();
	DF.ajax2.play({
		'send':'type=onlineinforums&forums='+onf,
		'func':function(){
			if(obj.readyState==4){
				if(obj.responseText!=''&&obj.responseText.indexOf('e')==-1) DF.setOnlineToForums(obj.responseText);
			}
		}
	},obj);
};
DF.setOnlineToForums=function(text){
	var arr=text.split('|'),place=false;
	for(var x=0;x<arr.length;x++){
		var c=arr[x].split(':');
		place=$I('#onlinef'+c[0]);
		if(place) place.innerHTML='<nobr>'+c[1]+'</nobr>';
	}
};
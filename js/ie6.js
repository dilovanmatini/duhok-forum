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
if(!DF){var DF={};}

$(function(){
	// check main menu
	$('.as-sub-menu').css('display','none');
	var r=$('.as-sub-menu a[main=1]'),t='<table cellpadding="0" cellspacing="0" style="margin-top:4px"><tr>';
	for(var x=0;x<r.length;x++){
		var a=r[x];
		if(x>0){
			t+='<td style="padding:0 6px"><img src="styles/menu/menu-item.png" height=\"25\" border="0"></td>';
		}
		t+='<td class="asACWhite"><a href="'+a.href+'">'+(a.href.indexOf('pm.php')>=0 ? 'الرسائل' : (a.href.indexOf('index.php')>=0  ? '<nobr>'+a.innerText+'</nobr>' : a.innerText))+'</a></td>';
	}
	t+='</tr></table>';
	$('.as-main-menu').html(t);
	
	// check moderator tools
	var MT1=$I('#MTContent');
	if(MT1){
		var MTdoCreate=function(){
			var MT=document.createElement('div');
			MT.id='MTPlace2';
			MT.style.position='absolute';
			MT.style.right='20px';
			MT.className='asTopHeader';
			MT.innerHTML=$('#MTContent').html();
			document.body.appendChild(MT);
			MTSetXY();
		};
		var MTSetXY=function(){
			var el=$I('#MTPlace2'),doc=((document.compatMode&&document.compatMode!='BackCompat') ? document.documentElement : document.body);
			if(el){
				el.style.top=(doc.scrollTop+doc.clientHeight-el.offsetHeight)+'px';
			}
		};
		MTdoCreate();
		window.onscroll=MTSetXY;
		$('#MTContent').html('');
	}
});
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

var DF={
	'rc':'[>:r:<]',
	'cc':'[>:c:<]',
	'ajax':{
		'ac':'[>:DT:<]',
		'url':'ajax.php',
		'oName':null,
		'method':'POST',
		connect:function(){
			var a=false;
			try{
				a=new XMLHttpRequest();
			}
			catch(e){
				try{
					a=new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e){
					try{
						a=new ActiveXObject("Microsoft.XMLHTTP")
					}
					catch(e){
						a=false;
					}
				}
			}
			this.oName=a;
			return a;
		},
		doPost:function(a){
			a.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
		},
		play:function(s){
			if(s){
				var o=this.connect();
				if(o){
					if(!s.url) s.url=this.url;
					if(!s.method) s.method=this.method;
					o.open(s.method,s.url,true);
					if(typeof s.post == "undefined"||s.post) this.doPost(o);
					o.onreadystatechange=s.func;
					o.send(s.send);
				}
			}
		}
	},
	'ajax2':{
		'ac':'[>:DT:<]',
		'url':'ajax.php',
		'method':'POST',
		connect:function(){
			var a=false;
			try{a=new XMLHttpRequest();}
			catch(e){
				try{a=new ActiveXObject("Msxml2.XMLHTTP");}
				catch(e){
					try{a=new ActiveXObject("Microsoft.XMLHTTP");}
					catch(e){a=false;}
				}
			}
			return a;
		},
		doPost:function(a){
			a.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=utf-8');
		},
		play:function(s,o){
			if(s&&o){
				if(!s.url) s.url=this.url;
				if(!s.method) s.method=this.method;
				o.open(s.method,s.url,true);
				if(typeof s.post == "undefined"||s.post) this.doPost(o);
				o.onreadystatechange=s.func;
				o.send(s.send);
			}
		}
	},
	browse:function(){
		var a={
			n:navigator,
			u:navigator.userAgent,
			v:navigator.appVersion,
			p:navigator.appName,
			s:navigator.platform,
			name:"",
			ver:"",
			sys:"",
			ie:false,
			opera:(/(Opera)[ \/]([\d\.]+)/),
			netscape:(/(Netscape)\d*\/([\d\.]+)/),
			msie:(/(MSIE) ([\d\.]+)/),
			safari:(/(Safari)\/([\d\.]+)/),
			konqueror:(/(Konqueror)\/([\d\.]+)/),
			gecko:(/(Gecko)\/(\d+)/),
			win:(/^(Win)/),
			mac:(/^(Mac)/),
			sun:(/^(SunOS)/),
			linux:(/^(Linux)/),
			unix:(/^(Unix)/)
		};
		if(a.opera.test(a.u)||a.netscape.test(a.u)||a.msie.test(a.u)||a.safari.test(a.u)||a.konqueror.test(a.u)||a.gecko.test(a.u)){
			a.name=RegExp.$1.toLowerCase();
			a.ver=RegExp.$2;
		}
		else{
			if(a.p == "Netscape"&&a.v.charAt(0) == "4"){
				a.name="netscape4";
				a.ver=parseFloat(a.v);
			}
			else{
				a.name="unknown";
				a.ver=0;
			}
		}
		if(a.name == "netscape"){
			switch(a.p){
				case "Microsoft Internet Explorer":
					a.name="msie";
					a.ver=a.msie.exec(a.u)[2];
				break;
				case "Netscape":
					a.name="gecko";
					a.ver=a.gecko.exec(a.u)[2];
			}
		}
		if(a.win.test(a.s)||a.mac.test(a.s)||a.sun.test(a.s)||a.linux.test(a.s)||a.unix.test(a.s)) a.sys=RegExp.$1.toLowerCase();
		else a.sys=a.s;
		if(a.name == "msie"&&a.ver>=5) a.ie=true;
		return{
			ie:a.ie,
			name:a.name,
			version:a.ver,
			system:a.sys
		};
	},
	choose:function(a,b,t){
		if(a == b){
			var v=new Array();
			v['s']="selected";
			v['c']="checked";
			return v[t];
		}
	},
	key:function(ev){
		var e=ev||window.event,k=(e.keyCode?e.keyCode:(e.which?e.which:e.charCode));
		return k;
	},
	getChoosedRadio:function( radio ){
		if( typeof radio.value == "undefined" ){
			for( var x = 0; x < radio.length; x++ ){
				if( radio[x].type == "radio" && radio[x].checked ) return radio[x].value;
			}
		}
		return false;
	},
	highlight:function(t,d){
		var db=document.body,l=DF.$('blackDrop'),w=this.browse();
		d=(typeof d!="undefined"&&!isNaN(parseInt(d))?(w.ie?parseInt(d):(parseInt(d)/100)):(w.ie?75:(75/100)));
		if(!l){
			l=document.createElement("div");
			l.id="blackDrop";
			l.style.visibility="hidden";
			l.style.position="absolute";
			l.style.zIndex=1000;
			l.style.left="0px";
			l.style.top="0px";
			l.style.width="100%";
			l.style.height=db.scrollHeight+"px";
			l.style.backgroundColor="black";
			if(w.ie) l.style.filter+="Alpha(style=0,opacity="+d+")";
			else l.style.opacity=d;
			db.appendChild(l);
		}
		if(t) l.style.visibility="visible";
		else l.style.visibility="hidden";
	},
	checkEmail:function(email){
		if((/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/).test(email)){
			if(email.toLowerCase().indexOf('www.')>=0) return false;
			else return true;
		}
		else return false;
	},
	round:function(n,p){
		if(!p||p == 0) p=1;
		var pow,ceil,floor,dCeil,dFloor;
		pow=Math.pow(10,p);
		ceil=Math.ceil(n*pow)/pow;
		floor=Math.floor(n*pow)/pow;
		pow=Math.pow(10,p+1);
		dCeil=pow*(ceil-n);
		dFloor=pow*(n-floor)+(n<0 ? -1 : 1);
		if(dCeil>=dFloor) return floor;
		else return ceil;
	},
	$:function(){
		var a=arguments;
		var g=function(d){
			var o=false;
			if(d){
				try{
					o=document.getElementById(d);
				}
				catch(e){
					try{
						o=document.all[d];
					}
					catch(e){
						try{
							document.layers[d];
						}
						catch(e){
							o=false;
						}
					}
				}
			}
			return o;
		};
		if(a.length == 1) return g(a[0]);
		else if(a.length>0){
			var l=new Array();
			for(var x=0;x<a.length;x++) l[a[x]]=g(a[x]);
			return l;
		}
		else return false;
	},
	$S:function(s){
		if(typeof s == 'string') s=DF.$(s);
		return s.options[s.selectedIndex].value;
	}
};
DF.checkLink = function(file,el,added){
	var link="";
	if(!el) el=new Array();
	if(!added) added=new Array();
	for(var x=0;x<el.length;x+=2){
		if(!added.inArray(el[x])&&el[x+1]!=''&&el[x+1]!=0){
			link+="&"+el[x]+"="+el[x+1];
		}
	}
	for(var x=0;x<added.length;x+=2){
		if(added[x+1]!=''&&added[x+1]!=0){
			link+="&"+added[x]+"="+added[x+1];
		}
	}
	if(file.indexOf("?") == -1&&link!=''){
		file+="?";
		link=link.substring(1);
	}
	link=file+link;
	return link;
};
DF.checkRowClass=function(s,id,className,rowName){
	var row=$I('#'+(rowName ? rowName : 'row')+id);
	row.className=(s.checked ? 'select' : (className ? className : 'fixed'));
};
DF.repClassByVal=function(val1,val2,el,newClass){
	var cell=$I('#'+el);
	if(!DF.oldClasses){
		DF.oldClasses=new Array();
	}
	if(!DF.oldClasses[el]){
		DF.oldClasses[el]=cell.className;
	}
	if(cell){
		if(val1 == val2){
			cell.className=DF.oldClasses[el];
		}
		else{
			cell.className=newClass;
		}
	}
};
DF.checkSymbols=function(str){
	var bads=new Array("\"","@","'","|","\\",".","ـ","[","]","{","}","(",")","<",">","?","؟",",","~","!","#","$","%","^","&","*","=","+","_","-","`","/",":",";","،","‘","÷","×","؛","’");
	for(var x in bads){
		if(str.indexOf(bads[x])>=0){
			return bads[x];
		}
	}
	return 1;
};
DF.basicPagingGo=function(s){
	var pg=s.options[s.selectedIndex].value;
	document.location=link+"pg="+pg;
};
DF.doPreviewImage = function(url){
	if(!url || url == ''){
		return;
	}
	DM.container.open({
		header: 'عرض وسام بعرض كامل',
		body: '<span style="padding:0 40px;"><img src="'+url+'" onload=\"DM.container.dimension();\"></span>',
		buttons: [
			{
				value: 'إغلاق',
				click: function(){
					DM.container.close();
				}
			}
		]
	});
};
DF.hideElement=function(id){
	var el=$I('#'+id);
	if(el){
		el.style.visibility='hidden';
		el.style.position='absolute';
		el.style.top='2px';
		el.style.left='2px';
	}
};
DF.showElement=function(id){
	var el=$I('#'+id);
	if(el){
		el.style.visibility='visible';
		el.style.position='';
	}
};
DF.changeMyPic=function(s){
	var el=$I('#myPicChanfeIcon');
	if(el) el.style.visibility=(s ? 'visible' : 'hidden');
};
DF.menu = {
	obj:false,menuText:new Array(),objId:0,objType:false,
	load:function(other){
		this.menuText[1]=['رقم العضوية',''];
		this.menuText[2]=['عدد مشاركات',''];
		this.menuText[3]=['نقاط التميز',''];
		this.menuText[7]=['ارسل رسالة خاصة للعضو','editor.php?type=sendpm&u={u}'];
		this.menuText[12]=['أضف عضو صديق لك','','',0,'DF.friends.add({u});'];
		this.menuText[8]=['منع عضو من إتصال بك','','',0,'DF.friends.block({u});'];
		this.menuText[4]=['مراسلاتك مع العضو','pm.php?mail=u&u={u}'];
		this.menuText[5]=['مشاركات العضو','yourposts.php?auth={u}'];
		this.menuText[6]=['مواضيع العضو','yourtopics.php?auth={u}'];
		this.menuText[9]=['فتح عضوية في إطار جديد','profile.php?u={u}','',1];
		this.menuText[10]=['فتح منتدى في إطار جديد','forums.php?f={f}','',1];
		this.menuText[11]=['فتح موضوع في إطار جديد','topics.php?t={t}','',1];
		this.menuText[20]=['أضف موضوع جديد','editor.php?type=newtopic&f={f}&src='+escape(self)+''];
		this.menuText[21]=['ارسل رسالة للمنتدى','editor.php?type=sendpm&u=-{f}&src='+escape(self)+''];
		this.menuText[22]=['مواضيعك في المنتدى','forums.php?f={f}&auth='+userId+''];
		this.menuText[30]=['أضف رد للموضوع','editor.php?type=newpost&t={t}&src='+escape(self)+''];
		this.menuText[31]=['تعديل الموضوع','editor.php?type=edittopic&t={t}&src='+escape(self)+''];
		this.menuText[32]=['أرسل موضوع لصديقك','sendtopic.php?t={t}'];
		this.menuText[33]=['أضف موضوع للمفضلة','favorite.php?type=add&t={t}'];
		this.menuText[34]=['طباعة موضوع','print.php?t={t}'];
		this.menuText[35]=['ردودك فقط في الموضوع','topics.php?t={t}&u='+userId+''];
		this.menuText[36]=['أرسل رسالة لصاحب الموضوع','editor.php?type=sendpm&u={o}&t={t}&src='+escape(self)+''];
		if(other){
			for(var x=0;x<other.length;x++){
				this.menuText[other[x][0]]=eval(other[x][1]);
			}
		}
	},
	create:function(){
		if(!this.obj){
			var obj=document.createElement('div'),retFlase=function(){return false};
			obj.id='menubarObj';
			obj.className='menubarBox asS12';
			obj.oncontextmenu=retFlase;
			obj.onselectstart=retFlase;
			document.body.appendChild(obj);
			this.obj=$I('#menubarObj');
		}
		DF.menu.msgBox("<img src=\""+progressUrl+"\" vspace=\"4\" border=\"0\"><br>رجاءاً انتظر ...");
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=menubarContents&method='+this.objType+'&id='+this.objId,
			success: function(res){
				var rows = eval(res);
				if(rows){
					code = "<table dir=\"rtl\" width=\"155\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">";
					for(var x = 0; x < rows.length; x++){
						cells = rows[x];
						if(cells[0] == -1){
							code += "<tr><td class=\"menubarOut\" style=\"padding:0px\" colspan=\"2\"><hr style=\"width:96%;height:1px;\"></td></tr>";
						}
						else{
							code += DF.menu.addField(cells[0], cells[1], cells[2], cells[3], cells[4]);
						}
					}
					code += "</table>";
					DF.menu.obj.innerHTML = code;
					DF.menu.setMenubarId(DF.menu.obj);
					DF.menu.hideSelectTag('hidden');
				}
				else{
					DF.menu.msgBox("<font color=\"red\"><img src=\""+errorUrl+"\" vspace=\"4\" border=\"0\"><br>حدث خطأ أثناء التحميل.</font>", 2000);
				}
			},
			error: function(){
				DF.menu.msgBox("<font color=\"red\"><img src=\""+errorUrl+"\" vspace=\"4\" border=\"0\"><br>حدث خطأ أثناء التحميل.</font>", 2000);
			}
		});
	},
	msgBox:function(text,sec){
		this.obj.innerHTML="<table width=\"140\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\"><tr><td class=\"menubarOut asS12 asCenter\">"+text+"</td></tr></table>";
		DF.menu.setMenubarId(this.obj);
		if(sec) setTimeout("DF.menu.obj.style.visibility='hidden';",sec);
	},
	setMenubarId:function(obj){
		var children=(DF.browse().ie?'children':'childNodes');
		for(var x=0;x<obj[children].length;x++){
			obj[children][x].id='menubar';
			this.setMenubarId(obj[children][x]);
		}
	},
	addField:function(textId,otherText,highlight,disabled,o){
		var code,other='',r=this.menuText[textId];
		if(r){
			if(r[4]&&disabled == 0){
				var func=r[4].replace("{"+this.objType+"}",this.objId);
				if(func) other+=" onclick=\""+func+"DF.menu.obj.style.visibility='hidden';\"";
			}
			else{
				var url=r[1].replace("{"+this.objType+"}",this.objId);
				if(o) url=url.replace("{o}",o);
				if(url!=''&&disabled == 0){
					var confMsg=(r[2] ? r[2] : ''),target=(r[3] ? r[3] : '');
					other+=" onClick=\"DF.menu.gotoLink('"+confMsg+"','"+url+"','"+target+"',event);\"";
				}
			}
			if(highlight == 1){
				other+=" onMouseOver=\"this.style.backgroundColor='"+menubarHighlight+"';\"  onMouseOut=\"this.style.backgroundColor='';\"";
			}
			var color=(disabled == 1 ? 'silver' : 'black');
			code="<tr"+other+">"+
			"<td class=\"asS12\" style=\"padding-right:5px;cursor:default;color:"+color+"\"><nobr>"+r[0]+"</nobr></td>"+
			"<td class=\"asS12 asCenter\" style=\"width:10%;padding-right:5px;padding-left:5px;cursor:default;color:"+color+"\"><nobr>"+otherText+"</nobr></td></tr>";
			return code;
		}
	},
	gotoLink:function(msg,url,target,ev){
		var con=true;
		if(msg!='') con=confirm(msg);
		if(con){
			if(target&&target == 1) this.newTabLink(url);
			else document.location=url;
		}
	},
	newTabLink:function(url){
		var l=url.split('?'),l,g;
		var frm=document.createElement('form');
		frm.action=l[0];
		frm.target='_blank';
		document.body.appendChild(frm);
		if(l[1]){
			l=l[1].split('&');
			for(var x=0;x<l.length;x++){
				g=l[x].split('=');
				var inp=document.createElement('input');
				inp.type='hidden';
				inp.name=g[0];
				inp.value=g[1];
				frm.appendChild(inp);
			}
		}
		frm.submit();
	},
	checkElements:function(){
		if(userLevel>0){
			var el=document.getElementsByTagName('a');
			for(var x=0;x<el.length;x++){
				if((/[u|f|t]+[0-9]/).test(el[x].id)){
					el[x].oncontextmenu=DF.menu.context;
				}
			}
		}
	},
	hideSelectTag:function(status){
		var el=document.getElementsByTagName('select');
		for(var x=0;x<el.length;x++){
			if(el[x].className == 'dark'&&this.objType == 'f'){
				el[x].style.visibility=status;
			}
		}
	},
	context:function(){
		var menu = DF.menu;
		menu.objId = this.id.match(/([0-9]+)/g);
		menu.objType = this.id.substring(0, 1);
 		menu.create();
		menu.obj.style.top = ($(this).offset().top + 15)+"px";
		menu.obj.style.left = $(this).offset().left+"px";
		menu.obj.style.visibility = 'visible';
		return false;
	},
	click:function(ev){
		var menu=DF.menu,e=ev||window.event,ie=DF.browse().ie,obj=(ie ? e.srcElement : e.target);
		if(obj&&!(/menubar+(.*)/).test(obj.id)&&menu.obj){
			menu.obj.style.visibility='hidden';
			DF.menu.hideSelectTag('visible');
		}
	}
};
DF.msgBox=function(text,color,mp,width,logo,align){
	var colorsCode=new Array(),obj,mp=(mp?mp:10),code=textCode="",id="v"+Math.random().toString().substring(2,6)+"v";
	colorsCode['gray']=new Array('#666666','#ffffff','loading');
	colorsCode['yellow']=new Array('#666600','#fffaca','alert');
	colorsCode['blue']=new Array('#000066','#dce3fd','info');
	colorsCode['green']=new Array('#116600','#d5ffcd','succeed');
	colorsCode['red']=new Array('#660000','#ffced1','error');
	if(logo){
		if(color == 'gray'){
			textCode=""+
			"<td dir=\"rtl\" style=\"padding:"+mp+"px;background-color:"+colorsCode[color][1]+"\">"+
			"<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">"+
			"	<tr>"+
			"		<td align=\"center\"><img src=\"images/icons/"+colorsCode[color][2]+".gif\" border=\"0\"></td>"+
			"	</tr>"+
			"	<tr>"+
			"		<td id=\""+id+"\" class=\"asCenter asS12\" style=\"padding-bottom:6px;color:"+colorsCode[color][0]+"\">"+text+"</td>"+
			"	</tr>"+
			"</table>"+
			"</td>";
		}
		else{
			textCode=""+
			"<td dir=\"rtl\" style=\"padding:"+mp+"px;background-color:"+colorsCode[color][1]+"\">"+
			"<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">"+
			"	<tr>"+
			"		<td><img src=\"images/icons/"+colorsCode[color][2]+".gif\" style=\"margin-left:"+(mp+2)+"px\" hspace=\"4\" border=\"0\"></td>"+
			"		<td id=\""+id+"\" class=\"asS12\" style=\"color:"+colorsCode[color][0]+"\">"+text+"</td>"+
			"	</tr>"+
			"</table>"+
			"</td>";
		}
	}
	else{
		textCode="<td id=\""+id+"\" class=\"asS12\" dir=\"rtl\" style=\"padding:"+mp+"px;background-color:"+colorsCode[color][1]+";color:"+colorsCode[color][0]+"\">"+text+"</td>";
	}
	code=""+
	"<table dir=\"ltr\""+(width&&width>0 ? " width=\""+width+"%\"" : "")+" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:"+mp+"px;\" border=\"0\">"+
	"	<tr>"+
	"		<td style=\"background:url(images/boxes/"+color+"_top_left.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>"+
	"		<td style=\"background:url(images/boxes/"+color+"_top.gif) repeat-x 0px 0px;height:5px;\"></td>"+
	"		<td style=\"background:url(images/boxes/"+color+"_top_right.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>"+
	"	</tr>"+
	"	<tr>"+
	"		<td style=\"background:url(images/boxes/"+color+"_left.gif) repeat-y 0px 0px;width:5px;\"></td>"+
	textCode+
	"		<td style=\"background:url(images/boxes/"+color+"_right.gif) repeat-y 0px 0px;width:5px;\"></td>"+
	"	</tr>"+
	"	<tr>"+
	"		<td style=\"background:url(images/boxes/"+color+"_down_left.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>"+
	"		<td style=\"background:url(images/boxes/"+color+"_down.gif) repeat-x 0px 0px;height:5px;\"></td>"+
	"		<td style=\"background:url(images/boxes/"+color+"_down_right.gif) no-repeat 0px 0px;width:5px;height:5px;\"></td>"+
	"	</tr>"+
	"</table>"+
	"";
	if(align) code="<center>"+code+"</center>";
	obj={'id':id,'code':code};
	return obj;
};
DF.loadIcon=function(){
	var code="&nbsp;<img src=\"images/icons/loading.gif\" border=\"0\">&nbsp;";
	return code;
};
DF.checkAllByCheck=function(s,name){
	var el=s.form.elements,check=s.checked;
	for(var x=0;x<el.length;x++){
		if(el[x].type == 'checkbox'){
			el[x].checked=check;
		}
	}
};
DF.fieldBox=function(text,width){
	var code=""+
	"<table dir=\"ltr\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">"+
	"	<tr>"+
	"		<td style=\"background:url(images/boxes/input1.gif) no-repeat 0px 0px;width:4px;height:30px;\"></td>"+
	"		<td style=\"background:url(images/boxes/input2.jpg) repeat-x 0px 0px;height:30px"+(width&&width>0 ? ";width:"+width+"px" : "")+"\" dir=\"rtl\">"+text+"</td>"+
	"		<td style=\"background:url(images/boxes/input3.gif) no-repeat 0px 0px;width:4px;height:30px;\"></td>"+
	"	</tr>"+
	"</table>";
	return code;
};
DF.input=function(size,att,ret){
	var input=code="";
	if(!att.inArray('type')){
		att.add('type','text');
	}
	for(var x=0;x<att.length;x+=2){
		input+=" "+att[x]+"=\""+att[x+1]+"\"";
	}
	code=this.fieldBox("<input"+input+" style=\"width:"+size+"px;border:gray 0px solid;background:none transparent scroll repeat 0% 0%\">");
	if(ret){
		return code;
	}
	else{
		document.write(code);
	}
};
DF.trashCookie = function(){
	if(confirm("هل أنت متأكد بأن تريد حذف كوكيز وخروجك من المنتدى ؟")){
		var date = new Date();
		date.setTime(date.getTime() - 1);
		document.cookie = 'login_user_name=;login_user_pass=; expires='+date.toGMTString();
		$G('index.php');
	}
};
DF.checkTHLink=function(){
	var el=document.getElementsByTagName('th');
	for(var x=0;x<el.length;x++){
		if(el[x].className == 'asTHLink'){
			el[x].onmouseout=function(){
				this.className='asTHLink';
			};
			el[x].onmouseover=function(){
				this.className='asTHLinkOver';
			};
		}
	}
};
DF.smOpen=function(name){
	var sm=eval('sm'+name);
	if(!sm.name) sm.name=name;
	if(!sm.oIndex) sm.oIndex=new Array();
	if(!sm.oText) sm.oText=new Array();
	if(!sm.isInput) sm.isInput=false;
	if(!sm.isSingle) sm.isSingle=(sm.isInput ? true : false);
	if(!sm.defValue) sm.defValue='';
	if(!sm.defIndex) sm.defIndex=0;
	if(!sm.isHtml) sm.isHtml=false;
	if(!sm.onChange) sm.onChange='';
	if(!sm.classes) sm.classes='';
	if(!sm.table) sm.table=$I('#smTab'+name);
	if(!sm.optionsPanel) sm.optionsPanel=false;
	if(!sm.defText) sm.defText=(sm.isInput ? false : $I('#defText'+name));
	if(!sm.inpValue) sm.inpValue=$I('#inpValue'+name);
	if(!sm.arrow) sm.arrow=$I('#smArrow'+name);
	if(!sm.colorBorder) sm.colorBorder='#aaaaaa';
	if(!sm.colorOut) sm.colorOut='#fbfbfb';
	if(!sm.colorOver) sm.colorOver='#dbdcdd';
	if(sm.arrow.className == 'arrowDown'){
		if(!sm.panel){
			$('#smDiv'+sm.name).append('<div id="smPanel'+sm.name+'" class="smPanel" style="'+(sm.width>0 ? 'width:'+sm.width+'px;' : '')+'border:#aaaaaa 1px solid;"></div>');
			sm.panel=$I('#smPanel'+sm.name);
			if(!DF.smElements) DF.smElements=new Array();
			if(!DF.smElements.inArray(name)) DF.smElements.add(name);
		}
		var overFlow=(sm.width>0 ? " style=\"width:"+(sm.width-24)+";overflow-x:hidden\"" : "");
		var classes=(sm.classes!='' ? " class=\""+sm.classes+"\"" : "");
		var text="<table id=\"optionsPanel"+name+"\" width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">";
		for(var x=0;x<sm.oText.length;x++){
			var index=(sm.isSingle ? sm.oText[x] : sm.oIndex[x]),defColor=sm.colorOut,border=(x>0 ? "border-top:"+sm.colorBorder+" 1px solid;" : "");
			if(sm.inpValue.value == index){
				defColor=sm.colorOver;
				sm.defIndex=x;
			}
			text+="<tr><td"+classes+" onclick=\"DF.smClose('"+name+"',"+(x+1)+");"+sm.onChange+"\" onmouseout=\"DF.smOnMouse('"+name+"','out',this,"+x+");\" onmouseover=\"DF.smOnMouse('"+name+"','over',this,"+x+");\" style=\""+border+"background-color:"+defColor+"\"><div"+overFlow+"><nobr>"+(sm.isHtml ? DF.smHtmlspecialcharsDeCode(sm.oText[x]) : sm.oText[x])+"</div></nobr></td></tr>";
		}
		if(x == 0) text+="<tr><td class=\"asS11\" style=\"text-align:center;color:gray;background-color:"+sm.colorOut+"\"><i>لا توجد خيارات</i></td></tr>";
		text+="</table>";
		sm.panel.style.visibility='visible';
		sm.panel.innerHTML=text;
		sm.panel.style.height=(sm.panel.offsetHeight<=300 ? sm.panel.offsetHeight : 300)+'px';
		sm.panel.style.top=sm.table.offsetHeight+'px';
		sm.panel.style.right='1px';
		sm.optionsPanel=$I('#optionsPanel'+name);
		sm.arrow.className='arrowUp';
		document.body.smElement=sm;
		$(document).click(function(event){
			var target = event.target, sm = document.body.smElement, place1 = sm.panel.element, place2 = sm.table;
			if( target != place1 && !DM.isAncestor(place1, target) && target != place2 && !DM.isAncestor(place2, target) ){
				sm.panel.style.visibility = 'hidden';
				sm.panel.style.top = '2px';
				sm.panel.style.left = '2px';
				sm.arrow.className = 'arrowDown';
				DF.smCloseAll(sm.name);
			}
		});
		DF.smCloseAll(name);
		DF.smSetScroll(name);
	}
	else{
		sm.panel.style.visibility='hidden';
		sm.panel.style.top='2px';
		sm.panel.style.left='2px';
		sm.arrow.className='arrowDown';
	}
};
DF.smClose=function(name,x){
	var sm=eval('sm'+name);
	if(x&&x>0){
		x--;
		sm.inpValue.value=(sm.isSingle ? sm.oText[x] : sm.oIndex[x]);
		if(!sm.isInput) sm.defText.innerHTML=(sm.isHtml ? DF.smHtmlspecialcharsDeCode(sm.oText[x]) : sm.oText[x]);
	}
	sm.panel.style.visibility='hidden';
	sm.panel.style.top='2px';
	sm.panel.style.left='2px';
	sm.arrow.className='arrowDown';
};
DF.smCloseAll=function(name){
	var el=DF.smElements,sm;
	for(var x=0;x<el.length;x++){
		if(el[x]!=name){
			DF.smClose(el[x]);
		}
	}
};
DF.smOnMouse=function(name,type,s,x){
	var sm=eval('sm'+name);
	if(type == 'over'){
		s.style.backgroundColor=sm.colorOver;
	}
	else{
		var index=(sm.isSingle ? sm.oText[x] : sm.oIndex[x]);
		s.style.backgroundColor=(sm.inpValue.value == index ? sm.colorOver : sm.colorOut);
	}
};
DF.smSetScroll=function(name){
	var sm=eval('sm'+name),count=sm.oText.length,height=sm.optionsPanel.offsetHeight,scroll=Math.ceil((height/count)*sm.defIndex);
	sm.panel.scrollTop=scroll;
};
DF.smHtmlspecialcharsDeCode=function(text){
 	var chars={
		'de':['&','"',"'",'<','>'],
		'en':[/&amp;/g,/&quot;/g,/&#039;/g,/&lt;/g,/&gt;/g]
	};
 	for(var x=0;x<chars.de.length;x++){
		text=text.replace(chars.en[x],chars.de[x]);
	}
	return text;
};
DF.picture=function(arr){
	var ex,file,pic=arr.picture,size=(arr.size ? arr.size : 100),base=(arr.base === true ? true : false),rand=(arr.rand === false ? false : true);
	if(arr.picture!=''){
		ex=arr.picture.split("|");
		if(base) file=ex[0];
		else{
			var withRand=(rand ? "?x="+ex[1] : "");
			file="images/upics/"+(size>0 ? size+"/" : "")+ex[0]+withRand;
		}
		return file;
	}
};
DF.picError=function(size,type){
	var error,size=(typeof size!='undefined' ? size : 100);
	if(type&&type == 'src') error="images/upics/"+(size>0 ? size+"/" : "")+"default.gif";
	else error=" onerror=\"this.src='images/upics/"+(size>0 ? size+"/" : "")+"default.gif';\"";
	return error;
};
DF.friends = {
	'add': function(id, set){
		DM.container.open({
			header: 'أضف عضو صديق لك',
			body: '<div class="asCenter"><img src="images/icons/loading2.gif"></div>',
			buttons: [
				{
					value: 'إغلاق',
					click: function(){
						DM.container.close();
					}
				}
			]
		});
		if(set){
			this.set(id);
		}
		else{
			this.get(id);
		}
	},
	'get': function(id){
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=getAddFriend&id='+id,
			success: function(res){
				var text = '', buttons=[], padding = 25;
				var u = (res != '') ? eval(res) : false;
				if(u && u.length == 3){
					var name = u[0], pic = u[1], status = u[2], subtext;
					if(status == 1) text = DF.friends.error("حدث خطأ<br>ربما رقم العضوية غير صحيحة.");
					else if(status == 2) text = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>لأن أنت تطلب طلب الصداقة لعضويتك الشخصية وهذا غير متاح في نظامنا.");
					else if(status == 3) text = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب ان العضوية التي تطلب منها هي مقفلة.");
					else{
						if(status == 4) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب أن صاحب العضوية قام بمنع إستقبال طلبات الصداقة للعضوية.");
						else if(status == 5) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب أن صاحب العضوية قام بمنعك من ارسال طلبات.");
						else if(status == 6) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب وجود منع على العضو من جانبك<br>لإرسال طلب الصداقة, يجب عليك بالأول أن تزيل المنع على العضو<br>لإزالة المنع <a href=\"friends.php?scope=block&u="+id+"\">انقر هنا</a>");
						else if(status == 7) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب ان صداقة ما بينك وبينه هي موجودة حالياً.");
						else if(status == 8) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب تم تقديم هذا الطلب من قَبل (طلبك تحت الإنتظار حالياً).");
						else if(status == 9) subtext= DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب هو قام بتقديم هذا الطلب من قَبل (طلبه تحت إنتظار موافقتك حالياً)<br>للذهاب الى قائمة طلبات المنتظرة <a href=\"friends.php?scope=wait&u="+id+"\">انقر هنا</a>");
						else if(status == 10) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب رفض طلبك السابق من نفس العضو<br>للموافقة على طلبك, إرسل رساله له لكي يوافق على طلبك السابق.");
						else if(status == 11) subtext = DF.friends.error("لا يمكنك تطلب طلب صداقة<br>بسبب وجود طلبه المرفوض من أنت<br>للموافقة على طلبه, إذهب الى صفحة <a href=\"friends.php?scope=inref&u="+id+"\">طلباتك المرفوضة</a>");
						else{
							subtext = "لإضافة هذه العضوية صديق لك<br>انقر فوق ايقونة (أضف عضو) التي في الأسفل.";
							buttons[buttons.length] = {
								value: 'أضف عضو',
								color: 'dark',
								click: function(){
									DF.friends.add(id, true);
								}
							};
						}
						text = "<table cellpadding=\"4\" cellspacing=\"1\">"+
							"<tr>"+
								"<td class=\"asText asCenter asP2\"><a href=\"profile.php?u="+id+"\"><img src=\""+DF.picture({picture:pic})+"\""+DF.picError(100)+"></a></td>"+
								"<td class=\"asHP10\" rowspan=\"2\"><nobr>"+subtext+"</nobr></td>"+
							"</tr>"+
							"<tr>"+
								"<td class=\"asCenter\">"+name+"</td>"+
							"</tr>"+
						"</table>";
						padding = 5;
					}
				}
				else{
					text = DF.friends.error("حدث خطأ أثناء تحميل المحتوي");
				}
				buttons[buttons.length] = {
					value: 'إغلاق',
					click: function(){
						DM.container.close();
					}
				};
				DM.container.open({
					header: 'أضف عضو صديق لك',
					body: text,
					padding: padding,
					buttons: buttons
				});
			},
			error: function(){
				DF.friends.error("حدث خطأ أثناء تحميل المحتوي");
			}
		});
	},
	'set': function(id){
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=setAddFriend&id='+id,
			success: function(res){
				var text = '';
				var res = res.split(DF.ajax2.ac);
				if(res && res[1] == 1){
					text = "<nobr>تم تقديم طلبك بنجاح.</nobr>";
				}
				else{
					text = DF.friends.error("حدث خطأ أثناء تقديم طلب الصداقة");
				}
				DM.container.open({
					header: 'أضف عضو صديق لك',
					body: text,
					buttons:[
						{
							value: 'إغلاق',
							click: function(){
								DM.container.close();
							}
						}
					]
				});
			},
			error: function(){
				DF.friends.error("حدث خطأ أثناء تحميل المحتوي");
			}
		});
	},
	'block': function(id){
		if(!id || id <= 0){
			return;
		}
		DM.container.open({
			header: 'منع عضو من إتصال بك',
			body: '<div class="asCenter"><img src="images/icons/loading2.gif"></div>',
			buttons:[
				{
					value: 'إغلاق',
					click: function(){
						DM.container.close();
					}
				}
			]
		});
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=blockUser&id='+id,
			success: function(res){
				var res = res.split(DF.ajax2.ac), text = DF.friends.error("حدث خطأ أثناء منع العضو");
				if(res && res[1] == 1){
					text = "<nobr>تم منع عضو بنجاح</nobr>";
				}
				else if(res && res[1] == 2){
					text = DF.friends.error("لا يمكنك إضافة أكثر من منع لعضو واحد");
				}
				$(DM.container.body).html(text);
			},
			error: function(){
				$(DM.container.body).html(DF.friends.error("حدث خطأ أثناء منع العضو"));
			}
		});
	},
	'error': function(text){
		if(text){
			return "<nobr class=\"asCRed\">"+text+"</nobr>";
		}
	}
};
DF.timezone = {
	panel:null,define:null,active:false,
	zones:new Array(
		'اينيوتوك، كواجالين','جزيرة ميدواي، ساموا','هاواي','ألاسكا','توقيت المحيط الهادي (الولايات المتحدة وكندا)',
		'التوقيت الجبلي (الولايات المتحدة وكندا)','التوقيت المركزي (الولايات المتحدة وكندا)، مكسيكو سيتي','التوقيت الشرقي (الولايات المتحدة وكندا) ، بوجوتا، ليما','التوقيت الأطلسي (كندا)، لاباز، سانتياغو','البرازيل، بوينس آيرس ، جورج تاون',
		'منتصف الأطلسي','الأزور، جزر الرأس الأخضر','في أوروبا الغربية من الزمن، لندن، لشبونة ، الدار البيضاء','بروكسل وكوبنهاغن ومدريد وباريس','كالينينجراد، جنوب أفريقيا، القاهرة',
		'بغداد، الرياض، موسكو ، سانت بطرسبرغ','أبو ظبي ، مسقط ، يريفان وباكو وتبليسي','ايكاترينبرغ ، إسلام آباد، كراتشي ، طشقند ، نيودلهي','الماتي ، دكا ، كولومبو','بانكوك، هانوي ، جاكرتا',
		'بكين، بيرث ، سنغافورة ، هونغ كونغ','طوكيو، سيول ، أوساكا، سابورو ، ياكوتسك','شرق استراليا وغوام وفلاديفوستوك','ماجادان، جزر سليمان ، كاليدونيا الجديدة','أوكلاند، ولينغتون، فيجي ، كامتشاتكا'
	),
	setDefaults:function(s){
		$('#timezoneParent').append('<div id="timeZonePanel" style="position:absolute;top:-7px;left:'+(s.offsetWidth+2)+'px;z-index:2000;"></div>');
		this.panel=$I('#timeZonePanel');
		this.define=s;
		$(document).click(function(event){
			var el = event.target;
			if( el != DF.timezone.define && !DM.isAncestor(DF.timezone.define, el) ){
				DF.timezone.close();
			}
		});
		this.close();
	},
	run:function(s,z){
		if(this.panel == null) this.setDefaults(s);
		if(this.active === true){
			this.close();
		}
		else{
			var g='',t='<table cellspacing="0" cellpadding="0\"><tr><td class="asBody2">'+
			'<table width="100%" cellpadding="0" cellspacing="2" align="center">'+
			'<tr><td class="asTitle asCenter"><nobr>التوقيت حسب منطقتك</nobr></td></tr>';
			for(var x=0,y=-12;x<this.zones.length;x++){
				if(y == 0) g='بتوقيت غرينتش';
				else{
					if(y>0) g='غرينتش + '+y+':00';
					else g='غرينتش - '+(y*(-1))+':00';
				}
				t+='<tr><td class="asTextLink asRight"><a '+(y == z ? ' style="border-color:#ffffff;"' : '')+'href="index.php?timezone='+(y == 0 ? '00' : y)+'&src='+$(s).attr('self')+'"><nobr>('+g+') '+this.zones[x]+'</nobr></a></td></tr>';
				y++;
			}
			t+='</table></td></tr></table>';
			$(this.panel).html(t);
			this.panel.style.visibility='visible';
			this.active=true;
		}
	},
	close:function(){
		this.panel.style.visibility='hidden';
		this.active=false;
	}
};
DF.headerIcons = {
	items: ['messages', 'friends', 'notifies', 'newusers', 'changenames'],
	icons: {},
	openedName: '',
	create: function(){
		var headerIcons = this, items = headerIcons.items, name, icon, el, place;
		for( var x = 0; x < items.length; x++ ){
			name = items[x];
			el = $I('#hd-icons-'+name);
			if( el ){
				place = $('#'+el.id+' > div')[0];
				if( place ){
					icon = {
						name: name,
						el: el,
						place: false,
						button: false,
						panel: false,
						content: false,
						border: false,
						arrow: false,
						box: false,
						click: false
					};
					place.className = 'icons';
					$I('.cur-pointer', place).id = 'button'+name;
					$(place).attr({
						'name': name,
						'parent': name
					});
					$(place).html('<div id="border'+name+'" class="border" style="display:none;"></div><div id="panel'+name+'" class="panel" style="display:none;"><table width="100%" cellpadding="4" cellspacing="1" dir="'+dir+'"><tr><td id="content'+name+'" class="smallText" align="center"><img src="images/icons/loading3.gif" width="28" height="20"></td></tr></table></div><img id="arrow'+name+'" class="arrow" style="display:none;" src="images/icons/header-arrow-bottom.gif"><div id="box'+name+'" class="box" style="display:none;"></div>'+$(place).html());
					icon.place = place;
					headerIcons.setChilds(icon, name);
					headerIcons.icons[name] = icon;
					$(place).mouseover(function(){
						var name = $(this).attr('parent'), icon = headerIcons.icons[name];
						if(!icon.click){
							$(this).css({
								'margin': '0',
								'border-width': '1px',
								'background-color': '#444'
							});
						}
					});
					$(place).mouseout(function(){
						var name = $(this).attr('parent'), icon = headerIcons.icons[name];
						if(!icon.click){
							$(this).css({
								'margin': '1px',
								'border-width': '0',
								'background-color': 'transparent'
							});
						}
					});
					$(place).click(function(e){
						var name = $(this).attr('parent'), icon = headerIcons.icons[name];
						if(e.target === this || e.target === icon.button){
							headerIcons.cleanIcons();
							icon.click = true;
							$(this).css({
								'margin': '0',
								'border-width': '1px',
								'background-color': '#444'
							});
							headerIcons.setContent(name);
							headerIcons.openedName = name;
						}
					});
				}
			}
		}
		$(document).click(function(e){
			if( e.target && headerIcons.openedName != '' ){
				var parentName = $(e.target).attr('parent') || '';
				if( parentName != headerIcons.openedName ){
					headerIcons.cleanIcons();
					headerIcons.openedName = '';
				}
			}
		});
	},
	setCount: function(){
		var icons = this.icons;
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=get_header_details',
			success: function( res ){
				var res = res.split('|');
				if( res.length == 5 ){
					var arr = [], count, hide;
					arr['messages'] = [$PI(res[0]), 0];
					arr['friends'] = [$PI(res[1]), 0];
					arr['notifies'] = [$PI(res[2]), 0];
					arr['newusers'] = [$PI(res[3]), 1];
					arr['changenames'] = [$PI(res[4]), 1];
					$.each( icons, function( name, icon ){
						count = arr[name][0];
						hide = arr[name][1];
						if( count > 0 ){
							$(icon.box).html(count);
							$(icon.box).fadeIn(500);
							$(icon.arrow).fadeIn(500);
							if( hide == 1 ){
								$(icon.place).show();
								$(icon.el).show();
							}
						}
						else{
							$(icon.box).hide();
							$(icon.arrow).hide();
							if( hide == 1 ){
								$(icon.place).hide();
								$(icon.el).hide();
							}
						}
					});
				}
			}
		});
		setTimeout('DF.headerIcons.setCount();', 10000);
	},
	load: function(){
		if( userLevel > 0 ){
			this.create();
			this.setCount();
		}
	},
	cleanIcons: function(){
		var icons = this.icons;
		$.each(icons, function(name, icon){
			icon.click = false;
			$(icon.panel).hide();
			$(icon.border).hide();
			$(icon.content).html('<img src="images/icons/loading3.gif" width="28" height="20">');
			$(icon.place).css({
				'margin': '1px',
				'border-width': '0',
				'background-color': 'transparent'
			});
		});
	},
	setContent: function(name){
		var icon = this.icons[name];
		this.getContent(name);
		$(icon.border).css({'width': (icon.place.offsetWidth - 2)+'px'});
		if($.browser.msie && $.browser.version < 7){
			$(icon.border).css({'left': '-4px'});
			$(icon.panel).css({'left': '-5px'});
		}
		$(icon.border).show();
		$(icon.panel).show();
	},
	getContent: function(name){
		var headerIcons = this, icon = headerIcons.icons[name],
		doError = function(){
			$(icon.content).html('<span class=\"asCGrayDark asS12\">حدث خطأ أثناء إتصال بالسيرفر.</span>');
			headerIcons.setChilds(icon, name);
		};
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=get_header_contents&name='+name,
			success: function(res){
				if(res.indexOf('(@@)') >= 0){
					headerIcons['do'+name](res.split('(@@)')[1].split('[@@]'));
				}
				else{
					doError();
				}
			},
			error: function(){
				doError();
			}
		});
	},
	setChilds: function(icon, name){
		var text = $(icon.place).html();
		text = text.replace(/(<[^>]*)/igm, function(a, t){
			if(t.indexOf('</') == -1 && t.indexOf('parent') == -1){
				t = t+' parent="'+name+'"';
			}
			return t;
		});
		$(icon.place).html(text);
		icon.button = $I('#button'+name);
		icon.panel = $I('#panel'+name);
		icon.content = $I('#content'+name);
		icon.border = $I('#border'+name);
		icon.arrow = $I('#arrow'+name);
		icon.box = $I('#box'+name);
	},
	domessages: function(rows){
		var headerIcons = this, name = 'messages', icon = headerIcons.icons[name], text = '', cells;
		text += '<table width="100%" cellpadding="3" cellspacing="1">';
		if(rows.length == 0 || rows.length == 1 && rows[0] == ''){
			text += '<tr><td class="smallText asCenter asCGrayDark">لا توجد أي رسائل جديدة غير مقروءة.</td></tr>';
		}
		else{
			for(var x = 0; x < rows.length; x++){
				cells = rows[x].split('{@@}');
				text += '<tr>'+
				'<td class="smallTitle asCenter asAS12"><img class="size-32" src="'+cells[3]+'" onerror="this.src=\'images/upics/32/default.gif\';"><br>'+cells[2]+'</td>'+
				'<td class="smallText asRight asAS12 asCGrayDark">'+cells[0]+'<br>'+cells[1]+'</td>'+
				'</tr>';
			}
			text += '<tr><td class="smallText asCenter asAS12" colspan="2"><a href="pm.php?mail=new">للمزيد انقر هنا للذهاب الى صندوق رسائل جديدة</a></td></tr>';
		}
		text += '</table>';
		$(icon.content).html(text);
		headerIcons.setChilds(icon, name);
	},
	dofriends: function(rows){
		var headerIcons = this, name = 'friends', icon = headerIcons.icons[name], text = '', cells;
		text += '<table width="100%" cellpadding="3" cellspacing="1">';
		if(rows.length == 0 || rows.length == 1 && rows[0] == ''){
			text += '<tr><td class="smallText asCenter asCGrayDark">لا توجد أية طلبات الصداقة.</td></tr>';
		}
		else{
			for(var x = 0; x < rows.length; x++){
				cells = rows[x].split('{@@}');
				text += '<tr>'+
				'<td class="smallTitle asCenter asAS12" width="10%"><img class="size-32" src="'+cells[2]+'" onerror="this.src=\'images/upics/32/default.gif\';"></td>'+
				'<td class="smallText asRight asAS12 asCGrayDark">'+cells[1]+'<br>'+cells[3]+'</td>'+
				'<td class="smallText asCenter asS12" width="20%" id="friendRequest'+cells[0]+'"><nobr><input type="button" class="button-dark" value="موافقة" onclick="DF.headerIcons.friends('+cells[0]+', \'accept\');">&nbsp;<input type="button" class="button" value="رفض" onclick="DF.headerIcons.friends('+cells[0]+', \'refuse\');"></nobr></td>'+
				'</tr>';
			}
			text += '<tr><td class="smallText asCenter asAS12" colspan="3"><a href="friends.php?scope=wait">للمزيد اذهب الى صفحة طلبات المنتظرة للموافقة</a></td></tr>';
		}
		text += '</table>';
		$(icon.content).html(text);
		headerIcons.setChilds(icon, name);
	},
	donotifies: function(rows){
		var headerIcons = this, name = 'notifies', icon = headerIcons.icons[name], text = '', cells;
		text += '<table width="100%" cellpadding="3" cellspacing="1">';
		if(rows.length == 0 || rows.length == 1 && rows[0] == ''){
			text += '<tr><td class="smallText asCenter asCGrayDark">لا توجد أية إشعارات.</td></tr>';
		}
		else{
			for(var x = 0; x < rows.length; x++){
				cells = rows[x].split('{@@}');
				text += '<tr onclick="DF.headerIcons.notifies('+cells[0]+', this);">'+
				'<td class="smallTitle asCenter asAS12"><img class="size-32" src="'+cells[6]+'" onerror="this.src=\'images/upics/32/default.gif\';"><br>'+cells[5]+'</td>'+
				'<td class="asRight asAS12 asS12 asCGrayDark" style="border:#c3c3c3 1px solid;background-color:#d4eaff;"><div class="pos-relative"><nobr><img class="size-14" src="'+cells[1]+'">&nbsp;'+cells[2]+'<br>'+cells[3]+'<br>'+cells[4]+'</nobr></div></td>'+
				'</tr>';
			}
			text += '<tr><td class="smallText asCenter asAS12" colspan="2"><a href="profile.php?type=notifications">للمزيد اذهب الى صفحة جميع إشعارات.</a></td></tr>';
		}
		text += '</table>';
		$(icon.content).html(text);
		headerIcons.setChilds(icon, name);
	},
	friends: function(id, method){
		var headerIcons = this, name = 'friends', icon = headerIcons.icons[name], bar = $I('#friendRequest'+id),
		doError = function(){
			$(bar).html('<span class="asCGrayDark"><nobr>حدث خطأ.</nobr></span>');
			headerIcons.setChilds(icon, name);
		};
		$(bar).html('<img class="size-16" src="images/icons/loading3.gif">');
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=checkFriends&method='+method+'&id='+id,
			success: function(res){
				var res = res.split('[>:DT:<]'), text = '';
				if(res.length == 3 && $PI(res[1]) == 1){
					if(method == 'accept'){
						text = 'تم قبول الطلب.';
					}
					else{
						text = 'تم رفض الطلب.';
					}
					$(bar).html('<nobr>'+text+'</nobr>');
					headerIcons.setChilds(icon, name);
				}
				else{
					doError();
				}
			},
			error: function(){
				doError();
			}
		});
	},
	notifies: function(id, row){
		var headerIcons = this, name = 'notifies', icon = headerIcons.icons[name];
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=read_notification&id='+id,
			success: function(res){
				if($PI(res) == 1){
					$(row.cells[1]).css('background-color', '#f0f0f0');
					headerIcons.setChilds(icon, name);
				}
			}
		});
	}
};
DF.searchBar = {
	setEvents: function(){
		$('#header_search_inp').keyup(function(){
			DF.searchBar.search();
		});
		$('#header_search_btn').click(function(){
			DF.searchBar.search();
		});
	},
	search: function(){
		var input = $I('#header_search_inp'), place = $I('#header_search_res');
		$(place).html(this.content('<img src="images/icons/loading3.gif" width="28" height="20">'));
		if(input.value.trim().length == 0){
			$(place).html('');
			return;
		}
		$.ajax({
			type: 'POST',
			url: 'ajax.php?x='+Math.random(),
			data: 'type=get_header_search_users&search='+encodeURIComponent(input.value),
			success: function(res){
				res = res.split('@=@');
 				if(res.length == 3 && res[1] != ''){
					res = res[1];
					if($PI(res) == 99){
						$(place).html(DF.searchBar.content('يجب عليك التسجيل<br>لكي تستطيع مشاهدة تفاصيل عضويات<br><a href="register.php">انقر هنا للتسجيل</a>', true));
					}
					else if($PI(res) == 98){
						$(place).html(DF.searchBar.content('لا توجد أية نتيجة', true));
					}
					else{
						var rows = res.split('@+@'), cells, code = '<table width="100%" cellspacing="0" cellpadding="0">';
						for(var x = 0; x < rows.length; x++){
							cells = rows[x].split('@-@');
							if(x > 0){
								code += '<tr><td colspan="2"><hr></td></tr>';
							}
							code += '<tr><td width="20%"><img class="size-32" src="'+cells[1]+'" onerror="this.src=\'images/upics/32/default.gif\';"></td><td class="asAS12 asS12 asCGrayDark" align="right">'+cells[0]+'<br>'+(cells[2] != '' ? cells[2] : 'غير معروف')+' ('+DF.searchBar.setPosts(cells[3])+')</td></tr>';
						}
						if(x == 6){
							code += '<tr><td colspan="2"><hr></td></tr><tr><td class="asCenter asAS12" colspan="2"><a href="users.php?search='+input.value+'">للمزيد من النتائج انقر هنا</a></td></tr>';
						}
						code += '</table>';
						$(place).html(DF.searchBar.content(code));
						DF.menu.checkElements();
					}
				}
				else{
					$(place).html(DF.searchBar.content('حدث خطأ', true));
				}
			},
			error: function(){
				DF.searchBar.search();
			}
		});
	},
	content: function(text, gray){
		var code = '';
		text = text || '';
		gray = gray || false;
		code += '<table width="100%" cellpadding="4" cellspacing="1" dir="'+dir+'"><tr><td class="smallText" align="center">';
		if(gray){
			code += '<span class="asCGrayDark asAS12"><nobr>'+text+'</nobr></span>';
		}
		else{
			code += text;
		}
		code += '</td></tr></table>';
		return code;
	},
	setPosts: function(number){
		var text = '';
		if(number == 0){
			text = 'لم يشارك';
		}
		else if(number == 1){
			text = 'مشاركة واحدة';
		}
		else if(number == 2){
			text = 'مشاركتان';
		}
		else if(number > 10){
			text = number+' مشاركة';
		}
		else{
			text = number+' مشاركات';
		}
		return text;
	}
};
DF.indexAdminMenu = function(){
	var elements = $('.forums-admenu'),
	create = function(element){
		var tools = (element.attr('tools') || '').split('|'), type = tools[0], id = tools[1], status = tools[2], hidden = tools[3] || 0, filename, box, button;
		element.append('<div></di>');
		box = $('div', element);
		button = $('img', element);
		if(type == 'f'){
			filename = forumAdminName;
			box.html(template(
				'خيارات المنتدى',
				[
					[
						'editor.php?type=newtopic&f='+id,
						'إضافة موضوع جديد'
					],
					[
						filename+'?type=edit&f='+id,
						'تعديل منتدى'
					],
					[
						filename+'?type='+( (hidden == 0) ? 'hidden' : 'visible')+'&f='+id,
						( (hidden == 0) ? 'إخفاء منتدى' : 'إظهار منتدى'),
						( (hidden == 0) ? 'هل أنت متأكد بأن تريد إخفاء هذا المنتدى ؟' : 'هل أنت متأكد بأن تريد إظهار هذا المنتدى ؟'),
					],
					[
						filename+'?type='+( (status == 1) ? 'lock' : 'open')+'&f='+id,
						( (status == 1) ? 'قفل منتدى' : 'فتح منتدى'),
						( (status == 1) ? 'هل أنت متأكد بأن تريد فتح هذا المنتدى ؟' : 'هل أنت متأكد بأن تريد حذف هذا المنتدى ؟'),
					],
					[
						filename+'?type=delete&f='+id,
						'حذف منتدى',
						'هل أنت متأكد بأن تريد حذف هذا المنتدى ؟'
					]
				]
			));
		}
		if(type == 'c'){
			filename = catAdminName;
			box.html(template(
				'خيارات الفئة',
				[
					[
						forumAdminName+'?type=add&c='+id,
						'إضافة منتدى جديد'
					],
					[
						filename+'?type=edit&c='+id,
						'تعديل الفئة'
					],
					[
						filename+'?type='+( (status == 1) ? 'lock' : 'open')+'&c='+id,
						( (status == 1) ? 'قفل الفئة' : 'فتح الفئة'),
						( (status == 1) ? 'هل أنت متأكد بأن تريد قفل هذه الفئة ؟' : 'هل أنت متأكد بأن تريد فتح هذه الفئة ؟'),
					],
					[
						filename+'?type=delete&c='+id,
						'حذف الفئة',
						'هل أنت متأكد بأن تريد حذف هذه الفئة ؟'
					]
				]
			));
		}
		box.css({
			'top': '18px',
			'left': ( (homeView == 'grid') ? ( (type == 'c') ? 4 : 14 ) : 9 )+'px'
		});
		button.click(function(){
			if(box.css('display') == 'none'){
				$('.forums-admenu > div').fadeOut('fast');
				$('.forums-admenu').css('z-index', '1');
				element.css('z-index', '2');
				box.fadeIn('fast');
			}
			else{
				box.fadeOut('fast').css('z-index', '1');
				element.css('z-index', '1');
			}
		});
		if(userLevel == 4){
			element.show();
		}
	},
	template = function(optionTitle, links){
		var clickText, text = '<table cellspacing="0" cellpadding="0"><tr><td class="asBody2"><table width="100%" cellpadding="0" cellspacing="2" align="center"><tr><td class="asTitle asCenter"><nobr>'+optionTitle+'</nobr></td></tr>';
		for(var x = 0; x < links.length; x++){
			clickText = (links[x][2] && links[x][2] != '') ? ' onclick="return confirm(\''+links[x][2]+'\')"' : '';
			text += '<tr><td class="asTextLink"><a href="'+links[x][0]+'"'+clickText+'><nobr>'+links[x][1]+'</nobr></a></td></tr>';
		}
		text += '</table></td></tr></table>';
		return text;
	};
	for(var x = 0; x < elements.length; x++){
		create( $(elements[x]) );
	}
};
DF.setOnlineToForums = function(){
	if(thisFile != 'index.php'){
		return;
	}
	$.ajax({
		type: 'POST',
		url: 'ajax.php?x='+Math.random(),
		data: 'type=onlineinforums&forums='+$('div[onf]').attr('onf'),
		success: function(res){
			if(res != '' && res.indexOf('e') == -1){
				res = res.split('|');
				var row;
				for(var x = 0; x < res.length; x++){
					row = res[x].split(':');
					$('#onlinef'+row[0]).html('<nobr>'+row[1]+'</nobr>');
				}
			}
		}
	});
};
Array.prototype.deleteVal=function(v){
	var index=this.getIndex(v);
	if(index>=0) this.splice(index,1);
};
$(function(){
	DF.indexAdminMenu();
	DF.setOnlineToForums();
});
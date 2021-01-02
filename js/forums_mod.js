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
	var DF = {};
}
DF.command = function(id, type){
	var msg = new Array(), f = document.info;
	msg["mo"] = ["موافقة", ""];
	msg["ho"] = ["تجميد", ""];
	msg["hd"] = ["إخفاء", ""];
	msg["vs"] = ["إظهار", ""];
	msg["lk"] = ["قفل", ""];
	msg["op"] = ["فتح", ""];
	msg["st"] = ["تثبيت", ""];
	msg["us"] = ["إلغاء تثبيت", ""];
	msg["ul"] = ["إزالة", " من وصلات منتدى "];
	msg["dl"] = ["حذف", ""];
	msg["re"] = ["إرجاع", ""];
	if(confirm("هل أنت متأكد بأن تريد "+msg[type][0]+" هذا الموضوع"+msg[type][1]+" ؟")){
		f.type.value = type;
		f.id.value = id;
		f.other.value = (type == 'ul' ? '' : topics[id][9]);
		f.cmd.value = 2;
		f.submit();
	}
};
DF.chkBox = function(f, s){
	var el = f.elements;
	if(typeof DF.fl == "undefined") DF.fl = false;
	if(!DF.fl){
		for(var x = 0, y = 0; x < el.length; x++){
			el[x].checked = true;
			if(el[x].type == 'checkbox' && el[x].name != s.name){
				y++;
				this.chkFrmTrClass(el[x], el[x].value);
			}
		}
		DF.fl = true;
		if(y == 0){
			alert("لا توجد أيه موضوع بالصفحة");
		}
		s.title = 'إلغاء تحديد الكل';
	}
	else{
		for(var x = 0; x < el.length; x++){
			el[x].checked = false;
			if(el[x].type == 'checkbox' && el[x].name != s.name){
				this.chkFrmTrClass(el[x], el[x].value);
			}
		}
		DF.fl = false;
		s.title = 'تحديد الكل';
	}
};
DF.getNumChoosedTopics = function(f){
	var el = f.elements;
	if(typeof DF.cht == 'undefined'){
		DF.cht = 0;
	}
	for(var x = 0, y = 0; x < el.length; x++){
		if(el[x].type == 'checkbox' && el[x].name != 'chkAll' && el[x].checked){
			y++;
		}
	}
	DF.cht = y;
	return y;
}
DF.getNumTopics = function(f){
	var el = f.elements, type = $S(f.type), t, a = new Array();
	f.id.value = 0;
	if(f.type.selectedIndex > 0){
		a["mo"] = [1, 3];
		a["ho"] = [1, 3];
		a["hd"] = [0, 2];
		a["vs"] = [1, 2];
		a["lk"] = [1, 0];
		a["op"] = [0, 0];
		a["st"] = [0, 1];
		a["us"] = [1, 1];
		a["t0"] = [1, 6];
		a["t1"] = [2, 6];
		a["t2"] = [1, 6];
		a["yv"] = [1, 10];
		a["nv"] = [0, 10];
		a["ln"] = [0, 8];
		a["mv"] = [0, 7];
		a["dl"] = [0, 4];
		a["re"] = [1, 4];
		a["ar"] = [0, 5];
		a["ua"] = [1, 5];
		var s = a[type][0], i = a[type][1];
		f.other.value = '';
		for(var x = 0, y = 0; x < el.length; x++){
			if(el[x].type == 'checkbox' && el[x].name != 'chkAll' && el[x].checked){
				t = topics[parseInt(el[x].value)];
				if(
					t[i] == s ||
					type == 'mo' && t[3] > 0 ||
					type == 't0' && t[6] > 1 ||
					type == 't1' && t[6] == 0 ||
					type == 't1' && t[6] == 2 ||
					type == 't2' && t[6] < 2
				){
					y++;
					f.id.value += ((y == 0) ? '' : ',')+el[x].value;
					f.other.value += ((y == 0) ? '' : '|')+el[x].value+"-"+t[9];
				}
			}
		}
		return y;
	}
};
DF.chkFrmTrClass = function(s, id){
	var f = s.form, ch = $('#tr'+id).children(), c=/asNormal|asFixed|asHidden/;
	if(!DF.oc){
		DF.oc=new Array();
	}
	if(s.checked){
		DF.oc[id]=[];
		for(var x=0;x<ch.length;x++){
			var nc=ch[x].className.replace(c,'asSelect');
			DF.oc[id][x]=ch[x].className;
			ch[x].className=nc;
		}
	}
	else{
		for(var x=0;x<ch.length;x++){
			var oc=DF.oc[id][x];
			ch[x].className=oc;
		}
	}
	this.chkChange(f,false);
};
DF.chkChange=function(f, m){
	var nt = this.getNumTopics(f), type = $S(f.type), p = $I('#moveForumList'), cht = this.getNumChoosedTopics(f);
	if(f.type.selectedIndex > 0){
		if(cht == 0){
			if(m){
				alert("أنت لم حددت أي موضوع");
			}
			f.type.selectedIndex = 0;
			p.innerHTML = '';
		}
		else{
			if(type == 'mv'){
				DF.getMoveForumList();
			}
		}
	}
	f.ok.value = (f.type.selectedIndex > 0) ? "("+nt+") تطبيق" : "تطبيق";
};
DF.getMoveForumList=function(){
	var fl=$I('#goToForumLsit').options,p=$I('#moveForumList'),
	t="<select class=\"asGoTo\" name=\"definedForumList\" id=\"definedForumList\">"+
	"<option value=\"0\">-- اختر منتدى --</option>";
	for(var x=0;x<fl.length;x++){
		var fid=fl[x].value,fs=fl[x].text;
		if(fid>0&&fid!=forumid) t+="<option value=\""+fid+"\">"+fs+"</option>";
	}	
	t+="</select>";
	p.innerHTML=t;
};
DF.chkClick = function(f){
	var el = f.elements, type = $S(f.type), nt = DF.getNumTopics(f), m = new Array(), em = new Array(), fl = $I('#definedForumList');
	m['mo'] = "موافقة على مواضيع المختارة";
	m['ho'] = "تجميد مواضيع المختارة";
	m['hd'] = "إخفاء مواضيع المختارة";
	m['vs'] = "إظهار مواضيع المختارة";
	m['lk'] = "قفل مواضيع المختارة";
	m['op'] = "فتح مواضيع المختارة";
	m['st'] = "تثبيت مواضيع المختارة";
	m['us'] = "إلغاء التثبيت مواضيع المختارة";
	m['t0'] = "إلغاء شعار التميز لمواضيع المختارة";
	m['t1'] = "منح نجمة لمواضيع المختارة";
	m['t2'] = "منح ميدالية لمواضيع المختارة";
	m['mv'] = "نقل مواضيع المختارة الى المنتدى الذي انت اخترت";
	m['yv'] = "عرض موضوع للجميع";
	m['nv'] = "عرض موضوع فقط لأعضاء مسجلين";
	m['ln'] = "يجعل مواضيع المختارة كوصلات منتدى";
	m['dl'] = "حذف مواضيع المختارة";
	m['re'] = "إرجاع مواضيع المختارة";
	m['ar'] = "جعل مواضيع المختارة امكانية نقلها للأرشيف";
	m['ua'] = "جعل مواضيع المختارة عدم نقلها للأرشيف";
	em['mo'] = ["ينتظر الموافقة او مجمّد", "موافقة عليه"];
	em['ho'] = ["ينتظر الموافقة", "تجميده"];
	em['hd'] = ["غير مخفي", "إخفائه"];
	em['vs'] = ["مخفي", "إظهاره"];
	em['lk'] = ["غير مقفل", "قفله"];
	em['op'] = ["مقفل", "فتحه"];
	em['st'] = ["غير مثبت", "تثبيته"];
	em['us'] = ["مثبت", "إلغاء تثبيته"];
	em['t0'] = ["يملك نجمة أو ميدالية", "إلغائه"];
	em['t1'] = ["لا يملك نجمة", "منح نجمة"];
	em['t2'] = ["لا يملك ميدالية", "منح ميدالية"];
	em['yv'] = ["فقط يظهر لأعضاء مسجلين", "عرضه للجميع"];
	em['nv'] = ["يظهر للجميع", "عرضه فقط لأعضاء مسجلين"];
	em['ln'] = ["ليس من ضمن وصلات المنتدى", "وصلة للمنتدى"];
	em['dl'] = ["غير محذوف", "حذفه"];
	em['re'] = ["محذوف", "إرجاعه"];
	em['ar'] = ["تم إلغاء نقله الى الأرشيف", "منح نقله الى الأرشيف"];
	em['ua'] = ["تم منح نقله للأرشيف", "إلغاء نقله الى الأرشيف"];
	if(nt > 0){
		if(type == 'mv' && fl.selectedIndex == 0){
			alert("يجب عليك ان تختار منتدى من القائمة ليتم نقل مواضيع المختارة الى ذلك المنتدى");
		}
		else{
			if(confirm("هل أنت متأكد بأن تريد "+m[type]+" وعددها:"+nt)){
				f.cmd.value = 1;
				f.submit();
			}
		}
	}
	else{
		if(f.type.selectedIndex == 0){
			confirm("أنت لم حددت أي خيار من قائمة خيارات المواضيع");
		}
		else{
			confirm("أنت لم حددت أي موضوع "+em[type][0]+" لكي يتم "+em[type][1]+".");
		}
	}
};
DF.chkOptions = function(s){
	var o = $S(s), ou = (o != '') ? "&option="+o : "";
	document.location = thisFile+"?f="+forumid+authURL+ou;
};
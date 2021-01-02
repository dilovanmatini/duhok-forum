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
DF.getUsersByIP = function(ip, id, img, cols){
	var thisRow = $I('#getIpRow'+id), table = $(thisRow).parents('table').get(0);
	if(!thisRow || !table){
		return;
	}
	if($T(DF.usersByIP) != 'array'){
		DF.usersByIP = [];
	}
	if(DF.usersByIP[id] === true){
		table.deleteRow(thisRow.rowIndex + 1);
		img.src = 'images/icons/expand.gif';
		DF.usersByIP[id] = false;
		return;
	}
	else{
		img.src = 'images/icons/contract.gif';
		DF.usersByIP[id] = true;
	}
	var row = table.insertRow(thisRow.rowIndex + 1);
	var cell = row.insertCell(0);
	$(cell).css({
		'text-align': 'center',
		'border': 'gray 1px solid'
	});
	cell.className = 'asNormalB';
	cell.colSpan = cols;
	$(cell).html('<br><img src="'+progressUrl+'" border="0"><br><br>رجاً انتظر...<br><br>');
	var doError = function(err){
		var text ='';
		if(err === 1){
			text = '<br>لم يتم العثور على أي عضوية<br><br>';
		}
		else{
			text = '<br><img src="'+errorUrl+'" border="0"><br><br><font color="red">حدث خطأ أثناء العملية<br>مرجوا إعادتها من جديد</font><br><br>';
		}
		$(cell).html(text);
	};
	$.ajax({
		type: 'POST',
		url: adAjaxFile+'?x='+Math.random(),
		data: 'type=get_users_by_ip&ip='+ip,
		success: function(res){
			res = res.trim();
			if(res == ''){
				doError(0);
			}
			if(res == 'empty'){
				doError(1);
			}
			else{
				$(cell).html(res);
			}
		},
		error: function(){
			doError(0);
		}
	});
};
DF.headerIcons.donewusers = function(rows){
	var headerIcons = this, name = 'newusers', icon = headerIcons.icons[name], text = '', cells;
	text += '<table width="100%" cellpadding="3" cellspacing="1">';
	if(rows.length == 0 || rows.length == 1 && rows[0] == ''){
		text += '<tr><td class="smallText asCenter asCGrayDark">لا يوجد أية عضوية ينتظر الموافقة.</td></tr>';
	}
	else{
		for(var x = 0; x < rows.length; x++){
			cells = rows[x].split('{@@}');
			text += '<tr>'+
			'<td class="smallText asRight asAS12 asCGrayDark"><nobr><a href="profile.php?u='+cells[0]+'">'+cells[1]+'</a><br>'+cells[2]+'<br>'+cells[3]+'&nbsp;<img class="cur-pointer" src="images/icons/new_user.gif" onclick="DF.headerIcons.newusersByIP('+cells[4]+');" width="10" height="10"></nobr></td>'+
			'<td class="smallText asCenter asCGrayDark"><nobr><img src="'+cells[5]+'" width="18" height="12"><br>'+cells[6]+'</nobr></td>'+
			'<td class="smallText asCenter asS12" width="20%" id="newusersRequest'+cells[0]+'"><nobr><input type="button" class="button-dark" value="موافقة" onclick="DF.headerIcons.newusers('+cells[0]+', \'accept\');">&nbsp;<input type="button" class="button" value="رفض" onclick="DF.headerIcons.newusers('+cells[0]+', \'refuse\');"></nobr></td>'+
			'</tr>';
		}
		text += '<tr><td class="smallText asCenter asAS12" colspan="3"><a href="admincp.php?type=users&method=waitusers">للمزيد اذهب الى صفحة عضويات منتظرة للموافقة</a></td></tr>';
	}
	text += '</table>';
	$(icon.content).html(text);
	headerIcons.setChilds(icon, name);
};
DF.headerIcons.dochangenames = function(rows){
	var headerIcons = this, name = 'changenames', icon = headerIcons.icons[name], text = '', cells;
	text += '<table width="100%" cellpadding="3" cellspacing="1">';
	if(rows.length == 0 || rows.length == 1 && rows[0] == ''){
		text += '<tr><td class="smallText asCenter asCGrayDark">لا يوجد أي اسم ينتظر الموافقة.</td></tr>';
	}
	else{
		for(var x = 0; x < rows.length; x++){
			cells = rows[x].split('{@@}');
			text += '<tr>'+
			'<td class="smallTitle asCenter asAS12"><img class="size-32" src="'+cells[2]+'" onerror="this.src=\'images/upics/32/default.gif\';"><br>'+cells[1]+'</td>'+
			'<td class="smallText asRight asCGrayDark"><nobr>اسم الجديد:<br><span class="asCBlack">'+cells[3]+'</span><br>'+cells[4]+'</nobr></td>'+
			'<td class="smallText asCenter asS12" width="20%" id="changenamesRequest'+cells[0]+'"><nobr><input type="button" class="button-dark" value="موافقة" onclick="DF.headerIcons.changenames('+cells[0]+', \'accept\');">&nbsp;<input type="button" class="button" value="رفض" onclick="DF.headerIcons.changenames('+cells[0]+', \'refuse\');"></nobr></td>'+
			'</tr>';
		}
		text += '<tr><td class="smallText asCenter asAS12" colspan="3"><a href="admincp.php?type=users&method=changenamewait">للمزيد اذهب الى صفحة أسماء منتظرة للموافقة.</a></td></tr>';
	}
	text += '</table>';
	$(icon.content).html(text);
	headerIcons.setChilds(icon, name);
};
DF.headerIcons.newusersByIP = function(ip){
	var setResult = function(type, res){
		var text = '';
		if(type == 'result'){
			text = res;
		}
		else if(type == 'load'){
			text = '<img src="images/icons/loading2.gif" width="36" height="27">';
		}
		else if(type == 'empty'){
			text = 'لم يتم العثور على أي عضوية';
		}
		else{
			text = '<span class="asCRed">حدث خطأ أثناء العملية<br>مرجوا إعادتها من جديد</span>';
		}
		DM.container.open({
			header: 'مطابقة الأي بي',
			body: '<center><span class="asAS12 asCenter">'+text+'</span></center>'
		});
	};
	setResult('load');
	$.ajax({
		type: 'POST',
		url: adAjaxFile+'?x='+Math.random(),
		data: 'type=get_users_by_ip&ip='+ip,
		success: function(res){
			res = res.trim();
			if(res == ''){
				setResult('error');
			}
			if(res == 'empty'){
				setResult('empty');
			}
			else{
				setResult('result', res);
			}
		},
		error: function(){
			setResult('error');
		}
	});
};
DF.headerIcons.newusers = function(id, method){
	var headerIcons = this, name = 'newusers', icon = headerIcons.icons[name], bar = $I('#newusersRequest'+id),
	doError = function(){
		$(bar).html('<span class="asCGrayDark"><nobr>حدث خطأ.</nobr></span>');
		headerIcons.setChilds(icon, name);
	};
	$(bar).html('<img class="size-16" src="images/icons/loading3.gif">');
	$.ajax({
		type: 'POST',
		url: adAjaxFile+'?x='+Math.random(),
		data: 'type=new_users_operations&method='+method+'&id='+id,
		success: function(res){
			var text = '';
			if($PI(res) == 1){
				if(method == 'accept'){
					text = 'تمت الموافقة.';
				}
				else{
					text = 'تم رفض.';
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
};
DF.headerIcons.changenames = function(id, method){
	var headerIcons = this, name = 'changenames', icon = headerIcons.icons[name], bar = $I('#changenamesRequest'+id),
	doError = function(){
		$(bar).html('<span class="asCGrayDark"><nobr>حدث خطأ.</nobr></span>');
		headerIcons.setChilds(icon, name);
	};
	$(bar).html('<img class="size-16" src="images/icons/loading3.gif">');
	$.ajax({
		type: 'POST',
		url: adAjaxFile+'?x='+Math.random(),
		data: 'type=change_names_operations&method='+method+'&id='+id,
		success: function(res){
			var text = '';
			if($PI(res) == 1){
				if(method == 'accept'){
					text = 'تمت الموافقة.';
				}
				else{
					text = 'تم رفض.';
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
};
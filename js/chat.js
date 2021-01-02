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
DF.chatAutoScroll = 'start';
DF.chatSetErrorLoad = false;
DF.chatUsersColor = new Array('#e5e5e5', '#d2f0ff', '#ffcccc', '#ccff99', '#ffff99');
DF.chatUsersChoosedColor = new Array();
DF.chatUsersBGColor = new Array();
DF.chatUsersSetBGColor = function(name){
	for(var x = 0; x < 5; x++){
		if(!this.chatUsersChoosedColor.inArray(x)){
			this.chatUsersChoosedColor.add(x);
			this.chatUsersBGColor[name] = this.chatUsersColor[x];
			break;
		}
	}
}
DF.chatSendMsg = function(myMessage, myStyle){
	var msgBox = $I('#messageBox'), message = ($T(myMessage) == 'string') ? myMessage : msgBox.value, style = ($T(myStyle) == 'string') ? myStyle : this.chatGetStyle(),
	msgPanel = $I('#messagesPanel'), msgText = msgPanel.innerHTML;
	if(message != ''){
		msgBox.value = '';
		$.ajax({
			type: 'POST',
			url: 'dochat.php?type=ajax&method=chatSendMsg&x='+Math.random(),
			data: 'message='+message+'&style='+style,
			success: function(res){
				var res = res.split(DF.ajax.ac);
				if(res && res[1] != 'yes'){
					msgPanel.innerHTML = msgText.substring(0, (msgText.length - 16))+DF.chatFoundError('لم يتم إرسال رسالة', 'red')+"</tbody></table>";
				}
			}
		});
	}
};
DF.chatActivity = function(limit){
	var time = $I('#chatStartTime'), msgPanel = $I('#messagesPanel'), msgText = msgPanel.innerHTML;
	$.ajax({
		type: 'POST',
		url: 'dochat.php?type=ajax&method=chatActivity&x='+Math.random(),
		data: 'time='+time.value+'&limit='+limit,
		success: function(res){
			var res = res.split(DF.ajax.ac), text = '', msgs, records, bg;
			if(res.length > 2){
				if(res[1] != ''){
					msgs = res[1].split('[>:r:<]');
					for(var x = 0; x < (msgs.length-1); x++){
						records = msgs[x].split('[>:c:<]');
						text += DF.chatInsertMessage(records[0], records[1], records[2]);
						limit++;
					}
					msgPanel.innerHTML = msgText.substring(0, (msgText.length - 16))+text+"</tbody></table>";
					if(DF.chatAutoScroll == 'start'){
						msgPanel.scrollTop = 10000;
					}
				}
				if(DF.chatSetErrorLoad){
					msgPanel.innerHTML = msgText.substring(0, (msgText.length - 16))+DF.chatFoundError('تم إتصال بنقاش حي بنجاح', 'green')+"</tbody></table>";
					DF.chatSetErrorLoad = false;
				}
			}
			else{
				if(!DF.chatSetErrorLoad){
					msgPanel.innerHTML = msgText.substring(0, (msgText.length - 16))+DF.chatFoundError('لا يمكن إتصال بنقاش حي', 'red')+"</tbody></table>";
					DF.chatSetErrorLoad = true;
				}
			}
			setTimeout("DF.chatActivity("+limit+")", 1);
		}
	});
};
DF.chatOnlineUsers = function(){
	var place = $I('#usersPanel');
	$.ajax({
		type: 'POST',
		url: 'dochat.php?type=ajax&method=chatGetOnlineUsers&x='+Math.random(),
		success: function(res){
			var res = res.split(DF.ajax.ac), users, text = '';
			if(res.length > 2){
				users = res[1].split('{AS}');
				if(users.length > 0){
					text+='<table cellpadding="2" width="100%">';
					for(var x = 0; x < users.length; x++){
						text+='<tr><td class="asTitle2 asAS12">'+users[x]+'</td></tr>';
					}
					text+='</table>';
					$(place).html(text);
				}
			}
			else{
				DF.chatOnlineUsers();
			}
			setTimeout("DF.chatOnlineUsers()", 2000);
		}
	});
};
DF.chatInsertMessage=function(name, date, text){
	var row = bg = "";
	if(!this.chatUsersBGColor[name]){
		this.chatUsersSetBGColor(name);
	}
	bg = this.chatUsersBGColor[name];
	row = "<tr><td class=\"asTitle2 asAS12\" style=\"border:bbbbbb 1px solid;padding:2px 4px 2px 4px;background-color:"+bg+"\"><nobr>"+name+"</nobr></td><td class=\"asTitle2\" style=\"border:bbbbbb 1px solid;padding:2px 4px 2px 4px;background-color:"+bg+"\"><nobr>"+date+"</nobr></td><td class=\"asTitle2\" style=\"width:95%;border:bbbbbb 1px solid;padding:2px 4px 2px 4px;background-color:"+bg+";word-break:break-all\">"+text+"</td></tr>";
	return row;
};
DF.chatFoundError = function(msg, color){
	var msgs = new Array();
	msgs['red'] = 'حدث خطأ';
	msgs['green'] = 'محاولة إتصال';
	return this.chatInsertMessage(userName, '<font color="'+color+'">'+msgs[color]+'</font>', '<font color="'+color+'">'+msg+'</font>');
};
DF.chatSetStyle = function(type){
	var sel = $I('#chatFont'+type), value = $S(sel), msgBox = $I('#messageBox');
	if(type == 'Name'){
		msgBox.style.fontFamily = value;
	}
	else if(type == 'Size'){
		msgBox.style.fontSize = value;
	}
	else if(type == 'Color'){
		msgBox.style.color = value;
	}
};
DF.chatGetStyle = function(){
	var name = $I('#chatFontName'), size = $I('#chatFontSize'), color = $I('#chatFontColor'), style = '';
	style += "font-family:"+$S(name)+";";
	style += "font-size:"+$S(size)+";";
	style += "color:"+$S(color)+";";
	return style;
};
DF.chatCheckScroll = function(s){
	var top = (s.scrollTop + s.offsetHeight);
	if(top >= s.scrollHeight){
		this.chatAutoScroll = 'start';
	}
	else{
		this.chatAutoScroll = 'stop';
	}
};
DF.chatInsertSmile = function(icon){
	var msgBox = $I('#messageBox');
	msgBox.value += "{:"+icon+":}";
	msgBox.focus();
};
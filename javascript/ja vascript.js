/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

function show_info(id){

  if(document.getElementById(id).style.display == "none")
  {
    document.getElementById(id).style.display = "block";
  }
  else
  {
    document.getElementById(id).style.display = "none";
  }

}

function checkAll(){
  for (var i = 0; i < check.elements.length; i++){    
    eval("check.elements[" + i + "].checked = true");  
  } 
} 
function delAll(){
  for (var i = 0; i < check.elements.length; i++){    
    eval("check.elements[" + i + "].checked = false");  
  } 
} 

function del_el(form){
check.typehiddel.value = "delete";

check.submit();
}
function hid_el(form){
check.typehiddel.value = "hidden";
check.submit();
}

function checkAllpm(){
var total = check.elements.length;
var totalpm = total - 2;
var are_you_sure = "عدد الرسائل التي تم وضع علامة الاختيار عليها :"+totalpm;
if(confirm(are_you_sure)){
  for (var i = 0; i < check.elements.length; i++){    
    eval("check.elements[" + i + "].checked = true");  
  } 
}
} 

function AllpmTrash(){
var total = deletemsg.elements.length;
var totalpm = total - 2;
var are_you_sure = "عدد الرسائل التي تم وضع علامة الاختيار عليها :"+totalpm;
if(confirm(are_you_sure)){
  for (var i = 0; i < deletemsg.elements.length; i++){    
    eval("deletemsg.elements[" + i + "].checked = true");  
  } 
}
} 

function contract_all(){
var el = document.all.to_hidd;
var ell = document.all.user_info;
document.getElementById('first_user_info').style.display = "none";

// Hidd Message As Add overflow
  for (var i = 0; i < el.length; i++){    
 el[i].style.height = 60;
 el[i].style.overflow="hidden"; 
  } 
// Hidd Userinfo But Not Some Info
  for (var i = 0; i < ell.length; i++){    
 ell[i].style.display = "none";
  } 
}
function expand_all(){
var el = document.all.to_hidd;
var ell = document.all.user_info;
document.getElementById('first_user_info').style.display = "block";
// Show Message
  for (var i = 0; i < el.length; i++){    
 el[i].style.height = "";
 el[i].style.overflow="hidden"; 
  } 
// Show Userinfo
  for (var i = 0; i < ell.length; i++){    
 ell[i].style.display = "block";
  } 
}

var check_flag = "false";
function check_top(){
if(check_flag == "false"){

  for (var i = 0; i < topics_tools.elements.length; i++){ 
    eval("topics_tools.elements[" + i + "].checked = true");  
  } 

     check_flag = "true";
     document.getElementById('check_all').value = "الغاء تحديد الكل";
  }
    else {
  for (var i = 0; i < topics_tools.elements.length; i++){ 
    eval("topics_tools.elements[" + i + "].checked = false");  
  }    
	check_flag = "false";
	document.getElementById('check_all').value = "تحديد الكل";
		}
} 

function left_tools(){
var type = document.getElementById('tools_mod').value;
var f = document.getElementById('t_forum').value;
var c = document.getElementById('t_cat').value;
document.topics_tools.action = "index.php?mode=moderate&type=tools_left&f="+f+"&c="+c+"&method="+type;
topics_tools.submit();
}

	function check_changes(row, val1, val2){
		if(val1 == val2){
			row.className = "cat";
		}
		else{
			row.className = "optionheader_selected";
		}
	}

function submit_search(search_count,max_search){
var msg = "لقد تجاوزت الحد الاقصى لعمليات البحث \n المسموح لك القيام بها \n عدد العمليات التي قمت بها هو : "+search_count+"\n بينما الحد الاجمالي لك هو : "+max_search;
if(search_count >= max_search){
alert(msg);
return false;
}else{
search.submit();

}
}

function profile_mod(link){
window.location=link;
}



	function submitCmd(){
		if(selPosts.command.value == "hide"){
			confirm("هل أنت متأكد من إخفاء الردود المختارة؟");
		}
		if(selPosts.command.value == "unhide"){
			confirm("هل أنت متأكد من إزالة إخفاء الردود المختارة؟");
		}
		if(selPosts.command.value == "approve"){
			confirm("هل أنت متأكد من الموافقة على الردود المختارة؟");
		}
		if(selPosts.command.value == "trash"){
			confirm("هل أنت متأكد من حذف الردود المختارة؟");
		}
	selPosts.submit();
	}


	
	function check(checked, alert_msg){
		if(check_flag == "false"){
			var count = 0;
			for (i = 0; i < checked.length; i++){
				checked[i].checked = true;
				if(checked[i].type == "checkbox"){
					count += 1;
				}
			}
			check_flag = "true";
			alert(alert_msg+": "+count);
			return "إلغاء التحديد الكل";
		}
		else {
			for (i = 0; i < checked.length; i++){
				checked[i].checked = false;
			}
			check_flag = "false";
			return "تحديد الكل";
		}
	}




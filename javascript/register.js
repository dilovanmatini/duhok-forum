/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 1.1                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright ɠ2007-2009 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

function submitForm()
{
var easy_pass = new Array ( 
"123456","123456789","123123","000000","111111","12345678","112233","666666","654321", 
"1234567","123321","555555","121212","999999","222222","101010","102030","123654", 
"987654","987654321","0123456","0123456789"); 

var x; 
var the_passwords_choosed_is_very_easy = "الكلمة السرية التي وضعتها سهلة جدا";
for (x = 0; x < easy_pass.length; x++){ 

if(userinfo.user_password1.value == easy_pass[x]){ 
confirm(the_passwords_choosed_is_very_easy); 
return; 
}
}

var name_not_allowed = new Array ( "المدير العام","مدير","ادارة","مديرة","اداري","َADMIN","مشرف","مراقب","admin","directeur","المنتدى");
var x; 
for (x = 0; x < name_not_allowed.length; x++){ 
if(userinfo.user_name.value.indexOf(name_not_allowed[x]) >= 0)
 { confirm(not_allowed_to_use_name_admin);
 return;
 }
} 

 var name_not_allowed = new Array ( "sex" , "سكس" );
var x; 
for (x = 0; x < name_not_allowed.length; x++){ 
if(userinfo.user_name.value.indexOf(name_not_allowed[x]) >= 0)
 { confirm(not_allowed_to_use_bad_name);
 return;
 }
} 
 

if(userinfo.user_email.value.toLowerCase().indexOf("http://") == 0)
	userinfo.user_email.value = userinfo.user_email.value.slice(7);

if(userinfo.user_email.value.toLowerCase().indexOf("www.") == 0)
	userinfo.user_email.value = userinfo.user_email.value.slice(4);


if(userinfo.forum_title.value.length == 0)
	{
	confirm(necessary_to_insert_site_name);
	return;
	}

if(userinfo.site_address.value.length == 0)
	{
	confirm(necessary_to_insert_site_address);
	return;
	}

if(userinfo.user_name.value.length == 0)
	{
	confirm(necessary_to_insert_user_name);
	return;
	}
	
if(userinfo.user_name.value.length < 3)
	{
	confirm(necessary_to_insert_more_three_letter);
	return;
	}

if(userinfo.user_name.value.length > 30)
	{
	confirm(necessary_to_insert_less_thirty_letter);
	return;
	}

if(userinfo.user_name.value.indexOf("Ü") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_one);
	return;
	}

if(userinfo.user_name.value.indexOf("\"") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_two);
	return;
	}

if(userinfo.user_name.value.indexOf("@") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_three);
	return;
	}

if(userinfo.user_name.value.indexOf("'") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_four);
	return;
	}

if(userinfo.user_name.value.indexOf("|") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_five);
	return;
	}

if(userinfo.user_name.value.indexOf("\\") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_six);
	return;
	}

if(userinfo.user_name.value.indexOf(".") >= 0)
	{
	confirm(not_allowed_to_use_this_symbol_seven);
	return;
	}

if(parseInt(userinfo.user_name.value) == userinfo.user_name.value)
	{
	confirm(not_allowed_to_use_just_numbers);
	return;
	}

if(userinfo.user_password1.value.length == 0)
	{
	confirm(necessary_to_insert_password);
	return;
	}

if(userinfo.user_password1.value.length < 6)
	{
	confirm(necessary_to_insert_more_five_letter_to_password);
	return;
	}

if(userinfo.user_name.value.length > 24)
	{
	confirm(necessary_to_insert_less_twenty_four_letter_to_password);
	return;
	}

if(userinfo.user_password2.value.length == 0)
	{
	confirm(necessary_to_insert_confirm_password);
	return;
	}

if(userinfo.user_password1.value  != userinfo.user_password2.value)
	{
	confirm(necessary_to_insert_true_confirm_password);
	return;
	}

if(userinfo.user_password1.value  == userinfo.user_name.value)
	{
	confirm(necessary_to_password_reversal_to_user_name);
	return;
	}

if(userinfo.user_password1.value.toLowerCase()  == userinfo.user_name.value.toLowerCase())
	{
	confirm(necessary_to_password_reversal_to_user_name);
	return;
	}

if(userinfo.user_email.value.length == 0)
	{
	confirm(necessary_to_insert_email);
	return;
	}

if(!/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/.test(userinfo.user_email.value))
	{
	confirm(necessary_to_insert_true_email);
	return;
	}

if(userinfo.user_password1.value.toLowerCase()  == userinfo.user_email.value.toLowerCase())
	{
	confirm(necessary_to_password_reversal_to_email);
	return;
	}

if(userinfo.user_age.value.length == 1)
	{
	confirm(necessary_to_insert_more_twelve_years);
	return;
	}

if(userinfo.user_age.value.length > 2)
	{
	confirm(necessary_to_insert_less_ninety_nine_years);
	return;
	}


userinfo.submit();
}

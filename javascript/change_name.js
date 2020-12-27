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

function submitForm()
{

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

if(userinfo.user_name.value.indexOf("ـ") >= 0)
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

userinfo.submit();
}

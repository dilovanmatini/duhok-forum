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

	var expanded = false;
	var autosave = false;
	var navvbulletin = new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	var files = new Array('DuhokForum');
	
	function fetch_object(idname){
    	if(document.getElementById)
    	{
    		return document.getElementById(idname);
    	}
    	else if(document.all)
    	{
    		return document.all[idname];
    	}
    	else if(document.layers)
    	{
    		return document.layers[idname];
    	}
    	else
    	{
    		return null;
    	}
    }

	function nobub()
	{
		window.event.cancelBubble = true;
	}

	function nav_goto(targeturl)
	{
		parent.frames.main.location = targeturl;
	}

	function toggle_group(group)
	{
		var curdiv = fetch_object("group_" + group);

		if(curdiv.style.display == "none")
		{
			open_close_group(group, true);
		}
		else
		{
			open_close_group(group, false);
		}

		if(autosave)
		{
			save_group_prefs(group);
		}
	}

	function expand_all_groups(doOpen)
	{
		var navobj = null;
		for (nav_file in files)
		{
			navobj = eval('nav' + files[nav_file]);
			for (var i = 0; i < navobj.length; i++)
			{
				open_close_group(files[nav_file] + '_' + i, doOpen);
			}
		}

		if(autosave)
		{
			save_group_prefs(-1);
		}
	}

	function save_group_prefs(groupid)
	{
		var opengroups = new Array();
		var counter = 0;
		var navobj = null;

		for (nav_file in files)
		{
			navobj = eval('nav' + files[nav_file]);
			for (var i = 0; i < navobj.length; i++)
			{
				if(fetch_object("group_" + files[nav_file] + '_' + i).style.display != "none")
				{
					opengroups[counter] = files[nav_file] + '_' + i;
					counter++;
				}
			}
		}

		window.location = "index.php?do=savenavprefs&nojs=0&navprefs=" + opengroups.join(",") + "#grp" + groupid;
	}

	function read_group_prefs()
	{
		var navobj = null;
		for (nav_file in files)
		{
			navobj = eval('nav' + files[nav_file]);
			for (var i = 0; i < navobj.length; i++)
			{
				open_close_group(files[nav_file] + '_' + i, navobj[i]);
			}
		}
	}
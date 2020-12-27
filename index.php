<?php

/*//////////////////////////////////////////////////////////
// ######################################################///
// # Duhok Forum 2.0                                    # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #  === Programmed & developed by Dilovan Matini ===  # //
// # Copyright © 2007-2020 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # Website: github.com/dilovanmatini/duhok-forum      # //
// # Email: df@lelav.com                                # //
// ###################################################### //
//////////////////////////////////////////////////////////*/

const _df_script = "index";
const _df_filename = "index.php";
define('_df_path', dirname(__FILE__)."/");

require_once _df_path."df.php";

require_once _df_path."header.php";

switch( $mode ){
     case "":
          require_once("home.php");
     break;
     case "f":
          require_once("forum.php");
     break;
     case "register":
          require_once("register.php");
     break;
     case "members":
          require_once("members.php");
     break;
     case "profile":
          require_once("profile.php");
     break;
     case "add_cat_forum":
          require_once("add_cat_forum.php");
     break;
     case "lock":
          require_once("lock.php");
     break;
     case "cat_forum_info":
          require_once("cat_forum_info.php");
     break;
     case "open":
          require_once("open.php");
     break;
     case "delete":
          require_once("delete.php");
     break;
     case "order":
          require_once("order.php");
     break;
     case "editor":
          require_once("editor.php");
     break;
     case "post_info":
          require_once("post_info.php");
     break;
     case "msg":
          require_once("msg.php");
     break;
     case "admin":
          require_once("admin/index.php");
     break;
     case "t":
          require_once("topic.php");
     break;
     case "forget_pass":
          require_once("forget_pass.php");
     break;
     case "pm":
          require_once("message.php");
     break;
     case "sendmsg":
          require_once("send_message.php");
     break;
     case "mail":
          require_once("forum_mail.php");
     break;
     case "svc":
          require_once("svc.php");
     break;
     case "user_svc":
          require_once("user_svc.php");
     break;
     case "rules":
          require_once("rules.php");
     break;
     case "option":
          require_once("topic_option.php");
     break;
     case "changename":
          require_once("change_name.php");
     break;
     case "sendpm":
          require_once("pm_to_admin.php");
     break;
     case "active":
          require_once("active.php");
     break;
     case "finfo":
          require_once("forum_info.php");
     break;
     case "other_cat_add":
          require_once("other_cat_add.php");
     break;
     case "other_cat_info":
          require_once("other_cat_info.php");
     break;
     case "files":
          require_once("files.php");
     break;
     case "topicmonitor":
          require_once("topicmonitor.php");
     break;
     case "search":
          require_once("search.php");
     break;
     case "p":
          require_once("print.php");
     break;
     case "posts":
          require_once("posts.php");
     break;
     case "mf":
          require_once("medal_files.php");
     break;
     case "admin_svc":
          require_once("admin_svc.php");
     break;
     case "hide_topics":
          require_once("hide_topics.php");
     break;
     case "requestmon":
          require_once("requestmon.php");
     break;
     case "moderate":
          require_once("moderation.php");
     break;
     case "mods":
          require_once("moderator_info.php");
     break;
     case "policy":
          require_once("policy.php");
     break;
     case "topics":
          require_once("topics.php");
     break;
     case "notify":
          require_once("notify.php");
     break;
     case "notifylist":
          require_once("notifylist.php");
     break;
     case "archive":
          require_once("archive.php");
     break;
     case "tellfriend":
          require_once("tellfriend.php");
     break;
     case "list":
          require_once("list.php");
     break;
     case "email_to_m":
          require_once("email_to_m.php");
     break;
     case "show":
          require_once("mem_forum.php");
     break;
     case "details":
          require_once("details.php");
     break;
     case "admin_notify":
          require_once("admin_notify.php");
     break;
     case "ip":
          require_once("ip.php");
     break;
     case "permission":
          require_once("permission.php");
     break;
     case "lockm":
          require_once("lockm.php");
     break;
     case "openm":
          require_once("openm.php");
     break;
     case "what_add":
          require_once("what_add.php");
     break;
     case "what_info":
          require_once("what_info.php");
     break;
     case "ihdaa_add":
          require_once("ihdaa_add.php");
     break;
     case "welcome":
          require_once("welcome.php");
     break;
     case "quick":
          require_once("quick.php");
     break;
}

require_once("footer.php");

?>
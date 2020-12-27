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

// denying calling this file without landing files.
defined('_df_script') or exit();

$forum_title = __FORUM_TITLE;
$forum_title2 = __FORUM_TITLE2;
$Site_ID = 1;
/*
$forum_title = __FORUM_TITLE2;
$Site_ID = 2;
*/
$site_name = __SITE_ADDRESS;
$copy_right = __COPY_RIGHT;
$image_folder = __IMAGE_FOLDER;
$max_page = __PAGE_NUMBER;
$admin_folder = __ADMIN_FOLDER;
$admin_email = __ADMIN_EMAIL;
$forum_version = __FORUM_VERSION;
$author_script = __AUTHOR_SCRIPT;
$total_pm_message = __TOTAL_PM_MSG;
$total_post_close_topic = __TOTAL_POST_CLOSE_TOPIC;
$mod_add_titles = __MOD_ADD_TITLES;
$mod_add_medals = __MOD_ADD_MEDALS;
$topic_max_size = __TOPIC_MAX_SIZE;
$reply_max_size = __REPLY_MAX_SIZE;
$pm_max_size = __PM_MAX_SIZE;
$sig_max_size = __SIG_MAX_SIZE;
$default_language = __DEFAULT_LANGUAGE;
$default_style = __DEFAULT_STYLE;
$forum_url = __FORUM_URL;
$forum_status = __FORUM_STATUS;
$seo = __FORUM_SEO;
$Meta = __FORUM_META;
$KeyWords = __FORUM_KEY;
$BanWords = __FORUM_BANWORDS;
$show_admin_info = __SHOW_ADMIN_INFO;
$change_name_max = __CHANGE_NAME_MAX;
$changename_dayslimit = __CHANGENAME_DAYSLIMIT;
$show_moderators = __SHOW_MODERATORS;
$Files_Max_Size = __FILES_MAX_SIZE;
$Files_Max_Allowed = __FILES_MAX_ALLOWED;
$help_forum = __HELP_FORUM;
$show_alexa_traffic = __SHOW_ALEXA_TRAFFIC;
$register_waitting = __REGISTER_WAITTING;
$show_medals_in_posts = __SHOW_MEDALS_IN_POSTS;
$new_member_min_posts = __NEW_MEMBER_MIN_POSTS;
$new_member_min_posts_pm = __NEW_MEMBER_MIN_POSTS_PM;
$site_timezone = __SITE_TIMEZONE;
$show_admin_topics = __SHOW_ADMIN_TOPICS;
$max_search = __MAX_SEARCH;


$max_list_cat_members = __MAX_LIST_CAT_MEMBERS;
$max_list_m_members = __MAX_LIST_M_MEMBERS;
$max_list_cat_moderators = __MAX_LIST_CAT_MODERATORS;
$max_list_m_moderators = __MAX_LIST_M_MODERATORS;

$color_0 = __COLOR_0;
$color_1 = __COLOR_1;
$color_2 = __COLOR_2;
$color_3 = __COLOR_3;
$color_4 = __COLOR_4;

// ############# Permession ###########

$CAN_SHOW_PM = __CAN_SHOW_PM;
$CAN_CLOSE_M = __CAN_CLOSE_M;
$CAN_OPEN_M = __CAN_OPEN_M;

$CAN_SHOW_FORUM = __CAN_SHOW_FORUM;
$CAN_SHOW_TOPIC = __CAN_SHOW_TOPIC;
$CAN_SHOW_PROFILE = __CAN_SHOW_PROFILE;

// ############# FTP ###########

$FTP_ACTIVE = __FTP_ACTIVE;
$FTP_SERVER = __FTP_SERVER;
$FTP_USER = __FTP_USER;
$FTP_PASS = __FTP_PASS;

// ############# Titles ###########


$Title = array(
	__TITLE_0,
	__TITLE_1,
	__TITLE_2,
	__TITLE_3,
	__TITLE_4,
	__TITLE_5,
	__TITLE_6,
	__TITLE_7,
	__TITLE_8,
	__TITLE_9,
	__TITLE_10,
	__TITLE_11,
	__TITLE_12,
	__TITLE_13
);

$Title_Female = array(
	__TITLE_0_FEMALE,
	__TITLE_1_FEMALE,
	__TITLE_2_FEMALE,
	__TITLE_3_FEMALE,
	__TITLE_4_FEMALE,
	__TITLE_5_FEMALE,
	__TITLE_6_FEMALE,
	__TITLE_7_FEMALE,
	__TITLE_8_FEMALE,
	__TITLE_9_FEMALE,
	__TITLE_10_FEMALE,
	__TITLE_11_FEMALE,
	__TITLE_12_FEMALE,
	__TITLE_13_FEMALE
);

$StarsNomber = array(
	__STARS_NUMBER_0,
	__STARS_NUMBER_1,
	__STARS_NUMBER_2,
	__STARS_NUMBER_3,
	__STARS_NUMBER_4,
	__STARS_NUMBER_5,
	__STARS_NUMBER_6,
	__STARS_NUMBER_7,
	__STARS_NUMBER_8,
	__STARS_NUMBER_9,
	__STARS_NUMBER_10
);

$StarsColor=array(
	__MLV_STARS_COLOR_0,
	__MLV_STARS_COLOR_1,
	__MLV_STARS_COLOR_2,
	__MLV_STARS_COLOR_3,
	__MLV_STARS_COLOR_4
);

//####### editor  ##############

$editor_full_html = __EDITOR_FULL_HTML;
$editor_width = __EDITOR_WIDTH;
$editor_height = __EDITOR_HEIGHT;

$EditorIcon=array(
	__EDITOR_ICON_SAVE,
	__EDITOR_ICON_PRINT,
	__EDITOR_ICON_ZOOM,
	__EDITOR_ICON_STYLE,
	__EDITOR_ICON_PARAGRAPH,
	__EDITOR_ICON_FONT_NAME,
	__EDITOR_ICON_SIZE,
	__EDITOR_ICON_TEXT,
	__EDITOR_ICON_SELECT_ALL,
	__EDITOR_ICON_CUT,
	__EDITOR_ICON_COPY,
	__EDITOR_ICON_PASTE,
	__EDITOR_ICON_UNDO,
	__EDITOR_ICON_REDO,
	__EDITOR_ICON_BOLD,
	__EDITOR_ICON_ITALIC,
	__EDITOR_ICON_UNDER_LINE,
	__EDITOR_ICON_STRIKE,
	__EDITOR_ICON_SUPER_SCRIPT,
	__EDITOR_ICON_SUB_SCRIPT,
	__EDITOR_ICON_SYMBOL,
	__EDITOR_ICON_LEFT,
	__EDITOR_ICON_CENTER,
	__EDITOR_ICON_RIGHT,
	__EDITOR_ICON_FULL,
	__EDITOR_ICON_NUBERING,
	__EDITOR_ICON_BULLETS,
	__EDITOR_ICON_INDENT,
	__EDITOR_ICON_OUTDENT,
	__EDITOR_ICON_IMAGE,
	__EDITOR_ICON_COLOR,
	__EDITOR_ICON_BGCOLOR,
	__EDITOR_ICON_EX_LINK,
	__EDITOR_ICON_IN_LINK,
	__EDITOR_ICON_ASSET,
	__EDITOR_ICON_TABLE,
	__EDITOR_ICON_SHOW_BORDER,
	__EDITOR_ICON_ABSOLUTE,
	__EDITOR_ICON_CLEAN,
	__EDITOR_ICON_LINE,
	__EDITOR_ICON_PROPERTIES,
	__EDITOR_ICON_WORD
);

//####### editor  ##############

//####### Schat  ##############

$active_schat = __ACTIVE_SCHAT;
$visitor_schat = __VISITOR_SCHAT;
$num_schat = __NUM_SCHAT;
$active_room = __ACTIVE_ROOM;
$nbr_max_post_schat = __NBR_MAX_POST_SCHAT;
$boss_schat = __BOSS_SCHAT;
$schat_url = __SCHAT_URL;
$forumid_mon_schat = __FORUMID_MON_SCHAT;
$active_schat_smile = __ACTIVE_SCHAT_SMILE;




//####### Best  ##############
$best = __BEST;
$best_mem = __BEST_MEM;
$best_topic = __BEST_TOPIC;
$best_mod = __BEST_MOD;
$best_frm = __BEST_FRM;

$best_t = __BEST_T;
$best_mem_t = __BEST_MEM_T;
$best_topic_t = __BEST_TOPIC_T;
$best_mod_t = __BEST_MOD_T;
$best_frm_t = __BEST_FRM_T;

//####### ADD  ##############

$logos = __logos;
$note = __note;

$close = __close;


//####### New Member  ##############
$new_member_show_topic = __NEW_MEMBER_SHOW_TOPIC;
$new_member_min_search = __NEW_MEMBER_MIN_SEARCH;
$new_member_change_name = __NEW_MEMBER_CHANGE_NAME;

$editor_topic = __editor_topic;
$editor_msg = __editor_msg;
$editor_style = __editor_style;

//####### ads  ##############
$ad = __ad;
$ad1 = __ad1;
$ad2 = __ad2;
$ad3 = __ad3;
$ad4 = __ad4;
$ad5 = __ad5;
$ad6 = __ad6;

$pb = __pb;
$pb1 = __pb1;
$pb2 = __pb2;
$pb3 = __pb3;
$pb4 = __pb4;
$pb5 = __pb5;
$pb6 = __pb6;

$pub = __pub;
$pub1 = __pub1;
$pub2 = __pub2;
$pub3 = __pub3;
$pub4 = __pub4;
$pub5 = __pub5;
$pub6 = __pub6;

$pubs = __pubs;
$pubs1 = __pubs1;
$pubs2 = __pubs2;
$pubs3 = __pubs3;
$pubs4 = __pubs4;
$pubs5 = __pubs5;
$pubs6 = __pubs6;
//####### ads  ##############

$BAR = __BAR;
$BAR1 = __BAR1;
$BAR2 = __BAR2;


$FORUM_MSG = __FORUM_MSG;
$FORUM_MSG1 = __FORUM_MSG1;
$FORUM_MSG2 = __FORUM_MSG2;
$MSG = __MSG;

$WHAT_ACTIVE = __WHAT_ACTIVE;
$WHAT_TITLE = __WHAT_TITLE;
$WHAT_ADMIN_SHOW = __WHAT_ADMIN_SHOW;
$WHAT_LIMIT = __WHAT_LIMIT;
$WHAT_COLOR = __WHAT_COLOR;
$WHAT_FASEL = __WHAT_FASEL;
$WHAT_ALL = __WHAT_ALL;
$WHAT_DIRECTION = __WHAT_DIRECTION;


?>

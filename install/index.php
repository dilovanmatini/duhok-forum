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

const _df_script = "install";
const _df_filename = "index.php";
define('_df_path', dirname( dirname(__FILE__) )."/");

require_once _df_path."df.php";

require_once "arabic.php";

echo'
<html dir="'.$lang['global']['dir'].'">
<head>
<meta http-equiv="Content-Language" content="'.$lang['global']['lang_code'].'">
<meta http-equiv="Content-Type" content="'.$lang['global']['charset'].'">
<title>'.$lang['install']['setup'].'</title>
<link rel="stylesheet" href="install/style_green.css">
<script type="text/javascript">
    var necessary_to_insert_site_name = ("'.$lang['install']['necessary_to_insert_site_name'].'");
    var necessary_to_insert_site_address = ("'.$lang['install']['necessary_to_insert_site_address'].'");
    var necessary_to_insert_user_name = ("'.$lang['install']['necessary_to_insert_user_name'].'");
    var necessary_to_insert_more_three_letter = ("'.$lang['install']['necessary_to_insert_more_three_letter'].'");
    var necessary_to_insert_less_thirty_letter = ("'.$lang['install']['necessary_to_insert_less_thirty_letter'].'");
    var not_allowed_to_use_just_numbers = ("'.$lang['install']['not_allowed_to_use_just_numbers'].'");
    var necessary_to_insert_password = ("'.$lang['install']['necessary_to_insert_password'].'");
    var necessary_to_insert_confirm_password = ("'.$lang['install']['necessary_to_insert_confirm_password'].'");
    var necessary_to_insert_true_confirm_password = ("'.$lang['install']['necessary_to_insert_true_confirm_password'].'");
    var necessary_to_insert_email = ("'.$lang['install']['necessary_to_insert_email'].'");
    var necessary_to_insert_true_email = ("'.$lang['install']['necessary_to_insert_true_email'].'");
    function submitForm()
    {

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

    if(userinfo.user_password2.value.length == 0)
        {
        confirm(necessary_to_insert_confirm_password);
        return;
        }

    if(userinfo.user_password1.value != userinfo.user_password2.value)
        {
        confirm(necessary_to_insert_true_confirm_password);
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

    userinfo.submit();
}
</script>
</head>
<body>

<center>
    <table border="0" width="42%" cellspacing="4" cellpadding="10" bgcolor="#C0C0C0">
        <tr>
            <td align="center" bgcolor="#CC3300"><font size="6" color="#FFFFFF">DUHOK FORUM 2.0</font><br><br><font color="#FFFFFF"><b>البرمجة والتطوير بواسطة Dilovan Matini</b>
        </tr>
    </table>
</center><br>';

$step = isset($_GET['step']) ? intval($_GET['step']) : 0;

if( $step == 0 ){
    echo'
    <center>
        <table width="60%" border="1">
            <tr class="normal">
                <td class="list_center" align="center" colSpan="10"><font size="5"><br>'.$lang['install']['welcome'].' DUHOK FORUM</font><br><br>
                    <a href="index.php?step=1">'.$lang['install']['click_here'].'</a><br><br>
                </td>
            </tr>
        </table>
    </center>';
}
elseif( $step == 1 ){

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}CATEGORY", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}CATEGORY (
    CAT_ID int(10) NOT NULL auto_increment,
    CAT_STATUS int(10) default '1',
    CAT_NAME varchar(100) NULL,
    CAT_ORDER int(10) default '1',
    CAT_MONITOR int(10) default NULL,
    CAT_HIDE INT(10) NOT NULL DEFAULT '0',
    CAT_LEVEL INT(10) NOT NULL DEFAULT '0',
    SITE_ID INT(10) NOT NULL DEFAULT '1',
    SHOW_INDEX  int(11) NOT NULL ,
    SHOW_INFO  int(11) NOT NULL ,
    SHOW_PROFILE  int(11) NOT NULL ,
    PRIMARY KEY (CAT_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}CHANGENAME_PENDING", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}CHANGENAME_PENDING (
    CHNAME_ID int(10) unsigned NOT NULL auto_increment,
    MEMBERID int(11) default '0',
    NEW_NAME varchar(40) default NULL,
    LAST_NAME varchar(40) default NULL,
    CH_DONE int(11) default '0',
    CH_CANCELLED int(11) default '0',
    UNDERDEMANDE int(11) default '0',
    CH_LASTDEMANDE int(11) default '0',
    CH_DATE int(10) unsigned default NULL,
    PRIMARY KEY  (CHNAME_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}CONFIG", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}CONFIG (
    ID int(10) unsigned NOT NULL auto_increment,
    keyword varchar(255) default NULL,
    text varchar(255) default NULL,
    PRIMARY KEY (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}FILES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}FILES (
    FILES_ID int(10) NOT NULL auto_increment,
    MEMBER_ID varchar(100) default NULL,
    FILES_SIZE varchar(100) default NULL,
    FILES_DATE int(10) unsigned default NULL,
    FILES_URL varchar(100) default NULL,
    FILES_NAME varchar(100) default NULL,
    PRIMARY KEY (FILES_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}FORUM", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}FORUM (
    CAT_ID int(10) default NULL,
    FORUM_ID int(10) unsigned NOT NULL auto_increment,
    F_STATUS int(10) default '1',
    F_SUBJECT varchar(100) default NULL,
    F_DESCRIPTION text,
    F_TOPICS int(10) default '0',
    F_REPLIES int(10) default '0',
    F_LAST_POST_DATE int(10) unsigned default NULL,
    F_LAST_POST_AUTHOR int(10) default NULL,
    F_ORDER int(10) default '1',
    F_LOGO varchar(255) default NULL,
    F_SEX INT(10) NULL DEFAULT '0',
    F_TOTAL_TOPICS int(11) default '5',
    F_TOTAL_REPLIES int(11) default '200',
    F_HIDE int(11) default '0',
    F_HIDE_MOD INT(10) NULL DEFAULT '0',
    F_HIDE_PHOTO int(11) default '0',
    F_HIDE_SIG int(11) default '0',
    DAY_ARCHIVE int(11) NOT NULL default '30', 
    CAN_ARCHIVE int(11) NOT NULL, 
    F_LEVEL INT(10) NOT NULL DEFAULT '0',
    SHOW_PROFILE  int(11) NOT NULL ,
    MODERATE_TOPIC  int(11) NOT NULL ,
    MODERATE_REPLY  int(11) NOT NULL ,
    SHOW_INDEX  int(11) NOT NULL ,
    SHOW_FRM  int(11) NOT NULL ,
    SHOW_INFO  int(11) NOT NULL ,
    SHOW_MONS  int(11) NOT NULL ,
    PRIMARY KEY (FORUM_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}FAVOURITE_TOPICS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}FAVOURITE_TOPICS (
    FAVT_ID int(11) NOT NULL auto_increment,
    F_MEMBERID int(11) default '0',
    F_CATID int(11) default '0',
    F_FORUMID int(11) default '0',
    F_TOPICID int(11) default '0',
    PRIMARY KEY (FAVT_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}HIDE_FORUM", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}HIDE_FORUM (
    HF_ID int(10) unsigned NOT NULL auto_increment,
    HF_MEMBER_ID int(11) default NULL,
    HF_FORUM_ID int(11) default NULL,
    HF_CAT_ID INT(11) default NULL,
    PRIMARY KEY (HF_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}LANGUAGE", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}LANGUAGE (
    L_ID int(10) unsigned NOT NULL auto_increment,
    L_FILE_NAME varchar( 100 ) NULL default NULL,
    L_NAME varchar( 100 ) NULL default NULL,
    PRIMARY KEY (L_ID))
    ", [], __FILE__, __LINE__);
    
    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}MEMBERS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}MEMBERS (
    MEMBER_ID int(10) unsigned NOT NULL auto_increment,
    M_STATUS int(10) default '1',
    M_NAME varchar(30) default NULL,
    M_PASSWORD varchar(100) default NULL,
    M_EMAIL varchar(100) default NULL,
    M_COUNTRY varchar(50) default NULL,
    M_LEVEL int(10) default '1',
    M_POSTS int(10) default '0',
    M_POINTS int(11) default '0',
    M_DATE int(10) unsigned default NULL,
    M_LAST_HERE_DATE int(10) unsigned default NULL,
    M_LAST_POST_DATE int(10) unsigned default NULL,
    M_RECEIVE_EMAIL int(10) default '1',
    M_LAST_IP varchar(25) default NULL,
    M_IP varchar(15) default NULL,
    M_OCCUPATION varchar(255) default NULL,
    M_SEX varchar(50) default NULL,
    M_AGE varchar(10) default NULL,
    M_BIO text,
    M_SIG text,
    M_MARSTATUS varchar(100) default NULL,
    M_CITY varchar(100) default NULL,
    M_STATE varchar(100) default NULL,
    M_PHOTO_URL varchar(255) default NULL,
    M_TITLE varchar(255) default NULL,
    M_OLD_MOD INT(10) NULL DEFAULT '0',
    M_MEDAL int(11) default '0',
    M_LOGIN int(10) default '0',
    M_PMHIDE int(11) default '1',
    M_CHANGENAME int(11) default '0',
    M_BROWSE int(11) default '1',
    M_ALLOWCHAT int(11) default '1',
    M_HIDE_SIG int(11) default '0',
    M_HIDE_PHOTO int(11) default '0',
    M_HIDE_DETAILS int(11) default '0',
    M_HIDE_POSTS int(11) default '0',
    M_HIDE_PM int(11) default '0',
    M_USE_PM int(11) default '0',
    M_Style_Form MEDIUMTEXT NOT NULL,
    M_SP_EDITOR int(11) default '1',
    view  int(11) NOT NULL ,
    M_ADMIN  int(11) default '1',
    P_INDEX  int(11) default '0',
    P_ARCHIVE int(11) default '0' ,
    P_MEMBERS  int(11) default '0',
    P_POSTS  int(11) default '0',
    P_POSTS_MEMBERS  int(11) default '0' ,
    P_TOPICS  int(11) default '0',
    P_TOPICS_MEMBERS  int(11) default '0',
    P_ACTIVE  int(11) default '0',
    P_MONITORED  int(11) default '0' ,
    P_SEARCH  int(11) default '0' ,
    P_DETAILS  int(11) default '0' ,
    P_PASS  int(11) default '0' ,
    P_DETAILS_EDIT  int(11) default '0' ,
    P_MEDALS  int(11) default '0' ,
    P_CHANGE_NAME  int(11) default '0' ,
    P_LIST  int(11) default '0' ,
    P_SIG  int(11) default '0' ,
    P_FORUM  int(11) default '0' ,
    P_FORUM_ARCHIVE  int(11) default '0' ,
    P_TOPICS_SHOW  int(11) default '0' ,
    P_POSTS_SHOW  int(11) default '0' ,
    P_ADD_TOPICS  int(11) default '0' ,
    P_ADD_POSTS  int(11) default '0' ,
    P_QUICK_POSTS  int(11) default '0' ,
    P_EDIT_TOPICS  int(11) default '0' ,
    P_EDIT_POSTS  int(11) default '0' ,
    P_SEND_TOPICS  int(11) default '0' ,
    P_NOTIFY  int(11) default '0' ,
    LOCK_DATE  int(10) unsigned default NULL ,
    LOCK_BY  int(11) default '0' ,
    LOCK_CAUSE text,
    LOCK_TOPICS  int(11) default '1' ,
    LOCK_POSTS  int(11) default '1' ,
    M_NOTES text,
    M_SIZE  int(11) default '18' ,
    M_ALIGN  varchar(15) default 'center' ,
    M_FONTS_T varchar(15) default NULL ,
    M_COLOR  varchar(15) default 'blue'  ,
    M_WEIGHT varchar(15) default 'normal'   ,
    M_IHDAA  int(11) default '0' ,
    PRIMARY KEY (MEMBER_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}MODERATOR", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}MODERATOR (
    MOD_ID int(10) unsigned NOT NULL auto_increment,
    FORUM_ID int(11) default '0',
    MEMBER_ID int(11) default '0',
    PRIMARY KEY (MOD_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}NAMEFILTER", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}NAMEFILTER (
    N_ID int(10) unsigned NOT NULL auto_increment,
    N_NAME varchar(255) default NULL,
    N_FILTER varchar(255) default NULL,
    PRIMARY KEY (N_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}ONLINE", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}ONLINE (
    ONLINE_ID int(10) unsigned NOT NULL auto_increment,
    O_MEMBER_ID int(11) default NULL,
    O_FORUM_ID int(11) default NULL,
    O_MEMBER_LEVEL int(11) default '0',
    O_MEMBER_BROWSE int(11) default '1',
    O_IP varchar(30) default NULL,
    O_MODE varchar(100) default NULL,
    O_DATE int(10) unsigned default NULL,
    O_LAST_DATE int(10) unsigned default NULL,
    PRIMARY KEY (ONLINE_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}OTHERS_CAT", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}OTHERS_CAT (
    O_CATID int(11) unsigned NOT NULL auto_increment,
    O_CAT_NAME varchar(40) default NULL,
    O_CAT_URL varchar(40) default NULL,
    PRIMARY KEY (O_CATID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}OTHERS_FORUM", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}OTHERS_FORUM (
    O_FORUMID int(11) unsigned NOT NULL auto_increment,
    O_FORUM_NAME varchar(40) default NULL,
    O_FORUM_URL varchar(40) default NULL,
    PRIMARY KEY (O_FORUMID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}PM", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}PM (
    PM_ID int(10) unsigned NOT NULL auto_increment,
    PM_MID int(11) default '0',
    PM_STATUS int(11) default '1',
    PM_TO int(11) default '0',
    PM_FROM int(11) default '0',
    PM_READ int(11) default '0',
    PM_OUT int(11) default '0',
    PM_REPLY int(11) default '0',
    PM_SUBJECT varchar(100) default NULL,
    PM_MESSAGE text,
    PM_DATE int(10) unsigned default NULL,
    PRIMARY KEY (PM_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}REPLY", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}REPLY (
    CAT_ID int(11) default '0',
    FORUM_ID int(11) default '0',
    TOPIC_ID int(11) default '0',
    REPLY_ID int(10) unsigned NOT NULL auto_increment,
    R_STATUS int(11) default '1',
    R_DELETED_BY int(11) default '0',
    R_DELETED_DATE int(10) unsigned default NULL,
    R_QUOTE int(11) default '0',
    R_AUTHOR int(11) default '0',
    R_MESSAGE text,
    R_DATE int(10) unsigned default NULL,
    R_HIDDEN int(11) default '0',
    R_HIDDEN_BY int(11) default '0',
    R_HIDDEN_DATE int(10) unsigned default NULL,
    R_UNMODERATED int(11) default '0',
    R_MODERATED_BY int(11) default '0',
    R_MODERATED_DATE int(10) unsigned default NULL,
    R_HOLDED int(11) default '0',
    R_HOLDED_BY int(11) default '0',
    R_HOLDED_DATE int(10) unsigned default NULL,
    R_LASTEDIT_DATE int(11) unsigned default NULL,
    R_LASTEDIT_MAKE varchar(40) default NULL,
    R_ENUM int(10) default '0',
    PRIMARY KEY (REPLY_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}STYLE", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}STYLE (
    S_ID int(10) unsigned NOT NULL auto_increment,
    S_FILE_NAME varchar( 100 ) NULL default NULL,
    S_NAME varchar( 100 ) NULL default NULL,
    PRIMARY KEY (S_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}TOPICS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}TOPICS (
    CAT_ID int(11) default '0',
    FORUM_ID int(11) default '0',
    TOPIC_ID int(10) unsigned NOT NULL auto_increment,
    T_STATUS int(11) default '1',
    T_DELETED_BY int(11) default '0',
    T_DELETED_DATE int(10) unsigned default NULL,
    T_SUBJECT varchar(100) default NULL,
    T_MESSAGE text,
    T_REPLIES int(11) default '0',
    T_COUNTS int(11) default '0',
    T_AUTHOR int(11) default '0',
    T_DATE int(10) unsigned default NULL,
    T_LAST_POST_AUTHOR int(10) default '1',
    T_LAST_POST_DATE int(10) unsigned default NULL,
    T_ARCHIVE_FLAG int(11) default '1',
    T_STICKY int(11) default '0',
    T_HIDDEN int(11) default '0',
    T_HIDDEN_BY int(11) default '0',
    T_HIDDEN_DATE int(10) unsigned default NULL,
    T_UNMODERATED int(11) default '0',
    T_MODERATED_BY int(11) default '0',
    T_MODERATED_DATE int(10) unsigned default NULL,
    T_HOLDED int(11) default '0',
    T_HOLDED_BY int(11) default '0',
    T_HOLDED_DATE int(10) unsigned default NULL,
    T_MOVED int(11) default '0',
    T_MOVED_BY int(11) default '0',
    T_MOVED_DATE int(10) unsigned default NULL,
    T_TOP int(11) default '0',
    T_LINKFORUM int(11) default '0',
    T_LASTEDIT_DATE int(11) unsigned default NULL,
    T_LASTEDIT_MAKE varchar(40) default NULL,
    T_LOCK_DATE int(11) unsigned default NULL,
    T_LOCK_MAKE varchar(40) default NULL,
    T_OPEN_DATE int(11) unsigned default NULL,
    T_OPEN_MAKE varchar(40) default NULL,
    T_ENUM int(10) default '0',
    T_SURVEYID int(11) default '0',
    T_ARCHIVED int(11) NOT NULL, 
    T_UNHIDDEN_DATE  int(10) unsigned default NULL ,
    T_UNHIDDEN_BY  int(11) default '0' ,
    T_UNSTICKY_DATE  int(10) unsigned default NULL ,
    T_UNSTICKY_BY  int(11) default '0' ,
    T_STICKY_DATE  int(10) unsigned default NULL ,
    T_STICKY_BY  int(11) default '0' ,
    PRIMARY KEY (TOPIC_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}UPLOAD", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}UPLOAD (
    UP_ID int(10) NOT NULL auto_increment,
    UP_MODMAKE varchar(100) default NULL,
    UP_FILESIZE varchar(100) default NULL,
    UP_DATE int(10) unsigned default NULL,
    UP_URL varchar(100) default NULL,
    PRIMARY KEY (UP_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}GLOBAL_MEDALS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}GLOBAL_MEDALS (
    MEDAL_ID int(10) unsigned NOT NULL auto_increment,
    FORUM_ID int(11) default NULL,
    STATUS int(11) default '0',
    SUBJECT varchar(255) default NULL,
    DAYS int(11) default '0',
    POINTS int(11) default '0',
    URL varchar(255) default NULL,
    CLOSE int(11) default '0',
    ADDED int(11) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (MEDAL_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}GLOBAL_TITLES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}GLOBAL_TITLES (
    TITLE_ID int(10) unsigned NOT NULL auto_increment,
    FORUM_ID int(11) default NULL,
    STATUS int(11) default '1',
    CLOSE int(11) default '0',
    FORUM int(11) default '0',
    ADDED int(11) default NULL,
    SUBJECT varchar(255) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (TITLE_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}MEDAL_FILES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}MEDAL_FILES (
    MF_ID int(10) unsigned NOT NULL auto_increment,
    FORUM_ID int(11) default NULL,
    ADDED int(11) default NULL,
    SUBJECT varchar(255) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (MF_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}MEDALS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}MEDALS (
    MEDAL_ID int(10) unsigned NOT NULL auto_increment,
    GM_ID int(11) default NULL,
    FORUM_ID int(11) default NULL,
    MEMBER_ID int(11) default NULL,
    STATUS int(11) default '1',
    ADDED int(11) default NULL,
    DAYS int(11) default '0',
    POINTS int(11) default '0',
    URL varchar(255) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (MEDAL_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}SURVEY_OPTIONS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}SURVEY_OPTIONS (
    SO_ID int(10) unsigned NOT NULL auto_increment,
    SURVEY_ID int(11) default NULL,
    OPTION_ID int(11) default '0',
    VALUE varchar(255) default NULL,
    OTHER varchar(255) default NULL,
    PRIMARY KEY  (SO_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}SURVEYS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}SURVEYS (
    SURVEY_ID int(10) unsigned NOT NULL auto_increment,
    FORUM_ID int(11) default NULL,
    SUBJECT varchar(255) default NULL,
    QUESTION varchar(255) default NULL,
    STATUS int(11) default '1',
    SECRET int(11) default '0',
    DAYS int(11) default '0',
    MIN_DAYS int(11) default '0',
    MIN_POSTS int(11) default '0',
    ADDED int(11) default NULL,
    START int(10) unsigned default NULL,
    END int(10) unsigned default NULL,
    PRIMARY KEY  (SURVEY_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}TITLES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}TITLES (
    TITLE_ID int(10) unsigned NOT NULL auto_increment,
    GT_ID int(11) default NULL,
    MEMBER_ID int(11) default NULL,
    STATUS int(11) default '1',
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (TITLE_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}TOPIC_MEMBERS", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}TOPIC_MEMBERS (
    TM_ID int(10) unsigned NOT NULL auto_increment,
    MEMBER_ID int(11) default NULL,
    TOPIC_ID int(11) default NULL,
    ADDED int(11) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (TM_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}USED_TITLES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}USED_TITLES (
    ID int(10) unsigned NOT NULL auto_increment,
    TITLE_ID int(11) NOT NULL,
    MEMBER_ID int(11) default NULL,
    STATUS int(11) default NULL,
    ADDED int(11) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}VOTES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}VOTES (
    VOTE_ID int(10) unsigned NOT NULL auto_increment,
    SURVEY_ID int(11) default NULL,
    OPTION_ID int(11) default NULL,
    FORUM_ID int(11) default NULL,
    TOPIC_ID int(11) default NULL,
    MEMBER_ID int(11) default NULL,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (VOTE_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}NOTIFY", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}NOTIFY (
    NOTIFY_ID int(10) unsigned NOT NULL auto_increment,
    STATUS int(11) default '1',
    FORUM_ID int(11) default '0',
    TOPIC_ID int(11) default '0',
    REPLY_ID int(11) default '0',
    AUTHOR_ID int(11) default '0',
    AUTHOR_NAME varchar(40) default NULL,
    POSTAUTHOR_ID int(11) default '0',
    POSTAUTHOR_NAME varchar(40) default NULL,
    DATE int(10) unsigned default NULL,
    TYPE varchar(100) default NULL,
    SUBJECT varchar(100) default NULL,
    R_ID int(11) default '0',
    R_MSG varchar(100) default NULL,
    R_DATE int(10) unsigned default NULL,
    NOTE_BY int(11) default '0',
    NOTES varchar(100) default NULL,
    NOTE_DATE int(10) unsigned default NULL,
    TRANSFER_BY int(11) default '0',
    TRANSFER_DATE int(10) unsigned default NULL,
    N_DONE int(11) default '0',
    PRIMARY KEY  (NOTIFY_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}MODERATION", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}MODERATION (
    MODERATION_ID int(11) NOT NULL auto_increment,
    M_STATUS int(11) default '0',
    M_MEMBERID int(11) default '0',
    M_FORUMID int(11) default '0',
    M_TOPICID int(11) default '0',
    M_REPLYID int(11) default '0',
    M_PM int(11) default '0',
    M_ADDED int(11) default '0',
    M_EXECUTE int(11) default '0',
    M_END int(11) default '0',
    M_MODERATOR_NOTES varchar(100) default NULL,
    M_TYPE int(11) default '0',
    M_RAISON varchar(100) default NULL,
    M_DATE int(10) unsigned default NULL,
    M_DATEAPP int(10) unsigned default NULL,
    M_DATEFIN int(10) unsigned default NULL,
    PRIMARY KEY  (MODERATION_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}EDITS_INFO", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}EDITS_INFO (
    EDIT_ID int(11) NOT NULL auto_increment,
    MEMBER_ID int(11) default '0',
    TOPIC_ID int(11) default '0',
    REPLY_ID int(11) default '0',
    OLD_SUBJECT varchar(100) default NULL,
    OLD_MESSAGE text,
    NEW_SUBJECT varchar(100) default NULL,
    NEW_MESSAGE text,
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (EDIT_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}LIST", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}LIST (
    ID int(11) NOT NULL auto_increment,
    `NAME` varchar(100) NOT NULL,
    M_ID int(11) NOT NULL,
    EDITFOLDER int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}LIST_M", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}LIST_M (
    ID int(11) NOT NULL auto_increment,
    M_ID int(11) NOT NULL,
    CAT_ID int(11) NOT NULL,
    `USER` int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}IP", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}IP (
    ID int(11) NOT NULL auto_increment,
    IP mediumtext NOT NULL,
    `DATE` int(11) NOT NULL,
    COUNTRY mediumtext NOT NULL,
    `TYPE` int(11) NOT NULL,
    M_ID int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}HIDE_INFO", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}HIDE_INFO (
    HIDE_ID int(11) NOT NULL auto_increment,
    STATUS int(11) default '0',
    MEMBER_ID int(11) default '0',
    TOPIC_ID int(11) default '0',
    REPLY_ID int(11) default '0',
    DATE int(10) unsigned default NULL,
    PRIMARY KEY  (HIDE_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}FORUM_ORDER", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}FORUM_ORDER (
    FO_ID int(11) NOT NULL auto_increment,
    FORUM_ID int(11) default NULL,
    FO_POINTS int(11) default NULL,
    FO_OLD_POINTS int(11) default NULL,
    FO_ORDER int(11) default '0',
    FO_OLD_ORDER int(11) default NULL,
    PRIMARY KEY  (FO_ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}TEMPLATES", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}TEMPLATES (
    ID int(11) NOT NULL auto_increment,
    NAME varchar(100) NOT NULL,
    STYLE_NAME varchar(250) NOT NULL,
    SOURCE text NOT NULL,
    OLD_SOURCE text NOT NULL,
    DATE int(11) NOT NULL,
    LAST_DATE int(11) NOT NULL,
    LAST_MEMBER varchar(100) NOT NULL,
    MEMBER varchar(100) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}IP_BAN", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}IP_BAN (
    ID int(11) NOT NULL auto_increment,
    IP varchar(100) NOT NULL,
    DATE int(11) NOT NULL,
    WHY varchar(250) NOT NULL,
    DATE_UNBAN int(11) NOT NULL,
    HWO int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}SEARCH", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}SEARCH (
    ID int(11) NOT NULL auto_increment,
    QUERY varchar(250) NOT NULL,
    DATE int(11) NOT NULL,
    TYPE int(11) NOT NULL,
    MEMBER_ID int(11) NOT NULL,
    IN_USER varchar(250) NOT NULL,
    FORUM int(11) NOT NULL,
    M_LEVEL int(11) NOT NULL,
    MONTH int(11) NOT NULL,
    YEAR int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}ICON", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}ICON (
    ID int(11) NOT NULL auto_increment,
    `NAME` varchar(100) NOT NULL,
    URL mediumtext NOT NULL,
    ICON mediumtext NOT NULL,
    `LEVEL` int(11) NOT NULL,
    `TYPE` int(11) NOT NULL,
    PLACE int(11) NOT NULL,
    PRIMARY KEY  (ID))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}CEP_CAT", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}CEP_CAT (
    O_CATIDA int(11) unsigned NOT NULL auto_increment,
    O_CAT_NAMEA varchar(40) default NULL,
    O_CAT_URLA varchar(40) default NULL,
    PRIMARY KEY (O_CATIDA))
    ", [], __FILE__, __LINE__);

    $mysql->execute("DROP TABLE IF EXISTS {$mysql->prefix}CEP_FORUM", [], __FILE__, __LINE__);
    $mysql->execute("
    CREATE TABLE {$mysql->prefix}CEP_FORUM (
    O_FORUMIDA int(11) unsigned NOT NULL auto_increment,
    O_FORUM_NAMEA varchar(255) NOT NULL default 'NOT NULL',
    O_FORUM_URLA varchar(255) default NULL,
    O_FORUM_IP varchar(40) default NULL,
    O_FORUM_DATE int(10) unsigned default NULL,
    PRIMARY KEY (O_FORUMIDA))
    ", [], __FILE__, __LINE__);

    echo'
    <center>
        <table width="60%" border="1">
            <tr class="normal">
                <td class="list_center" align="center" colspan="10"><font size="5"><br>'.$lang['install']['setup_tables_was_god'].'</font><br><br>
                    <a href="index.php?step=2">'.$lang['install']['next'].'</a><br><br>
                </td>
            </tr>
        </table>
    </center>';

}
elseif( $step == 2 ){
    echo'
    <center>
    <form name="userinfo" method="POST" action="index.php?step=3">
    <input type="hidden" name="user_age">
    <table dir="rtl" class="grid" border="0" width="60%" cellspacing="1" cellpadding="4" bgcolor="#C0C0C0">
    <tr>
    <td class="cat" colspan="2" align="center">'.$lang['install']['site_info'].'</td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['site_name'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="text" name="forum_title" size="40" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['site_address'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="text" name="site_address" dir="ltr" size="40" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="cat" colspan="2" align="center">'.$lang['install']['admin_info'].'</td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['user_name'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="text" name="user_name" size="40" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['password'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="Password" name="user_password1" size="40" maxLength="30" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['confirm_password'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="Password" name="user_password2" size="40" maxLength="30" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="userdetails_data" bgcolor="#FFFFCC">&nbsp;'.$lang['install']['email'].'</td>
    <td class="userdetails_data" bgcolor="#FFFFCC"><input type="text" name="user_email" dir="ltr" size="40" style="font-weight: 700"></td>
    </tr>
    <tr>
    <td class="userdetails_data" colspan="2" align="middle" bgcolor="darkgreen"><input onclick="submitForm()" type="button" value="'.$lang['install']['next'].'"></td>
    </tr>
    </table>
    </form>
    </center>';
}
elseif( $step == "3" ){

    $ForumTitle = $_POST["forum_title"];
    $SiteAddress = $_POST["site_address"];
    $UserName = $_POST["user_name"];
    $Password = $_POST["user_password1"];
    $Email = $_POST["user_email"];
    $IP = $_SERVER["REMOTE_ADDR"];
    $DIR = $_SERVER["SCRIPT_NAME"];
    $date = time();

    $mysql->insert_config("FORUM_TITLE", $ForumTitle);
    $mysql->insert_config("FORUM_TITLE2", $ForumTitle);
    $mysql->insert_config("SITE_ADDRESS", $SiteAddress);
    $mysql->insert_config("COPY_RIGHT", "Dilovan Matini 2007 - "._this_year);
    $mysql->insert_config("IMAGE_FOLDER", "images/");
    $mysql->insert_config("ADMIN_FOLDER", "admin");
    $mysql->insert_config("PAGE_NUMBER", "40");
    $mysql->insert_config("ADMIN_EMAIL", $Email);
    $mysql->insert_config("AUTHOR_SCRIPT", "Dilovan Matini 2007 - "._this_year);
    $mysql->insert_config("FORUM_VERSION", "2.0");
    $mysql->insert_config("FORUM_META", "This is a discussion forum powered by Duhok Forum");
    $mysql->insert_config("FORUM_KEY", "Duhok,Forum,PHP,Mysql,Dev");
    $mysql->insert_config("FORUM_BANWORDS", "script,SCRIPT,meta,META");
    $mysql->insert_config("FORUM_SEO", "0");
    $mysql->insert_config("NEW_MEMBER_MIN_POSTS_PM", "50");
    $mysql->insert_config("TOTAL_PM_MSG", "20");
    $mysql->insert_config("TOTAL_POST_CLOSE_TOPIC", "500");
    $mysql->insert_config("MOD_ADD_TITLES", "0");
    $mysql->insert_config("TITLE_0", $lang['install']['title_member_one']);
    $mysql->insert_config("TITLE_1", $lang['install']['title_member_two']);
    $mysql->insert_config("TITLE_2", $lang['install']['title_member_three']);
    $mysql->insert_config("TITLE_3", $lang['install']['title_member_four']);
    $mysql->insert_config("TITLE_4", $lang['install']['title_member_five']);
    $mysql->insert_config("TITLE_5", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_6", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_7", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_8", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_9", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_10", $lang['install']['title_member_six']);
    $mysql->insert_config("TITLE_11", $lang['install']['title_moderator']);
    $mysql->insert_config("TITLE_12", $lang['install']['title_monitor']);
    $mysql->insert_config("TITLE_13", $lang['install']['title_admin']);
    $mysql->insert_config("TITLE_0_FEMALE", $lang['install']['title_member_one_female']);
    $mysql->insert_config("TITLE_1_FEMALE", $lang['install']['title_member_two_female']);
    $mysql->insert_config("TITLE_2_FEMALE", $lang['install']['title_member_three_female']);
    $mysql->insert_config("TITLE_3_FEMALE", $lang['install']['title_member_four_female']);
    $mysql->insert_config("TITLE_4_FEMALE", $lang['install']['title_member_five_female']);
    $mysql->insert_config("TITLE_5_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_6_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_7_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_8_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_9_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_10_FEMALE", $lang['install']['title_member_six_female']);
    $mysql->insert_config("TITLE_11_FEMALE", $lang['install']['title_moderator_female']);
    $mysql->insert_config("TITLE_12_FEMALE", $lang['install']['title_monitor_female']);
    $mysql->insert_config("TITLE_13_FEMALE", $lang['install']['title_admin_female']);
    $mysql->insert_config("MLV_STARS_COLOR_0", "");
    $mysql->insert_config("MLV_STARS_COLOR_1", "green");
    $mysql->insert_config("MLV_STARS_COLOR_2", "red");
    $mysql->insert_config("MLV_STARS_COLOR_3", "gold");
    $mysql->insert_config("MLV_STARS_COLOR_4", "blue");
    $mysql->insert_config("STARS_NUMBER_0", "0");
    $mysql->insert_config("STARS_NUMBER_1", "30");
    $mysql->insert_config("STARS_NUMBER_2", "100");
    $mysql->insert_config("STARS_NUMBER_3", "500");
    $mysql->insert_config("STARS_NUMBER_4", "1000");
    $mysql->insert_config("STARS_NUMBER_5", "2000");
    $mysql->insert_config("STARS_NUMBER_6", "3000");
    $mysql->insert_config("STARS_NUMBER_7", "4000");
    $mysql->insert_config("STARS_NUMBER_8", "5000");
    $mysql->insert_config("STARS_NUMBER_9", "6000");
    $mysql->insert_config("STARS_NUMBER_10", "7000");

    $mysql->insert_config("TOPIC_MAX_SIZE", "512000");
    $mysql->insert_config("REPLY_MAX_SIZE", "512000");
    $mysql->insert_config("PM_MAX_SIZE", "102400");
    $mysql->insert_config("SIG_MAX_SIZE", "51200");
    $mysql->insert_config("DEFAULT_LANGUAGE", "arabic");
    $mysql->insert_config("DEFAULT_STYLE", "green");
    $mysql->insert_config("FORUM_URL", "");

    $mysql->insert_config("COLOR_0", "#999999");
    $mysql->insert_config("COLOR_1", "");
    $mysql->insert_config("COLOR_2", "#cc0033");
    $mysql->insert_config("COLOR_3", "#cc8811");
    $mysql->insert_config("COLOR_4", "blue");

    $mysql->insert_config("CAN_SHOW_PM",0);
    $mysql->insert_config("CAN_CLOSE_M",0);
    $mysql->insert_config("CAN_OPEN_M",0);

    $mysql->insert_config("CAN_SHOW_FORUM",0);
    $mysql->insert_config("CAN_SHOW_TOPIC",0);
    $mysql->insert_config("CAN_SHOW_PROFILE",1);

    $mysql->insert_config("FTP_ACTIVE",0);
    $mysql->insert_config("FTP_SERVER","");
    $mysql->insert_config("FTP_USER","");
    $mysql->insert_config("FTP_PASS","");


    $mysql->insert_config("SHOW_ADMIN_INFO", 0);
    $mysql->insert_config("SHOW_ADMIN_TOPICS", 0);
    $mysql->insert_config("MOD_ADD_MEDALS", 0);
    $mysql->insert_config("CHANGE_NAME_MAX", 4);
    $mysql->insert_config("CHANGENAME_DAYSLIMIT", 30);
    $mysql->insert_config("SHOW_MODERATORS", 1);
    $mysql->insert_config("FILES_MAX_SIZE", 1024000);
    $mysql->insert_config("FILES_MAX_ALLOWED", 102400);
    $mysql->insert_config("HELP_FORUM", 0);
    $mysql->insert_config("SITE_TIMEZONE", "3");
    $mysql->insert_config("FORUM_STATUS", "0");
    $mysql->insert_config("MAX_SEARCH", 100);

    $mysql->insert_config("SHOW_ALEXA_TRAFFIC", 1);
    $mysql->insert_config("REGISTER_WAITTING", 1);
    $mysql->insert_config("SHOW_MEDALS_IN_POSTS", 1);
    $mysql->insert_config("NEW_MEMBER_MIN_POSTS", 0);

    $mysql->insert_config("MAX_LIST_CAT_MEMBERS", 5);
    $mysql->insert_config("MAX_LIST_M_MEMBERS", 10);
    $mysql->insert_config("MAX_LIST_CAT_MODERATORS", 10);
    $mysql->insert_config("MAX_LIST_M_MODERATORS", 60);

    $mysql->insert_config("EDITOR_FULL_HTML", "false");
    $mysql->insert_config("EDITOR_WIDTH", "100%");
    $mysql->insert_config("EDITOR_HEIGHT", "100%");
    $mysql->insert_config("EDITOR_ICON_SAVE", "false");
    $mysql->insert_config("EDITOR_ICON_PRINT", "false");
    $mysql->insert_config("EDITOR_ICON_ZOOM", "false");
    $mysql->insert_config("EDITOR_ICON_STYLE", "false");
    $mysql->insert_config("EDITOR_ICON_PARAGRAPH", "false");
    $mysql->insert_config("EDITOR_ICON_FONT_NAME", "true");
    $mysql->insert_config("EDITOR_ICON_SIZE", "true");
    $mysql->insert_config("EDITOR_ICON_TEXT", "false");
    $mysql->insert_config("EDITOR_ICON_SELECT_ALL", "false");
    $mysql->insert_config("EDITOR_ICON_CUT", "true");
    $mysql->insert_config("EDITOR_ICON_COPY", "true");
    $mysql->insert_config("EDITOR_ICON_PASTE", "true");
    $mysql->insert_config("EDITOR_ICON_UNDO", "true");
    $mysql->insert_config("EDITOR_ICON_REDO", "true");
    $mysql->insert_config("EDITOR_ICON_BOLD", "true");
    $mysql->insert_config("EDITOR_ICON_ITALIC", "true");
    $mysql->insert_config("EDITOR_ICON_UNDER_LINE", "true");
    $mysql->insert_config("EDITOR_ICON_STRIKE", "true");
    $mysql->insert_config("EDITOR_ICON_SUPER_SCRIPT", "false");
    $mysql->insert_config("EDITOR_ICON_SUB_SCRIPT", "false");
    $mysql->insert_config("EDITOR_ICON_SYMBOL", "true");
    $mysql->insert_config("EDITOR_ICON_LEFT", "true");
    $mysql->insert_config("EDITOR_ICON_CENTER", "true");
    $mysql->insert_config("EDITOR_ICON_RIGHT", "true");
    $mysql->insert_config("EDITOR_ICON_FULL", "true");
    $mysql->insert_config("EDITOR_ICON_NUBERING", "true");
    $mysql->insert_config("EDITOR_ICON_BULLETS", "true");
    $mysql->insert_config("EDITOR_ICON_INDENT", "true");
    $mysql->insert_config("EDITOR_ICON_OUTDENT", "true");
    $mysql->insert_config("EDITOR_ICON_IMAGE", "true");
    $mysql->insert_config("EDITOR_ICON_COLOR", "true");
    $mysql->insert_config("EDITOR_ICON_BGCOLOR", "true");
    $mysql->insert_config("EDITOR_ICON_EX_LINK", "true");
    $mysql->insert_config("EDITOR_ICON_IN_LINK", "false");
    $mysql->insert_config("EDITOR_ICON_ASSET", "false");
    $mysql->insert_config("EDITOR_ICON_TABLE", "true");
    $mysql->insert_config("EDITOR_ICON_SHOW_BORDER", "false");
    $mysql->insert_config("EDITOR_ICON_ABSOLUTE", "false");
    $mysql->insert_config("EDITOR_ICON_CLEAN", "false");
    $mysql->insert_config("EDITOR_ICON_LINE", "true");
    $mysql->insert_config("EDITOR_ICON_PROPERTIES", "true");
    $mysql->insert_config("EDITOR_ICON_WORD", "true");
    $mysql->insert_config("logos","images/logos/logo.gif");
    $mysql->insert_config("BEST", 1);
    $mysql->insert_config("BEST_MEM", 1);
    $mysql->insert_config("BEST_TOPIC", 1);
    $mysql->insert_config("BEST_MOD", 1);
    $mysql->insert_config("BEST_FRM", 1);
    $mysql->insert_config("BEST_T", "لوحة الشرف");
    $mysql->insert_config("BEST_MEM_T", "العضو المميز لهذا الشهر");
    $mysql->insert_config("BEST_TOPIC_T", "الموضوع المميز لهذا الشهر");
    $mysql->insert_config("BEST_MOD_T", "المشرف المميز لهذا الشهر");
    $mysql->insert_config("BEST_FRM_T", "المنتدى المميز لهذا الشهر");
    $mysql->insert_config("close", "الموقع تحت الصيانة حاليا .. الرجاء المحاولة بعد عدة دقائق");
    $mysql->insert_config("note", "بسم الله الرحمان الرحيم");
    $mysql->insert_config("NEW_MEMBER_MIN_SEARCH", "35");
    $mysql->insert_config("NEW_MEMBER_SHOW_TOPIC", "35");
    $mysql->insert_config("NEW_MEMBER_CHANGE_NAME", "35");
    $mysql->insert_config("ad", "0");
    $mysql->insert_config("ad1", "github.com/dilovanmatini/duhok-forum");
    $mysql->insert_config("ad2", "دهوك فوروم");
    $mysql->insert_config("ad3", "images/logos/logo.gif");
    $mysql->insert_config("ad4", "157");
    $mysql->insert_config("ad5", "75");
    $mysql->insert_config("ad6", "center");
    $mysql->insert_config("pb", "0");
    $mysql->insert_config("pb1", "facebook.com");
    $mysql->insert_config("pb2", "Facebook");
    $mysql->insert_config("pb3", "images/logos/logo.gif");
    $mysql->insert_config("pb4", "157");
    $mysql->insert_config("pb5", "75");
    $mysql->insert_config("pb6", "center");
    $mysql->insert_config("pub", "0");
    $mysql->insert_config("pub1", "twitter.com");
    $mysql->insert_config("pub2", "Twitter");
    $mysql->insert_config("pub3", "images/logos/logo.gif");
    $mysql->insert_config("pub4", "157");
    $mysql->insert_config("pub5", "75");
    $mysql->insert_config("pub6", "center");
    $mysql->insert_config("pubs", "0");
    $mysql->insert_config("pubs1", "www.yahoo.com");
    $mysql->insert_config("pubs2", "Yahoo");
    $mysql->insert_config("pubs3", "images/logos/logo.gif");
    $mysql->insert_config("pubs4", "157");
    $mysql->insert_config("pubs5", "75");
    $mysql->insert_config("pubs6", "center");
    $mysql->insert_config("FORUM_MSG", "أنت غير مسجل في");
    $mysql->insert_config("FORUM_MSG1", "للتسجيل الرجاء اضغط");
    $mysql->insert_config("FORUM_MSG2", "هنـا");
    $mysql->insert_config("WHAT_ACTIVE", 0);
    $mysql->insert_config("WHAT_TITLE", "الإهدائات");
    $mysql->insert_config("WHAT_SIZE", 10);
    $mysql->insert_config("WHAT_ADMIN_SHOW", 1);
    $mysql->insert_config("WHAT_LIMIT", 10);
    $mysql->insert_config("WHAT_FASEL", "|+|");
    $mysql->insert_config("WHAT_COLOR", "blue");
    $mysql->insert_config("WHAT_ALL", 1);
    $mysql->insert_config("WHAT_DIRECTION","right");

    $mysql->insert_config("ACTIVE_SCHAT","");
    $mysql->insert_config("VISITOR_SCHAT","");
    $mysql->insert_config("NUM_SCHAT","");
    $mysql->insert_config("ACTIVE_ROOM","");
    $mysql->insert_config("NBR_MAX_POST_SCHAT","");
    $mysql->insert_config("BOSS_SCHAT","");
    $mysql->insert_config("SCHAT_URL","");
    $mysql->insert_config("FORUMID_MON_SCHAT","");
    $mysql->insert_config("ACTIVE_SCHAT_SMILE","");
    $mysql->insert_config("editor_topic","");
    $mysql->insert_config("editor_msg","");
    $mysql->insert_config("editor_style","");
    $mysql->insert_config("BAR","");
    $mysql->insert_config("BAR1","");
    $mysql->insert_config("BAR2","");
    $mysql->insert_config("BAR3","");
    $mysql->insert_config("MSG","");
    $mysql->insert_config("timezone",3);

    $Password = MD5($Password);
    $mysql->execute("INSERT INTO {$mysql->prefix}MEMBERS (MEMBER_ID, M_NAME, M_PASSWORD, M_LEVEL, M_EMAIL, M_POSTS, M_DATE, M_LAST_HERE_DATE, M_LAST_POST_DATE, M_IP, M_LAST_IP) VALUES (NULL, '$UserName', '$Password', '4', '$Email', '1', '$date', '$date', '$date', '$IP', '$IP')", [], __FILE__, __LINE__);
    $mysql->execute("INSERT INTO {$mysql->prefix}CATEGORY (CAT_ID, CAT_NAME, SITE_ID) VALUES (NULL, '".$lang['install']['test_cat']."', 1)", [], __FILE__, __LINE__);

    $query3 = "INSERT INTO {$mysql->prefix}FORUM (FORUM_ID, CAT_ID, F_SUBJECT, F_DESCRIPTION, F_LOGO, F_TOPICS, F_REPLIES, F_LAST_POST_DATE, F_LAST_POST_AUTHOR) VALUES (NULL, ";
    $query3 .= " '1', ";
    $query3 .= " '".$lang['install']['test_forum']."', ";
    $query3 .= " '".$lang['install']['test_forum_subject']." DUHOK FORUM', ";
    $query3 .= " 'images/forum-logo/logo-1.gif', "; 
    $query3 .= " '1', ";
    $query3 .= " '1', ";
    $query3 .= " '$date', ";
    $query3 .= " '1') ";

    $mysql->execute($query3, [], __FILE__, __LINE__);

    $query4 = "INSERT INTO {$mysql->prefix}TOPICS (TOPIC_ID, FORUM_ID, CAT_ID, T_SUBJECT, T_MESSAGE, T_DATE, T_AUTHOR) VALUES (NULL, ";
    $query4 .= " '1', ";
    $query4 .= " '1', ";
    $query4 .= " '".$lang['install']['test_topic_subject']." DUHOK FORUM', ";
    $query4 .= " '".$lang['install']['test_topic_message']." DUHOK FORUM ', ";
    $query4 .= " '$date', ";
    $query4 .= " '1') ";

    $mysql->execute($query4, [], __FILE__, __LINE__);

    $mysql->execute("INSERT INTO {$mysql->prefix}STYLE (S_ID, S_FILE_NAME, S_NAME) VALUES (NULL, 'green', '".$lang['install']['green']."') ", [], __FILE__, __LINE__);
    $mysql->execute("INSERT INTO {$mysql->prefix}STYLE (S_ID, S_FILE_NAME, S_NAME) VALUES (NULL, 'stars', '".$lang['install']['stars']."') ", [], __FILE__, __LINE__);
    $mysql->execute("INSERT INTO {$mysql->prefix}LANGUAGE (L_ID, L_FILE_NAME, L_NAME) VALUES (NULL, 'arabic', '".$lang['global']['lang_name']."') ", [], __FILE__, __LINE__);
    $mysql->execute("INSERT INTO {$mysql->prefix}LANGUAGE (L_ID, L_FILE_NAME, L_NAME) VALUES (NULL, 'english', 'english') ", [], __FILE__, __LINE__);

    echo'
    <center>
        <table width="60%" border="1">
            <tr class="normal">
                <td class="list_center" align="center" colSpan="10"><font size="5"><br>'.$lang['install']['setup_forum_was_god_but_delete_install_file'].'</font><br><br>
                    <a href="../index.php">'.$lang['install']['click_here_to_home'].'</a><br><br>
                </td>
            </tr>
        </table>
    </center>';
}

?>

</body>
</html>
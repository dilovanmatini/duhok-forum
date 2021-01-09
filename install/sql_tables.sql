DROP TABLE IF EXISTS _prfx_bad_words;
CREATE TABLE _prfx_bad_words (
  id int(10) UNSIGNED NOT NULL,
  code varchar(100) NOT NULL,
  val varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_blocks;
CREATE TABLE _prfx_blocks (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  blockid int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_category;
CREATE TABLE _prfx_category (
  id int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  sort tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  monitor int(10) UNSIGNED NOT NULL DEFAULT '0',
  archive tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `hidden` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemonhome tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemoninfo tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemonprofile tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  submonitor int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_changename;
CREATE TABLE _prfx_changename (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  userid int(10) UNSIGNED NOT NULL,
  `newname` varchar(50) NOT NULL,
  oldname varchar(50) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_chat;
CREATE TABLE _prfx_chat (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_complain;
CREATE TABLE _prfx_complain (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '3',
  forumid smallint(5) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  postid int(10) UNSIGNED NOT NULL,
  posttype tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  notetype tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  notetext mediumtext NOT NULL,
  sendby int(10) UNSIGNED NOT NULL,
  senddate int(10) UNSIGNED NOT NULL,
  replyby int(10) UNSIGNED NOT NULL,
  replytext mediumtext NOT NULL,
  replydate int(10) UNSIGNED NOT NULL,
  adminread tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  admintext mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_config;
CREATE TABLE _prfx_config (
  id int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  variable varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_country;
CREATE TABLE _prfx_country (
  id int(10) UNSIGNED NOT NULL,
  code char(2) NOT NULL,
  `name` char(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_cpvisit;
CREATE TABLE _prfx_cpvisit (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_favorite;
CREATE TABLE _prfx_favorite (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_forum;
CREATE TABLE _prfx_forum (
  id int(10) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  logo varchar(255) NOT NULL,
  sort tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  topics int(10) UNSIGNED NOT NULL DEFAULT '0',
  posts int(10) UNSIGNED NOT NULL DEFAULT '0',
  lpauthor int(10) UNSIGNED NOT NULL DEFAULT '0',
  lpdate int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `hidden` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  sex tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  archive tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  hidemodhome tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemodforum tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  topic_show int(11) UNSIGNED NOT NULL DEFAULT '0',
  topic_appearance tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  moderateurl int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_forumbrowse;
CREATE TABLE _prfx_forumbrowse (
  id int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  visit int(10) UNSIGNED NOT NULL DEFAULT '1',
  `year` smallint(4) UNSIGNED ZEROFILL NOT NULL,
  `month` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `day` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  hour tinyint(2) UNSIGNED ZEROFILL NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_forumflag;
CREATE TABLE _prfx_forumflag (
  id smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  pmlists mediumtext NOT NULL,
  archivedays smallint(5) UNSIGNED NOT NULL DEFAULT '30',
  totaltopics smallint(5) UNSIGNED NOT NULL DEFAULT '5',
  totalposts smallint(5) UNSIGNED NOT NULL DEFAULT '200',
  moderatetopics tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  moderateposts tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemodinfo tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidemodeprofile tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidesignature tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hideprofile tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidephoto tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidepm tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_forumusers;
CREATE TABLE _prfx_forumusers (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_fpass;
CREATE TABLE _prfx_fpass (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  userid int(10) UNSIGNED NOT NULL,
  randcode char(32) NOT NULL,
  sendip int(11) NOT NULL,
  confirmip int(11) NOT NULL,
  confirmdate int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_friends;
CREATE TABLE _prfx_friends (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  userid int(11) NOT NULL,
  friendid int(11) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_hacker;
CREATE TABLE _prfx_hacker (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL DEFAULT '0',
  ip int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  referer varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_ipban;
CREATE TABLE _prfx_ipban (
  id int(10) UNSIGNED NOT NULL,
  ip int(11) NOT NULL,
  cause mediumtext,
  fromdate int(10) UNSIGNED NOT NULL,
  todate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_language;
CREATE TABLE _prfx_language (
  id int(10) UNSIGNED NOT NULL,
  `subject` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_listsrows;
CREATE TABLE _prfx_listsrows (
  id int(10) UNSIGNED NOT NULL,
  items text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_loginip;
CREATE TABLE _prfx_loginip (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  ip int(11) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_loginsession;
CREATE TABLE _prfx_loginsession (
  id int(11) UNSIGNED NOT NULL,
  `hash` char(32) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  userid int(11) UNSIGNED NOT NULL,
  ip char(11) NOT NULL,
  useragent text NOT NULL,
  lastdate int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_medal;
CREATE TABLE _prfx_medal (
  id int(10) UNSIGNED NOT NULL,
  listid int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  added int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_medallists;
CREATE TABLE _prfx_medallists (
  id int(10) UNSIGNED NOT NULL,
  forumid mediumint(8) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `days` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  points tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `filename` varchar(50) NOT NULL,
  `close` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  added int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_medalphotos;
CREATE TABLE _prfx_medalphotos (
  id int(10) UNSIGNED NOT NULL,
  forumid mediumint(8) UNSIGNED NOT NULL,
  `filename` varchar(50) NOT NULL,
  added int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_modactivity;
CREATE TABLE _prfx_modactivity (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  points smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_moderator;
CREATE TABLE _prfx_moderator (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_moderator_block;
CREATE TABLE _prfx_moderator_block (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  block_id int(10) UNSIGNED NOT NULL,
  cause varchar(255) NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  step tinyint(4) NOT NULL DEFAULT '1',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_mon;
CREATE TABLE _prfx_mon (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  userid int(10) UNSIGNED NOT NULL,
  forumid mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  montype tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  addedby int(10) UNSIGNED NOT NULL,
  addeddate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_monflag;
CREATE TABLE _prfx_monflag (
  id int(10) UNSIGNED NOT NULL,
  postid int(10) UNSIGNED NOT NULL DEFAULT '0',
  posttype tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  usernote mediumtext CHARACTER SET latin1 NOT NULL,
  monnote mediumtext CHARACTER SET latin1 NOT NULL,
  agreeby int(10) UNSIGNED NOT NULL DEFAULT '0',
  agreedate int(10) UNSIGNED NOT NULL,
  upby int(10) UNSIGNED NOT NULL DEFAULT '0',
  upmdate int(10) UNSIGNED NOT NULL,
  refby int(10) UNSIGNED NOT NULL DEFAULT '0',
  refdate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_notification;
CREATE TABLE _prfx_notification (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  author int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `type` char(3) NOT NULL,
  topicid int(10) UNSIGNED NOT NULL DEFAULT '0',
  postid int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_online;
CREATE TABLE _prfx_online (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  hidebrowse tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  ip int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL,
  lastdate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_photos;
CREATE TABLE _prfx_photos (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `filename` varchar(100) NOT NULL,
  filetype varchar(100) NOT NULL,
  filesize int(10) UNSIGNED NOT NULL DEFAULT '0',
  filetitle varchar(255) NOT NULL,
  phototype varchar(20) NOT NULL,
  targettype varchar(30) NOT NULL,
  targetid int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  sdescription varchar(255) NOT NULL,
  addby int(10) UNSIGNED NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_pm;
CREATE TABLE _prfx_pm (
  id int(10) UNSIGNED NOT NULL,
  author int(10) NOT NULL,
  sender int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  redeclare int(10) UNSIGNED NOT NULL DEFAULT '0',
  pmlist tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  pmfrom int(10) NOT NULL,
  pmto int(10) NOT NULL,
  pmread tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  pmout tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  reply tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_pmmessage;
CREATE TABLE _prfx_pmmessage (
  id int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_post;
CREATE TABLE _prfx_post (
  id int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  redeclare int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hidden` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  moderate tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  trash tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  author int(10) UNSIGNED NOT NULL,
  editby int(10) UNSIGNED NOT NULL,
  editdate int(10) UNSIGNED NOT NULL,
  editnum smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_postmessage;
CREATE TABLE _prfx_postmessage (
  id int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  operations text NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_style;
CREATE TABLE _prfx_style (
  id int(10) UNSIGNED NOT NULL,
  `subject` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_survey;
CREATE TABLE _prfx_survey (
  id int(10) UNSIGNED NOT NULL,
  forumid int(10) UNSIGNED NOT NULL,
  question varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `secret` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `days` int(10) UNSIGNED NOT NULL DEFAULT '0',
  posts int(10) UNSIGNED NOT NULL DEFAULT '0',
  added int(10) UNSIGNED NOT NULL,
  `start` int(10) UNSIGNED NOT NULL,
  `end` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_surveyoptions;
CREATE TABLE _prfx_surveyoptions (
  id int(10) UNSIGNED NOT NULL,
  surveyid int(10) UNSIGNED NOT NULL,
  votes int(10) UNSIGNED NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL,
  other varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_surveyvotes;
CREATE TABLE _prfx_surveyvotes (
  id int(10) UNSIGNED NOT NULL,
  surveyid int(10) UNSIGNED NOT NULL,
  optionid int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_template;
CREATE TABLE _prfx_template (
  id int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `text` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_title;
CREATE TABLE _prfx_title (
  id int(10) UNSIGNED NOT NULL,
  listid int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_titlelists;
CREATE TABLE _prfx_titlelists (
  id int(10) UNSIGNED NOT NULL,
  forumid mediumint(8) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `global` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  added int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_titleuse;
CREATE TABLE _prfx_titleuse (
  id int(10) UNSIGNED NOT NULL,
  listid int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  added int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_topic;
CREATE TABLE _prfx_topic (
  id int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  redeclare int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `hidden` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  sticky tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  moderate tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  trash tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  archive tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  survey int(10) UNSIGNED NOT NULL DEFAULT '0',
  `top` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  link tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  author int(10) UNSIGNED NOT NULL,
  posts smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  views int(10) UNSIGNED NOT NULL DEFAULT '0',
  lpauthor int(10) UNSIGNED NOT NULL,
  lpdate int(10) UNSIGNED NOT NULL,
  editby int(10) UNSIGNED NOT NULL,
  editdate int(10) UNSIGNED NOT NULL,
  editnum smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  allownotify text NOT NULL,
  viewforusers tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_topicarchive;
CREATE TABLE _prfx_topicarchive (
  id int(10) UNSIGNED NOT NULL,
  forumid mediumint(8) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  author int(10) UNSIGNED NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_topicedit;
CREATE TABLE _prfx_topicedit (
  id int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_topicmessage;
CREATE TABLE _prfx_topicmessage (
  id int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  operations text NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_topicusers;
CREATE TABLE _prfx_topicusers (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  topicid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  addby int(10) UNSIGNED NOT NULL,
  adddate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_trylogin;
CREATE TABLE _prfx_trylogin (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  ip int(11) NOT NULL,
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_user;
CREATE TABLE _prfx_user (
  id int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  active tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  entername varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  keycode char(32) NOT NULL,
  code char(3) NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `date` int(10) UNSIGNED NOT NULL,
  submonitor int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_useractivity;
CREATE TABLE _prfx_useractivity (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL,
  catid smallint(5) UNSIGNED NOT NULL,
  points smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_userflag;
CREATE TABLE _prfx_userflag (
  id int(10) UNSIGNED NOT NULL,
  email varchar(100) NOT NULL,
  title varchar(255) NOT NULL,
  picture varchar(255) NOT NULL,
  photo varchar(255) NOT NULL,
  sex tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  brithday DATE NULL DEFAULT NULL,
  age tinyint(3) UNSIGNED NOT NULL,
  country char(2) NOT NULL,
  best_player varchar(255) NOT NULL,
  best_club varchar(255) NOT NULL,
  best_team varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  city varchar(255) NOT NULL,
  ip int(11) NOT NULL,
  allip text NOT NULL,
  ips text NOT NULL,
  marstatus varchar(255) NOT NULL,
  biography mediumtext NOT NULL,
  occupation varchar(255) NOT NULL,
  `signature` mediumtext NOT NULL,
  style varchar(255) NOT NULL,
  lists mediumtext NOT NULL,
  pmlists mediumtext NOT NULL,
  posts int(10) UNSIGNED NOT NULL DEFAULT '0',
  points int(10) UNSIGNED NOT NULL DEFAULT '0',
  medalid int(10) UNSIGNED NOT NULL DEFAULT '0',
  views int(10) UNSIGNED NOT NULL DEFAULT '0',
  lpid int(10) UNSIGNED NOT NULL,
  lptype enum('post','topic') NOT NULL DEFAULT 'post',
  lpdate int(10) UNSIGNED NOT NULL,
  lhdate int(10) UNSIGNED NOT NULL,
  oldlevel tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  balance double NOT NULL DEFAULT '0',
  agree int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_userlock;
CREATE TABLE _prfx_userlock (
  id int(10) UNSIGNED NOT NULL,
  userid int(10) UNSIGNED NOT NULL,
  cause mediumtext NOT NULL,
  lockedby int(10) UNSIGNED NOT NULL,
  lockeddate int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_useronline;
CREATE TABLE _prfx_useronline (
  ip int(11) NOT NULL,
  userid int(11) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  forumid smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  hidebrowse tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_userperm;
CREATE TABLE _prfx_userperm (
  id int(10) UNSIGNED NOT NULL,
  receiveemail tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  receivepm tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  changename tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  changeentername tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidephoto tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidesignature tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidearchive tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideusers tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidesearch tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidefavorite tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidebrowse tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidetopics tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideposts tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hidepm tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideselftopics tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideuserstopics tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideselfposts tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideusersposts tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideselfprofile tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  hideusersprofile tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  stopsendpm tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  stopaddpost tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  postsundermon tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  uneditsignature tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  sendcomplain tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  dochat tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  allowfriendship tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  showfriends tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  showbirthday tinyint(1) UNSIGNED NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS _prfx_visitors;
CREATE TABLE _prfx_visitors (
  ip int(11) NOT NULL,
  forumid smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE _prfx_bad_words
  ADD PRIMARY KEY (id),
  ADD KEY code (code);

ALTER TABLE _prfx_blocks
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY blockid (blockid);

ALTER TABLE _prfx_category
  ADD PRIMARY KEY (id),
  ADD KEY csort (sort),
  ADD KEY sort (sort),
  ADD KEY monitor (monitor),
  ADD KEY archive (archive),
  ADD KEY `level` (`level`),
  ADD KEY `status` (`status`),
  ADD KEY `hidden` (`hidden`),
  ADD KEY hidemonhome (hidemonhome),
  ADD KEY hidemoninfo (hidemoninfo),
  ADD KEY hidemonprofile (hidemonprofile),
  ADD KEY submonitor (submonitor);

ALTER TABLE _prfx_changename
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY userid (userid);

ALTER TABLE _prfx_chat
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid);

ALTER TABLE _prfx_complain
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY forumid (forumid),
  ADD KEY userid (userid),
  ADD KEY postid (postid),
  ADD KEY posttype (posttype),
  ADD KEY notetype (notetype),
  ADD KEY sendby (sendby),
  ADD KEY replyby (replyby),
  ADD KEY adminread (adminread);

ALTER TABLE _prfx_config
  ADD PRIMARY KEY (id),
  ADD KEY `type` (`type`),
  ADD KEY variable (variable);

ALTER TABLE _prfx_country
  ADD PRIMARY KEY (id),
  ADD KEY code (code);

ALTER TABLE _prfx_cpvisit
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid);

ALTER TABLE _prfx_favorite
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY topicid (topicid);

ALTER TABLE _prfx_forum
  ADD PRIMARY KEY (id),
  ADD KEY catid (catid),
  ADD KEY sort (sort),
  ADD KEY `level` (`level`),
  ADD KEY `status` (`status`),
  ADD KEY `hidden` (`hidden`),
  ADD KEY sex (sex),
  ADD KEY archive (archive),
  ADD KEY hidemodhome (hidemodhome),
  ADD KEY hidemodforum (hidemodforum),
  ADD KEY topic_show (topic_show),
  ADD KEY topic_appearance (topic_appearance),
  ADD KEY moderateurl (moderateurl);

ALTER TABLE _prfx_forumbrowse
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY `year` (`year`),
  ADD KEY `month` (`month`),
  ADD KEY `day` (`day`),
  ADD KEY hour (hour);

ALTER TABLE _prfx_forumflag
  ADD PRIMARY KEY (id),
  ADD KEY catid (catid),
  ADD KEY archivedays (archivedays),
  ADD KEY totaltopics (totaltopics),
  ADD KEY totalposts (totalposts),
  ADD KEY moderatetopics (moderatetopics),
  ADD KEY moderateposts (moderateposts),
  ADD KEY hidemodinfo (hidemodinfo),
  ADD KEY hidemodeprofile (hidemodeprofile),
  ADD KEY hidesignature (hidesignature),
  ADD KEY hideprofile (hideprofile),
  ADD KEY hidephoto (hidephoto),
  ADD KEY hidepm (hidepm);

ALTER TABLE _prfx_forumusers
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid);

ALTER TABLE _prfx_fpass
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY userid (userid);

ALTER TABLE _prfx_friends
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY userid (userid),
  ADD KEY friendid (friendid);

ALTER TABLE _prfx_hacker
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid);

ALTER TABLE _prfx_ipban
  ADD PRIMARY KEY (id);

ALTER TABLE _prfx_language
  ADD PRIMARY KEY (id);

ALTER TABLE _prfx_listsrows
  ADD PRIMARY KEY (id);

ALTER TABLE _prfx_loginip
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid);

ALTER TABLE _prfx_loginsession
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY `status` (`status`);

ALTER TABLE _prfx_medal
  ADD PRIMARY KEY (id),
  ADD KEY listid (listid),
  ADD KEY userid (userid),
  ADD KEY `status` (`status`),
  ADD KEY added (added);

ALTER TABLE _prfx_medallists
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY `status` (`status`),
  ADD KEY `days` (`days`),
  ADD KEY points (points),
  ADD KEY `close` (`close`),
  ADD KEY added (added);

ALTER TABLE _prfx_medalphotos
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY added (added);

ALTER TABLE _prfx_modactivity
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid);

ALTER TABLE _prfx_moderator
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid),
  ADD KEY `block` (`block`);

ALTER TABLE _prfx_moderator_block
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY block_id (block_id),
  ADD KEY `type` (`type`),
  ADD KEY step (step);

ALTER TABLE _prfx_mon
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY montype (montype),
  ADD KEY addedby (addedby);

ALTER TABLE _prfx_monflag
  ADD PRIMARY KEY (id),
  ADD KEY postid (postid),
  ADD KEY posttype (posttype),
  ADD KEY agreeby (agreeby),
  ADD KEY upby (upby),
  ADD KEY refby (refby);

ALTER TABLE _prfx_notification
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY author (author),
  ADD KEY userid (userid),
  ADD KEY `type` (`type`),
  ADD KEY topicid (topicid),
  ADD KEY postid (postid);

ALTER TABLE _prfx_online
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY `level` (`level`),
  ADD KEY hidebrowse (hidebrowse);

ALTER TABLE _prfx_photos
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY `filename` (`filename`),
  ADD KEY phototype (phototype),
  ADD KEY targettype (targettype),
  ADD KEY targetid (targetid),
  ADD KEY addby (addby),
  ADD KEY `datetime` (`datetime`),
  ADD KEY sdescription (sdescription(30));

ALTER TABLE _prfx_pm
  ADD PRIMARY KEY (id),
  ADD KEY author (author),
  ADD KEY sender (sender),
  ADD KEY `status` (`status`),
  ADD KEY redeclare (redeclare),
  ADD KEY pmlist (pmlist),
  ADD KEY pmfrom (pmfrom),
  ADD KEY pmto (pmto),
  ADD KEY pmread (pmread),
  ADD KEY pmout (pmout),
  ADD KEY reply (reply);

ALTER TABLE _prfx_pmmessage
  ADD PRIMARY KEY (id);

ALTER TABLE _prfx_post
  ADD PRIMARY KEY (id),
  ADD KEY topicid (topicid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid),
  ADD KEY redeclare (redeclare),
  ADD KEY `hidden` (`hidden`),
  ADD KEY moderate (moderate),
  ADD KEY trash (trash),
  ADD KEY author (author),
  ADD KEY editby (editby),
  ADD KEY editnum (editnum);

ALTER TABLE _prfx_postmessage
  ADD PRIMARY KEY (id),
  ADD KEY topicid (topicid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid);

ALTER TABLE _prfx_style
  ADD PRIMARY KEY (id);

ALTER TABLE _prfx_survey
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY `status` (`status`),
  ADD KEY `secret` (`secret`),
  ADD KEY `days` (`days`),
  ADD KEY posts (posts),
  ADD KEY added (added);

ALTER TABLE _prfx_surveyoptions
  ADD PRIMARY KEY (id),
  ADD KEY surveyid (surveyid),
  ADD KEY votes (votes);

ALTER TABLE _prfx_surveyvotes
  ADD PRIMARY KEY (id),
  ADD KEY surveyid (surveyid),
  ADD KEY optionid (optionid),
  ADD KEY topicid (topicid),
  ADD KEY userid (userid);

ALTER TABLE _prfx_template
  ADD PRIMARY KEY (id),
  ADD KEY `name` (`name`);

ALTER TABLE _prfx_title
  ADD PRIMARY KEY (id),
  ADD KEY listid (listid),
  ADD KEY userid (userid),
  ADD KEY `status` (`status`);

ALTER TABLE _prfx_titlelists
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY `status` (`status`),
  ADD KEY `global` (`global`),
  ADD KEY added (added);

ALTER TABLE _prfx_titleuse
  ADD PRIMARY KEY (id),
  ADD KEY listid (listid),
  ADD KEY userid (userid),
  ADD KEY `status` (`status`),
  ADD KEY added (added);

ALTER TABLE _prfx_topic
  ADD PRIMARY KEY (id),
  ADD KEY `date` (`date`),
  ADD KEY sticky (sticky),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid),
  ADD KEY redeclare (redeclare),
  ADD KEY `status` (`status`),
  ADD KEY `hidden` (`hidden`),
  ADD KEY moderate (moderate),
  ADD KEY trash (trash),
  ADD KEY archive (archive),
  ADD KEY survey (survey),
  ADD KEY `top` (`top`),
  ADD KEY link (link),
  ADD KEY author (author),
  ADD KEY posts (posts),
  ADD KEY lpauthor (lpauthor),
  ADD KEY editby (editby),
  ADD KEY editnum (editnum),
  ADD KEY viewforusers (viewforusers);

ALTER TABLE _prfx_topicarchive
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid),
  ADD KEY author (author);

ALTER TABLE _prfx_topicedit
  ADD PRIMARY KEY (id),
  ADD KEY topicid (topicid),
  ADD KEY userid (userid);

ALTER TABLE _prfx_topicmessage
  ADD PRIMARY KEY (id),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid);

ALTER TABLE _prfx_topicusers
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY topicid (topicid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid),
  ADD KEY addby (addby);

ALTER TABLE _prfx_trylogin
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid);

ALTER TABLE _prfx_user
  ADD PRIMARY KEY (id),
  ADD KEY `status` (`status`),
  ADD KEY active (active),
  ADD KEY entername (entername(10)) USING BTREE,
  ADD KEY `name` (`name`(10)) USING BTREE,
  ADD KEY `level` (`level`),
  ADD KEY submonitor (submonitor);

ALTER TABLE _prfx_useractivity
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY forumid (forumid),
  ADD KEY catid (catid);

ALTER TABLE _prfx_userflag
  ADD PRIMARY KEY (id),
  ADD KEY sex (sex),
  ADD KEY age (age),
  ADD KEY country (country),
  ADD KEY posts (posts),
  ADD KEY medalid (medalid),
  ADD KEY lpid (lpid),
  ADD KEY lptype (lptype),
  ADD KEY oldlevel (oldlevel),
  ADD KEY agree (agree);

ALTER TABLE _prfx_userlock
  ADD PRIMARY KEY (id),
  ADD KEY userid (userid),
  ADD KEY lockedby (lockedby);

ALTER TABLE _prfx_useronline
  ADD PRIMARY KEY (ip),
  ADD KEY userid (userid),
  ADD KEY `level` (`level`),
  ADD KEY forumid (forumid),
  ADD KEY hidebrowse (hidebrowse);

ALTER TABLE _prfx_userperm
  ADD PRIMARY KEY (id),
  ADD KEY receiveemail (receiveemail),
  ADD KEY receivepm (receivepm),
  ADD KEY changename (changename),
  ADD KEY changeentername (changeentername),
  ADD KEY hidephoto (hidephoto),
  ADD KEY hidesignature (hidesignature),
  ADD KEY hidearchive (hidearchive),
  ADD KEY hideusers (hideusers),
  ADD KEY hidesearch (hidesearch),
  ADD KEY hidefavorite (hidefavorite),
  ADD KEY hidebrowse (hidebrowse),
  ADD KEY hidetopics (hidetopics),
  ADD KEY hideposts (hideposts),
  ADD KEY hidepm (hidepm),
  ADD KEY hideselftopics (hideselftopics),
  ADD KEY hideuserstopics (hideuserstopics),
  ADD KEY hideselfposts (hideselfposts),
  ADD KEY hideusersposts (hideusersposts),
  ADD KEY hideselfprofile (hideselfprofile),
  ADD KEY hideusersprofile (hideusersprofile),
  ADD KEY stopsendpm (stopsendpm),
  ADD KEY stopaddpost (stopaddpost),
  ADD KEY postsundermon (postsundermon),
  ADD KEY uneditsignature (uneditsignature),
  ADD KEY sendcomplain (sendcomplain),
  ADD KEY dochat (dochat),
  ADD KEY allowfriendship (allowfriendship),
  ADD KEY showfriends (showfriends),
  ADD KEY showbirthday (showbirthday);

ALTER TABLE _prfx_visitors
  ADD PRIMARY KEY (ip),
  ADD KEY forumid (forumid);

ALTER TABLE _prfx_bad_words
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_blocks
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_category
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_changename
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_chat
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_complain
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_config
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_country
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_cpvisit
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_favorite
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_forum
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_forumbrowse
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_forumusers
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_fpass
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_friends
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_hacker
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_ipban
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_language
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_loginip
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_loginsession
  MODIFY id int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_medal
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_medallists
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_medalphotos
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_modactivity
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_moderator
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_moderator_block
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_mon
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_notification
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_online
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_photos
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_pm
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_post
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_style
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_survey
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_surveyoptions
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_surveyvotes
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_template
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_title
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_titlelists
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_titleuse
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_topic
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_topicedit
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_topicusers
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_trylogin
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_user
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_useractivity
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE _prfx_userlock
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
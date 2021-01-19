<?php

const _df_script = 'ajax.php';

$_type = isset($_GET['type']) ? $_GET['type'] : '';

$json = [ 'status' => '' ];

if( $_type == 'dbcheck_connection' ){
    require_once '../includes/config.php';

    if(
        is_array($df_config) &&
        isset($df_config['database'])
    ){
        $db = $df_config['database'];
        if( isset($db['host']) && isset($db['name']) && isset($db['user']) && isset($db['pass']) && isset($db['port']) ){
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};port={$db['port']};charset=utf8;";
            $conn = new PDO( $dsn, $db['user'], $db['pass'] );
            if( $conn ){
                $json['status'] = 'success';
            }
        }
        
    }

    echo json_encode($json);
}
elseif( $_type == 'setting_up' ){
    require_once '../includes/config.php';

    if(
        is_array($df_config) &&
        isset($df_config['database'])
    ){
        $db = $df_config['database'];
        if( isset($db['host']) && isset($db['name']) && isset($db['user']) && isset($db['pass']) && isset($db['port']) ){
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};port={$db['port']};charset=utf8;";
            $conn = new PDO( $dsn, $db['user'], $db['pass'] );
            if( !$conn ){
                $json['status'] = 'فشل في اتصال بقاعدة البيانات، رجاءً تأكد من ملف config.php';
            }
            else{
                $sql_error = "";
                function mysql_execute( $text, $params = [] ){
                    global $conn, $sql_error;
                    try{
                        $sql = $conn->prepare($text);
                        $sql->execute($params);
                        return $sql;
                    }
                    catch( PDOException $e ){
                        $sql_error = $e->getMessage();
                        return false;
                    }
                }

                mysql_execute("SET NAMES 'utf8'");
                $conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                $forum_title = isset($_POST['forum_title']) ? trim($_POST['forum_title']) : '';
                $site_address = isset($_POST['site_address']) ? trim($_POST['site_address']) : '';
                $forum_email = isset($_POST['forum_email']) ? trim($_POST['forum_email']) : '';
                $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                $password1 = isset($_POST['password1']) ? trim($_POST['password1']) : '';
                $password2 = isset($_POST['password2']) ? trim($_POST['password2']) : '';

                if( empty($forum_title) ){
                    $json['status'] = 'يجب عليك كتابة اسم المنتدى';
                }
                elseif( empty($site_address) || !preg_match("/^([a-z0-9\.\-]+)$/i", $site_address) ){
                    $json['status'] = 'يجب عليك كتابة عنوان الويب للمنتدى وبشكل صحيح';
                }
                elseif( empty($forum_email) || filter_var($forum_email, FILTER_VALIDATE_EMAIL) === false ){
                    $json['status'] = 'يجب عليك كتابة بريد الالكتروني للمنتدى وبشكل صحيح';
                }
                elseif( strlen($username) < 3 ){
                    $json['status'] = 'يجب عليك كتابة اسم مدير المنتدى لايقل عن 3 احرف';
                }
                elseif( strlen($password1) < 5 ){
                    $json['status'] = 'يجب عليك كتابة كلمة سرية لا يقل عن 5 احرف';
                }
                elseif( strlen($password2) < 5 ){
                    $json['status'] = 'يجب عليك كتابة إعادة كلمة السرية لا يقل عن 5 احرف';
                }
                elseif( $password1 != $password2 ){
                    $json['status'] = 'كلمتا السرية غير مطابقين';
                }
                else{
                    $sql_tables = file_get_contents("sql_tables.sql");
                    $sql_tables = str_replace("_prfx_", $db['prefix'], $sql_tables);
                    if( strlen($sql_tables) == 0 ){
                        $json['status'] = 'توجد مشكلة في ملف انشاء جداول قاعدة بيانات وهو sql_tables.sql';
                    }
                    else{
                        if( mysql_execute($sql_tables) === false ){
                            $json['status'] = 'لم يتم إنشاء جداول قاعدة بيانات بسبب مشكلة في ملف sql_tables.sql';
                        }
                        else{
                            $code = strtolower( substr( mt_rand(1000000, 9999999).time(), 0, 3 ) );
                            $password = md5($code.$password1);
                            $sql = mysql_execute("INSERT INTO {$db['prefix']}user
                            (
                                active, name, entername, password, keycode,code, level, date
                            ) VALUES (
                                1,
                                :name,
                                :name,
                                :password,
                                :keycode,
                                :code,
                                4,
                                ".time()."
                            )", [
                                'name' => $username,
                                'password' => $password,
                                'keycode' => "",
                                'code' => $code
                            ]);
                            $admin_id = mysql_execute("SELECT LAST_INSERT_ID()")->fetch(PDO::FETCH_NUM);
                            $admin_id = intval($admin_id[0]);
                            if( $admin_id == 0 ){
                                $json['status'] = 'لم يتم ادراج معلومات المدير، رجاءً حاول مرة اخرى';
                            }
                            else{
                                mysql_execute("INSERT INTO {$db['prefix']}userperm ( id ) VALUES ( {$admin_id} )");
                                mysql_execute("INSERT INTO {$db['prefix']}userflag ( id, email,title,picture,photo,age,country,best_player,best_club,best_team,state,city,ip,allip,ips,marstatus,biography,occupation,signature,style,lists,pmlists,lpid,lpdate,lhdate ) VALUES ( {$admin_id},'{$forum_email}','','','',18,'A1','','','','','',127001,'','','','','','','','','',1611074580,1611074580,1611074580 )");

                                // adding config data
                                $sql = "INSERT INTO {$db['prefix']}config (type, variable, value) VALUES
                                (1, 'forum_title', '{$forum_title}'),
                                (1, 'site_address', '{$site_address}'),
                                (1, 'forum_email', '{$forum_email}'),
                                (1, 'forum_logo', 'images/favicon/light/ms-icon-150x150.png'),
                                (1, 'shut_down_status', '0'),
                                (1, 'shut_down_msg', 'المنتديات تحت الصيانة حالياً\r\nسنعود بعد قليل'),
                                (1, 'register_status', '1'),
                                (1, 'site_domains', 'a:1:{i:0;s:9:\"localhost\";}'),
                                (1, 'site_keywords', 'duhokforum, duhokfrm, duhok, forum, forums'),
                                (1, 'default_style', 'blue'),
                                (1, 'default_stylefont', 'arial'),
                                (1, 'default_timezone', '3'),
                                (1, 'repair_timezone', '0'),
                                (1, 'facebook_account', ''),
                                (1, 'twitter_account', ''),
                                (1, 'num_pages', '40'),
                                (1, 'reply_num_page', '20'),
                                (1, 'count_pm_for_24_hour', '30'),
                                (1, 'new_user_under_moderate', '20'),
                                (1, 'new_user_can_send_pm', '100'),
                                (1, 'topic_max_posts', '300'),
                                (1, 'max_days_change_name', '30'),
                                (1, 'max_change_name', '5'),
                                (1, 'help_forum_id', '0'),
                                (1, 'forums_logo_folder', 'images/forums-logo/'),
                                (1, 'visitor_can_show_forums', '1'),
                                (1, 'visitor_can_show_topics', '1'),
                                (1, 'forum_copy_right', 'Copyright © {$site_address} 2009-2021 All Rights Reserved.'),
                                (1, 'user_name_color', 'a:4:{i:1;a:4:{i:0;s:7:\"#888888\";i:1;s:0:\"\";i:2;s:7:\"#009900\";i:3;s:7:\"#666600\";}i:2;a:2:{i:0;s:7:\"#cc0033\";i:1;s:7:\"#9900cc\";}i:3;a:2:{i:0;s:0:\"\";i:1;s:7:\"#cc9900\";}i:4;a:2:{i:0;s:0:\"\";i:1;s:7:\"#0000ff\";}}'),
                                (1, 'stars_number', 'a:11:{i:0;i:0;i:1;i:30;i:2;i:100;i:3;i:500;i:4;i:1000;i:5;i:2000;i:6;i:3000;i:7;i:4000;i:8;i:5000;i:9;i:6000;i:10;i:7000;}'),
                                (1, 'stars_color', 'a:4:{i:1;a:4:{i:0;s:6:\"silver\";i:1;s:4:\"blue\";i:2;s:5:\"green\";i:3;s:6:\"silver\";}i:2;a:2:{i:0;s:3:\"red\";i:1;s:6:\"purple\";}i:3;a:2:{i:0;s:0:\"\";i:1;s:4:\"gold\";}i:4;a:2:{i:0;s:0:\"\";i:1;s:6:\"bronze\";}}'),
                                (1, 'female_titles', 'a:4:{i:1;a:6:{i:0;s:10:\"عضوة جديدة\";i:1;s:11:\"عضوة مبتدئة\";i:2;s:4:\"عضوة\";i:3;s:9:\"عضوة نشطة\";i:4;s:11:\"عضوة متطورة\";i:5;s:11:\"عضوة أساسية\";}i:2;a:2:{i:0;a:2:{i:0;s:5:\"مشرفة\";i:1;s:11:\"مشرفة سابقة\";}i:1;a:2:{i:0;s:11:\"نائبة مراقب\";i:1;s:21:\"نائبة السابقة للمراقب\";}}i:3;a:2:{i:0;s:6:\"مراقبة\";i:1;s:12:\"مراقبة سابقة\";}i:4;a:2:{i:0;s:5:\"مديرة\";i:1;s:11:\"مديرة سابقة\";}}'),
                                (1, 'male_titles', 'a:4:{i:1;a:6:{i:0;s:8:\"عضو جديد\";i:1;s:9:\"عضو مبتدئ\";i:2;s:3:\"عضو\";i:3;s:7:\"عضو نشط\";i:4;s:9:\"عضو متطور\";i:5;s:9:\"عضو أساسي\";}i:2;a:2:{i:0;a:2:{i:0;s:4:\"مشرف\";i:1;s:9:\"مشرف سابق\";}i:1;a:2:{i:0;s:10:\"نائب مراقب\";i:1;s:17:\"نائب سابق للمراقب\";}}i:3;a:2:{i:0;s:5:\"مراقب\";i:1;s:10:\"مراقب سابق\";}i:4;a:2:{i:0;s:4:\"مدير\";i:1;s:9:\"مدير سابق\";}}'),
                                (1, 'temp_details_for_send_message_to_all', ''),
                                (1, 'blocked_names', ''),
                                (1, 'blocked_tags', 'a:8:{i:0;s:4:\"form\";i:1;s:6:\"script\";i:2;s:4:\"meta\";i:3;s:5:\"frame\";i:4;s:6:\"iframe\";i:5;s:6:\"object\";i:6;s:5:\"embed\";i:7;s:8:\"frameset\";}'),
                                (1, 'blocked_attributes', 'a:78:{i:0;s:7:\"onabort\";i:1;s:10:\"onactivate\";i:2;s:12:\"onafterprint\";i:3;s:13:\"onafterupdate\";i:4;s:16:\"onbeforeactivate\";i:5;s:12:\"onbeforecopy\";i:6;s:11:\"onbeforecut\";i:7;s:18:\"onbeforedeactivate\";i:8;s:17:\"onbeforeeditfocus\";i:9;s:13:\"onbeforepaste\";i:10;s:13:\"onbeforeprint\";i:11;s:14:\"onbeforeunload\";i:12;s:14:\"onbeforeupdate\";i:13;s:8:\"onbounce\";i:14;s:12:\"oncellchange\";i:15;s:8:\"onchange\";i:16;s:7:\"onclick\";i:17;s:7:\"onclose\";i:18;s:13:\"oncontextmenu\";i:19;s:15:\"oncontrolselect\";i:20;s:6:\"oncopy\";i:21;s:5:\"oncut\";i:22;s:15:\"ondataavailable\";i:23;s:16:\"ondatasetchanged\";i:24;s:17:\"ondatasetcomplete\";i:25;s:10:\"ondblclick\";i:26;s:12:\"ondeactivate\";i:27;s:10:\"ondragdrop\";i:28;s:9:\"ondragend\";i:29;s:11:\"ondragenter\";i:30;s:11:\"ondragleave\";i:31;s:10:\"ondragover\";i:32;s:11:\"ondragstart\";i:33;s:6:\"ondrag\";i:34;s:6:\"ondrop\";i:35;s:7:\"onerror\";i:36;s:13:\"onerrorupdate\";i:37;s:14:\"onfilterchange\";i:38;s:8:\"onfinish\";i:39;s:7:\"onfocus\";i:40;s:9:\"onfocusin\";i:41;s:10:\"onfocusout\";i:42;s:6:\"onhelp\";i:43;s:9:\"onkeydown\";i:44;s:10:\"onkeypress\";i:45;s:7:\"onkeyup\";i:46;s:16:\"onlayoutcomplete\";i:47;s:19:\"onloadonlosecapture\";i:48;s:11:\"onmousedown\";i:49;s:12:\"onmouseenter\";i:50;s:12:\"onmouseleave\";i:51;s:11:\"onmousemove\";i:52;s:10:\"onmouseout\";i:53;s:11:\"onmouseover\";i:54;s:9:\"onmouseup\";i:55;s:12:\"onmousewheel\";i:56;s:6:\"onmove\";i:57;s:9:\"onmoveend\";i:58;s:11:\"onmovestart\";i:59;s:7:\"onpaste\";i:60;s:16:\"onpropertychange\";i:61;s:18:\"onreadystatechange\";i:62;s:7:\"onreset\";i:63;s:8:\"onresize\";i:64;s:11:\"onresizeend\";i:65;s:23:\"onresizestartonrowenter\";i:66;s:9:\"onrowexit\";i:67;s:12:\"onrowsdelete\";i:68;s:14:\"onrowsinserted\";i:69;s:8:\"onscroll\";i:70;s:8:\"onselect\";i:71;s:17:\"onselectionchange\";i:72;s:13:\"onselectstart\";i:73;s:7:\"onstart\";i:74;s:6:\"onstop\";i:75;s:8:\"onsubmit\";i:76;s:8:\"onunload\";i:77;s:6:\"onblur\";}')";
                                mysql_execute($sql);

                                // adding countries data
                                $sql = "INSERT INTO {$db['prefix']}country (code, name) VALUES
                                ('A1', 'مجهول المصدر'),
                                ('A2', 'ستلايت'),
                                ('AD', 'أندورا'),
                                ('AE', 'الإمارات'),
                                ('AF', 'أفغانستان'),
                                ('AG', 'أنتيجا وبربودا'),
                                ('AI', 'أنجيلا'),
                                ('AL', 'ألبانيا'),
                                ('AM', 'أرمينيا'),
                                ('AN', 'جزر الأنتيل'),
                                ('AO', 'أنغولا'),
                                ('AP', 'منطقة آسيا والمحيط الهادئ'),
                                ('AQ', 'انتاركتيكا'),
                                ('AR', 'الأرجنتين'),
                                ('AS', 'الساموا الأمريكية'),
                                ('AT', 'النمسا'),
                                ('AU', 'أستراليا'),
                                ('AW', 'أروبا'),
                                ('AX', 'جزر أولان'),
                                ('AZ', 'إذربيجان'),
                                ('BA', 'البوسنة والهرسك'),
                                ('BB', 'بربادوس'),
                                ('BD', 'بنغلادش'),
                                ('BE', 'بلجيكا'),
                                ('BF', 'بوركينا فاسو'),
                                ('BG', 'بلغاريا'),
                                ('BH', 'البحرين'),
                                ('BI', 'بوروندي'),
                                ('BJ', 'بنين'),
                                ('BM', 'برمودا'),
                                ('BN', 'بروناي دار السلام'),
                                ('BO', 'بوليفيا'),
                                ('BR', 'البرازيل'),
                                ('BS', 'البهاما'),
                                ('BT', 'بوتان'),
                                ('BV', 'جزيرة بوفيه'),
                                ('BW', 'بوتسوانا'),
                                ('BY', 'روسيا البيضاء'),
                                ('BZ', 'بليز'),
                                ('CA', 'كندا'),
                                ('CD', 'جمهورية الكونجو'),
                                ('CF', 'جمهورية أفريقيا الوسطى'),
                                ('CG', 'الكونجو'),
                                ('CH', 'سويسرا'),
                                ('CI', 'ساحل العاج'),
                                ('CK', 'جزر كوك'),
                                ('CL', 'تشيلي'),
                                ('CM', 'الكاميرون'),
                                ('CN', 'الصين'),
                                ('CO', 'كولمبيا'),
                                ('CR', 'كوستا ريكا'),
                                ('CU', 'كوبا'),
                                ('CV', 'كاب فيردي'),
                                ('CY', 'قبرص'),
                                ('CZ', 'التشيك'),
                                ('DE', 'ألمانيا'),
                                ('DJ', 'جيبوتي'),
                                ('DK', 'الدانمارك'),
                                ('DM', 'دومينيكا'),
                                ('DO', 'الدومينيكان'),
                                ('DZ', 'الجزائر'),
                                ('EC', 'الإكوادور'),
                                ('EE', 'إستونيا'),
                                ('EG', 'مصر'),
                                ('ER', 'إريتريا'),
                                ('ES', 'أسبانيا'),
                                ('ET', 'إثيوبيا'),
                                ('EU', 'أوروبا'),
                                ('FI', 'فنلندا'),
                                ('FJ', 'جزر فيجي'),
                                ('FK', 'جزر الفلكلاند'),
                                ('FM', 'مايكرونيسيا'),
                                ('FO', 'جزر فاروه'),
                                ('FR', 'فرنسا'),
                                ('GA', 'الجابون'),
                                ('GB', 'بريطانيا'),
                                ('GD', 'جرنادا'),
                                ('GE', 'جورجيا'),
                                ('GF', 'غيانا الفرنسية'),
                                ('GG', 'غويرنسي'),
                                ('GH', 'غانا'),
                                ('GI', 'جبل طارق'),
                                ('GL', 'جزر جرينلاند'),
                                ('GM', 'جامبيا'),
                                ('GN', 'غينيا'),
                                ('GP', 'جوادلوب'),
                                ('GQ', 'غينيا الإستوائية'),
                                ('GR', 'اليونان'),
                                ('GT', 'جواتيمالا'),
                                ('GU', 'جوام'),
                                ('GW', 'جينيا بيساو'),
                                ('GY', 'غيانا'),
                                ('HK', 'هونج كونج'),
                                ('HN', 'الهوندوراس'),
                                ('HR', 'كرواتيا'),
                                ('HT', 'هايتي'),
                                ('HU', 'المجر'),
                                ('ID', 'إندونيسيا'),
                                ('IE', 'إيرلندا'),
                                ('IL', 'إسرائيل'),
                                ('IM', 'جزيرة مان'),
                                ('IN', 'الهند'),
                                ('IO', 'المحيط الهندي البريطاني'),
                                ('IQ', 'العراق'),
                                ('IR', 'إيران'),
                                ('IS', 'أيسلندا'),
                                ('IT', 'إيطاليا'),
                                ('JE', 'جيرسي'),
                                ('JM', 'جاميكا'),
                                ('JO', 'الأردن'),
                                ('JP', 'اليابان'),
                                ('KE', 'كينيا'),
                                ('KG', 'كيرجيستان'),
                                ('KH', 'كمبوديا'),
                                ('KI', 'كيريباتي'),
                                ('KM', 'جزر القمر'),
                                ('KN', 'سانت كيتس ونيفيس'),
                                ('KP', 'كوريا الشمالية'),
                                ('KR', 'كوريا الجنوبية'),
                                ('KW', 'الكويت'),
                                ('KY', 'جزر الكايمان'),
                                ('KZ', 'كازاخستان'),
                                ('LA', 'لاوس'),
                                ('LB', 'لبنان'),
                                ('LC', 'سانت لوسيا'),
                                ('LH', 'سيرفر محلي'),
                                ('LI', 'ليشتنشتين'),
                                ('LK', 'سري لانكا'),
                                ('LR', 'ليبيريا'),
                                ('LS', 'ليسوثو'),
                                ('LT', 'ليثوانيا'),
                                ('LU', 'لوكسمبرج'),
                                ('LV', 'لاتفيا'),
                                ('LY', 'ليبيا'),
                                ('MA', 'المغرب'),
                                ('MC', 'موناكو'),
                                ('MD', 'مولدوفا'),
                                ('ME', 'الجبل الأسود'),
                                ('MG', 'مدغشقر'),
                                ('MH', 'جزر المارشال'),
                                ('MK', 'مقدونيا'),
                                ('ML', 'مالي'),
                                ('MM', 'ميانمار'),
                                ('MN', 'مونغوليا'),
                                ('MO', 'ماكاو'),
                                ('MP', 'جزر ماريانا الشمالية'),
                                ('MQ', 'مارتينيك'),
                                ('MR', 'موريتانيا'),
                                ('MS', 'مونسرات'),
                                ('MT', 'مالطة'),
                                ('MU', 'الموريشيس'),
                                ('MV', 'جزر المالديف'),
                                ('MW', 'مالاوي'),
                                ('MX', 'المكسيك'),
                                ('MY', 'ماليزيا'),
                                ('MZ', 'موزمبيق'),
                                ('NA', 'ناميبيا'),
                                ('NC', 'كاليدونيا الجديدة'),
                                ('NE', 'النيجر'),
                                ('NF', 'جزيرة نورفولك'),
                                ('NG', 'نيجيريا'),
                                ('NI', 'نيكاراجوا'),
                                ('NL', 'هولندا'),
                                ('NO', 'النرويج'),
                                ('NP', 'النيبال'),
                                ('NR', 'ناورو'),
                                ('NU', 'نوي'),
                                ('NZ', 'نيو زيلندا'),
                                ('OM', 'عمان'),
                                ('PA', 'بنما'),
                                ('PE', 'بيرو'),
                                ('PF', 'بولينيسيا الفرنسية'),
                                ('PG', 'بابوا نيو جيني'),
                                ('PH', 'الفلبين'),
                                ('PK', 'باكستان'),
                                ('PL', 'بولندا'),
                                ('PM', 'سانت بيير وميكولون'),
                                ('PR', 'بورتو ريكو'),
                                ('PS', 'فلسطين'),
                                ('PT', 'البرتغال'),
                                ('PW', 'بالاو'),
                                ('PY', 'باراجواي'),
                                ('QA', 'قطر'),
                                ('RE', 'جزر الرينيون'),
                                ('RO', 'رومانيا'),
                                ('RS', 'صربيا'),
                                ('RU', 'روسيا'),
                                ('RW', 'رواندا'),
                                ('SA', 'السعودية'),
                                ('SB', 'جزر السولومون'),
                                ('SC', 'السيشيل'),
                                ('SD', 'السودان'),
                                ('SE', 'السويد'),
                                ('SG', 'سنغافورة'),
                                ('SI', 'سلوفينيا'),
                                ('SK', 'سلوفاكيا'),
                                ('SL', 'سييرا ليون'),
                                ('SM', 'سان مارينو'),
                                ('SN', 'السنغال'),
                                ('SO', 'الصومال'),
                                ('SR', 'سورينام'),
                                ('ST', 'سان تومي وبرينسيبي'),
                                ('SV', 'السلفادور'),
                                ('SY', 'سوريا'),
                                ('SZ', 'سوازيلاند'),
                                ('TC', 'جزر تركس وكايكوس'),
                                ('TD', 'تشاد'),
                                ('TG', 'توجو'),
                                ('TH', 'تايلاند'),
                                ('TJ', 'تاطجكستان'),
                                ('TK', 'توكلو'),
                                ('TM', 'تركمنستان'),
                                ('TN', 'تونس'),
                                ('TO', 'تونجا'),
                                ('TR', 'تركيا'),
                                ('TT', 'ترينيداد وتوباجو'),
                                ('TV', 'توفالو'),
                                ('TW', 'تايوان'),
                                ('TZ', 'تنزانيا'),
                                ('UA', 'أوكرانيا'),
                                ('UG', 'أوغندا'),
                                ('UM', 'جزر الولايات المتحدة'),
                                ('US', 'الولايات المتحدة الأمريكي'),
                                ('UY', 'أوروجواي'),
                                ('UZ', 'أزبكستان'),
                                ('VA', 'الفاتيكان'),
                                ('VC', 'سانت فنسنت وجزر غرينادين'),
                                ('VE', 'فنزويلا'),
                                ('VG', 'جزر فيرجن'),
                                ('VI', 'جزر فيرجن'),
                                ('VN', 'فيتنام'),
                                ('VU', 'فاناتو'),
                                ('WF', 'جزر واليس وفوتونا'),
                                ('WS', 'ساموا'),
                                ('YE', 'اليمن'),
                                ('YT', 'مايوت'),
                                ('ZA', 'جنوب أفريقيا'),
                                ('ZM', 'زامبيا'),
                                ('ZW', 'زمبابوي'),
                                ('WA', 'ويلز'),
                                ('YU', 'يوغوسلافيا'),
                                ('KD', 'كردستان')";
                                mysql_execute($sql);

                                // adding styles data
                                $sql = "INSERT INTO {$db['prefix']}style (subject, filename) VALUES
                                ('أزرق', 'blue'),
                                ('أخضر', 'green'),
                                ('أحمر', 'red'),
                                ('ارجواني', 'purple')";
                                mysql_execute($sql);

                                // adding templates data
                                $sql = "INSERT INTO {$db['prefix']}template (name, text) VALUES
                                ('login_bar', '<center><br><br>\$paging\r\n<table width=\"40%\" cellpadding=\"4\" cellspacing=\"1\">\r\n	<tr>\r\n		<td class=\"asHeader\" colspan=\"3\">سجل اتصال \$loginbar[username]</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"asDarkB\"><nobr>IP</nobr></td>\r\n		<td class=\"asDarkB\"><nobr>بلد</nobr></td>\r\n		<td class=\"asDarkB\"><nobr>تاريخ آخر محاولة</nobr></td>\r\n	</tr>\r\n<if condition=\"\$loginbar[result]\">\r\n	<foreach array=\"\$loginbar[result]\" key=\"\$key\" val=\"\$val\">\r\n		<tr>\r\n			<td class=\"asNormalB asS12 asCenter\"><nobr>\$val[ip_address]</nobr></td>\r\n			<td class=\"asNormalB asS12 asCenter\"><nobr>\$val[country_and_flag]</nobr></td>\r\n			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>\$val[date_of_last_try]</nobr></td>\r\n		</tr>\r\n	</foreach>\r\n</if>\r\n	<if condition=\"\$count == 0\">\r\n		<tr>\r\n			<td class=\"asNormalB asCenter\" colspan=\"3\"><br>لا توجد أي اتصال للعضوية<br><br></td>\r\n		</tr>\r\n	</if>\r\n</table>\$paging\r\n</center>'),
                                ('try_login', '<center><br><br>\$paging\r\n<table width=\"40%\" cellpadding=\"4\" cellspacing=\"1\">\r\n	<tr>\r\n		<td class=\"asHeader\" colspan=\"4\">سجل محاولات دخول \$trylogin[username]</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"asDarkB\"><nobr>عدد محاولات</nobr></td>\r\n		<td class=\"asDarkB\"><nobr>IP</nobr></td>\r\n		<td class=\"asDarkB\"><nobr>بلد</nobr></td>\r\n		<td class=\"asDarkB\"><nobr>تاريخ آخر محاولة</nobr></td>\r\n	</tr>\r\n<if condition=\"\$trylogin[result]\">\r\n	<foreach array=\"\$trylogin[result]\" key=\"\$key\" val=\"\$val\">\r\n		<tr>\r\n			<td class=\"asNormalB asS12 asCenter\"><nobr>\$val[count]</nobr></td>\r\n			<td class=\"asNormalB asS12 asCenter\"><nobr>\$val[ip_address]</nobr></td>\r\n			<td class=\"asNormalB asS12 asCenter\"><nobr>\$val[country_and_flag]</nobr></td>\r\n			<td class=\"asNormalB asDate asS12 asCenter\"><nobr>\$val[date_of_last_try]</nobr></td>\r\n		</tr>\r\n	</foreach>\r\n</if>\r\n	<if condition=\"\$count == 0\">\r\n		<tr>\r\n			<td class=\"asNormalB asCenter\" colspan=\"4\"><br>لا توجد أي محاولة لدخول عضويتك<br><br></td>\r\n		</tr>\r\n	</if>\r\n</table>\$paging\r\n</center>'),
                                ('rules', '<table width=\"70%\" cellpadding=\"4\" cellspacing=\"0\" align=\"center\">\r\n	<tr>\r\n		<td class=\"asHeader\">شروط المشاركة في \$forum_title</td>\r\n	</tr>\r\n	<tr>\r\n		<td class=\"asNormal asCenter\" style=\"padding:15px\" align=\"center\">\r\n<table  width=\"100%\">\r\n	<tr>\r\n		<td class=\\\"asCenter asC5\\\">لتشارك في \$forum_title يجب عليك الإلتزام بالشروط التالية</td>\r\n	</tr>\r\n</table>\r\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n	<tr>\r\n<td width=\"1%\"> </td>\r\n				<td width=\"90%\"><u> نحن نقبل في المنتديات أغلبية المشاركات الا التي تحتوي على:</u></td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\" valign=\"top\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> كلام بذيء أو مشين</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> هجوم مباشر أو غير مباشر على شخص أو عضو أو مؤسسة</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> صور غير لائقة من أي نوع</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> كلام يشجع على الحقد والكراهية</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> نص كامل من مصدر يبدو انه عليه حقوق نشر بدون ذكر المصدر</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> شرح لعملية اختراق سواء لأجهزة كمبيوتر أو خدمات تلفزيونية أو غيرها</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> الإعلان بشكل مباشر أو غير مباشر عن منتديات أو مواقع منافسة</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> اي نشاط إجرامي من أي نوع</td>\r\n			</tr>\r\n			<tr>\r\n<td width=\"1%\"> </td>\r\n				<td width=\"99%\"><u> والرجاء ملاحظة التالي:</u></td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\" valign=\"top\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> الموقع ومدير الموقع ومشرفو الموقع غير مسئولون عن أية معلومات توفرها وأية مشاركات تقوم بها.</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\" valign=\"top\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> أي مشاركات تقوم بها في هذه المنتديات تصبح معلومات عامة فنرجو منك عدم الادلاء بأية معلومات سرية أو خاصة بك في مشاركاتك.</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\" valign=\"top\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> هذه المنتديات قد تحتوي على وصلات الى مواقع أخرى ومشاركات من أفراد والموقع غير مسئول عن محتويات المشاركات والوصلات. اذا وجدت أي مشاركة أو وصلة تحتوي على كلام بذيء أو غير مقبول الرجاء اخبارنا فورا وسنقوم بحذف هذه المشاركات من المنتدى حالا.</td>\r\n			</tr>\r\n			<tr>\r\n				<td width=\"1%\" valign=\"top\"><img border=\"0\" src=\"images/icons/star_red.gif\"></td>\r\n				<td width=\"99%\"> لمدير الموقع ومشرفوه الحق في إزالة أي مشاركة أو طرد أي عضو بدون سابق إنذار.</td>\r\n			</tr>\r\n		</table>\r\n<table  width=\"80%\">\r\n	<tr>\r\n		<td class=\\\"asCenter asC5\\\">اذا كان لديك أي استفسار الرجاء ارسال بريد الكتروني الى : <a href=\"mailto:\$forum_email\">\$forum_email</a></td>\r\n	</tr>\r\n</table>\r\n		</td>\r\n	</tr>\r\n</table>')";
                                mysql_execute($sql);

                                // adding test category
                                $sql = "INSERT INTO {$db['prefix']}category (subject, sort, monitor, archive, level, status, hidden, hidemonhome, hidemoninfo, hidemonprofile, submonitor) VALUES
                                ('فئة تجريبية', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0)";
                                mysql_execute($sql);
                                $cat_id = mysql_execute("SELECT LAST_INSERT_ID()")->fetch(PDO::FETCH_NUM);
                                $cat_id = intval($cat_id[0]);

                                // adding test forum
                                $sql = "INSERT INTO {$db['prefix']}forum (catid, subject, description, logo, sort, level, topics, posts, lpauthor, lpdate, status, hidden, sex, archive, hidemodhome, hidemodforum, topic_show, topic_appearance, moderateurl) VALUES
                                ({$cat_id}, 'منتدى تجريبي', 'هذا المنتدى هو تجربة نسخة منتديات', 'images/icons/errorlogo.gif', 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0)";
                                mysql_execute($sql);
                                $forum_id = mysql_execute("SELECT LAST_INSERT_ID()")->fetch(PDO::FETCH_NUM);
                                $forum_id = intval($forum_id[0]);
                                mysql_execute("INSERT INTO {$db['prefix']}forumflag ( id, catid, pmlists ) VALUES ( {$forum_id},{$cat_id}, '' )");

                                $json['status'] = 'success';
                            }
                        }
                        if( !empty($sql_error) ){
                            $json['sql_error'] = $sql_error;
                        }
                    }
                }
            }
        }
        else{
            $json['status'] = 'فشل في اتصال بقاعدة البيانات، رجاءً تأكد من ملف config.php';
        }
    }
    else{
        $json['status'] = 'فشل في اتصال بقاعدة البيانات، رجاءً تأكد من ملف config.php';
    }

    echo json_encode($json);
}


?>
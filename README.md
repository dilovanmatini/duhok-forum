# Duhok Forum v3.0
Duhok Forum is a free forum script developed in PHP and MySQL. It can be installed in Linux servers or local servers by using Wamp, Xampp, etc...\
دهوك فوريوم هي نسخة منتديات مجانية مبرمجة بلغة&#x202b; PHP وقواعد بيانات MySQL. بإمكانك تثبيت على خوادم لينكس و خوادم المحلية مثل Wamp وXampp والى اخره...

[![GitHub Version](https://img.shields.io/github/v/tag/dilovanmatini/duhok-forum)](https://github.com/dilovanmatini/duhok-forum/releases)
[![editor](https://img.shields.io/badge/editor-vscode-blue)](https://code.visualstudio.com/)

![Preview](https://repository-images.githubusercontent.com/324770043/500d6e80-4c34-11eb-9563-967e32b1c16a)

## Download - تحميل
[Download](https://github.com/dilovanmatini/duhok-forum/releases)

## Installation
After you download the ZIP file, extract it, then put the script files into your server's runnable folder and do the below steps:
1. Create a `MySQL` database and open **`includes/config.php`** file, then put the database information into below variable:
```php
$df_config['database'] = [
    'host' => 'localhost',    // Server Host Name
    'name' => 'df_db',        // Database Name
    'user' => 'df_db',        // Database User Name
    'pass' => '',             // Database User's Password
    'prefix' => 'df_',        // Tables's Preix
    'port' => 3306            // MySQL Server Port
];
```
2. Go to **`http://hostname/install`**.
3. After reading license and agree it, click **`Next`**.
4. Check the database connection and click **`Next`**.
5. Type the nessesary forum's information, then create an `Admin`, and then click **`Begin Setting Up`**.
6. Finally, you will see the congratulation message, then you can navigate your forum.
>Don't forget to remove **`install`** folder before you publishing in the Internet.

## التثبيت
&#x202b;بعد تنزيل النسخة، قم باستخراج ملفات من نسخة مضغوطة، ثم نقل ملفات الى مجلدك الرئيسي للخادم وقم بما يلي:\
&#x202b;1. قم بإنشاء قاعدة بيانات `MySQL` ثم فتح ملف **`includes/config.php`** ثم ضع معلومات قاعدة البيانات في متغييرات التالية:
```php
$df_config['database'] = [
    'host' => 'localhost',    // اسم الخادم
    'name' => 'df_db',        // اسم قاعدة بيانات
    'user' => 'df_db',        // اسم مستخدم قاعدة بيانات
    'pass' => '',             // الكلمة السرية لمستخدم قاعدة بيانات
    'prefix' => 'df_',        // البادئة قبل اسم الجداول
    'port' => 3306            // منفذ خادم MySQL
];
```
&#x202b;2. اذهب الى **`http://hostname/install`**.\
&#x202b;3. بعد قراءة الرخصة والموافقة عليها انقر فوق زر **`التالي`**.\
&#x202b;4. تحقق من اتصال بقاعدة بيانات ثم انقر فوق زر **`التالي`**.\
&#x202b;5. اكتب معلومات الاساسية للمنتدى ثم قم بإنشاء المدير للمنتدى ثم انقر فوق زر **`بدأ التثبيت`**.\
&#x202b;6. في النهاية سوف يظهر لك رسالة بأن المنتدى تم تثبيته بنجاح، انت بإمكانك تصفحها كما شئت.
>&#x202b;لا تنسى بحذف مجلد **`install`** قبل استخدام ونشر المنتدى عبر الانترنت.

## Documentation - الدليل
<https://www.startimes.com/f.aspx?mode=f&f=211>

## Bugs and Issues - مشاكل
Have an issue or a bug? please feel free to [open a new issue](https://github.com/dilovanmatini/duhok-forum/issues/new).\
هل توجد مشكلة في النسخة؟ أرجوا ان لا تتردد في ذكرها بفتح [مشكلة جديدة&#x202b;](https://github.com/dilovanmatini/duhok-forum/issues/new).


## Contact - اتصل بنا
df@lelav.com

## Support - دعم
Is Duhok Forum fitted your requirements?  [Buy Me a Coffee ☕](https://www.paypal.me/DilovanMatini)\
&#x202b;هل نسخة منتديات دهوك يناسب متطلباتك؟  [اشتري لي فنجان قهوة ☕](https://www.paypal.me/DilovanMatini)

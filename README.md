# Duhok Forum 3
Duhok Forum is a free, open-source script that can be installed on both Linux and localhost servers that support the Apache platform. The script supports all modern web browsers. It programmed by PHP and MySQL databases. Also, the basic web languages have been used in it such as HTML, CSS, JavaScript, Ajax, jQuery library, and some javascript open source libraries.

The first eight version had been released by [Dilovan Matini](http://dilovanmatini.com), then many developers worked on it and many versions have been released, the last one was 2.1 that contains many improvements and enhancements but due to growing technology so fast, the mentioned version does not work on modern servers and browsers, especially PHP version 7 and MySQL version 8 and due to these issues, version 3 of Duhok Forum has been released with tremendous improvements, enhancements, and modern design.

# &#x202b;دهوك فوريوم 3
&#x202b;نسخة منتديات Duhok Forum هي نسخة مجانية مفتوحة المصدر يمكنك تنصيب على خوادم لينكس وخوادم المحلية التي تحتوي على منصة Apache. يمكن تشغيل النسخة بواسطة جميع متصفحات الويب الحديثة. تم برمجة هذه النسخة بالغة البرمجة الشهيرة PHP وقواعد بيانات MySQL، بالإضافة الى استخدام لغات الأسياسية للويب مثل HTML و CSS و JavaScript و Ajax، أيضا تم استخدام مكتبة شهيرة jQuery والعديد من مكتبات الجافا سكريبت المفتوحة المصدر.

تم إصدار أول ثمانية نسخ بواسطة&#x202b; [Dilovan Matini](http://dilovanmatini.com)، ثم بعدها تم تطوير النسخة من قبل العديد من المبرمجين وتم نزول العديد من النسخ، آخرها نسخة 2.1 التي تحتوي على كثير من التحسينات والتطويرات، لكن بسبب تحديثات الكثيرة في مجال التقنية وتحديث جميع لغات البرمجة المستخدمة في هذه النسخة مثل PHP7 و قواعد البيانات MySQL8، فلا يمكن استعمالها في سيرفرات الحديثة ولهذا السبب، تم إصدار نسخة 3 من قبل مبرمجها الأصلي لكي يتناسب مع جميع اصدارات المحدثة للغات المذكورة المستخدمة. أيضاً تم تحسين النسخة من جميع جوانب الأمنية والأداء والتصميم.

[![GitHub Version](https://img.shields.io/github/v/tag/dilovanmatini/duhok-forum)](https://github.com/dilovanmatini/duhok-forum/releases)
[![editor](https://img.shields.io/badge/editor-vscode-blue)](https://code.visualstudio.com/)

![Preview](https://repository-images.githubusercontent.com/324770043/500d6e80-4c34-11eb-9563-967e32b1c16a)

## Download - تحميل
[Download](https://github.com/dilovanmatini/duhok-forum/releases)

## Installation
After you download the ZIP file, extract it, then put the script files into your server's runnable folder and do the below steps:
1. Create a `MySQL` database and open **`includes/config.php`** file, then put the database information into below variables:
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
2. Go to **`http://hostname/install`**
3. After reading license and agree on it, click **`Next`**.
4. Check the database connection and click **`Next`**.
5. Type the nessesary forum's information, then create an `Admin` and click **`Begin Setting Up`**.
6. Finally, you will see the congratulation message, then you can navigate your forum as you like.
>Don't forget to remove **`install`** folder before you publishing it in the Internet.

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
&#x202b;2. اذهب الى **`http://hostname/install`**\
&#x202b;3. بعد قراءة الرخصة والموافقة عليها انقر فوق زر **`التالي`**.\
&#x202b;4. تحقق من اتصال بقاعدة بيانات ثم انقر فوق زر **`التالي`**.\
&#x202b;5. اكتب معلومات الاساسية للمنتدى ثم قم بإنشاء المدير للمنتدى ثم انقر فوق زر **`بدأ التثبيت`**.\
&#x202b;6. في النهاية سوف يظهر لك رسالة بأن المنتدى تم تثبيته بنجاح، انت بإمكانك تصفحها كما شئت.
>&#x202b;لا تنسى بحذف مجلد **`install`** قبل استخدام ونشر المنتدى عبر الانترنت.

## Requirenments - المتطلبات
- **PHP 5.5** or greater with `exif` and `mbstring` extensions.
- **MySQL 5.6** or greater.
- **Apache** with `mod_rewrite` module.

## Documentation - الدليل
<https://www.startimes.com/f.aspx?mode=f&f=211>

## Bugs and Issues - مشاكل
Have an issue or a bug? please feel free to [open a new issue](https://github.com/dilovanmatini/duhok-forum/issues/new).\
هل توجد مشكلة في النسخة؟ أرجوا ان لا تتردد في ذكرها بفتح [مشكلة جديدة&#x202b;](https://github.com/dilovanmatini/duhok-forum/issues/new).

## License
This script is free and open-source: you can redistribute it and/or modify it under the terms of the [GNU](https://www.gnu.org/licenses) General Public License as published by the Free Software Foundation, either version 3 of the License, or any later version.

This script is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the [GNU](https://www.gnu.org/licenses)  General Public License for more details.

## الرخصة
&#x202b;Duhok Forum هي نسخة مجانية مفتوحة المصدر يمكنك إعادة توزيعه أو تعديله بموجب شروط رخصة [GNU](https://www.gnu.org/licenses) كما تم نشرها بواسطة مؤسسة البرمجيات الحرة ، إما الإصدار 3 من الترخيص ، أو أي إصدار لاحق.

النسخة محمية وفقاً لجميع معايير الحماية ويتم توزيعها على أمل أن يكون مفيدًا، ولكن دون أي ضمان؛ حتى بدون الضمان الضمني للتسويق أو الملاءمة لغرض معين. انظر رخصة&#x202b; [GNU](https://www.gnu.org/licenses) العمومية لمزيد من التفاصيل.

## Contact - اتصل بنا
df@lelav.com

## Support - دعم
Is Duhok Forum fitted your requirements?  [Buy Me a Coffee ☕](https://www.paypal.me/DilovanMatini)\
&#x202b;هل نسخة منتديات دهوك يناسب متطلباتك؟  [اشتري لي فنجان قهوة ☕](https://www.paypal.me/DilovanMatini)

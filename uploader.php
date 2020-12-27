<?php
/*//////////////////////////////////////////////////////////
// ######################################################///
// # DuhokForum 0.9                                     # //
// ###################################################### //
// #                                                    # //
// #       --  DUHOK FORUM IS FREE SOFTWARE  --         # //
// #                                                    # //
// #   ========= Programming By Dilovan ==============  # //
// # Copyright © 2007-2008 Dilovan. All Rights Reserved # //
// #----------------------------------------------------# //
// #----------------------------------------------------# //
// # If you want any support vist down address:-        # //
// # Email: df@duhoktimes.com                           # //
// # Site: http://df.duhoktimes.com/index.php           # //
// ###################################################### //
//////////////////////////////////////////////////////////*/


// لا تعدل في هنا	
$DESTINATION_FOLDER = $_POST["folder"];
// قم هنا بالتعديل على حجم الملفات المحملة
$MAX_SIZE = 5000000;
// أتركه كما هو إذا
$RETURN_LINK = $_SERVER['HTTP_REFERER'];
// لا اغيرها هنا لكي لا تصير مشاكل و يرفع شيل او ثغرة
$AUTH_EXT = array(".css",".gif",".png",".bmp",".jpg");



function createReturnLink(){
	global $RETURN_LINK;
	echo "<a href='".$RETURN_LINK."'>إضغط هنا للعودة</a><br>";
}




function isExtAuthorized($ext){
	global $AUTH_EXT;
	if(in_array($ext, $AUTH_EXT)){
		return true;
	}else{
		return false;
	}
}

// لا تلمس شيئا بعد هذا السطر من فضلك
// bien rempli.

if(!empty($_FILES["file"]["name"])){
	
	// إسم الملف المختار:
	$nomFichier = $_FILES["file"]["name"] ;
	// إسم ملف التخزين بالسيرفر:
	$nomTemporaire = $_FILES["file"]["tmp_name"] ;
	// نوع ملف التحميل:
	$typeFichier = $_FILES["file"]["type"] ;
	// حجم الملف:
	$poidsFichier = $_FILES["file"]["size"] ;
	// كود الخطأ:
	$codeErreur = $_FILES["file"]["error"] ;
	// قدرة الملف
	$extension = strrchr($nomFichier, ".");
	
	// Si le poids du fichier est de 0 bytes, le fichier est
	// invalide (ou le chemin incorrect) => message d'erreur
	// sinon, le script continue.
	if($poidsFichier <> 0){
		// في حالة أن الملف أكبر
		// الملف كبير : رسالة الخطأ
		if($poidsFichier < $MAX_SIZE){

			if(isExtAuthorized($extension)){

				$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER.$nomFichier);
				if($uploadOk){
					echo("تم تحميل الملف<br><br>");
					echo(createReturnLink());
				}else{
					echo("لم يتم تحميل الملف !<br><br>");
					echo(createReturnLink());
				}
			}else{
				echo ("الملفات ذات الإختصاص $extension لا يسمح بتحميلها !<br>");
				echo (createReturnLink()."<br>");
			}
		}else{
			$tailleKo = $MAX_SIZE / 1000;
			echo("لا يسمح بتحميل الملفات التي تتجاوز الحجم : $tailleKo Ko.<br>");
			echo (createReturnLink()."<br>");
		}		
	}else{
		echo("الملف الذي إخترته غير صحيح !<br>");
		echo (createReturnLink()."<br>");
	}
}else{
	echo("لم تختر أي ملف !<br>");
	echo (createReturnLink()."<br>");
}
?>

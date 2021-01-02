/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */

/************************************************#
* DM Editor v1.1
* Work with below libraries
* 1- JQuery Library 1.7.1 and later versions
* 2- DM Library 1.0 and later versions
* Copyright 2007 - 2021, Dilovan Matini
*
* Date: Wednesday, ‎December ‎28, 2021
#************************************************/

if(!$.DM){
	$.DM = {};
}
var ie6 = ($.browser.msie && $.browser.version >= 6 && $.browser.version < 7) ? true : false,
ie8 = ($.browser.msie && $.browser.version < 9) ? true : false,
ie9 = ($.browser.msie && $.browser.version >= 9) ? true : false,
opera = $.browser.opera,
mozilla = $.browser.mozilla,
webkit = $.browser.webkit,
oldBrowser = (($.browser.msie && $.browser.version < 6) || (opera && $.browser.version < 8)||(mozilla && $.browser.version < 2)||($.browser.safari && $.browser.version < 3)) ? true : false,
xload = (typeof xcode != 'undefined' ? xcode : '?x=1.1');
/**
* @namespace $.DM
* @class editor
*/
$.DM.editor = {
	version: '1.1',
	type: 'advanced',
	rand: DM.rand(),
	place: false,
	toolbarPlace: false,
	bodyPlace: false,
	box: false,
	boxName: '',
	tempSel: false,
	tempSelType: false,
	path: '',
	toolbox: '',
	userCSSText: '',
	setting: {
		outPlace: 'editorPlace',
		width: '900',
		height: '400',
		dir: '',
		align: '',
		disalign: '',
		margin: '4px',
		outBorder: '#c3c3c3',
		overBorder: '#606060',
		upBG: '',
		downBG: '',
		ajaxFile: 'ajax.php',
		cssFile: 'style.css',
		userCSS: {
			textAlign: '',
			fontWeight: 'bold',
			fontFamily: 'arial',
			fontSize: '15px',
			color: '#000'
		},
		previewText: 'DM Editor v1.1',
		editorMode: 'WYSI', /** WYSI, HTML */
		basicHTML: '<html><head></head><body><div></div></body></html>'
	},
	use: {
		fontName: true,
		fontSize: true,
		iconLibrary: true,
		copy: true,
		paste: true,
		bold: true,
		italic: true,
		underline: true,
		strikeThrough: true,
		justifyLeft: true,
		justifyCenter: true,
		justifyRight: true,
		line: true,
		numberList: true,
		bullList: true,
		foreColor: true,
		backColor: true,
		symbol: true,
		image: true,
		link: true,
		table: true,
		phpCode: true,
		userStyle: true,
		editorMode: false
	},
	fonts: [
		['tahoma', 'Tahoma'],
		['arial', 'Arial'],
		['arial black', 'Arial Black'],
		['akhbar MT', 'Akhbar'],
		['arabic transparent', 'Basit'],
		['comic sans ms', 'Comic'],
		['courier new', 'Courier New'],
		['diwani letter', 'Diwani'],
		['arial narrow', 'Narrow'],
		['times new roman', 'Times'],
		['monotype kufi', 'Kufi'],
		['andalus', 'Andalus'],
		['old antic bold', 'Antic'],
		['verdana', 'Verdana'],
		['wingdings', 'Wingdings']
	],
	sizes: [8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 28, 32, 40, 48, 60, 72],
	smiles: [
		['8ball.gif', 'angry.gif', 'approve.gif'],
		['big.gif', 'blackeye.gif', 'blush.gif'],
		['wink.gif', 'cool.gif', 'crying.gif'],
		['dead.gif', 'dissapprove.gif', 'evil.gif'],
		['eyebrows.gif', 'hearteyes.gif', 'icon.gif'],
		['waving2.gif', 'kisses.gif', 'nono.gif'],
		['question.gif', 'rotating.gif', 'sad.gif'],
		['shock.gif', 'shy.gif', 'sleepy.gif'],
		['tongue.gif', 'wailing.gif', 'waving.gif']
	],
	setImages: function(){
		var path = this.path, x = xload;
		this.img = {
			blank: path+'assets/blank.gif'+x,
			progress: path+'assets/progress.gif'+x,
			success: path+'assets/success.gif'+x,
			error: path+'assets/error.gif'+x,
			buttons: path+'assets/editor-buttons.gif'+x,
			buttonBack: path+'assets/editor-buttons-back.gif'+x,
			buttonBackDown: path+'assets/editor-buttons-back-down.gif'+x
		};
	},
	resize: function(){
		$(function(){
			var editor = DMEditor, setting = editor.setting, width = setting.width+'', height = setting.height+'', iw = parseInt(width),ih = parseInt(height),
			w = h = 0, outPlace = $I('#'+setting.outPlace), margin = (parseInt(setting.margin) || 0) * 2;
			if(isNaN(iw) || iw < 1){
				iw = 900;
			}
			if(isNaN(ih) || ih < 1){
				ih = 400;
			}
			if(outPlace){
				w = $(outPlace).width() - margin - 25;
				h = $(outPlace).height() - margin - 5;
				if(width.indexOf('%') >= 0 && w > 0){
					iw = (iw >= 100) ? w : (w / 100) * iw;
				}
				if(height.indexOf('%') >= 0 && h > 0){
					ih = (ih >= 100) ? h : (h / 100) * ih;
				}
			}
			setting.width = iw;
			setting.height = ih;
			editor.place.css({'width': iw+'px', 'height': ih+'px'});
			editor.toolbarPlace.css({'width': iw+'px'});
			editor.bodyPlace.css({'width': iw+'px', 'height': (ih - 30)+'px'});
			$(editor.box).css({'width': iw+'px', 'height': (ih - 32)+'px'});
		});
	},
	setDefault: function( options ){
		var editor = this;
		DM.extend(editor, options);
		editor.path = DM.path+'editor/';
		editor.setImages();
		var setting = editor.setting, img = editor.img, align = setting.align.toLowerCase(), alignArr = ['right', 'left'];
		setting.dir = (setting.dir == '') ? ($('html').attr('dir') == 'rtl' ? 'rtl' : 'ltr') : setting.dir;
		setting.align = (alignArr.inArray(align)) ? align : ((setting.dir == 'rtl') ? 'right' : 'left');
		setting.disalign = (setting.align == 'right') ? 'left' : 'right';
		if(setting.upBG == ''){
			setting.upBG = '#f1f0f0 url('+img.buttonBack+') repeat-x';
		}
		if(setting.downBG == ''){
			setting.downBG='#f1f0f0 url('+img.buttonBackDown+') repeat-x';
		}
		editor.setUserCSS(setting.userCSS);
	},
	run: function( options ){
		this.setDefault( options );
		var editor = this, rand = editor.rand, setting = editor.setting;
		if( oldBrowser ){
			document.write('<center><nobr>متصفحك غير ملائم لتقنية هذا المحرر<br>يجب عليك تحميل أحد متصفحات الداعمة لتقنية هذا المحرر<br>المتصفحات الداعمة لهذا المحرر:-<br>Internet Explorer v6 to latest versions<br>Mozilla v2 to latest versions<br>Opera v8 to latest versions<br>Safari v3 to latest versions<br>Google chrome all versions.</nobr></center>');
			return;
		}
		document.write(''+
		'<link rel="stylesheet" type="text/css" href="'+editor.path+'assets/'+setting.cssFile+xload+'" />'+
		'<div id="editorPlace'+rand+'" class="DMEditor" style="margin:'+setting.margin+';border:'+setting.outBorder+' 1px solid;" dir="'+setting.dir+'">'+
		'	<div id="toolbarPlace'+rand+'" class="toolbar" style="border-bottom:'+setting.outBorder+' 1px solid;" dir="ltr"></div>'+
		'	<div id="editorBody'+rand+'" class="body" style="border-bottom:'+setting.outBorder+' 1px solid;">'+
		'		<iframe id="contentPlace'+rand+'" name="contentPlace'+rand+'" contentEditable="true" noborder></iframe>'+
		'	</div>'+
		'	<iframe id="contentTempPlace'+rand+'" name="contentTempPlace'+rand+'" class="tempBox" contentEditable="true"></iframe>'+
		'</div>');
		editor.place = $('#editorPlace'+rand);
		editor.place.hide();
		editor.toolbarPlace = $('#toolbarPlace'+rand);
		editor.bodyPlace = $('#editorBody'+rand);
		editor.boxName = 'contentPlace'+rand;
		editor.box = $I('#'+editor.boxName);
		editor.toolbar.create();
		editor.setContent(setting.basicHTML);
		editor.resize();
		$(function(){
			editor.place.show();
			if(editor.type == 'advanced'){
				editor.focus();
			}
		});
	},
	eBox: function(obj){
		return eval(obj);
	},
	setContent: function(content){
		var editor = this, obj = editor.eBox(editor.boxName), tempObj = editor.eBox('contentTempPlace'+editor.rand), style = editor.setting.style, doc;
		if( tempObj.document && tempObj.document.designMode ){
			tempObj.document.designMode = 'on';
		}
		doc = tempObj.document.open('text/html', 'replace');
		doc.write(content);
		doc.close();
		doc = obj.document.open('text/html', 'replace');
		doc.write($(tempObj.document.documentElement).html());
		doc.close();
		if('spellcheck' in obj.document.body){
			obj.document.body.spellcheck = false;
		}
		if('contentEditable' in obj.document.body){
			obj.document.body.contentEditable = true;
		}
		else{
			if('designMode' in obj.document.body.contentWindow.document){
				obj.document.body.contentWindow.document.designMode = 'on';
			}
		}
		if('oncontextmenu' in obj.document.body){
			obj.document.body.oncontextmenu=function(){return false;};
		}
		if(ie8){
			obj.document.execCommand("2D-Position", true, true);
			obj.document.execCommand("MultipleSelection", true, true);
			obj.document.execCommand("LiveResize", true, true);
		}
		$(obj.document.body).keypress(function(e){
			if(e.which == 13){
				editor.focus();
				if(ie8){
					editor.pasteHTML('<br>', true);
				}
				else if(mozilla || ie9){
					var r = editor.getRange();
					r.deleteContents();
					r.insertNode('<br>');
				}
				else{
					return true;
				}
				return false;
			}
		});
		$(obj.document.body).focus(function(){
			editor.hideBoxes();
		});
		editor.setCSSText('WYSI');
	},
	getContent: function(lenght){ /** if lenght == true means get text length else get content */
		var editor = this, obj = editor.eBox(editor.boxName), tempObj = editor.eBox("contentTempPlace"+editor.rand), doc, text,
		tags = [ /** 0 = block, 1 = inline */
			['div', 0],
			['p', 0],
			['span', 1],
			['font', 1]
		],
		selectors = [
			'padding-top: 0px;',
			'padding-right: 0px;',
			'padding-bottom: 0px;',
			'padding-left: 0px;',
			'border-top-width: 0px;',
			'border-right-width: 0px;',
			'border-bottom-width: 0px;',
			'border-left-width: 0px;',
			'border-left-width: 0px;',
			'margin: 0px;',
			'border-image: initial'
		];
		lenght = (lenght === true) ? true : false;
		if(lenght){
			doc = obj.document.documentElement;
		}
		else{
			doc = tempObj.document.open('text/html', 'replace');
			doc.write($(obj.document.documentElement).html());
			doc.close();
			doc = tempObj.document.documentElement;
		}
		text = $(doc).html();
		text = text.substr(text.toLowerCase().indexOf("<body")+1);
		text = text.substr(text.indexOf(">")+1);
		if(text.substr(0, 2) == "\r\n"){
			text = text.substr(2);
		}
		text = text.substr(0, text.toLowerCase().indexOf("</body>"));
		for(var x = 0, re; x < selectors.length; x++){
			re = new RegExp(selectors[x], "gim");
			text = text.replace(re, '');
		}
		text = text.replace(/\s*style="\s*"/gim, '');
		for(var x = 0, re; x < tags.length; x++){
			re = new RegExp("<\s*"+tags[x][0]+"\s*>\s*</"+tags[x][0]+">", "gim");
			text = text.replace(re, '');
			if(tags[x][1] === 1){
				re = new RegExp("<\s*"+tags[x][0]+"\s*>(.*)</"+tags[x][0]+">", "gim");
				text = text.replace(re, '$1');
			}
		}
		text = text.replace(/<img border=([0-9]*)/gim, '<img style="border:#000 $1px solid;"');//border:#000 5px solid
 		text = text.replace(/style="([^"]*)"/gim, function(a, style){
			var styles = [], selector, prop, value,
			temp = [],
			borders = [
				'border-top',
				'border-right',
				'border-bottom',
				'border-left'
			],
			paddings = [
				'padding-top',
				'padding-right',
				'padding-bottom',
				'padding-left'
			],
			check = function(type){
				arr = temp[type];
				if(arr.length == 4 && arr[0][1] == arr[1][1] && arr[0][1] == arr[2][1] && arr[0][1] == arr[3][1]){
					styles[styles.length] = type+':'+arr[0][1];
				}
				else{
					for(var x = 0; x < arr.length; x++){
						styles[styles.length] = arr[x][0]+':'+arr[x][1];
					}
				}
			};
			style = style.replace('\n', '').replace('\t', '').replace('\r', '');
			style = style.split(';');
			temp['border'] = [];
			temp['padding'] = [];
			for(var x = 0; x < style.length; x++){
				selector = style[x].trim();
				if(selector.indexOf(':') >= 0){
					selector = selector.split(':');
					prop = selector[0].toLowerCase();
					value = selector[1];
					if(borders.inArray(prop)){
						temp['border'][temp['border'].length] = [prop, value];
					}
					else if(paddings.inArray(prop)){
						temp['padding'][temp['padding'].length] = [prop, value];
					}
					else{
						styles[styles.length] = prop+':'+value;
					}
				}
			}
			check('border');
			check('padding');
			style = styles.join(';');
			style = 'style="'+style+'"';
			return style;
		});
		if(!lenght){
			text = text.replace(/^\s*<br>/gim, '');
		}
		return (lenght) ? text.length : text;
	},
	setCSSText: function(mode){
		var editor = this, css = '', userCSS = editor.setting.userCSS, userCSSText = '',
		align = (mode == 'WYSI') ? userCSS.textAlign : 'left',
		weight = (mode == 'WYSI') ? userCSS.fontWeight : 'normal',
		family = (mode == 'WYSI') ? userCSS.fontFamily : '\'Courier New\',tahoma',
		size = (mode == 'WYSI') ? userCSS.fontSize : '15px',
		color = (mode == 'WYSI') ? userCSS.color : '#000',
		dir = (mode == 'WYSI') ? editor.setting.dir : 'ltr';
		userCSSText = 'text-align:'+align+';font-weight:'+weight+';font-family:'+family+';font-size:'+size+';color:'+color+';';
		editor.userCSSText = userCSSText;
		css = 'margin:0;padding:0;border-width:0;background-color:#fff;'+userCSSText+'direction:'+dir+';';
		editor.eBox(editor.boxName).document.body.style.cssText = css;
	},
	editorMode: function(){
		var editor = this, setting = editor.setting;
 		editor.hideBoxes();
		var obj = editor.eBox(editor.boxName);
		if(setting.editorMode == 'WYSI'){
			var content = editor.getContent();
			$(obj.document.body).text(content);
			editor.setCSSText('HTML');
			editor.toolbar.disable(true, '*', 'editorMode');
			setting.editorMode = 'HTML';
		}
		else{
			editor.setContent($(obj.document.body).text());
			editor.setCSSText('WYSI');
			editor.toolbar.disable(false, '*' ,'editorMode');
			setting.editorMode = 'WYSI';
		}
	},
	setUserCSS: function(obj){
		var editor = this, setting = editor.setting, userCSS = setting.userCSS,
		check = function(name, def, arr){
			var outpot = '', size, prop = obj[name];
			prop = ($T(prop) == 'string') ? prop.toLowerCase() : '';
			if(prop != '' && !arr || arr && arr.inArray(prop)){
				if(name == 'fontSize'){
					size = parseInt(prop) || 0;
					prop = (size > 0) ? size+'px' : def;
				}
				outpot = prop;
			}
			else{
				outpot = def;
			}
			return outpot;
		};
		if(obj){
			userCSS.textAlign = check('textAlign', setting.align, ['right', 'left', 'center']);
			userCSS.fontWeight = check('fontWeight', 'bold', ['bold', 'normal']);
			userCSS.fontFamily = check('fontFamily', 'arial');
			userCSS.fontSize = check('fontSize', '15px');
			userCSS.color = check('color', '#000');
		}
	},
	toolbar: {
		place: false,
		buttons: [],
		buttonsArr: [
			['fontName', -1, 'نمط الخط', "doFontName();"],
			['fontSize', -1, 'حجم الخط', "doFontSize();"],
			['iconLibrary', 512, 'مكتبة آيقونات', "doInsertIcons();"],
			['copy', 64, 'نسخ', "setCommand('Copy');"],
			['paste', 80, 'لصق', "setCommand('Paste');"],
			['bold', 208, 'خط ثقيل', "setCommand('Bold');"],
			['italic', 224, 'خط مائل', "setCommand('Italic');"],
			['underline', 240, 'تحته خط', "setCommand('Underline');"],
			['strikeThrough', 256, 'عليه خط', "setCommand('Strikethrough');"],
			['justifyLeft', 368, 'في اليسار', "setCommand('JustifyLeft');"],
			['justifyCenter', 384, 'في الوسط', "setCommand('JustifyCenter');"],
			['justifyRight', 400, 'في اليمين', "setCommand('JustifyRight');"],
			['numberList', 304, 'قائمة مرقمة', "setCommand('InsertOrderedList');"],
			['bullList', 320, 'قائمة', "setCommand('InsertUnorderedList');"],
			['line', 496, 'أدخل خط أفقي', "setCommand('InsertHorizontalRule');"],
			['foreColor', 704, 'لون النص', "doForeColor();"],
			['backColor', 544, 'لون خلفية النص', "doBackColor();"],
			['symbol', 528, 'ادخل شعار', "doInsertSymbol();"],
			['image', 576, 'ادخل او غير صورة', "doImage.open();"],
			['link', 432, 'ادخل وصلة', "doLink.open();"],
			['table', 480, 'أدخل او غير جدول‌', "doTable.open();"],
			['phpCode', 688, 'ادخل شيفرة PHP', "doPHPCode.open();"],
			['userStyle', 720, 'خصائص العرض', "userStyle.open();"],
			['editorMode', 672, 'عرض شيفرات لغة HTML', "editorMode();"]
		],
		create: function(){
			var editor = DMEditor, toolbar = editor.toolbar, setting = editor.setting, b = toolbar.buttonsArr, html = '';
 			html += '<table cellpadding="3" cellspacing="2"><tr>';
			$.each(b, function(i, v){
				var id = v[0],
				use = editor.eBox('DMEditor.use.'+id),
				y = v[1],
				tip = v[2],
				cmd = 'DMEditor.'+v[3],
				text = '';
				if(use === true){
					if(y == -1){
						text = toolbar.setArrow('<nobr>'+tip+'</nobr>');
					}
					else{
						text = '<img class="buttonImg" src="'+editor.img.blank+'" style="background:url('+editor.img.buttons+') no-repeat 0 -'+y+'px;">';
					}
					if(id == 'iconLibrary'){
						text = toolbar.setArrow(text);
					}
					html += '<td id="buttonCell'+id+'" buttonid="'+id+'" tip="'+tip+'" cmd="'+cmd+'" class="buttonCell" style="border:'+setting.outBorder+' 1px solid;background:'+setting.upBG+';"><div id="buttonDiv'+id+'" buttonid="'+id+'" class="buttonDiv">'+text+'</div></td>';
				}
			});
			html += '</tr></table>';
			editor.toolbarPlace.html(html);
			toolbar.tips = [];
			toolbar.buttons['store'] = [];
			for(var x = 0; x < b.length; x++){
				var id = b[x][0],
				button = $I('#buttonCell'+id),
				div = $I('#buttonDiv'+id),
				tipId = 'button'+id+'Tip';
				toolbar.buttons[id] = {
					id: id,
					button: button,
					disabled: false,
					disable: function(s){
						if(s === true){
							$('#buttonDiv'+this.id).css({opacity: .4});
							this.disabled = true;
						}
						else{
							$('#buttonDiv'+this.id).css({opacity: 1});
							this.disabled = false;
						}
					}
				};
				toolbar.buttons['store'][x] = id;
				$(div).append('<div id="'+tipId+'" class="buttonTip" style="border:'+setting.outBorder+' 1px solid;" dir="'+setting.dir+'"><nobr>'+b[x][2]+'</nobr></div>');
				$('#'+tipId).hide();
				toolbar.tips[x] = tipId;
				$(div).hover(
					function(){
						var id = $(this).attr('buttonid');
						if(!toolbar.disabled(id)){
							$('#button'+id+'Tip').fadeIn('slow').show();
						}
					},
					function(){
						var tips = toolbar.tips;
						$.each(tips, function(i, v){
							$('#'+v).hide();
						});
					}
				);
				$(button).mouseout(function(){
					var id = $(this).attr('buttonid');
					if(!toolbar.disabled(id)){
						$(this).css('border', setting.outBorder+' 1px solid');
					}
				});
				$(button).mouseover(function(){
					var id = $(this).attr('buttonid');
					if(!toolbar.disabled(id)){
						$(this).css('border', setting.overBorder+' 1px solid');
					}
				});
				$(button).mouseup(function(){
					var id = $(this).attr('buttonid');
					if(!toolbar.disabled(id)){
						$(this).css('background', setting.upBG);
						if(editor.toolbox == id){
							editor.toolbox = '';
						}
						else{
							editor.eBox($(this).attr('cmd'));
						}
					}
				});
				$(button).mousedown(function(){
					var id = $(this).attr('buttonid');
					if(!toolbar.disabled(id)){
						$(this).css('background', editor.setting.downBG);
					}
				});
			}
			$('#toolbarPlace'+editor.rand+' *').attr('unselectable', 'on');
		},
		disable: function(s, within, without){
			var wi = [], wo = [], all = false, b = this.buttons['store'], id;
			s = (s === true) ? true : false;
 			if($T(within) === 'string'){
				if(within == '*'){
					all = true;
				}
				else{
					wi[wi.length] = within;
				}
			}
			else if($T(within) === 'array'){
				wi = within;
			}
			else{
				all = true;
			}
			if($T(without) === 'string'){
				wo[wo.length] = without;
			}
			else if($T(without) === 'array'){
				wo = without;
			}
			$.each(b, function(i, id){
				if($.inArray(id, wo) == -1){
					if(all || $.inArray(id, wi) >= 0){
						DMEditor.toolbar.buttons[id].disable(s);
					}
				}
			});
		},
		disabled: function(id){
			var s = (this.buttons[id].disabled === true) ? true : false;
			return s;
		},
		setArrow: function(c){
			var text = '<table cellpadding="0" cellspacing="0"><tr><td class="buttonText">'+c+'</td><td><img class="buttonArrow" src="'+DMEditor.img.blank+'"></td></tr></table>';
			return text;
		}
	},
	hideBoxes: function(){
		var boxes = ['fontNameBox', 'fontSizeBox', 'iconLibraryBox'];
		$.each(boxes, function(i, v){
			$('#'+v).css('visibility', 'hidden');
		});
		DM.container.close();
		this.toolbox = '';
	},
	getDoc: function(){
		var box = this.box, doc = false;
		if(box){
			try{
				if(box.contentWindow && box.contentWindow.document){
					doc = box.contentWindow.document;
					return doc;
				}
			}catch(e){}
		}
		return false;
	},
	getWindow: function(){
		var box = this.box, win = false;
		if(box && box.contentWindow){
			win = box.contentWindow;
		}
		return win;
	},
	focus: function(){
		this.getWindow().focus();
	},
	getSelection: function(){
		var editor = this, sel = null;
		if(editor.getDoc() && editor.getWindow()){
			if(editor.getDoc().selection){
				sel = editor.getDoc().selection;
			}
			else{
				sel = editor.getWindow().getSelection();
			}
 			if(webkit){
				if(sel.baseNode){
					editor.checkSel = {
						baseNode: sel.baseNode,
						baseOffset: sel.baseOffset,
						extentNode: sel.extentNode,
						extentOffset: sel.extentOffset
					};
				}
				else if($T(editor.checkSel) !== 'undefined' && editor.checkSel != null){
					sel = editor.getWindow().getSelection();
					sel.setBaseAndExtent(editor.checkSel.baseNode, editor.checkSel.baseOffset, editor.checkSel.extentNode, editor.checkSel.extentOffset);
					editor.checkSel = null;
				}
			}
		}
		return sel;
	},
	getRange:function(){
		var editor = this, sel = editor.getSelection();
		if(sel === null){
			return null;
		}
		if(webkit && !sel.getRangeAt){
			var range = editor.getDoc().createRange();
			try{
				range.setStart(sel.anchorNode, sel.anchorOffset);
				range.setEnd(sel.focusNode, sel.focusOffset);
			}
			catch(e){
				range = editor.getWindow().getSelection()+'';
			}
			return range;
		}
		if(ie8){
			try{
				return sel.createRange();
			}
			catch(e2){
				return null;
			}
		}
		if(opera){
			try{
				return sel.getRangeAt(0);
			}
			catch(e2){
				return null;
			}
		}
		if(sel.rangeCount > 0){
			return sel.getRangeAt(0);
		}
		return null;
	},
	pasteHTML: function(text, enter){ /** if "enter" === true : means paste enter event */
		var editor = this;
		if(ie8){
			var sel = editor.getRange(), type, target;
			if(enter === true){
				sel.pasteHTML(text);
				sel.select();
				sel.moveEnd("character",1);
				sel.moveStart("character",1);
				sel.collapse(false);
			}
			else{
				if(editor.tempSel){
					sel = editor.tempSel;
				}
				sel = editor.fixSel(sel);
				type = editor.fixSelType(sel, type);
				target = (type == 'None') ? editor.getDoc() : sel;
				sel.select();
				target.pasteHTML(text);
			}
		}
		else{
			var frag = editor.getDoc().createDocumentFragment();
			var div = editor.getDoc().createElement("div");
			div.innerHTML = text;
			while(div.firstChild){
				frag.appendChild(div.firstChild);
			}
			var sel = editor.getSelection(), range;
			if(sel.rangeCount>0){
				range = sel.getRangeAt(0);
			}
			else{
				range = editor.getRange();
			}
			if(range === null){
				return;
			}
			sel.removeAllRanges();
			range.deleteContents();
			var n = range.startContainer;
			var p = range.startOffset;
			if(n.nodeType == 3){
				if(frag.nodeType == 3){
					n.insertData(p, frag.data);
					range.setEnd(n, p+frag.length);
					range.setStart(n, p+frag.length);
				}
				else{
					n = n.splitText(p);
					n.parentNode.insertBefore(frag, n);
					if(!opera){
						range.setEnd(n, p+frag.length);
						range.setStart(n, p+frag.length);
					}
				}
			}
			else if(n.nodeType == 1){
				if(mozilla){
					range.insertNode($((text.indexOf("<") !=0 ) ? $("<span/>").append(text) : text)[0]);
				}
				else{
					range.insertNode($(editor.getDoc().createElement("span")).append($((text.indexOf("<") != 0) ? "<span>"+text+"</span>" : text))[0]);
				}
			}
			sel.addRange(range);
		}
	},
	hasSelection: function(){
		var sel = this.getSelection(),
		range = this.getRange(),
		hasSel = false;
		if(!sel || !range){
			return hasSel;
		}
		if($.browser.msie || opera){
			if(range.text){
				hasSel = true;
			}
			if(range.html){
				hasSel = true;
			}
		}
		else{
			if(webkit){
				if(sel+'' !== ''){
					hasSel = true;
				}
			}
			else{
				if(sel && (sel.toString() !== '') && ($T(sel) !== 'undefined')){
					hasSel = true;
				}
			}
		}
		return hasSel;
	},
	getTarget: function(e){
		var target = e.target || e.srcElement;
		try{
			if(target && target.nodeType == 3){
				return target.parentNode;
			}
		}
		catch(e){}
		return target;
	},
	isElement: function(el, tag){
		if(el && el.tagName && (el.tagName.toLowerCase() == tag)){
			return true;
		}
		if(el && el.getAttribute && (el.getAttribute('tag') == tag)){
			return true;
		}
		return false;
	},
	getSelectedElement: function(){
		var editor = this, doc = editor.getDoc(), range = null, sel = null, el = null, check = true;
		if(ie8){
			editor.currentEvent = editor.getWindow().event;
			range = editor.getRange();
			if(range){
				el = range.item ? range.item(0) : range.parentElement();
				if(el === doc.body) {
					el = null;
				}
			}
			if((editor.currentEvent !== null) && (editor.currentEvent.keyCode === 0)){
				el = editor.getTarget(editor.currentEvent);
			}
		}
		else{
			sel = editor.getSelection();
			range = editor.getRange();
			if(!sel || !range){
				return null;
			}
			if($.browser.gecko){
				if(range.startContainer){
					if(range.startContainer.nodeType === 3){
						el = range.startContainer.parentNode;
					}
					else if(range.startContainer.nodeType === 1){
						el = range.startContainer;
					}
					if(editor.currentEvent){
						var tar = editor.getTarget(editor.currentEvent);
						if(!editor.isElement(tar, 'html')){
							if(el !== tar){
								el = tar;
							}
						}
					}
				}
			}
			if(check){
				if(sel.anchorNode && (sel.anchorNode.nodeType == 3)){
					if(sel.anchorNode.parentNode){
						el = sel.anchorNode.parentNode;
					}
					if(sel.anchorNode.nextSibling != sel.focusNode.nextSibling){
						el = sel.anchorNode.nextSibling;
					}
				}
				if(editor.isElement(el, 'br')){
					el = null;
				}
				if(!el){
					el = range.commonAncestorContainer;
					if(!range.collapsed) {
						if(range.startContainer == range.endContainer){
							if(range.startOffset - range.endOffset < 2){
								if(range.startContainer.hasChildNodes()){
									el = range.startContainer.childNodes[range.startOffset];
								}
							}
						}
					}
				}
		   }
		}
		if(editor.currentEvent !== null){
			try{
				if(editor.currentEvent.type == 'click' || editor.currentEvent.type == 'mousedown' || editor.currentEvent.type == 'mouseup'){
					if(webkit){
						el = editor.getTarget(editor.currentEvent);
					}
				}
			}
			catch(e){}
		}
		if(opera || webkit){
			if(editor.currentEvent && !el){
				el = editor.getTarget(editor.currentEvent);
			}
		}
		if(!el || !el.tagName){
			el = doc.body;
		}
		if(editor.isElement(el, 'html')){
			el = doc.body;
		}
		if(editor.isElement(el, 'body')){
			el = doc.body;
		}
		if(el && !el.parentNode){
			el = doc.body;
		}
		if($T(el) === 'undefined'){
			el = null;
		}
		return el;
	},
	setCommand: function(cmd, user, value, type){
		var editor = this;
		editor.hideBoxes();
		if(ie8){
 			var obj = editor.eBox(editor.boxName), cache = (type != null && type == 2);
			if(cache){
				var sel = editor.tempSel;
				var type = editor.tempSelType;
			}
			else{
				var sel = obj.document.selection.createRange(), type = obj.document.selection.type;
			}
			sel = editor.fixSel(sel);
			type = editor.fixSelType(sel, type);
			var target = (type == 'None') ? obj.document : sel;
			if(cache){
				sel.select();
			}
			target.execCommand(cmd, false, value);
		}
		else{
			if(cmd == 'BackColor'){
				cmd = 'hilitecolor';
			}
			editor.focus();
			editor.getDoc().execCommand(cmd, user || false, value || null);
		}
	},
	fixSel: function(sel){
		var obj = this.eBox(this.boxName);
		if(sel.parentElement != null){
			if(!this.isInsideEditor(sel.parentElement())){
				obj.focus();
				var sel = obj.document.selection.createRange();
			}
		}
		else{
			if(!this.isInsideEditor(sel.item(0))){
				obj.focus();
				var sel = obj.document.selection.createRange();
			}
		}
		return sel;
	},
	fixSelType:function(sel, type){
		var obj = this.eBox(this.boxName);
		if(sel.parentElement != null){
			if(!this.isInsideEditor(sel.parentElement())){
				obj.focus();
				var type = obj.document.selection.type;
			}
		}
		else{
			if(!this.isInsideEditor(sel.item(0))){
				obj.focus();
				var type = obj.document.selection.type;
			}
		}
		return type;
	},
	isInsideEditor:function(el){
		while(el != null){
			if(el.tagName == 'BODY' && el.contentEditable == 'true'){
				return true;
			}
			el = el.parentElement;
		}
		return false;
	},
	msieSelection: function(){
		if(ie8){
			var o = this.eBox(this.boxName);
			this.tempSel = o.document.selection.createRange();
			this.tempSelType = o.document.selection.type;
		}
	},
	doFontName: function(){
		var editor = this, setting = editor.setting;
		if(editor.use.fontName === true){
			editor.hideBoxes();
			editor.msieSelection();
			editor.toolbox = 'fontName';
			var box = $I('#fontNameBox'), fonts = editor.fonts;
			if(!box){
				var text = '';
 				$.each(fonts, function(i, v){
					text += '<tr><td onclick="DMEditor.setCommand(\'FontName\',null,\''+v[0]+'\',2);" style="border:'+setting.outBorder+' 1px solid;padding:2px 5px;text-align:left;cursor:pointer;font:normal 11px tahoma;background:'+setting.upBG+';"><nobr>'+v[1]+'</nobr></td></tr>';
				});
				$('#buttonDivfontName').append('<div id="fontNameBox" style="position:absolute;left:-5px;top:21px;"><table width="100%" cellspacing="1" cellpadding="0">'+text+'</table></div>');
				$('#fontNameBox td').mouseout(function(){
					$(this).css('border', setting.outBorder+' 1px solid');
				});
				$('#fontNameBox td').mouseover(function(){
					$(this).css('border', setting.overBorder+' 1px solid');
				});
			}
			else{
				$(box).css('visibility', 'visible');
			}
		}
	},
	doFontSize:function(){
		var editor = this, setting = editor.setting;
		if(editor.use.fontSize === true){
			editor.msieSelection();
			editor.hideBoxes();
			editor.toolbox = 'fontSize';
			var box = $I('#fontSizeBox');
			if(!box){
				var text = '';
				for(var x = 1; x <= 7; x++){
					text += '<tr><td onclick="DMEditor.setCommand(\'FontSize\',null,\''+x+'\',2);" style="border:'+setting.outBorder+' 1px solid;padding:1px 20px;text-align:center;cursor:pointer;font:normal 11px tahoma;background:'+setting.upBG+';"><nobr>'+x+'</nobr></td></tr>';
				}
				$('#buttonDivfontSize').append('<div id="fontSizeBox" style="position:absolute;left:-5px;top:21px;"><table width="100%" cellspacing="1" cellpadding="0">'+text+'</table></div>');
				$('#fontSizeBox td').mouseout(function(){
					$(this).css('border', setting.outBorder+' 1px solid');
				});
				$('#fontSizeBox td').mouseover(function(){
					$(this).css('border', setting.overBorder+' 1px solid');
				});
			}
			else{
				$(box).css('visibility','visible');
			}
		}
	},
	doInsertIcons:function(){
		var editor = this, setting = editor.setting;
		if(editor.use.iconLibrary === true){
			editor.msieSelection();
			editor.hideBoxes();
			editor.toolbox = 'iconLibrary';
			var box = $I('#iconLibraryBox'), smiles = editor.smiles, text = '', src = '';
			if(!box){
				$.each(smiles, function(i, v){
					text += '<tr>';
					$.each(v, function(i, v){
						src = editor.path+'assets/smiles/'+v;
						text += '<td img="'+src+'" style="border:'+setting.outBorder+' 1px solid;padding:2px;text-align:center;cursor:pointer;font:normal 11px tahoma;background:'+setting.upBG+';"><img src="'+src+'" width="22" height="22"></td>';
					});
					text += '</tr>';
				});
				$('#buttonDiviconLibrary').append('<div id="iconLibraryBox" style="position:absolute;left:-5px;top:21px;"><table width="100%" cellspacing="1" cellpadding="0">'+text+'</table></div>');
				$('#iconLibraryBox td').mouseout(function(){
					$(this).css('border', setting.outBorder+' 1px solid');
				});
				$('#iconLibraryBox td').mouseover(function(){
					$(this).css('border', setting.overBorder+' 1px solid');
				});
				$('#iconLibraryBox td').mouseup(function(){
					editor.doImage.insert({
						src: $(this).attr('img'),
						hspace: 5
					});
				});
			}
			else{
				$(box).css('visibility', 'visible');
			}
		}
	},
	doForeColor: function(){
		var editor = this, container = DM.container;
		if(editor.use.foreColor === true){
			editor.hideBoxes();
			editor.msieSelection();
			container.open({
				header: 'لون النص',
				body: DM.colorPicker.panel('ForeColor'),
				buttons: [
					{
						value: 'إدخال',
						color: 'dark',
						click: function(){
							editor.setCommand('ForeColor', null, DM.colorPicker.getColor('ForeColor'), 2);
						}
					},
					{
						value: 'إلغاء الأمر',
						click: function(){
							container.close();
						}
					}
				]
			});
		}
	},
	doBackColor: function(){
		var editor = this, container = DM.container;
		if(editor.use.backColor === true){
			editor.hideBoxes();
			editor.msieSelection();
			container.open({
				header: 'لون خلفية النص',
				body: DM.colorPicker.panel('BackColor'),
				buttons: [
					{
						value: 'إدخال',
						color: 'dark',
						click: function(){
							editor.setCommand('BackColor', null, DM.colorPicker.getColor('BackColor'), 2);
						}
					},
					{
						value: 'إلغاء الأمر',
						click: function(){
							container.close();
						}
					}
				]
			});
		}
	},
	doInsertSymbol: function(){
		var editor = this;
		if(editor.use.symbol === true){
			editor.hideBoxes();
			editor.msieSelection();
			var symbols = [
				["&quot;", "&amp;", "&lt;", "&gt;", "&euro;", "&iexcl;", "&cent;", "&pound;", "&curren;", "&yen;"],
				["&brvbar;", "&sect;", "&uml;", "&copy;", "&ordf;", "&laquo;", "&not;", "&shy;", "&reg;", "&macr;"],
				["&deg;", "&plusmn;", "&sup2;", "&sup3;", "&acute;", "&micro;", "&para;", "&middot;", "&cedil;", "&sup1;"],
				["&ordm;", "&raquo;", "&frac14;", "&frac12;", "&frac34;", "&iquest;", "&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;"],
				["&Auml;", "&Aring;", "&AElig;", "&Ccedil;", "&Egrave;", "&Eacute;", "&otilde;", "&Euml;", "&Igrave;", "&Iacute;"],
				["&Icirc;", "&ouml;", "&ETH;", "&Ntilde;", "&Ograve;", "&Oacute;", "&ntilde;", "&Otilde;", "&Ouml;", "&times;"],
				["&Oslash;", "&Ugrave;", "&Uacute;", "&ograve;", "&Uuml;", "&Yacute;", "&THORN;", "&szlig;", "&agrave;", "&aacute;"],
				["&acirc;", "&atilde;", "&auml;", "&aring;", "&aelig;", "&eth;", "&egrave;", "&eacute;", "&oacute;", "&euml;"],
				["&#202;", "&#206;", "&#212;", "&#219;", "&#350;", "&#1194;", "&yuml;", "&thorn;", "&yacute;", "&uuml;"],
				["&#234;", "&#238;", "&#244;", "&#251;", "&#351;", "&#1195;", "&divide;", "&oslash;", "&ugrave;", "&uacute;"],
				["&#1700;", "&#1742;", "&#1740;", "&#1734;", "&#1688;", "&#1711;", "&#1717;", "&#1607;&#173;", "&#1662;", "&#1670;"]
			];
			var text = ''+
			'<table cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border:#a9a9a9 1px solid;">';
			$.each(symbols, function(i, v){
				text += '<tr>';
				$.each(v, function(i, v){
					text += '<td align="center" onclick="DMEditor.inserSymbolClick(this);" onmouseover="this.style.border=\'#a9a9a9 1px solid\';" onmouseout=\"this.style.border=\'#f0f4fb 1px solid\';" style="border:#f0f4fb 1px solid;padding:2px 5px;font:normal 12px tahoma,arial;cursor:pointer;">'+v+'</td>';
				});
				text += '</tr>';
			});
			text += '</table>';
			editor.inserSymbolClick = function(sel){
				editor.focus();
				editor.pasteHTML('&#'+$(sel).text().charCodeAt(0)+';');
				editor.hideBoxes();
			};
			DM.container.open({
				header: 'ادخل شعار',
				body: text,
				padding: '6px'
			});
		}
	},
	doLink: {
		link: null,
		mode: 'create',
		open: function(){
			var editor = DMEditor, doLink = editor.doLink, container = DM.container;
			if(editor.use.link === true){
				editor.hideBoxes();
				editor.msieSelection();
				var el = editor.getSelectedElement(),
				tagName = (el) ? el.tagName.toLowerCase() :  '',
				link = (el && tagName == 'a') ? el : false,
				parent = false,
				obj = {},
				hasSelection = editor.hasSelection(),
				rand = editor.rand,
				text = '';
				doLink.mode = (link) ? 'update' : 'create';
				doLink.link = (link) ? link : null;
				if(tagName != 'body'){
					if(el){
						parent = $(el).parent().get(0);
					}
				}
				else{
					parent = el;
				}
				obj.protocol = (link) ? '' : 'http://';
				obj.href = (link) ? link.href : '';
				obj.text = '';
				obj.title = (link) ? link.title : '';
				obj.name = (link) ? link.name : '';
				text = '<table cellspacing="2" cellpadding="2">'+
				'<tr><td class="DMTitle"><nobr>الرابط</nobr></td><td class="DMText" dir="ltr"><nobr><select class="DMSelect" id="linkProtocol'+rand+'" style="width:70px;"></select>&nbsp;<input type="text" class="DMInput" id="linkHref'+rand+'" style="width:300px;"></nobr></td></tr>'+
				'<tr id="linkTextRow'+rand+'"><td class="DMTitle"><nobr>نص رابط</nobr></td><td class="DMText"><input type="text" class="DMInput" id="linkText'+rand+'" style="width:373px;"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>شرح رابط</nobr></td><td class="DMText"><input type="text" class="DMInput" id="linkTitle'+rand+'" style="width:373px;"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>اسم رابط</nobr></td><td class="DMText"><input type="text" class="DMInput" id="linkName'+rand+'" style="width:373px;" dir="ltr"></td></tr>'+
				'</table>';
				container.open({
					header: 'إنشاء او تعديل رابط',
					body: text,
					padding: '10px',
					buttons: [
						{
							value: (doLink.mode == 'update' ? 'تعديل رابط' : 'إنشاء رابط'),
							color: 'dark',
							click: function(){
 								var obj = {
									protocol: $('#linkProtocol'+rand).val(),
									href: $('#linkHref'+rand).val(),
									text: $('#linkText'+rand).val(),
									title: $('#linkTitle'+rand).val(),
									name: $('#linkName'+rand).val()
								};
								if(doLink.mode == 'update'){
									doLink.update(obj);
								}
								else{
									doLink.create(obj);
								}
								container.close();
							}
						},
						{
							value: 'إلغاء الأمر',
							click: function(){
								container.close();
							}
						}
					]
				});
				if(doLink.mode == 'update' || hasSelection && $(parent).html() != ''){
					$('#linkTextRow'+rand).hide();
				}
				$('#linkHref'+rand).val(obj.href);
				$('#linkTitle'+rand).val(obj.title);
				$('#linkName'+rand).val(obj.name);
				var protocol = $I('#linkProtocol'+rand), protocols = ['http://', 'https://', 'ftp://', 'mailto:'];
				while(protocol.length > 0){
					protocol.remove(0);
				}
				protocol.options[0] = new Option('', '');
				$.each(protocols, function(i, v){
					protocol.options[i+1] = new Option(v, v);
					if(obj.protocol == v){
						protocol.options.selectedIndex = i+1;
					}
				});
				container.dimension();
			}
		},
		create: function(obj){
			var editor = DMEditor;
			if(obj && $T(obj.href) != 'undefined'){
				var tempUrl = 'http://dm.duhoktimes.com/temp-link.php', link,
				protocol = ($T(obj.protocol) == 'string') ? obj.protocol : '',
				text = ($T(obj.text) == 'string') ? obj.text : '',
				setValue = function(link, obj, name){
					var value = obj[name], type = $T(value);
					if(type == 'string' && value != ''){
						$(link).attr(name, value);
					}
				};
				if(text == ''){
					editor.setCommand('createlink', null, tempUrl, 2);
				}
				else{
					editor.focus();
					editor.pasteHTML('<a href="'+tempUrl+'">'+text+'</a>');
				}
				var links = editor.getDoc().getElementsByTagName('a');
				$.each(links, function(i, v){
					if(v.href == tempUrl){
						link = v;
						return false;
					}
				});
				$(link).attr('href', protocol+obj.href);
				setValue(link, obj, 'title');
				setValue(link, obj, 'name');
			}
		},
		update: function(obj){
			if(this.link && obj && $T(obj.href) == 'string'){
				var link = this.link, protocol = ($T(obj.protocol) == 'string') ? obj.protocol : '',
				setValue = function(link, obj, name){
					var value = obj[name], type = $T(value);
					$(link).removeAttr(name);
					if(type == 'string' && value != ''){
						$(link).attr(name, value);
					}
				};
				$(link).attr('href', protocol+obj.href);
				setValue(link, obj, 'title');
				setValue(link, obj, 'name');
			}	
		}
	},
	doImage: {
		image: null,
		mode: 'insert',
		open: function(){
			var editor = DMEditor, doImage = editor.doImage, container = DM.container;
			if(editor.use.image === true){
				editor.hideBoxes();
				editor.msieSelection();
				var el = editor.getSelectedElement(),
				image = (el && el.tagName.toLowerCase() == 'img' ? el : false),
				rand = editor.rand,
				text = '',
				obj = {
					src: 'http://',
					alt: '',
					align: '',
					border: '',
					width: '',
					height: '',
					hspace: '',
					vspace: ''	
				};
				doImage.mode = (image) ? 'update' : 'insert';
				doImage.image = (image) ? image : null;
				DM.extend(obj, image, false);
				text = '<table cellspacing="2" cellpadding="2">'+
				'<tr><td class="DMTitle"><nobr>مصدر الصورة</nobr></td><td class="DMText" colspan="3"><input type="text" class="DMInput" id="imageSrc'+rand+'" style="width:320px;" dir="ltr"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>شرح الصورة</nobr></td><td class="DMText" colspan="3"><input type="text" class="DMInput" id="imageAlt'+rand+'" style="width:320px;"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>وضع الصورة</nobr></td><td class="DMText"><select class="DMSelect" id="imageAlign'+rand+'" style="width:110px;"></select></nobr></td><td class="DMTitle"><nobr>حاشية الصورة</nobr></td><td class="DMText"><input type="text" class="DMInput" id="imageBorder'+rand+'" style="width:90px;text-align:center;" dir="ltr"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>عرض الصورة</nobr></td><td class="DMText"><input type="text" class="DMInput" id="imageWidth'+rand+'" style="width:100px;text-align:center;" dir="ltr"></td><td class="DMTitle"><nobr>تمديد المساحة أفقيا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="imageHSpace'+rand+'" style="width:90px;text-align:center;" dir="ltr"></td></tr>'+
				'<tr><td class="DMTitle"><nobr>إرتفاع الصورة</nobr></td><td class="DMText"><input type="text" class="DMInput" id="imageHeight'+rand+'" style="width:100px;text-align:center;" dir="ltr"></td><td class="DMTitle"><nobr>تمديد المساحة عموديا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="imageVSpace'+rand+'" style="width:90px;text-align:center;" dir="ltr"></td></tr>'+
				'</table>';
				container.open({
					header: 'ادخل او تعديل صورة',
					body: text,
					padding: '10px',
					buttons: [
						{
							value: (doImage.mode == 'update' ? 'غيّر الصورة الحالية' : 'أدخل الصورة'),
							color: 'dark',
							click: function(){
 								var obj = {
									src: $('#imageSrc'+rand).val(),
									alt: $('#imageAlt'+rand).val(),
									align: $('#imageAlign'+rand).val(),
									border: $('#imageBorder'+rand).val(),
									width: $('#imageWidth'+rand).val(),
									height: $('#imageHeight'+rand).val(),
									hspace: $('#imageHSpace'+rand).val(),
									vspace: $('#imageVSpace'+rand).val()
								};
								if(doImage.mode == 'update'){
									doImage.update(obj);
								}
								else{
									doImage.insert(obj);
								}
								container.close();
							}
						},
						{
							value: 'إلغاء الأمر',
							click: function(){
								container.close();
							}
						}
					]
				});
				$('#imageSrc'+rand).val(obj.src);
				$('#imageAlt'+rand).val(obj.alt);
				$('#imageBorder'+rand).val(obj.border);
				$('#imageWidth'+rand).val(obj.width);
				$('#imageHeight'+rand).val(obj.height);
				$('#imageHSpace'+rand).val(obj.hspace);
				$('#imageVSpace'+rand).val(obj.vspace);
				var align = $I('#imageAlign'+rand), aligns = [['absBottom', 'أقصى الأسفل'], ['absMiddle', 'وسط دقيق'], ['baseline', 'خط النص'], ['bottom', 'أسفل'], ['left', 'يسار'], ['middle', 'وسط'], ['right', 'يمين'], ['textTop', 'أعلى النص'], ['top', 'أقصى الأعلى']];
				while(align.length > 0){
					align.remove(0);
				}
				align.options[0] = new Option('غير محدد', '');
				$.each(aligns, function(i, v){
					align.options[i+1] = new Option(v[1], v[0]);
					if(obj.align == v[0]){
						align.options.selectedIndex = i+1;
					}
				});
			}
		},
		insert: function(obj){
			var editor = DMEditor;
			if(obj && $T(obj.src) != 'undefined'){
				var tempUrl = 'http://dm.duhoktimes.com/temp-image.gif', image,
				setValue = function(image, obj, name){
					var value = obj[name], type = $T(value);
					if(type == 'string' && value != '' || type == 'number' && value > 0){
						$(image).attr(name, value);
					}
				};
				editor.setCommand('insertimage', null, tempUrl, 2);
				var images = editor.getDoc().getElementsByTagName('img');
				$.each(images, function(i, v){
					if(v.src == tempUrl){
						image = v;
						return false;
					}
				});
				image.src = obj.src;
				setValue(image, obj, 'alt');
				setValue(image, obj, 'align');
				setValue(image, obj, 'border');
				setValue(image, obj, 'width');
				setValue(image, obj, 'height');
				setValue(image, obj, 'hspace');
				setValue(image, obj, 'vspace');
			}
		},
		update: function(obj){
			var image = this.image;
			if(obj && image){
				var setValue = function(image, obj, name){
					var value = obj[name], type = $T(value);
					$(image).removeAttr(name);
					if(type == 'string' && value != '' && value != '0'){
						$(image).attr(name, value);
						if(name == 'width' || name == 'height'){
							$(image).css(name, value+'px');
						}
					}
				};
				setValue(image, obj, 'src');
				setValue(image, obj, 'alt');
				setValue(image, obj, 'align');
				setValue(image, obj, 'border');
				setValue(image, obj, 'width');
				setValue(image, obj, 'height');
				setValue(image, obj, 'hspace');
				setValue(image, obj, 'vspace');
			}
		}
	},
	userStyle: {
		style: {},
		align: [['right', 'يمين'], ['center', 'وسط'], ['left', 'يسار']],
		weight: [['normal', 'خفيف'], ['bold', 'ثقيل']],
		size: [],
		fonts: [],
		open: function(){
			var editor = DMEditor, userStyle = editor.userStyle, container = DM.container;
			if(editor.use.userStyle === true){
				editor.hideBoxes();
				var setting = editor.setting, userCSS = setting.userCSS, rand = editor.rand, text ='',
				checkSel = function(name, arr, sel){
					var el = $I('#style'+name+rand), value = '', text = '';
					while(el.length > 0){
						el.remove(0);
					}
					$.each(arr, function(i, v){
						if($T(v) == 'array'){
							value = v[0];
							text = v[1];
						}
						else{
							value = (name == 'Size') ? v+'px' : v;
							text = v;
						}
						el.options[i] = new Option(text, value);
						if(value == sel){
							el.options.selectedIndex = i;
						}
					});
					return sel;
				},
				getColor = function(){
					userStyle.changeStyle('color', this.color);
				};
				this.size = editor.sizes;
				this.fonts = editor.fonts;
				text = '<table cellspacing="2" cellpadding="2">'+
				'<tr><td id="previewStyle'+rand+'" class="DMText" style="'+editor.userCSSText+'padding:10px 4px;" colspan="2"><nobr>'+setting.previewText+'</nobr></td></tr>'+
				'<tr><td class="DMTitle"><nobr>اتجاه النص</nobr></td><td class="DMText"><select class="DMSelect" id="styleAlign'+rand+'" style="width:100px;" onchange="DMEditor.userStyle.changeStyle(\'textAlign\', $(this).val());"></select></td></tr>'+
				'<tr><td class="DMTitle"><nobr>وزن الخط</nobr></td><td class="DMText"><select class="DMSelect" id="styleWeight'+rand+'" style="width:100px;" onchange="DMEditor.userStyle.changeStyle(\'fontWeight\', $(this).val());"></select></td></tr>'+
				'<tr><td class="DMTitle"><nobr>نمط الخط</nobr></td><td class="DMText"><select class="DMSelect" id="styleFamily'+rand+'" style="width:100px;" onchange="DMEditor.userStyle.changeStyle(\'fontFamily\', $(this).val());"></select></td></tr>'+
				'<tr><td class="DMTitle"><nobr>حجم النص</nobr></td><td class="DMText"><select class="DMSelect" id="styleSize'+rand+'" style="width:100px;" onchange="DMEditor.userStyle.changeStyle(\'fontSize\', $(this).val());"></select></td></tr>'+
				'<tr><td class="DMTitle"><nobr>لون النص</nobr></td><td class="DMText">'+DM.colorPicker.panel('userStyle', {color: userCSS.color, click: getColor})+'</td></tr>'+
				'</table>';
				container.open({
					header: 'تغيير نمط النصوص',
					body: text,
					footer: '<div id="styleSavePlace'+rand+'"></div>',
					padding: '2px',
					buttons: [
						{
							name: 'save',
							disabled: true,
							value: 'حفظ تغييرات',
							color: 'dark',
							click: function(){
								userStyle.saveChanges();
							}
						},
						{
							value: 'إغلاق',
							click: function(){
								container.close();
							}
						}
					]
				});
				checkSel('Align', this.align, userCSS.textAlign);
				checkSel('Weight', this.weight, userCSS.fontWeight);
				checkSel('Family', this.fonts, userCSS.fontFamily);
				checkSel('Size', this.size, userCSS.fontSize);
				DM.extend(this.style, userCSS);
			}
		},
		changeStyle: function(name, value){
			var container = DM.container
			$('#previewStyle'+DMEditor.rand).css(name, value);
			this.style[name] = value;
			$(container.buttons.save).attr({'disabled': false, 'class': 'dark'});
			container.dimension();
		},
		saveChanges: function(){
			var editor = DMEditor, statusBar = $I('#styleSavePlace'+editor.rand), style = this.style, img = editor.img,
			errorText = '<img src="'+img.error+'" width="14" height="14"> حدث خطأ أثناء حفظ تغييرات.';
			$(statusBar).html('<img src="'+img.progress+'" width="16" height="16"> أنتظر ليتم حفظ تغييرات ...');
 			$.ajax({
				type: 'POST',
				url: editor.setting.ajaxFile,
				data: 'type=set_user_style&align='+style.textAlign+'&weight='+style.fontWeight+'&family='+style.fontFamily+'&size='+style.fontSize+'&color='+style.color,
				success: function(res){
					var res = parseInt(res);
					if(res == 1){
						$(statusBar).html('<img src="'+img.success+'" width="14" height="14"> تم حفظ تغييرات بنجاح.');
						$(DM.container.buttons.save).attr({'disabled': true, 'class': 'light'});
						editor.setUserCSS(style);
						editor.setCSSText('WYSI');
					}
					else{
						$(statusBar).html(errorText);
					}
				},
				error: function(){
					$(statusBar).html(errorText);
				}
			});
		}
	},
	doPHPCode: {
		open: function(){
			var editor = DMEditor, container = DM.container;
			if(editor.use.phpCode === true){
				editor.hideBoxes();
				editor.msieSelection();
				var rand = editor.rand,
				text = '<div id="phpCodeBox'+rand+'" class="DMEditorPHPCode" contentEditable="true" dir="ltr"></div>';
				container.open({
					header: 'ادخل شيفرة PHP',
					body: text,
					footer: '<div id="phpCodePlace'+rand+'"></div>',
					padding: '6px',
					buttons: [
						{
							name: 'enter',
							value: 'ادخل شيفرة',
							color: 'dark',
							click: function(){
								editor.doPHPCode.process();
							}
						},
						{
							value: 'إلغاء الأمر',
							click: function(){
								container.close();
							}
						}
					]
				});
				$('#phpCodeBox'+rand).focus();
			}
		},
		process: function(){
			var editor = DMEditor, container = DM.container, img = editor.img, statusBar = $I('#phpCodePlace'+editor.rand),
			button = container.buttons.enter,
			box = $I('#phpCodeBox'+editor.rand),
			code = (ie8) ? box.innerText : $(box).text(),
			errorText = '<img src="'+img.error+'" width="14" height="14"> حدث خطأ أثناء معالجة شيفرة.';
			$(statusBar).html('<img src="'+img.progress+'" width="16" height="16">');
			$(button).attr({'disabled': true, 'class': 'light'});
 			$.ajax({
				type: 'POST',
				url: editor.setting.ajaxFile,
				data: 'type=process_phpcode&code='+encodeURIComponent(code),
				success: function(res){
					var arr = res.split('@@DM@@'), error = (arr.length == 3) ? false : true;
					if(!error){
						editor.focus();
						editor.pasteHTML(arr[1]);
						container.close();
					}
					else{
						$(button).attr({'disabled': false, 'class': 'dark'});
						$(statusBar).html(errorText);
					}
				},
				error: function(){
					$(button).attr({'disabled': false, 'class': 'dark'});
					$(statusBar).html(errorText);
				}
			});
		}
	},
	doTable: {
		menus: {
			mode: 1
		},
		body: null,
		parentElement : '',
		parentElementTag : '',
		open: function(){
			var editor = DMEditor, container = DM.container, doTable = editor.doTable;
			if(editor.use.table === true){
				editor.hideBoxes();
				editor.msieSelection();
				var rand = editor.rand,
				parentElement = editor.getSelectedElement(),
				parentElementTag = (parentElement) ? parentElement.tagName.toLowerCase() :  'body',
				text = '';
				text += '<table width="540" cellspacing="0" cellpadding="3" bgcolor="#f4f4f4">'+
				'<tr>'+
				'<td id="tableMenu1'+rand+'" class="DMEditorTableMenu">جدول جديد</td>'+
				'<td id="tableMenu2'+rand+'" class="DMEditorTableMenu">تعديل خصائص الجدول</td>'+
				'<td id="tableMenu3'+rand+'" class="DMEditorTableMenu">تعديل خصائص الخلية</td>'+
				'</tr>'+
				'<tr><td id="tableBody'+rand+'" class="DMEditorTableBody" colspan="3"></td></tr>'+
				'</table>';
				container.open({
					header: 'الجدول',
					body: text,
					footer: '<div id="tablePlace'+rand+'"></div>',
					padding: '6px',
					buttons: [
						{
							name: 'newTable',
							value: 'أضف جدول',
							color: 'dark',
							hide: true,
							click: function(){
								doTable.doNewTable();
							}
						},
						{
							name: 'editTable',
							value: 'تعديل جدول',
							color: 'dark',
							hide: true,
							click: function(){
								doTable.doEditTable();
							}
						},
						{
							name: 'editCell',
							value: 'تعديل خلية',
							color: 'dark',
							hide: true,
							click: function(){
								doTable.doEditCell();
							}
						},
						{
							value: 'إلغاء الأمر',
							click: function(){
								container.close();
							}
						}
					]
				});
				doTable.body = $I('#tableBody'+rand);
				doTable.parentElement = parentElement;
				doTable.parentElementTag = parentElementTag;
				doTable.checkMenus();
			}
		},
		checkMenus: function(){
			var editor = DMEditor, doTable = editor.doTable, rand = editor.rand, menus = doTable.menus,
			edit = (doTable.parentElementTag == 'td') ? true : false;
			menus.newTable = $I('#tableMenu1'+rand);
			menus.editTable = $I('#tableMenu2'+rand);
			menus.editCell = $I('#tableMenu3'+rand);
			menus.mode = (edit) ? 3 : 1;
			$(menus.newTable).click(function(){
				doTable.newTable();
			});
			if(edit){
				$(menus.editTable).click(function(){
					doTable.editTable();
				});
				$(menus.editCell).click(function(){
					doTable.editCell();
				});
				doTable.editCell();
			}
			else{
				doTable.newTable();
			}
		},
		checkMenusDesign: function(){
			var editor = DMEditor, doTable = editor.doTable, menus = doTable.menus, mode = menus.mode,
			align = editor.setting.align,
			edit = (doTable.parentElementTag == 'td') ? true : false,
			active = '1px 1px 0',
			right = '1px 1px 1px 0',
			left = '1px 0 1px 1px';
			$(menus.newTable).css({
				'background-color': (mode == 1) ? '#f4f4f4' : '#ddd',
				'border-width': (mode == 1) ? active : (align == 'right' ? right : left)
			});
			$(menus.editTable).css({
				'background-color': (mode == 2) ? '#f4f4f4' : '#ddd',
				'border-width': (mode == 2) ? active : (align == 'right' ? (mode == 1 ? left : right) : (mode == 1 ? right : left)),
				'color': (edit) ? '#000' : '#888'
			});
			$(menus.editCell).css({
				'background-color': (mode == 3) ? '#f4f4f4' : '#ddd',
				'border-width': (mode == 3) ? active : (align == 'right' ? left : right),
				'color': (edit) ? '#000' : '#888'
			});
			doTable.checkButtons();
			DM.container.dimension();
		},
		checkButtons: function(){
			var mode = this.menus.mode, button = DM.container.buttons;
			if(mode == 2){
				$(button.newTable).hide();
				$(button.editTable).show();
				$(button.editCell).hide();
			}
			else if(mode == 3){
				$(button.newTable).hide();
				$(button.editTable).hide();
				$(button.editCell).show();
			}
			else{
				$(button.newTable).show();
				$(button.editTable).hide();
				$(button.editCell).hide();
			}
		},
		newTable: function(){
			var editor = DMEditor, doTable = editor.doTable, colorPicker = DM.colorPicker, rand = editor.rand, text = '';
			doTable.menus.mode = 1;
			text = '<table width="100%" cellspacing="2" cellpadding="2"><tr>'+
			'<td class="DMTitle"><nobr>عدد الأسطر</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableRows'+rand+'" style="width:50px;text-align:center;" value="2" dir="ltr"></td>'+
			'<td class="DMTitle"><nobr>عدد الأعمدة</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableCols'+rand+'" style="width:50px;text-align:center;" value="2" dir="ltr"></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>العرض</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableWidth'+rand+'" style="width:30px;text-align:center;" dir="ltr"><select class="DMSelect" id="tableWidthType'+rand+'"><option value="pixel">نقطة</option><option value="percent">نسبة مئوية</option></select></td>'+
			'<td class="DMTitle"><nobr>الارتفاع</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableHeight'+rand+'" style="width:30px;text-align:center;" dir="ltr"><select class="DMSelect" id="tableHeightType'+rand+'"><option value="pixel">نقطة</option><option value="percent">نسبة مئوية</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>لون الخلفية</nobr></td><td class="DMText" colspan="3">'+colorPicker.panel('tableBackground', {blank: true})+'</td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>عنوان صورة الخلفية للجدول</nobr></td><td class="DMText" colspan="3"><input type="text" class="DMInput" id="tableBGImage'+rand+'" style="width:300px;" dir="ltr"></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>حجم الحاشية</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableBorder'+rand+'" style="width:50px;text-align:center;" value="1" dir="ltr"></td>'+
			'<td class="DMTitle"><nobr>تنسيق افقي</nobr></td><td class="DMText"><select class="DMSelect" id="tableAlign'+rand+'"><option value=""></option><option value="left">يسار</option><option value="center">وسط</option><option value="right">يمين</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>لون الحاشية</nobr></td><td class="DMText" colspan="3">'+colorPicker.panel('tableBorder', {blank: true})+'</td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>إضافة لحجم الخلايا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tablePadding'+rand+'" style="width:50px;text-align:center;" value="0" dir="ltr"></td>'+
			'<td class="DMTitle"><nobr>المسافة بين الخلايا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableSpacing'+rand+'" style="width:50px;text-align:center;" value="0" dir="ltr"></td>'+
			'</tr></table>';
			$(doTable.body).html(text);
			doTable.checkMenusDesign();
		},
		doNewTable: function(){
			var editor = DMEditor, doTable = editor.doTable, colorPicker = DM.colorPicker, rand = editor.rand,
			rows = parseInt($('#tableRows'+rand).val()),
			cols = parseInt($('#tableCols'+rand).val()),
			width = parseInt($('#tableWidth'+rand).val()),
			height = parseInt($('#tableHeight'+rand).val()),
			widthType = $('#tableWidthType'+rand).val(),
			heightType = $('#tableHeightType'+rand).val(),
			bgColor = colorPicker.getColor('tableBackground'),
			bgImage = $('#tableBGImage'+rand).val(),
			border = parseInt($('#tableBorder'+rand).val()),
			align = $('#tableAlign'+rand).val(),
			borderColor = colorPicker.getColor('tableBorder'),
			padding = parseInt($('#tablePadding'+rand).val()),
			spacing = parseInt($('#tableSpacing'+rand).val()),
			text = '';
			rows = (isNaN(rows)) ? 2 : rows;
			cols = (isNaN(cols)) ? 2 : cols;
			width = (isNaN(width) || width == 0) ? '' : ' width="'+width+doTable.percent(widthType)+'"';
			height = (isNaN(height) || height == 0) ? '' : ' height="'+height+doTable.percent(heightType)+'"';
			bgColor = (bgColor == '') ? '' : ' bgcolor="'+bgColor+'"';
			bgImage = (bgImage == '') ? '' : ' background="'+bgImage+'"';
			border = (isNaN(border) || border == 0) ? '' : ' border="'+border+'"';
			align = (align == '') ? '' : ' align="'+align+'"';
			borderColor = (borderColor == '') ? '' : ' bordercolor="'+borderColor+'"';
			padding = (isNaN(padding)) ? '' : ' cellpadding="'+padding+'"';
			spacing = (isNaN(spacing)) ? '' : ' cellspacing="'+spacing+'"';
			text += '<table'+width+height+bgColor+bgImage+border+align+borderColor+padding+spacing+'>';
			for(var x = 0; x < rows; x++){
				text += '<tr>';
				for(var i = 0; i < cols; i++){
					text += '<td>&nbsp;</td>';
				}
				text += '</tr>';
			}
			text += '</table>';
			editor.focus();
			editor.pasteHTML(text);
			DM.container.close();
		},
		editTable: function(){
			var editor = DMEditor, doTable = editor.doTable, colorPicker = DM.colorPicker, choose = DM.choose, rand = editor.rand,
			table = $(doTable.parentElement).parents('table').get(0),
 			width = $(table).attr('width') || '',
			height = $(table).attr('height') || '',
			widthType = 'pixel',
			heightType = 'pixel',
			bgColor = $(table).attr('bgcolor') || '',
			bgImage = $(table).attr('background') || '',
			border = $(table).attr('border') || '',
			align = $(table).attr('align') || '',
			borderColor = $(table).attr('bordercolor') || '',
			padding = $(table).attr('cellPadding') || '',
			spacing = $(table).attr('cellSpacing') || '',
			text = '';
			doTable.menus.mode = 2;
			if(width.indexOf('%') >= 0){
				width = width.substr(0, width.length-1);
				widthType = 'percent';
			}
			if(height.indexOf('%') >= 0){
				height = height.substr(0, height.length-1);
				heightType = 'percent';
			}
			text = '<table width="100%" cellspacing="2" cellpadding="2"><tr>'+
			'<td class="DMTitle"><nobr>العرض</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableWidth'+rand+'" style="width:30px;text-align:center;" value="'+width+'" dir="ltr"><select class="DMSelect" id="tableWidthType'+rand+'"><option value="pixel">نقطة</option><option value="percent"'+choose('percent', widthType)+'>نسبة مئوية</option></select></td>'+
			'<td class="DMTitle"><nobr>الارتفاع</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableHeight'+rand+'" style="width:30px;text-align:center;" value="'+height+'" dir="ltr"><select class="DMSelect" id="tableHeightType'+rand+'"><option value="pixel">نقطة</option><option value="percent"'+choose('percent', heightType)+'>نسبة مئوية</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>لون الخلفية</nobr></td><td class="DMText" colspan="3">'+colorPicker.panel('tableBackground', {blank: true, color: bgColor})+'</td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>عنوان صورة الخلفية للجدول</nobr></td><td class="DMText" colspan="3"><input type="text" class="DMInput" id="tableBGImage'+rand+'" style="width:300px;" value="'+bgImage+'" dir="ltr"></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>حجم الحاشية</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableBorder'+rand+'" style="width:50px;text-align:center;" value="'+border+'" dir="ltr"></td>'+
			'<td class="DMTitle"><nobr>تنسيق افقي</nobr></td><td class="DMText"><select class="DMSelect" id="tableAlign'+rand+'"><option value=""></option><option value="left"'+choose('left', align)+'>يسار</option><option value="center"'+choose('center', align)+'>وسط</option><option value="right"'+choose('right', align)+'>يمين</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>لون الحاشية</nobr></td><td class="DMText" colspan="3">'+colorPicker.panel('tableBorder', {blank: true, color: borderColor})+'</td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>إضافة لحجم الخلايا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tablePadding'+rand+'" style="width:50px;text-align:center;" value="'+padding+'" dir="ltr"></td>'+
			'<td class="DMTitle"><nobr>المسافة بين الخلايا</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tableSpacing'+rand+'" style="width:50px;text-align:center;" value="'+spacing+'" dir="ltr"></td>'+
			'</tr></table>';
			$(doTable.body).html(text);
			doTable.checkMenusDesign();
		},
		doEditTable: function(){
			var editor = DMEditor, doTable = editor.doTable, colorPicker = DM.colorPicker, rand = editor.rand,
			table = $(doTable.parentElement).parents('table').get(0),
			width = parseInt($('#tableWidth'+rand).val()),
			height = parseInt($('#tableHeight'+rand).val()),
			widthType = $('#tableWidthType'+rand).val(),
			heightType = $('#tableHeightType'+rand).val(),
			bgColor = colorPicker.getColor('tableBackground'),
			bgImage = $('#tableBGImage'+rand).val(),
			border = parseInt($('#tableBorder'+rand).val()),
			align = $('#tableAlign'+rand).val(),
			borderColor = colorPicker.getColor('tableBorder'),
			padding = parseInt($('#tablePadding'+rand).val()),
			spacing = parseInt($('#tableSpacing'+rand).val()),
			style = $(table).attr('style'),
			checkAttr = function(name, operator, value){
				if(operator){
					$(table).removeAttr(name);
				}
				else{
					$(table).attr(name, value);
				}
			};
			if($T(style) == 'string' && style != ''){
				var arr = style.split(';'), newStyle = '';
				for(var x = 0; x < arr.length; x++){
					if(arr[x].toLowerCase().indexOf('width') == -1 && arr[x].toLowerCase().indexOf('height') == -1 && arr[x].trim() != ''){
						newStyle += arr[x]+';';
					}
				}
				checkAttr('style', (newStyle == ''), newStyle);
			}
			checkAttr('width', (isNaN(width) || width == 0), width+doTable.percent(widthType));
			checkAttr('height', (isNaN(height) || height == 0), height+doTable.percent(heightType));
			checkAttr('bgcolor', (bgColor == ''), bgColor);
			checkAttr('background', (bgImage == ''), bgImage);
			checkAttr('border', (isNaN(border) || border == 0), border);
			checkAttr('align', (align == ''), align);
			checkAttr('bordercolor', (borderColor == ''), borderColor);
			checkAttr('cellpadding', (isNaN(padding)), padding);
			checkAttr('cellspacing', (isNaN(spacing)), spacing);
			DM.container.close();
		},
		editCell: function(){
			var editor = DMEditor, doTable = editor.doTable, choose = DM.choose, rand = editor.rand,
			td = doTable.parentElement,
 			width = $(td).attr('width') || '',
			height = $(td).attr('height') || '',
			widthType = 'pixel',
			heightType = 'pixel',
			align = $(td).attr('align') || '',
			valign = $(td).attr('valign') || '',
			bgImage = $(td).attr('background') || '',
			bgColor = $(td).attr('bgcolor') || '',
			text = '';
			doTable.menus.mode = 3;
			if(width.indexOf('%') >= 0){
				width = width.substr(0, width.length-1);
				widthType = 'percent';
			}
			if(height.indexOf('%') >= 0){
				height = height.substr(0, height.length-1);
				heightType = 'percent';
			}
			text = '<table width="100%" cellspacing="2" cellpadding="2"><tr>'+
			'<td class="DMTitle"><nobr>عرض الخلية</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tdWidth'+rand+'" style="width:30px;text-align:center;" value="'+width+'" dir="ltr"><select class="DMSelect" id="tdWidthType'+rand+'"><option value="pixel">نقطة</option><option value="percent"'+choose('percent', widthType)+'>نسبة مئوية</option></select></td>'+
			'<td class="DMTitle"><nobr>ارتفاع الخلية</nobr></td><td class="DMText"><input type="text" class="DMInput" id="tdHeight'+rand+'" style="width:30px;text-align:center;" value="'+height+'" dir="ltr"><select class="DMSelect" id="tdHeightType'+rand+'"><option value="pixel">نقطة</option><option value="percent"'+choose('percent', heightType)+'>نسبة مئوية</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>تنسيق افقي للخلية</nobr></td><td class="DMText"><select class="DMSelect" id="tdAlign'+rand+'"><option value=""></option><option value="left"'+choose('left', align)+'>يسار</option><option value="center"'+choose('center', align)+'>وسط</option><option value="right"'+choose('right', align)+'>يمين</option></select></td>'+
			'<td class="DMTitle"><nobr>تنسيق عمودي للخلية</nobr></td><td class="DMText"><select class="DMSelect" id="tdVAlign'+rand+'"><option value=""></option><option value="top"'+choose('top', valign)+'>أعلى</option><option value="middle"'+choose('middle', valign)+'>وسط</option><option value="bottom"'+choose('bottom', valign)+'>أسفل</option></select></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>عنوان صورة الخلفية للخلية</nobr></td><td class="DMText" colspan="3"><input type="text" class="DMInput" id="tdBGImage'+rand+'" style="width:300px;" value="'+bgImage+'" dir="ltr"></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>لون الخلفية للخلية</nobr></td><td class="DMText" colspan="3">'+DM.colorPicker.panel('tdBackground', {blank: true, color: bgColor})+'</td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>أدخل سطر جديد</nobr></td><td class="DMText" colspan="3"><nobr><input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'insertRowAbove\');" value="فوق">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'insertRowBelow\');" value="تحت"></nobr></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>أدخل عمود جديد</nobr></td><td class="DMText" colspan="3"><nobr><input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'insertColLeft\');" value="الى اليسار">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'insertColRight\');" value="الى اليمين"></nobr></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>أحذف</nobr></td><td class="DMText" colspan="3"><nobr><input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'deleteRow\');" value="سطر كامل">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'deleteCol\');" value="عمود كامل">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'deleteCell\');" value="الخلية الحالية"></nobr></td>'+
			'</tr><tr>'+
			'<td class="DMTitle"><nobr>تمديد الخلايا</nobr></td><td class="DMText" colspan="3"><nobr><input type="text" class="DMInput" id="tdSpan'+rand+'" style="width:30px;text-align:center;" value="2" dir="ltr">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'colSpan\');" value="تمديد أفقي">&nbsp;&nbsp;<input type="button" class="DMButton" onclick="DMEditor.doTable.doCell(\'rowSpan\');" value="تمديد عمودي"></nobr></td>'+
			'</tr></table>';
			$(doTable.body).html(text);
			doTable.checkMenusDesign();
		},
		doEditCell: function(){
			var editor = DMEditor, doTable = editor.doTable, rand = editor.rand,
			td = doTable.parentElement,
			width = parseInt($('#tdWidth'+rand).val()),
			height = parseInt($('#tdHeight'+rand).val()),
			widthType = $('#tdWidthType'+rand).val(),
			heightType = $('#tdHeightType'+rand).val(),
			align = $('#tdAlign'+rand).val(),
			valign = $('#tdVAlign'+rand).val(),
			bgImage = $('#tdBGImage'+rand).val(),
			bgColor = DM.colorPicker.getColor('tdBackground'),
			style = $(td).attr('style'),
			checkAttr = function(name, operator, value){
				if(operator){
					$(td).removeAttr(name);
				}
				else{
					$(td).attr(name, value);
				}
			};
			if($T(style) == 'string' && style != ''){
				var arr = style.split(';'), newStyle = '';
				for(var x = 0; x < arr.length; x++){
					if(arr[x].toLowerCase().indexOf('width') == -1 && arr[x].toLowerCase().indexOf('height') == -1 && arr[x].trim() != ''){
						newStyle += arr[x]+';';
					}
				}
				checkAttr('style', (newStyle == ''), newStyle);
			}
			checkAttr('width', (isNaN(width) || width == 0), width+doTable.percent(widthType));
			checkAttr('height', (isNaN(height) || height == 0), height+doTable.percent(heightType));
			checkAttr('align', (align == ''), align);
			checkAttr('valign', (valign == ''), valign);
			checkAttr('background', (bgImage == ''), bgImage);
			checkAttr('bgcolor', (bgColor == ''), bgColor);
			DM.container.close();
		},
		doCell: function(type){
			if($T(type) != 'string'){
				return;
			}
			var editor = DMEditor, doTable = editor.doTable, rand = editor.rand,
			td = doTable.parentElement,
			tr = $(doTable.parentElement).parents('tr').get(0),
			table = $(doTable.parentElement).parents('table').get(0),
			span = parseInt($('#tdSpan'+rand).val()),
			dir = editor.setting.dir,
			cell;
			if(isNaN(span)){
				span = 2;
			}
			if(type == 'insertRowAbove'){
				var row = table.insertRow(tr.rowIndex);
				for(var x = 0; x < tr.cells.length; x++){
					cell = row.insertCell(x);
					$(cell).html('&nbsp;');
				}
			}
			else if(type == 'insertRowBelow'){
				var row = table.insertRow(tr.rowIndex + 1);
				for(var x = 0; x < tr.cells.length; x++){
					cell = row.insertCell(x);
					$(cell).html('&nbsp;');
				}
			}
			else if(type == 'insertColLeft'){
				for(var x = 0; x < table.rows.length; x++){
					cell = table.rows[x].insertCell(dir == 'rtl' ? td.cellIndex + 1 : td.cellIndex);
					$(cell).html('&nbsp;');
				}
			}
			else if(type == 'insertColRight'){
				for(var x = 0; x < table.rows.length; x++){
					cell = table.rows[x].insertCell(dir == 'rtl' ? td.cellIndex : td.cellIndex + 1);
					$(cell).html('&nbsp;');
				}
			}
			else if(type == 'deleteRow'){
				table.deleteRow(tr.rowIndex);
			}
			else if(type == 'deleteCol'){
				var index = td.cellIndex;
				for(var x = 0; x < table.rows.length; x++){
					table.rows[x].deleteCell(index);
				}
			}
			else if(type == 'deleteCell'){
				tr.deleteCell(td.cellIndex);
			}
			else if(type == 'colSpan'){
				$(td).attr('colspan', span);
			}
			else if(type == 'rowSpan'){
				$(td).attr('rowspan', span);
			}
			DM.container.close();
		},
		percent: function(type){
			return ($T(type) == 'string' && type == 'percent') ? '%' : '';
		}
	}
};
var DMEditor = $.DM.editor;
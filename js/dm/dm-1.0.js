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
* DM Library v1.1
* Work with JQuery Library 1.7.1 and later versions
* Copyright 2007 - 2012, Dilovan Matini
*
* Date: Wednesday, ‎December ‎28, 2021
#************************************************/
var DMFolderPath = 'js/dm/'; // The folder path of the DM Library files.
var DM = {
	/**
	* @property version
	* @description The version number of the DM Library.
	* @type String
	*/
	version:'1.1',
	/**
	* @property path
	* @description The folder path of the DM Library files.
	* @type String
	*/
	path: DMFolderPath,
	/**
	* @method type
	* @description Get value type.
	* @param {Any} value
	* @return {String}
	*/
	type: function(value){
		return $.type(value);
	},
	/**
	* @method parseInt
	* @description Convert value to integer.
	* @param {Any} value
	* @return {Number}
	*/
	parseInt: function(value){
		return parseInt(value) || 0;
	},
	/**
	* @method parseFloat
	* @description Convert value to float.
	* @param {Any} value
	* @return {Float}
	*/
	parseFloat: function(value){
		return parseFloat(value) || 0;
	},
	/**
	* @method getElement
	* @description Get element by id or tag name or class name.
	* @param {String} value
	* @param {HTMLElement} context
	* @return {HTMLElement}
	*/
	getElement: function(value, context){
		if(context){
			return $(value, context)[0] || false;
		}
		else{
			return $(value)[0] || false;
		}
	},
	/**
	* @method getSelectedValue
	* @description Get value for select tag.
	* @param {String} OR {HTMLElement} value
	* @return {String}
	*/
	getSelectedValue: function(value){
		return $(value).val();
	},
	/**
	* @method goToURL
	* @description Go to url.
	* @param {String} url
	*/
	goToURL: function(url){
		document.location = url;
	},
	/**
	* @method choose
	* @description Set selected or checked for form elemnts.
	* @param {String} value1
	* @param {String} value2
	* @param {String} type
	* @return {String}
	*/
	choose: function(value1, value2, type){
		var types = ['s', 'c'];
		if($T(type) == 'undefined' || !types.inArray(type)){
			type = 's';
		}
		return (value1 == value2 ? (type == 's' ? ' selected' : ' checked') : '');
	},
	/**
	* @method round
	* @description Create Math function round.
	* @param {Float} number
	* @param {Number} precision
	* @return {Float}
	*/
	round: function(number, precision){
		if(!precision || precision == 0){
			precision = 1;
		}
		var pow, ceil, floor, dc, df;
		pow = Math.pow(10, precision);
		ceil = Math.ceil(number * pow) / pow;
		floor = Math.floor(number * pow) / pow;
		pow = Math.pow(10, precision + 1);
		dc = pow * (ceil - number);
		df = pow * (number - floor) + (number < 0 ? -1 : 1);
		return (dc >= df ? floor : ceil);
	},
	/**
	* @method rand
	* @description Create random.
	* @param {Number} number
	* @return {number}
	*/
	rand: function(number){
		if($T(number) != 'number'){
			number = 999999;
		}
		return Math.floor(Math.random() * number);
	},
	/**
	* @namespace DM
	* @class container
	*/
	container: {
		id: 0,
		obj: {},
		box: false,
		table: false,
		header: false,
		body: false,
		footer: false,
		buttons: {},
		align: '',
		disalign: '',
		defaults: {
			dir: 'rtl',
			body: '',
			footer: '',
			error: false,
			padding: '25px',
			buttons: []
		},
		/**
		* @method setDefaults
		* @description Set conrainer defaults.
		* @param {Object} obj
		* @return {Object} obj
		*/
		setDefaults: function(obj){
			var container = this, defaults = container.defaults,
			check = function(sets, defualt, type){
				if(!type){
					type = 'string';
				}
				return (($T(sets) !== type || type == 'string' && sets == '') ? defualt : sets);
			};
			if(!obj){
				obj = {};
			}
			obj.parent = check(obj.parent, document.body, 'object');
			obj.dir = check(obj.dir, defaults.dir);
			obj.body = check(obj.body, defaults.body);
			obj.footer = check(obj.footer, defaults.footer);
			obj.error = check(obj.error, defaults.error, 'boolean');
			obj.padding = check(obj.padding, defaults.padding);
			obj.buttons = check(obj.buttons, defaults.buttons, 'array');
			container.obj = obj;
			container.align = (obj.dir == 'rtl' ? 'right' : 'left');
			container.disalign = (obj.dir == 'rtl' ? 'left' : 'right');
			return obj;
		},
		/**
		* @method create
		* @description create html for container.
		*/
		create: function(){
			var container = this, getElement = DM.getElement, id = 0;
			if(container.id == 0){
				container.id = id = DM.rand();
				$(container.obj.parent).append('<div id="container'+id+'" class="DMContainer"><table id="table'+id+'" cellpadding="0" cellspacing="1" dir="'+container.obj.dir+'"><tr id="bodyRow'+id+'"><td id="body'+id+'" class="body"></td></tr></table></div>');
				$(container.obj.parent).append('<span id="highlight'+id+'" style="position:absolute;visibility:hidden;top:2px;left:2px;margin:0;padding:0;z-index:1000;background-color:#000;opacity:.50;filter:alpha(opacity=50);"></span>');
				container.box = getElement('#container'+id);
				$(container.box).hide();
				container.table = getElement('#table'+id);
				container.body = getElement('#body'+id);
				$(window).resize(function(){container.dimension();});
				$(window).scroll(function(){container.dimension();});
			}
		},
		/**
		* @method open
		* @description open container, for open container:-
		DM.container.open({
			header: '', // example: title
			body: '', // example: message
			footer: '', // example: other text
			padding: '', // example: 25px
			buttons: [{
				value: '', // example: ok
				click: function(){},
				color: '' // example: light or dark
			}],
			error: true // if the message is have error text, will show text by red color
		});
		* @param {Object} obj
		*/
		open: function(obj){
			var container = this, getDocumentSize = DM.getDocumentSize;
			obj = container.setDefaults(obj);
			container.reset();
			container.create();
			if($T(obj.header) !== 'undefined'){
				container.setHeader(obj.header);
			}
			$(container.body).html((obj.body.toLowerCase().indexOf('nobr') >= 0) ? obj.body : '<nobr>'+obj.body+'</nobr>');
			if(obj.footer != '' || obj.buttons.length > 0){
				container.setFooter(obj.footer, obj.buttons);
			}
			if(obj.error === true){
				$('#highlight'+container.id).css({
					top: '0',
					left: '0',
					width: getDocumentSize('width')+'px',
					height: getDocumentSize('height')+'px',
					visibility: 'visible'
				});
				$(container.body).css({color: '#ff0000'});
			}
			$(container.body).css({padding: obj.padding});
			$(container.box).show();
			//$(container.table).resize(function(){container.dimension();});
			container.dimension();
		},
		/**
		* @method setHeader
		* @description Set conrainer header.
		* @param {String} text
		*/
		setHeader: function(text){
			var container = this;
			var row = container.table.insertRow(0);
			var cell = row.insertCell(0);
			cell.className = 'header';
			$(cell).html('<div class="text"><nobr>&nbsp;'+text+'</nobr></div><img src="'+DM.path+'assets/close.gif" onclick="DM.container.close();" class="close" style="margin-'+container.align+':20px;">');
			container.header = cell;
		},
		/**
		* @method setFooter
		* @description Set conrainer footer.
		* @param {String} text
		* @param {Array} buttons
		*/
		setFooter: function(text, buttons){
			var container = this;
			var row = container.table.insertRow(container.table.rows.length == 1 ? 1 : 2);
			var cell = row.insertCell(0);
			cell.className = 'footer';
			var buttonText = '', buttonId = [], arr = [], colors = ['light', 'dark'], el, color;
			if(buttons.length > 0){
				for(var x = 0; x < buttons.length; x++){
					if($T(buttons[x].value) !== 'string' || buttons[x].value == ''){
						continue;
					}
					color = ($T(buttons[x].color) === 'string' || colors.inArray(buttons[x].color)) ? buttons[x].color : 'light';
					buttonText += '<input type="button" class="'+color+'" id="button'+container.id+x+'" value="'+buttons[x].value+'">';
					arr[arr.length] = {
						id: 'button'+container.id+x,
						name: buttons[x].name || '',
						disabled: buttons[x].disabled || false,
						hide: buttons[x].hide || false,
						click: buttons[x].click || function(){}
					};
				}
			}
			$(cell).html('<table width="100%" cellpadding="0" cellspacing="0"><tr><td class="text"><nobr>'+text+'</nobr></td><td class="buttons" align="'+container.disalign+'" style="margin-'+container.align+':20px;"><nobr>'+buttonText+'</nobr></td></tr></table>');
			for(var x = 0; x < arr.length; x++){
				el = $I('#'+arr[x].id);
				$(el).click(arr[x].click);
				el.disabled = arr[x].disabled;
				if(el.disabled === true){
					el.className = 'light';
				}
				if(arr[x].hide === true){
					$(el).hide();
				}
				if(arr[x].name != ''){
					container.buttons[arr[x].name] = el;
				}
			}
			container.footer = cell;
		},
		/**
		* @method dimension
		* @description setting container position and scale.
		*/
		dimension: function(){
 			var w, h, x, y, ie6 = ($.browser.msie && $.browser.version >= 6 && $.browser.version < 7 ? true : false), align = (ie6 ? 'right' : 'left');
			w = this.table.offsetWidth;
			h = this.table.offsetHeight;
			x = Math.ceil(($(window).width() - w) / 2) + (ie6 ? 0 : $(window).scrollLeft());
			y = Math.ceil(($(window).height() - h) / 2) + $(window).scrollTop();
			var position = {
				top: y+'px',
				width: w+'px',
				height: h+'px'
			};
			eval('position.'+align+' = "'+x+'px";');
			$(this.box).css(position);
		},
		/**
		* @method reset
		* @description reset all conrainer's elements.
		*/
		reset: function(){
			var container = this;
			if(container.id > 0){
				var x = 0, rowId = 'bodyRow'+container.id;
				while(container.table.rows.length > 1){
					if(container.table.rows[x].id != rowId){
						container.table.deleteRow(x);
					}
					else{
						x++;
					}
				}
				$('#highlight'+container.id).css({
					top: '2px',
					left: '2px',
					width: '2px',
					height: '2px',
					visibility: 'hidden'
				});
				$(container.body).css({color: '#000'});
				$(container.body).html('');
			}
		},
		/**
		* @method close
		* @description close container.
		*/
		close: function(){
			var container = this;
			if(container.id > 0){
				$(container.box).hide();
				container.reset();
			}
		}
	},
	/**
	* @method getDocumentSize
	* @description get full width and height for document.
	* @param {String} type
	* @param {Object} obj
	* @return {Number} size
	*/
	getDocumentSize: function(type, obj){
		var size = 0;
		if(!obj){
			obj = window.document;
		}
		var viewPort = {
			width: function(){
				var width = self.innerWidth;
				if(obj.compatMode || $.browser.msie){
					width = (obj.compatMode == 'CSS1Compat') ? obj.documentElement.clientWidth : obj.body.clientWidth;
				}
				return width;
			},
			height: function(){
				var height = self.innerHeight;
				if(obj.compatMode || $.browser.msie){
					height = (obj.compatMode == 'CSS1Compat') ? obj.documentElement.clientHeight : obj.body.clientHeight;
				}
				return height;
			}
		};
		if(type == 'width'){
			var width = (obj.compatMode != 'CSS1Compat') ? obj.body.scrollWidth : obj.documentElement.scrollWidth;
			size = Math.max(width, viewPort.width());
		}
		if(type == 'height'){
			var height = (obj.compatMode != 'CSS1Compat') ? obj.body.scrollHeight : obj.documentElement.scrollHeight;
			size = Math.max(height, viewPort.height());
		}
		return size;
	},
	/**
	* @method extend
	* @description Sets property of "prop" to property of "obj".
	* @param {Object} obj
	* @param {Object} prop
	* @param {Boolean} setProp
	*/
	extend: function(obj, prop, setProp){
		if($T(obj) == 'object' && $T(prop) == 'object'){
			setProp = (setProp === false) ? false : true;
			for(var name in prop){
				if(setProp || $T(obj[name]) != 'undefined'){
					if($T(prop[name]) == 'object'){
						this.extend(obj[name], prop[name]);
					}
					else{
						obj[name] = prop[name];
					}
				}
			}
		}
	},
	/**
	* @namespace DM
	* @class colorPicker
	*/
	colorPicker: {
		name: '',
		tempName: 'DMColor',
		panels: [],
		/**
		* @method panel
		* @description Color picker panel.
		* @param {String} name
		* @param {Object} obj
		* @return {String} this.create();
		*/
		panel: function(name, obj){
			var colorPicker = this;
			if($T(name) != 'string' || name == ''){
				name = colorPicker.tempName;
			}
			colorPicker.name = name;
			colorPicker.rand = DM.rand();
			colorPicker.panels[name] = {
				rand: colorPicker.rand,
				color: '#ffffff',
				click: function(){}
			};
			if(obj){
				var blank = true;
				if($T(obj.color) == 'string' && (/^#([a-fA-F0-9]{6})$/).test(obj.color)){
					colorPicker.panels[name].color = obj.color;
					blank = false;
				}
				if($T(obj.click) == 'function'){
					colorPicker.panels[name].click = obj.click;
				}
				if(blank && $T(obj.blank) == 'boolean' && obj.blank == true){
					colorPicker.panels[name].color = '';
				}
			}
			return colorPicker.create();
		},
		/**
		* @method create
		* @description Create html text for color picker panel.
		* @return {String} text
		*/
		create: function(){
			var colorPicker = this, text = '', name = colorPicker.name,
			color = colorPicker.panels[name].color,
			colors = [[], [], [], [], [], []],
			r = ['00', '33', '66', '99', 'cc', 'ff'],
			c = ['0033', '0066', '0099', '00cc', '00ff', '33ff', '66ff', '99ff', 'ccff', 'ffff', 'ffcc', 'ff99', 'ff66', 'ff33', 'ff00', 'cc00', '9900', '6600', '3300', '0000', ['000000', '333333', '666666', '999999', 'cccccc', 'eeeeee'], ['222222', '555555', '888888', 'bbbbbb', 'dddddd', 'ffffff']];
			for(var x = 0; x < c.length; x++){
				for(var i = 0; i < r.length; i++){
					colors[i][x] = ($T(c[x]) == 'array' ? c[x][i] : r[i]+c[x]+'');
				}
			}
			text += '<table height="55" cellpadding="0" cellspacing="2"><tr><td style="border:#c0c0c0 1px solid;padding:4px;">'+
			'<table width="43" height="43" cellpadding="2" cellspacing="0">'+
			'<tr><td id="colorPreview'+name+colorPicker.rand+'" class="DMColorPickerPreview" style="color:'+colorPicker.codeColor(color)+';background-color:'+color+';" dir="ltr">'+color+'</td></tr>'+
			'</table>'+
			'</td><td>'+
			'<table width="220" cellpadding="0" cellspacing="1" bgcolor="#000000">';
			$.each(colors, function(i, v){
				text += '<tr>';
				$.each(v, function(i, v){
					text += '<td width="8" height="8" onclick="DM.colorPicker.click(this);" style="cursor:pointer;background-color:#'+v+'" panel="'+name+'"></td>';
				});
				text += '</tr>';
			});
			text += '</table>'+
			'</td></tr></table>';
			return text;
		},
		/**
		* @method getColor
		* @description Get choosed color from color picker panel.
		* @param {String} name
		* @return {String} color
		*/
		getColor: function(name){
			if($T(name) != 'string' || name == ''){
				name = this.tempName;
			}
			return this.panels[name].color;
		},
		/**
		* @method click
		* @description When click in on the color box.
		* @param {HTMLElement} sel
		*/
		click: function(sel){
			var colorPicker = this, color = colorPicker.rgb2hex($(sel).css('background-color')), name = $(sel).attr('panel'), rand = colorPicker.panels[name].rand;
			$('#colorPreview'+name+rand).css({'background-color': color, 'color': colorPicker.codeColor(color)});
			$('#colorPreview'+name+rand).html('<nobr>'+color+'</nobr>');
			colorPicker.panels[name].color = color;
			colorPicker.panels[name].click();
		},
		/**
		* @method codeColor
		* @description Get the mirror color of the choosed color.
		* @param {String} color
		* @param {String} color
		*/
		codeColor: function(color){
			var color1 = parseInt(color.substr(1,1)), color2 = parseInt(color.substr(3,1));
			return (isNaN(color1) || isNaN(color2) ? '#000' : '#fff');
		},
		/**
		* @method rgb2hex
		* @description Replace RGB color system to HEX color system.
		* @param {String} color
		* @param {String} color
		*/
		rgb2hex: function(color){
			color = color.replace(/\s/igm, '').toLowerCase();
			if(color.indexOf('rgb(')>=0){
				color = color.replace(/^rgb\((\d*),(\d*),(\d*)\)$/igm, function(a, r, g, b){
					var d2h = function(d){
						var h = (parseInt(d).toString(16));
						if(h.length == 1){
							h = ("0"+h);
						}
						return h.toLowerCase();
					};
					return "#"+d2h(r)+d2h(g)+d2h(b);
				});
			}
			return color;
		}
	},
	/**
	* @method isAncestor
	* @description Get true if target in element.
	* @param {HTMLElement} el
	* @param {HTMLElement} terget
	* @return {Boolean} ret
	*/
	isAncestor: function(el, terget) {
		var ret = false;
		if(el && terget){
			if(el === terget){
				ret = true;
			}
			else{
				if(el.nodeType && terget.nodeType){
					if(el.contains){
						ret = el.contains(terget);
					}
					else if(el.compareDocumentPosition){
						ret = !!(el.compareDocumentPosition(terget) & 16);
					}
				}
			}
		}
		return ret;
	}
};
/**
* @method String.trim
* @description Strip whitespace from the begin and end of string.
* @return {String}
*/
String.prototype.trim = function(){
	return this.replace(/^\s+/, '').replace(/\s+$/, '');
};
/**
* @method String.ltrim
* @description Strip whitespace from the begin of string.
* @return {String}
*/
String.prototype.ltrim = function(){
	return this.replace(/^\s+/, '');
};
/**
* @method String.rtrim
* @description Strip whitespace from the end of string.
* @return {String}
*/
String.prototype.rtrim = function(){
	return this.replace(/\s+$/, '');
};
/**
* @method Array.add
* @description Add items to array.
* @param {Any} arguments[,arguments]
*/
Array.prototype.add = function(){
	var a = arguments;
	if(typeof a == 'object'){
		for(var x = 0;x < a.length; x++){
			this.push(a[x]);
		}
	}
};
/**
* @method Array.clear
* @description Clear or empty array.
*/
Array.prototype.clear = function(){
	this.splice(0, this.length);
};
/**
* @method Array.trash
* @description Delete items value in array.
* @param {String} value
*/
Array.prototype.trash = function(value){
	var i = this.getIndex(value);
	if(i >= 0){
		this.splice(i, 1);
	}
};
/**
* @method Array.inArray
* @description Search value in array.
* @param {String} value
* @return {Boolean}
*/
Array.prototype.inArray=function(value){
	for(var x = 0; x < this.length; x++){
		if(this[x] == value){
			return true;
		}
	}
	return false;
};
/**
* @method Array.getIndex
* @description Get index number in array.
* @param {String} value
* @return {Number}
*/
Array.prototype.getIndex = function(value){
	for(var x = 0; x < this.length; x++){
		if(this[x] == value){
			return x;
		}
	}
	return -1;
};
/**
* @method Array.merge
* @description Merge two or more array in to one array.
* @param {Array} arguments[,arguments]
*/
Array.prototype.merge = function(){
	var a = arguments;
	for(var x = 0; x < a.length; x++){
		if(typeof a[x] == 'object'){
			for(var i = 0; i < a[x].length; i++){
				this.add(a[x][i]);
			}
		}
	}
};
var $I = DM.getElement, $S = DM.getSelectedValue, $T = DM.type, $G = DM.goToURL, $PI = DM.parseInt, $PF = DM.parseFloat;
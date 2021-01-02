/*//////////////////////////////////////////////////////////////////////////////
// ##########################################################################///
// # DM System 1.0                                                          # //
// ########################################################################## //
// #                                                                        # //
// #               --  DM SYSTEM IS NOT FREE SOFTWARE  --                   # //
// #                                                                        # //
// #  ============ Programming & Designing By Dilovan Matini =============  # //
// #     	 Copyright © 2018 Dilovan Matini. All Rights Reserved.  	    # //
// #------------------------------------------------------------------------# //
// #------------------------------------------------------------------------# //
// # Website: www.qkurd.com                                                 # //
// # Contact us: dilovan@lelav.com                                          # //
// ########################################################################## //
//////////////////////////////////////////////////////////////////////////////*/

var dm = {
	parseInt: function( value, defaultValue, radix ){
		radix = radix || 10;
		return parseInt( value, radix ) || parseInt( defaultValue, radix ) || 0;
	},
	parseFloat: function( value, defaultValue ){
		return parseFloat( value ) || parseFloat( defaultValue ) || 0;
	},
	window: function( url, width, height, name ){
		var win = window.open( url, ( name ? name : "newWindow" ), "menubar=no,location=no,toolbar=no,titlebar=no,status=yes,scrollbars=yes,width="+width+",height="+height+",left="+( (document.body.clientWidth-width) / 2 )+",top=20");
		$(win).focus();
	},
	goTo: function( url, target, options ){
		url = dm.checkVar( url, ['string'], '' );
		target = dm.checkVar( target, ['string'], '' );
		options = dm.checkVar( options, ['object'], {} );
		
		if( url.length == 0 ){
			return;
		}

		if( target == '_window' ){
			options.windowName = dm.checkVar( options.windowName, ['string'], 'targetWindow' );
			options.width = dm.checkVar( options.width, ['number'], 900 );
			options.height = dm.checkVar( options.height, ['number'], 500 );
			dm.window(url, options.width, options.height, options.windowName);
		}
		else if( target == '_blank' ){
			var form, parts, gets, vals, key, val;
			$(document.body).append('<form class="goto-target-form" method="get" target="'+target+'"></form>');
			form = $('.goto-target-form');
			parts = url.split('?');
			form.attr( 'action', ( parts[0].length > 0 ) ? parts[0] : 'index.php' );
			if( parts[1] ){
				gets = parts[1].split('&');
				for( var x = 0; x < gets.length; x++ ){
					vals = gets[x].split('=');
					key = vals[0];
					val = vals[1] || '';
					if( key.length > 0 && val.length > 0 ){
						form.append('<input type="hidden" name="'+key+'" value="'+val+'">');
					}
				}
			}
			form.submit();
			form.remove();
		}
		else{
			document.location = url;
		}
	},
	round: function(number, precision){
		if(!precision || precision == 0){
			precision = 1;
		}
		var pow, ceil, floor, dc, df;
		pow = Math.pow(10, precision);
		ceil = ( Math.ceil(number * pow) / pow );
		floor = ( Math.floor(number * pow) / pow );
		pow = Math.pow(10, (precision + 1) );
		dc = ( pow * (ceil - number) );
		df = ( pow * (number - floor) + ( (number < 0) ? -1 : 1 ) );
		return (dc >= df) ? floor : ceil;
	},
	rand: function(number){
		if($.type(number) != 'number'){
			number = 999999999;
		}
		return Math.floor(Math.random() * number);
	},
	mtrand: function(min, max){
		min = this.parseInt(min);
		max = this.parseInt(max, 999999999);
		return Math.floor(Math.random() * (max - min + 1)) + min;
	},
	numberFormat: function( number, decimals, decPoint, thousandsSep ){
		number = ( number + '' ).replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number;
		var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
		var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
		var dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
		var s = '';

		var toFixedFix = function( n, prec ){
			var k = Math.pow(10, prec);
			return '' + ( Math.round(n * k) / k ).toFixed( prec );
		};

		s = ( prec ? toFixedFix(n, prec) : '' + Math.round(n) ).split('.');
		if( s[0].length > 3 ){
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if( ( s[1] || '' ).length < prec ){
			s[1] = s[1] || '';
			s[1] += new Array( prec - s[1].length + 1 ).join('0');
		}

		return s.join( dec );
	},
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
	checkVar: function( value, allowTypes, defaultValue ){
		var type = $.type(value);

		if( $.type(allowTypes) !== 'array' ){
			allowTypes = [allowTypes];
		}

		if( $.inArray( type, allowTypes ) >= 0 || $.inArray( 'string', allowTypes ) >= 0 && type === 'number' ){
			return value;
		}
		else if( $.inArray( 'number', allowTypes ) >= 0 ){
			defaultValue = ( $.type(defaultValue) === 'undefined' ) ? 0 : defaultValue;
			return parseInt( value, 10 ) || defaultValue;
		}
		else{
			if( $.type(defaultValue) === 'undefined' ){
				if( $.inArray( 'string', allowTypes ) >= 0 ){
					return '';
				}
				else if( $.inArray( 'object', allowTypes ) >= 0 ){
					return {};
				}
				else if( $.inArray( 'array', allowTypes ) >= 0 ){
					return [];
				}
				else if( $.inArray( 'boolean', allowTypes ) >= 0 ){
					return false;
				}
				else if( $.inArray( 'function', allowTypes ) >= 0 ){
					return function(){};
				}
				else if( $.inArray( 'date', allowTypes ) >= 0 ){
					return new Date();
				}
				else if( $.inArray( 'error', allowTypes ) >= 0 ){
					return new Error();
				}
				else if( $.inArray( 'regexp', allowTypes ) >= 0 ){
					return /(.*)/;
				}
				else if( $.inArray( 'undefined', allowTypes ) >= 0 ){
					return undefined;
				}
				else if( $.inArray( 'null', allowTypes ) >= 0 ){
					return null;
				}
				else{
					return '';
				}
			}
			else{
				return defaultValue;
			}
		}
	},
	doCall: function( callback, object, args ){
		if( $.type( callback ) === 'function' ){
			callback.apply( object, args );
		}
	},
	doBind: function( callback, object, arg1, arg2, arg3 ){
		if( $.type( callback ) === 'function' ){
			return callback.bind( object, arg1, arg2, arg3 );
		}
		return null;
	},
	textConvert: function( text, object ){
		text = dm.checkVar( text, ['string'], '' );
		if( text.length == 0 ){
			return'';
		}
		
		object = dm.checkVar( object, ['object'], {} );
		var except = dm.checkVar( object.except, ['array'], [] ),
		strip = dm.checkVar( object.strip, ['array'], [] ),
		stripSymbols = dm.checkVar( object.stripSymbols, ['boolean'], false ),
		stripKurdish = dm.checkVar( object.stripKurdish, ['boolean'], false ),
		stripSpace = dm.checkVar( object.stripSpace, ['boolean'], false ),
		inline = dm.checkVar( object.inline, ['boolean'], false ),
		search = dm.checkVar( object.search, ['boolean'], false ),
		symbols = [
			'`', '~', '!', '@', '#', '$', '%', '^', '&', '\\',
			'(', ')', '{', '}', '[', ']', '<', '>', "'", '"',
			'=', '+', '-', '*', '/', '_', '.', ',', '?', '|',
			':', ';'
		], strips = [];
		
		if( strip.length > 0 ){
			$.merge( strips, strip );
		}
		
		if( stripSymbols ){
			$.merge( strips, symbols );
		}
	
		if( except.length > 0 ){
			for( var x = 0; x < except.length; x++ ){
				strips.trash( except[x] );
			}
		}
		
		if( stripSpace ){
			text = text.replace( /\s/g, '' );
		}
		
		if( search ){
			strips.trash( '*' );
		}
		
		if( strips.length > 0 ){
			text = text.replace(
				new RegExp( strips.join('|\\'), 'g' ),
				''
			);
		}
		
		if( stripKurdish ){
			text = text.replace( /َ|ً|ُ|ٌ|ِ|ٍ|ْ|ّ/g, '' ); // arabic actions fatha, dhama, kasra, ...
			text = text.replace( /ة|ه‌|ە|ھ/g, 'ه' );
			text = text.replace( /أ|آ|إ/g, 'ا' );
			text = text.replace( /ۆ|ؤ/g, 'و' );
			text = text.replace( /ى|ێ|ی/g, 'ي' );
			text = text.replace( /چ/g, 'ج' );
			text = text.replace( /ڤ/g, 'ف' );
			text = text.replace( /ژ/g, 'ز' );
			text = text.replace( /گ/g, 'ك' );
			text = text.replace( /پ/g, 'ب' );
			text = text.replace( /ڕ/g, 'ر' );
			text = text.replace( /ڵ/g, 'ل' );
		}
		
		if( inline ){
			text = text.replace( /\n/g, '' );
			text = text.replace( /\r/g, '' );
			text = text.replace( /\t/g, '' );
		}
		
		if( search ){
			text = text.replace( /\*/g, '%' );
		}

		return text;
	},
	m2u: function( text ){
		text = text.toString();
		text = text.replace(/يَ/g, 'ێ');
		text = text.replace(/ىَ/g, 'ێ');
		text = text.replace(/]/g, 'ێ');
		text = text.replace(/ة/g, 'ە');
		text = text.replace(/ظ/g, 'ڤ');
		text = text.replace(/ث/g, 'پ');
		text = text.replace(/ذ/g, 'ژ');
		text = text.replace(/ط/g, 'گ');
		text = text.replace(/ض/g, 'چ');
		text = text.replace(/وَ/g, 'ۆ');
		text = text.replace(/ؤ/g, 'ۆ');
		text = text.replace(/رِ/g, 'ڕ');
		return text;
	},
	getYoutubeVideoId: function( url ){
		var regExp = /^.*(youtu.be\/|v\/|vi\/|e\/|u\/\w+\/|embed\/|v=|vi=)([^#\&\?]{11}).*/;
		var match = url.match(regExp);
		if( match && match[2].length == 11 ){
			return match[2];
		}
		return'';
	},
	isDate: function( date, format ){
		date = dm.checkVar( date, ['string'], '' );
		format = dm.checkVar( format, ['string'], 'Y-m-d' );
		if( date.length < 8 || date.length > 10 || format.length != 5 ){
			return false;
		}
		
		var
		format_split = format.split(''),
		sep = format.substr(1, 1),
		format_vars = format.split(sep),
		date_vars = date.split(sep),
		months_days = [0,
			31, 29, 31,
			30, 31, 30,
			31, 31, 30,
			31, 30, 31
		],
		year = 0,
		month = 0,
		day = 0,
		is_leap_year;
		
		for( var x = 0; x < format_vars.length; x++ ){
			if( format_vars[x] == 'Y' ){
				year = dm.parseInt(date_vars[x]);
			}
			else if( format_vars[x] == 'm' ){
				month = dm.parseInt(date_vars[x]);
			}
			else if( format_vars[x] == 'd' ){
				day = dm.parseInt(date_vars[x]);
			}
			else{
				return false;
			}
		}
		
		is_leap_year = ( ( year % 4 == 0 ) && ( year % 100 != 0 ) || ( year % 400 == 0 ) ) ? true : false;
		
		if( year < 1000 || year > 9999 ){
			return false;
		}
		else if( month < 1 || month > 12 ){
			return false;
		}
		else if( day < 1 || day > months_days[month] ){
			return false;
		}
		else if( !is_leap_year && month == 2 && day > 28 ){
			return false;
		}
		else{
			return true;
		}
	},
	keyboardShortcut: function(){
		var chortcuts = arguments,
		letters = {
			// some shortcut not work in all browser ( ctrl+n ctrl+t ctrl+w )
			up: 38, down: 40, left: 37, right: 39,
			a: 65, b: 66, c: 67, d: 68, e: 69,
			f: 70, g: 71, h: 72, i: 73, j: 74,
			k: 75, l: 76, m: 77, n: 78, o: 79,
			p: 80, q: 81, r: 82, s: 83, t: 84,
			u: 85, v: 86, w: 87, x: 88, y: 89,
			z: 90, enter: 13, space: 32
		};
		
		$(document).keydown(function( event ){
			var keys = {
				shift: document.getElementById ? (event.shiftKey ? true : false) : ( document.layers ? (event.modifiers & Event.SHIFT_MASK ? true : false) : false ),
				//ctrl: (document.all || document.getElementById) ? (event.ctrlKey ? true : false) : ( document.layers ? (event.modifiers & Event.CONTROL_MASK ? true : false) : false ),
				ctrl: ( event.ctrlKey || event.metaKey ),
				alt: document.getElementById ? (event.altKey ? true : false) : ( document.layers ? (event.modifiers & Event.ALT_MASK ? true : false) : false )
			}, additionKeys = ( keys.shift || keys.ctrl || keys.alt ? true : false ), chortcut, parts, key, letter;

			//alert(event.which);

			if( chortcuts.length > 0 ){
				for( var x = 0; x < chortcuts.length; x++ ){
					chortcut = chortcuts[x];
					if( $.type(chortcut) == 'object' ){
						chortcut.status = ( chortcut.status === false ) ? false : true;
						if( chortcut.key == 'enter' ){
							if( chortcut.status && event.which == 13 && ( !event.target || event.target.tagName.toLowerCase() != 'textarea' ) ){
								if( $.type(chortcut.done) === 'function' ){
									chortcut.done();
								}
								return false;
							}
						}
						if( chortcut.key == 'space' ){
							if( chortcut.status && event.which == 32 && ( !event.target || event.target.tagName.toLowerCase() != 'textarea' && event.target.tagName.toLowerCase() != 'input' ) ){
								if( $.type(chortcut.done) === 'function' ){
									chortcut.done();
								}
								return false;
							}
						}
						else{
							parts = chortcut.key.split('+');
							key = parts[0] || false,
							letter = parts[1] || false;
							if( chortcut.status && additionKeys && keys[key] && event.which == letters[letter] ){
								if( $.type(chortcut.done) === 'function' ){
									chortcut.done();
								}
								return false;
							}
						}
					}
				}
			}
		});
	},
	killAjax: {
		list: {},
		add: function( jqXHR, name ){
			if( !this.list[name] && $.type(this.list[name]) !== 'array' ){
				this.list[name] = [];
			}
			this.list[name][ this.list[name].length ] = jqXHR;
		},
		abort: function( name ){
			var list = this.list;
			if( !list[name] && $.type(list[name]) !== 'array' ){
				return;
			}
			for( var x = 0; x < list[name].length; x++ ){
				if( list[name][x].abort ){
					list[name][x].abort();
				}
			}
		}
	},
	ajaxurl: function( name ){
		var url = '';
		if( name && name.length > 0 ){
			url = 'ajax.php?type='+name+'&x='+dm.rand();
		}
		return url;
	},
	ajax: function( object ){
		if( $.type(object) !== 'object' ){
			return;
		}
		
		var inputs = {}, data = {}, results = {}, result, url, input, error,
		iconsList = {
			'white': '',
			'gray': '',
			'dark': '',
			'cskyblue': '<i class="icon-info-circle"></i> ',
			'cgold': '<i class="icon-warning"></i> ',
			'cmaroon': '<i class="icon-times-circle"></i> ',
			'delete': '<i class="icon-minus-circle"></i> ',
			'cgreen': '<i class="icon-check-circle"></i> ',
			'cyellow': '<i class="icon-warning"></i> '
		},
		checkButtonIcon = function( button, status ){
			var icon = $('i', button), classes;
			if( icon.length == 0 ){
				return;
			}
			
			if( status == 'loading' ){
				classes = icon.attr('class');
				icon.attr('bclass', classes);
				icon.removeClass( classes.split(' ')[0] ).addClass('icon-spinner icon-spin');
			}
			else{
				icon.attr('class', icon.attr('bclass'));
			}
		};
		
		object.name = dm.checkVar( object.name, ['string'], '' );
		object.url = dm.checkVar( object.url, ['string'], '' );
		object.type = dm.checkVar( object.type, ['string'], 'post' );
		object.timeout = dm.checkVar( object.timeout, ['number'], 0 );
		object.killAjax = dm.checkVar( object.killAjax, ['boolean'], false );
		object.info = dm.checkVar( object.info, ['object'], [] );
		object.button = dm.checkVar( object.button, ['object'], [] );
		object.error = dm.checkVar( object.error, ['function', 'string'], 'An error occurred while saving data, please try again' );
		object.before = dm.checkVar( object.before, ['function'], function(){ return true; } );
		object.after = dm.checkVar( object.after, ['function'], function(){} );
		object.inputs = dm.checkVar( object.inputs, ['array'], [] );
		object.results = dm.checkVar( object.results, ['array'], [] );
		
		if( object.name == '' && object.url == '' ){
			return;
		}

		if( !dm.busies ){
			dm.busies = {};
		}
		
		if( $.type(dm.busies[object.name]) === 'undefined' ){
			dm.busies[object.name] = false;
		}
		
		if( dm.busies[object.name] === true ){
			return;
		}
		
		if( object.killAjax === false ){
			dm.busies[object.name] = true;
		}
		
		if( object.button.length > 0 ){
			if( object.button.hasClass('disabled') ){
				return false;
			}
			checkButtonIcon( object.button, 'loading' );
		}
		
		if( object.info.length > 0 ){
			object.info.textInfo( '<i class="icon-spinner icon-spin"></i>', 'white' );
		}
		
		if( object.name != '' ){
			url = 'ajax.php?type='+object.name+'&x='+dm.rand();
		}
		else{
			url = object.url+( object.url.indexOf('?') ? '&' : '?' )+'x='+dm.rand();
		}
		
		for( var x = 0; x < object.inputs.length; x++ ){
		
			input = object.inputs[x];
			if( $.type(input) !== 'object' ){
				continue;
			}
			
			input.name = dm.checkVar( input.name, ['string'] );
			input.element = dm.checkVar( input.element, ['object'] );
			input.val = dm.checkVar( input.val, ['function', 'string'], '' );
			input.value = dm.checkVar( input.value, ['string'], '' );
			input.search = dm.checkVar( input.search, ['object', 'boolean'], false );
			
			if( input.name == '' ){
				continue;
			}
			
			if( input.value.length == 0 ){
				if( $.type(input.val) === 'function' ){
					input.value = ''+input.val.call( input.element );
				}
				else if( $.type(input.val) === 'string' && input.element[input.val] ){
					if( input.element.length > 0 ){
						input.value = ''+input.element[input.val]();
					}
					else{
						input.value = '';
					}
				}
				else{
					input.value = ''+input.val;
				}
			}

			if( input.value.length > 0 && ( $.type(input.search) === 'object' || input.search === true ) ){
				input.value = input.value.search(input.search);
			}
			
			data[input.name] = input.value;
			inputs[input.name] = {
				element: input.element,
				val: input.val,
				value: input.value
			};
		}
		
		object.data = {};
		object.data.inputs = inputs;
		
		if( object.results.length > 0 ){
			for( var i = 0; i < object.results.length; i++ ){
				result = object.results[i];
				if( $.type(result) !== 'object' ){
					continue;
				}
				
				result.type = dm.checkVar( result.type, ['string'], 'text' );
				result.name = dm.checkVar( result.name, ['string'], '' );
				result.text = dm.checkVar( result.text, ['function', 'string'], '' );
				result.callback = dm.checkVar( result.callback, ['function'], function(){} );
				result.alert = dm.checkVar( result.alert, ['object'], {} );
				
				if( result.name == '' ){
					continue;
				}
				
				results[result.name] = function( json ){
					var object = this.object, result = this.result, text = result.text;
					if( $.type(text) === 'function' ){
						text = text.call( this, json, inputs );
					}
					else if( $.type(json.text) === 'string' ){
						text = json.text;
					}

					if( json.vars ){
						$.each( json.vars, function( key, value ){
							var re = new RegExp('{:'+key+':}', "g");
							text = text.replace(re, value);
						});
					}
					if( object.info.length > 0 ){
						if( $.type(result.alert.type) === 'undefined' || result.alert.textinfo === true ){
							object.info.textInfo( iconsList[result.type]+text, result.type );
						}
						else{
							object.info.textInfo( '', 'white' );
						}
					}

					if( object.button.length > 0 ){
						object.button.prop('disabled', false);
					}
					if( $.type(result.alert.type) !== 'undefined' ){
						if( result.alert.type == 'classic' ){
							alert( text );
						}
						else if( result.alert.type == 'modal' ){
							var options = dm.checkVar( result.alert.options, ['object'], {} );
							var align = dm.checkVar( result.alert.align, ['string'], 'center' );
							
							let classes = [];
							if( align == 'center' ) classes.push('dm-center');
							if( align == 'left' ) classes.push('dm-left');
							if( align == 'right' ) classes.push('dm-right');
							if( result.type != '' ) classes.push('dm-'+result.type);
							
							options.content = '<div class="'+classes.join(' ')+'">'+text+'</div>';

							if( $.type(options.name) === 'undefined' ) options.name = 'alert-'+result.name;
							if( $.type(options.minwidth) === 'undefined' ) options.minwidth = 400;
							if( $.type(options.padding) === 'undefined' ) options.padding = 30;
							if( $.type(options.highlight) === 'undefined' ) options.highlight = true;
							if( $.type(options.outClose) === 'undefined' ) options.outClose = true;
							if( $.type(options.buttons) === 'undefined' ) options.buttons = [
								{
									name: 'ok',
									value: 'OK',
									focus: true,
									click: function( event, element ){
										element.data('modal').hide();
										return false;
									}
								}
							];

							$('<span />').modal(options).modal('show');
						}
					}
					result.callback.call( this, json, inputs );
				};
				results[result.name] = results[result.name].bind( {object: object, result: result} );
			}
		}
		
		object.data.results = results;
		
		error = function( json ){
			var error = this.error;
			
			if( $.type(json) !== 'object' ){
				json = {
					status: ''
				};
			}
			
			if( $.type(error) === 'function' ){
				error = error.call( this, json );
			}
			if( this.info.length > 0 ){
				this.info.textInfo( iconsList['cmaroon']+error+( json.status != '' ? ' <span class="dm-cred" dir="ltr">'+json.status+'</span>' : '' ), 'cmaroon' );
			}
			if( this.button.length > 0 ){
				this.button.prop('disabled', false);
			}
			object.after.call( this, json );
			checkButtonIcon( object.button );
			dm.busies[object.name] = false;
		};
		error = error.bind( object );
		
		if( !object.before.call( object ) ){
			return;
		}
		
		if( object.killAjax === true ){
			dm.killAjax.abort( object.name );
		}
		var jqXHR = $.ajax({
			type: object.type,
			url: url,
			data: data,
			dataType: 'json',
			cache: false,
			timeout: object.timeout,
			beforeSend: function( jqXHR ){
				dm.killAjax.add( jqXHR, object.name );
			},
			success: function( json ){
				var doError = false;
				if( $.type(json) !== 'object' ){
					doError = true;
				}
				
				if( doError === true && window.console && window.console.log ){
					window.console.log( '"json" is no object: name('+object.name+'), url('+url+')' );
				}
				
				if( doError === false ){
					json.status = dm.checkVar( json.status, ['string'] );
					json.id = dm.checkVar( json.id, ['number'] );
					
					if( results[json.status] ){
						results[json.status]( json );
						object.after.call( object, json );
						checkButtonIcon( object.button );
						dm.busies[object.name] = false;
						if( json.status == 'added' || json.status == 'updated' ){
							dm.needSave.resetValue();
						}
					}
					else{
						doError = true;
					}
				}
				
				if( doError === true ){
					error( json );
				}
			},
			error: function(){
				error();
			}
		});
		return jqXHR;
	},
	needSave: {
		inputs: [],
		store: function( object ){
			object = dm.checkVar( object, ['object'], {} );
			object.inputs = dm.checkVar( object.inputs, ['array'], [] );
			var input, callback;
			
			for( var x = 0; x < object.inputs.length; x++ ){
			
				input = object.inputs[x];
				if( $.type(input) !== 'object' ){
					continue;
				}
				
				input.element = dm.checkVar( input.element, ['object'], [] );
				input.val = dm.checkVar( input.val, ['function', 'string'], '' );
				input.value = dm.checkVar( input.value, ['string'], '' );
				
				if( input.element.length > 0 ){
					callback = function( event ){
						var input = dm.needSave.inputs[event.data.x],
						newValue = dm.needSave.getValue(input),
						oldValue = input.value;
						$(this).removeClass('error cgreen');
						if( newValue != oldValue ){
							$(this).addClass('cpurple');
						}
						else{
							$(this).removeClass('cpurple');
						}
					}
					if( input.element.hasClass('select-list') ){
						input.element.data('select-list').input.on('focus blur', { x: this.inputs.length }, callback);
					}
					else if( input.element.attr('type') == 'password' ){
						input.element.on('keyup', { x: this.inputs.length }, callback);
					}
					else{
						input.element.on('change', { x: this.inputs.length }, callback);
					}
				}

				this.inputs[this.inputs.length] = {
					element: input.element,
					val: input.val,
					value: this.getValue(input)
				};
			}
		},
		getValue: function( input ){
			var value = '';
			if( $.type(input.val) === 'function' ){
				value = input.val.call( input.element );
			}
			else if( $.type(input.val) === 'string' && input.element[input.val] ){
				value = input.element[input.val]();
			}
			else{
				value = ''+input.val;
			}
			return value;
		},
		resetValue: function( custom ){
			var element, found;
			custom = dm.checkVar( custom, ['array'] );
			for( var x = 0; x < this.inputs.length; x++ ){

				if( this.inputs[x].element.data('select-list') ){
					element = this.inputs[x].element.data('select-list').input;
				}
				else{
					element = this.inputs[x].element;
				}
				
				if( custom.length > 0 ){
					found = false;
					for( var i = 0; i < custom.length; i++ ){
						if( element[0] == custom[i][0] ){
							found = true;
						}
					}
					if( found === false ){
						continue;
					}
				}
				
				this.inputs[x].value = this.getValue(this.inputs[x]);
				
				if( element.length > 0 ){
					element.removeClass('cpurple');
				}
			}
		},
		check: function(){
			var hasChanges = false, newValue, oldValue;
			for( var x = 0; x < this.inputs.length; x++ ){
				newValue = this.getValue(this.inputs[x]);
				oldValue = this.inputs[x].value;
				if( newValue != oldValue ){
					hasChanges = true;
					break;
				}
			}
			return hasChanges;
		}
	},
	commandListCreate: function( varname, vars, extra ){
		dm.commandListVars = dm.checkVar( dm.commandListVars, 'object' );
		varname = dm.checkVar( varname, 'string' );
		vars = dm.checkVar( vars, 'array' );
		extra = dm.checkVar( extra, 'function' );
		if( varname.length > 0 ){
			dm.commandListVars[varname] = dm.checkVar( dm.commandListVars[varname], 'object' );
			dm.commandListVars[varname].extra = extra;
			if( vars.length > 0 ){
				var object, name, prop;
				for( var x = 0; x < vars.length; x++ ){
					object = vars[x];
					name = dm.checkVar( object.name, 'string' );
					prop = dm.checkVar( object.prop, 'function' );
					if( name.length > 0 ){
						dm.commandListVars[varname][name] = prop;
					}
				}
			}
		}
	},
	commandList: function( varname, object ){
		object = dm.checkVar( object, 'object' );
		object.id = dm.checkVar( object.id, 'number' );
		object.position = dm.checkVar( object.position, 'number' );
		object.write = dm.checkVar( object.write, 'boolean' );
		object.refresh = dm.checkVar( object.refresh, 'boolean' );
		object.vars = dm.checkVar( object.vars, 'array' );
		object.ajaxvars = dm.checkVar( object.ajaxvars, 'array' );
		object.commands = dm.checkVar( object.commands, 'array' );

		dm.commandListVars = dm.checkVar( dm.commandListVars, 'object' );
		if( $.type(dm.commandListVars[varname]) !== 'object' ){
			return;
		}
		var listVars = dm.commandListVars[varname];
		
		object.icons = dm.checkVar( object.icons, 'object' );

		if( object.vars.length > 0 ){
			var singleVar, name, value, type;
			for( x = 0; x < object.vars.length; x++ ){
				singleVar = dm.checkVar( object.vars[x], 'array' );
				if( singleVar.length >= 2 && singleVar.length <= 4 ){
					name = dm.checkVar( singleVar[0], 'string' );
					value = singleVar[1];
					type = dm.checkVar( singleVar[2], ['array', 'string'], 'string' );
					if( name.length > 0 && type.length > 0 ){
						if( $.type(singleVar[3]) === 'undefined' ){
							object[name] = dm.checkVar( value, type );
						}
						else{
							object[name] = dm.checkVar( value, type, singleVar[3] );
						}
					}
				}
			}
		}

		if( object.ajaxvars.length > 0 ){
			var ajaxvars_temp = [], singleVar, name, value;
			for( x = 0; x < object.ajaxvars.length; x++ ){
				singleVar = dm.checkVar( object.ajaxvars[x], 'array' );
				if( singleVar.length == 2 ){
					name = dm.checkVar( singleVar[0], 'string' );
					value = dm.checkVar( singleVar[1], 'string' );
					if( name.length > 0 && value.toString().length > 0 ){
						ajaxvars_temp[ajaxvars_temp.length] = [ name, value ];
					}
				}
			}
			object.ajaxvars = ajaxvars_temp;
		}
		
		if( object.commands.length > 0 ){
			
			object.html = '';
			
			var name, prop,
			createButton = function( name, prop ){
				var rules = ['lock', 'unlock', 'delete', 'restore', 'cancel', 'ended_restore', 'full_cancel'],
				dmcid, aclass, iclass, attr, hidden, attrs = '',
				getDMCID = function(){
					var dmcid = 'c'+dm.mtrand(10000000, 99999999);
					while( $.type( dm.commandListVarsProp[dmcid] ) === 'object' ){
						dmcid = 'c'+dm.mtrand(10000000, 99999999);
					}
					return dmcid;
				};
				
				dm.commandListVarsProp = dm.checkVar( dm.commandListVarsProp, 'object' );
				dmcid = getDMCID();
				
				prop.name = name;
				prop.dmcid = dmcid;
				prop.type = dm.checkVar( prop.type, 'string' );
				prop.cond = dm.checkVar( prop.cond, 'boolean' );
				prop.aclass = dm.checkVar( prop.aclass, 'array' );
				prop.href = dm.checkVar( prop.href, 'string' );
				prop.poptip = dm.checkVar( prop.poptip, 'string' );
				prop.icon = dm.checkVar( prop.icon, 'string' );
				prop.iclass = dm.checkVar( prop.iclass, 'array' );
				prop.attrs = dm.checkVar( prop.attrs, 'array' );
				prop.refresh = dm.checkVar( prop.refresh, 'boolean' );
				prop.before = dm.checkVar( prop.before, 'function', function(){return true;} );
				prop.success = dm.checkVar( prop.success, 'function' );
				prop.after = dm.checkVar( prop.after, 'function' );
				
				if( prop.cond == false ){
					return;
				}

				aclass = ( prop.aclass.length > 0 ) ? ' '+prop.aclass.join(' ') : '';
				iclass = ( prop.iclass.length > 0 ) ? ' '+prop.iclass.join(' ') : '';
				
				for( var x = 0; x < prop.attrs.length; x++ ){
					attr = dm.checkVar( prop.attrs[x], 'array' );
					if( attr.length == 2 ){
						attrs += ' '+attr[0]+'="'+attr[1]+'"';
					}
				}

				if( prop.href.length > 0 ){
					attrs += ' href="'+prop.href+'"';
				}
				
				if( $.inArray( prop.name, rules ) >= 0 ){
					if( prop.type == '' ){
						return;
					}
					if( prop.name == 'lock' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Hold';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-lock';
						hidden = ( this.position != 1 ) ? ' style="display:none;"' : '';
						this.html += '<a class="icon dm-pointer dm-command'+aclass+'" dmcid="'+dmcid+'" poptip="'+prop.poptip+'"'+attrs+hidden+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
					}
					if( prop.name == 'unlock' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Active';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-unlock';
						hidden = ( this.position != 0 ) ? ' style="display:none;"' : '';
						this.html += '<a class="icon dm-pointer dm-command'+aclass+'" dmcid="'+dmcid+'" poptip="'+prop.poptip+'"'+attrs+hidden+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
					}
					if( prop.name == 'delete' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Delete';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-trash-o';
						hidden = ( this.position == 2 ) ? ' style="display:none;"' : '';
						this.html += '<a class="icon dm-pointer dm-command'+aclass+'" dmcid="'+dmcid+'" poptip="'+prop.poptip+'"'+attrs+hidden+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
					}
					if( prop.name == 'restore' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Restore';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-undo';
						hidden = ( this.position != 2 ) ? ' style="display:none;"' : '';
						this.html += '<a class="icon dm-pointer dm-command'+aclass+'" dmcid="'+dmcid+'" poptip="'+prop.poptip+'"'+attrs+hidden+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
					}

					dm.commandListVarsProp[dmcid] = prop;
					object.icons[name] = prop;

					$('.dm-command[dmcid="'+dmcid+'"]').livequery(function(){
						var command = $(this);
						if( command.data('command') ){
							return;
						}
						command.data('command', {
							busy: false,
							tip: ''
						});
						$(this).on('click', function(){
							var
							command = $(this),
							icon = $('i', command),
							dmcid = command.attr('dmcid'),
							prop = dm.commandListVarsProp[dmcid],
							row = $('tr[rowid='+object.id+']'),
							refresh = ( prop.refresh === true ) ? true : object.refresh,
							resultCall, confirmation = '', do_prompt = false;

							if( command.data('command').busy === true ){
								return false;
							}
							
							if( !prop.before.call( object, prop ) ){
								return false;
							}
							
							command.data('command').busy = true;
							icon.removeClass('dm-cred').addClass('icon-spinner icon-spin');
							command.data('poptip').setContent('In progress...');
							
							if( prop.name == 'lock' ){
								resultCall = function( json ){
									if( json && json.sets == 1 ){
										object.position = 0;
										command.hide();
										dm.getCommandByName('unlock', object).show();
										if( row.length > 0 ){
											$('> td', row).removeClass( tableRowClasses ).addClass( dm.rowStatus(0).className );
										}
										prop.success.call( object, prop );
									}
									else{
										if( json.errmsg ){
											alert(json.errmsg);
										}
									}
									icon.removeClass('icon-spinner icon-spin');
									command.data('poptip').setContent( command.attr('poptip') );
									command.data('command').busy = false;
								};
							}
							else if( prop.name == 'unlock' ){
								resultCall = function( json ){
									if( json && json.sets == 1 ){
										object.position = 1;
										command.hide();
										dm.getCommandByName('lock', object).show();
										if( row.length > 0 ){
											$('> td', row).removeClass( tableRowClasses ).addClass( row.attr('defaultclass') ? row.attr('defaultclass') : dm.rowStatus(1).className );
										}
										prop.success.call( object, prop );
									}
									else{
										if( json.errmsg ){
											alert(json.errmsg);
										}
									}
									icon.removeClass('icon-spinner icon-spin');
									command.data('poptip').setContent( command.attr('poptip') );
									command.data('command').busy = false;
								};
							}
							else if( prop.name == 'delete' ){
								confirmation = 'Are you sure you want to delete this record?';
								resultCall = function( json ){
									if( json && json.sets == 1 ){
										var restoreCommand = dm.getCommandByName('restore', object), wasDeleted = false;
										if( restoreCommand.length > 0 ){
											object.position = 2;
											command.hide();
											dm.getCommandByName('lock', object).hide();
											dm.getCommandByName('unlock', object).hide();
											restoreCommand.show();
											if( row.length > 0 ){
												command.data('poptip').hide();
												$('> td', row).removeClass( tableRowClasses ).addClass( dm.rowStatus(2).className );
											}
										}
										else{
											if( row.length > 0 ){
												command.data('poptip').hide();
												row.remove();
												wasDeleted = true;
											}
										}
										prop.success.call( object, prop );
									}
									else{
										if( json.errmsg ){
											alert(json.errmsg);
										}
									}
									icon.removeClass('icon-spinner icon-spin');
									if( !wasDeleted ){
										command.data('poptip').setContent( command.attr('poptip') );
										command.data('command').busy = false;
									}
								};
							}
							else if( prop.name == 'restore' ){
								confirmation = 'Are you sure you want to restore this record?';
								resultCall = function( json ){
									if( json && json.sets == 1 ){
										object.position = 1;
										command.hide();
										dm.getCommandByName('delete', object).show();
										dm.getCommandByName('lock', object).show();
										if( row.length > 0 ){
											$('> td', row).removeClass( tableRowClasses ).addClass( row.attr('defaultclass') ? row.attr('defaultclass') : dm.rowStatus(1).className );
										}
										prop.success.call( object, prop );
									}
									else{
										if( json.errmsg ){
											alert(json.errmsg);
										}
									}
									icon.removeClass('icon-spinner icon-spin');
									command.data('poptip').setContent( command.attr('poptip') );
									command.data('command').busy = false;
								};
							}
							
							var runCallback = function( prompt_text, undefined ){
								var inputs = [
									{ name: 'command', val: prop.type },
									{ name: 'cmdid', val: object.id }
								];
								
								if( prompt_text !== undefined ){
									inputs[inputs.length] = {
										name: 'prompt',
										val: prompt_text
									};
								}
								
								if( object.ajaxvars.length > 0 ){
									for( x = 0; x < object.ajaxvars.length; x++ ){
										inputs[inputs.length] = {
											name: object.ajaxvars[x][0],
											value: object.ajaxvars[x][1]
										};
									}
								}
								
								dm.ajax({
									name: 'commands',
									inputs: inputs,
									after: function(){
										if( refresh == 1 ){
											document.location = document.location.toString();
										}
									},
									error: function(){
										icon.removeClass('icon-spinner icon-spin').addClass('dm-cred');
										command.data('poptip').setContent('An error occurred while saving data, please try again');
										command.data('command').busy = false;
									},
									results: [
										{ name: 'success', text: resultCall }
									]
								});
							};
							
							if( confirmation != '' ){
								if( do_prompt === true ){
									confirmation = '<div class="dm-center">'+confirmation+'<br><textarea style="margin:5px;width:560px;height:80px;" placeholder="Write your remarks here"></textarea></div>';
								}
								else{
									confirmation = '<div class="dm-center">'+confirmation+'</div>';
								}
								$(document.body).modal({
									name: 'command-'+object.id,
									minwidth: 600,
									minheight: 100,
									highlight: true,
									content: confirmation,
									buttons: [
										{
											name: 'cancel',
											value: 'No',
											click: function( event, element ){
												icon.removeClass('icon-spinner icon-spin');
												command.data('poptip').setContent( command.attr('poptip') );
												command.data('command').busy = false;
												element.data('modal').hide();
												return false;
											}
										},
										{
											name: 'ok',
											value: 'Yes',
											classes: ['btn-cmaroon'],
											focus: true,
											click: function( event, element ){
												if( do_prompt === true ){
													runCallback( $('textarea', element.data('modal').content).val() );
												}
												else{
													runCallback();
												}
												element.data('modal').hide();
												return false;
											}
										}
									]
								}).modal('show');
							}
							else{
								runCallback();
							}
							
							prop.after.call( object, prop );
							return false;
						});
					});
				}
				else if( prop.name == 'actions' ){
					prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Actions';
					prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-info-circle';
					if( object.ajaxvars.length > 0 ){
						attrs += ' ajaxvars="'+escape( JSON.stringify( object.ajaxvars ) )+'"';
					}
					this.html += '<a class="icon dm-pointer cmd-get-actions'+aclass+'" cmdid="'+object.id+'" cmdname="'+prop.type+'" poptip="'+prop.poptip+'"'+attrs+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
				
					dm.commandListVarsProp[dmcid] = prop;
					object.icons[name] = prop;
				}
				else{
					
					if( object.ajaxvars.length > 0 ){
						attrs += ' ajaxvars="'+escape( JSON.stringify( object.ajaxvars ) )+'"';
					}
					
					if( prop.name == 'edit' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Modify';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-pencil';
					}
					else if( prop.name == 'email' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Send email to this user';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-envelope';
					}
					else if( prop.name == 'message' ){
						prop.poptip = ( prop.poptip.length > 0 ) ? prop.poptip : 'Send message to this user';
						prop.icon  = ( prop.icon.length > 0 ) ? prop.icon : 'icon-comment';
					}
					
					if( prop.poptip.length > 0 ){
						attrs += ' poptip="'+prop.poptip+'"';
					}
					this.html += '<a class="icon dm-pointer dm-command'+aclass+'" dmcid="'+dmcid+'"'+attrs+'><i class="'+prop.icon+' size20'+iclass+'"></i></a>\n';
					
					dm.commandListVarsProp[dmcid] = prop;
					object.icons[name] = prop;
					
					$('.dm-command[dmcid="'+dmcid+'"]').livequery(function(){
						$(this).on('click', function(){
							var
							command = $(this),
							aicon = $('i', command),
							dmcid = command.attr('dmcid'),
							prop = dm.commandListVarsProp[dmcid],
							row = $('tr[rowid='+object.id+']'),
							refresh = ( prop.refresh === true ) ? true : object.refresh;
							
							prop.command = command;
							prop.aicon = aicon;
							prop.row = row;
							prop.refresh = refresh;

							if( !prop.before.call( object, prop ) ){
								return false;
							}
							
							return prop.success.call( object, prop );
						});
					});
				}
			};
			
			listVars.extra.call( object );
			
			for( x = 0; x < object.commands.length; x++ ){
				name = dm.checkVar( object.commands[x], 'string' );
				if( name.length > 0 ){
					if( $.type(listVars[name]) === 'function' ){
						prop = listVars[name].call( object );
						createButton.call( object, name, prop );
					}
				}
			}
			
			if( object.write === true ){
				document.write( object.html );
			}
			else{
				return object.html;
			}
		}
	},
	getCommandByName: function( name, object ){
		var prop = dm.checkVar( object.icons[name], 'object' );
		if( prop.dmcid && prop.dmcid.length > 0 ){
			return $('.dm-command[dmcid="'+prop.dmcid+'"]');
		}
		return $([]);
	},
	rowStatus: function( position, defaultClassName, undefined ){
		var className;
		position = dm.parseInt( position );

		if( position == 0 ){
			className = 'text-cmaroon';
		}
		else if( position == 1 ){
			className = 'text-white';
		}
		else if( position == 2 ){
			className = 'text-delete';
		}
		else if( position == 10 ){ // in reality is status of transaction action
			className = 'text-gray';
		}
		else{
			className = ( defaultClassName != undefined ) ? defaultClassName : 'text-white';
		}

		return {
			className: className
		};
	},
	pagination: function( object ){
		if( $.type(object) !== 'object' ){
			return;
		}
		
		var count, url, perPage, pages;
		
		count = dm.checkVar( object.count, ['number'], 0 );
		url = dm.checkVar( object.url, ['string'], '' );
		perPage = dm.checkVar( object.perPage, ['number'], 10 ); 
		page = dm.checkVar( object.page, ['number'], 1 );
		
		if( count == 0 ){
			return;
		}
		
		if( perPage < 1 ){
			perPage = 10;
		}
		
		pages = Math.ceil( count / perPage );
		pages = ( pages == 0 ) ? 1 : pages;
		
		if( pages > 1 ){
			var firstPageHref = '#', prevPageHref = '#', firstClassName = '', lastPageHref = '#', nextPageHref = '#', lastClassName = '', code = '', equal;
			
			if( page > 1 ){
				firstPageHref = url+'page=1';
				prevPageHref = url+'page='+( page - 1 );
			}
			else{
				firstClassName = ' class="disabled"';
			}
			
			code = ''+
			'<div class="pagination">'+
			'	<ul>'+
			'		<li'+firstClassName+'><a href="'+firstPageHref+'">First Page</a></li>'+
			'		<li'+firstClassName+'><a href="'+prevPageHref+'">Prev Page</a></li>';
			
			if( page > 1 ){
				equal = ( page - ( ( page == 2 ) ? 1 : 2 ) );
				for( var x = equal; x < page; x++ ){
					code += '<li><a href="'+url+'page='+x+'">'+x+'</a></li>';
				}
			}
			
			code += '<li><a href="#" class="input"><input type="text" style="width:30px;display:inline-block;" value="'+page+'" pages="'+pages+'" page="'+page+'" url="'+url+'"></a></li>';

			if( page < pages ){
				equal = ( page + ( ( page == ( pages - 1 ) ) ? 1 : 2 ) );
				for( var x = ( page + 1 ); x <= equal; x++ ){
					code += '<li><a href="'+url+'page='+x+'">'+x+'</a></li>';
				}
				nextPageHref = url+'page='+( page + 1 );
				lastPageHref = url+'page='+pages;
			}
			else{
				lastClassName = ' class="disabled"';
			}
			
			code += ''+
			'		<li'+lastClassName+'><a href="'+nextPageHref+'">Next page</a></li>'+
			'		<li'+lastClassName+'><a href="'+lastPageHref+'">Last Page</a></li>'+
			'	</ul>'+
			'</div>';
		}
		return code;
	},
	paginationAjax: function( object ){
		if( $.type(object) !== 'object' ){
			return;
		}
		
		var count, url, perPage, pages, page;
		
		selector = dm.checkVar( object.selector, ['object', 'array'], [] );
		count = dm.checkVar( object.count, ['number'], 0 );
		callback = dm.checkVar( object.callback, ['function'], function(){} );
		perPage = dm.checkVar( object.perPage, ['number'], 10 ); 
		page = dm.checkVar( object.page, ['number'], 1 );
		
		if( count == 0 ){
			return;
		}
		
		if( perPage < 1 ){
			perPage = 10;
		}
		
		pages = Math.ceil( count / perPage );
		pages = ( pages == 0 ) ? 1 : pages;
		
		if( pages > 1 ){
			var
			firstClassName = '',
			lastClassName = '',
			code = '',
			equal;
			
			if( page == 1 ){
				firstClassName = ' class="disabled"';
			}
			
			code = ''+
			'<div class="pagination" style="margin-top:3px;">'+
			'	<ul>'+
			'		<li'+firstClassName+'><a href="#" number="'+( page > 1 ? 1 : 0 )+'">First Page</a></li>'+
			'		<li'+firstClassName+'><a href="#" number="'+( page > 1 ? ( page - 1 ) : 0 )+'">Prev Page</a></li>';
			
			if( page > 1 ){
				equal = ( page - ( ( page == 2 ) ? 1 : 2 ) );
				for( var x = equal; x < page; x++ ){
					code += '<li><a href="#" number="'+x+'">'+x+'</a></li>';
				}
			}
			
			code += '<li class="active"><span>'+page+'</span></li>';

			if( page < pages ){
				equal = ( page + ( ( page == ( pages - 1 ) ) ? 1 : 2 ) );
				for( var x = ( page + 1 ); x <= equal; x++ ){
					code += '<li><a href="#" number="'+x+'">'+x+'</a></li>';
				}
			}
			else{
				lastClassName = ' class="disabled"';
			}
			
			code += ''+
			'		<li'+lastClassName+'><a href="#" number="'+( page < pages ? ( page + 1 ) : 0 )+'">Next Page</a></li>'+
			'		<li'+lastClassName+'><a href="#" number="'+( page < pages ? pages : 0 )+'">Last Page</a></li>'+
			'	</ul>'+
			'</div>';
		}
		return {
			contents: function(){
				return code;
			},
			active: function( object ){
				var pagination = ( selector.length > 0 ) ? $('.pagination', selector) : $('.pagination'), elements = $('> ul > li > a', pagination);
				elements.on('click', function(){
					var element = $(this), number = dm.parseInt( element.attr('number') );
					if( number > 0 ){
						callback( number, object );
					}
					return false;
				});
			}
		};
	},
	toggleButton: function( selector, rule, options ){
		rule = dm.parseInt( rule );
		options = ( $.type(options) === 'object' ) ? options : {};
		var disabled, yes_text, no_text, classes, attrs, attrs_text, icon, html, key, val;
		
		disabled = ( options.disabled === true ) ? true : false;
		yes_text = ( $.type(options.yes_text) === 'string' ) ? options.yes_text : 'Yes';
		no_text = ( $.type(options.no_text) === 'string' ) ? options.no_text : 'No';
		classes = ( $.type(options.classes) === 'array' ) ? options.classes : [];
		attrs =  ( $.type(options.attrs) === 'array' ) ? options.attrs : [];
		
		classes[classes.length] = selector;
		if( disabled === true ){
			classes[classes.length] = 'disabled';
		}
		classes = classes.join(' ');
		
		attrs[attrs.length] = [ 'rule', rule ];
		attrs_text = [];
		for( var x = 0; x < attrs.length; x++ ){
			key = ( attrs[x][0] ) ? attrs[x][0] : '';
			val = ( attrs[x][1] ) ? attrs[x][1] : '';
			if( key != '' ){
				attrs_text[attrs_text.length] = key+'="'+val+'"';
			}
		}
		attrs = ' '+attrs_text.join(' ');
		
		icon = ( rule == 1 ) ? 'icon-check' : 'icon-times';
		html = ''+
		'<div class="toggle-button '+classes+'"'+attrs+'>'+
		'	<div class="box-yes">'+yes_text+'</div>'+
		'	<div class="box-move"><i class="'+icon+'"></i></div>'+
		'	<div class="box-no">'+no_text+'</div>'+
		'</div>';
		
		return html;
	},
	selectListLoad: function( element ){
		if( element.length > 0 ){
			var code = element.html();
			code = code.replace('tc_select-list', 'select-list');
			return code;
		}
	},
	allows: {
		list: {},
		add: function( list ){
			var name, status;
			list = dm.checkVar(list, ['array'], []);
			for( var x = 0; x < list.length; x++ ){
				if( $.type(list[x]) !== 'array' ){
					continue;
				}
				name = dm.checkVar(list[x][0], ['string'], '');
				status = dm.parseInt(list[x][1]);
				if( name != '' ){
					this.list[name] = status;
				}
			}
		}
	},
	allow: function( name ){
		if( name != '' ){
			name = name.toLowerCase();
			if( dm.allows.list[name] == 1 ){
				return true;
			}
		}
		return false;
	},
	callSearch: function( callback, duration, undefined ){
		if( $.type(dm.searchBreak) !== 'number' ){
			dm.searchBreak = 0;
		}
		clearTimeout(dm.searchBreak);
		duration = ( duration === undefined ) ? 500 : dm.parseInt(duration);
		dm.searchBreak = setTimeout(callback, duration);
	},
	scriptDefineURL: function( queryString, pagePath, undefined ){
		var path = '';
		
		try{
			pagePath = ( pagePath === false ) ? false : true;
			if( pagePath === true && _page_path != '' ){
				path = _page_path;
			}
			else{
				path = _script_path;
			}
		}
		catch(e){}
		
		queryString = ( queryString != undefined && queryString != '' ) ? queryString : '';
		if( path.length > 0 && queryString.length > 0 ){
			return path+( path.indexOf('?') == -1 ? '?' : '&' )+queryString;
		}
		else if( queryString.length > 0 ){
			return queryString;
		}
		else if( path.length > 0 ){
			return path;
		}
		else{
			return '';
		}
	},
	viewport: {
		isCompatible: false,
		element: [],
		run: function(){
			var isAppleDevice = ( navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) ), element = $('meta[name="viewport"]');
			if( isAppleDevice && element.length > 0 ){
				this.isCompatible = true;
				this.element = element;
				
				this.resetScale();

				window.addEventListener('gesturestart', this.resetScale, false);
				window.addEventListener('orientationchange', this.resetScale, false);
			}
		},
		resetScale: function(){
			var viewport = dm.viewport;
			if( viewport.isCompatible ){
				viewport.element.attr('content', 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0');
				viewport.element.attr('content', 'width=device-width, minimum-scale=0.25, maximum-scale=10');
			}
		}
	},
	alert: function( text, options, callback ){
		text = dm.checkVar( text, ['string'] );
		options = dm.checkVar( options, ['object'] );
		callback = dm.checkVar( callback, ['function'] );
		if( text.length == 0 ) return;

		options.alert = dm.checkVar( options.alert, ['string'] );
		if( options.alert == 'cmaroon' ){
			text = '<div class="dm-cmaroon dm-bold dm-center"><i class="icon-minus-circle dm-cmaroon size48"></i><br>'+text+'</div>';
		}
		else if( options.alert == 'cgreen' ){
			text = '<div class="dm-cgreen dm-bold dm-center"><i class="icon-check-circle dm-cgreen size48"></i><br>'+text+'</div>';
		}
		else if( options.alert == 'cyellow' ){
			text = '<div class="dm-cyellow dm-bold dm-center"><i class="icon-warning dm-cyellow size48"></i><br>'+text+'</div>';
		}

		var default_options = {
			name: 'alert',
			minwidth: 400,
			padding: 30,
			highlight: true,
			outClose: true,
			content: text,
			buttons: [
				{
					name: 'ok',
					value: 'OK',
					focus: true,
					click: function( event, element ){
						callback();
						element.data('modal').hide();
						return false;
					}
				}
			]
		};
		options = $.extend( true, default_options, options );
		$('<span />').modal(options).modal('show');
	},
	confirm: function( text, options, callbackYes, callbackNo ){
		text = dm.checkVar( text, ['string'] );
		options = dm.checkVar( options, ['object'] );
		callbackYes = dm.checkVar( callbackYes, ['function'] );
		callbackNo = dm.checkVar( callbackNo, ['function'] );
		if( text.length == 0 ) return;
		var default_options = {
			name: 'confirm',
			minwidth: 400,
			highlight: true,
			content: text,
			buttons: [
				{
					name: 'cancel',
					value: 'No',
					click: function( event, element ){
						callbackNo();
						element.data('modal').hide();
						return false;
					}
				},
				{
					name: 'ok',
					value: 'Yes',
					classes: ['btn-cmaroon'],
					focus: true,
					click: function( event, element ){
						callbackYes();
						element.data('modal').hide();
						return false;
					}
				}
			]
		};
		options = $.extend( true, default_options, options );
		$('<span />').modal(options).modal('show');
	},
	filesizeFromByte: function( size ){
		size = dm.parseInt(size);
		if( size >= 1024 ){
			size = ( size / 1024 );
			if( size >= 1024 ){
				size = ( size / 1024 );
				if( size >= 1024 ){
					size = ( size / 1024 );
					if( size >= 1024 ){
						size = ( size / 1024 );
						return dm.round( size, 2 )+" TB";
					}
					else{
						return dm.round( size, 2 )+" GB";
					}
				}
				else{
					return dm.round( size, 2 )+" MB";
				}
			}
			else{
				return dm.round( size, 2 )+" KB";
			}
		}
		else{
			return dm.round( size, 2 )+" B";
		}
	}
};
/******************************************************************************************************************************
	                                              prototype functions
******************************************************************************************************************************/
String.prototype.trim = function( clean, undefined ){
	var text = this;
	if( text.length == 0 ){
		return '';
	}
	if( clean != undefined ){
		text = text.ltrim(clean);
		text = text.rtrim(clean);
		return text;
	}
	else{
		return text.replace(/^\s+/, '').replace(/\s+$/, '');
	}
};
String.prototype.ltrim = function( clean, undefined ){
	var text = this;
	if( text.length == 0 ){
		return '';
	}
	if( clean != undefined ){
		while( text.substring(0, 1) == clean ){
			text = text.substring(1);
		}
		return text;
	}
	else{
		return text.replace(/^\s+/, '');
	}
};
String.prototype.rtrim = function( clean, undefined ){
	var text = this;
	if( text.length == 0 ){
		return '';
	}
	if( clean != undefined ){
		while( text.substring(text.length - 1) == clean ){
			text = text.substring( 0, text.length - 1 );
		}
		return text;
	}
	else{
		return text.replace(/\s+$/, '');
	}
};
String.prototype.search = function( object, undefined ){
	object = dm.checkVar( object, ['object'], {} );
	if( object.stripSymbols == undefined ){
		object.stripSymbols = true;
	}
	if( object.stripKurdish == undefined ){
		object.stripKurdish = true;
	}
	if( object.stripSpace == undefined ){
		object.stripSpace = true;
	}
	object.search = true;
	return dm.textConvert( this, object );
};
String.prototype.m2u = function(){
	return dm.m2u( this );
};
String.prototype.htmlEncode = function(){
	return this
	.replace(/&/g, '&amp;')
	.replace(/"/g, '&quot;')
	.replace(/'/g, '&#39;')
	.replace(/</g, '&lt;')
	.replace(/>/g, '&gt;');
};
String.prototype.htmlDecode = function(){
	return this
	.replace(/&amp;/g, '&')
	.replace(/&quot;/g, '"')
	.replace(/&#39;/g, "'")
	.replace(/&lt;/g, '<')
	.replace(/&gt;/g, '>');
};
String.prototype.nohtml = function(){
	return this.replace(/<\/?[^>]+(>|$)/g, "");
};
String.prototype.nl2br = function(){
	return this.replace(/\n/g, "<br>");
};
String.prototype.br2nl = function(){
	return this.replace(/<br?[^>]+(>|$)/g, "\n");
};
String.prototype.length_split = function( $length ){
	var string = this;
	if( $length === null ){
		$length = 1;
	}
	if( string === null || $length < 1 ){
		return false;
	}
	string += '';
	var chunks = [];
	var pos = 0;
	var len = string.length;
	while( pos < len ){
		chunks.push( string.slice( pos, pos += $length ) );
	}
	return chunks;
}
Array.prototype.add = function(){
	for( var x = 0; x < arguments.length; x++ ){
		this.push(arguments[x]);
	}
	return this;
};
Array.prototype.clear = function(){
	this.splice(0, this.length);
	return this;
};
Array.prototype.trash = function(value){
	var i = this.getIndex(value);
	if( i >= 0 ){
		this.splice(i, 1);
	}
	return this;
};
Array.prototype.getIndex = function(value){
	for( var x = 0; x < this.length; x++ ){
		if( this[x] == value ){
			return x;
		}
	}
	return -1;
};
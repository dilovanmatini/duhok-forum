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

/******************************************************************************************************************************
	                      All plugins in this file was programmed by Dilovan Matini
******************************************************************************************************************************/
/***
	$('select').sval(); 													// get selected value
	$('select').sval( 'valuebyindex', index ); 								// get value by index
	$('select').sval( 'valuebytext', text ); 								// get value by text
			
	$('select').sval( 'index' ); 											// get selected index
	$('select').sval( 'indexbyvalue', value ); 								// get index by value
	$('select').sval( 'indexbytext', text ); 								// get index by text
			
	$('select').sval( 'text', index ); 										// get selected text or by index if set
	$('select').sval( 'textbyvalue', value ); 								// get text by value
		
	$('select').sval( 'setvalue', value, index ); 							// set new value to selected option or by index if set
	$('select').sval( 'setvaluebytext', value, text ); 						// set new value by text
			
	$('select').sval( 'settext', text, index ); 							// set new text to selected option or by index if set
	$('select').sval( 'settextbyvalue', text, value ); 						// set new text by value
			
	$('select').sval( 'selectbyindex', index ); 							// select by index
	$('select').sval( 'selectbyvalue', value ); 							// select by value
	$('select').sval( 'selectbytext', text ); 								// select by text
		
	$('select').sval( 'add', newValue, newText, index ); 					// add new option to end of options or to index if set
	$('select').sval( 'addafter', newValue, newText, index, aftertype ); 	// add new option after selected option or after index or value or text if set
	$('select').sval( 'addbefore', newValue, newText, index, beforetype ); 	// add new option before selected option or before index or value or text if set
			
	$('select').sval( 'edit', newValue, newText, index ); 					// edit selected option or by index if set
	$('select').sval( 'editbyvalue', newValue, newText, value ); 			// edit option by value
	$('select').sval( 'editbytext', newValue, newText, text ); 				// edit option by text
			
	$('select').sval( 'remove', index ); 									// remove selected option
	$('select').sval( 'removebyvalue', value ); 							// remove option by value
	$('select').sval( 'removebytext', text ); 								// remove option by text
			
	$('select').sval( 'empty' ); 											// remove all options
***/
$.fn.sval = function( type, value1, value2, value3, value4, undefined ){
	var _sval = function( select ){
		if( type == undefined ){
			return select.options[select.selectedIndex].value;
		}
		else if( type == 'valuebyindex' ){
			var index = dm.parseInt( value1 );
			return ( select.options[index] ) ? select.options[index].value : '';
		}
		else if( type == 'valuebytext' ){
			var text = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == text ){
					return select.options[i].value;
				}
			}
			return '';
		}
		else if( type == 'index' ){
			return select.selectedIndex;
		}
		else if( type == 'indexbyvalue' ){
			var value = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value ){
					return i;
				}
			}
			return -1;
		}
		else if( type == 'indexbytext' ){
			var text = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == text ){
					return i;
				}
			}
			return -1;
		}
		else if( type == 'text' ){
			var index = ( value1 !== undefined ) ? dm.parseInt( value1 ) : select.selectedIndex;
			if( select.options[index] ){
				return select.options[index].text;
			}
			return '';
		}
		else if( type == 'textbyvalue' ){
			var value = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value ){
					return select.options[i].text;
				}
			}
			return '';
		}
		else if( type == 'setvalue' ){
			var index = ( value2 !== undefined ) ? dm.parseInt( value2 ) : select.selectedIndex;
			if( select.options[index] ){
				select.options[index].value = value1;
			}
			return '';
		}
		else if( type == 'setvaluebytext' ){
			var
			value = dm.checkVar( value1, 'string' ),
			text = dm.checkVar( value2, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == text ){
					select.options[i].value = value;
					break;
				}
			}
		}
		else if( type == 'settext' ){
			var index = ( value2 !== undefined ) ? dm.parseInt( value2 ) : select.selectedIndex;
			if( select.options[index] ){
				select.options[index].text = value1;
			}
			return '';
		}
		else if( type == 'settextbyvalue' ){
			var
			text = dm.checkVar( value1, 'string' ),
			value = dm.checkVar( value2, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value ){
					select.options[i].text = text;
					break;
				}
			}
		}
		else if( type == 'selectbyindex' ){
			var index = dm.parseInt( value1 );
			select.selectedIndex = index;
		}
		else if( type == 'selectbyvalue' ){
			var value = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value ){
					select.selectedIndex = i;
					break;
				}
			}
		}
		else if( type == 'selectbytext' ){
			var text = dm.checkVar( value1, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == text ){
					select.selectedIndex = i;
					break;
				}
			}
		}
		else if( type == 'add' ){
			if( value3 !== undefined ){
				addByIndex( select, value1, value2, dm.parseInt( value3 ) );
			}
			else{
				var
				newValue = dm.checkVar( value1, 'string' ),
				newText = dm.checkVar( value2, 'string' );
				select.options[select.options.length] = new Option( newText, newValue );
			}
		}
		else if( type == 'addafter' ){
			if( value4 == 'index' ){
				addByIndex( select, value1, value2, dm.parseInt( value3 ) + 1 );
			}
			else if( value4 == 'value' ){
				for( var i = 0; i < select.options.length; i++ ){
					if( select.options[i].value == value3 ){
						addByIndex( select, value1, value2, i + 1 );
						break;
					}
				}
			}
			else if( value4 == 'text' ){
				for( var i = 0; i < select.options.length; i++ ){
					if( select.options[i].text == value3 ){
						addByIndex( select, value1, value2, i + 1 );
						break;
					}
				}
			}
			else{
				addByIndex( select, value1, value2, select.selectedIndex + 1 );
			}
		}
		else if( type == 'addbefore' ){
			if( value4 == 'index' ){
				addByIndex( select, value1, value2, dm.parseInt( value3 ) );
			}
			else if( value4 == 'value' ){
				for( var i = 0; i < select.options.length; i++ ){
					if( select.options[i].value == value3 ){
						addByIndex( select, value1, value2, i );
						break;
					}
				}
			}
			else if( value4 == 'text' ){
				for( var i = 0; i < select.options.length; i++ ){
					if( select.options[i].text == value3 ){
						addByIndex( select, value1, value2, i );
						break;
					}
				}
			}
			else{
				addByIndex( select, value1, value2, select.selectedIndex );
			}
		}
		else if( type == 'edit' ){
			var
			newValue = dm.checkVar( value1, 'string' ),
			newText = dm.checkVar( value2, 'string' ),
			index = ( value3 !== undefined ) ? dm.parseInt( value3 ) :  select.selectedIndex;
			if( select.options[index] ){
				select.options[index] = new Option( newText, newValue );
			}
		}
		else if( type == 'editbyvalue' ){
			var
			newValue = dm.checkVar( value1, 'string' ),
			newText = dm.checkVar( value2, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value3 ){
					select.options[i] = new Option( newText, newValue );
					break;
				}
			}
		}
		else if( type == 'editbytext' ){
			var
			newValue = dm.checkVar( value1, 'string' ),
			newText = dm.checkVar( value2, 'string' );
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == value3 ){
					select.options[i] = new Option( newText, newValue );
					break;
				}
			}
		}
		else if( type == 'remove' ){
			var index = ( value1 !== undefined ) ? dm.parseInt( value1 ) : select.selectedIndex;
			$( select.options[index] ).remove();
		}
		else if( type == 'removebyvalue' ){
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].value == value1 ){
					$( select.options[i] ).remove();
					break;
				}
			}
		}
		else if( type == 'removebytext' ){
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].text == value1 ){
					$( select.options[i] ).remove();
					break;
				}
			}
		}
		else if( type == 'empty' ){
			$(select).children().remove();
		}
		return select;
	},
	addByIndex = function( select, value, text, index, undefined ){
		value = dm.checkVar( value, 'string' );
		text = dm.checkVar( text, 'string' );
		if( index !== undefined ){
			if( index >= select.options.length ){
				select.options[select.options.length] = new Option( text, value );
			}
			else{
				var options = [], y = false, z;
				for( var i = 0; i < select.options.length; i++ ){
					if( i == index ){
						options[i] = [value, text];
						y = true;
					}
					z = ( y ) ? ( i + 1 ) : i;
					options[z] = [
						select.options[i].value,
						select.options[i].text
					];
				}
				$(select).children().remove();
				for( var i = 0; i < options.length; i++ ){
					select.options[i] = new Option( options[i][1], options[i][0] );
				}
			}
		}
	}, selectors = this, returnValue = selectors;
	for( var x = 0; x < selectors.length; x++ ){
		returnValue = _sval( selectors[x] );
	}
	return returnValue;
};
/***
 used for get multiple select values
 $('select[multiple]').msval();
***/
$.fn.msval = function( seperator, undefined ){
	var selects = $(this), select, values = [];
	if( selects.length == 0 ){
		return '';
	}
	else if( selects.length == 1 ){
		for( var x = 0; x < selects.length; x++ ){
			select = selects[x];
			for( var i = 0; i < select.options.length; i++ ){
				if( select.options[i].selected === true ){
					values[values.length] = select.options[i].value;
				}
			}
		}
		if( seperator == undefined || seperator == '' ){
			seperator = ',';
		}
		return values.join(seperator);
	}
	else{
		return 'duplicate select found';
	}
};
/***
 .rval used for get radio input value
 $('input[type=radio]').rval();
***/
$.fn.rval = function(){
	var radios = this, radio, value = '';
	for( var x = 0; x < radios.length; x++ ){
		radio = $(radios[x]);
		if( radio.prop('tagName').toLowerCase() == 'input' && radio.attr('type') == 'radio' && radio.prop('checked') === true ){
			value = radio.val();
			break;
		}
	}
	return value;
};
/***
 .tbval used for get toggle btn value
 $('.toggle-btn').tbval();
***/
$.fn.tbval = function(){
	var toggle = $(this), rule = dm.parseInt( toggle.attr('rule') );
	return ( rule == 1 ) ? 1 : 0;
};
/***
 $(selector).toggleButton('setYes'); // make button be Yes
 $(selector).toggleButton('setNo'); // make button be No
 $(selector).toggleButton('enable'); // make button enable
 $(selector).toggleButton('disable'); // make button disable
 $(selector).on('tbchange', function( event, rule ){
	 
 });
***/
$.fn.toggleButton = function( option ){
	var _toggleButton = function( element ){
		
		if( element.data('toggle-button') ){
			return element;
		}
		
		var
		icon = $('i', element),
		setYes = function(){
			if( element.hasClass('disabled') ){
				return;
			}
			element.attr('rule', '1');
			icon.removeClass('icon-times').addClass('icon-check', 100);
			element.trigger( 'tbchange', [1] );
		},
		setNo = function(){
			if( element.hasClass('disabled') ){
				return;
			}
			element.attr('rule', '0');
			icon.removeClass('icon-check').addClass('icon-times', 100);
			element.trigger( 'tbchange', [0] );
		},
		enable = function(){
			element.removeClass('disabled');
		},
		disable = function(){
			element.addClass('disabled');
		};
		
		element.on('click', function(){
			var rule = dm.parseInt( $(this).attr('rule') );
			if( rule == 1 ){
				setNo();
			}
			else{
				setYes();
			}
		});

		element.data('toggle-button' , {
			setYes: setYes,
			setNo: setNo,
			enable: enable,
			disable: disable
		});
		return element;
	}, elements = $(this), options = ['setYes', 'setNo', 'enable', 'disable'], lastElement = [];
	for( var x = 0; x < elements.length; x++ ){
		lastElement = _toggleButton( $(elements[x]) );
	}
	
	if( $.type(option) === 'string' && $.inArray( option, options ) >= 0 && lastElement.length > 0 ){
		return lastElement.data('toggle-button')[option]();
	}
	
	return elements;
};
/***
 .brval used to get buttonRadio value or check button by value
 $('.button-radio').brval();
 $('.button-radio').brval( value );
***/
$.fn.brval = function( params ){
	var button = $(this);
	return $(this).data('button-radio').brval( params );
};
/***
 $(selector).buttonRadio('checked'); 											// It gets status of a button whether checked or unchecked
 $(selector).buttonRadio('checked', number or string or function or element ); 	// It gets status of a button whether checked or unchecked by value
 $(selector).buttonRadio('brval'); 												// It gets value of checked button
 $(selector).buttonRadio('brval', number or string or function or element ); 	// It checks button by value
 $(selector).buttonRadio('enable'); 											// It disables buttons
 $(selector).buttonRadio('disable'); 											// It enables buttons
 $(selector).on('brchange', function( event, rule ){
	 
 });
***/
$.fn.buttonRadio = function( option, params ){
	var _buttonRadio = function( button ){
		if( button.data('button-radio') ){
			return button;
		}
		
		var
		name = button.attr('button-name') || '',
		classname = button.attr('button-radio'),
		buttons = $('[button-radio][button-name="'+name+'"]'),
		selectedRule = function(){
			return $('.'+classname+'[button-radio][button-name="'+name+'"]').attr('rule') || '';
		},
		prepareButton = function( type ){
			var rule;
			if( $.type(type) == 'number' || $.type(type) == 'string' || $.type(type) == 'function' ){
				rule = type;
				if( $.type(rule) == 'function' ){
					rule = rule.call( button );
				}
				button = $('[button-radio][button-name="'+name+'"][rule="'+rule+'"]');
				return {
					update: true,
					button: button,
					rule: rule
				};
			}
			else if( $.type(type) == 'object' ){
				button = type;
				rule = button.attr('rule');
				return {
					update: true,
					button: button,
					rule: rule
				};
			}
			else{
				return {
					update: false,
					button: button,
					rule: selectedRule()
				};
			}
		},
		checked = function( type ){
			type = prepareButton(type);
			return type.button.hasClass(classname) ? true : false;
		},
		brval = function( type ){
			type = prepareButton(type);
			if( type.update === true ){
				if( button.hasClass('disabled') || selectedRule() == type.rule ){
					return;
				}
				buttons.removeClass(classname);
				type.button.addClass(classname);
				type.button.trigger( 'brchange', [type.rule] );
				return type.rule;
			}
			else{
				return type.rule;
			}
		}
		enable = function(){
			buttons.removeClass('disabled');
		},
		disable = function(){
			buttons.addClass('disabled');
		};
		
		button.on('click', function(){
			brval(button);
			return false;
		});

		button.data('button-radio' , {
			name: name,
			classname: classname,
			buttons: buttons,
			checked: checked,
			brval: brval,
			enable: enable,
			disable: disable
		});
	}, elements = $(this), options = ['name', 'classname', 'buttons', 'checked', 'brval', 'enable', 'disable'], lastElement = [];
	for( var x = 0; x < elements.length; x++ ){
		lastElement = _buttonRadio( $(elements[x]) );
	}

	if( $.type(option) === 'string' && $.inArray( option, options ) >= 0 && lastElement.length > 0 ){
		if( $.inArray( option, ['name', 'classname', 'buttons'] ) >= 0 ){
			return lastElement.data('button-radio')[option];
		}
		else{
			return lastElement.data('button-radio')[option](params);
		}
	}
	
	return elements;
};
/***
 .bcval used to get buttonCheck value or check button by value as an [Array] for example: [value1, value2, ...]
 $('.button-check').bcval();
 $('.button-check').bcval( value );
***/
$.fn.bcval = function( params ){
	var button = $(this);
	return $(this).data('button-check').bcval( params );
};
/***
 .bcsval used to get buttonCheck value or check button by value as a "String" for example "value1,value2,..."
 $('.button-check').bcsval();
 $('.button-check').bcsval( value );
***/
$.fn.bcsval = function( params ){
	var button = $(this);
	return $(this).data('button-check').bcval( params ).join(',');
};
/***
 $(selector).buttonCheck('checked'); 											// It gets status of a button whether checked or unchecked
 $(selector).buttonCheck('checked', number or string or function or element ); 	// It gets status of a button whether checked or unchecked by value
 $(selector).buttonCheck('bcval'); 												// It gets value of checked button
 $(selector).buttonCheck('bcval', number or string or function or element ); 	// It checks button by value
 $(selector).buttonCheck('enable'); 											// It disables buttons
 $(selector).buttonCheck('disable'); 											// It enables buttons
 $(selector).on('bcchange', function( event, rule ){
	 
 });
***/
$.fn.buttonCheck = function( option, params ){
	var _buttonCheck = function( button ){
		if( button.data('button-check') ){
			return button;
		}
		
		var
		name = button.attr('button-name') || '',
		classname = button.attr('button-check'),
		buttons = $('[button-check][button-name="'+name+'"]'),
		selectedRule = function(){
			var selectedButtons = $('.'+classname+'[button-check][button-name="'+name+'"]'), vals = [];
			for( var i = 0; i < selectedButtons.length; i++ ){
				vals[vals.length] = $(selectedButtons[i]).attr('rule') || '';
			}
			return vals;
		},
		prepareButton = function( type ){
			var rule;
			if( $.type(type) == 'number' || $.type(type) == 'string' || $.type(type) == 'function' ){
				rule = type;
				if( $.type(rule) == 'function' ){
					rule = rule.call( button );
				}
				button = $('[button-check][button-name="'+name+'"][rule="'+rule+'"]');
				return {
					update: true,
					button: button,
					rule: rule
				};
			}
			else if( $.type(type) == 'object' ){
				button = type;
				rule = button.attr('rule');
				return {
					update: true,
					button: button,
					rule: rule
				};
			}
			else{
				return {
					update: false,
					button: button,
					rule: selectedRule()
				};
			}
		},
		checked = function( type ){
			type = prepareButton(type);
			return type.button.hasClass(classname) ? true : false;
		},
		bcval = function( type ){
			type = prepareButton(type);
			if( type.update === true ){
				if( button.hasClass('disabled') ){
					return;
				}
				if( $.inArray( type.rule, selectedRule() ) >= 0 ){
					type.button.removeClass(classname);
				}
				else{
					type.button.addClass(classname);
				}
				type.button.trigger( 'bcchange', [type.rule] );
				return type.rule;
			}
			else{
				return type.rule;
			}
		}
		enable = function(){
			buttons.removeClass('disabled');
		},
		disable = function(){
			buttons.addClass('disabled');
		};
		
		button.on('click', function(){
			bcval(button);
			return false;
		});

		button.data('button-check' , {
			name: name,
			classname: classname,
			buttons: buttons,
			checked: checked,
			bcval: bcval,
			enable: enable,
			disable: disable
		});
	}, elements = $(this), options = ['name', 'classname', 'buttons', 'checked', 'bcval', 'enable', 'disable'], lastElement = [];
	for( var x = 0; x < elements.length; x++ ){
		lastElement = _buttonCheck( $(elements[x]) );
	}

	if( $.type(option) === 'string' && $.inArray( option, options ) >= 0 && lastElement.length > 0 ){
		if( $.inArray( option, ['name', 'classname', 'buttons'] ) >= 0 ){
			return lastElement.data('button-check')[option];
		}
		else{
			return lastElement.data('button-check')[option](params);
		}
	}
	
	return elements;
};
/***
 .slval used for get option value in .select-list
 $('.select-list').slval();
***/
$.fn.slval = function( value, undefined ){
	var lists = this, list, input;
	for( var x = 0; x < lists.length; x++ ){
		list = $(lists[x]);
		if( list.hasClass('select-list') ){
			if( list.data('select-list') && list.data('select-list').input ){
				if( value === undefined ){
					return list.attr('slvalue') || '';
				}
				else{
					list.data('select-list').setValue( value );
				}
			}
		}
	}
};
/***
 .selectVal used for select option in select list
 $('select').selectVal('dm');
***/
$.fn.selectVal = function( undefined ){
	var selectors = this, selector, value;
	for(var x = 0; x < selectors.length; x++){
		if(selectors[x] == undefined || selectors[x].tagName.toLowerCase() != 'select'){
			continue;
		}
		else{
			selector = selectors[x];
			value = $(selector).attr('val');
			for( var i = 0; i < selector.options.length; i++ ){
				if( selector.options[i].value == value ){
					selector.options[i].selected = true;
				}
			}
		}
	}
};
/***
 .setCursor set cursor to pointed text
 $('input, textarea').setCursor( start, end );
***/
$.fn.setCursor = function( start, end ){
	var element = this[0];
	if(element.setSelectionRange){
		element.focus();
		element.setSelectionRange(start, end);
	}
	else{
		if(element.createTextRange){
			var range = element.createTextRange();
			range.collapse(true);
			range.moveEnd('character', end);
			range.moveStart('character', start);
			range.select();
		}
	}
};
/***
 .getCursor get cursor from pointed text
 $('input, textarea').getCursor();
***/
$.fn.getCursor = function(){
	var element = this[0], position = 0, select, selLength;
	if(document.selection){
		element.focus();
		select = document.selection.createRange();
		selLength = document.selection.createRange().text.length;
		select.moveStart('character', -element.value.length);
		position = (select.text.length - selLength);
	}
	else if(element.selectionStart || element.selectionStart == '0'){
		position = element.selectionStart;
	}
	return position;
};
/***
 .popbox used for get or set select tag text
 $( selector ).popbox( [options [, callback]] );
***/
$.fn.popbox = function( options, callback ){
	var _popbox = function( element, options ){
		// merge options and json options and default options
		var defaults = {					// approval contents					| data type 		| default	| information
			trigger: 'click',				// click hover toggle manual			| string 			| 'click'	| how popbox is triggered
			placement: 'ver',				// ver hor top bottom left right		| string 			| 'ver'		| how to position the popbox
			arrowalign: 'center',			// center left right top bottom			| string 			| 'center'	| align for arrow
			arrowfar: 0,					// 0 to infinity						| int 				| 0			| how far arrow form element
			padding: 6,						// 0 to infinity						| int 				| 6			| padding for box content
			width: 0,						// 30 to maxwidth option				| int 				| 0			| popbox width, 0 = auto
			height: 0,						// 30 to maxheight option				| int 				| 0			| popbox height, 0 = auto
			maxwidth: 800,					// 30 to infinity						| int 				| 800		| popbox max width, if set width the width become max width
			maxheight: 400,					// 30 to infinity						| int 				| 400		| popbox max height, if set height the height become max height
			dir: '',						// ltr or rtl							| string 			| empty		| direction of popbox element
			delay: {show:400, hide:400},	// 0 to infinity						| int, object		| 400		| how long to show or hide popbox (milliseconds), this work if trigger = hover
			scroll: 'both',					// none ver hor both					| string			| 'both'	| set scroll for the popbox
			wrap: false,					// true false							| boolean			| false		| if wrap = true, text will break when it necessary.
			datacatch: true,				// true false							| boolean			| true		| if datacatch = true then content will set one-time, if datacatch = false then content will set every call show()
			url: '',						// ajax url								| string			| ''		| url for ajax operation with get method
			vars: {},						// ajax data							| object			| {}		| vars for ajax operation with post method
			selector: '',					// jquery selector						| string, object	| ''		| for get innerHTML from jquery selector
			content: '',					// any thing							| string			| ''		| content of the popbox
			header: '',						// any thing							| string			| ''		| header of the popbox, if header is empty will not show
			footer: ''						// any thing							| string			| ''		| footer of the popbox, if footer is empty will not show
			/***
			you can use callback function for all options, for example:-
			$( selector ).popbox({
				trigger: function(){
					return 'toggle';
				},
				width: function(){
					return 300;
				},
				...
			});
			***/
		}, json_options = ( element.attr('popbox') ) ? $.parseJSON( unescape( element.attr('popbox') ) ) : {};
		json_options = $.extend(true, defaults, json_options);
		options = $.extend(true, json_options, options || {});
		var createPopbox = function(){
			var data = element.data('popbox');
			if(data.created === false){
				popbox.css({
					'top': 0,
					'left': 0,
					'right': 'auto',
					'display': 'block'
				}).insertAfter(element);
				if( dirOption != '' ){
					popbox.attr('dir', dirOption);
				}
				data.created = true;
			}
		},
		show = function(){
			if( contentOption == '' && urlOption == '' ){
			 	return;
			}
			popboxShown = true;
			createPopbox();
			setPadding();
			setContents();
			setScrollbar();
			setPosition();
			popbox.show();
		},
		shown = function(){
			return popboxShown;
		},
		hide = function(){
			popbox.hide();
			popboxShown = false;
		},
		hidden = function(){
			return !popboxShown;
		},
		setPosition = function(){
			if(!popboxShown){
				return;
			}
			popbox.css({
				'top': 0,
				'left': 0,
				'right': 'auto',
				'display': 'block'
			});
			setContentSize();
			var topPlace = function(){
				popbox.addClass('top');
				setArrowAlign();
				if(footerOption != ''){
					arrow.addClass('dark');
				}
				top = (position.top - boxHeight - arrowfarOption - arrowSize);
				if(arrowalignOption == 'left'){
					left = ( direction == 'rtl' ) ? (position.left + position.width - boxWidth) : ( position.left + (position.width / 2) - 20 );
				}
				else if(arrowalignOption == 'right'){
					left = ( direction == 'rtl' ) ? position.left : ( position.left + position.width - boxWidth - (position.width / 2) + 20 );
				}
				else{
					left = (position.left + (position.width / 2) - (boxWidth / 2));
				}
				popbox.offset({
					top: top,
					left: left
				});
			},
			bottomPlace = function(){
				popbox.addClass('bottom');
				setArrowAlign();
				if(headerOption != ''){
					arrow.addClass('dark');
				}
				top = (position.top + position.height + arrowfarOption + arrowSize);
				if(arrowalignOption == 'left'){
					left = ( direction == 'rtl' ) ? (position.left + position.width - boxWidth) : ( position.left + (position.width / 2) - 20 );
				}
				else if(arrowalignOption == 'right'){
					left = ( direction == 'rtl' ) ? position.left : ( position.left + position.width - boxWidth - (position.width / 2) + 20 );
				}
				else{
					left = (position.left + (position.width / 2) - (boxWidth / 2));
				}
				popbox.offset({
					top: top,
					left: left
				});
			},
			leftPlace = function(){
				popbox.addClass('left');
				setArrowAlign();
				if( (arrowalignOption == 'top' && headerOption != '') || (arrowalignOption == 'bottom' && footerOption != '') ){
					arrow.addClass('dark');
				}
				if(arrowalignOption == 'top'){
					top = (position.top + (position.height / 2) - 20);
				}
				else if(arrowalignOption == 'bottom'){
					top = (position.top + position.height - boxHeight - (position.height / 2) + 20);
				}
				else{
					top = (position.top + (position.height / 2) - (boxHeight / 2));
				}
				left = ( direction == 'rtl' ) ? (position.left + position.width + arrowfarOption + arrowSize) : (position.left - boxWidth - arrowfarOption - arrowSize);
				popbox.offset({
					top: top,
					left: left
				});
			},
			rightPlace = function(){
				popbox.addClass('right');
				setArrowAlign();
				if( (arrowalignOption == 'top' && headerOption != '') || (arrowalignOption == 'bottom' && footerOption != '') ){
					arrow.addClass('dark');
				}
				if(arrowalignOption == 'top'){
					top = (position.top + (position.height / 2) - 20);
				}
				else if(arrowalignOption == 'bottom'){
					top = (position.top + position.height - boxHeight - (position.height / 2) + 20);
				}
				else{
					top = (position.top + (position.height / 2) - (boxHeight / 2));
				}
				left = ( direction == 'rtl' ) ? (position.left - boxWidth - arrowfarOption - arrowSize) : (position.left + position.width + arrowfarOption + arrowSize);
				popbox.offset({
					top: top,
					left: left
				});
			},
			boxWidth = popbox[0].offsetWidth,
			boxHeight = popbox[0].offsetHeight,
			arrowSize = arrowWidth(),
			position = elementPosition(),
			windowWidth, windowHeight, scrollTop, scrollLeft, top, left;
			
			popbox.removeClass('top bottom left right');
			arrow.removeClass('dark');
			
			if(placementOption == 'top'){
				topPlace();
			}
			if(placementOption == 'bottom'){
				bottomPlace();
			}
			if(placementOption == 'left'){
				leftPlace();
			}
			if(placementOption == 'right'){
				rightPlace();
			}
			if(placementOption == 'ver'){
				windowHeight = $(window).height();
				scrollTop = $(document).scrollTop();
				if( (position.top - scrollTop) < (windowHeight / 2) ){
					bottomPlace();
				}
				else{
					topPlace();
				}
			}
			if(placementOption == 'hor'){
				windowWidth = $(window).width();
				scrollLeft = $(document).scrollLeft();
				if( (position.left - scrollLeft) < (windowWidth / 2) ){
					rightPlace();
				}
				else{
					leftPlace();
				}
			}
		},
		elementPosition = function(){
			var offset = element.offset(), position = {
				top: offset.top,
				left: offset.left,
				width: element[0].offsetWidth,
				height: element[0].offsetHeight
			};
			return position;
		},
		setArrowAlign = function(){
			var alignElement;
			if(arrowalignOption == 'top' || arrowalignOption == 'bottom'){
				alignElement = $('.popbox.left .arrow, .popbox.right .arrow');
				if(arrowalignOption == 'top'){
					alignElement.css('top', '20px');
					alignElement.css('bottom', 'auto');
				}
				if(arrowalignOption == 'bottom'){
					alignElement.css('bottom', '9px');
					alignElement.css('top', 'auto');
				}
			}
			if(arrowalignOption == 'left' || arrowalignOption == 'right'){
				alignElement = $('.popbox.top .arrow, .popbox.bottom .arrow');
				left = ( direction == 'rtl' ) ? 'right' : 'left';
				right = ( direction == 'rtl' ) ? 'left' : 'right';
				if(arrowalignOption == 'left'){
					alignElement.css(left, '20px');
					alignElement.css(right, 'auto');
				}
				if(arrowalignOption == 'right'){
					alignElement.css(right, '9px');
					alignElement.css(left, 'auto');
				}
			}
		},
		arrowWidth = function(){
			var border = function(align){
				return parseInt( arrow.css('border-'+align+'-width'), 10 ) || 0;
			};
			return Math.max( border('top'), border('bottom'), border('left'), border('right') );
		},
		setPadding = function(){
			var padding, topPadding, bottomPadding, width,
			pixel = function(size){
				return ( size > 0 ) ? size+'px' : '0';
			};
			padding = ( paddingOption > 0 ) ? paddingOption : 0;
			topPadding = ( headerOption != '' ) ? padding : ( padding + 4 );
			bottomPadding = ( footerOption != '' ) ? padding : ( padding + 4 );
			padding = pixel(topPadding)+' '+pixel(padding)+' '+pixel(bottomPadding);
			contentBox.css('padding', padding);
		},
		setContentSize = function(){
			var maxWidth = maxwidthOption, maxHeight = maxheightOption, contentWidth, contentHeight;
			if(widthOption >= 30){
				maxWidth = widthOption;
				contentBox.css('width', widthOption+'px');
			}
			if(heightOption >= 30){
				maxHeight = heightOption;
				contentBox.css('height', heightOption+'px');
			}
			contentWidth = contentBox[0].offsetWidth;
			if(contentWidth > maxWidth){
				contentBox.css('width', maxWidth+'px');
			}
			contentHeight = contentBox[0].offsetHeight;
			if(contentHeight > maxHeight){
				contentBox.css('height', maxHeight+'px');
			}
		},
		setScrollbar = function(){
			var both, x, y;
			if(scrollOption == 'none'){
				return;
			}
			else{
				if(scrollOption == 'ver'){
					both = 'auto';
					x = 'hidden';
					y = 'overlay';
				}
				else if(scrollOption == 'hor'){
					both = 'auto';
					x = 'overlay';
					y = 'hidden';
				}
				else if(scrollOption == 'both'){
					both = 'overlay';
					x = 'auto';
					y = 'auto';
				}
				contentBox.css({
					'overflow': both,
					'overflow-x': x,
					'overflow-y': y
				});
			}
		},
		setContents = function(){
			if(datacatchOption && contentAdded){
				return;
			}
			if(urlOption != ''){
				var getVars = function(){
					var data = [];
					$.each(varsOption, function(name, value){
						data[data.length] = name+'='+value;
					});
					return data.join('&');
				};
				$(contentBox).html( (contentOption != '') ? contentOption : 'Loading...' );
				$.ajax({
					type: 'post',
					url: urlOption+(urlOption.indexOf('?') ? '&' : '?')+'x='+Math.random(),
					data: getVars,
					success: function(result){
						$(contentBox).html( result );
						_callback();
					},
					error: function(result){
						$(contentBox).html( '<span class="dm-cred">Loading Error.</span>' );
					}
				});
			}
			else if(selectorOption != ''){
				$(contentBox).html( $(selectorOption).html() );
				_callback();
			}
			else{
				$(contentBox).html( contentOption );
				_callback();
			}
			if(!contentAdded && headerOption != ''){
				$('<div class="popbox-header">'+headerOption+'</div>').insertBefore(contentBox);
			}
			if(!contentAdded && footerOption != ''){
				$('<div class="popbox-footer">'+footerOption+'</div>').insertAfter(contentBox);
			}
			contentAdded = true;
		},
		getValue = function(name, datatype){
			name = options[name];
			datatype = ( $.type(datatype) == 'array' ) ? datatype : [datatype];
			if( $.type(name) === 'function' ){
				return name.call(element[0]);
			}
			else if( $.inArray(  $.type(name), datatype ) >= 0 ){
				return name;
			}
			else{
				return '';
			}
		},
		popbox = $('<div class="popbox"><div class="arrow"></div><div class="popbox-frame"><div class="popbox-content"></div></div></div>'),
		contentBox = $('.popbox-content', popbox),
		arrow = $('.arrow', popbox),
		direction = element.css('direction'),
		// start options variables
		triggerOption = getValue('trigger', 'string'),
		placementOption = getValue('placement', 'string'),
		arrowalignOption = getValue('arrowalign', 'string'),
		arrowfarOption = getValue('arrowfar', 'number'),
		paddingOption = getValue('padding', 'number'),
		widthOption = getValue('width', 'number'),
		heightOption = getValue('height', 'number'),
		maxwidthOption = getValue('maxwidth', 'number'),
		maxheightOption = getValue('maxheight', 'number'),
		dirOption = getValue('dir', 'string'),
		delayOption = getValue('delay', ['object']),
		scrollOption = getValue('scroll', 'string'),
		wrapOption = getValue('wrap', 'boolean'),
		datacatchOption = getValue('datacatch', 'boolean'),
		urlOption = getValue('url', 'string'),
		varsOption = getValue('vars', 'object'),
		selectorOption = getValue('selector', ['object', 'string']),
		contentOption = getValue('content', 'string'),
		headerOption = getValue('header', 'string'),
		footerOption = getValue('footer', 'string'),
		// end options variables
		popboxShown = false,
		contentAdded = false,
		elementEnter = false,
		popboxEnter = false,
		showTimeout, hideTimeout;

		if( wrapOption === true ){
			contentBox.css('white-space','pre-line');
		}

		// trigger = click
		if(triggerOption == 'click'){
			$(element).click(function(){
				if(popboxShown === true){
					hide();
				}
				else{
					show();
				}
			});
		}
		
		// trigger = hover
		if(triggerOption == 'hover'){
			var showDelay = ( $.type(delayOption.show) === 'number' && delayOption.show >= 0 ) ? delayOption.show : 400,
			hideDelay = ( $.type(delayOption.hide) === 'number' && delayOption.hide >= 0 ) ? delayOption.hide : 400;
			$(element).hover(
				function(){
					showTimeout = setTimeout(show, showDelay);
					clearTimeout(hideTimeout);
					elementEnter = true;
				},
				function(){
					hideTimeout = setTimeout(function(){
						if(popboxEnter){
							return;
						}
						else{
							hide();
							clearTimeout(showTimeout);
						}
					}, hideDelay);
					elementEnter = false;
				}
			);
			$(popbox).hover(
				function(){
					popboxEnter = true;
				},
				function(){
					hideTimeout = setTimeout(function(){
						if(elementEnter){
							return;
						}
						else{
							hide();
							clearTimeout(showTimeout);
						}
					}, hideDelay);
					popboxEnter = false;
				}
			);
		}
		
		// trigger = toggle
		if(triggerOption == 'toggle'){
			$(element).click(function(){
				if(popboxShown === true){
					hide();
				}
				else{
					show();
				}
			});
			$(element).hover(
				function(){
					elementEnter = true;
				},
				function(){
					elementEnter = false;
				}
			);
			$(popbox).hover(
				function(){
					popboxEnter = true;
				},
				function(){
					popboxEnter = false;
				}
			);
			$(document.body).click(function(){
				if(popboxShown && !elementEnter && !popboxEnter){
					hide();
				}
			});
		}
		
		// when resize popbox content will set new position
		$(popbox).resize(function(){
			setPosition();
		});

		element.data({
			popbox: {
				created: false,
				show: show,
				shown: shown,
				hide: hide,
				hidden: hidden,
				content: contentBox,
				destroy: function(){
					popbox.remove();
					element.removeAttr("popbox");
					element.data({
						popbox: false
					});
				}
			}
		});
	},
	_prepare = function(element, options){
		var data = element.data('popbox'), events = ['show', 'hide', 'shown', 'hidden', 'destroy'];
		if( $.type(options) === 'object' || $.type(options) === 'undefined' ){
			if( !data ){
				_popbox( element, options );
			}
		}
		else if( $.type(options) === 'string' && $.inArray(options, events) >= 0 ){
			return data[options]();
		}
	}, elements = $(this), _callback = function(){}, returnValue;
	
	if( $.type(callback) === 'function' ){
		_callback = callback;
	}
	
	// set popbox to selector elements
	for(var x = 0; x < elements.length; x++){
		returnValue = _prepare( $(elements[x]), options );
	}
	
	// return selector elements if returnValue is undefined
	return ( $.type(returnValue) === 'undefined' ) ? elements : returnValue;
};
/***
	.poptip used for show tip text on the selector.
	
	$( selector ).poptip(); 								// create empty poptip [ return poptipData ]
	$( selector ).poptip( 'text' [string] ); 				// create poptip with text [ return poptipData ]
	$( selector ).poptip( options [object] ); 				// create poptip from optons [ return poptipData ]
	$( selector ).poptip( options | 'text' [function] ); 	// create poptip from optons [ return poptipData ]
	$( selector[poptip] ).poptip( [] ); 					// create poptip from json attribue ( poptip="{}" ) [ return poptipData ]
	$( selector ).poptip().show(); 							// show the poptip [ return poptipData ]
	$( selector ).data('poptip').show(); 					// another way to show the poptip [ return poptipData ]
	$( selector ).poptip().destroy(); 						// destroy the poptip [ return element ]
	
	<tag poptip=" your text || options "></tag>				// create poptip by html tag ( options = optionName:value; ) like css style after (||) symbol
	<tag poptip="{}"></tag>									// create poptip from json
***/
$.fn.poptip = function( options ){
	var _poptip = function( element, newOptions ){
		// merge options and json options and default options
		var defaults = {					// approval contents					| data type 		| default	| information
			trigger: 'hover',				// hover manual							| string 			| 'hover'	| how popbox is triggered
			placement: 'ver',				// ver hor top bottom left right		| string 			| 'ver'		| how to position the poptip
			hover: false,					// true false							| boolean			| false		| if hover = false when mouse hover poptip box will hide and if hover = true will do not hide 
			hideEmpty: true,				// true false							| boolean			| true		| if hideEmpty = true when content is empty will be hidden
			arrowfar: 2,					// 0 to infinity						| int 				| 2			| how far arrow form element
			padding: 6,						// 0 to infinity						| int 				| 6			| padding for box content
			width: 0,						// 0 to infinity						| int 				| 0			| poptip width, 0 = auto
			height: 0,						// 0 to infinity						| int 				| 0			| poptip height, 0 = auto
			maxWidth: 800,					// 0 to infinity						| int 				| 800		| poptip max width, if set width the width become max width
			maxHeight: 400,					// 0 to infinity						| int 				| 400		| poptip max height, if set height the height become max height
			minWidth: 20,					// 0 to infinity						| int 				| 16		| poptip min width, if set width the width become min width
			minHeight: 16,					// 0 to infinity						| int 				| 16		| poptip min height, if set height the height become min height
			json: {
				url: '',
				data: {},
				cache: true,
				before: function(){},
				success: function(){},
				error: function(){}
			},
			selector: '',					// jquery selector						| string, object	| ''		| for get innerHTML from jquery selector
			content: ''						// any thing							| string			| ''		| content of the poptip
			/***
			you can use callback function for all options, for example:-
			$( selector ).poptip({
				placement: function(){
					return 'ver';
				},
				width: function(){
					return 300;
				},
				...
			});
			***/
		}, oldData = element.data('poptip'), old_options = oldData ? oldData.options : {}, options = {};
		
		newOptions = dm.checkVar( newOptions, 'object' );
		$.extend( true, options, defaults, old_options, newOptions );
		
		var createPoptip = function(){
			if( !element.hasClass('poptip-created') ){
				poptip.css({
					'top': 0,
					'left': 0,
					'right': 'auto',
					'display': 'block'
				});
				$( document.body ).append( poptip );
				element.addClass('poptip-created');
			}
		},
		show = function( callback ){
			setContent();
			if( hideEmptyOption && box.html().length == 0 ){
				hide();
				return poptipData;
			}
			createPoptip();
			setPadding();
			setPosition();
			poptip.show();
			poptipData.visible = true;
			dm.doCall( callback, poptipData, [element] );
			return poptipData;
		},
		hide = function( callback ){
			poptip.hide();
			poptipData.visible = false;
			dm.doCall( callback, poptipData, [element] );
			return poptipData;
		},
		hidden = function( callback ){
			dm.doCall( callback, poptipData, [element] );
			return !poptipData.poptipShown;
		},
		setPosition = function(){
			var display = poptipData.visible;
			poptip.css({
				'top': 0,
				'left': 0,
				'right': 'auto',
				'display': 'block'
			});
			setContentSize();
			var topPlace = function(){
				poptip.addClass('top');
				top = (position.top - boxHeight - arrowfarOption - arrowSize);
				left = (position.left + (position.width / 2) - (boxWidth / 2));
				poptip.offset({
					top: top,
					left: left
				});
			},
			bottomPlace = function(){
				poptip.addClass('bottom');
				top = (position.top + position.height + arrowfarOption + arrowSize);
				left = (position.left + (position.width / 2) - (boxWidth / 2));
				poptip.offset({
					top: top,
					left: left
				});
			},
			leftPlace = function(){
				poptip.addClass('left');
				top = (position.top + (position.height / 2) - (boxHeight / 2));
				left = ( direction == 'rtl' ) ? (position.left + position.width + arrowfarOption + arrowSize) : (position.left - boxWidth - arrowfarOption - arrowSize);
				poptip.offset({
					top: top,
					left: left
				});
			},
			rightPlace = function(){
				poptip.addClass('right');
				top = (position.top + (position.height / 2) - (boxHeight / 2));
				left = ( direction == 'rtl' ) ? (position.left - boxWidth - arrowfarOption - arrowSize) : (position.left + position.width + arrowfarOption + arrowSize);
				poptip.offset({
					top: top,
					left: left
				});
			},
			boxWidth = poptip[0].offsetWidth,
			boxHeight = poptip[0].offsetHeight,
			arrowSize = arrowWidth(),
			position = elementPosition(),
			windowWidth, windowHeight, scrollTop, scrollLeft, top, left;
			
			poptip.removeClass('top bottom left right');
			arrow.removeClass('dark');
			
			if(placementOption == 'top'){
				topPlace();
			}
			if(placementOption == 'bottom'){
				bottomPlace();
			}
			if(placementOption == 'left'){
				leftPlace();
			}
			if(placementOption == 'right'){
				rightPlace();
			}
			if(placementOption == 'ver'){
				windowHeight = $(window).height();
				scrollTop = $(document).scrollTop();
				if( ( position.top - scrollTop ) > ( boxHeight + arrowfarOption + 10 ) ){
					topPlace();
				}
				else{
					bottomPlace();
				}
			}
			if(placementOption == 'hor'){
				windowWidth = $(window).width();
				scrollLeft = $(document).scrollLeft();
				if( (position.left - scrollLeft) < (windowWidth / 2) ){
					rightPlace();
				}
				else{
					leftPlace();
				}
			}
			if( !display ){
				poptip.hide();
			}
		},
		elementPosition = function(){
			var offset = element.offset(), position = {
				top: offset.top,
				left: offset.left,
				width: element[0].offsetWidth,
				height: element[0].offsetHeight
			};
			return position;
		},
		arrowWidth = function(){
			var border = function(align){
				return parseInt( arrow.css('border-'+align+'-width'), 10 ) || 0;
			};
			return Math.max( border('top'), border('bottom'), border('left'), border('right') );
		},
		setPadding = function(){
			box.css( 'padding', ( paddingOption > 0 ) ? paddingOption : 0 );
		},
		setContentSize = function(){
			var
			maxWidth = maxWidthOption,
			maxHeight = maxHeightOption,
			minWidth = minWidthOption,
			minHeight = minHeightOption,
			width,
			height,
			contentWidth,
			contentHeight;
			
			if( widthOption > 0 ){
				box.css('width', widthOption+'px');
			}
			else{
				contentWidth = box[0].offsetWidth;
				width = contentWidth;
				if( maxWidth > minWidth ){
					if( width > maxWidth ){
						width = maxWidth;
					}
					else if( width < minWidth ){
						width = minWidth;
					}
				}
				else{
					if( width > maxWidth ){
						width = maxWidth;
					}
				}
				
				if( width != contentWidth ){
					box.css('width', width+'px');
				}
			}
			
			if( heightOption > 0 ){
				box.css('height', heightOption+'px');
			}
			else{
				contentHeight = box[0].offsetHeight;
				height = contentHeight;
				if( maxHeight > minHeight ){
					if( height > maxHeight ){
						height = maxHeight;
					}
					else if( height < minHeight ){
						height = minHeight;
					}
				}
				else{
					if( height > maxHeight ){
						height = maxHeight;
					}
				}
				
				if( height != contentHeight ){
					box.css('height', height+'px');
				}
			}
		},
		setContent = function( content, callback ){
			var contentType = $.type(content);
			if( contentType === 'string' || contentType === 'number' || contentType === 'function' ){
				if( contentType === 'function' ){
					content = content.call( poptipData, element );
				}
				box.html( content );
				poptipData.inserted = true;
				dm.doCall( callback, poptipData, [element] );
				return poptipData;
			}
			
			if( jsonOption.url != '' ){
				if( jsonOption.cache && poptipData.inserted ){
					return poptipData;
				}
				
				box.html( contentOption != '' ? contentOption : 'Loading...' );
				dm.killAjax.abort( 'poptip' );
				$.ajax({
					type: 'post',
					url: jsonOption.url,
					data: jsonOption.data,
					dataType: 'json',
					cache: false,
					beforeSend: function( jqXHR ){
						dm.killAjax.add( jqXHR, 'poptip' );
						jsonOption.before.call( poptipData );
					},
					success: function( json, status, jqXHR ){
						if( $.type(json) === 'object' ){
							jsonOption.success.call( poptipData, json, status, jqXHR );
							poptipData.inserted = true;
						}
						else{
							jsonOption.error.call( poptipData, jqXHR );
						}
					},
					error: function( jqXHR ){
						jsonOption.error.call( poptipData, jqXHR );
					}
				});
			}
			else if( selectorOption != '' ){
				box.html( $(selectorOption).html() );
			}
			else{
				if( !poptipData.inserted ){
					box.html( contentOption );
				}
			}
			return poptipData;
		},
		getContent = function( callback ){
			dm.doCall( callback, poptipData, [element] );
			return box.html();
		},
		getValue = function( name, types ){
			option = options[name];
			if( $.type(option) === 'function' ){
				return option.call( element[0], options );
			}
			else{
				return dm.checkVar( option, types );
			}
		},
		destroy = function(){
			hide();
			poptip.remove();
			element.removeClass('poptip-created');
			element.removeAttr('poptip');
			element.removeData('poptip');
			return element;
		},
		
		// start options variables
		triggerOption = getValue( 'trigger', 'string' ),
		placementOption = getValue( 'placement', 'string' ),
		hoverOption = getValue('hover', 'boolean'),
		hideEmptyOption = getValue('hideEmpty', 'boolean'),
		arrowfarOption = getValue( 'arrowfar', 'number' ),
		paddingOption = getValue( 'padding', 'number' ),
		widthOption = getValue( 'width', 'number' ),
		heightOption = getValue( 'height', 'number' ),
		maxWidthOption = getValue( 'maxWidth', 'number' ),
		maxHeightOption = getValue( 'maxHeight', 'number' ),
		minWidthOption = getValue( 'minWidth', 'number' ),
		minHeightOption = getValue( 'minHeight', 'number' ),
		jsonOption = getValue( 'json', 'object' ),
		selectorOption = getValue( 'selector', ['object', 'string'] ),
		contentOption = getValue( 'content', 'string' ),
		// end options variables
		
		direction = element.css('direction'),
		
		visible = false,
		inserted = false,
		inElement = false,
		inPoptip = false,
		showT, hideT, poptip, box, arrow;

		if( oldData ){
			poptip = oldData.poptip;
			box = oldData.box;
			arrow = oldData.arrow;
			visible = oldData.visible;
			inserted = oldData.inserted;
			inElement = oldData.inElement;
			inPoptip = oldData.inPoptip;
			showT = oldData.showT;
			hideT = oldData.hideT;
		}
		else{
			poptip = $('<div class="poptip"><div class="arrow"></div><div class="poptip-frame"><div class="poptip-content"></div></div></div>');
			box = $('.poptip-content', poptip);
			arrow = $('.arrow', poptip);
		}
		
		var poptipData = {
			show: show,
			hide: hide,
			visible: visible,
			setPosition: setPosition,
			setContent: setContent,
			getContent: getContent,
			poptip: poptip,
			box: box,
			arrow: arrow,
			inserted: inserted,
			inElement: inElement,
			inPoptip: inPoptip,
			showT: showT,
			hideT: hideT,
			destroy: destroy,
			options: options
		};
		
		element.data('poptip', poptipData);
		
		// trigger = hover
		if( triggerOption == 'hover' ){
			element.off('mouseenter mouseleave');
			element.hover(
				function(){
					poptipData.showT = setTimeout(show, 200);
					clearTimeout( poptipData.hideT );
					poptipData.inElement = true;
				},
				function(){
					poptipData.hideT = setTimeout(function(){
						if( poptipData.inPoptip ){
							return;
						}
						else{
							hide();
							clearTimeout( poptipData.showT );
						}
					}, 100);
					poptipData.inElement = false;
				}
			);
			if( hoverOption === true ){
				poptip.off('mouseenter mouseleave');
				poptip.hover(
					function(){
						poptipData.inPoptip = true;
					},
					function(){
						poptipData.hideT = setTimeout(function(){
							if( poptipData.inElement ){
								return;
							}
							else{
								hide();
								clearTimeout( poptipData.showT );
							}
						}, 400);
						poptipData.inPoptip = false;
					}
				);
			}
		}

		poptip.resize(function(){
			if( element.data('poptip') ){
				element.data('poptip').setPosition();
			}
		});

		return poptipData;
	}, elements = $(this), optionsType = $.type(options), returnValue;
	
	if( elements.length == 0 ){
		return elements;
	}
	
	if( optionsType === 'array' ){
		var element, json_options = {}, json_content, vars, option, name, value;
		for( var x = 0; x < elements.length; x++ ){
			element = $(elements[x]);
			if( element.attr('poptip') ){
				json_content = unescape( element.attr('poptip') );
				if( json_content.indexOf('{') == 0 ){
					json_options = $.parseJSON( json_content );
				}
				else{
					json_content = json_content.split('||');
					json_options.content = json_content[0];
					if( $.type( json_content[1] ) === 'string' ){
						vars = json_content[1].split(';');
						for( var i = 0; i < vars.length; i++ ){
							option = vars[i].split(':');
							name = dm.checkVar( option[0], ['string'] );
							value = dm.checkVar( option[1], ['string'] );
							if( name.length > 0 ){
								json_options[name] = value;
							}
						}
					}
				}
				returnValue = _poptip( element, json_options );
			}
		}
		return returnValue;
	}
	else if( optionsType === 'function' ){
		var element, getOptions;
		for( var x = 0; x < elements.length; x++ ){
			element = $(elements[x]);
			getOptions = options.call( element );
			if( $.type(getOptions) === 'object' ){
				returnValue = _poptip( element, getOptions );
			}
			else if( $.type(getOptions) === 'string' ){
				returnValue = _poptip( element, {
					content: getOptions
				});
			}
			else{
				returnValue = _poptip( element );
			}
		}
		return returnValue;
	}
	else if( optionsType === 'object' ){
		for( var x = 0; x < elements.length; x++ ){
			returnValue = _poptip( $(elements[x]), options );
		}
		return returnValue;
	}
	else if( optionsType === 'string' ){
		for( var x = 0; x < elements.length; x++ ){
			returnValue = _poptip( $(elements[x]), {
				content: options
			});
		}
		return returnValue;
	}
	else if( optionsType === 'undefined' ){
		for( var x = 0; x < elements.length; x++ ){
			returnValue = _poptip( $(elements[x]) );
		}
		return returnValue;
	}
	else{
		return elements;
	}
};
/***
 .modal used for show content in the dialog box.
 $( selector ).modal( [options] );
***/
$.fn.modal = function( options ){
	var _modal = function(element){
		// merge options and json options and default options
		var defaults = {					// approval contents					| data type 		| default	| information
			name: 'modal',					// a - z								| string			| 'modal'	| name of the modal
			padding: 6,						// 0 to infinity						| int 				| 6			| padding for box content
			width: 0,						// 30 to maxwidth option				| int 				| 0			| modal width, 0 = auto
			height: 0,						// 30 to maxheight option				| int 				| 0			| modal height, 0 = auto
			maxwidth: 950,					// 30 to infinity						| int 				| 950		| modal max width, if set width the width become max width
			maxheight: 400,					// 30 to infinity						| int 				| 400		| modal max height, if set height the height become max height
			minwidth: 30,					// 30 to maxwidth option				| int 				| 30		| modal min width, if set width the width become min width
			minheight: 30,					// 30 to maxheight option				| int 				| 30		| modal min height, if set height the height become min height
			zindex: 0,						// 0 to infinity						| int 				| 0			| z-index of box
			scroll: 'both',					// none ver hor both					| string			| 'both'	| set scroll for the modal
			close: false,					// true false							| boolean			| false		| show close button in header
			outClose: false,				// true false							| boolean			| false		| when click out area of modal close the modal
			datacatch: true,				// true false							| boolean			| true		| if datacatch = true then content will set one-time, if datacatch = false then content will set every call show()
			keyScroll: false,				// true false							| boolean			| false		| when use dwon key or up key for scrolling
			highlight: false,				// true false							| boolean			| true		| show or hide highlight
			classes: [],					// an array of classes names			| array				| []		| all classes will be added to content box
			attrs: {},						// an object of attributes				| object			| {}		| all attributes will be added to content box
			styles: {},						// an object of css style				| object			| {}		| all css style will be added to content box
			delay: {'start':250,'end':150}, // 0 to infinity						| double			| 250,150	| duration of start and end in the millisecond of the modal
			url: '',						// ajax url								| string			| ''		| url for ajax operation with get method
			vars: {},						// ajax data							| object			| {}		| vars for ajax operation with post method
			json: {
				url: '',
				data: {},
				before: function(){},
				success: function(){},
				error: function(){},
				complete: function(){}
			},
			selector: '',					// jquery selector						| string, object	| ''		| for get innerHTML from jquery selector
			content: '',					// any thing							| string			| ''		| content of the modal
			header: '',						// any thing							| string			| ''		| header of the modal, if header is empty will not show
			footer: '',						// any thing							| string			| ''		| footer of the modal, if footer is empty will not show
			footerAlign: '',
			buttons: [],					// buttons								| array				| []		| buttons in the footer
			onClose: function(){}
			/***
			
			//you can use callback function for all options, for example:-
			$( selector ).modal({
				width: function(){
					return 300;
				},
				...
			});
			
			//to add buttons to the footer:
			buttons: [
				{
					name: 'button_name',
					icon: 'icon-ok',
					classes: ['btn-cblue', 'btn-cgold', 'btn-cmaroon', 'btn-cgreen', 'btn-cskyblue', 'btn-cblack'],
					value: 'button value',
					click: function( event, element ){
					
					}
				}
			]
			
			//for use modal data:
			element.data('modal').content.html('box content');
			element.data('modal').header.html('header content');
			element.data('modal').footer.html('footer content');
			element.data('modal').buttons['buttonName'].addClass('disabled');
			
			***/
		},
		show = function(){
			modal.show();
			setPadding();
			setContents();
			setScrollbar();
			var position = getPosition();
			modal.css({
				'left': position.left+'px',
				'top': position.top+'px',
				'opacity': '0'
			}).animate({
				'opacity': '1'
			}, delayOption.start, function(){
				data.display = true;
				setPosition();
			});
			doHighlight(true);
		},
		shown = function(){
			return data.display;
		},
		hide = function(){
			modal.animate({
				'opacity': '0'
			}, delayOption.end, function(){
				data.display = false;
				modal.hide();
			});
			doHighlight(false);
			onCloseOption.call( contentBox );
		},
		hidden = function(){
			return !data.display;
		},
		getPosition = function( onscroll ){
			setContentSize();
			
			var
			top = 0,
			left = 0,
			height = $(window).height(),
			width = $(window).width(),
			scrollTop = $(document).scrollTop(),
			scrollLeft = $(document).scrollLeft(),
			lastScrollTop, lastScrollLeft, boxHeight, boxWidth, diffScroll, diffSize, boxTop, boxLeft,
			shown = ( modal.css('display') != 'none' ) ? true : false;
			
			onscroll = ( onscroll === true ) ? true : false;
			
			modal.show();
			boxHeight = modal.prop('offsetHeight');
			boxWidth = modal.prop('offsetWidth');
			if( !shown ){
				modal.hide();
			}
			
			lastScrollTop = modal.prop('lastScrollTop') ? dm.parseInt( modal.prop('lastScrollTop') ) : scrollTop;
			lastScrollLeft = modal.prop('lastScrollLeft') ? dm.parseInt( modal.prop('lastScrollLeft') ) : scrollLeft;
			modal.prop( 'lastScrollTop', scrollTop );
			modal.prop( 'lastScrollLeft', scrollLeft );
			
			top = Math.ceil( (height - boxHeight) / 3 );
			left = Math.ceil( (width - boxWidth) / 2 );
			
			// check scroll top
			if( boxHeight > height ){
				if( scrollTop > lastScrollTop ){ // scroll down
				
					diffScroll = ( scrollTop - lastScrollTop );
					diffSize = ( boxHeight - height );
					boxTop = dm.parseInt( modal.css('top') );

					if( diffScroll > diffSize ){
						top = -diffSize;
					}
					else{
						top = ( boxTop - diffScroll );
						if( top < -diffSize ){
							top = -diffSize;
						}
						else{
							if( top > 0 ){
								top = 0;
							}
						}
					}
				}
				else if( scrollTop < lastScrollTop ){ // scroll up
				
					diffScroll = ( lastScrollTop - scrollTop );
					diffSize = ( boxHeight - height );
					boxTop = dm.parseInt( modal.css('top') );

					if( diffScroll > diffSize ){
						top = 0;
					}
					else{
						top = ( boxTop + diffScroll );
						if( top > 0 ){
							top = 0;
						}
					}
				}
				else{
					top = onscroll ? boxTop : 0;
				}
			}
			else{
				if( top < 0 ) top = 0;
			}
			
			// check scroll left
			if( boxWidth > width ){
				if( scrollLeft > lastScrollLeft ){ // scroll right
				
					diffScroll = ( scrollLeft - lastScrollLeft );
					diffSize = ( boxWidth - width );
					boxLeft = dm.parseInt( modal.css('left') );

					if( diffScroll > diffSize ){
						left = -diffSize;
					}
					else{
						left = ( boxLeft - diffScroll );
						if( left < -diffSize ){
							left = -diffSize;
						}
						else{
							if( left > 0 ){
								left = 0;
							}
						}
					}
				}
				else if( scrollLeft < lastScrollLeft ){ // scroll left
				
					diffScroll = ( lastScrollLeft - scrollLeft );
					diffSize = ( boxWidth - width );
					boxLeft = dm.parseInt( modal.css('left') );

					if( diffScroll > diffSize ){
						left = 0;
					}
					else{
						left = ( boxLeft + diffScroll );
						if( left > 0 ){
							left = 0;
						}
					}
				}
				else{
					left = onscroll ? boxLeft : 0 ;
				}
			}
			else{
				if( left < 0 ) left = 0;
			}

 			$('.xxxtop').html( top );
			$('.xxxbtop').html( boxTop );
			$('.xxxscroll').html( scrollTop );
			$('.xxxlscroll').html( lastScrollTop );
			$('.xxxwsize').html( height );
			$('.xxxbsize').html( boxHeight );
			
			$('.xxxvals').css('color', 'red');
			$('.xxxvars > div').css('display', 'table-row');
			$('.xxxvars > div > div').css('display', 'table-cell');
			
			highlight.css({
				'width': dm.getDocumentSize('width')+'px',
				'height': dm.getDocumentSize('height')+'px'
			});
			
			return {'top': top, 'left': left};
		},
		setPosition = function( onscroll ){
 			if( !data.display ){
				return;
			}
			var position = getPosition( onscroll );
 			modal.css({
				'top': position.top+'px',
				'left': position.left+'px'
			});
		},
		doHighlight = function( showHighlight ){
			if( highlightOption === true ){
				if( showHighlight === true ){
					highlight.css({
						'opacity': '0',
						'width': dm.getDocumentSize('width')+'px',
						'height': dm.getDocumentSize('height')+'px'
					}).show().animate({
						'opacity': '0.5'
					}, delayOption.start);
				}
				else{
					highlight.animate({
						'opacity': '0'
					}, delayOption.end, function(){
						$(this).hide();
					});
				}
			}
		},
		setPadding = function(){
			var padding, topPadding, bottomPadding, width,
			pixel = function(size){
				return ( size > 0 ) ? size+'px' : '0';
			};
			padding = ( paddingOption > 0 ) ? paddingOption : 0;
			contentBox.css('padding', pixel(padding));
		},
		setContentSize = function(){
			var contentWidth, contentHeight;
			
			contentBox.css({
				'max-width': maxwidthOption+'px',
				'min-width': minwidthOption+'px',
				'max-height': maxheightOption+'px',
				'min-height': minheightOption+'px'
			});
			
			if( widthOption > 0 ){
				if( widthOption > minwidthOption ){
					contentBox.css('width', widthOption+'px');
				}
				contentWidth = contentBox[0].offsetWidth;
				if( contentWidth > maxwidthOption ){
					contentBox.css('width', maxwidthOption+'px');
				}
			}
			if( heightOption > 0 ){
				if( heightOption > minheightOption ){
					contentBox.css('height', heightOption+'px');
				}
				contentHeight = contentBox[0].offsetHeight;
				if( contentHeight > maxheightOption ){
					contentBox.css('height', maxheightOption+'px');
				}
			}
		},
		setScrollbar = function(){
			var both, x, y;
			if( scrollOption == 'none' ){
				return;
			}
			else{
				if( scrollOption == 'ver' ){
					both = 'auto';
					x = 'hidden';
					y = 'overlay';
				}
				else if( scrollOption == 'hor' ){
					both = 'auto';
					x = 'overlay';
					y = 'hidden';
				}
				else if( scrollOption == 'both' ){
					both = 'overlay';
					x = 'auto';
					y = 'auto';
				}
				contentBox.css({
					'overflow': both,
					'overflow-x': x,
					'overflow-y': y
				});
			}
		},
		setContents = function(){
			// set box content
			if(urlOption != ''){
				contentBox.html( (contentOption != '') ? contentOption : 'Loading...' );
				$.ajax({
					type: 'post',
					url: urlOption+(urlOption.indexOf('?') ? '&' : '?')+'x='+Math.random(),
					data: varsOption,
					success: function(result){
						contentBox.html( result );
						$.modalAlways.call(element, modal);
					},
					error: function(){
						contentBox.html( '<span style="color:red;">Loading Error.</span>' );
					}
				});
			}
			else if(selectorOption != ''){
				contentBox.html( $(selectorOption).html() );
				$.modalAlways.call(element, modal);
			}
			else if( jsonOption.url != '' ){
				dm.killAjax.abort( 'actions' );
				$.ajax({
					type: 'post',
					url: jsonOption.url,
					data: jsonOption.data,
					dataType: 'json',
					cache: false,
					beforeSend: function( jqXHR ){
						dm.killAjax.add( jqXHR, 'actions' );
						if( jsonOption.before ){
							jsonOption.before.call( contentBox );
						}
					},
					success: function( json, status, jqXHR ){
						if( $.type(json) === 'object' ){
							jsonOption.success.call( contentBox, json, status, jqXHR );
							$.modalAlways.call(element, modal);
						}
						else{
							if( jsonOption.error ){
								jsonOption.error.call( contentBox, jqXHR );
							}
						}
					},
					error: function( jqXHR ){
						if( jsonOption.error ){
							jsonOption.error.call( contentBox, jqXHR );
						}
					},
					complete: function( jqXHR ){
						if( jsonOption.complete ){
							jsonOption.complete.call( contentBox, jqXHR );
						}
					}
				});
			}
			else{
				contentBox.html( contentOption );
				$.modalAlways.call(element, modal);
			}
			
			// set header content
			if( headerOption != '' || closeOption === true ){
				$('span', headerBox).html( headerOption+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' );
				if( closeOption === true ){
					headerBox.append('<i class="icon-times close-modal"></i>');
				}
				headerBox.show();
				if( closeOption === true ){
					$('.close-modal', headerBox).on('click', function(){
						hide();
					});
				}
				$.modalAlways.call(element, modal);
			}
			else{
				headerBox.hide();
			}
			
			// set footer content
			if( footerOption != '' || buttonsOption.length > 0 ){
				$('span', footerBox).html( footerOption );
				if( buttonsOption.length > 0 ){
					if( $('> div', footerBox).length == 0 ){
						footerBox.append('<div></div>');
					}
					
					$('> div', footerBox).children().remove();

					var classes = '', icon = '', button, buttonElement;
					for( var x = 0; x < buttonsOption.length; x++ ){
						button = buttonsOption[x];
						if( $.type(button) !== 'object' ){
							continue;
						}
						
						button.name = dm.checkVar( button.name, ['string'] );
						button.icon = dm.checkVar( button.icon, ['string'] );
						button.classes = dm.checkVar( button.classes, ['array'] );
						button.value = dm.checkVar( button.value, ['string'] );
						button.focus = dm.checkVar( button.focus, ['boolean'], false );
						button.click = dm.checkVar( button.click, ['function'], false );
						
						if( button.name.length == 0 ){
							continue;
						}
						
						if( button.classes.length > 0 ){
							classes = ' '+button.classes.join(' ');
						}
						
						if( button.icon.length > 0 ){
							icon = '<i class="'+button.icon+'"></i> ';
						}
						
						$('> div', footerBox).append('<a class="btn'+classes+'" href="#" bname="'+button.name+'">'+icon+''+button.value+'</a>');
						button.element = $('> div > a[bname="'+button.name+'"]', footerBox);
						
						if( button.focus === true ){
							button.element.focus();
						}
						
						footerButtons[button.name] = button;
						
						if( button.click !== false ){
							button.element.on('click', function( event ){
								var bname = $(this).attr('bname') || '', button = footerButtons[bname] || function(){};
								return button.click.call( this, event, element );
							});
						}
					}
					
					$('> div', footerBox).css('line-height', '28px');
					$('> span', footerBox).css('line-height', '21px');
					
					if( footerOption == '' ){
						$('span', footerBox).html('&nbsp;');
					}
				}
				else{
					$('> span', footerBox).css('line-height', '13px');
				}
				footerBox.show();
				$.modalAlways.call(element, modal);
			}
			else{
				footerBox.hide();
			}
		},
		getValue = function( name, datatype ){
			name = options[name];
			datatype = ( $.type(datatype) == 'array' ) ? datatype : [datatype];
			if( $.type(name) === 'function' ){
				return name.call( element[0] );
			}
			else if( $.inArray(  $.type(name), datatype ) >= 0 ){
				return name;
			}
			else{
				return '';
			}
		}, json_options = ( element.attr('modal') ) ? $.parseJSON( unescape( element.attr('modal') ) ) : {}, data = element.data('modal'),
		modal, highlight, name = '';

		defaults = $.extend( true, defaults, json_options );
		options = ( $.type(options) === 'object' ) ? options : {};

		if( data ){
			modal = data.modal;
			highlight = data.highlight;
			name = ( options.name !== '' ) ? options.name : 'modal';
			defaults = $.extend( true, defaults, data.options[options.name] || {} );
			options = $.extend( true, defaults, options );
		}
		else{
			modal = $( '<div class="modal"'+( zindexOption > 0 ? ' style="z-index:'+zindexOption+';"' : '' )+'><div><div class="modal-header"><span></span></div><div class="modal-content"></div><div class="modal-footer clearfix"><span></span></div></div></div>' );
			modal.css({
				'top': '-500px',
				'left': '50px'
			}).appendTo(document.body);
			highlight = $( '<span class="modal-highlight"></span>' );
			highlight.appendTo(document.body);
			options = $.extend( true, defaults, options );
			data = {};
			data.modal = modal;
			data.highlight = highlight;
			data.display = false;
			data.options = [];
			data.content = {};
			data.header = {};
			data.footer = {};
			data.buttons = [];
		}

		// options variables
		var contentBox, headerBox, footerBox, footerButtons = [],
		paddingOption = getValue('padding', 'number'),
		widthOption = getValue('width', 'number'),
		heightOption = getValue('height', 'number'),
		maxwidthOption = getValue('maxwidth', 'number'),
		maxheightOption = getValue('maxheight', 'number'),
		minwidthOption = getValue('minwidth', 'number'),
		minheightOption = getValue('minheight', 'number'),
		zindexOption = getValue('zindex', 'number'),
		scrollOption = getValue('scroll', 'string'),
		closeOption = getValue('close', 'boolean'),
		outCloseOption = getValue('outClose', 'boolean'),
		datacatchOption = getValue('datacatch', 'boolean'),
		keyScrollOption = getValue('keyScroll', 'boolean'),
		highlightOption = getValue('highlight', 'boolean'),
		classesOption = getValue('classes', 'array'),
		attrsOption = getValue('attrs', 'object'),
		stylesOption = getValue('styles', 'object'),
		delayOption = getValue('delay', 'object'),
		urlOption = getValue('url', 'string'),
		varsOption = getValue('vars', 'object'),
		selectorOption = getValue('selector', ['object', 'string']),
		jsonOption = getValue('json', ['object']),
		contentOption = getValue('content', 'string'),
		headerOption = getValue('header', 'string'),
		footerOption = getValue('footer', 'string'),
		footerAlignOption = getValue('footerAlign', 'string'),
		buttonsOption = getValue('buttons', 'array'),
		onCloseOption = dm.checkVar( options.onClose, ['function'], function(){} );
		
		delayOption = $.extend(true, {'start':800,'end':500}, delayOption || {});
		contentBox = $('.modal-content', modal);
		headerBox = $('.modal-header', modal);
		footerBox = $('.modal-footer', modal);

		if( footerAlignOption != '' ){
			footerBox.css('text-align', footerAlignOption);
		}

		// add classes option
		(function( box ){
			for( var i = 0; i < classesOption.length; i++ ){
				let name = classesOption[i].toString().trim();
				if( name.length > 0 ){
					box.addClass(name);
				}
			}
		})( contentBox );

		// add attrs options
		(function( box ){
			for( let [name, value] of Object.entries(attrsOption) ){
				name = name.toString().trim();
				if( name.length > 0 ){
					box.attr(name, value);
				}
			}
		})( contentBox );

		// add style options
		(function( box ){
			for( let [name, value] of Object.entries(stylesOption) ){
				name = name.toString().trim();
				value = value.toString().trim();
				if( name.length > 0 && value.length > 0 ){
					if( value.indexOf("!important") >= 0 ){
						value = value.replace('!important', '').trim();
						box.cssImportant(name, value);
					}
					else{
						box.css(name, value);
					}
				}
			}
		})( contentBox );
		
		data.show = show;
		data.shown = shown;
		data.hide = hide;
		data.hidden = hidden;
		data.options[options.name] = options;
		data.content = contentBox;
		data.header = $('span', headerBox);
		data.footer = $('span', footerBox);
		data.buttons = footerButtons;
		element.data('modal', data);
		
		dm.viewport.resetScale();
		
		if( outCloseOption === true ){
			highlight.on('click', function(){
				hide();
			});
		}
		
		// when resize window will set new position
		$(window).resize(function(){
			setPosition();
		});
		
		// when resize modal content will set new position
  		$(modal).resize(function(){
			setPosition();
		});
		
		// when scroll used will set new position
		$(document).scroll(function(){
			setPosition( true );
		});
		
 		$(document.body).on('keydown', function( event ){
			if( keyScrollOption === false || data.display === false ){
				return;
			}
			if( event.which == 38 ){ // Arrow up key
				contentBox.scrollTo( '-=30px', { axis:'y' } );
				return false;
			}
			if( event.which == 40 ){ // Arrow down key
				contentBox.scrollTo( '+=30px', { axis:'y' } );
				return false;
			}
		});
		

	},
	_prepare = function(element){
		var data = element.data('modal'), events = ['show', 'hide', 'shown', 'hidden'];
		if($.type(options) === 'object' || $.type(options) === 'undefined'){
			_modal(element);
		}
		else if( $.type(options) === 'string' && $.inArray(options, events) >= 0 && data ){
			return data[options]();
		}
	}, elements = $(this), returnValue;
	
	// check always function
	if( $.type($.modalAlways) !== 'function' ){
		$.modalAlways = function(){};
	}
	if( $.type(options) === 'function' ){
		$.modalAlways = options;
		return elements;
	}
	
	// set modal to selector elements
	for(var x = 0; x < elements.length; x++){
		returnValue = _prepare( $(elements[x]) );
	}
	
	// return selector elements if returnValue is undefined
	return ( $.type(returnValue) === 'undefined' ) ? elements : returnValue;
};

/***
 .textInfo used for form messages in the footer.
 $( selector ).textInfo( text, color );
***/
$.fn.textInfo = function( text, color ){
	var _textInfo = function( element, text, color ){
		var colors = ['white', 'silver', 'gray', 'dark', 'cskyblue', 'cgold', 'cmaroon', 'delete', 'cgreen', 'cyellow'], removeClasses = [], addClasses = '';
		color = color || '';
		for( var x = 0; x < colors.length; x++ ){
			removeClasses[removeClasses.length] = 'text-'+colors[x];
		}
		removeClasses[removeClasses.length] = 'text';
		removeClasses = removeClasses.join(' ');
		addClasses = ( $.inArray( color, colors ) >= 0 ) ? 'text-'+color : color;
		element.html( text ).parent().removeClass( removeClasses ).addClass( addClasses );
	}, elements = $(this);
	for( var x = 0; x < elements.length; x++ ){
		_textInfo( $(elements[x]), text, color );
	}
};

/***
 .selectList to make custom select.
 $( selector ).selectList( [refresh] );
***/
$.fn.selectList = function( refresh ){
	var _selectList = function( element, refresh ){
		if( refresh === true ){
			$.removeData( element[0], 'select-list' );
		}
		if( element.data('select-list') ){
			return;
		}
		var arrowIconName = 'icon-caret-down',
		selectValue = element.attr('slvalue') || '',
		anypart = dm.parseInt( element.attr('anypart') ),
		anyvalue = dm.parseInt( element.attr('anyvalue') ),
		focusall = dm.parseInt( element.attr('focusall') ),
		disabled = dm.parseInt( element.attr('sdisabled') ),
		ajax = element.attr('ajax') || '',
		slajax = dm.parseInt( element.attr('slajax') ),
		blankOption = element.attr('blank') || '',
		panalDisplay = false,
		overPanel = false,
		focusDisplay = false,
		entered = false,
		doKeyUp = false,
		tabIndex = '',
		placeHolder = '',
		input,
		arrow,
		show = function( arrowClicked, focused ){
			if( input.prop('disabled') === true || input.prop('readonly') === true || $('> div > div', element).length == 0 ){
				return;
			}
			$('> div', element).show();
			panalDisplay = true;
			checkText( arrowClicked, focused );
			$('> div > div', element).removeClass('active');
		},
		hide = function( status ){
			$('> div', element).hide();
			panalDisplay = false;
		},
		checkText = function( arrowClicked, focused ){
			var value = input.val().search().toLowerCase(), options = $('> div > div', element), stext = '', option;
			arrowClicked = ( arrowClicked === true ) ? true : false;
			focused = ( focused === true ) ? true : false;
			let evalue = element.attr('slvalue') || false;
			options.removeClass('selected');
			if( evalue !== false ){
				$('> div > div[value="'+evalue+'"]', element).addClass('selected');
			}
 			if( arrowClicked || value.length == 0 || value == blankOption || focusall == 1 && focused ){
				options.show();
				return;
			}
			for( var x = 0, y = 0; x < options.length; x++ ){
				option = $( options[x] );
				if( option.attr('stext') ){
					stext = option.attr('stext') || '';
				}
				else{
					stext = getOptionText( option ).search();
				}
				
				stext = stext.toLowerCase();
				
				if( anypart == 1 ){
					if( stext.indexOf(value) >= 0 ){
						option.show();
						y++;
					}
					else{
						option.hide();
					}
				}
				else{
					stext = stext.substring( 0, value.length );
					if( value == stext ){
						option.show();
						y++;
					}
					else{
						option.hide();
					}
				}
			}
			if( y == 0 ){
				if( anyvalue == 1 ){
					element.attr( 'slvalue', input.val() );
					element.trigger( 'slchange', [input.val()] );
				}
				else{
					element.attr( 'slvalue', '' );
					element.trigger( 'slchange', [''] );
				}
				hide();
			}
		},
		selectedText = function( _selectValue, undefined ){
			var options = $('> div > div', element), option, value = '';

			for( var x = 0; x < options.length; x++ ){
				option = $( options[x] );
				value = option.attr('code') ? option.attr('code') : ( option.attr('value') || '' );
				if( value == selectValue && option.text() != blankOption ){
					return getOptionText( option );
				}
			}
			
			if( anyvalue == 1 ){
				return ( _selectValue !== undefined ) ? _selectValue : input.val();
			}
			
			return '';
		},
		setValue = function( value ){
			selectValue = value;
			element.attr( 'slvalue', value );
			input.val( selectedText() );
		},
		getOptionText = function( option ){
			return option.attr('text') || '';
		},
		arrowActive = function( arrow, element ){
			var activeElement = $('> div > div.active', element),
			availableElements = $('> div > div', element).filter(function(){
				return $(this).css('display') != 'none';
			});
			if( activeElement.length > 0 ){
				if( arrow == 'down' ){
					for( var x = 0, y = 0; x < availableElements.length; x++ ){
						if( y == 1 ){
							activeElement.removeClass('active');
							$(availableElements[x]).addClass('active');
							$('> div', element).scrollTo( $(availableElements[x]), { duration:1, axis:'y'});
							return;
						}
						if( activeElement[0] == availableElements[x] ){
							y = 1;
						}
					}
				}
				else{
					for( var x = availableElements.length, y = 0; x >= 0; x-- ){
						if( y == 1 ){
							activeElement.removeClass('active');
							$(availableElements[x]).addClass('active');
							$('> div', element).scrollTo( $(availableElements[x]), { duration:1, axis:'y'});
							return;
						}
						if( activeElement[0] == availableElements[x] ){
							y = 1;
						}
					}
				}
			}
			else{
				if( arrow == 'down' ){
					$( availableElements.get(0) ).addClass('active');
				}
			}
		},
		reloadChild = function( element ){
			var children = element.attr('children') || '', value = element.attr('slvalue') || '', children_data, name, selector, onlyin, gettexts;
			if( children != '' ){
				children = children.split(';');
				for( var x = 0; x < children.length; x++ ){
					children_data = children[x].split(':');
					name = children_data[0];
					selector = children_data[1];
					level = children_data[2] ? dm.parseInt(children_data[2]) : -1; // this option is useful for multiple parents with multiple children with the same name
					if( name != '' && selector != '' ){
						if( level >= 0 ){
							if( level = 0 ){
								selector = $( selector, element.parent() );
							}
							else if( level = 1 ){
								selector = $( selector, element.parent().parent() );
							}
							else if( level = 2 ){
								selector = $( selector, element.parent().parent().parent() );
							}
							else if( level = 3 ){
								selector = $( selector, element.parent().parent().parent().parent() );
							}
							else if( level = 4 ){
								selector = $( selector, element.parent().parent().parent().parent().parent() );
							}
						}
						else{
							selector = $(selector);
						}
						if( selector.length > 0 ){
							selector.attr('parent', value);
							onlyin = selector.attr('onlyin') || '';
							gettexts = selector.attr('gettexts') || '';
							$.ajax({
								type: 'post',
								url: 'ajax.php?type=lists_get_vars&x='+dm.rand(),
								data: {
									name: name,
									parent: value,
									ischild: 1,
									onlyin: onlyin,
									gettexts: gettexts
								},
								dataType: 'json',
								cache: false,
								selector: selector,
								beforeSend: function( jqXHR ){
									selector = this.selector;
									$('> i.drop-dwon-arrow', selector).removeClass(arrowIconName).addClass('icons-spinner icon-spin').cssImportant(dm.vars.disalign, ( element.next().length > 0 ? '-1px' : '0' )).css({'font-size': '16px', 'top': '4px'});
								},
								success: function( json ){
									selector = this.selector;
									if( $.type(json) !== 'object' ){
										ajaxLodingError('error in json object');
										return;
									}

									json.status = dm.checkVar( json.status, ['string'] );
									if( json.status == 'success' ){
										$('> div > div ', selector).remove();
										if( json.rows && json.rows.length > 0 ){
											var code = '', texts = '', attrs = '';
											for( var x = 0; x < json.rows.length; x++ ){
												attrs = '';
												if( json.rows[x][3] != '' ){
													code = ' code="'+json.rows[x][3]+'"';
												}
												texts = dm.checkVar( json.rows[x][5], ['object'] );
												for( var n = 1; n <= 3; n++ ){
													texts[n] && ( attrs += ' text'+n+'="'+texts[n]+'"' );
												}
												$('<div value="'+json.rows[x][0]+'" text="'+json.rows[x][1]+'" stext="'+json.rows[x][2]+'"'+code+''+attrs+'>'+json.rows[x][4]+'</div>').appendTo( $('> div ', selector) );
											}
										}
										selector.attr('slvalue', '');
										selector.selectList(true);
										$('> i.drop-dwon-arrow', selector).removeClass('icons-spinner icon-spin').addClass(arrowIconName).cssImportant(dm.vars.disalign, arrow.attr('x')+'px').css({'font-size': '22px', 'top': '1px'});
									}
									else{
										ajaxLodingError('error in json status');
									}
								},
								error: function(){
									ajaxLodingError('error in connection');
								}
							});
						}
					}
				}
			}
		},
		reloadList = function( element ){ // to reload list press CTRL + Enter
			var
			name = element.attr('slname') || '',
			value = element.attr('slvalue') || '',
			parent = element.attr('parent') || '',
			ischild = dm.parseInt( element.attr('ischild') ),
			onlyin = element.attr('onlyin') || '',
			gettexts = element.attr('gettexts') || '';
			
			if( name == '' ){ // only reload defined lists
				return;
			}
			
			$.ajax({
				type: 'post',
				url: 'ajax.php?type=lists_get_vars&x='+dm.rand(),
				data: {
					name: name,
					parent: parent,
					ischild: ischild,
					onlyin: onlyin,
					gettexts: gettexts
				},
				dataType: 'json',
				cache: false,
				beforeSend: function( jqXHR ){
					$('> i.drop-dwon-arrow', element).removeClass(arrowIconName).addClass('icons-spinner icon-spin').cssImportant(dm.vars.disalign, ( element.next().length > 0 ? '-1px' : '0' )).css({'font-size': '16px', 'top': '4px'});
				},
				complete: function(){
					element.data('select-list').input.focus();
				},
				success: function( json ){
					if( $.type(json) !== 'object' ){
						ajaxLodingError('error in json object');
						return;
					}

					json.status = dm.checkVar( json.status, ['string'] );
					if( json.status == 'success' ){
						$('> div > div ', element).remove();
						if( json.rows && json.rows.length > 0 ){
							var code = '', texts = '', attrs = '';
							for( var x = 0; x < json.rows.length; x++ ){
								attrs = '';
								if( json.rows[x][3] != '' ){
									code = ' code="'+json.rows[x][3]+'"';
								}
								texts = dm.checkVar( json.rows[x][5], ['object'] );
								for( var n = 1; n <= 3; n++ ){
									texts[n] && ( attrs += ' text'+n+'="'+texts[n]+'"' );
								}
								$('<div value="'+json.rows[x][0]+'" text="'+json.rows[x][1]+'" stext="'+json.rows[x][2]+'"'+code+''+attrs+'>'+json.rows[x][4]+'</div>').appendTo( $('> div ', element) );
							}
						}
						element.attr('slvalue', value);
						element.removeAttr('sdisabled');
						element.selectList(true);
						$('> i.drop-dwon-arrow', element).removeClass('icons-spinner icon-spin').addClass(arrowIconName).cssImportant(dm.vars.disalign, arrow.attr('x')+'px').css({'font-size': '22px', 'top': '1px'});
					}
					else{
						ajaxLodingError('error in json status');
					}
				},
				error: function(){
					ajaxLodingError('error in connection');
				}
			});
		},
		ajaxLodingError = function( error ){
			if( window.console && window.console.log ){
				window.console.log( 'select list error is ('+error+')' );
			}
		};
		
		if( refresh !== true ){
			if( element.attr('tabselect') ){
				tabIndex = ' tabindex="'+element.attr('tabselect')+'"';
			}
			if( element.attr('holder') ){
				placeHolder = ' placeholder="'+element.attr('holder')+'"';
			}
			$('<input type="search" style="width:'+( dm.parseInt(element.css('width')) )+'px;" autocomplete="off"'+tabIndex+placeHolder+'>').insertBefore( $('> div', element) );
			$('<i class="'+arrowIconName+' drop-dwon-arrow"></i>').insertBefore( $('> div', element) );
			$('<span></span>').insertBefore( $('> div', element) );
			
		}
		
		input = $('> input', element);
		input.val( selectedText( selectValue ) );
		arrow = $('> i.drop-dwon-arrow', element);
		arrow.attr( 'x', dm.parseInt( arrow.css(dm.vars.disalign) ) );
		$('> div', element).css('min-width', ( dm.parseInt( input.css('width') ) )+'px');
		if( element.attr('ischild') && $('> div > div', element).length == 0 ){
			element.attr( 'slvalue', '');
			element.trigger( 'slchange', [''] );
		}
		if( disabled == 1 ){
			input.prop('readonly', true);
		}
		
		if( refresh !== true ){
			input.on('keydown', function( event ){
				if( event.which == 9 ){ // Tab key
					if( focusDisplay === true ){
						hide();
						focusDisplay = false;
					}
					return;
				}
				if( event.which == 38 ){ // Arrow up key
					arrowActive( 'up', element );
					return;
				}
				if( event.which == 40 ){ // Arrow down key
					arrowActive( 'down', element );
					return;
				}
				if( event.which == 13 ){ // Enter key
				
					var ctrl = ( document.all || document.getElementById ) ? ( event.ctrlKey ? true : false ) : ( document.layers ? ( event.modifiers & Event.CONTROL_MASK ? true : false ) : false );
					
					 // if pressed CTRL + Enter will reloading list
					if( ctrl == true ){
						reloadList(element);
					}
					else{
						var active = $('> div > div.active[value]', element);
						
						if( active.length == 0 ){
							active = $('> div > div[value]', element).filter(function(){
								return $(this).css('display') == 'block';
							});
							if( active.length > 0 ){
								active = $(active[0]);
							}
						}
						
						if( active.length > 0 ){
							input.val( getOptionText( active ) );
							element.attr( 'slvalue', active.attr('code') ? active.attr('code') : (active.attr('value') || '') );
							element.trigger( 'slchange', [element.attr('slvalue')] );
							reloadChild( element );
							entered = true;
							hide();
							return false;
						}
					}
				}
				doKeyUp = true;
			});
			input.on('keyup', function( event ){
				if( doKeyUp === false ){
					return;
				}
				
				if( ajax.length > 0 ){

					var ajaxdata = {
						name: ajax,
						text: input.val(),
						anypart: anypart,
						slajax: slajax,
						gettexts: ( element.attr('gettexts') || '' )
					},
					ajaxvars = element.attr('ajaxvars') || '';
					if( ajaxvars.length > 0 ){
						ajaxdata.vars = ajaxvars;
					}
					if( element.attr('parent') ){
						ajaxdata.parent = element.attr('parent');
					}
					
					dm.callSearch(function(){
						$.ajax({
							type: 'post',
							url: 'ajax.php?type=select_list_initialize&x='+dm.rand(),
							data: ajaxdata,
							dataType: 'json',
							cache: false,
							beforeSend: function( jqXHR ){
								hide();
								$('> div > div', element).remove();
								if( input.val().trim().length == 0 ){
									return false;
								}
								arrow.removeClass(arrowIconName).addClass('icons-spinner icon-spin').cssImportant(dm.vars.disalign, ( element.next().length > 0 ? '-1px' : '0' )).css({'font-size': '16px', 'top': '4px'});
								dm.killAjax.abort( ajax );
								dm.killAjax.add( jqXHR, ajax );
							},
							complete: function(){
								arrow.removeClass('icons-spinner icon-spin').addClass(arrowIconName).cssImportant(dm.vars.disalign, arrow.attr('x')+'px').css({'font-size': '22px', 'top': '1px'});
							},
							success: function( json ){
								if( $.type(json) !== 'object' ){
									ajaxLodingError('json object');
									return;
								}

								json.status = dm.checkVar( json.status, ['string'] );
								if( json.status == 'success' ){
									var rows = json.rows, row, texts = '', attrs = '';
									for( var x = 0; x < rows.length; x++ ){
										row = rows[x];
										attrs = '';
										texts = dm.checkVar( row[4], ['object'] );
										for( var n = 1; n <= 3; n++ ){
											texts[n] && ( attrs += ' text'+n+'="'+texts[n]+'"' );
										}
										$('> div', element).append('<div value="'+row[0]+'" text="'+row[1]+'" stext="'+row[2]+'"'+attrs+'>'+row[3]+'</div>');
									}
									show();
								}
								else{
									ajaxLodingError('json status');
								}
							},
							error: function(){
								ajaxLodingError('connection');
							}
						});
					}, 200);
				}
				else{
					if( $(this).val().length > 0 ){
						dm.callSearch( show, 200 );
					}
					else{
						dm.callSearch( checkText, 200 );
					}
				}
				
				doKeyUp = false;
			});
			input.on('focus', function(){
				if( blankOption.length > 0 && blankOption == $(this).val() ){
					$(this).val('');
				}
				if( entered === true ){
					entered = false;
					return false;
				}
				show(null, true);
				focusDisplay = true;
			});
			input.on('change', function(){
				var active = $('> div > div[value]', element).filter(function(){
					return $(this).css('display') == 'block';
				}), value = $('> input', element).val().search(), stext = '';
				if( anyvalue == 1 ){
					element.attr( 'slvalue', input.val() );
					element.trigger( 'slchange', [input.val()] );
					return;
				}
				else if( value.length > 0 && active.length > 0 ){
					for( var x = 0; x < active.length; x++ ){
						if( active.attr('stext') ){
							stext = active.attr('stext');
						}
						else{
							stext = active.html();
						}
						stext = stext.substring( 0, value.length );
						if( value == stext ){
							element.attr( 'slvalue', active.attr('code') ? active.attr('code') : (active.attr('value') || '') );
							element.trigger( 'slchange', [element.attr('slvalue')] );
							input.val( getOptionText( active ) );
							reloadChild( element );
							return;
						}
					}
				}
				element.attr( 'slvalue', selectValue );
				input.val( selectedText() );
			});
			input.on('click', function(){
				show(null, true);
			});
			$('> div > div', element).livequery(function(){
				var options = $(this), option,
				onClick = function(){
					var option = $(this);
					input.val( getOptionText( option ) );
					element.attr( 'slvalue', option.attr('code') ? option.attr('code') : option.attr('value') );
					element.trigger( 'slchange', [element.attr('slvalue')] );
					reloadChild( element );
					hide(true);
					entered = true;
					input.focus();
				};
				for( var x = 0; x < options.length; x++ ){
					option = $(options[x]);
					if( option.prop('addedClick') !== true ){
						option.on('click', onClick);
						option.prop('addedClick', true);
					}
				}
			});
			arrow.on('click', function(){
				if( panalDisplay === true && focusDisplay === false ){
					hide();
				}
				else{
					show(true);
					focusDisplay = false;
				}
			});
			element.hover(
				function(){
					overPanel = true;
				},
				function(){
					overPanel = false;
				}
			);
			$( document ).on('click', function(){
				if( overPanel === false ){
					hide();
				}
			});
		}
		element.data('select-list' , {
			input: input,
			setValue: setValue,
			show: show,
			hide: hide
		});
	}, elements = $(this);
	for( var x = 0; x < elements.length; x++ ){
		_selectList( $(elements[x]), refresh );
	}
};

/***
 .inputValue for make input just enters selected kind of data
 $('input, textarea').inputValue( type, format [, callback] );
***/
$.fn.inputValue = function( type, format, callback, undefined ){
	var _inputValue = function( input ){
		if( input.data('input-value') ){
			return;
		}
		var _globals = [
			8,	// backspace
			9,	// tab
			37,	// %
			38,	// &
			39,	// '
			40,	// (
			116	// t
		],
		_integer = [
			46,	// .
			48,	// 0
			49,	// 1
			50,	// 2
			51,	// 3
			52,	// 4
			53,	// 5
			54,	// 6
			55,	// 7
			56,	// 8
			57	// 9
		],
		_float = [
			46,	// .
			0	// null
		],
		_date = [
			45,	// -
			47,	// /
			0	// null
		],
		_time = [
			58,	// :
			46	// .
		],
		_negative = [
			45	// -
		],
		_doKeypress = function( event ){
			var key = event.which,
			shift = (document.all || document.getElementById) ? event.shiftKey : ( (d.layers) ? event.modifiers & Event.SHIFT_MASK : false ),
			ctrl = (document.all || document.getElementById) ? event.ctrlKey : ( (d.layers) ? event.modifiers & Event.CONTROL_MASK : false ),
			alt = (document.all || document.getElementById) ? event.altKey : ( (d.layers) ? event.modifiers & Event.ALT_MASK : false ),
			systemKey = (shift || ctrl || alt) ? true : false, keys = [];
			
			if( type == 'int' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
			if( type == 'intn' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				$.merge(keys, _negative);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
			if( type == 'float' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				$.merge(keys, _float);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
			if( type == 'floatn' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				$.merge(keys, _float);
				$.merge(keys, _negative);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
			if( type == 'date' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				$.merge(keys, _date);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
			if( type == 'time' ){
				$.merge(keys, _globals);
				$.merge(keys, _integer);
				$.merge(keys, _time);
				if( systemKey === false && $.inArray(key, keys) == -1 ){
					return false;
				}
			}
		},
		_doDate = function(){
			var date = input.val(), seperator = ( date.indexOf('/') >= 0 ) ? '/' : '-', part, day, month, year, error = '',
			checkNumber = function( number ){
				if( number >= 10 ){
					return number;
				}
				else{
					return '0'+number;
				}
			};
			part = date.split(seperator);
			if( part.length == 3 ){
				day = part[0];
				month = part[1];
				year = part[2];
				
				if( day.length == 4 && year.length == 2 ){
					day = part[2];
					year = part[0];
				}
				
				format = dm.checkVar( format, ['string'], 'dd-mm-yyyy' ).toLowerCase();
				if( format.length < 8 || format.length > 10 ){
					error = 'format';
				}
				
				day = parseInt(day, 10) || 0;
				month = parseInt(month, 10) || 0;
				year = parseInt(year, 10) || '0000';
				date = format;
				date = date.replace( /yyyy/, year );
				date = date.replace( /mm/, checkNumber(month, 2) );
				date = date.replace( /m/, month );
				date = date.replace( /dd/, checkNumber(day, 2) );
				date = date.replace( /d/, day );

				input.val( date );
				if( date.length != format.length ){
					error = 'dateformat';
				}
			}
			else{
				error = 'date';
			}
			callback.call( input, error );
		},
		_doTime = function(){
			var time = input.val(), seperator = ( time.indexOf('.') >= 0 ) ? '.' : ':', part, hour, minute, error = '',
			checkNumber = function( number ){
				if( number >= 10 ){
					return number;
				}
				else{
					return '0'+number;
				}
			},
			checkTime = function( format, hour, minute ){
				var time = format;
				time = time.replace( /hh/, checkNumber(hour, 2) );
				time = time.replace( /h/, hour );
				time = time.replace( /ii/, checkNumber(minute, 2) );
				time = time.replace( /i/, minute );
				return time;
			};
			part = time.split(seperator);
			if( part.length >= 2 ){
				hour = part[0];
				minute = part[1];
				
				format = dm.checkVar( format, ['string'], 'hh:ii' ).toLowerCase();
				if( format.length < 3 || format.length > 5 ){
					error = 'format';
				}
				
				hour = dm.parseInt(hour);
				minute = dm.parseInt(minute);
				
				if( hour >= 24 ){
					hour = 0;
				}
				if( minute >= 60 ){
					minute = 0;
				}
				
				time = checkTime( format, hour, minute );

				input.val( time );
				if( time.length != format.length ){
					error = 'timeformat';
				}
			}
			else{
				error = 'time';
			}
			callback.call( input, error );
		};
		
		if( callback === true ){
			callback = function( error ){
				if( error != '' ){
					this.attr('date-error', error);
					this.addClass('cmaroon');
				}
				else{
					this.removeAttr('date-error');
					this.removeClass('cmaroon');
				}
			};
		}
		else{
			callback = callback || function(){};
		}
		
		if( type == 'int' || type == 'intn' || type == 'float' || type == 'floatn' || type == 'date' || type == 'time' ){
			input.on('keypress', _doKeypress);
		}
		if(type == 'date'){
			input.on('blur', _doDate);
		}
		if(type == 'time'){
			input.on('blur', _doTime);
		}
		input.data('input-value', {
			input: input
		});
	}, inputs = $(this);
	for( var x = 0; x < inputs.length; x++ ){
		if( inputs[x] && ( inputs[x].tagName.toLowerCase() == 'input' || inputs[x].tagName.toLowerCase() == 'textarea' ) ){
			_inputValue( $(inputs[x]) );
		}
	}
};

/***
 .inputSelect used for if click radio text or checkbox text will select it or check it.
 $( span ).inputSelect();
***/
$.fn.inputSelect = function(){
	var _inputSelect = function( element ){
		var parent = element.parent();
		if( parent.length == 0 || parent.prop('tagName').toLowerCase() != 'span' ){
			return;
		}
		parent.css('cursor', 'pointer');
		parent.click(function( event ){
			var span = $(this), input = $('input', span);
			if( input.length == 0 ){
				return;
			}
			if( input.attr('type').toLowerCase() == 'radio' ){
				if( input.prop('disabled') === false ){
					input.prop('checked', true).trigger('change');
				}
			}
			else if( input.attr('type').toLowerCase() == 'checkbox' ){
				if( $(event.target).prop('tagName').toLowerCase() != 'input' && input.prop('disabled') === false ){
					input.click();
				}
			}
		});
	}, elements = $(this);
	for( var x = 0; x < elements.length; x++ ){
		_inputSelect( $(elements[x]) );
	}
};

/***
 .textareaAutoSize to check textarea auto resize by text value.
 $( textarea ).textareaAutoSize();
***/
(function(){
	$.fn.extend({
		textareaAutoSize: function(){
			var cssProperties = [
				'box-sizing',
				'padding-top',
				'padding-right',
				'padding-bottom',
				'padding-left',
				'border-top-width',
				'border-right-width',
				'border-bottom-width',
				'border-left-width',
				'border-top-style',
				'border-right-style',
				'border-bottom-style',
				'border-left-style',
				'border-top-color',
				'border-right-color',
				'border-bottom-color',
				'border-left-color',
				'line-height',
				'font-size',
				'font-family',
				'font-weight',
				'width'
			];
			return this.each(function(){
				var textarea = $(this);
				if( this.type !== 'textarea' || textarea.data('auto-size') ){
					return false;
				}
				
				var temp = $('<div></div>').css({
					'position'		: 'absolute',
					'display'		: 'none',
					'word-wrap'		: 'break-word',
					'white-space'	: 'pre-wrap'
				}),
				lineHeight	= parseInt( textarea.css('line-height'), 10 ) 	|| parseInt( textarea.css('font-size'), 10 ),
				minHeight	= parseInt( textarea.css('height'), 10 ) 		|| ( lineHeight * 3 ),
				maxHeight	= parseInt( textarea.css('max-height'), 10 ) 	|| Number.MAX_VALUE,
				setTempWidth = function(){
					var width = Math.floor( dm.parseInt( textarea.css('width') ) );
					if( temp.width() !== width ){
						temp.css({
							'width': width+'px'
						});
						update(true);
					}
				},
				setHeightAndOverflow = function( height, overflow ){
					height = Math.floor( dm.parseInt( height ) );
					if( textarea.height() !== height ){
						textarea.css({
							'height': height+'px',
							'overflow': overflow
						});
						var extend = textarea.attr('extend') || '', elements, element;
						if( extend.length > 0 ){
							elements = $('[te-extend="'+extend+'"]');
							for( let i = 0; i < elements.length; i++ ){
								element = $(elements[i]);
								if( element.length > 0 ){
									element.css({
										'height': height+'px',
										'overflow': overflow
									});
								}
							}
						}
					}
				},
				update = function( forced ){
					var content = textarea.val().replace( /&/g, '&amp;' ).replace( / {2}/g, '&nbsp;' ).replace( /<|>/g, '&gt;' ).replace( /\n/g, '<br />'+unescape('%u200C') );
					var tempContent = temp.html().replace( /<br>/ig, '<br />' );
					if( forced || content !== tempContent ){
						temp.html( content );
						if( Math.abs( temp.height() + lineHeight - textarea.height() ) > 3 ){
							temp.show();
							var height = temp[0].offsetHeight;
							temp.hide();
							if( height >= maxHeight ){
								setHeightAndOverflow( maxHeight, 'auto' );
							}
							else if( height <= minHeight ){
								setHeightAndOverflow( minHeight, 'hidden' );
							}
							else{
								setHeightAndOverflow( height, 'hidden' );
							}
						}
					}
				};

				if( maxHeight < 0 ){
					maxHeight = Number.MAX_VALUE;
				}
				temp.appendTo( document.body );
				for( let i = 0; i < cssProperties.length; i++ ){
					temp.css( cssProperties[i].toString(), textarea.css( cssProperties[i].toString() ) );
				}

				textarea.css({
					'overflow':'hidden'
				});
				textarea.bind('keyup change cut paste', function(){
					update();
				});
				$(window).bind( 'resize', setTempWidth );
				textarea.bind( 'resize', setTempWidth );
				textarea.bind( 'update', update );
				textarea.bind('input paste', function(){
					setTimeout( update, 250 );
				});				
				update();
				textarea.data( 'auto-size', {
					update: update
				});
			});
		} 
	});
})();

$.fn.dmMask = function( type, options, undefined ){
	var _mask = function( element ){
		var cleanValue = function( value ){
			value = value.split(''), newValue = '', found = false;
			for( var x = 0; x < value.length; x++ ){
				if( value[x] == '.' ){
					if( found ){
						continue;
					}
					found = true;
				}
				if( (/([0-9\.]+)/).test( value[x] ) ){
					newValue += value[x];
				}
			}
			return newValue;
		},
		comaLength = function( value ){
			var times = 0, split = value.split('');
			for( var x = 0; x < split.length; x++){
				if( split[x] == ',' ){
					times++;
				}
			}
			return times;
		},
		setComa = function( input, firsttime ){
			var cursor = input.getCursor(), value = cleanValue( input.val() ), realNumber = '', number = '', realNumberSplit;
			if( !input.data('dmMask') ){
				input.data('dmMask', {
					comas: 0
				});
			}
			value = value.split('.');
			realNumber = value[0];
			realNumber = ''+realNumber;
			if( realNumber.length > 0 ){
				if( realNumber.length > 3 ){
					realNumberSplit = realNumber.split('');
					realNumber = '';
					var y = 0;
					for( var x = realNumberSplit.length - 1; x >= 0; x-- ){
						if( y == 3 ){
							realNumber = ','+realNumber;
							y = 0;
						}
						realNumber = realNumberSplit[x]+''+realNumber;
						y++;
					}
				}
				number = realNumber;
			}
			if( value.length == 2 ){
				number = realNumber+'.'+value[1];
			}
			input.val(number);
			if( number.length > 1 && firsttime !== true ){
				cursor = cursor + comaLength(number) - input.data('dmMask').comas;
				if( firsttime !== 'nofocus' ){
					input.setCursor( cursor, cursor );
				}
			}
			input.data('dmMask', {
				comas: comaLength(number),
				setComa: setComa
			});
		};
		setComa(element, true);
		element.on('keyup', function( event ){
			var input = $(this);
			if( $.inArray(event.which, [37, 38, 39, 40]) >= 0 ){
				return;
			}
			setComa(input);
		});
  		element.on('focus', function(){
			setComa( $(this) );
		});
	}, elements = this, lastElement = [];
	for( var x = 0; x < elements.length; x++ ){
		_mask( $(elements[x]) );
		lastElement = elements[x];
	}
	return $(lastElement);
};

var jKeyEvent = jKeyEvent || {};
var jEscapeKeyFunctions = jEscapeKeyFunctions || [];
(function($) {
	var debug = false;
	/**/
	jKeyEvent.warn = function(log) { 
		if (console && debug) {
			console.warn(log);
		}
	};
	
	/*john's array prototype remove*/
	jKeyEvent.remove = function (from, to) {
		var rest = jEscapeKeyFunctions.slice((to || from) + 1 || jEscapeKeyFunctions.length);
		jEscapeKeyFunctions.length = from < 0 ? jEscapeKeyFunctions.length + from : from;
		return jEscapeKeyFunctions.push.apply(jEscapeKeyFunctions, rest);
	};
	
	/**/
	jKeyEvent.keydown = function(e) {
		e.preventDefault();
		/*add a document key listener*/
		var code = (e.keyCode ? e.keyCode : e.which);
			if (code === 27) {
				for (var i = jEscapeKeyFunctions.length-1; i>-1; --i) {
					if (typeof jEscapeKeyFunctions[i].callback === 'function') {
						jEscapeKeyFunctions[i].callback(jEscapeKeyFunctions[i].element);
						jKeyEvent.remove(i,0);
						break;
					}
				} //end for		
			} //end if 
	};
	
	/**/
	jKeyEvent.addEvent = function() {
		if (jKeyEvent.hasKeyDown) { 
			return;
		} 
		else
		{
			jKeyEvent.hasKeyDown=true;
			$(document).keydown(function (e) {			
				jKeyEvent.keydown(e);
			}); //end key down 
		} 
	};
	
	/**/
	jKeyEvent.push = function (obj) {	
		var controlled = $.grep(jEscapeKeyFunctions, function(item) {
			return obj.index === item.index
		});
		
		if (controlled.length===0) 
		{
			jEscapeKeyFunctions.push(obj);
		}
	};
			
	/**/
	jKeyEvent.debug = function() {
		if (console) {
			console.warn(jEscapeKeyFunctions.length);
			console.dir(jEscapeKeyFunctions);
		}
	}
	
	$.fn.removeEscape = function() {
		/*Get Index*/
		var index = this.attr('kb');
		if (index) 
		{
			var indexToInt = parseInt(index,10);
			for (var i = 0; i < jEscapeKeyFunctions.length;i++) {
				if (jEscapeKeyFunctions[i].index === indexToInt) {
						jKeyEvent.remove(i,0);	
				}
			}
		} else {
			return false;
		}
	};
	
	/**/
 	$.fn.escape = function(callback) {
		var keyCode = -1;
		var element = this;	
		var keyBindIndex = jEscapeKeyFunctions.length;
		
		if (!element.attr('keybind')) {
			element.attr('kb', jEscapeKeyFunctions.length); //add key bind index
		}
		
		jKeyEvent.push({
			element: element,
			index: keyBindIndex,			
			callback: callback
		});
		
		jKeyEvent.addEvent();
	}; //end of escape 
})(jQuery);

jQuery.fn.uploadify = function( object ){
	var form = this, formData, url, data, console = ( window.console && window.console.log );
	
	if( !( "onprogress" in $.ajaxSettings.xhr() ) || $.type(object) !== 'object' ){
		if( console ){
			window.console.log( 'Uploadify: the onprogress not found in xhr in this browser.' );
		}
		return;
	}
	
	if( $.type(form.tagName) !== 'string' ){
		form = ( form && form.length == 1 ) ? form[0] : false;
	}
	
	if( $.type(form) !== 'object' || $.type(form) !== 'object' || form.tagName.toLowerCase() != 'form' ){
		if( console ){
			window.console.log( 'Uploadify: form object was undefined' );
		}
		return;
	}

	object.name = dm.checkVar( object.name, ['string'] );
	object.url = dm.checkVar( object.url, ['string'] );
	object.file = dm.checkVar( object.file, ['string'], 'ajax.php' );
	object.status = dm.checkVar( object.status, ['string'], 'success' );
	object.before = dm.checkVar( object.before, ['function'], function(){ return true; } );
	object.after = dm.checkVar( object.after, ['function'] );
	object.complete = dm.checkVar( object.complete, ['function'] );
	object.success = dm.checkVar( object.success, ['function'] );
	object.dataType = dm.checkVar( object.dataType, ['string'], 'json' );
	object.error = dm.checkVar( object.error, ['function'] );
	object.data = dm.checkVar( object.data, ['object'] );
	object.progress = dm.checkVar( object.progress, ['function'] );
	
	/* example:
	progress = function( event ){
		event.lengthComputable // return true or false
		event.loaded // return bytes was loaded
		event.total // return number of all bytes
		
		// for percent use this code:
		Math.round( event.loaded * 100 / event.total ) + '%'
	}
	*/
	
	if( object.name != '' ){
		url = object.file+'?type='+object.name+'&x='+dm.rand();
	}
	else{
		url = object.url+( object.url.indexOf('?') ? '&' : '?' )+'x='+dm.rand();
	}
	
	formData = new FormData( form );

	$.each( object.data, function( name, value ){
		formData.append( name, value );
	});
	
	if( !object.before.call( object ) ){
		return;
	}
	
	$.ajax({
		url: url,
		type: 'POST',
		xhr: function(){
			myXhr = $.ajaxSettings.xhr();
			if( myXhr.upload ){
				myXhr.upload.addEventListener('progress', object.progress, false);
			}
			return myXhr;
		},
		success: function( json ){
			var doError = false;
			
			if( $.type(json) !== 'object' ){
				doError = true;
			}
			
			if( doError === true && console ){
				window.console.log( 'Uploadify: json is no object: name('+object.name+')' );
			}
			
			if( doError === false ){
				json.status = dm.checkVar( json.status, ['string'] );
				
				if( json.status == object.status ){
					object.success.call( object, json );
					object.after.call( object, json );
				}
				else{
					doError = true;
				}
			}
			
			if( doError === true ){
				object.error.call( object, json );
			}
		},
		error: object.error,
		complete: object.complete,
		dataType: object.dataType,
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	});
};
$(function(){
	var keyboards = {
		'en_us': {
			'langcode': 'en_us',
			'shortname': 'EN',
			'longname': 'English United States',
			'dir': 'ltr',
			'keys': [
				/*  */	32,		/* ! */	33,		/* " */	34,		/* # */	35,		/* $ */	36,		/* % */	37,		/* & */	38,		/* ' */	39,
				/* ( */	40,		/* ) */	41,		/* * */	42,		/* + */	43,		/* , */	44,		/* - */	45,		/* . */	46,		/* / */	47,
				/* 0 */	48,		/* 1 */	49,		/* 2 */	50,		/* 3 */	51,		/* 4 */	52,		/* 5 */	53,		/* 6 */	54,		/* 7 */	55,
				/* 8 */	56,		/* 9 */	57,		/* : */	58,		/* ; */	59,		/* < */	60,		/* = */	61,		/* > */	62,		/* ? */	63,
				/* @ */	64,		/* A */	65,		/* B */	66,		/* C */	67,		/* D */	68,		/* E */	69,		/* F */	70,		/* G */	71,
				/* H */	72,		/* I */	73,		/* J */	74,		/* K */	75,		/* L */	76,		/* M */	77,		/* N */	78,		/* O */	79,
				/* P */	80,		/* Q */	81,		/* R */	82,		/* S */	83,		/* T */	84,		/* U */	85,		/* V */	86,		/* W */	87,
				/* X */	88,		/* Y */	89,		/* Z */	90,		/* [ */	91,		/* \ */	92,		/* ] */	93,		/* ^ */	94,		/* _ */	95,
				/* ` */	96,		/* a */	97,		/* b */	98,		/* c */	99,		/* d */	100,	/* e */	101,	/* f */	102,	/* g */	103,
				/* h */	104,	/* i */	105,	/* j */	106,	/* k */	107,	/* l */	108,	/* m */	109,	/* n */	110,	/* o */	111,
				/* p */	112,	/* q */	113,	/* r */	114,	/* s */	115,	/* t */	116,	/* u */	117,	/* v */	118,	/* w */	119,
				/* x */	120,	/* y */	121,	/* z */	122,	/* { */	123,	/* | */	124,	/* } */	125,	/* ~ */	126
			]
		},
		'kuka_ku': {
			'langcode': 'kuka_ku',
			'shortname': 'KU',
			'longname': 'Kurdish Kirmanji Arabic',
			'dir': 'rtl',
			'keys': [
				/*  */	32,		/* ! */	33,		/* " */	1591,	/* # */	35,		/* $ */	36,		/* % */	37,		/* & */	38,		/* ' */	1711,
				/* ( */	40,		/* ) */	41,		/* * */	42,		/* + */	43,		/* , */	1608,	/* - */	45,		/* . */	1586,	/* / */	1700,
				/* 0 */	48,		/* 1 */	49,		/* 2 */	50,		/* 3 */	51,		/* 4 */	52,		/* 5 */	53,		/* 6 */	54,		/* 7 */	55,
				/* 8 */	56,		/* 9 */	57,		/* : */	58,		/* ; */	1603,	/* < */	44,		/* = */	61,		/* > */	46,		/* ? */	1567,
				/* @ */	64,		/* A */	1616,	/* B */	65269,	/* C */	1572,	/* D */	1610,	/* E */	1579,	/* F */	91,		/* G */	65271,
				/* H */	1571,	/* I */	1726,	/* J */	1600,	/* K */	1548,	/* L */	47,		/* M */	1577,	/* N */	1570,	/* O */	215,
				/* P */	1563,	/* Q */	1590,	/* R */	1612,	/* S */	1613,	/* T */	1573,	/* U */	247,	/* V */	1685,	/* W */	1611,
				/* X */	1618,	/* Y */	1573,	/* Z */	126,	/* [ */	1580,	/* \ */	92,		/* ] */	1583,	/* ^ */	94,		/* _ */	95,
				/* ` */	1688,	/* a */	1588,	/* b */	1717,	/* c */	1734,	/* d */	1740,	/* e */	1662,	/* f */	1576,	/* g */	1604,
				/* h */	1575,	/* i */	1607,	/* j */	1578,	/* k */	1606,	/* l */	1605,	/* m */	1749,	/* n */	1742,	/* o */	1582,
				/* p */	1581,	/* q */	1670,	/* r */	1602,	/* s */	1587,	/* t */	1601,	/* u */	1593,	/* v */	1585,	/* w */	1589,
				/* x */	1569,	/* y */	1594,	/* z */	1574,	/* { */	60,		/* | */	1592,	/* } */	62,		/* ~ */	1584
			]
		},
		'ar_iq': {
			'langcode': 'ar_iq',
			'shortname': 'AR',
			'longname': 'Arabic Iraq',
			'dir': 'rtl',
			'keys': [
				/*  */	32,		/* ! */	33,		/* " */	1591,	/* # */	35,		/* $ */	36,		/* % */	37,		/* & */	38,		/* ' */	1711,
				/* ( */	40,		/* ) */	41,		/* * */	42,		/* + */	43,		/* , */	1608,	/* - */	45,		/* . */	1586,	/* / */	1592,
				/* 0 */	48,		/* 1 */	49,		/* 2 */	50,		/* 3 */	51,		/* 4 */	52,		/* 5 */	53,		/* 6 */	54,		/* 7 */	55,
				/* 8 */	56,		/* 9 */	57,		/* : */	58,		/* ; */	1603,	/* < */	44,		/* = */	61,		/* > */	46,		/* ? */	1567,
				/* @ */	64,		/* A */	1616,	/* B */	65269,	/* C */	125,	/* D */	1610,	/* E */	1615,	/* F */	91,		/* G */	65271,
				/* H */	1571,	/* I */	247,	/* J */	1600,	/* K */	1548,	/* L */	47,		/* M */	8217,	/* N */	1570,	/* O */	215,
				/* P */	1563,	/* Q */	1614,	/* R */	1612,	/* S */	1613,	/* T */	65273,	/* U */	8216,	/* V */	123,	/* W */	1611,
				/* X */	1618,	/* Y */	1573,	/* Z */	126,	/* [ */	1580,	/* \ */	92,		/* ] */	1583,	/* ^ */	94,		/* _ */	95,
				/* ` */	1584,	/* a */	1588,	/* b */	65275,	/* c */	1734,	/* d */	1740,	/* e */	1579,	/* f */	1576,	/* g */	1604,
				/* h */	1575,	/* i */	1607,	/* j */	1578,	/* k */	1606,	/* l */	1605,	/* m */	1577,	/* n */	1609,	/* o */	1582,
				/* p */	1581,	/* q */	1590,	/* r */	1602,	/* s */	1587,	/* t */	1601,	/* u */	1593,	/* v */	1585,	/* w */	1589,
				/* x */	1569,	/* y */	1594,	/* z */	1574,	/* { */	60,		/* | */	124,	/* } */	62,		/* ~ */	1617
			]
		}
	},
	_setSelectionRange = function( input, selectionStart, selectionEnd ){
		input.focus();
		input.setSelectionRange( selectionStart, selectionEnd );
	},
	_doConvert = function( event, lang ){
		if( event == null ){
			event = window.event;
		}
		
		var key = event.which || event.charCode || event.keyCode;
		var eElement = event.target || event.originalTarget || event.srcElement;

		if( event.ctrlKey && key == 32 ){
			alert('ChangeLang');
		}

		if(
			( event.charCode != null && event.charCode != key ) ||
			( event.which != null && event.which != key ) ||
			( event.ctrlKey || event.altKey || event.metaKey ) ||
			( key == 13 || key == 27 || key == 8 )
		){
			return true;
		}

		//check windows lang
		if( key > 128 ){
			alert("Please, change your keyboad to english language");
			return false;
		}

		//check CpasLock
/* 		if( ( key >= 65 && key <= 90 && !event.shiftKey ) || ( key >= 97 && key <= 122 ) && event.shiftKey ){
			alert("The Caps Lock is active, to avoid write username with errors, please turn it off");
			return false;
		} */

		// Shift-space -> ZWNJ
		if( key == 32 && event.shiftKey ){
			key = 8204;
		}
		else{
			key = lang.keys[ key - 32 ];
		}

		key = ( typeof key == 'string' ) ? key : String.fromCharCode( key );

		// to choosed font name
		try{
			var docSelection = document.selection;
			var selectionStart = eElement.selectionStart;
			var selectionEnd = eElement.selectionEnd;

			if( typeof selectionStart == 'number' ){ 
				// FOR W3C STANDARD BROWSERS
				var nScrollTop = eElement.scrollTop;
				var nScrollLeft = eElement.scrollLeft;
				var nScrollWidth = eElement.scrollWidth;

				eElement.value = eElement.value.substring( 0, selectionStart ) + key + eElement.value.substring( selectionEnd );
				_setSelectionRange( eElement, selectionStart + key.length, selectionStart + key.length );

				var nW = eElement.scrollWidth - nScrollWidth;
				if( eElement.scrollTop == 0 ){
					eElement.scrollTop = nScrollTop;
				}
			}
			else if( docSelection ){
				var nRange = docSelection.createRange();
				nRange.text = key;
				nRange.setEndPoint( 'StartToEnd', nRange );
				nRange.select();
			}

		}
		catch( error ){
			try{
				// IE
				event.keyCode = key;
			}
			catch( error ){
				try{
					// OLD GECKO
					event.initKeyEvent( "keypress", true, true, document.defaultView, false, false, true, false, 0, key, eElement );
				}
				catch( error ){
					//OTHERWISE
					eElement.value += key;
				}
			}
		}

		if( event.preventDefault ){
			event.preventDefault();
		}
		event.returnValue = false;
		return true;
	},
	_makeKeyboard = function( element ){
		var
		tempLangs = element.attr('dmkeyboard').toLowerCase().split(','),
		langs = [], button, lang, id;
		
		if( element.hasClass('dmk-created') ){
			return;
		}
		
		for( var x = 0; x < tempLangs.length; x++ ){
			if( $.type( keyboards[tempLangs[x]] ) === 'object' ){
				langs[langs.length] = tempLangs[x];
			}
		}

		if( langs.length > 1 ){
			id = 'btn'+dm.mtrand(100000, 999999);
			$('<input type="button" class="btn" id="'+id+'" value="EN">').insertAfter(element);
			button = $('#'+id);
			button.css({
				'padding-right': '5px',
				'padding-left': '5px'
			});
			for( var x = 0; x < langs.length; x++ ){
				lang = keyboards[langs[x]];
				if( x == 0 ){
					element.attr({
						'langcode': lang.langcode,
						'dir': lang.dir
					});
					button.val( lang.shortname );
					button.attr({
						'slang': 0,
						'title': lang.longname
					});
				}
			}
			button.on('click', function(){
				var button = $(this), slang = dm.parseInt( button.attr('slang') || 0 ), lang;
				
				slang = ( slang < ( langs.length - 1 ) ) ? ( slang + 1 ) : 0;
				lang = keyboards[ langs[slang] ];
				
				element.attr({
					'langcode': lang.langcode,
					'dir': lang.dir
				});
				button.val( lang.shortname );
				button.attr({
					'slang': slang,
					'title': lang.longname
				});
				element.focus();
			});
			element.on('keypress', function( event ){
				var langcode = $(this).attr('langcode');
				return _doConvert( event, keyboards[langcode] );
			});
		}
		else if( langs.length == 1 ){
			lang = keyboards[langs[0]];
			element.attr('dir', lang.dir);
			element.on('keypress', function( event ){
				return _doConvert( event, lang );
			});
		}
		else{
			return;
		}
		
		element.addClass('dmk-created');
	};
	$('input[dmkeyboard], textarea[dmkeyboard]').livequery(function(){
		var elements = $(this), element, tagname;
		for( var x = 0; x < elements.length; x++ ){
			element = $(elements[x]);
			tagname = element.prop('tagName').toLowerCase();
			if( tagname == 'input' && element.attr('type') == 'text' || tagname == 'textarea' ){
				_makeKeyboard( element );
			}
		}
	});
});

$.fn.fixedBar = function(){
	var parent = $(this).parent(), bar;
	if( parent.length == 0 ){
		return;
	}

	$(document.body).append('<div class="fixed-bar"><table class="table-list" width="100%" cellpadding="0" cellspacing="0"><tr><td class="text-white buttons">'+parent.html()+'</td></tr></table></div>');
	
	var fixedBar = $('.fixed-bar'), height = ( fixedBar.length > 0 ? fixedBar[0].offsetHeight : 0 ), footer = $('.block-footer'), padding = dm.parseInt( footer.css('margin-bottom') );
	if( padding == 0 && height > 0 ){
		footer.css('margin-bottom', height+'px');
	}
};
// min and max for inputs
$.fn.minmax = function(){
	var _minmax = function( element ){
		
		if( element.data('minmax') ) return;
		
		var
		min = dm.parseFloat(element.attr('min')),
		max = dm.parseFloat(element.attr('max')),
		increase = dm.parseFloat(element.attr('increase')),
		hasMin = ( element.attr('min') ? true : false ),
		hasMax = ( element.attr('max') ? true : false ),
		buttonUp = $('> .mm-up', element),
		buttonDown = $('> .mm-down', element),
		input = $( element.attr('sel') || '' ),
		_min = function(){
			var number = dm.parseFloat( input.val() );
			if( hasMin ){
				if( min < number ) number -= increase;
				if( min > number ) number = min;
			}
			else{
				number -= increase;
			}
			input.val( Math.round(number * 100) / 100 );
		},
		_max = function(){
			var number = dm.parseFloat( input.val() );
			if( hasMax ){
				if( max > number ) number += increase;
				if( max < number ) number = max;
			}
			else{
				number += increase;
			}
			input.val( Math.round(number * 100) / 100 );
		};

		if( min > max ) max = min;
		if( increase == 0 ) increase = 1;
		if( input.length == 0 ) return;

		buttonUp.on('click', function(){
			if( $(this).parent().hasClass('disabled') ) return;
			_max();
		});
		buttonDown.on('click', function(){
			if( $(this).parent().hasClass('disabled') ) return;
			_min();
		});
		
		element.data('minmax' , {
			min: _min,
			max: _max
		});
	}, elements = $(this);
	for( var x = 0; x < elements.length; x++ ){
		_minmax( $(elements[x]) );
	}

	return elements;
};
jQuery.fn.cssImportant = function(name, value) {
	const $this = this;
	const applyStyles = (n, v) => {
		// Convert style name from camelCase to dashed-case.
		const dashedName = n.replace(/(.)([A-Z])(.)/g, (str, m1, upper, m2) => {
			return m1 + "-" + upper.toLowerCase() + m2;
		}); 
		// Loop over each element in the selector and set the styles.
		$this.each(function(){
			this.style.setProperty(dashedName, v, 'important');
		});
	};
	// If called with the first parameter that is an object,
	// Loop over the entries in the object and apply those styles. 
	if( jQuery.isPlainObject(name) ){
		for(const [n, v] of Object.entries(name)){
			applyStyles(n, v);
		}
	}
	else{
		// Otherwise called with style name and value.
		applyStyles(name, value);
	}
	// This is required for making jQuery plugin calls chainable.
	return $this;
};
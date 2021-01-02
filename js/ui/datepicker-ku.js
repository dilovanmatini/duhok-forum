/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Alhourani -- me@khaledalhourani.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name فبراير - يناير and there isn't any Arabic roots for these months */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../jquery.ui.datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {
	datepicker.regional['ku'] = {
		closeText: 'دایخستن',
		prevText: '&#x3C;لپێش',
		nextText: 'ددویڤدا&#x3E;',
		currentText: 'ئەڤرو',
		monthNames: ['كانینا ئێكێ', 'شوبات', 'ئادار', 'نيسان', 'گولان', 'خزیران', 'تیرمەھ', 'تەباخ', 'ئەیلول', 'چریا ئێكێ', 'چریا دووێ', 'كانینا ئێكێ'],
		monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		dayNames: ['ئێك شەمب', 'دوو شەمب', 'سێ شەمب', 'چوار شەمب', 'پێنج شەمب', 'ئەینی', 'شەمبی'],
		dayNamesShort: ['ئێك شەمب', 'دوو شەمب', 'سێ شەمب', 'چوار شەمب', 'پێنج شەمب', 'ئەینی', 'شەمبی'],
		dayNamesMin: ['1 ش', '2 ش', '3 ش', '4 ش', '5 ش', 'ئـ', 'ش'],
		weekHeader: 'حەفتی',
		dateFormat: 'dd/mm/yy',
		changeYear: true,
		changeMonth: true,
		firstDay: 6,
  		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: '',
		yearRange: "c-50:c+10"
	};
	datepicker._defaults.defaultDate = dm.vars.date;
	datepicker.setDefaults(datepicker.regional['ku']);

	return datepicker.regional['ku'];

}));

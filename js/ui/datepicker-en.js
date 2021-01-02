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
	datepicker.regional['en'] = {
		dateFormat: 'dd/mm/yy',
		changeYear: true,
		changeMonth: true,
		firstDay: 0,
		showMonthAfterYear: false,
		yearSuffix: '',
		yearRange: "c-50:c+10"
	};
	datepicker._defaults.defaultDate = dm.vars.date;
	datepicker.setDefaults(datepicker.regional['en']);

	return datepicker.regional['en'];

}));

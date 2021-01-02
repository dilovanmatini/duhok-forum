/**
 * This jQuery plugin resizes a textarea to adapt it automatically to the content.
 * @author Amaury Carrade
 * @version 1.1
 * 
 * @example $('textarea').autoResize({
 *              animate:   {                            // @see .animate()
 *              	enabled:    true,                   // Default: false
 * 					duration:   'fast',                 // Default: 100
 *					complete:   function() {},          // Default: null
 *					step:       function(now, fx) {}    // Default: null
 *              },
 *              maxHeight: '500px'                      // Default: null (unlimited)
 *          });
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lessier General Public License version 3 as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lessier General Public License for more details.
 *
 * You should have received a copy of the GNU Lessier General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

(function($){
	$(document).ready(function(){
		$('body').append('<div id="autoResizeTextareaCopy" style="box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;-webkit-box-sizing:border-box;visibility:hidden;"></div>');
		var $copy = $('#autoResizeTextareaCopy');
		function autoSize($textarea){
			$copy.css({
				fontFamily:     $textarea.css('fontFamily'),
				fontSize:       $textarea.css('fontSize'),
				padding:        $textarea.css('padding'),
				paddingLeft:    $textarea.css('paddingLeft'),
				paddingRight:   $textarea.css('paddingRight'),
				paddingTop:     $textarea.css('paddingTop'), 
				paddingBottom:  $textarea.css('paddingBottom'),
				lineHeight: 	$textarea.css('lineHeight'),
				whiteSpace: 	$textarea.css('whiteSpace'),
				wordWrap:		$textarea.css('wordWrap'),
 				letterSpacing:	$textarea.css('letterSpacing'),
				wordSpacing:	$textarea.css('wordSpacing'),
				textTransform:	$textarea.css('textTransform'),
				width:          $textarea.css('width')
			});
			$textarea.css('overflow', 'hidden');
			var text = $textarea.val().replace(/\n/g, '<br/>');
			$copy.html(text + '<br />');
			var newHeight = $copy.css('height');
			$copy.html('');
			if(parseInt(newHeight) != 0) {
				$textarea.css('height', newHeight);
			}
		}
		
		$.fn.autoResize = function(){
			var $this = $(this);
			$this.change( 			function() { autoSize($this); } )
				 .keydown( 			function() { autoSize($this); } )
				 .keyup( 			function() { autoSize($this); } )
				 .focus( 			function() { autoSize($this); } );
			$this.on('paste', function() { autoSize($this); } );
			autoSize($this);
		};
	});
})(jQuery);
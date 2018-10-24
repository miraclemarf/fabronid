(function($) {
    'use strict';
	$(document).ready(function () {
		if($("input[name='billing_phone']").val()){
			$('body').trigger('update_checkout');
		}

		$( document ).on( 'updated_checkout', function() {
		   	var data = {
		        'action': 'clkp_get_data',
		        'kode_pembayaran': $("input[name='billing_phone']").val()
		    };

		    $.post(cepatlakooAjax.ajax_url, data, function(response) {
			});

		});

		$('body.woocommerce-checkout').on('change keyup', "input#billing_phone", debounce(function() {
		   	var data = {
		        'action': 'clkp_get_data',
		        'kode_pembayaran': $("input[name='billing_phone']").val()
		    };

		    $.post(cepatlakooAjax.ajax_url, data, function(response) {
		        $('body').trigger('update_checkout');
			});
	    }, 1000));

	    function debounce(func, wait, immediate) {
	        var timeout;
	        return function() {
	            var context = this,
	                args = arguments;
	            var later = function() {
	                timeout = null;
	                if (!immediate) func.apply(context, args);
	            };
	            var callNow = immediate && !timeout;
	            clearTimeout(timeout);
	            timeout = setTimeout(later, wait);
	            if (callNow) func.apply(context, args);
	        };
	    };

	});

})(jQuery);
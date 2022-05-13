/* Theme Verify JS */

(function ($) {
	"use strict";
	// Create by Nguyen Duc Viet
	$(document).on('click', '#orfarm-submit-code', function () {
		var $this = $(this);
		var $code = $('#purchased_code').val();
		if (!$code) {
			$('#purchased_code').addClass('empty');
			return false;
		}
		$('.orfarm-verify img.loading').show();
		$(this).attr('disabled', 'disabled');
		$.ajax({
			url: 'https://blueskytechco.com/wpblueskytech/api.php',
			type: 'POST',
			data: 'theme=orfarm&purchase_code=' + $code,
			dataType: 'json',
			success: function (result) {
				if (result.success && result.success == 1) { 
					
					var save_url = 'action=orfarm_save_purchased_code&code=' + $code;
					console.log(result);
					console.log(save_url);
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: save_url,
						success: function (data) {
							$('#purchased_code').prev('.correct').show();
						}
					});
				} else {
					$('#purchased_code').next('.incorrect').show();
				}
				$('.orfarm-verify img.loading').hide();
				$this.removeAttr('disabled');
			}
		});
	});
	$(document).on('change', '#purchased_code', function () {
		$(this).removeClass('empty').next('.incorrect').hide();
	});
})(jQuery);
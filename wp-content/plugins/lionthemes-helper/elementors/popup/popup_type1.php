<?php 
	$width = ""; 
    if($settings['popup_width']) {
		$width = $settings['popup_width'];
	}

?>
<div class="popup-content" id="popup_onload">  
	<div class="popup-content-inner">
		<div class="overlay-bg"><div class="lds-ripple"><div></div><div></div></div></div>
			<div class="popup-content-wrapper" id="popup-style-apply" <?php if(isset($settings['enable_width']) && $settings['enable_width']=='yes') { ?> style ="width:<?php echo $width;?>px" <?php } ?> >
					<div class="newletter-form">
						<?php echo do_shortcode( $settings['popup_onload_form'] ); ?>
					</div>
					<label class="not-again"><input type="checkbox" value="1" name="not-again" /><span><?php echo esc_html__('Do not show this popup again', 'orfarm'); ?></span></label>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) { 
			
			if($('#popup_onload').length){
				$('#popup_onload').fadeIn(400);
			}

			$('#popup_onload .close-popup, #popup_onload .overlay-bg, #popup_onload .no-thanks').click(function(){
				
				var not_again = $(this).closest('#popup_onload').find('.not-again input[type="checkbox"]').prop('checked');
				if(not_again){
					var datetime = new Date();
					var exdays = <?php echo ((!empty($settings['popup_onload_expires'])) ? intval($settings['popup_onload_expires']) : 7) ?>;
					datetime.setTime(datetime.getTime() + (exdays*24*60*60*1000));
					document.cookie = "no_again_<?php echo $_page_id; ?>=1; expires=" + datetime.toUTCString();
				}
				$(this).closest('#popup_onload').fadeOut(400);
			});
	});
	
</script>
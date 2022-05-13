		<div class="popup-content" id="popup_onload"> 
			<div class="overlay-bg"><div class="lds-ripple"><div></div><div></div></div></div>
				<div class="popup-content-wrapper" id="popup-style-apply">
		<?php
		
		if($settings['end_date']) {
			$_id = lionthemes_make_id();
				$end = strtotime( $this->get_settings( 'end_date' ) );
				$now = strtotime('now');
				$left = $end - $now;
				$week_left = $day_left = $hours_left = $mins_left = $secs_left = 0;
				if ($left > 0) {
					$day_left = floor($left / (24 * 60 * 60));
					$week_left = floor($day_left / 7);
					$hours_left = floor(($left - ($day_left * 60 * 60 * 24)) / (60 * 60));
					$mins_left = floor(($left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60)) / 60);
					$secs_left = floor($left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60) - ($mins_left * 60));
			}
		}
		
		
		switch ($settings['columns']) {
			case '6':
				$class_column='col-lg-2 col-md-3 col-sm-4 col-xs-12';
				break;
			case '5':
				$class_column='col-lg-20 col-md-3 col-sm-4 col-xs-12';
				break;
			case '4':
				$class_column='col-lg-3 col-md-4 col-sm-6 col-xs-12';
				break;
			case '3':
				$class_column='col-md-4 col-sm-6 col-xs-12';
				break;
			case '2':
				$class_column='col-md-6 col-sm-6 col-xs-12';
				break;
			case '1':
				$class_column='col-md-12 col-sm-12 col-xs-12';
				break;	
			default:
				$class_column='col-md-3 col-sm-6 col-xs-12';
				break;
		}
		if($settings['type']) {
			$_id = lionthemes_make_id();
			$show_rating = $is_deals = false;
			$show_rating=true;
			if($settings['type'] == 'deals') $is_deals=true;
			
			$loop = orfarm_woocommerce_query($settings['type'], $settings['number'], $settings['in_category']);
			$autoplay = (($settings['autoplay'] != '') ? true : false);
			
			$owl_data = 'data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-dots="'. ($settings['enable_dots'] == 'yes' ? 'true' : 'false') .'" ';
			$owl_data .= 'data-nav="'. ($settings['enable_nav'] == 'yes' ? 'true' : 'false') .'" '; 
			$owl_data .= 'data-bigdesk="'. esc_attr($settings['bigdesk']) .'" ';
			$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
			$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
			$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
			$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
			$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
			$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
			$owl_data .= 'data-item-slide="'. esc_attr($settings['columns']) .'" ';
			$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
			$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
			$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" ';
		
			if ( $loop->have_posts() ) {
			?>
			<?php $_total = $loop->found_posts > $settings['number'] ? $settings['number'] : $loop->found_posts; ?>
			<div id="countdown-event-<?php echo $_id ?>"  class="woocommerce<?php echo (($settings['el_class'] != '') ? ' '. $settings['el_class'] : ''); ?> <?php echo (($settings['style'] != '') ? ' '. $settings['style'] : ''); ?>">
				<?php if($settings['title'] || $settings['short_desc'] ){ ?>
					<div class="element-widget-title">
						<?php if($settings['title']){ ?>
							<h3 class="vc_widget_title vc_products_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?> <?php echo (($settings['style'] != '') ? ' '. $settings['style'] : ''); ?>">
								<span><?php echo wp_kses($settings['title'], array('strong' => array())) ?></span>
							</h3>
						<?php } ?>
						<?php if($settings['end_date']) { ?> 
						  <div class="countdown">
							<div class="event-ended<?php echo $left > 0 ? ' d-none': ''; ?>"><span><?php echo esc_html__('The event has ended', 'orfarm') ?></span></div>
							<div class="countdown-sections<?php echo $left <= 0 ? ' d-none': ''; ?>">
								<span class="countdown-section">
									<span class="countdown-val days_left"><?php echo ''.$day_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Days', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val hours_left"><?php echo ''.$hours_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Hrs', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val mins_left"><?php echo ''.$mins_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Mins', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val secs_left"><?php echo ''.$secs_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Secs', 'orfarm'); ?></span>
								</span>
							</div>
						</div>
						<?php } ?>
						<?php if($settings['short_desc']){ ?>
							<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
								<p><?php echo nl2br(strip_tags($settings['short_desc'])); ?></p>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div id="products-element-<?php echo $_id ?>" class="inner-content<?php echo ($is_deals) ? ' deal-layout ' . $settings['deal_style'] : ''; ?>">
					<?php wc_get_template( 'product-layout/'.$settings['style'].'.php', array( 
						'show_rating' => $show_rating,
						'showsold' => $settings['show_sold'],
						'hideactions' => ($settings['hide_actions'] == 'yes'),
						'hidecategories' => ($settings['hide_categories'] == 'yes'),
						'showdesc' => $settings['show_desc'],
						'loop'=>$loop,
						'columns_count'=>$settings['columns'],
						'class_column' => $class_column,
						'_total'=>$_total,
						'number'=>$settings['number'],
						'rows'=>$settings['rows'],
						'isdeals' => $is_deals,
						'itemlayout'=> $settings['item_layout'],
						'showoneffect' => $settings['showon_effect'],
						'owl_data' => $owl_data
						) ); ?>
				</div>
			</div>
				<?php if ($settings['end_date'] && $left > 0) { ?>
			<script>
				jQuery(document).ready(function($) {
					var countdown_event_<?php echo $_id ?> = null;
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (countdown_event_<?php echo $_id ?>) clearInterval(countdown_event_<?php echo $_id ?>);
					<?php } ?>
					countdown_event_<?php echo $_id ?> = setInterval(function(){
						var me = $('#countdown-event-<?php echo $_id ?>');
						var days = parseInt(me.find('.days_left').text());
						var hours = parseInt(me.find('.hours_left').text());
						var mins = parseInt(me.find('.mins_left').text());
						var secs = parseInt(me.find('.secs_left').text());
						if (days > 0 || hours > 0 || mins > 0 || secs > 0) {
							if (secs == 0) {
								secs = 59;
								if (mins == 0) {
									mins = 59;
									if (hours == 0) {
										hours = 23;
										if ((days = 0)) {
											hours = 0;
											mins = 0;
											secs = 0;
										} else {
											days = days - 1;
										}
									} else {
										hours = hours - 1;
									}
								} else {
									mins = mins - 1;
								}
							} else {
								secs = secs - 1;
							}
							if (days > 0) {
								me.find('.weeks_left').html(Math.floor(days / 7));
							}
							me.find('.days_left').html(days);
							me.find('.hours_left').html(hours);
							me.find('.mins_left').html(mins);
							me.find('.secs_left').html(secs);
						} else {
							me.find('.event-ended').removeClass('d-none');
							me.find('.countdown-sections').addClass('d-none');
							clearInterval(countdown_event_<?php echo $_id ?>);
						}
					}, 1000);
				});
			</script>
				<?php } ?>
			<?php 
			if ($settings['style'] == 'carousel') { ?>
				<script>
					jQuery(document).ready(function($) {
						<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
						if (typeof owlCarousel !== "undefined") $('#products-element-<?php echo $_id ?> [data-owl="slide"]').owlCarousel('destroy');
						<?php } ?>
						if (typeof initOwl !== "undefined") initOwl($('#products-element-<?php echo $_id ?> [data-owl="slide"]'));
					});
				</script>
			<?php }
			}
		}
		?>
				<p class="no-thanks"><?php echo esc_html__('No Thank ! I am not interested in this promotion', 'orfarm'); ?></p>
				<label class="not-again"><input type="checkbox" value="1" name="not-again" /><span><?php echo esc_html__('Do not show this popup again', 'orfarm'); ?></span></label>
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
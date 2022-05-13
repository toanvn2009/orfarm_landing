<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_CountdownEvent_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'countdownevent';
	}

	public function get_title() {
		return __( 'Countdown Event', 'orfarm' ); 
	}
	public function get_icon() {
		return 'fa fa-bomb';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'general_opt',
			[
				'label' => __( 'General', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'label_block' => true,
			]
        );
        $this->add_control(
			'alignment',
			[
				'label' => __( 'Title alignment', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'orfarm' ),
					'center' => esc_html__( 'Center', 'orfarm' ),
					'right' => esc_html__( 'Right', 'orfarm' ),
				],
				'default' => 'center'
			]
		);
        $this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'label_block' => true,
			]
        );
		$this->add_control(
			'background',
			[
				'label' => __( 'Background banner', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);
        $this->add_control(
			'end_date',
			[
				'label' => __( 'Finish Event Date/Time', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);
		$this->add_control(
			'more_info',
			[
				'label' => __( 'Link more info', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'orfarm' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
        );
        $this->add_control(
			'el_class',
			[
				'label' => __( 'Extra class', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		?>
		<?php if($settings['end_date']) {
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
		?>
            <div id="countdown-event-<?php echo $_id ?>" class="countdown-event <?php echo esc_attr($settings['el_class']); ?>"<?php echo (!empty($settings['background']['url'])) ? ' style="background-image: url('. $settings['background']['url'] .')"' : '' ?>>
            	<?php if ($settings['title'] || $settings['sub_title']) { ?>
	            	<div class="element-widget-title"> 
		                <?php if($settings['title']) { ?>
		                    <h3 class="vc_widget_title vc_countdownevent_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
		                        <span><?php echo esc_html($settings['title']); ?></span>
		                    </h3>
		                <?php } ?>
		                <?php if($settings['sub_title']){ ?>
		                    <div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
		                        <?php echo $settings['sub_title']; ?>
		                    </div>
		                <?php } ?>
		            </div>
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
                <?php if($settings['more_info']){ ?>
                    <a class="more-info-btn" href="<?php echo $settings['more_info']['url']; ?>"<?php echo ($settings['more_info']['is_external']) ? ' target="_blank"' : '' ?><?php echo ($settings['more_info']['nofollow']) ? ' rel="nofollow"' : '' ?>><?php echo esc_html__('Shop Now', 'orfarm'); ?></a>
                <?php } ?>
            </div>
			<?php if ($left > 0) { ?>
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
        <?php } 
    }
}
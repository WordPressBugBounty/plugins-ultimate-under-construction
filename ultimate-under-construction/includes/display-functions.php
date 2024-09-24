<?php
/**
 * Display Functions
 *
 * Loads the functionality for the front end holding page.
 *
 * @package Ultimate Under Construction
 */

add_action( 'wp_enqueue_scripts', 'uuc_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function uuc_enqueue_scripts() {
	wp_enqueue_script( 'uuc_base', UUC_PLUGIN_URL . 'js/base.js', array(), filemtime( UUC_PLUGIN_DIR . 'js/base.js' ), array( 'in_footer' => false ) );
	wp_enqueue_script( 'uuc_flipclock', UUC_PLUGIN_URL . 'js/flipclock.js', array(), filemtime( UUC_PLUGIN_DIR . 'js/flipclock.js' ), array( 'in_footer' => false ) );
	wp_enqueue_script( 'uuc_counter', UUC_PLUGIN_URL . 'js/dailycounter.js', array(), filemtime( UUC_PLUGIN_DIR . 'js/dailycounter.js' ), array( 'in_footer' => false ) );

	wp_enqueue_style( 'uuc_flipclock_styles', UUC_PLUGIN_URL . 'css/base.css', array(), filemtime( UUC_PLUGIN_DIR . 'css/base.css' ), array( 'in_footer' => false ) );
}

// Display functions for outputting data.
add_filter( 'get_header', 'uuc_add_content' );

/**
 * Add UUC Content.
 */
function uuc_add_content() {
	global $uuc_options;

	// Current version of WP seems to fall over on unticked Checkboxes... This is to tidy it up and stop unwanted 'Notices'.
	// Enable Checkbox Sanitization.
	if ( ! isset( $uuc_options['enable'] ) || '1' != $uuc_options['enable'] ) {
		$uuc_options['enable'] = 0;
	} else {
		$uuc_options['enable'] = 1;
	}

	// Countdown Checkbox Sanitization.
	if ( ! isset( $uuc_options['cdenable'] ) || '1' != $uuc_options['cdenable'] ) {
		$uuc_options['cdenable'] = 0;
	} else {
		$uuc_options['cdenable'] = 1;
	}

	if ( 1 == $uuc_options['enable'] ) {

		?>
		<!DOCTYPE html>
		<script language="JavaScript">
			TargetDate = "<?php echo esc_html( $uuc_options['cdmonth'] ), '/', esc_html( $uuc_options['cdday'] ), '/', esc_html( $uuc_options['cdyear'] ); ?>";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true;
			DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds ";
			FinishMessage = "It is finally here!";
		</script>

		<script src="//code.jquery.com/jquery-latest.min.js"></script>

		<?php
		echo wp_kses(
			'<script src="' . plugin_dir_url( __FILE__ ) . 'js/base.js"></script>',
			array(
				'script' => array(
					'src' => array(),
				),
			)
		);
		echo wp_kses(
			'<script src="' . plugin_dir_url( __FILE__ ) . 'js/flipclock.js"></script>',
			array(
				'script' => array(
					'src' => array(),
				),
			)
		);
		echo wp_kses(
			'<script src="' . plugin_dir_url( __FILE__ ) . 'js/dailycounter.js"></script>',
			array(
				'script' => array(
					'src' => array(),
				),
			)
		);
		echo wp_kses(
			'<link rel="stylesheet" href="' . plugin_dir_url( __FILE__ ) . 'css/flipclock.css">',
			array(
				'link' => array(
					'rel'  => array(),
					'href' => array(),
				),
			)
		);
		$html = '';
		?>

		<script type="text/javascript">
			var clock;

			$(document).ready(function () {

				// Grab the current date
				var currentDate = new Date();

				// Set some date in the future.
				var selecteddate = new Date("<?php echo esc_html( $uuc_options['cdyear'] ), '/', esc_html( $uuc_options['cdmonth'] ), '/', esc_html( $uuc_options['cdday'] ); ?>");

				// Calculate the difference in seconds between the future and current date
				var diff1 = selecteddate.getTime() / 1000 - currentDate.getTime() / 1000;

				var diff = (diff1 <= 0) ? "0" : diff1;

				// Instantiate a coutdown FlipClock

				clock = $('.clock').FlipClock(diff, {
					clockFace: 'DailyCounter',
					countdown: true
				});
			});
		</script>
		<?php

		if ( isset( $uuc_options['cdday'] ) ) {
			$entereddate = ( $uuc_options['cdyear'] . '-' . esc_html( $uuc_options['cdmonth'] ) . '-' . esc_html( $uuc_options['cdday'] ) . ' ' . '00:00:00' );
			$cddates     = strtotime( $entereddate );
		}

		if ( ! is_admin() && ! is_user_logged_in() && true == $uuc_options['enable'] && 'htmlblock' == $uuc_options['holdingpage_type'] ) {

			$html .= '<div class="uuc-holdingpage">';
			if ( isset( $uuc_options['html_block'] ) ) {
				$html .= $uuc_options['html_block'];
			}
			$html .= '</div>';
			echo esc_html( $html );
			exit;
		} elseif ( ! is_admin() && ! is_user_logged_in() && true == $uuc_options['enable'] ) {

			if ( isset( $uuc_options['background_style'] ) && 'solidcolor' == $uuc_options['background_style'] ) {
				if ( isset( $uuc_options['background_color'] ) ) {
					?>
					<style type="text/css">
						body {
							background-color: <?php echo esc_html( $uuc_options['background_color'] ); ?>
						}

						.uuc-holdingpage {
							text-align: center;
							padding-top: 250px;
						}
					</style>
					<?php
				}
			} elseif ( isset( $uuc_options['background_style'] ) && 'patterned' == $uuc_options['background_style'] ) {
				if ( ! isset( $uuc_options['background_styling'] ) ) {
					?>
					<style type="text/css">
						body {
							background: url(<?php echo esc_html( plugin_dir_url( __FILE__ ) . '/images/oldmaths.png' ); ?>);
						}

						.uuc-holdingpage {
							text-align: center;
							padding-top: 250px;
						}
					</style>
					<?php
				} elseif ( isset( $uuc_options['background_styling'] ) ) {
					if ( 'darkbind' == $uuc_options['background_styling'] ) {
						?>
						<style type="text/css">
							body {
								background: url(<?php echo esc_html( plugin_dir_url( __FILE__ ) . 'images/' . $uuc_options['background_styling'] . '.png' ); ?>);
							}

							.uuc-holdingpage {
								text-align: center;
								color: #909090;
								padding-top: 250px;
							}
						</style>
					<?php } else { ?>
						<style type="text/css">
							body {
								background: url(<?php echo esc_html( plugin_dir_url( __FILE__ ) . 'images/' . $uuc_options['background_styling'] . '.png' ); ?>);
							}

							.uuc-holdingpage {
								text-align: center;
								padding-top: 250px;
							}
						</style>
						<?php
					}
				}
			}

			$html .= '<div class="uuc-holdingpage">';
			$html .= '<h1>' . $uuc_options['website_name'] . '</h1>';
			if ( isset( $uuc_options['holding_message'] ) ) {
				$html .= '<h2>' . $uuc_options['holding_message'] . '</h2>';
			}

			$htmlpart = '';

			if ( true == $uuc_options['cdenable'] ) {

				if ( 'flipclock' == $uuc_options['cd_style'] ) {
					$html .= '<div class="cddiv"><div class="clock" style="margin:2em;"></div></div>';
				} elseif ( 'textclock' == $uuc_options['cd_style'] ) {
					if ( $cddates > time() ) {
						$htmlpart  = '<h3>' . '<script src="' . plugin_dir_url( __FILE__ ) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>';
						$htmlpart .= ' ' . $uuc_options['cdtext'] . '</h3>';
					} else {
						$htmlpart  = '<h3>' . '<script src="' . plugin_dir_url( __FILE__ ) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>';
						$htmlpart .= '</h3>';
					}
				}
				$html .= $htmlpart;
			}
			$html .= '</div>';
			echo wp_kses(
				$html,
				'post'
			);
			?>
			<?php
			exit;
		}
	}
}

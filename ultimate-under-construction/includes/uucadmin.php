<?php
/**
 * Admin Settings page
 *
 * Loads the Settings page within the Admin area
 *
 * @package Ultimate Under Construction
 */

/**
 * Loads Options Page
 */
function uuc_options_page() {

	global $uuc_options;
	global $wp_version;

	ob_start(); ?>
	<div class="wrap">
		<div id="icon-tools" class="icon32"></div>
		<h2><?php esc_html_e( 'Ultimate Under Construction Plugin Options', 'ultimate-under-construction' ); ?></h2>

		<form method="post" action="options.php">

			<?php
			// Current version of WP seems to fall over on unticked Checkboxes... This is to tidy it up and stop unwanted 'Notices'.
			if ( ! empty( $uuc_options ) ) {
				// Enable Checkbox Sanitization.
				if ( ! isset( $uuc_options['enable'] ) || '1' !== $uuc_options['enable'] ) {
					$uuc_options['enable'] = 0;
				} else {
					$uuc_options['enable'] = 1;
				}

				// Countdown Checkbox Sanitization.
				if ( ! isset( $uuc_options['cdenable'] ) || '1' !== $uuc_options['cdenable'] ) {
					$uuc_options['cdenable'] = 0;
				} else {
					$uuc_options['cdenable'] = 1;
				}
			}

			settings_fields( 'uuc_settings_group' );
			?>

			<h4 class="uuc-title"></h4>
			<p>
				<input id="uuc_settings[enable]" name="uuc_settings[enable]" type="checkbox" value="1" <?php checked( ( ! empty( $uuc_options ) ) ? $uuc_options['enable'] : '0', '1' ); ?>/>
				<label class="description" for="uuc_settings[enable]"><?php esc_html_e( 'Enable the Under Construction Page', 'ultimate-under-construction' ); ?></label>

			<h4 class="uuc-title"><?php esc_html_e( 'Holding Page Type', 'ultimate-under-construction' ); ?></h4>
			<p>
				<label>
					<input onclick="checkPage()" class="check-page" type="radio" name="uuc_settings[holdingpage_type]" id="htmlblock" value="htmlblock"
						<?php
						if ( ! isset( $uuc_options['holdingpage_type'] ) ) {
							?>
							checked 
							<?php
						} else {
							checked( 'htmlblock' == $uuc_options['holdingpage_type'] );
						}
						?>
					/>
					<?php esc_html_e( 'HTML Block', 'ultimate-under-construction' ); ?>
				</label>
				<br/>
				<label>
					<input onclick="checkPage()" class="check-page" type="radio" name="uuc_settings[holdingpage_type]" id="custom" value="custom"<?php checked( ( ! empty( $uuc_options ) ) ? 'custom' == $uuc_options['holdingpage_type'] : '' ); ?> />
					<?php esc_html_e( 'Custom Build', 'ultimate-under-construction' ); ?>
				</label><br/>
			</p>

			<div id="htmlblockbg" 
			<?php
			if ( ! empty( $uuc_options ) && 'custom' === $uuc_options['holdingpage_type'] ) {
				?>
				style="visibiliy: hidden; display: none;"<?php } ?>>
				<h4 class="uuc-title"><?php esc_html_e( 'HTML Block', 'ultimate-under-construction' ); ?></h4>
				<p>
					<textarea class="theEditor" name="uuc_settings[html_block]" id="uuc_settings[html_block]" rows="10" cols="75">
						<?php
						if ( isset( $uuc_options['html_block'] ) ) {
							echo wp_kses(
								$uuc_options['html_block'],
								array(
									'a'      => array(
										'href'  => array(),
										'title' => array(),
									),
									'br'     => array(),
									'em'     => array(),
									'strong' => array(),
									'p'      => array(),
								)
							);
						}
						?>
					</textarea>
					<label class="description" for="uuc_settings[html_block]">
						<br />
						<?php esc_html_e( 'Enter the HTML - Advised for advanced users only!', 'ultimate-under-construction' ); ?>
						<br />
						<?php esc_html_e( 'Will display exactly as entered.', 'ultimate-under-construction' ); ?>
					</label>
				</p>
			</div>

			<div id="custombg" 
			<?php
			if ( ( ! empty( $uuc_options ) ) ? 'htmlblock' === $uuc_options['holdingpage_type'] : '' ) {
				?>
				style="visibility: hidden; display: none;"<?php } ?>>
				<h4 class="uuc-title"><?php esc_html_e( 'Website Title', 'ultimate-under-construction' ); ?></h4>
				<p>
					<input id="uuc_settings[website_name]" name="uuc_settings[website_name]" type="text"
							value="<?php echo esc_attr( ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['website_name'] ) : '' ); ?>"/>
					<label class="description"
							for="uuc_settings[website_name]"><?php esc_html_e( 'Enter the Title of your website', 'ultimate-under-construction' ); ?></label>
				</p>

				<h4 class="uuc-title"><?php esc_html_e( 'Holding Message', 'ultimate-under-construction' ); ?></h4>
				<p>
					<textarea id="uuc_settings[holding_message]" name="uuc_settings[holding_message]" rows="5"
								cols="50"><?php echo esc_attr( ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['holding_message'] ) : '' ); ?></textarea><br/>
					<label class="description"
							for="uuc_settings[holding_message]"><?php esc_html_e( 'Enter a message to appear below the Website Title', 'ultimate-under-construction' ); ?></label>
				</p>

				<h4 class="uuc-title"><?php esc_html_e( 'Countdown Timer', 'ultimate-under-construction' ); ?></h4>
				<p>
					<input id="uuc_settings[cdenable]" name="uuc_settings[cdenable]" type="checkbox" value="1" <?php checked( ( ! empty( $uuc_options ) ) ? $uuc_options['cdenable'] : '0', '1' ); ?>/>
					<label class="description" for="uuc_settings[cdenable]"><?php esc_html_e( 'Enable the Countdown Timer?', 'ultimate-under-construction' ); ?></label>
					<br/>
					<br/>
					<label>
						<input type="radio" name="uuc_settings[cd_style]" id="flipclock" value="flipclock"
							<?php
							if ( ! isset( $uuc_options['cd_style'] ) ) {
								?>
								checked 
								<?php
							} else {
									checked( 'flipclock' == $uuc_options['cd_style'] );
							}
							?>
						/>
						<?php esc_html_e( 'Flip Clock', 'ultimate-under-construction' ); ?>
					</label>
					<label>
						<input type="radio" name="uuc_settings[cd_style]" id="textclock" value="textclock"<?php checked( ( ! empty( $uuc_options ) ) ? 'textclock' == $uuc_options['cd_style'] : '' ); ?> />
						<?php esc_html_e( 'Text only.', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<br/>
					<input id="uuc_settings[cdday]" name="uuc_settings[cdday]" type="text" value="<?php echo ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['cdday'] ) : ''; ?>"/>
					<label class="description" for="uuc_settings[cdday]"><?php esc_html_e( 'Enter the Date - e.g. 14', 'ultimate-under-construction' ); ?></label>
					<br/>
					<input id="uuc_settings[cdmonth]" name="uuc_settings[cdmonth]" type="text" value="<?php echo ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['cdmonth'] ) : ''; ?>"/>
					<label class="description" for="uuc_settings[cdmonth]"><?php esc_html_e( 'Enter the Month - e.g. 2', 'ultimate-under-construction' ); ?></label>
					<br/>
					<input id="uuc_settings[cdyear]" name="uuc_settings[cdyear]" type="text" value="<?php echo ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['cdyear'] ) : ''; ?>"/>
					<label class="description" for="uuc_settings[cdyear]"><?php esc_html_e( 'Enter the Year -  e.g. 2014', 'ultimate-under-construction' ); ?></label>
					<br/>
					<input id="uuc_settings[cdtext]" name="uuc_settings[cdtext]" type="text" value="<?php echo ( ! empty( $uuc_options ) ) ? esc_attr( $uuc_options['cdtext'] ) : ''; ?>"/>
					<label class="description" for="uuc_settings[cdtext]"><?php esc_html_e( 'Enter the Countdown text - e.g. Till the site goes live!', 'ultimate-under-construction' ); ?></label>
				</p>

				<h4 class="uuc-title"><?php esc_html_e( 'Background Style', 'ultimate-under-construction' ); ?></h4>
				<p>
					<label>
						<input onclick="checkEm()" class="check-em" type="radio" name="uuc_settings[background_style]" id="solidcolor" value="solidcolor"
							<?php
							if ( ! isset( $uuc_options['background_style'] ) ) {
								?>
								checked 
								<?php
							} else {
									checked( 'solidcolor' === $uuc_options['background_style'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Solid Colour', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input onclick="checkEm()" class="check-em" type="radio" name="uuc_settings[background_style]" id="patterned" alue="patterned"<?php checked( ( ! empty( $uuc_options ) ) ? 'patterned' === $uuc_options['background_style'] : '' ); ?> />
						<?php esc_html_e( 'Patterned Background', 'ultimate-under-construction' ); ?>
					</label>
				</p>

				<?php if ( $wp_version >= 3.5 ) { ?>
					<div id="solidcolorbg"
						<?php
						if ( ! empty( $uuc_options ) && 'patterned' === $uuc_options['background_style'] ) {
							?>
							style="visibility: hidden; display: none;"<?php } ?>>
						<h4 class="uuc-title"><?php esc_html_e( 'Background Colour', 'ultimate-under-construction' ); ?></h4>
						<p>
							<input name="uuc_settings[background_color]" id="background-color" type="text" value="
							<?php
							if ( isset( $uuc_options['background_color'] ) ) {
								echo esc_attr( $uuc_options['background_color'] );
							}
							?>
							"/>
							<label class="description" for="uuc_settings[background_color]"><?php esc_html_e( 'Select the Background Colour', 'ultimate-under-construction' ); ?></label>
						</p>
					</div>
				<?php } else { ?>
					<div id="solidcolorbg"
						<?php
						if ( ! empty( $uuc_options ) && 'patterned' === $uuc_options['background_style'] ) {
							?>
							style="visibility: hidden; display: none;"<?php } ?>>
						<h4 class="uuc-title"><?php esc_html_e( 'Background Colour', 'ultimate-under-construction' ); ?></h4>
						<p>
						<div class="color-picker" style="position: relative;">
							<input type="text" name="uuc_settings[background_color]" id="color" value=" 
							<?php
							if ( isset( $uuc_options['background_color'] ) ) {
								echo esc_attr( $uuc_options['background_color'] );
							}
							?>
							"/>
							<div style="position: absolute;" id="colorpicker"></div>
						</div>
						</p>
					</div>
				<?php } ?>

				<div id="patternedbg"
					<?php
					if ( ! empty( $uuc_options ) && 'solidcolor' === $uuc_options['background_style'] ) {
						?>
						style="visibility: hidden; display: none;"<?php } ?>>
					<h4 class="uuc-title"></h4>
					<label>
						<input type="radio" name="uuc_settings[background_styling]" id="background_choice_one" value="squairylight"<?php checked( 'squairylight' === isset( $uuc_options['background_styling'] ) ); ?> />
						<?php esc_html_e( 'Squairy', 'ultimate-under-construction' ); ?>
					</label><br/>
					<label>
						<input type="radio" id="background_choice_two" name="uuc_settings[background_styling]"
									value="lightbind" 
									<?php
									if ( ! isset( $uuc_options['background_styling'] ) ) {
										?>
										checked 
										<?php
									} else {
										checked( 'lightbind' === $uuc_options['background_styling'] );
									}
									?>
						/> 
						<?php esc_html_e( 'Light Binding', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_three" name="uuc_settings[background_styling]" value="darkbind" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
								checked( 'darkbind' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Dark Binding', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_four" name="uuc_settings[background_styling]" value="wavegrid" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
								checked( 'wavegrid' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Wavegrid', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_five" name="uuc_settings[background_styling]" value="greywashwall" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
								checked( 'greywashwall' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Gray Wash Wall', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_six" name="uuc_settings[background_styling]" value="flatcardboard" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
								checked( 'flatcardboard' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Cardboard Flat', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_seven" name="uuc_settings[background_styling]" value="pooltable" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
								checked( 'pooltable' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Pool Table', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
					<label>
						<input type="radio" id="background_choice_eight" name="uuc_settings[background_styling]" value="oldmaths" 
							<?php
							if ( ! isset( $uuc_options['background_styling'] ) ) {
								?>
								checked 
								<?php
							} else {
									checked( 'oldmaths' === $uuc_options['background_styling'] );
							}
							?>
						/> 
						<?php esc_html_e( 'Old Mathematics', 'ultimate-under-construction' ); ?>
					</label>
					<br/>
				</div>
			</div>

			<?php if ( $wp_version >= 3.5 ) { ?>
					<div id="fontcolor">
						<h4 class="uuc-title"><?php esc_html_e( 'Font Colour', 'ultimate-under-construction' ); ?></h4>
						<p>
							<input name="uuc_settings[font_color]" id="font-color" type="text" value="
							<?php
							if ( isset( $uuc_options['font_color'] ) ) {
								echo esc_attr( $uuc_options['font_color'] );
							}
							?>
							"/>
							<label class="description" for="uuc_settings[font_color]"><?php esc_html_e( 'Select the Background Colour', 'ultimate-under-construction' ); ?></label>
						</p>
					</div>
				<?php } else { ?>
					<div id="fontcolor" >
						<h4 class="uuc-title"><?php esc_html_e( 'Font Colour', 'ultimate-under-construction' ); ?></h4>
						<p>
						<div class="color-picker" style="position: relative;">
							<input type="text" name="uuc_settings[font_color]" id="color" value=" 
							<?php
							if ( isset( $uuc_options['font_color'] ) ) {
								echo esc_attr( $uuc_options['font_color'] );
							}
							?>
							"/>
							<div style="position: absolute;" id="colorpicker"></div>
						</div>
						</p>
					</div>
				<?php } ?>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Options', 'ultimate-under-construction' ); ?>"/>
			</p>

		</form>
	</div>
	</div>
	<?php
	echo wp_kses(
		ob_get_clean(),
		array(
			'before'   => array(),
			'a'        => array(
				'href'  => array(),
				'title' => array(),
			),
			'br'       => array(),
			'em'       => array(),
			'strong'   => array(),
			'p'        => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'h3'       => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'h4'       => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'h1'       => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'h2'       => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'div'      => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
			),
			'span'     => array(),
			'img'      => array(),
			'form'     => array(
				'class'  => array(),
				'method' => array(),
				'action' => array(),
				'id'     => array(),
			),
			'label'    => array(),
			'textarea' => array(
				'class' => array(),
				'style' => array(),
				'id'    => array(),
				'name'  => array(),
				'rows'  => array(),
				'cols'  => array(),
			),
			'input'    => array(
				'class'   => array(),
				'type'    => array(),
				'id'      => array(),
				'name'    => array(),
				'value'   => array(),
				'onclick' => array(),
				'before'  => array(),
				'checked' => array(),
			),
			':before'  => array(),
			'script'   => array(),
		)
	);
}

add_action( 'admin_enqueue_scripts', 'admin_register_style' );
/**
 * Output admin page styles.
 */
function admin_register_style() {
	wp_enqueue_style( 'uuc_admin_style', UUC_PLUGIN_URL . 'includes/css/plugin_styles.css', array(), UUC_VERSION );
	wp_enqueue_script( 'uuc_admin_script', UUC_PLUGIN_URL . 'includes/js/uuc-admin.js', array(), UUC_VERSION, array( 'in_footer' => true ) );
}

add_action( 'admin_menu', 'uuc_add_options_link' );
/**
 * Set up Settings page
 */
function uuc_add_options_link() {
	add_options_page( 'Ultimate Under Construction Plugin Options', 'Ultimate Under Construction', 'manage_options', 'uuc-options', 'uuc_options_page' );
}

add_action( 'admin_init', 'uuc_register_settings' );
/**
 * Register Settings group
 */
function uuc_register_settings() {
	register_setting( 'uuc_settings_group', 'uuc_settings' );
}

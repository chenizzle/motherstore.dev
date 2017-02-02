<!-- SUBSCRIBE popup -->
<div id="subscribe-popup" class="subscribe-popup">
	<div id="subscribe-popup-close" class="subscribe-popup__overlay"></div>
	<div class="subscribe-popup__box valign-middle clearfix">
		<div class="subscribe-popup__image" style="background-image: url(<?php echo esc_url( mnml_themeoption('subscribe-popup-image') ); ?>"></div>
		<div class="subscribe-popup__content">
			<span class="subscribe-popup__close"></span>
			<span class="subscribe-popup__title"><?php echo mnml_themeoption('subscribe-title'); ?></span>
			<span class="subscribe-popup__subtitle"><?php echo mnml_themeoption('subscribe-subtitle'); ?></span>
			<!-- Retrieving the shortcode from the panel -->
			<?php 
			$mnml_panel_html_shortcode = mnml_themeoption('subscribe-shortcode-or-html');
			
			if ( $mnml_panel_html_shortcode ){
				$mnml_sc_content = do_shortcode($mnml_panel_html_shortcode);
				if ( $mnml_sc_content ){
					echo $mnml_sc_content;
				} else {
					esc_html_e( 'Your shortcode didn\'t generate any results!', 'mnml-shop' );
				}
			} else {
				esc_html_e( 'Shortcode field is empty!', 'mnml-shop' );
			}
			?>
		</div>
	</div>
</div>



			<div class="footer-container s-container">
				<footer class="footer">

					<div class="footer__top clearfix">

						<?php
						##  Footer Navigation
						$mnml_navargs = array(
						   	'container'		  => 'ul',
						   	'container_class' => 'menu',
						   	'container_id'	  => '',
						    'echo'            => false,
						    'theme_location' => 'footer-navigation',
						    'fallback_cb'     => 'mnml_nomenu',
						    'items_wrap'      => '<ul class="footer-nav">%3$s</ul>',
						    'depth'           => 0,
						);
						$mnml_footer_nav = wp_nav_menu( $mnml_navargs );
						?>
						<!-- footer navigation -->
						<nav class="footer-nav-wrapper">
							<?php echo $mnml_footer_nav; ?>
						</nav>

						<?php 
						if (mnml_themeoption('use-subscribe-area') === "on"){
						?>
						<!-- subscribe -->
						<div class="subscribe-wrapper">
							<a href="#" id="subscribe-link"><?php esc_html_e('Subscribe','mnml-shop'); ?><i></i></a>
						</div>
						<?php
						}
						?>

						<!-- social profile links -->
						<?php 
						if (mnml_themeoption('use-socialicons') === "on"){
							echo do_shortcode('[the1-socialicons]');
						}
						?>

					</div>

					<!-- copyright -->
					<?php 
					$mnml_allowed_html_copyright = array(
						//formatting
					    'a' => array(
							'href' => array(),
						),
					);
					?>
					<div class="copyright"><?php echo wp_kses(stripslashes(mnml_themeoption('copyright-text')),$mnml_allowed_html_copyright);?></div>
				</footer>
			</div>


		</div><!-- end: #wrapper__inner -->
	</div><!-- end: #wrapper -->


	<?php if (mnml_themeoption('use-subscribe-area') === "on") { get_template_part('template-parts/subscribe'); }?>


	
	<?php wp_footer(); ?>
</body>
</html>
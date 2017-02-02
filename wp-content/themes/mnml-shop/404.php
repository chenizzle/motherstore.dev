<?php get_header(); ?>

	<div class="s-container">
	<div id="content">	

		<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( '404', 'mnml-shop' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporary unavaliable', 'mnml-shop' ); ?></p>

					<div class="ts-button ts-align-center"><a class="button button-hover--fill button-hover--2" href="<?php echo home_url(); ?>"><?php esc_html_e( 'Homepage', 'mnml-shop' ); ?></a></div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

	</div>
	</div>

	

<?php get_footer(); ?>
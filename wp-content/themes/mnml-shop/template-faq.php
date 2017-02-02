<?php
/* Template name: FAQ */
get_header(); ?>

	<div class="s-container">
	<div id="content" class="content">	

		<?php 
		if ( have_posts() ){
			while ( have_posts() ){
				the_post();
				?>
				<div <?php post_class(); ?>>

					<!-- Main Banner Area -->
					<div class="mainbanner-area-container s-container">
						<div class="mainbanner-area <?php echo $mnml_css_class; ?>">

							<?php 

							# inner content of the main banner
							the_content();

							# vertical social links
							get_template_part( 'template-parts/sidelinks' ); 

							?>

						</div>
					</div>
					
					<?php 
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				    ?>
				</div>
				<?php
			}
		} else {
			echo _x( 'Sorry, no posts matched your criteria.', 'No Posts msg', 'mnml-shop' );
		}
		?>

	</div>
	</div>

	
<?php get_footer(); ?>
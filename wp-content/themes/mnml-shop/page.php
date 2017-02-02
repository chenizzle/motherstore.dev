<?php get_header(); ?>


	<!-- Main Banner -->
	<?php get_template_part('template-parts/mainbanner'); ?>

	<div class="s-container">
	<div id="content" class="content">	

		<?php 
		if ( have_posts() ){
			while ( have_posts() ){
				the_post();
				?>
				<div <?php post_class(); ?>>

					<!-- content -->
					<div class="post-content"><?php the_content(); ?></div>

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
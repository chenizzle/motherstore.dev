<?php get_header(); ?>

	<?php get_template_part('template-parts/mainbanner','catalogue'); ?>

	<div id="content" class="s-padding-x3 s-container" style="padding-top: 0;">	

		<div class="blog-wrapper s-row">
			<?php 
			if ( have_posts() ){
				while ( have_posts() ){
					the_post();
					?>
					<div <?php post_class('blog-post s-col-6'); ?>>
						<?php
						if ( has_post_thumbnail() ){
							echo '<a href="'.get_permalink().'" class="blog-post__thumbnail image-to-load">';
							the_post_thumbnail();
							echo '</a>';
						}
						?>
						<div class="blog-post__category"><?php echo get_the_category_list(', ','',get_the_id()); ?></div>
						<h1 class="blog-post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						<div class="blog-post__content"><?php the_excerpt(); ?></div>
						<div class="blog-post__date"><?php echo get_the_date(); ?></div>
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
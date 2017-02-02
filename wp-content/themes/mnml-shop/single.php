<?php get_header(); ?>


	<div id="content" class="content content--blog-post content--padding">	

		<?php 
		if ( have_posts() ){
			while ( have_posts() ){
				the_post();
				?>
				<div <?php post_class(); ?>>

					<div class="post-header">
						<!-- title -->
						<h1 class="post-title"><?php the_title(); ?></h1>
						<!-- date -->
						<div class="post-date"><?php echo get_the_date(); ?></div>
					</div>

					<!-- thumbnail -->
					<div class="post-thumbnail">
						<?php
						if ( has_post_thumbnail() ){
							the_post_thumbnail();
						}
						?>
					</div>

					<!-- content -->
					<div class="post-content">
					<?php the_content(); ?>
					<?php
                    $mnml_args = array(
                        'before'	=> '<div class="post-section post-pagination">' . _x( 'Page:', 'Paginated posts label', 'mnml-shop' ),
                            'after'		=> '</div>',
                            'pagelink'	=> '<span>%</span>',
                    );
                    wp_link_pages($mnml_args);
					?>	

					</div>
					
					<!-- post tags -->
					<?php mnml_get_tags_list(); ?>

					<!-- share post  -->
					<div class="post-share">
						<?php mnml_share_post(); ?>
					</div>

					<!-- related posts -->
					<?php get_template_part('template-parts/related-posts'); ?>

					<!-- Comments Section -->
					<?php comments_template();  ?>

				</div>
				<?php
			}
		} else {
			echo _x( 'Sorry, no posts matched your criteria.', 'No Posts msg', 'mnml-shop' );
		}
		?>

	</div>

	











<?php get_footer(); ?>
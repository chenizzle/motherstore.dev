<?php get_header(); ?>
	
	<div class="s-container">
	<div id="content">	

		<div class="blog-wrapper s-row">
			<?php 
			if ( have_posts() ){
				$mnml_post_counter = 0;
				while ( have_posts() ){
					the_post();
					if ($mnml_post_counter === 0){
						$mnml_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()),'large');
						$mnml_featured_image_source = $mnml_featured_image[0];
					?>
						<!-- Main Banner Area -->
						<div class="mainbanner-area-container s-container">
							<div class="mainbanner-area">

								<!-- Main Banner -->
								<div class="titlebar image-to-load titlebar--x3 titlebar-blog">
									<div class="titlebar__image__overlayer"></div>
									<div class="titlebar__content__blog">
										<div class="titlebar__small__blog"><?php echo get_the_category_list(', ','',get_the_id()); ?></div>
										<a href="<?php the_permalink(); ?>" class="titlebar__big__blog"><?php the_title(); ?></a>
									</div>
									<?php if ( $mnml_featured_image_source ){ echo '<img src="'.esc_url($mnml_featured_image_source).'">'; } ?>
								</div>
								<?php 
								# vertical social links
								get_template_part( 'template-parts/sidelinks' ); 
								?>
							</div>
						</div>

					<?php 
					}
					else {
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
				$mnml_post_counter++;
				}
				?>
				<!-- Pagination Links -->
					<div class="s-col-12 pagination-links clearfix">
						<div class="nav-previous align-right font-1"><?php next_posts_link( _x('Older posts','Older posts text','mnml-shop') ); ?></div>
						<div class="nav-next align-left font-1"><?php previous_posts_link( _x('Newer posts','Newer posts text','mnml-shop') ); ?></div>
					</div>
				<?php
			} else {
				echo _x( 'Sorry, no posts matched your criteria.', 'No Posts msg', 'mnml-shop' );
			}
			?>
		</div>

	</div>
	</div>

	

<?php get_footer(); ?>
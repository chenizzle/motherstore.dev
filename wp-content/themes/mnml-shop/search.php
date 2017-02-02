<?php get_header(); ?>

	<div class="s-container">
	<div id="content">	

		<div class="titlebar titlebar-search titlebar--x1">
			<div class="titlebar__content">
				<div class="titlebar__big"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;<?php printf( __( 'Search Results for: %s', 'mnml-shop' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></div>
			</div>
		</div>
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
				?>
				<!-- Pagination Links -->
					<div class="s-col-12 pagination-links clearfix">
						<div class="nav-previous align-right font-1"><?php next_posts_link( _x('Older posts','Older posts text','mnml-shop') ); ?></div>
						<div class="nav-next align-left font-1"><?php previous_posts_link( _x('Newer posts','Newer posts text','mnml-shop') ); ?></div>
					</div>
				<?php
			} else {
				echo '<div class="not-found-wrapper">';
				echo '<h2 class="not-found">'._x( 'Sorry, no posts matched your criteria.', 'No Posts msg', 'mnml-shop' ).'</h2>';
				echo '</div>';
			}
			?>
		</div>

	</div>
	</div>

	

<?php get_footer(); ?>
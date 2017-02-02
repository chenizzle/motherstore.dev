<?php
$mnml_post_retreiver_class = new Mnml_Related_Posts;
$mnml_related_posts_ids = $mnml_post_retreiver_class->the1_related_posts_array(3);
if (is_array($mnml_related_posts_ids) && !empty($mnml_related_posts_ids)){ 
?>
<div class="post-related">

	<div class="post-related__header">
		<h3><?php esc_html_e( 'Related Posts', 'mnml-shop' );?></h3>
	</div>

	<div class="s-row">
		
			<?php
			foreach ($mnml_related_posts_ids as $mnml_single_id) {
				$mnml_single_title = get_the_title($mnml_single_id);
				$mnml_single_permalink = get_permalink($mnml_single_id);
				$mnml_featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($mnml_single_id),'large');
				$mnml_featured_image_source = $mnml_featured_image[0];
		?>
		<div class="s-col-4">
			<div class="post-related__single">
				<?php if ($mnml_featured_image_source) {?>
				<div class="post-related__thumbnail">
					<?php echo '<img src="'.esc_html($mnml_featured_image_source).'" />';?>
				</div>
				<?php    }
			    ?>
				<h3 class="post-related__title"><a href="<?php echo $mnml_single_permalink; ?>"><?php echo $mnml_single_title; ?></a></h3>
				<div class="post-related__category"><?php echo get_the_category_list(', ','',$mnml_single_id); ?></div>
			</div>
		</div>
		<?php
			}
		?>

	</div>



</div>
<?php } ?>
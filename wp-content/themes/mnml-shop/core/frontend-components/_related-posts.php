<?php
class Mnml_Related_Posts {
	public $post_counter;
	public $post_category;
	public $current_post_id;
	
	public function the1_related_posts_array($post_count){
		$tag_ids = $this->the1_related_posts_tag($post_count);	
		
		return $tag_ids;
		
	}

	function the1_related_posts_tag($post_count){
		$post_counter = 0;
		$post_ids = array();
		global $post;
		$tags = wp_get_post_tags($post->ID);
		$this->current_post_id = $post->ID;
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=>$post_count, // Number of related posts that will be shown.
			'ignore_sticky_posts'=>1
			);
			$my_query = new wp_query( $args );
			
		
			## Retrieving ids from tags
			if( $my_query->have_posts() ) {
				while( $my_query->have_posts() ) {
					$my_query->the_post(); 
					$post_counter++;
					$post_ids[] = get_the_id();
				}
			}
			## end: tag ids
		}
		wp_reset_query();
		$this->post_counter=$post_counter;
		return $post_ids;
	}
}
?>
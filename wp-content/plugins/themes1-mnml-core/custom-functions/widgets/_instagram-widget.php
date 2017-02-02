<?php

	function mnml_register_instagram_widget() {
		register_widget( 'mnml_instagram_widget' );
	}
	add_action( 'widgets_init', 'mnml_register_instagram_widget' );
	



###	Twitter widget backend
	class mnml_instagram_widget extends WP_Widget {
	
		function __construct() {
			$widget_ops = array(
				'classname' => 'themes1-instagram-feed',
				'description' => esc_html__( 'Displays your latest Instagram photos', 'mnml' ) 
			);
			parent::__construct( 
				'themes1-instagram-feed',
				'Themes1 | Instagram',
				$widget_ops
			);
		}
	
	
		##	Backend
		function form( $instance ) {
			$instance = wp_parse_args( 
				(array) $instance, 
				array( 
					'title' => esc_html__( 'Instagram', 'mnml' ),
					'username' => '',
					'link' => esc_html__( 'Follow Us', 'mnml' ),
					'number' => 10,
					'target' => '_self' 
				) 
			);
			?>
			
            <p>
            	<?php 
				$title = esc_attr( $instance['title'] );
				$fid_title = $this->get_field_id( 'title' ); 
				$fnm_title = $this->get_field_name( 'title' ); 
				?>
            	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
					<?php esc_html_e( 'Title', 'mnml' ); ?>: 
                    <input class="widefat" id="<?php echo $fid_title; ?>" name="<?php echo $fnm_title; ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
			<p>
            	<?php 
				$username = esc_attr( $instance['username'] );
				$fid_username = $this->get_field_id( 'username' ); 
				$fnm_username = $this->get_field_name( 'username' ); 
				?>
                <label for="<?php echo $fid_username; ?>">
					<?php esc_html_e( 'Username', 'mnml' ); ?>: 
                    <input class="widefat" id="<?php echo $fid_username; ?>" name="<?php echo $fnm_username; ?>" type="text" value="<?php echo $username; ?>" />
                </label>
            </p>
			<p>
            	<?php 
				$number = absint( $instance['number'] );
				$fid_number = $this->get_field_id( 'number' ); 
				$fnm_number = $this->get_field_name( 'number' ); 
				?>
                <label for="<?php echo $this->get_field_id( 'number' ); ?>">
					<?php esc_html_e( 'Number of photos', 'mnml' ); ?>: 
                    <input class="widefat" id="<?php echo $fid_number; ?>" name="<?php echo $fnm_number; ?>" type="text" value="<?php echo $number; ?>" />
                </label>
            </p>
			<p>
            	<?php 
				$target = esc_attr( $instance['target'] );
				$fid_target = $this->get_field_id( 'target' ); 
				$fnm_target = $this->get_field_name( 'target' ); 
				?>
                <label for="<?php echo $fid_target; ?>">
                    <?php esc_html_e( 'Open links in', 'mnml' ); ?>:]
                </label>
				<select id="<?php echo $fid_target; ?>" name="<?php echo $fnm_target; ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window (_self)', 'mnml' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window (_blank)', 'mnml' ); ?></option>
				</select>
			</p>
			<p>
            	<?php 
				$link = esc_attr( $instance['link'] );
				$fid_link = $this->get_field_id( 'link' ); 
				$fnm_link = $this->get_field_name( 'link' ); 
				?>
            	<label for="<?php echo $fid_link; ?>">
					<?php esc_html_e( 'Link text', 'mnml' ); ?>: 
                    <input class="widefat" id="<?php echo $fid_link; ?>" name="<?php echo $fnm_link; ?>" type="text" value="<?php echo $link; ?>" />
                </label>
            </p>
			<?php
	
		}
	
	
		##	Update backend
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
			$instance['number'] = !absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
			$instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_self' );
			$instance['link'] = strip_tags( $new_instance['link'] );
			return $instance;
		}



		##	Frontend
		function widget( $args, $instance ) {
	
			extract( $args, EXTR_SKIP );
	
			$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$limit = empty( $instance['number'] ) ? 9 : $instance['number'];
			$target = empty( $instance['target'] ) ? '_self' : $instance['target'];
			$link = empty( $instance['link'] ) ? '' : $instance['link'];
	
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
	
			do_action( 'the1instagram_before_widget', $instance );
	
			if ( $username != '' ) {
	
				$media_array = $this->scrape_instagram( $username, $limit );
	
				if ( is_wp_error( $media_array ) ) {
	
					echo $media_array->get_error_message();
	
				} else {
	
					// filter for images only?
					if ( $images_only = apply_filters( 'the1instagram_images_only', FALSE ) )
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
	
					// filters for custom classes
					$liclass = esc_attr( apply_filters( 'the1instagram_item_class', '' ) );
					$aclass = esc_attr( apply_filters( 'the1instagram_a_class', '' ) );
					$imgclass = esc_attr( apply_filters( 'the1instagram_img_class', '' ) );
	
					?><ul class="the1_instagram__pics clearfix"><?php
					foreach ( $media_array as $item ) {
						// copy the else line into a new file (parts/wp-instagram-widget.php) within your theme and customise accordingly
						if ( locate_template( 'template-parts/themes1-instagramwidget.php' ) != '' ) {
							include locate_template( 'template-parts/themes1-instagramwidget.php' );
						} else {
							echo '<li class="'. $liclass .'">' .
								'<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $aclass .'" style="background-image: url('.esc_url( $item['thumbnail'] ).')">' .
								'</a>' .
								'</li>';
						}
					}
					?></ul><?php
				}
			}
	
			if ( $link != '' ) {
				?>
                <p class="clear">
                	<a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo $link; ?></a>
                </p>
				<?php
			}
	
			do_action( 'the1instagram_after_widget', $instance );
	
			echo $after_widget;
		}
	
	
		// based on https://gist.github.com/cosmocatalano/4544576
		function scrape_instagram( $username, $slice = 9 ) {
	
			$username = strtolower( $username );
	
			if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {
	
				$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );
	
				if ( is_wp_error( $remote ) )
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'mnml' ) );
	
				if ( 200 != wp_remote_retrieve_response_code( $remote ) )
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'mnml' ) );
	
				$shards = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );
	
				if ( !$insta_array )
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'mnml' ) );
	
				// old style
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type = 'old';
				// new style
				} else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
					$type = 'new';
				} else {
					return new WP_Error( 'bad_josn_2', esc_html__( 'Instagram has returned invalid data.', 'mnml' ) );
				}
	
				if ( !is_array( $images ) )
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'mnml' ) );
	
				$instagram = array();
	
				switch ( $type ) {
					case 'old':
						foreach ( $images as $image ) {
	
							if ( $image['user']['username'] == $username ) {
	
								$image['link']						  = preg_replace( "/^http:/i", "", $image['link'] );
								$image['images']['thumbnail']		   = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
								$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
								$image['images']['low_resolution']	  = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
	
								$instagram[] = array(
									'description'   => $image['caption']['text'],
									'link'		  	=> $image['link'],
									'time'		  	=> $image['created_time'],
									'comments'	  	=> $image['comments']['count'],
									'likes'		 	=> $image['likes']['count'],
									'thumbnail'	 	=> $image['images']['thumbnail'],
									'large'		 	=> $image['images']['standard_resolution'],
									'small'		 	=> $image['images']['low_resolution'],
									'type'		  	=> $image['type']
								);
							}
						}
					break;
					default:
						foreach ( $images as $image ) {
	
							$image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );
	
							if ( $image['is_video']  == true ) {
								$type = 'video';
							} else {
								$type = 'image';
							}
	
							$instagram[] = array(
								'description'   => esc_html__( 'Instagram Image', 'mnml' ),
								'link'		  	=> '//instagram.com/p/' . $image['code'],
								'time'		  	=> $image['date'],
								'comments'	  	=> $image['comments']['count'],
								'likes'		 	=> $image['likes']['count'],
								'thumbnail'	 	=> $image['display_src'],
								'type'		  	=> $type
							);
						}
					break;
				}
	
				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
				}
			}
	
			if ( ! empty( $instagram ) ) {
	
				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );
	
			} else {
	
				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'mnml' ) );
	
			}
		}
	
		function images_only( $media_item ) {
	
			if ( $media_item['type'] == 'image' )
				return true;
	
			return false;
		}
	}

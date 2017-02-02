<?php


	/* include style/scripts */
	if ( !function_exists('the1_slider_backend_scritps') ) {
	function the1_slider_backend_scritps(){
		
		global $post_type;
	    if( 'the1_slider' == $post_type ){
			wp_enqueue_media();
			wp_enqueue_style( 'the1_slider-backend-style', plugins_url('_backend.css', __FILE__) );
			wp_enqueue_script( 'the1_slider-backend-script', plugins_url('_backend.js', __FILE__), array('jquery'), '1.0', true );
		}
			
	}
	add_action('admin_enqueue_scripts','the1_slider_backend_scritps');
	}




	/*-------------------------------------------------------*
	 *	METABOX		the1_slider : Slider Options
	 *-------------------------------------------------------*/
 
 	if ( !function_exists('the1_slider_mb_slideroptions') ) {
		function the1_slider_mb_slideroptions(){
			add_meta_box(
				'the1_slideroptions', 
				'Slider Options', 
				'the1_slider_mb_slideroptions_content', 
				'the1_slider', 
				'side', 
				'default'
			);
		}
		add_action( 'add_meta_boxes', 'the1_slider_mb_slideroptions' );
	}

	//	femto_gallery : Gallery Type / HTML 
	if ( !function_exists('the1_slider_mb_slideroptions_content') ) {
		function the1_slider_mb_slideroptions_content() {
			global $post;
			echo '<input type="hidden" name="the1_slideroptions_nonce" id="the1_slideroptions_nonce" value="'.wp_create_nonce( 'the1_slideroptions_nonce' ) . '" />';
			?>
        

        <!-- Gallery Type -->
            <div class="wrap_options">

                <div style="padding:10px;">
                
						<?php
						$settings_defaults = array(
							'width'			=> '1480',
							'height'		=> '980',
							'arrows'		=> '',
							'bottom_bar'	=> 'dots',
							'overlayer-use'	=> '',
							'fx'			=> 'fade',
							'autoplay'		=> '',
							'autoplay_delay'=> '6',
							'tabs_color'	=> '#e8bb33',
							'overlayer_color'=> '#555555',
							'overlayer_pattern'=> 'patt_00',
							
						);
						$settings = get_post_meta($post->ID,'settings',true);
						$settings = ( is_array($settings) ? array_merge($settings_defaults,$settings) : $settings_defaults );
                        ?>
                        
                        
                        <label style="display:inline-block;width:110px;">
                            Content width:
                        </label>
                        <input type="text" name="settings[width]" value="<?php echo $settings['width']; ?>" style="width: 50px"  /> px
                        &nbsp;&nbsp;<br />
                        <label style="display:inline-block;width:110px;">
                            Content height:
                        </label>
                        <input type="text" name="settings[height]" value="<?php echo $settings['height']; ?>" style="width: 50px"  /> px
                        
                        
                        
                        <div style="background:#eee;padding: 3px 12px;margin: 30px -12px 10px; font-weight: 600;">Controls</div>
                        
                        <label >
                        	<input type="checkbox" name="settings[arrows]" value="on" <?php checked( $settings['arrows'], 'on' );?>/>
                            Main arrows
                        </label>
                        
                        <br /><br />
                        
                        <label style="display:inline-block;">
                            Bottom bar
                        </label><br />
                        <select name="settings[bottom_bar]" >
                            <option value="" <?php selected( $settings['bottom_bar'],'' ); ?>>None</option>
                            <option value="thumbs" <?php selected( $settings['bottom_bar'],'thumbs' ); ?>>Thumbnails</option>
                            <option value="thumbs-arrows" <?php selected( $settings['bottom_bar'],'thumbs-arrows' ); ?>>Thumbnails + Arrows</option>
                            <option value="dots" <?php selected( $settings['bottom_bar'],'dots' ); ?>>Dots</option>
                            <option value="dots-arrows" <?php selected( $settings['bottom_bar'],'dots-arrows' ); ?>>Dots + Arrows</option>
                            <option value="tabs" <?php selected( $settings['bottom_bar'],'tabs' ); ?>>Tabs</option>
                        </select>
                        
                        <br /><br />
                        
                        <div>
                        <label style="display:inline-block;">
                            Tabs color
                        </label><br />
                        <input type="text" class="the1npc-colorpicker" name="settings[tabs_color]" value="<?php echo $settings['tabs_color']; ?>" />
                        </div>
                        

                        <div style="background:#eee;padding: 3px 12px;margin: 30px -12px 10px; font-weight: 600;">Overlayer</div>
                        
                        <label >
                        	<input type="checkbox" name="settings[overlayer-use]" value="on" <?php checked( $settings['overlayer-use'], 'on' );?>/>
                            Use Overlayer
                        </label>
                        
                        <br /><br />
                        
                        <label style="display:inline-block;">
                            Overlayer Color
                        </label><br />
                        <input type="text" class="the1npc-colorpicker" name="settings[overlayer_color]" value="<?php echo $settings['overlayer_color']; ?>" />
                        
                        <br /><br />
                        
                        <label style="display:inline-block;">
                            Overlayer Pattern
                        </label>
                        <div class="the1_radio_group">
						<?php 
                        $patts = array('patt_00','patt_01','patt_02','patt_03');
                        foreach( $patts as $patt ){
                            $patt_style = 'width:21px; height:21px; display:inline-block; background-position:center; margin:5px 5px 0 0; ';
                            $patt_style .= 'background-image:url('. plugins_url( 'images/'.$patt.'.png', __FILE__ ) .');';
                            
							echo '<label>';
                            echo '<input type="radio" class="the1_radio" name="settings[overlayer_pattern]" value="'.$patt.'" '.checked($settings['overlayer_pattern'],$patt,0 ).'>';
                            echo '<div class="the1_radio_trigger" style="'.$patt_style.'"></div>'; 
                        	echo '</label>';
						}
                        ?>
                        </div>

                        
                        
                        
                        
                        
                        <div style="background:#eee;padding: 3px 12px;margin: 30px -12px 10px; font-weight: 600;">Transition</div>
                        
                                        <div style="display:none;">
                                        <label style="display:inline-block;width:70px;">
                                            Sliding FX:
                                        </label><br />
                                        <select name="settings[fx]" >
                                            <option value="fade" <?php selected( $settings['fx'],'fade' ); ?>>Fade</option>
                                            <option value="slide" <?php selected( $settings['fx'],'slide' ); ?>>Slide</option>
                                        </select>
                                        <br /><br />
                                        </div>


                        <label >
                        	<input type="checkbox" name="settings[autoplay]" value="on" <?php checked( $settings['autoplay'], 'on' );?>/>
                            Autoplay on load
                        </label>
                        
                        <br /><br />

                        <label style="display:inline-block;">
                            Delay before transition
                        </label>
                        <select name="settings[autoplay_delay]" >
                            <option value="1" <?php selected( $settings['autoplay_delay'],'1' ); ?>>1</option>
                            <option value="2" <?php selected( $settings['autoplay_delay'],'2' ); ?>>2</option>
                            <option value="3" <?php selected( $settings['autoplay_delay'],'3' ); ?>>3</option>
                            <option value="4" <?php selected( $settings['autoplay_delay'],'4' ); ?>>4</option>
                            <option value="5" <?php selected( $settings['autoplay_delay'],'5' ); ?>>5</option>
                            <option value="6" <?php selected( $settings['autoplay_delay'],'6' ); ?>>6</option>
                            <option value="7" <?php selected( $settings['autoplay_delay'],'7' ); ?>>7</option>
                            <option value="8" <?php selected( $settings['autoplay_delay'],'8' ); ?>>8</option>
                        </select>
                        sec.
                        
                </div>
                
            </div>
			<?php 
		}
	}

	//	femto_gallery : Gallery Manager / SAVE 
	if ( !function_exists('the1_slider_mb_slideroptions_save') ) {
		function the1_slider_mb_slideroptions_save($post_id, $post) {
			
			$nonce = ( isset($_POST['the1_slideroptions_nonce']) ? $_POST['the1_slideroptions_nonce'] : '' );
			// verify nonce
			if ( ! wp_verify_nonce( $nonce, 'the1_slideroptions_nonce' )) {
				return $post_id;
			}
			// check autosave
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return $post_id;
			}
			// check permissions
			if ( ! current_user_can( 'edit_post', $post_id )) {
				return $post_id;
			}

			$settings = $_POST['settings'];
			update_post_meta($post_id,'settings',$settings);

		}
		add_action('save_post', 'the1_slider_mb_slideroptions_save', 1, 2); # save the custom fields
	}




	/*-------------------------------------------------------*
	 *	METABOX		the1_slider : Manage Slides
	 *-------------------------------------------------------*/
 
 	if ( !function_exists('the1_slider_mb_slidermanager') ) {
		function the1_slider_mb_slidermanager(){
			add_meta_box(
				'the1_slidermanager', 
				'Manage Slides', 
				'the1_slider_mb_slidermanager_content', 
				'the1_slider', 
				'normal', 
				'default'
			);
		}
		add_action( 'add_meta_boxes', 'the1_slider_mb_slidermanager' );
	}

	//	femto_gallery : Gallery Manager / HTML 
	if ( !function_exists('the1_slider_mb_slidermanager_content') ) {
		function the1_slider_mb_slidermanager_content() {
			global $post;
			echo '<input type="hidden" name="the1_slides_nonce" id="the1_slides_nonce" value="'.wp_create_nonce( 'the1_slides_nonce' ) . '" />';
			?>
        

        <!-- Gallery Manager -->
            <div class="wrap_options">

    			<?php
				$slides = get_post_meta($post->ID,'slides',true);
				$slidesmanager_id = 'slides-manager';
				$items = array();
				?>
                
                
                <div class="slides-manager" id="<?php echo esc_attr($slidesmanager_id); ?>" data-noitems="no images here">
                    <a href="#" id="add-new-slide">+ Add new slide</a>
                    <br /><br />
                    
                    
                    
                    <ul class="SLIDES-list" id="SLIDES-list">
                    
                
                    	<?php
						if ( is_array($slides) && !empty($slides) ){
							foreach ( $slides as $slide ) {
								
								the1_slider_single_slide_html( $slide );
								
							}
						}
						?>
                    </ul>
                    
                                   
                </div>
                
            </div>

        <?php }
	}

	//	femto_gallery : Gallery Manager / SAVE 
	if ( !function_exists('the1_slider_mb_slidermanager_save') ) {
		function the1_slider_mb_slidermanager_save($post_id, $post) {
			
			$nonce = ( isset($_POST['the1_slides_nonce']) ? $_POST['the1_slides_nonce'] : '' );
			// verify nonce
			if ( ! wp_verify_nonce( $nonce, 'the1_slides_nonce' )) {
				return $post_id;
			}
			// check autosave
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return $post_id;
			}
			// check permissions
			if ( ! current_user_can( 'edit_post', $post_id )) {
				return $post_id;
			}

			$slides = $_POST['slides'];
			update_post_meta($post_id,'slides',$slides);
			
		}
		add_action('save_post', 'the1_slider_mb_slidermanager_save', 1, 2); # save the custom fields
	}
	
	//	Single slide HTML
	if ( !function_exists('the1_slider_single_slide_html') ) {
		function the1_slider_single_slide_html( $slide = false ) {

			$defaults = array(
				'id' => '',
				'title' => '',
				'text' => '',
				'tab_title' => '',
				'bg_color' => '',
				'media_id' => '',
				'media_url' => '',
				'media_type' => '',
				'media_thumb' => '',
				'tab_button_text' => '',
				'text_align' => 'left',
				'title_size' => 'medium',
			);

			if ( isset($_POST['id']) && $_POST['id'] ){
				$slide = $_POST;
			}
			
			if ( !$slide || !is_array($slide) ){ return; }
			$slide = array_merge( $defaults, $slide );
			if ( !$slide['id'] ){ return; }



			if ( $slide['media_type'] === 'image' ){
				$media_url = wp_get_attachment_image_src( $slide['media_id'], 'full' );
				$media_url = $media_url[0];
				$thumb_url = wp_get_attachment_image_src( $slide['media_id'], 'thumbnail' );
				$thumb_url = $thumb_url[0];
			} else {
				$media_url = esc_attr($slide['media_url']);
				$thumb_url = esc_attr($slide['media_thumb']);
			}
			
			$thumb_bg = ( $thumb_url ? 'background-image:url('.$thumb_url.');' : '' );
			$thumb_color = ( $slide['bg_color'] ? 'background-color:'.$slide['bg_color'].';' : '' );
			
			$output =	'<li id="'. esc_attr('SLIDE-'.$slide['id']) .'" data-id="'. esc_attr($slide['id']) .'" class="SLIDE clearfix">'.

                            '<input type="hidden" name="'. esc_attr('slides['.$slide['id'].'][id]') .'" class="slide-id" value="'. esc_attr($slide['id']) .'" />'.
                            '<input type="hidden" name="'. esc_attr('slides['.$slide['id'].'][media_id]') .'" class="slide-media-id" value="'. esc_attr($slide['media_id']) .'" />'.
                            '<input type="hidden" name="'. esc_attr('slides['.$slide['id'].'][media_thumb]') .'" class="slide-media-thumb" value="'. $thumb_url .'" />'.
                            '<input type="hidden" name="'. esc_attr('slides['.$slide['id'].'][media_url]') .'" class="slide-media-url" value="'. $media_url .'" />'.
                            '<input type="hidden" name="'. esc_attr('slides['.$slide['id'].'][media_type]') .'" class="slide-media-type" value="'. esc_attr($slide['media_type']) .'" />'.
                        	
                        	'<div class="SLIDE-section SLIDE-section-image">'.
							
								//background color
								'<div class="SLIDE-background-color">' .
									'<input class="the1npc-colorpicker" name="'. esc_attr('slides['.$slide['id'].'][bg_color]') .'" value="'. esc_attr($slide['bg_color']) .'" placeholder="bg color..."/>' .
								'</div>' .
								//background preview
                            	'<div class="SLIDE-image" style="'. esc_attr($thumb_bg) . esc_attr($thumb_color) . '"></div>'.
								
								//background insert tools
                                '<div class="SLIDE-image-tools clearfix">'.
                                	'<a href="#" class="SLIDE-image-tool SLIDE-add-image" data-buttontext="Add Image" data-title="Slide image" data-framework="the1_slider" title="Add image"></a>'.
                                    '<a href="#" class="SLIDE-image-tool SLIDE-embed-video" title="Add YouTube/Vimeo video"></a>'.
                                    '<div class="SLIDE-embed-video-field">'.
                                        '<input placeholder="Enter Vimeo or YouTube video URL..." style="width:350px" />'.
                                        '&nbsp;&nbsp;&nbsp;'.
                                        '<a href="#" class="submit-video">Insert to slide</a>'.
                                    '</div>         '.
                                    '<a href="#" class="SLIDE-image-tool SLIDE-remove-media" title="Clear slide media"></a>'.
                                '</div>'.
								
                            '</div>'.
                        	
                        	'<div class="SLIDE-section SLIDE-section-options">'.
								//content align
								'<div class="SLIDE-content-align the1icontabs">Text alignment'.
									'<i class="icontab fa fa-align-left '.( $slide['text_align'] === 'left' ? 'selected' : '' ).'" data-value="left"></i>'.
									'<i class="icontab fa fa-align-center '.( $slide['text_align'] === 'center' ? 'selected' : '' ).'" data-value="center"></i>'.
									'<i class="icontab fa fa-align-right '.( $slide['text_align'] === 'right' ? 'selected' : '' ).'" data-value="right"></i>'.
									'<input type="hidden" name="slides['.$slide['id'].'][text_align]" value="'.$slide['text_align'].'" />'.
								'</div>'.
								//title size
								'<div class="SLIDE-title-size the1icontabs" style="font-weight:bold;">'.
									'<div class="icontab '.( $slide['title_size'] === 'small' ? 'selected' : '' ).'" data-value="small">
										<span style="font-size: 11px;">A</span>
									</div>'.
									'<div class="icontab '.( $slide['title_size'] === 'medium' ? 'selected' : '' ).'" data-value="medium">
										<span style="font-size: 14px;">A</span>
									</div>'.
									'<div class="icontab '.( $slide['title_size'] === 'large' ? 'selected' : '' ).'" data-value="large">
										<span style="font-size: 17px;">A</span>
									</div>'.
									'<input type="hidden" name="slides['.$slide['id'].'][title_size]" value="'.$slide['title_size'].'" />'.
								'</div>'.
								//delete slide
								'<div class="SLIDE-delete"><i class="fa fa-trash"></i> Delete this slide</div>' .
                            '</div>'.
							
							'<div class="SLIDE-section SLIDE-move-grip"><i class="fa fa-arrows-v"></i></div>' .
                        	
                        	'<div class="SLIDE-section SLIDE-section-content">'.
                                '<input class="SLIDE-title" type="text" name="'. esc_attr('slides['.$slide['id'].'][title]') .'" placeholder="Slide Title" value="'. esc_attr($slide['title']) .'" /><br />'.
                                '<textarea class="SLIDE-text" name="'. esc_attr('slides['.$slide['id'].'][text]') .'" placeholder="Slide content...">'. esc_attr($slide['text']) .'</textarea>'.
                                '<input class="SLIDE-tab-button-text" type="text" name="'. esc_attr('slides['.$slide['id'].'][tab_button_text]') .'" placeholder="Place your button text here" value="'. esc_attr($slide['tab_button_text']) .'" style="max-width: 400px; margin-top: 15px;" /><br />'.
                                '<input class="SLIDE-tab-title" type="text" name="'. esc_attr('slides['.$slide['id'].'][tab_title]') .'" placeholder="If you use Tabs, put tab text here" value="'. esc_attr($slide['tab_title']) .'" style="max-width: 400px; margin-top: 15px;" /><br />'.
                            '</div>'.
                        
                        '</li>';
						
				echo $output;
				if ( isset($_POST['id']) ){
					die();
				}
		}
		add_action('wp_ajax_the1_slider_single_slide_html', 'the1_slider_single_slide_html');
	}





?>
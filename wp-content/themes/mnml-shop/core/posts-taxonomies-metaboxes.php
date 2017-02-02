<?php

	/* Register scripts for metaboxes */
	function mnml_theme_metabox_scripts(){
		wp_enqueue_script( 'metabox-script', get_template_directory_uri().'/core/js/metabox-script.js', array('jquery'), 1.0, true );
		wp_enqueue_style( 'metabox-style', get_template_directory_uri().'/core/css/metabox-style.css' );
	}
	add_action( 'admin_enqueue_scripts', 'mnml_theme_metabox_scripts' );
			



	/*-------------------------------------------------------*
	 *	METABOX		page : page layout
	 *-------------------------------------------------------*/
 
 	if ( !function_exists('mnml_mb_page_layout') ) {
		function mnml_mb_page_layout(){

			add_meta_box(
				'the1_slideroptions', 
				'Page setup', 
				'mnml_mb_page_layout_content', 
				array('page'), 
				'normal', 
				'high'
			);
		}
		add_action( 'add_meta_boxes', 'mnml_mb_page_layout' );
	}

	if (!function_exists('mnml_sidebar_layout')){
		function mnml_sidebar_layout(){
            $pl_sidebar_layout = get_post_meta(get_the_id(),'pl-sidebar-layout',true);
			$pl_sidebar_layout = ( $pl_sidebar_layout ? $pl_sidebar_layout : 'global' );
			$pl_sidebar_global_layout = '';
			$pl_sidebar = get_post_meta(get_the_id(),'pl-sidebar',true);
			$post_type = get_post_type(get_the_id());
			$sidebar_type = '';
			$sidebar = array();
			if ($pl_sidebar_layout === 'left-sidebar'){
				$sidebar_type = 'left';
			}
			else if ($pl_sidebar_layout === 'right-sidebar'){
				$sidebar_type = 'right';
			}
			else if ($pl_sidebar_layout === 'no-sidebar'){
				$sidebar_type = 'no';
			}
			else if ($pl_sidebar_layout === 'global'){
				$pl_sidebar_global_layout = mnml_themeoption('default-'.$post_type.'-sidebar-layout');
				if ($pl_sidebar_global_layout === 'left-sidebar'){
					$sidebar_type = 'left';
				}
				else if ($pl_sidebar_global_layout === 'right-sidebar'){
					$sidebar_type = 'right';
				}
				else if ($pl_sidebar_global_layout === 'no-sidebar'){
					$sidebar_type = 'no';
				}
			}
			$sidebar[] = $sidebar_type; // Adding Sidebar Layout to array
			$sidebar[] = $pl_sidebar; //Adding Sidebar that is chosen
			return $sidebar;  
		}
	}

	//	Sidebar Type and Layout 
	if ( !function_exists('mnml_mb_page_layout_content') ) {
		function mnml_mb_page_layout_content() {
			global $post;
            global $post;
            echo '<input type="hidden" name="mnml_mb_page_layout_nonce" id="mnml_mb_page_layout_nonce" value="'.wp_create_nonce( 'mnml_mb_page_layout_nonce' ) . '" />';
                
			?>

			<!-- Slider -->
    
				<?php
                $pl_slider = get_post_meta($post->ID,'pl-slider',true);
                $pl_slider_radios = $pl_slider_dropdowns = $pl_slider_output = '';
                
                ## Themes1 Slider 
                $pl_slider_the1 = get_post_meta($post->ID,'pl-slider-the1',true);
                if ( post_type_exists('the1_slider') ){
                        $pl_slider_radios .=
                            '<label>' .
                            '<input type="radio" class="the1_radio_tab" data-tab="the1_sl_sel" name="pl-slider" value="the1" '. checked( $pl_slider, 'the1', false ) . '>' .
                            'Themes1 slider' .
                            '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        
                        $pl_slider_dropdowns .=	'<select name="pl-slider-the1" class="the1_radio_tab_page the1_sl_sel">';			
                            $the1sliders = get_posts(  array( 'post_type' => 'the1_slider', 'posts_per_page'=>-1,  ) );
                            if ( !empty($the1sliders) ){
                                foreach ( $the1sliders as $sl ){
                                $pl_slider_dropdowns .= '<option value="'. esc_attr($sl->ID) .'" '.selected( $sl->ID, $pl_slider_the1, false ).'>'.get_the_title($sl->ID).'</option>';
                                }
                            } else {
                                $pl_slider_dropdowns .= '<option value="" '.selected( "", $pl_slider_the1, false ).'>No sliders available</option>';
                            }
                        $pl_slider_dropdowns .=	'</select>'; 
                }
                
                ## Revolution Slider
                $pl_slider_revo = get_post_meta($post->ID,'pl-slider-revo',true);
                if ( class_exists('RevSlider') ){
                        $pl_slider_radios .=	
                            '<label>' .
                            '<input type="radio" class="the1_radio_tab" data-tab="revo_sl_sel" name="pl-slider" value="revo" '. checked( $pl_slider, 'revo', false ) . '>' .
                            'Revolution slider' .
                            '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        
                        $i = 0;
                        $cls_a = new RevSlider();
                        $revSliders = $cls_a->getAllSliderAliases();
                        
                        $pl_slider_dropdowns .= '<select name="pl-slider-revo" class="the1_radio_tab_page revo_sl_sel">';
                            if ( !empty($revSliders) ){
                                foreach ( $revSliders as $sl ){
                                $pl_slider_dropdowns .= '<option value="'. esc_attr($sl) .'" '.selected( $sl, $pl_slider_revo, false ).'>'.$sl.'</option>';
                                }
                            } else {
                                $pl_slider_dropdowns .= '<option value="" '.selected( "", $pl_slider_revo, false ).'>No sliders available</option>';
                            }
                        $pl_slider_dropdowns .=	'</select>'; 
                }

                ## Google Map
				$def_gmap = array('apikey'=>'','lat'=>'','lng'=>'','title'=>'','desc'=>'');
                $pl_slider_gmap = get_post_meta($post->ID,'pl-slider-gmap',true);
				$pl_slider_gmap = ( is_array($pl_slider_gmap) ? $pl_slider_gmap : array() );
				$pl_slider_gmap = array_merge($def_gmap, $pl_slider_gmap);
				
                if ( function_exists('the1_googlemap') ){
                        $pl_slider_radios .=	
                            '<label>' .
                            '<input type="radio" class="the1_radio_tab" data-tab="gmap_sl_sel" name="pl-slider" value="gmap" '. checked( $pl_slider, 'gmap', false ) . '>' .
                            'Google Map' .
                            '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        
                        $pl_slider_dropdowns .= '<div class="the1_radio_tab_page gmap_sl_sel">' .
													'<div class="page-gmap-label">Marker (Lat,Lng):</div>' .
                        						 	'<input style="width: 150px;" name="pl-slider-gmap[lat]" value="'. esc_attr($pl_slider_gmap['lat']) .'" />, ' .
                        						 	'<input style="width: 150px;" name="pl-slider-gmap[lng]" value="'. esc_attr($pl_slider_gmap['lng']).'" /><br />' .
													'<div class="page-gmap-label">Title:</div>' .
                        						 	'<input style="width: 400px;" name="pl-slider-gmap[title]" value="'. esc_attr($pl_slider_gmap['title']) .'" /><br />' .
													'<div class="page-gmap-label">Description:</div>' .
                        						 	'<input style="width: 400px;" name="pl-slider-gmap[desc]" value="'. esc_attr($pl_slider_gmap['desc']) .'" />' .
                        						'</div>';
                }
                
                
                ## Custom Shortcode
                $pl_slider_sc = get_post_meta($post->ID,'pl-slider-sc',true);
				
				$pl_slider_radios .=	
					'<label>' .
					'<input type="radio" class="the1_radio_tab" data-tab="sc_sl_sel" name="pl-slider" value="sc" '. checked( $pl_slider, 'sc', false ) . '>' .
					'Shortcode/Html' .
					'</label>' .
                    '<label>' .
                    '<input type="radio" class="the1_radio_tab" data-tab="sc_tb_sel" name="pl-slider" value="tb" '. checked( $pl_slider, 'tb', false ) . '>' .
                    'Titlebar' .
                    '</label>'.
                    '<input type="radio" class="the1_radio_tab" data-tab="sc_cat_sel" name="pl-slider" value="cat" '. checked( $pl_slider, 'cat', false ) . '>' .
                    'Catalogue' .
                    '</label>';
				
				$pl_slider_dropdowns .= '<div class="the1_radio_tab_page sc_sl_sel">' .
											'<div>You can insert shortcodes or html content here: </div>' .
											'<textarea style="width:100%;height:120px" name="pl-slider-sc">'.$pl_slider_sc.'</textarea> ' .
										'</div>';
                
                
                ## HTML output preparation
                if ( $pl_slider_radios ){
                    $pl_slider_output = 	
                        '<div class="the1_option_wrapper">' .
                            '<span class="the1_radio_tab_group">' .
                                '<p><strong>Slider</strong></p>' .
                                '<p>' .
                                    '<label>' . 
                                    '<input type="radio" class="the1_radio_tab" name="pl-slider" value="" ' . checked( $pl_slider, '', false ) . ' />' .
                                    'No titlebar' .
                                    '</label>' .
                                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
                                    $pl_slider_radios . 
                                '</p>' .
                                '<p>' . $pl_slider_dropdowns . '</p>' .
                            '</span>' .
                        '</div>';
                } else {
                     $pl_slider_output =
                        '<div class="the1_option_wrapper">' .
                            '<p>No compatible sliders installed<br />' .
                            '<small>Currently, theme only supports Themes1 slider and Revolution slider as the page\'s main slider.<br />' .
                            'But you can, however, use any other slider inside the pages content</small></p>' .
                        '</div>';
                };
                
                ## HTML print
                echo $pl_slider_output;
				?>
            
                <div class="the1_hr"></div>
                
                <!-- Page titlebar -->
                <div class="the1_radio_tab_group">
                <div class="the1_option_wrapper floating">
                    <p><strong><?php esc_html_e('Page layout','mnml-shop'); ?></strong></p>
                    <?php
                        $site_layout = get_post_meta($post->ID,'pl-site-layout',true);
                        ?>
                        <select name="pl-site-layout">
                            <?php
                            if ( !$site_layout ) { $site_layout = 'global'; }
                            ?>
                            <option value="global" <?php selected( $site_layout, 'global' ); ?>><?php esc_html_e('Global','mnml-shop'); ?></option>
                            <option value="fullwidth" <?php selected( $site_layout, 'fullwidth' ); ?>><?php esc_html_e('Entirely full width','mnml-shop'); ?></option>
                            <option value="banner" <?php selected( $site_layout, 'banner' ); ?>><?php esc_html_e('Banner full width','mnml-shop'); ?></option>
                            <option value="fixed" <?php selected( $site_layout, 'fixed' ); ?>><?php esc_html_e('Fixed width','mnml-shop'); ?></option>
                        </select>
                </div>
                </div>
                <div class="the1_hr"></div>

            <!-- Title bar -->
            
                <div class="the1_option_wrapper">
                    <p><strong>Title bar</strong></p>
                    <?php
                    $pl_title_show = get_post_meta($post->ID,'pl-title-show',true);
                    ?>
                    <p>
                    <label>
                        <input type="hidden" class="the1_chk_tab" data-tab="chkpage-titlebaroptions" name="pl-title-show" value="0" <?php checked( $pl_title_show, 1 );?> />
                    </label>
                    </p>
                    
                    <div class="the1_chk_page chkpage-titlebaroptions initial">
                        <p><strong>- Title</strong></p>
                        <?php
                        $pl_titlebar_title = get_post_meta($post->ID,'pl-titlebar-title',true);
                        $pl_titlebar_title = ( $pl_titlebar_title ? $pl_titlebar_title : '' );
                        ?>
                        <textarea name="pl-titlebar-title" placeholder="Page title..." style="width:100%;display:block;max-width:400px;height:70px;"><?php echo strip_tags( $pl_titlebar_title, '<strong>, <em>, <small>' );?></textarea>
                        <p><strong>- Subtitle</strong></p>
                        <?php
                        $pl_titlebar_subtitle = get_post_meta($post->ID,'pl-titlebar-subtitle',true);
                        $pl_titlebar_subtitle = ( $pl_titlebar_subtitle ? $pl_titlebar_subtitle : '' );
                        ?>
                        <textarea name="pl-titlebar-subtitle" placeholder="Page subtitle..." style="width:100%;display:block;max-width:400px;height:70px;"><?php echo strip_tags( $pl_titlebar_subtitle, '<strong>, <em>, <small>' );?></textarea>
    
    
    
    
    
                        <p><strong>- Options</strong></p>
                        <?php
                        $pl_titlebar_options = get_post_meta($post->ID,'pl-titlebar-options',true);
                        $pl_titlebar_options = ( $pl_titlebar_options ? $pl_titlebar_options : 'global' );
                        ?>
                        <p>
                        <div class="the1_radio_tab_group">
                            <label>
                                <input type="radio" class="the1_radio_tab" name="pl-titlebar-options" value="global" <?php checked( $pl_titlebar_options, 'global' ); ?> />
                                Use globals (set on panel)
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" class="the1_radio_tab" data-tab="the1_tb_customoptions" name="pl-titlebar-options" value="custom" <?php checked( $pl_titlebar_options, 'custom' ); ?> />
                                Use custom options for this page
                            </label>
                            <div class="the1_radio_tab_page the1_tb_customoptions" style="padding:1px 10px;background:#f4f4f4;margin: 10px 0;">
                                
                                <div class="the1_floating_options" style="border-right:solid 1px #eee;">
                                    <p><strong>Background image</strong></p>
                                    <p>
                                    <?php
                                    $pl_titlebar_bgimage = get_post_meta($post->ID,'pl-titlebar-bgimage',true);
                                    $pl_titlebar_bgimage = ( $pl_titlebar_bgimage ? $pl_titlebar_bgimage : 'global' );
                                    ?>
                                    <label style="display:inline-block;margin-bottom:7px;width:160px">
                                        <input type="radio" name="pl-titlebar-bgimage" value="global"  <?php checked( $pl_titlebar_bgimage, 'global' ); ?> />
                                        Global (set on panel)
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-bgimage" value="none"  <?php checked( $pl_titlebar_bgimage, 'none' ); ?> />
                                        None
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-bgimage" value="featured"  <?php checked( $pl_titlebar_bgimage, 'featured' ); ?> />
                                        Use featured image
                                    </label>
                                    </p>
                                </div>
    
                                <div class="the1_floating_options" style="border-right:solid 1px #eee;">
                                    <p><strong>Background color</strong></p>
                                    <p>
                                    <?php
                                    $pl_titlebar_bgcolor = get_post_meta($post->ID,'pl-titlebar-bgcolor',true);
                                    $pl_titlebar_bgcolor = ( $pl_titlebar_bgcolor ? $pl_titlebar_bgcolor : 'global' );
    
                                    $pl_titlebar_bgcolorpicker = get_post_meta($post->ID,'pl-titlebar-bgcolorpicker',true);
                                    $pl_titlebar_bgcolorpicker = ( $pl_titlebar_bgcolorpicker ? $pl_titlebar_bgcolorpicker : '#555555' );
                                    ?>
                                    <label style="display:inline-block;margin-bottom:7px;width:160px">
                                        <input type="radio" name="pl-titlebar-bgcolor" value="global"  <?php checked( $pl_titlebar_bgcolor, 'global' ); ?> />
                                        Global (set on panel)
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-bgcolor" value="custom"  <?php checked( $pl_titlebar_bgcolor, 'custom' ); ?> />
                                        Custom: 
                                    </label>
                                    <input type="text" name="pl-titlebar-bgcolorpicker" class="mb-picker" value="<?php echo esc_attr($pl_titlebar_bgcolorpicker); ?>" /> 
                                    </p>
                                </div>
                                
                                <div class="the1_floating_options" style="border-right:solid 1px #eee;">
                                    <p><strong>Content color</strong></p>
                                    <p>
                                    <?php
                                    $pl_titlebar_scheme = get_post_meta($post->ID,'pl-titlebar-scheme',true);
                                    $pl_titlebar_scheme = ( $pl_titlebar_scheme ? $pl_titlebar_scheme : 'global' );
                                    ?>
                                    <label style="display:inline-block;margin-bottom:7px;width:160px;">
                                        <input type="radio" name="pl-titlebar-scheme" value="global"  <?php checked( $pl_titlebar_scheme, 'global' ); ?> />
                                        <?php
                                        $skin = mnml_get_site_skin();
                                        $titlebar_scheme = mnml_themeoption($skin.'-pagetitlebar-scheme');
                                        $schemes = array( 'light'=>'Light', 'dark'=>'Dark' );
                                        echo ( $titlebar_scheme ? 'Global ('.($schemes[$titlebar_scheme]).')' : '' );
                                        ?>
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-scheme" value="light"  <?php checked( $pl_titlebar_scheme, 'light' ); ?> />
                                        Light
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-scheme" value="dark" <?php checked( $pl_titlebar_scheme, 'dark' ); ?> />
                                        Dark
                                    </label>
                                    </p>
                                </div>
                                
                                <div class="the1_floating_options" style="border-right:solid 1px #eee;">
                                    <p><strong>Align</strong></p>
                                    <p>
                                    <?php
                                    $pl_titlebar_align = get_post_meta($post->ID,'pl-titlebar-align',true);
                                    $pl_titlebar_align = ( $pl_titlebar_align ? $pl_titlebar_align : 'global' );
                                    ?>
                                    <label style="display:inline-block;margin-bottom:7px;width:160px">
                                        <input type="radio" name="pl-titlebar-align" value="global"  <?php checked( $pl_titlebar_align, 'global' ); ?> />
                                        <?php
                                        $skin = mnml_get_site_skin();
                                        $titlebar_align = mnml_themeoption($skin.'-pagetitlebar-align');
                                        $aligns = array( 'align-left'=>'Left', 'align-center'=>'Center', 'align-right'=>'Right' );
                                        echo ( $titlebar_align ? 'Global ('.($aligns[$titlebar_align]).')' : '' );
                                        ?>
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-align" value="align-left"  <?php checked( $pl_titlebar_align, 'align-left' ); ?> />
                                        Left
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-align" value="align-center" <?php checked( $pl_titlebar_align, 'align-center' ); ?> />
                                        Center
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-align" value="align-right" <?php checked( $pl_titlebar_align, 'align-right' ); ?> />
                                        Right
                                    </label>
                                    </p>
                                </div>
                                
                                <div class="the1_floating_options">
                                    <p><strong>Size</strong></p>
                                    <p>
                                    <?php
                                    $pl_titlebar_size = get_post_meta($post->ID,'pl-titlebar-size',true);
                                    $pl_titlebar_size = ( $pl_titlebar_size ? $pl_titlebar_size : 'global' );
                                    ?>
                                    <label style="display:inline-block;margin-bottom:7px;width:160px;">
                                        <input type="radio" name="pl-titlebar-size" value="global"  <?php checked( $pl_titlebar_size, 'global' ); ?> />
                                        <?php
                                        $skin = mnml_get_site_skin();
                                        $titlebar_size = mnml_themeoption($skin.'-pagetitlebar-size');
                                        $sizes = array( 'x1'=>'Small', 'x2'=>'Medium', 'x3'=>'Large' );
                                        echo ( $titlebar_size ? 'Global ('.($sizes[$titlebar_size]).')' : '' );
                                        ?>
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-size" value="x1"  <?php checked( $pl_titlebar_size, 'x1' ); ?> />
                                        Small
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-size" value="x2" <?php checked( $pl_titlebar_size, 'x2' ); ?> />
                                        Medium
                                    </label>
                                    <br />
                                    <label>
                                        <input type="radio" name="pl-titlebar-size" value="x3" <?php checked( $pl_titlebar_size, 'x3' ); ?> />
                                        Large
                                    </label>
                                    </p>
                                </div>
                                <div style="clear:both;"></div>
                            
                            </div>	
                        </div>
                        </p>
                        
                        
                        
                    </div>
                    
                </div>

                    

        <?php }
	}

	//	femto_gallery : Gallery Manager / SAVE 
	if ( !function_exists('mnml_mb_page_layout_save') ) {
		function mnml_mb_page_layout_save($post_id, $post) {
			
			$nonce = ( isset($_POST['mnml_mb_page_layout_nonce']) ? $_POST['mnml_mb_page_layout_nonce'] : '' );
			// verify nonce
			if ( ! wp_verify_nonce( $nonce, 'mnml_mb_page_layout_nonce' )) {
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

			$pl_slider = $_POST['pl-slider'];
			update_post_meta($post_id,'pl-slider',$pl_slider);

			$pl_slider_the1 = ( isset($_POST['pl-slider-the1']) ? $_POST['pl-slider-the1'] : '' );
            update_post_meta($post_id,'pl-slider-the1',$pl_slider_the1);

            $pl_slider_revo = ( isset($_POST['pl-slider-revo']) ? $_POST['pl-slider-revo'] : '' );
            update_post_meta($post_id,'pl-slider-revo',$pl_slider_revo);

            /*
			$pl_slider_gmap = ( isset($_POST['pl-slider-gmap']) ? $_POST['pl-slider-gmap'] : '' );
			update_post_meta($post_id,'pl-slider-gmap',$pl_slider_gmap);
            */
			
            $pl_slider_sc = ( isset($_POST['pl-slider-sc']) ? $_POST['pl-slider-sc'] : '' );
            update_post_meta($post_id,'pl-slider-sc',$pl_slider_sc);

			$pl_title_show = ( !empty($_POST['pl-title-show']) ? $_POST['pl-title-show'] : '' );
			update_post_meta($post_id,'pl-title-show',$pl_title_show);

            $pl_site_layout =  ( isset( $_POST['pl-site-layout']) ? $_POST['pl-site-layout'] : '');
            update_post_meta($post_id,'pl-site-layout',$pl_site_layout);

			$pl_titlebar_options = $_POST['pl-titlebar-options'];
			update_post_meta($post_id,'pl-titlebar-options',$pl_titlebar_options);

			$pl_titlebar_size = $_POST['pl-titlebar-size'];
			update_post_meta($post_id,'pl-titlebar-size',$pl_titlebar_size);

			$pl_titlebar_scheme = $_POST['pl-titlebar-scheme'];
			update_post_meta($post_id,'pl-titlebar-scheme',$pl_titlebar_scheme);

			$pl_titlebar_align = $_POST['pl-titlebar-align'];
			update_post_meta($post_id,'pl-titlebar-align',$pl_titlebar_align);

			$pl_titlebar_bgimage = $_POST['pl-titlebar-bgimage'];
			update_post_meta($post_id,'pl-titlebar-bgimage',$pl_titlebar_bgimage);

			$pl_titlebar_bgcolor = $_POST['pl-titlebar-bgcolor'];
			update_post_meta($post_id,'pl-titlebar-bgcolor',$pl_titlebar_bgcolor);

			$pl_titlebar_bgcolorpicker = $_POST['pl-titlebar-bgcolorpicker'];
			update_post_meta($post_id,'pl-titlebar-bgcolorpicker',$pl_titlebar_bgcolorpicker);

            $pl_titlebar_title = $_POST['pl-titlebar-title'];
            update_post_meta($post_id,'pl-titlebar-title',$pl_titlebar_title);

			$pl_titlebar_subtitle = $_POST['pl-titlebar-subtitle'];
			update_post_meta($post_id,'pl-titlebar-subtitle',$pl_titlebar_subtitle);

            /*
			$pl_content_padding = $_POST['pl-content-padding'];
			update_post_meta($post_id,'pl-content-padding',$pl_content_padding);
            */
            
		}
		add_action('save_post', 'mnml_mb_page_layout_save', 1, 2); # save the custom fields
	}
	
    
?>
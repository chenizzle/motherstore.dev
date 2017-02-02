<?php 
add_action('wp_ajax_mnml_options_page__general', 'mnml_options_page__general');
function mnml_options_page__general(){ 
	?>


	<!-- navigation -->
    <ul class="the1panel__navigation">
    	<li class="nav-section georgia">General</li>
        <li><a data-page="pg-logo" href="#" class="active">Logo</a></li>
        <li><a data-page="pg-footer" href="#">Footer</a></li>
        <li><a data-page="pg-woocommerce" href="#">Woocommerce</a></li>
        <li><a data-page="pg-subscribe" href="#">Subscribe Popup</a></li>
        <li><a data-page="pg-social-icons" href="#">Social Profiles</a></li>
        <li><a data-page="pg-other" href="#"><?php //the1_newfeature('nav');?>Other</a></li>
        <li class="nav-section georgia">Advanced</li>
        <li><a data-page="pg-resetoptions" href="#">Reset options</a></li>
    </ul>

    

    <form action="/" class="the1panel-optionsform the1panel-right" autocomplete="off" >
    	
        <input type="hidden" class="optionsgroup" value="general" />
        <input type="hidden" name="action" value="the1options_save__general" />
        <input type="hidden" name="options-version" id="options-version" value="<?php echo mnml_themeinfo('version','attr');?>" />
        <input type="hidden" name="security" id="the1options_nonce__general" value="<?php echo wp_create_nonce('the1options_nonce__general'); ?>" />
        
           
            <div class="options-pages">

            
            <!-- PAGE: logo -->
                    <div class="page pg-logo" style="display:block;">
                    
                        <?php
						
						##	Upload: Site Logo
							$args = array(
								'title'	=>	'Site Logo Image',
								'desc'	=>	'Insert your own logo for the site.',
							);
							$newoption = new mnml_optioncomponent_upload('site-logo', $args);

						##	Text Input: Site Logo Text
							$args = array(
								'title'	=>	'Text Logo',
								'desc'	=>	'Use this text instead of logo image. If left blank, the logo image will be used.',
							);
							$newoption = new mnml_optioncomponent_inputtext('site-logo-text', $args);
						?>
                        
                    </div>        

              
            <!-- PAGE: social icons -->
                    <div class="page pg-social-icons">
                        
                        <div class="single-option">
                            <div style="background:#ffe;padding: 10px;">
                                Use the <code>[the1-socialicons]</code> shortcode to display your icons anywhere on the site.
                            </div>
                        </div>
                        
                        <?php 
							$args = array(
								'title'	=>	'RSS Social Icons in Footer',
								'label'	=>	'Display Social Icons in footer',
							);
							$newoption = new mnml_optioncomponent_checkbox('use-socialicons', $args);
						
                        ##	Sortable: Socialli
							$args = array(
								'title'		=>	'Social Profiles',
								'desc'		=>	'Manage social profile icons',
								'type'		=>	'socialicons',
							);
							$newoption = new mnml_optioncomponent_sortable('socialprofiles', $args);


						##	Checkbox: Show RSS link
							$args = array(
								'title'	=>	'RSS Feed link',
								'label'	=>	'Display RSS link next to social media icons',
							);
							$newoption = new mnml_optioncomponent_checkbox('use-rss', $args);

							
							$left_text_html = '<label>Title: <input type="text" name="left-title" value="'.mnml_themeoption('left-title').'"></label>'.
							'<br/><label>Hyperlink: <input type="text" name="left-hyperlink" value="'.mnml_themeoption('left-hyperlink').'"></label>';

							##	Text Input: Left Title and hyperlink
							$args = array(
								'title'	=>	'Left Title and hyperlink',
								'desc'	=>	'Add your left title and hyperlink which appears in titlebar',
								'html'  =>  $left_text_html,
							);
							$newoption = new mnml_optioncomponent('left-slider-component', $args);

							
							$right_text_html = '<label>Title: <input type="text" name="right-title" value="'.mnml_themeoption('right-title').'"></label>'.
							'<br/><label>Hyperlink: <input type="text" name="right-hyperlink" value="'.mnml_themeoption('right-hyperlink').'"></label>';

							##	Text Input: Right Title and hyperlink
							$args = array(
								'title'	=>	'Left Title and hyperlink',
								'desc'	=>	'Add your right title and hyperlink which appears in titlebar',
								'html'  =>  $right_text_html,
							);
							$newoption = new mnml_optioncomponent('right-slider-component', $args);
						?>
                        
                    </div>


            <!-- PAGE: other -->
                    <div class="page pg-other">
                        
                        <?php 

						##	Checkbox: Enable sharing buttons
							$args = array(
								'title'	=>	'Sharing Buttons',
								'label'	=>	'Use the built-in sharing buttons',
							);
							$newoption = new mnml_optioncomponent_checkbox('share-enable', $args);

							?>
							
							
							
							
                    </div>


            <!-- PAGE: footer -->
                    <div class="page pg-footer">
                    
                    
						<?php
                        
                    ##	Textarea: Copyright (left)
						$args = array(
							'title'	=>	'Footer Text/Copyright',
							'desc'	=>	'This field is specifically designed for the copyright information, however it can also serve for any other purpose.'.
										'<br /><br />'.
										'Allowed tags:'.
										'<br />'.
										esc_html('<br> <a> <strong> <em>'),
						);
						$newoption = new mnml_optioncomponent_textarea('copyright-text', $args);

                        ?>


                    </div>
            <!-- PAGE: woocommerce -->
                    <div class="page pg-woocommerce">
                    
                    
						<?php
							## Show cart icon in menu area
						
                        	$args = array(
								'title'	=>	'Cart Icon',
								'label'	=>	'Display Cart icon in menu',
							);
							$newoption = new mnml_optioncomponent_checkbox('show-cart', $args);
                    		##	Text Input: Woocommerce Shop Title
                    		
							$args = array(
								'title'	=>	'Shop Title',
								'desc'	=>	'Write your custom Woocommerce shop title',
							);
							$newoption = new mnml_optioncomponent_inputtext('woo-shop-title', $args);

							$args = array(
								'title'	=>	'Shop Subtitle',
								'desc'	=>	'Write your custom Woocommerce shop subtitle',
							);
							$newoption = new mnml_optioncomponent_inputtext('woo-shop-subtitle', $args);

							##	Upload: Popup Image
							$args = array(
								'title'	=>	'Woocommerce title image',
								'desc'	=>	'Insert your own image for the title.',
							);
							$newoption = new mnml_optioncomponent_upload('woo-title-image', $args);

                        ?>


                    </div>

                    <!-- PAGE: subscribe -->
                    <div class="page pg-subscribe">
                    
                    
						<?php
                        	$args = array(
								'title'	=>	'Subscribe',
								'label'	=>	'Display Subscribe link in footer area',
							);
							$newoption = new mnml_optioncomponent_checkbox('use-subscribe-area', $args);


                		##	Upload: Popup Image
							$args = array(
								'title'	=>	'Subscribe popup image',
								'desc'	=>	'Insert your own image for the popup.',
							);
							$newoption = new mnml_optioncomponent_upload('subscribe-popup-image', $args);

						##	Text Input: Title and subtitle
						$sub_html = '<label>Title:</br> <input type="text" name="subscribe-title" value="'.mnml_themeoption('subscribe-title').'"></label>'.
						'<br/></br><label>Subtitle: </br> <textarea name="subscribe-subtitle">'.mnml_themeoption('subscribe-subtitle').'</textarea></label>';

						$args = array(
							'title'	=>	'Title and subtitle',
							'desc'	=>	'Add your content which appears in the subscription popup',
							'html'  =>  $sub_html,
						);
						$newoption = new mnml_optioncomponent('subscribe-component', $args);

						##	Input Text: Shortcode for mail form
							$args = array(
								'title'	=>	'Shortcode',
								'desc'	=>	'Type the shortcode for your subscription form',
							); 	
							$newoption = new mnml_optioncomponent_textarea('subscribe-shortcode-or-html', $args);
                        ?>


                    </div>

                      

            <!-- PAGE: resetoptions -->
                    <div class="page pg-resetoptions">
                        
						<div class="single-option" style="text-align:center;">
                        	<br /><br />
                            <div class="">Note: This will reset the "General" options of the theme.<br />Also any unsaved changes on other tabs will be lost.</div>
                            <br /><br />
                            <a href="#" class="the1-btn the1options_resetbtn" style="padding: 14px 50px;">Reset "General" options</a>
                        	<br /><br /><br /><br />
                        </div>


                    </div>



            </div><!--.options-pages-->
            
            <div class="options-foot">
                <a href="#" class="the1-btn the1-submit-btn">Save Changes</a>
                
                <div class="clear"></div>
            </div>
    
    </form>


	<?php 
	if ( isset($_POST['action']) && $_POST['action']==='mnml_options_page__general') { die(); }
 } 


 ?>
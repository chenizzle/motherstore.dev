<?php 
add_action('wp_ajax_mnml_options_page__styling', 'mnml_options_page__styling');
function mnml_options_page__styling(){ ?>

     
    <!-- navigation -->
    <ul class="the1panel__navigation">
            
    	<li class="nav-section georgia">Styling</li>
        	
        <li><a data-page="pg-layout" href="#" class="active">Layout</a></li>
        <li><a data-page="pg-typography" href="#">Typography</a></li>
        <li><a data-page="pg-buttons" href="#">Links and buttons</a></li>
        <!-- <li><a data-page="pg-header" href="#">Header</a></li> -->
        <!-- <li><a data-page="pg-homepage" href="#">Homepage</a></li> -->
        <!-- <li><a data-page="pg-post" href="#">Post</a></li> -->
        <li><a data-page="pg-page" href="#">Page</a></li>
        <!-- <li><a data-page="pg-archives" href="#">Archives</a></li> -->
        <li><a data-page="pg-footer" href="#">Footer</a></li>
        <li><a data-page="pg-custom-css" href="#">Custom CSS</a></li>

    	<li class="nav-section georgia">Advanced</li>
        
        <li><a data-page="pg-resetoptions" href="#">Reset Styling Options</a></li>
        
    </ul>
    

    <form action="/" class="the1panel-optionsform the1panel-right" autocomplete="off" >

        <input type="hidden" class="optionsgroup" value="styling" />
        <input type="hidden" name="action" value="the1options_save__styling" />
        <input type="hidden" name="options-version" id="options-version" value="<?php echo mnml_themeinfo('version','attr');?>" />
        <input type="hidden" name="security" id="the1options_nonce__styling" value="<?php echo wp_create_nonce('the1options_nonce__styling'); ?>" />
        
        <div class="options-pages">      

            <!-- PAGE: layout -->
                    <div class="page pg-layout">
                       <?php
                           $args = array(
                                'name'      =>  'site-layout',
                                'options'   =>  array( 
                                                    'fullwidth' => 'Entirely full width', 
                                                    'banner' => 'Banner full width', 
                                                    'fixed' => 'Fixed width',
                                                ),
                            );
                            $site_layout = mnml_optioncomponent_select($args);
                            $args = array(
                                'title' =>  'Select site layout',
                                'desc'  =>  'Site Layout',
                                'html' => $site_layout
                            );
                            $newoption = new mnml_optioncomponent('site-layout', $args);
                       ?>
                        
                    </div>


            <!-- PAGE: typography -->
                    <div class="page pg-typography">
                        

                        <div class="options-group">
                            <?php 
                            
                            ##	Font: body
                                $args = array(
                                    'title'			=>	'Font: Body',
                                    'desc'			=>	'Set-up font style',
                                    'sampletext'    =>  'Lorem Ipsum dolor sit amet consecterur ...',
                                );
                                $newoption = new mnml_optioncomponent_font('body', $args);


                            ?>
                        </div>

                        <div class="options-group">
                            <span class="opt-section">Headings</span>
                            <?php
                            
                            ##  Font: logo
                                $args = array(
                                    'title'         =>  'Logo',
                                    'desc'          =>  'Set-up font style',
                                    'sampletext'    =>  'Logo Font Style',
                                );
                                $newoption = new mnml_optioncomponent_font('logo', $args);
                            
                            
                            ##	Font: H1
                                $args = array(
                                    'title'			=>	'Heading 1',
                                    'desc'			=>	'Set-up font style',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h1', $args);
                            
                            ##	Font: H2
                                $args = array(
                                    'title'			=>	'Heading 2',
                                    'desc'			=>	'',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h2', $args);
                            
                            ##	Font: H3
                                $args = array(
                                    'title'			=>	'Heading 3',
                                    'desc'			=>	'',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h3', $args);
                            
                            ##	Font: H4
                                $args = array(
                                    'title'			=>	'Heading 4',
                                    'desc'			=>	'',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h4', $args);
                            
                            ##	Font: H5
                                $args = array(
                                    'title'			=>	'Heading 5',
                                    'desc'			=>	'',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h5', $args);
                            
                            ##	Font: H6
                                $args = array(
                                    'title'			=>	'Heading 6',
                                    'desc'			=>	'',
                                    'sampletext'	=>	'Lorem Ipsum Dolor Sit Amet',
                                );
                                $newoption = new mnml_optioncomponent_font('h6', $args);
                            ?>
                        </div>

                        <div class="options-group">
                            <span class="opt-section">Additional Google Fonts</span>
                            <?php 
                            
                            ##	Font: body
                                $args = array(
                                    'title'			=>	'',
                                    'desc'			=>	'Enable additional Google fonts to be used on the site by simply typing font family names here (separated with comma ",")<br /><br />ex.: <em>Open Sans, Raleway</em><br /><br />Then you can use these font types through css on your site.',
                                    'sampletext'	=>	'Logo Font Type',
                                );
                                $newoption = new mnml_optioncomponent_textarea('extra-googlefonts', $args);
                                
                            ?>
                        </div>
                            
                        
                        
                    </div>
                    
                    

            <!-- PAGE: footer -->
                    <div class="page pg-footer">
                    	
						<?php
                        
    
                        ##	Font: footer-headlines
                            $args = array(
                                'title'			=>	'Footer Headlines',
                                'desc'			=>	'Set-up font style.',
                                'sampletext'	=>	'This is a headline on footer',
                            );
                            $newoption = new mnml_optioncomponent_font('footer-headlines', $args);
                            
    
                        ##	Font: footer-text
                            $args = array(
                                'title'			=>	'Footer Text',
                                'desc'			=>	'Set-up font style.',
                                'sampletext'	=>	'This is the text of the footer',
                            );
                            $newoption = new mnml_optioncomponent_font('footer-text', $args);

                        ##	Color Picker: footer links color
                            $btn_st = 'display:inline-block;width:160px;';
                            $args = array(
                                'title'	=>	'Footer Links',
                                'desc'	=>	'Pick colors for links on footer',
                                'html'	=>	'<div style="display:inline-block;padding-right: 40px;">' .
                                                '<span style="'.$btn_st.'">Color:</span>'.mnml_optioncomponent_color('footer-links-color') .
                                                '<br /><br />' .
                                                '<span style="'.$btn_st.'">[hover] Color:</span>'.mnml_optioncomponent_color('footer-links-hover-color') .
                                            '</div>'
                            );
                            $newoption = new mnml_optioncomponent('footer-links', $args);

                        ?>
                        
                    </div>
                    

            <!-- PAGE: post -->
                    <div class="page pg-post">
                    	
						<?php
    
                    ##	Upload: background
                        $pre_name = 'posttitlebar';
                        $sllargs = array(
                            'name'	=> $pre_name.'-overlay-opacity',
                            'style' => '',
                            'data'	=> array(
                                'data-min="1"',
                                'data-max="100"',
                                'data-range="min"',
                                'data-orientation="horizontal"',
                                'data-units=" "'
                            )
                        );
                        $sll = mnml_optioncomponent_uislider($sllargs);
                        $clr = mnml_optioncomponent_color($pre_name.'-overlay-color' );	
                                
                        $args = array(
                        'title'	=>	'Title Bar',
                        'desc'	=>	'Pick  background image for titlebar and adjust color and opacity for the overlayer',
                        'before'=>	'<span class="inner-title">Background:</span><br /><br />' .
                                    $clr.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sll.'<br /><br />' ,
                        'after'	=>	'<br /><br /><br />' .
                                    '<span class="inner-title">Content color:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="light" '.(mnml_themeoption($pre_name.'-scheme')==='light'?'checked':'').'/>' .
                                        'Light'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="dark" '.(mnml_themeoption($pre_name.'-scheme')==='dark'?'checked':'').'/>' .
                                        'Dark'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br /><br />' .
                                    '<span class="inner-title">Breadcrumbs:</span><br />' .
                                    '<label>' .
                                        '<input type="checkbox" name="'.$pre_name.'-breadcrumbs" value="1" '.checked( mnml_themeoption($pre_name.'-breadcrumbs'), 1, false ).'/> ' .
                                        'Show Breadcrumbs' .
                                    '</label>' .
                                    '<br /><br /><br />' .
                                    '<span class="inner-title">Content align:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-left" '.(mnml_themeoption($pre_name.'-align')==='align-left'?'checked':'').'/>' .
                                        'Left'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-center" '.(mnml_themeoption($pre_name.'-align')==='align-center'?'checked':'').'/>' .
                                        'Center'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-right" '.(mnml_themeoption($pre_name.'-align')==='align-right'?'checked':'').'/>' .
                                        'Right'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br />' ,
                        );
                        $newoption = new mnml_optioncomponent_upload($pre_name.'-bg', $args);
                        

                        ?>
                        
                    </div>


            <!-- PAGE: page -->
                    <div class="page pg-page">
                    	
						<?php

                                $args = array(
                                    'title' =>  'Background Color',
                                    'desc'  =>  'Pick color and opacity for header background',
                                    'palette' => array('orange'=>'#ff7700', 'sky'=>'#aaccee')
                                );
                                $newoption = new mnml_optioncomponent_color('bgggg-color', $args);


                    ##	Upload: background
                        $pre_name = 'pagetitlebar';
                        $sllargs = array(
                            'name'	=> $pre_name.'-overlay-opacity',
                            'style' => '',
                            'data'	=> array(
                                'data-min="1"',
                                'data-max="100"',
                                'data-range="min"',
                                'data-orientation="horizontal"',
                                'data-units=" "'
                            )
                        );
                        $sll = mnml_optioncomponent_uislider($sllargs);
                        $clr = mnml_optioncomponent_color($pre_name.'-overlay-color' );	
                                
                        $args = array(
                        'title'	=>	'Title Bar',
                        'desc'	=>	'Pick  background image for titlebar and adjust color and opacity for the overlayer',
                        'before'=>	'<span class="inner-title">Background:</span><br /><br />' .
                                    $clr.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sll.'<br /><br />' ,
                        'after'	=>	'<br />' .
                                    '<label>' .
                                        '<input type="checkbox" name="'.$pre_name.'-parallax" value="1" '.checked( mnml_themeoption($pre_name.'-parallax'), 1, false ).'/> ' .
                                        'Parallax Background' .
                                    '</label>' .
                                    '<br /><br /><br />' .
                                    '<span class="inner-title">Content color:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="light" '.(mnml_themeoption($pre_name.'-scheme')==='light'?'checked':'').'/>' .
                                        'Light'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="dark" '.(mnml_themeoption($pre_name.'-scheme')==='dark'?'checked':'').'/>' .
                                        'Dark'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br /><br />' .
                                    '<span class="inner-title">Content align:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-left" '.(mnml_themeoption($pre_name.'-align')==='align-left'?'checked':'').'/>' .
                                        'Left'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-center" '.(mnml_themeoption($pre_name.'-align')==='align-center'?'checked':'').'/>' .
                                        'Center'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-right" '.(mnml_themeoption($pre_name.'-align')==='align-right'?'checked':'').'/>' .
                                        'Right'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br /><br />'.
                                    '<span class="inner-title">Area size:</span><br />' .
                                    '<span class="the1_radio_group">' .
                                    '<label>' .
                                        '<input type="radio" class="the1_radio" name="'.$pre_name.'-size" value="x1" '.(mnml_themeoption($pre_name.'-size')==='x1'?'checked':'').'/>' .
                                        '<img class="the1_radio_trigger" src="'.get_template_directory_uri().'/core/images/titlebar-x1.png"/>' .
                                    '</label> &nbsp;&nbsp;&nbsp;' .
                                    '<label>' .
                                        '<input type="radio" class="the1_radio" name="'.$pre_name.'-size" value="x2" '.(mnml_themeoption($pre_name.'-size')==='x2'?'checked':'').'/>' .
                                        '<img class="the1_radio_trigger" src="'.get_template_directory_uri().'/core/images/titlebar-x2.png"/>' .
                                    '</label> &nbsp;&nbsp;&nbsp;' .
                                    '<label>' .
                                        '<input type="radio" class="the1_radio" name="'.$pre_name.'-size" value="x3" '.(mnml_themeoption($pre_name.'-size')==='x3'?'checked':'').'/>' .
                                        '<img class="the1_radio_trigger" src="'.get_template_directory_uri().'/core/images/titlebar-x3.png"/>' .
                                    '</label>' .
                                    '</span><br /><br />',
                        );
                        $newoption = new mnml_optioncomponent_upload($pre_name.'-bg', $args);
    
                        $args = array(
                            'title' =>  'Page Title',
                            'label' =>  'Show title in pages',
                            );
                        $newoption = new mnml_optioncomponent_checkbox('page-top-text', $args);

                        $args = array(
                                'title' =>  'Post Title',
                                'label' =>  'Show title in posts',
                            );
                        $newoption = new mnml_optioncomponent_checkbox('post-top-text', $args);
                        ?>
                    </div>
                    



            <!-- PAGE: archives -->
                    <div class="page pg-archives">
                    	
						<?php
    
                    ##	Upload: background
                        $pre_name = 'archivetitlebar';
                        $sllargs = array(
                            'name'	=> $pre_name.'-overlay-opacity',
                            'style' => '',
                            'data'	=> array(
                                'data-min="1"',
                                'data-max="100"',
                                'data-range="min"',
                                'data-orientation="horizontal"',
                                'data-units=" "'
                            )
                        );
                        $sll = mnml_optioncomponent_uislider($sllargs);
                        $clr = mnml_optioncomponent_color($pre_name.'-overlay-color' );	
                                
                        $args = array(
                        'title'	=>	'Title Bar',
                        'desc'	=>	'Pick  background image for titlebar and adjust color and opacity for the overlayer',
                        'before'=>	'<span class="inner-title">Background:</span><br /><br />' .
                                    $clr.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$sll.'<br /><br />' ,
                        'after'	=>	'<br /><br /><br />' .
                                    '<span class="inner-title">Content color:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="light" '.(mnml_themeoption($pre_name.'-scheme')==='light'?'checked':'').'/>' .
                                        'Light'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-scheme" value="dark" '.(mnml_themeoption($pre_name.'-scheme')==='dark'?'checked':'').'/>' .
                                        'Dark'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br /><br />' .
                                    '<span class="inner-title">Content align:</span><br />' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-left" '.(mnml_themeoption($pre_name.'-align')==='align-left'?'checked':'').'/>' .
                                        'Left'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' . 
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-center" '.(mnml_themeoption($pre_name.'-align')==='align-center'?'checked':'').'/>' .
                                        'Center'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<label>' .
                                        '<input type="radio" name="'.$pre_name.'-align" value="align-right" '.(mnml_themeoption($pre_name.'-align')==='align-right'?'checked':'').'/>' .
                                        'Right'.
                                    '</label> &nbsp;&nbsp;&nbsp;&nbsp;' .
                                    '<br /><br />' ,
                        );
                        $newoption = new mnml_optioncomponent_upload($pre_name.'-bg', $args);
    

                        ?>
                    </div>


            <!-- PAGE: buttons -->
                    <div class="page pg-buttons">

						<?php

                        ##	Font: Button Text
                            $args = array(
                                'title'			=>	'Button Text',
                                'desc'			=>	'Set-up font style',
                                'sampletext'	=>	'Button Text',
                                'comp'			=>	array( 'family','size','weight','spacing','transform' ),
                            );
                            $newoption = new mnml_optioncomponent_font('buttons', $args);
                            
                        ##	Color Picker: buttons background
                            $btn_st = 'display:inline-block;width:160px;';
                            $args = array(
                                'title'	=>	'Button Colors',
                                'desc'	=>	'Pick colors for buttons',
                                'html'	=>	'<div style="float:left;padding-right:60px;">' .
                                                '<span style="'.$btn_st.'">Primary button color:</span>'.mnml_optioncomponent_color('btn-primary-color') .
                                                '<br /><br />' .
                                                '<span style="'.$btn_st.'">Secondary button color:</span>'.mnml_optioncomponent_color('btn-secondary-color') .
                                                '<br /><br />' .
                                                '<span style="'.$btn_st.'">Third button color:</span>'.mnml_optioncomponent_color('btn-third-color') .
                                                '<br />' .
                                            '</div>' .
                                            '<div class="clear"></div><br />'
                            );
                            //$newoption = new mnml_optioncomponent('buttons-color', $args);

                        ##	Color Picker: links color
                            $btn_st = 'display:inline-block;width:160px;';
                            $args = array(
                                'title'	=>	'Links',
                                'desc'	=>	'Pick colors for links',
                                'html'	=>	'<div style="display:inline-block;padding-right: 40px;">' .
                                                '<span style="'.$btn_st.'">Color:</span>'.mnml_optioncomponent_color('links-color') .
                                                '<br /><br />' .
                                                '<span style="'.$btn_st.'">[hover] Color:</span>'.mnml_optioncomponent_color('links-hover-color') .
                                            '</div>'
                            );
                            $newoption = new mnml_optioncomponent('default-links', $args);
                            
                        ?>

                    </div>


            <!-- PAGE: custom css -->
                    <div class="page pg-custom-css">
                        
						<?php 
                        ##	Textarea: Custom CSS
                            $args = array(
                                'title'		=>	'CSS',
                                'desc'		=>	'Insert any custom CSS code here. This will override default theme style.<br /><br />Style changes made through this field will be preserved on theme update.',
                            );
                            $newoption = new mnml_optioncomponent_textarea('custom-css', $args);
                        ?>
                        
                    </div>
                    
                    

            <!-- PAGE: resetoptions -->
                    <div class="page pg-resetoptions">
                        
						<div class="single-option" style="text-align:center;">
                        	<br /><br />
                            <div class="">Note: This will reset the "Styling" options of the theme.<br />Also any unsaved changes on other tabs will be lost.</div>
                            <br /><br />
                            <a href="#" class="the1-btn the1options_resetbtn" style="padding: 14px 50px;">Reset "Styling" options</a>
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
    if ( isset($_POST['action']) && $_POST['action']==='mnml_options_page__styling') { die(); }
 } 


 ?>
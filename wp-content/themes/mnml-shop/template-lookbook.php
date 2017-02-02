<?php /* Template name: Lookbook */ ?>
<?php get_header(); ?>



            	<div class="s-container">

                    <div class="mainbanner-area">
                        <div class="mainbanner">

                            <div class="lookbook-wrapper">
                                <div class="lookbook noselect">
                                	<?php
                            		$mnml_my_gallery = true;//mnml_themeoption('homepage-gallery');
                            		if ( $mnml_my_gallery ){

                                        wp_enqueue_script('mnml-the1_lookbook');

                            			$mnml_post = get_post(get_the_id());
                            			if ( $mnml_post ){
                            				setup_postdata($mnml_post);

                                            // Media
                                            $mnml_media = '';
                            				if ( get_post_gallery() ){

                                                $mnml_gallery = get_post_gallery(get_the_ID(),false);
                                                $mnml_gallery_ids = explode(',',$mnml_gallery['ids']);

                                                $current_slide = 0;

                                                foreach ($mnml_gallery_ids as $id) {
                                                    $image = wp_get_attachment_image_src($id,'large');
                                                    $mnml_media .= '<div class="lookbook__media__slide gall_Slide" style="background-image:url('.$image[0].');left:'.($current_slide*100).'%;" ></div>';
                                                    $current_slide++;
                                                }

                            					$mnml_media =    '<div class="lookbook__media lookbook__media--gallery">' .
                                                                '<div class="lookbook__media--gallery__slides gall_Slides">' .
                                                                    $mnml_media .
                                                                '</div>' .
                                                            '</div>' .
                                                            '<div class="lookbook__media__arrows">' .
                                                                '<div class="lookbook__media__arrow goLeft"><i class="fa fa-chevron-left"></i></div>' .
                                                                '<div class="lookbook__media__arrow goRight"><i class="fa fa-chevron-right"></i></div>' .
                                                            '</div>';
                            				
                                            } else if ( has_post_thumbnail() ){
                            				    
                                                $mnml_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                                                $mnml_media .=   '<div class="lookbook__media lookbook__media--thumbnail" style="background-image:url('.$mnml_thumbnail[0].')">' .
                                                            '</div>';
                            				
                                            }


                                            // Content
                                            $mnml_content = $mnml_category = $mnml_author = '';
                            				
                            				$mnml_category = '<div class="lookbook__category entry-category">' . 'Gallery Slideshow' . '</div>';

                            				$mnml_author = '<div class="lookbook__author entry-author">by '.get_the_author().'</div>';
                            				
                                            $mnml_content .= '<div class="lookbook__content align-center valign-middle">' .
                            								$mnml_category .
                                                            '<h1>'.get_the_title().'</h1>' .
                            								$mnml_author .
                                                        '</div>';




                                            // Output results
                            				echo $mnml_media;
                                            //echo $mnml_content;
                            				wp_reset_postdata();
                            			}
                            		}
                                    ?>

                                </div>
                            </div>

                        </div>

                        <?php
                        # vertical social links
                        get_template_part( 'template-parts/sidelinks' ); 
                        ?>
                        
                    </div>
                    <?php
                        echo '<div class="lookbook_media__pagination"><span id="current_slide">1</span> / <span id="last_slide">'.$current_slide.'</span></div>';
                    ?>
                </div>


            </div><!-- end: .s-container-->
        </div><!-- end: #wrapper__inner -->
    </div><!-- end: #wrapper -->
    <?php wp_footer(); ?>
</body>
</html>
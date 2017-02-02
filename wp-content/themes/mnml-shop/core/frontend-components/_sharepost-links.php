<?php

//**    Share Post Links
        function mnml_share_post( $opts = array() ){
            if ( !mnml_themeoption('share-enable') ){return;}
            
            $title = ( isset($opts['title']) && $opts['title'] ? $opts['title'] : '' );
            $style = ( isset($opts['style']) && $opts['style'] ? $opts['style'] : 'SP--2' );
            ?>
        
            <div class="post-share <?php echo esc_attr($style); ?> clearfix">
                              
                
                
                <!--Facebook-->
                <a class="SP-link sp_facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>" target="_blank" title="<?php echo esc_html__('Share on Facebook','mnml-shop');?>">
                    <i class="SP-icon fa fa-facebook"></i><span class="SP-name"></span>
                </a>
                
                <!--Twitter-->
                <a class="SP-link sp_twitter" href="http://twitter.com/home/?status=<?php the_permalink();?>" target="_blank" title="<?php echo esc_html__('Tweet this!','mnml-shop');?>">
                    <i class="SP-icon fa fa-twitter"></i><span class="SP-name"></span>
                </a>

                <!--Google Plus-->
                <a class="SP-link sp_googleplus" href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink();?>','gplusshare','width=600,height=400,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;">
                    <i class="SP-icon fa fa-google-plus"></i><span class="SP-name"></span>
                </a>
                
                <!--Reddit-->
                <a class="SP-link sp_reddit" href="http://reddit.com/submit?url=<?php the_permalink();?>" target="_blank" title="<?php echo esc_html__('Vote on Reddit','mnml-shop');?>">
                    <i class="SP-icon fa fa-reddit"></i><span class="SP-name"></span>
                </a>

                
                <!--Linkedin-->
                <a class="SP-link sp_linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo esc_attr(get_the_title());?>&amp;url=<?php the_permalink();?>" title="<?php echo esc_html__('Share on LinkedIn','mnml-shop');?>" rel="external nofollow" rel="nofollow" target="_blank">
                    <i class="SP-icon fa fa-linkedin"></i><span class="SP-name"></span>
                </a>

                <!--Pinterest-->
                <?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );?>
                <a class="SP-link sp_pinterest" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo esc_url($url);?>" title="<?php echo esc_html__('Pinterest','mnml-shop');?>" rel="nofollow" target="_blank">
                    <i class="SP-icon fa fa-pinterest"></i><span class="SP-name"></span>
                </a>
                

            </div>
            
            
            
            
            <?php
        }


?>
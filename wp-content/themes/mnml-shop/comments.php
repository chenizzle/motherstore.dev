<div id="comments" class="post-section">
	<?php 
    	if ( post_password_required() ) {?>
            <p class="nocomments"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'mnml-shop' );?></p>
		<?php
			return;
		}

    ?>
 
    <!-- You can start editing here. -->
    <?php // Begin Comments & Trackbacks ?>
    <?php if ( have_comments() ) : ?>
        <h3><?php esc_html_e( 'COMMENTS', 'mnml-shop' );?> <small>(<?php comments_number('No comments', 'One comment', '% comments' );?>)</small></h3>

        <ul class="commentlist">
            <?php 
			$mnml_args = array(
				'walker'            => null,
				'max_depth'         => 3,
				'style'             => 'ul',
				'callback'          => 'mnml_comments',
				'end-callback'      => null,
				'type'              => 'all',
				'reply_text'        => 'Reply',
				'page'              => '',
				'per_page'          => '',
				'avatar_size'       => 0,
				'reverse_top_level' => true,
				'reverse_children'  => ''
			);
			wp_list_comments($mnml_args); ?>
        </ul>

        <div class="navigation">
            <?php previous_comments_link() ?>
            <?php next_comments_link() ?>
        </div>
		<?php // End Comments ?>
 
	<?php else : // this is displayed if there are no comments so far ?>
 
		<?php if ('open' == $post->comment_status) { ?>
            <!-- If comments are open, but there are no comments. -->
     
         <?php } else { // comments are closed ?>
            <!-- If comments are closed. -->
            <p class="nocomments"> </p>
     
        <?php } ?>
    <?php endif; ?>
 
 	<?php
	$mnml_aria_req = ( $req ? ' aria-required="true"' : '' );
	$mnml_fields =  array(
			'author' => 	'<div class="s-row"><div class="s-col-4">'.
								'<p class="comment-form-author cf-element-wrapper">' . 
								'Name *'.
								'<input id="author" name="author" type="text" class="cf-user" value="'.esc_attr( $commenter['comment_author'] ).'" '.$mnml_aria_req.' />'.
								'</p>'.
							'</div>',
								
			'email'  => 	'<div class="s-col-4">'.
								'<p class="comment-form-email cf-element-wrapper">'.
								'Email *'.
								'<input id="email" name="email" type="text" class="cf-email" value="'.esc_attr(  $commenter['comment_author_email'] ).'" '.$mnml_aria_req.' />'.
								'</p>'.
							'</div>',
								
			'url'    => 	'<div class="s-col-4">'.
								'<p class="comment-form-url cf-element-wrapper">'.
								'Website'.
								'<input id="url" name="url" type="text" class="cf-website" value="'.esc_attr( $commenter['comment_author_url'] ).'" />'.
								'</p>'.
							'</div></div>',
	);
  comment_form( array(
      'title_reply'			=> _x('POST A COMMENT','Comment form title','mnml-shop'),
      'label_submit'			=> _x('Post Comment','Comment form button label','mnml-shop'),
	
    	'comment_field' 		=>		'<div class="s-row space-x2"><div class="s-col-12">'.
              										'<p class="comment-form-comment cf-element-wrapper">'.
              										'Your Comment'.
              										'<textarea id="comment" name="comment" class="cf-bubble" rows="7" aria-required="true" >' . '</textarea>'.
              										'</p>'.
              									'</div></div>',
							
      'comment_notes_before'	=> '',
      'comment_notes_after'	=> '',
  		'fields'				=> $mnml_fields,
  )); 

	?>
 	
</div>
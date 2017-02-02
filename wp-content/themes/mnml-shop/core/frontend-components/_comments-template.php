<?php

//**	Comments Template customized
		function mnml_comments($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment-body">
					<div class="comment-author-avatar vcard">
						<?php echo get_avatar( $comment, 80 ); ?>
					</div>
					
			 		<div class="comment-author-name">
						<?php printf('<div class="comment-user">%s</div>', get_comment_author_link()); ?>
					</div>
					<div class="comment-date">
						<?php printf( '%1$s at %2$s' , get_comment_date(),get_comment_time()) ?>
						<?php edit_comment_link( '(Edit)', ' ', '') ?>

						<?php if( $args['max_depth']!=$depth ){ ?>
							<span class="comment-reply">
								<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
							</span>
						<?php } ?>

					</div>
			 		<div class="comment-text">
						<?php if ( $comment->comment_approved == '0' ){ ?>
							<em><?php esc_html__e( 'Your comment is awaiting moderation.','mnml-shop'); ?></em>
							<br />
						<?php } ?>

						<?php comment_text() ?>
					</div>
					
					
				</div>
            </li>
			<?php
		}


?>
<?php
if( !function_exists('kontruk_comment') ){
	function kontruk_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; 
	?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<div class="author pull-left">
				<?php echo get_avatar($comment, $size = '80'); ?>
			</div>
			<div class="media-body">
				<div class="media">
					<div class="media-heading clearfix">
						<div class="author-name">
							<span><?php echo comment_author_link(get_comment_ID())?></span>
						</div>
						<div class="time">
							<?php edit_comment_link(__('(Edit)', 'kontruk'), '', ''); ?>
						<time datetime="<?php echo get_comment_date( 'c', get_comment_ID() ); ?>"><?php echo esc_html( get_comment_date() . get_comment_time() ); ?></time>
						</div>
					</div>
					<?php if ($comment->comment_approved == '0') : ?>
						<div class="awaiting row-fluid">
						  <i><?php esc_html_e('Your comment is awaiting moderation.', 'kontruk'); ?></i>
						</div>
					<?php endif; ?>
					<div class="media-content row-fluid">
						<?php comment_text(); ?>						
					</div> 
					<div class="reply"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></div>
				</div>
		 	</div>
<?php } } ?>

<?php if (have_comments()) : ?>
	<div id="comments">
		<h3 class="title"><?php esc_html_e( 'Comments', 'kontruk' ) ?> <small>(<?php echo get_post()->comment_count;?>)</small></h3>
		<?php if (post_password_required()) : ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'kontruk'); ?></p>
			</div>
		<?php else:  ?>
		
		<div class="commentlist">
			<div class="entry-summary">
				<?php wp_list_comments(array('callback' => 'kontruk_comment','style' => 'div')); ?>
			</div>
		</div>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
			<nav id="comments-nav" class="pager">
				<ul class="pager">
					<?php if (get_previous_comments_link()) : ?>
						<li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'kontruk')); ?></li>
					<?php else: ?>
						<li class="previous disabled"><a><?php esc_html_e('&larr; Older comments', 'kontruk'); ?></a></li>
					<?php endif; ?>
					<?php if (get_next_comments_link()) : ?>
						<li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'kontruk')); ?></li>
					<?php else: ?>
						<li class="next disabled"><a><?php esc_html_e('Newer comments &rarr;', 'kontruk'); ?></a></li>
					<?php endif; ?>
				</ul>
			</nav>
		<?php endif; // check for comment navigation ?>
	<?php endif; ?>
	</div><!-- /#comments -->
<?php endif; ?>

<?php 
if (comments_open()) : 
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$title_reply = '<span class="title">' . esc_html__( 'Leave a comment', 'kontruk' ) . '</span>';
		$comment_notes_before = '<p>' . esc_html__( 'Make sure you enter the(*) required information where indicated. HTML code is not allowed', 'kontruk' ) .'</p>';
		$author = '<div class="cmm-box-top clearfix">
				<div class="control-group your-name pull-left">
					<div class="controls">
						<label>'. esc_attr__( 'Name *', 'kontruk' ) .'</label>
						<input type="text" class="input-block-level" name="author" id="author" value="'. esc_attr( $comment_author ) .'" size="22" tabindex="1" '. $aria_req . '>	
					</div>
				</div>';
		$email = '<div class="control-group your-email pull-left">
					<div class="controls">
						<label>'. esc_attr__( 'Email *', 'kontruk' ) .'</label>
						<input type="email" class="input-block-level" name="email" id="email" value="' . esc_attr( $comment_author_email ) .'" size="22" tabindex="2" '. $aria_req . '>
					</div>
				</div>';
		$url = '<div class="control-group website pull-left">
					<label>'. esc_attr__( 'Website', 'kontruk' ) .'</label>
					<input type="url" class="input-block-level" name="url" id="url" value="'. esc_attr( $comment_author_url ) .'" size="22" tabindex="3">
				</div>
			</div>';
		$comment_field = '<div class="cmm-box-bottom clearfix">
				<div class="control-group your-comment">			
					<div class="controls">
						<label>'. esc_attr__( 'Comment', 'kontruk' ) .'</label>
						<textarea name="comment" id="comment" class="input-block-level" rows="7" tabindex="4" '. $aria_req . '></textarea>
					</div>
				</div>
			</div>';
		$fields = array( 'author' => $author, 'email' => $email, 'url' => $url );
		$args = array( 'comment_field' => $comment_field, 'fields' => $fields, 'comment_notes_before' => $comment_notes_before, 'comment_notes_after' => '', 'title_reply' => $title_reply, 'label_submit' => esc_html__( 'Submit reply', 'kontruk' ) );
		comment_form( $args );
	endif;
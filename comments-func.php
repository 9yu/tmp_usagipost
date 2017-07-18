<?php
function better_comments( $comment, $args, $depth ) {
	global $post;
	$author_id = $post->post_author;
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments. ?>
		<div class="comment" id="comment-<?php echo get_comment_ID(); ?>">
			<div class="commentbody">
				<?php comment_text(); ?>
			</div>
			<p class="comment_state">
				<?php echo date_i18n( 'Y/m/d', strtotime(get_comment_time('c'))); ?>
				<?php $week = date_i18n( 'N', strtotime(get_comment_time('c'))); 
					  $weeklist = array('月','火','水','木','金','土','日'); 	
					  echo '(' . $weeklist[$week-1] . ')';
				?>
				&nbsp;
				<?php echo date_i18n( 'H:i:s', strtotime(get_comment_time('c'))); ?>
				&nbsp;|&nbsp;
				<a href="<?php echo get_comment_author_link(); ?>" title="「<?php comment_author(); ?>」" target="_blank"><?php comment_author(); ?></a>
			</p>
		</div>
	<?php
		break;
		default :
		// Proceed with normal comments. ?>
	<div class="comment" id="comment-<?php echo get_comment_ID(); ?>">
		<div class="commentbody">
			<?php comment_text(); ?>
		</div>
		<p class="comment_state">
			<?php comment_author(); 
			echo ':';
			echo date_i18n( 'Y/m/d', strtotime(get_comment_time('c')));
			$week = date_i18n( 'N', strtotime(get_comment_time('c'))); 
				  $weeklist = array('月','火','水','木','金','土','日'); 	
				  echo '(' . $weeklist[$week-1] . ')';
		
			echo ' ';
			echo date_i18n( 'H:i:s', strtotime(get_comment_time('c')));
			echo ' | ';
			if( !empty(get_comment_author_url()) ){
					echo '<a href="' . get_comment_author_url() . '" target="_blank">URL</a>';
				} else {
					echo 'URL';
				}
			
			echo ' | ';
			?>
			[<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => '回复',
							'depth'      => $depth,
							'max_depth'	 => $args['max_depth'] )
					) ); ?>]
		</p>
	</div>
	<?php
		break;
	endswitch; // End comment_type check.
}
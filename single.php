<?php get_header(); ?>

<?php
if (have_posts()) :
   while (have_posts()) : the_post();

?>

<div class="entry">

	<div class="entryday" datetime="<?php the_time('c') ?>">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;<?php the_time('Y'); ?><br /></p>
		<?php the_time('m.d'); ?>
	</div>

	<div class="entry_title">
		<a href="<?php the_permalink() ?>">
			<h3><?php the_title(); ?></h3>
		</a>
	</div>

	<div class="entry_body">
		<?php echo apply_filters('the_content',get_the_content('…')) ?>
	</div>

	<div class="entry_state">
		<p>
			<?php $categories = get_the_category(); ?>
			<a href="<?php echo esc_url( get_category_link($categories[0]->term_id) ); ?>"><?php echo $categories[0]->name; ?></a>
			:&nbsp;
			<?php 
			global $wpdb;
			$post_id = get_the_ID();
			$post_ping_count = $wpdb->get_var("SELECT count(comment_id) FROM $wpdb->comments WHERE comment_type IN ('pingback', 'trackback') and comment_approved = 1 and comment_post_id = $post_id");
			?>
			<?php if($post_ping_count > 0): ?>
			<a href="<?php the_permalink() ?>#trackback" title="<?php the_title(); ?>のトラックバック数">トラックバック(<?php echo $post_ping_count; ?>)</a>
			<?php else: ?>
			トラックバック(-)
			<?php endif; ?>
			&nbsp;
			<?php if( comments_open(get_the_ID()) ): ?>
			<a href="<?php the_permalink() ?>#comment" title="<?php the_title(); ?>のコメント数">コメント(<?php echo get_post(get_the_ID())->comment_count; ?>)</a>
			<?php else: ?>
			コメント(-)
			<?php endif; ?>
			&nbsp;
			<a href="#header">▲</a>
		</p>
	</div>

<!--
<?php trackback_rdf(); ?>
-->


</div>


<?php
   endwhile;
endif; 

comments_template();

?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
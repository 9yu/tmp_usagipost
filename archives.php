<?php
/*
Template Name: Archives
*/

get_header();
?>

<div class="entry_all">
	<p class="all_date">All articles of this blog</p>

<?php
$query = new WP_Query( 'nopaging=true' );
if ( $query->have_posts() ):
	while ( $query->have_posts() ):
		$query->the_post();
?>
	<div class="all_body">
		<p class="all_day">
			<strong><?php the_time('Y\'m/d'); ?></strong>
			<a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
			&nbsp;:&nbsp;
			<?php $categories = get_the_category(); ?>
			<a href="<?php echo esc_url( get_category_link($categories[0]->term_id) ); ?>"><?php echo $categories[0]->name; ?></a>
		</p>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└&nbsp;<?php echo mb_substr(get_the_excerpt(),0,19); ?>...
	<a href="<%titlelist_url>" target="_blank">続きを読む</a>
	</div>

<?php 
	endwhile;
endif;
wp_reset_postdata();
?>

</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
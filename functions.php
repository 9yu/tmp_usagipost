<?php

/*
// 清洗-主head
remove_action('wp_head', 'rsd_link'); //针对Blog的远程离线编辑器接口
remove_action('wp_head', 'wlwmanifest_link'); //Windows Live Writer接口
remove_action('wp_head', 'parent_post_rel_link', 10, 0); //移除后面文章的url
remove_action('wp_head', 'start_post_rel_link', 10, 0); //移除最开始文章的url
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);//自动生成的短链接
remove_action('wp_head', 'wp_generator'); // 移除版本号
remove_action('wp_head', 'index_rel_link');//当前文章的索引
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // 上、下篇.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink
remove_action('wp_head', 'rel_canonical' );
wp_deregister_script('l10n');
remove_action('wp_head','rsd_link');//移除head中的rel="EditURI"
remove_action('wp_head','wlwmanifest_link');//移除head中的rel="wlwmanifest"
remove_action('wp_head','rsd_link');//rsd_link移除XML-RPC
remove_filter('the_content', 'wptexturize');//禁用半角符号自动转换为全角
remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'wp_site_icon', 99);
// 清洗-emoji
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('emoji_svg_url', create_function('', 'return false;'));

// 头部引用
function fc_style() {
    wp_enqueue_style( 'fc-style', get_stylesheet_uri(), array(), '0.1' ); 
    wp_enqueue_style( 'code-style', get_template_directory_uri() . '/github-gist.css' , array(), '0.1' );
}
add_action( 'wp_enqueue_scripts', 'fc_style' );
*/


// 样式版本
function fc_ver() {
	echo '?ver=1';
	return;
}

// 注册菜单
register_nav_menus(  
	array (
		'header-menu' => 'Header Menu'
	)
);


// 清洗-菜单
function my_css_attributes_filter($var) {
	return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent','current')) : '';
}
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);

function MBT_special_nav_class($classes, $item){
	if( in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes) || in_array('current-post-parent', $classes) || in_array('current-post-ancestor', $classes)){
		$classes = array('current');
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'MBT_special_nav_class' , 10 , 2);

// more link
function modify_read_more_link() {
    return '<div class="entry_more">&nbsp;<a href="' . get_permalink() . '">...READ MORE？</a></div>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

// 解决wordpress自动加上p标签和br标签
//remove_filter (  'the_content' ,  'wpautop'  );//移除文章p自动标签
//remove_filter (  'the_excerpt' ,  'wpautop'  );//移除摘要p自动标签
//remove_filter( 'comment_text', 'wpautop',  30 );//取消评论自动<p></p>标签

require_once( get_template_directory() .'/comments-func.php' );


// 评论添加@，by Ludou
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<a href="#comment-' . $comment->comment_parent . '">> '.get_comment_author( $comment->comment_parent ) . '</a><br />' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);


/* 评论邮件通知 */
function comment_mail_notify($comment_id) { 
 $comment = get_comment($comment_id);
 $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
 $spam_confirmed = $comment->comment_approved; 
 if (($parent_id != '') && ($spam_confirmed != 'spam')) { 
 $wp_email = 'notify@push.yunet.work' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出点, no-reply 可改为可用的 e-mail. 
 $to = trim(get_comment($parent_id)->comment_author_email); 
 $subject = '[' . get_option("blogname") . '] 您的留言有了新回复'; 
 $message = ' 
 <div style="width: 60%;margin: 0 auto"> 
 <div style="font-size: 28px;line-height: 28px;text-align: center;"><p>' . trim(get_comment($parent_id)->comment_author) . '主人，向您表示最忠诚的问候！</p></div> 
 <div style="border-bottom: 1px solid #eee;padding-top: 10px;"> 
 <p style="color: #999;">您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言：</p> 
 <p style="font-size: 18px;">' . trim(get_comment($parent_id)->comment_content) . '</p> 
 </div> 
 <div style="border-bottom: 1px solid #eee;padding-top: 10px;"> 
 <p style="color: #999;">' . trim($comment->comment_author) . ' 给您的回复：</p> 
 <p style="font-size: 18px;">' . trim($comment->comment_content) . '</p>
 <p style="text-align: center;font-size: 12px;padding-bottom: 20px;"><a style="border: 1px solid #3297fb;color: #3297fb;padding: 7px 14px;text-decoration: none;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius:4px;" href="' . esc_attr(get_comment_link($parent_id, array('type' => 'comment'))) . '">点击查看</a></p> 
 </div> <div style="font-size: 12px;color: #999;text-align: center;"> 
 <p>*女仆无能，请勿回复</p> 
 <p>© 2017 <a href="https://9yu.eu" style="color: #999;text-decoration: none;">' . get_option('blogname') . '</a></p> 
 </div> 
 </div>'; 
 $from = "From: \"" . get_option('blogname') . "\" <$wp_email>"; 
 $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n"; wp_mail( $to, $subject, $message, $headers ); } } 
add_action('comment_post', 'comment_mail_notify');


function no_self_ping( &$links ) {
 $home = get_option( 'home' );
 foreach ( $links as $l => $link )
 if ( 0 === strpos( $link, $home ) )
 unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );

register_sidebar( array(
	'name'          => 'sidebar',
	'id'            => 'sidebar',
	'before_widget' => '',
	'after_widget'  => '</div>',
	'before_title'  => '<p class="sidebar_title">',
	'after_title'   => '</p><div class="sidebar_contents">' )
);

?>
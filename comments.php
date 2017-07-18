<div class="pageselect">
<?php next_post_link('<strong>%link</strong>', 'Next'); ?>
&nbsp;|&nbsp;
<?php previous_post_link('<strong>%link</strong>', 'Back'); ?>
</div>

<?php
if ( post_password_required() ){
    return;
    }
?>

<?php
wp_list_comments( array(
    'callback' => 'better_comments'
) );
?>

<div class="comment">
    <div class="comment_title">コメントの投稿</div>
        <div class="commentbody">
        <?php if(comments_open()) :
            comment_form( array(
                'class_submit' => 'serb',
                'title_reply' => '留言',
                'title_reply_to' => '回复给%s',
                'cancel_reply_link' => '取消',
                'label_submit' => '发布',
                'comment_notes_before' => '邮箱用于接受回复通知。'
                ));
        endif; ?>
        </div>
    </div>



<div class="comment">
    <div class="comment_title">trackback</div>
    <div class="commentbody">
        この記事のトラックバックURL<br />
        <p><input type="text" tabindex="8" name="trackback_url" size="60" value="<?php echo get_trackback_url(); ?>" onfocus="this.select()" class="trackbackurl" /></p>
    </div>
</div>

<div class="pageselect">
<?php next_post_link('<strong>%link</strong>', 'Next'); ?>
&nbsp;|<a href="/">TOP</a>|&nbsp;
<?php previous_post_link('<strong>%link</strong>', 'Back'); ?>
</div>
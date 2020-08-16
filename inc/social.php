<div class="rewards-thumbups">
    <?php if (vm_get_option('rewards_s')) {?>
        <a href="javascript:;" class="rewards-btn" data-event="rewards-open"><i class="fa fa-jpy"></i> <?php echo vm_get_option('rewards_text', '我要打赏') ?></a>
    <?php }?>

    <?php if (vm_get_option('thumbups_s')) {?>
        <a href="javascript:;" data-action="thumbup" data-id="<?php the_ID();?>" class="thumbups-btn favorite<?php if (isset($_COOKIE['like_cookie' . $post->ID])) {
    echo 'done';
}
    ?>"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php echo vm_get_option('thumbups_text', '喜欢') ?> <span class="count">(
            <?php if (get_post_meta($post->ID, 'like', true)) {
        echo get_post_meta($post->ID, 'like', true);
    } else {
        echo '0';
    }
    ?> )</span>
        </a>
    <?php }?>
</div>
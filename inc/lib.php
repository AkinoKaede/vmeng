<?php
require get_template_directory() . '/inc/options/options-framework.php';
require get_template_directory() . '/inc/res.php';
require get_template_directory() . '/inc/ajax-comment.php';
require get_template_directory() . '/inc/post-thumbnails.php';
require get_template_directory() . '/inc/widget.php';
require get_template_directory() . '/inc/vmeng.php';
require get_template_directory() . '/inc/notify.php';
require get_template_directory() . '/inc/comment-template.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/my-field.php';

if (vm_get_option('save_image')) {
    require get_template_directory() . '/inc/save-image.php';
}

if (vm_get_option('no_category')) {
    require get_template_directory() . '/inc/no-category.php';
}

if (vm_get_option('serverchan')) {
    require get_template_directory() . '/inc/serverchan.php';
}

function vmeng_seo()
{
    get_template_part('inc/seo');
}

function vmeng_copyright()
{
    get_template_part('inc/copyright');
}

function vmeng_social()
{
    get_template_part('inc/social');
}

//plugins
foreach (glob(get_template_directory() . '/lib/plugins/plugin-*.php') as $file_path) {
    include $file_path;
}

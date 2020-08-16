<?php
// 文章SEO
$seo_post_meta_boxes =
array(
    "custom_title" => array(
        "name" => "custom_title",
        "std" => "",
        "title" => "SEO自定义文章标题",
        "type" => "text"),

    "description" => array(
        "name" => "description",
        "std" => "",
        "title" => "SEO文章描述，留空则自动截取首段一定字数作为文章描述",
        "type" => "textarea"),

    "keywords" => array(
        "name" => "keywords",
        "std" => "",
        "title" => "SEO文章关键词，多个关键词用半角逗号隔开",
        "type" => "text"),
);

// 面板内容
function seo_post_meta_boxes()
{
    global $post, $seo_post_meta_boxes;
    //获取保存
    foreach ($seo_post_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '', true);
        if ($meta_box_value != "")
        //将默认值替换为已保存的值
        {
            $meta_box['std'] = $meta_box_value;
        }

        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'title':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                break;
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
            case 'radio':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                $counter = 1;
                foreach ($meta_box['buttons'] as $radiobutton) {
                    $checked = "";
                    if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
                        $checked = 'checked = "checked"';
                    }
                    echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
                    $counter++;
                }
                break;
            case 'checkbox':
                if (isset($meta_box['std']) && $meta_box['std'] == 'true') {
                    $checked = 'checked = "checked"';
                } else {
                    $checked = '';
                }

                echo '<br /><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
                echo '<label>' . $meta_box['title'] . '</label><br />';
                break;
        }
    }
}
// 创建面板
function seo_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('seo_post_meta_box', 'SEO设置', 'seo_post_meta_boxes', 'post', 'normal', 'high');
    }
}
// 保存数据
function save_seo_post_postdata($post_id)
{
    global $post, $seo_post_meta_boxes;
    foreach ($seo_post_meta_boxes as $meta_box) {
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

        }
        $data = $_POST[$meta_box['name'] . ''];
        if (get_post_meta($post_id, $meta_box['name'] . '') == "") {
            add_post_meta($post_id, $meta_box['name'] . '', $data, true);
        } elseif ($data != get_post_meta($post_id, $meta_box['name'] . '', true)) {
            update_post_meta($post_id, $meta_box['name'] . '', $data);
        } elseif ($data == "") {
            delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
        }

    }
}
// 触发
add_action('admin_menu', 'seo_post_meta_box');
add_action('save_post', 'save_seo_post_postdata');

// 文章手动缩略图
$thumbnail_post_meta_boxes =
array(
    "thumbnail" => array(
        "name" => "thumbnail",
        "std" => "",
        "title" => "输入图片地址，调用指定缩略图，图片尺寸要求与主题选项中对应缩略图大小相同",
        "type" => "text"),
);

// 面板内容
function thumbnail_post_meta_boxes()
{
    global $post, $thumbnail_post_meta_boxes;
    //获取保存
    foreach ($thumbnail_post_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '', true);
        if ($meta_box_value != "")
        //将默认值替换为已保存的值
        {
            $meta_box['std'] = $meta_box_value;
        }

        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'title':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                break;
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
            case 'radio':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                $counter = 1;
                foreach ($meta_box['buttons'] as $radiobutton) {
                    $checked = "";
                    if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
                        $checked = 'checked = "checked"';
                    }
                    echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
                    $counter++;
                }
                break;
            case 'checkbox':
                if (isset($meta_box['std']) && $meta_box['std'] == 'true') {
                    $checked = 'checked = "checked"';
                } else {
                    $checked = '';
                }

                echo '<br /><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
                echo '<label>' . $meta_box['title'] . '</label><br />';
                break;
        }
    }
}
// 创建面板
function thumbnail_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('thumbnail_post_meta_box', '手动缩略图', 'thumbnail_post_meta_boxes', 'post', 'normal', 'high');
    }
}
// 保存数据
function save_thumbnail_post_postdata($post_id)
{
    global $post, $thumbnail_post_meta_boxes;
    foreach ($thumbnail_post_meta_boxes as $meta_box) {
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

        }
        $data = $_POST[$meta_box['name'] . ''];
        if (get_post_meta($post_id, $meta_box['name'] . '') == "") {
            add_post_meta($post_id, $meta_box['name'] . '', $data, true);
        } elseif ($data != get_post_meta($post_id, $meta_box['name'] . '', true)) {
            update_post_meta($post_id, $meta_box['name'] . '', $data);
        } elseif ($data == "") {
            delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
        }

    }
}
// 触发
add_action('admin_menu', 'thumbnail_post_meta_box');
add_action('save_post', 'save_thumbnail_post_postdata');

// 文章其它设置
$other_post_meta_boxes =
array(
    "from" => array(
        "name" => "from",
        "std" => "",
        "title" => "文章来源",
        "type" => "text"),

    "copyright" => array(
        "name" => "copyright",
        "std" => "",
        "title" => "原文链接",
        "type" => "text"),

);

// 面板内容
function other_post_meta_boxes()
{
    global $post, $other_post_meta_boxes;
    //获取保存
    foreach ($other_post_meta_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '', true);
        if ($meta_box_value != "")
        //将默认值替换为已保存的值
        {
            $meta_box['std'] = $meta_box_value;
        }

        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'title':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                break;
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
            case 'radio':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                $counter = 1;
                foreach ($meta_box['buttons'] as $radiobutton) {
                    $checked = "";
                    if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
                        $checked = 'checked = "checked"';
                    }
                    echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
                    $counter++;
                }
                break;
            case 'checkbox':
                if (isset($meta_box['std']) && $meta_box['std'] == 'true') {
                    $checked = 'checked = "checked"';
                } else {
                    $checked = '';
                }

                echo '<br /><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
                echo '<label>' . $meta_box['title'] . '</label><br />';
                break;
        }
    }
}
// 创建面板
function other_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('other_post-meta-boxes', '其它设置', 'other_post_meta_boxes', 'post', 'normal', 'high');
    }
}
// 保存数据
function save_other_post_postdata($post_id)
{
    global $post, $other_post_meta_boxes;
    foreach ($other_post_meta_boxes as $meta_box) {
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

        }
        $data = $_POST[$meta_box['name'] . ''];
        if (get_post_meta($post_id, $meta_box['name'] . '') == "") {
            add_post_meta($post_id, $meta_box['name'] . '', $data, true);
        } elseif ($data != get_post_meta($post_id, $meta_box['name'] . '', true)) {
            update_post_meta($post_id, $meta_box['name'] . '', $data);
        } elseif ($data == "") {
            delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
        }

    }
}
// 触发
add_action('admin_menu', 'other_post_meta_box');
add_action('save_post', 'save_other_post_postdata');

// 页面相关自定义栏目
$new_meta_page_boxes =
array(

    "custom_title" => array(
        "name" => "custom_title",
        "std" => "",
        "title" => "SEO自定义页面标题",
        "type" => "text"),

    "description" => array(
        "name" => "description",
        "std" => "",
        "title" => "文章描述，留空则自动截取首段一定字数作为文章描述",
        "type" => "textarea"),

    "keywords" => array(
        "name" => "keywords",
        "std" => "",
        "title" => "文章关键词，多个关键词用半角逗号隔开",
        "type" => "text"),

);

// 面板内容
function new_meta_page_boxes()
{
    global $post, $new_meta_page_boxes;
    //获取保存
    foreach ($new_meta_page_boxes as $meta_box) {
        $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '', true);
        if ($meta_box_value != "")
        //将默认值替换为已保存的值
        {
            $meta_box['std'] = $meta_box_value;
        }

        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'title':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                break;
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
            case 'radio':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                $counter = 1;
                foreach ($meta_box['buttons'] as $radiobutton) {
                    $checked = "";
                    if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
                        $checked = 'checked = "checked"';
                    }
                    echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
                    $counter++;
                }
                break;
            case 'checkbox':
                if (isset($meta_box['std']) && $meta_box['std'] == 'true') {
                    $checked = 'checked = "checked"';
                } else {
                    $checked = '';
                }

                echo '<br /><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
                echo '<label>' . $meta_box['title'] . '</label><br />';
                break;
        }
    }
}

function create_meta_page_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('new-meta-boxes', '页面设置', 'new_meta_page_boxes', 'page', 'normal', 'high');
    }
}
function save_page_postdata($post_id)
{
    global $post, $new_meta_page_boxes;
    foreach ($new_meta_page_boxes as $meta_box) {
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }

        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

        }
        $data = $_POST[$meta_box['name'] . ''];
        if (get_post_meta($post_id, $meta_box['name'] . '') == "") {
            add_post_meta($post_id, $meta_box['name'] . '', $data, true);
        } elseif ($data != get_post_meta($post_id, $meta_box['name'] . '', true)) {
            update_post_meta($post_id, $meta_box['name'] . '', $data);
        } elseif ($data == "") {
            delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
        }

    }
}
add_action('admin_menu', 'create_meta_page_box');
add_action('save_post', 'save_page_postdata');

$one_delete =
array(
    "posts" => array("name" => "posts"),
    "from" => array("name" => "from"),
    "copyright" => array("name" => "copyright"),
);

function save_one_delete($post_id)
{
    global $post, $one_delete;
    foreach ($one_delete as $meta_box) {
        $data = $_POST[$meta_box['name'] . ''];
        if ($data == "") {
            delete_post_meta($post_id, $meta_box['name'] . '', get_post_meta($post_id, $meta_box['name'] . '', true));
        }

    }
}
add_action('save_post', 'save_one_delete');

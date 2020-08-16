<?php
define('Vmeng_Ver', wp_get_theme()->get('Vesion'));
function vmeng_setup()
{
    //注册菜单
    register_nav_menu('vm_menu', __('主菜单', 'vmeng'));
}
add_action('after_setup_theme', 'vmeng_setup');
// 开启文章缩略图(特色图像)
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post'));
}
/*
 * WordPress 后台禁用Google Open Sans字体，加速网站
 */
function vmeng_disable_open_sans($translations, $text, $context, $domain)
{
    if ('Open Sans font: on or off' == $context && 'on' == $text) {
        $translations = 'off';
    }
    return $translations;
}
add_filter('gettext_with_context', 'vmeng_disable_open_sans', 888, 4);

/*
 * 搜索模块 前台页面搜索DOM结构自定义，样式自定义
 */
function vmeng_search_form($form)
{
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url('/') . '" >
	<div class="form-group" style="margin-bottom:0;">
	<input type="search" value="' . get_search_query() . '" name="s" id="s" class="form-control" placeholder="' . __('善于搜索...', 'vmeng') . '" />
	<input type="submit" id="searchsubmit" class="hide" value="' . esc_attr__('Search') . '" />
	</div>
	</form>';

    return $form;
}

add_filter('get_search_form', 'vmeng_search_form');

/*
 *文章摘要结尾字符替换
 */
function new_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
/*
 *文章摘要截取字符长度
 */
function new_excerpt_length($length)
{
    return 80;
}
add_filter('excerpt_length', 'new_excerpt_length');

/*
 * 注册小工具
 */
function vmeng_widgets_init()
{
    register_sidebar(array(
        'name' => __('右部边栏', 'vmeng'),
        'id' => 'sidebar-right',
        'description' => __('右部边栏', 'vmeng'),
        'before_widget' => '<div id="%2$s" class="panel panel-default vm-panel" >',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="vm-widget-title">',
        'after_title' => '</h4>',
    ));

    $unregister_widgets = array(
        'Tag_Cloud',
        'Recent_Comments',
        'Recent_Posts',
        'Bloger_Info',
        'Php_Text',
        'Banner',
    );

    foreach ($unregister_widgets as $widget) {
        unregister_widget('WP_Widget_' . $widget);
    }

}
add_action('widgets_init', 'vmeng_widgets_init');

/*
 * Bootstrap 导航菜单
 */

class vmeng_Nav_Walker extends Walker_Nav_Menu
{

    /*
     * @see Walker_Nav_Menu::start_lvl()
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "\n<ul class=\"dropdown-menu\">\n";
    }

    /*
     * @see Walker_Nav_Menu::start_el()
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $li_attributes = $class_names = $value = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if ($args->has_children) {
            $classes[] = (1 > $depth) ? 'dropdown' : 'dropdown-submenu';
            $li_attributes .= ' data-dropdown="dropdown"';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

        $attributes = $item->attr_title ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= $item->target ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= $item->xfn ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= $item->url ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= $args->has_children ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

        $item_output = $args->before . '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= ($args->has_children and 1 > $depth) ? ' <b class="caret"></b>' : '';
        $item_output .= '</a>' . $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /*
     * @see Walker::display_element()
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        //display this element
        if (is_array($args[0])) {
            $args[0]['has_children'] = (bool) (!empty($children_elements[$element->$id_field]) and $depth != $max_depth - 1);
        } elseif (is_object($args[0])) {
            $args[0]->has_children = (bool) (!empty($children_elements[$element->$id_field]) and $depth != $max_depth - 1);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if (($max_depth == 0 or $max_depth > $depth + 1) and isset($children_elements[$id])) {

            foreach ($children_elements[$id] as $child) {

                if (!isset($newlevel)) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge(array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[$id]);
        }

        if (isset($newlevel) and $newlevel) {
            //end the child delimiter
            $cb_args = array_merge(array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
}

/*
 * 给激活的导航菜单添加 .active
 */
function vmeng_nav_menu_css_class($classes)
{
    if (in_array('current-menu-item', $classes) or in_array('current-menu-ancestor', $classes)) {
        $classes[] = 'active';
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'vmeng_nav_menu_css_class');
require get_template_directory() . '/inc/lib.php';

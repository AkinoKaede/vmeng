<?php
// 头部冗余代码
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
// 移除头部 wp-json 标签和 HTTP header 中的 link
remove_action('wp_head', 'rest_output_link_wp_head', 10 );
remove_action('template_redirect', 'rest_output_link_header', 11 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
//禁止 s.w.org
function vmeng_remove_dns_prefetch($hints, $relation_type){
    if ('dns-prefetch' === $relation_type) {
        return array_diff(wp_dependencies_unique_hosts(), $hints);
    }
    return $hints;
}
add_filter('wp_resource_hints', 'vmeng_remove_dns_prefetch', 10, 2);
//清除wp_footer带入的embed.min.js
function vmeng_deregister_embed_script(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'vmeng_deregister_embed_script' );
// 屏蔽 REST API
if(vm_get_option('restapi_no')){
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
}
/*
 * 网站标题 不同页面加载不同标题
 */
if (!vm_get_option('seo')) {
function vmeng_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// 添加网站名称
	$title .= get_bloginfo( 'name' );

	// 为首页添加网站描述
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// 在页面标题中添加页码
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'vmeng' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'vmeng_wp_title', 10, 2 );
}
//Poi
function vmeng_poi(){
	if (vm_get_option('hitokoto_type') == 'random'){
	$hitokoto_type = '';
	}else{
	$hitokoto_type = vm_get_option('hitokoto_type');
    }
    $slider_n = vm_get_option('slider_n') !== '0';
	$poi = json_encode(array(
	'instantclick' => vm_get_option('instantclick'),
	'hitokoto_type' => $hitokoto_type,
    'template_directory_uri' => get_template_directory_uri(),
    'slider_n' => $slider_n
	));
	echo "<script type='text/javascript'>/* <![CDATA[ */var Poi = ".$poi.";/* ]]> */</script>";
}
add_action( 'wp_head', 'vmeng_poi' );
//自定义CSS
if(vm_get_option('custom_css') != '') {
function vmeng_custom_css(){
	echo "<style>\n".vm_get_option('custom_css')."</style>\n";
}
add_action( 'wp_head', 'vmeng_custom_css' );
}
//统计
if(vm_get_option('tongji') !== ''){
function vmeng_tongji(){
	echo vm_get_option('tongji');
}
add_action( 'wp_footer', 'vmeng_tongji' );
}
function time_ago( $time_type ){
	switch( $time_type ){
		case 'comment': //评论时间
			$time_diff = current_time('timestamp') - get_comment_time('U');
			if( $time_diff <= 300 )
				echo ('刚刚');
			elseif(  $time_diff>=300 && $time_diff <= 86400 ) //24 小时之内
				echo human_time_diff(get_comment_time('U'), current_time('timestamp')).'前';
			else
				printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time());
			break;
		case 'post'; //日志时间
			$time_diff = current_time('timestamp') - get_the_time('U');
			if( $time_diff <= 300 )
				echo ('刚刚');
			elseif(  $time_diff>=300 && $time_diff <= 86400 ) //24 小时之内
				echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
			else
				echo the_time( 'm月d日' );
			break;
		case 'posts'; //日志时间年
			$time_diff = current_time('timestamp') - get_the_time('U');
			if( $time_diff <= 300 )
				echo ('刚刚');
			elseif(  $time_diff>=300 && $time_diff <= 86400 ) //24 小时之内
				echo human_time_diff(get_the_time('U'), current_time('timestamp')).'前';
			else
				echo get_the_date();
			break;
	}
}
//注册说说类型文章
add_action('init', 'my_custom_init');
function my_custom_init()
{ $labels = array( 'name' => '说说',
'singular_name' => '说说', 
'add_new' => '发表说说', 
'add_new_item' => '发表说说',
'edit_item' => '编辑说说', 
'new_item' => '新说说',
'view_item' => '查看说说',
'search_items' => '搜索说说', 
'not_found' => '暂无说说',
'not_found_in_trash' => '没有已遗弃的说说',
'parent_item_colon' => '', 'menu_name' => '说说' );
$args = array( 'labels' => $labels,
'public' => true, 
'publicly_queryable' => true,
'show_ui' => true,
'show_in_menu' => true, 
'exclude_from_search' =>true,
'query_var' => true, 
'rewrite' => true, 'capability_type' => 'post',
'has_archive' => false, 'hierarchical' => false, 
'menu_position' => null, 'supports' => array('editor','author','title', 'custom-fields') );
register_post_type('shuoshuo',$args); 
}
//添加后台左下角文字
function vmeng_admin_footer_text($text) {
        $text = '感谢使用<a target="_blank" href="https://www.iknet.top/" >Vmeng主题 '.Vmeng_Ver.'</a>进行创作';
    return $text;
}
add_filter('admin_footer_text', 'vmeng_admin_footer_text');
// 外链跳转
	add_filter('the_content','link_to_jump',999);
	function link_to_jump($content){
		preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/',$content,$matches);
		if($matches){
		    foreach($matches[2] as $val){
			    if(strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff|swf)/i',$val) && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i',$val)){
			    	$content=str_replace("href=\"$val\"", "href=\"".get_template_directory_uri()."/inc/go.php?url=$val\" ",$content);
				}
			}
		}
		if(vm_get_option('instantclick')) {
		return link_to_jump_pajx($content);
		}else{
		return $content;
		}
	}
    function link_to_jump_pajx($content) {
        $content = preg_replace('/<a\b[^>]+\bhref="([^"]*)[g^][o^][.^][p^][h^][p^][?^]url=([^\'"]*)"([^>])*>([\s\S]*?)<\/a>/i','<a href="$1go.php?url=$2" $3 data-no-instant>$4</a>',$content);
	return $content;
    }
    function reply_instantclick($content) {
        $content = preg_replace('/<a (.*?)\>(.*?)<\/a>/i','<a $1 data-no-instant>$2</a>',$content);
	echo $content;
    }	

	// 评论者链接跳转并新窗口打开
	function commentauthor($comment_ID = 0) {
		$url    = get_comment_author_url( $comment_ID );
		$author = get_comment_author( $comment_ID );
		if ( empty( $url ) || 'http://' == $url || 'https://' == $url )
		echo $author;
		else
		echo "<a href='".get_template_directory_uri()."/inc/go.php?url=$url' rel='external nofollow' target='_blank' class='url' data-no-instant>$author</a>";
	}
	// gravatar头像调用
function cn_avatar($avatar) {
	$avatar = preg_replace( "/(www|\d).gravatar.com/i","http://cn.gravatar.com",$avatar );
	return $avatar;
}
function ssl_avatar($avatar) {
	$avatar = preg_replace( "/http:\/\//i","https://",$avatar );
	$avatar = preg_replace( "/(www|\d).gravatar.com/i","secure.gravatar.com",$avatar );
	return $avatar;
}
function loli_avatar($avatar) {
	$avatar = preg_replace( "/http:\/\//i","https://",$avatar );
	$avatar = preg_replace( "/(www|\d).gravatar.com/i","gravatar.loli.net",$avatar );
	return $avatar;
}
function qiniu_avatar($avatar) {
	$avatar = preg_replace( "/(www|\d).gravatar.com/i","dn-qiniu-avatar.qbox.me",$avatar );
	return $avatar;
}
if (vm_get_option('no') !== 'no') :
	if (!vm_get_option('gravatar_url') || (vm_get_option("gravatar_url") == 'ssl')) {
		add_filter('get_avatar', 'ssl_avatar');
	}

	if (vm_get_option('gravatar_url') == 'cn') {
		add_filter('get_avatar', 'cn_avatar');
	}
	
	if (vm_get_option('gravatar_url') == 'loli') {
		add_filter('get_avatar', 'loli_avatar');
	}
	
	if (vm_get_option('gravatar_url') == 'qiniu') {
		add_filter('get_avatar', 'qiniu_avatar');
	}
endif;
// 头像添加alt
function avatar_alt($avatar) {
	$avatar = preg_replace( "/alt=''/i","alt=\"avatar\"",$avatar );
	return $avatar;
}
add_filter('get_avatar', 'avatar_alt');
function html_page_permalink() {
	global $wp_rewrite;
	if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
		$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
	}
}
if (vm_get_option('page_html')) {
	add_action('init', 'html_page_permalink', -1);
}
if (vm_get_option('baidu_submit')) {
// 主动推送
if(!function_exists('Baidu_Submit')){
    function Baidu_Submit($post_ID) {
		$WEB_DOMAIN = get_option('home');
		if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
		$url = get_permalink($post_ID);
		$api = 'http://data.zz.baidu.com/urls?site='.$WEB_DOMAIN.'&token='.vm_get_option('token_p');
		$request = new WP_Http;
		$result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
		$result = json_decode($result['body'],true);
		if (array_key_exists('success',$result)) {
		    add_post_meta($post_ID, 'Baidusubmit', 1, true);
		}
	}
	add_action('publish_post', 'Baidu_Submit', 0);
}
}
if (vm_get_option('refused_spam')) {
	// 禁止无中文留言
	if ( current_user_can('level_10') ) {
	} else {
	function refused_spam_comments( $comment_data ) {
		$pattern = '/[一-龥]/u';  
		if(!preg_match($pattern,$comment_data['comment_content'])) {
			fa_ajax_comment_err(__('<i class="fa fa-exclamation-circle"></i>评论必须含中文！'));
		}
		return( $comment_data );
	}
	add_filter('preprocess_comment','refused_spam_comments');
	}
}

if (vm_get_option('email_check')) {
	// 判断邮箱是否存在
	if ( !current_user_can('level_10') ) {
	function email_check_comments( $comment_data ) {
		$pattern = '/[一-龥]/u';  
		 if(file_get_contents('https://ihuan.me/mail/check.php?check='.$comment_data['comment_author_email'])!=1){
      fa_ajax_comment_err( '<i class="fa fa-exclamation-circle"></i>您的邮箱地址不正确' );
        }
		return( $comment_data );
	}
	add_filter('preprocess_comment','email_check_comments');
	}
}
//屏蔽关键词，email，url，ip
if (vm_get_option('spam_keywords') && !is_user_logged_in()):
function vmeng_fuckspam($comment) {
    if (wp_blacklist_check($comment['comment_author'], $comment['comment_author_email'], $comment['comment_author_url'], $comment['comment_content'], $comment['comment_author_IP'], $comment['comment_agent'])) {
        header("Content-type: text/html; charset=utf-8");
        fa_ajax_comment_err(__('<i class="fa fa-exclamation-circle"></i>不好意思，您的评论违反本站评论规则'));
    } else {
        return $comment;
    }
}
add_filter('preprocess_comment', 'vmeng_fuckspam');
endif;
//屏蔽长连接评论
if (vm_get_option('spam_long') && !is_user_logged_in()):
function lang_url_spamcheck($approved, $commentdata) {
    return (strlen($commentdata['comment_author_url']) > 50) ?
    'spam' : $approved;
}
add_filter('pre_comment_approved', 'lang_url_spamcheck', 99, 2);
endif;
//屏蔽昵称，评论内容带链接的评论
if (vm_get_option('spam_url') && !is_user_logged_in()):
function vmeng_link($comment_data) {
    $links = '/http:\/\/|https:\/\/|www\./u';
    if (preg_match($links, $comment_data['comment_author']) || preg_match($links, $comment_data['comment_content'])) {
        fa_ajax_comment_err(__('<i class="fa fa-exclamation-circle"></i>在昵称和评论里面是不准发链接滴.'));
    }
    return ($comment_data);
}
    add_filter('preprocess_comment', 'vmeng_link');
endif;
function usercheck($incoming_comment) {
	$isSpam = 0;
	if (trim($incoming_comment['comment_author']) == ''.vm_get_option('admin_name').'')
	$isSpam = 1;
	if (trim($incoming_comment['comment_author_email']) == ''.vm_get_option('admin_email').'')
	$isSpam = 1;
	if(!$isSpam)
	return $incoming_comment;
	fa_ajax_comment_err('<i class="fa fa-exclamation-circle"></i>请勿冒充管理员发表评论！');
}
if (vm_get_option('check_admin')){
add_filter('preprocess_comment','usercheck');
}
// 禁止代码标点转换
remove_filter( 'the_content', 'wptexturize' );
if (vm_get_option('xmlrpc_no')) {
// 禁用xmlrpc
add_filter('xmlrpc_enabled', '__return_false');
}
//添加链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
//fancybox3图片添加 data-fancybox 属性
function fancybox ($content){
    global $post;
    $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 data-fancybox="images"$6 data-no-instant>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
add_filter('the_content', 'fancybox');
//去除工具条
add_filter('show_admin_bar', '__return_false');
// 评论添加@
function comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<a href="#comment-' . $comment->comment_parent . '" class="comment-at">@'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'comment_add_at', 20, 2);
//文章目录
function article_menu($content) {
    //判断是否是文章页
    if(is_single()){
        // 将目录拼接到文章
        $content .= "<div class=\"autoMenu\" id=\"autoMenu\" data-autoMenu> </div>\n";
		return $content;
    }else{
		return $content;
    }
}
add_filter( "the_content", "article_menu" );
//编辑器扩展
function custum_fontfamily($initArray){
   $initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';";
   return $initArray;
}
function enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'del';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	$buttons[] = 'wp_page';
	$buttons[] = 'anchor';
	$buttons[] = 'backcolor';
	return $buttons;
}
add_filter( "mce_buttons_2", "enable_more_buttons" );
// 可视化按钮
add_action( 'admin_init', 'vmeng_tinymce_button' );

function vmeng_tinymce_button() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_buttons', 'vmeng_register_tinymce_button' );
		add_filter( 'mce_external_plugins', 'vmeng_add_tinymce_button' );
	}
}

function vmeng_register_tinymce_button( $buttons ) {
	array_push( $buttons,"url","addCollapse","reply","login","password","addPost","comments","highlight" );
	return $buttons;
}

function vmeng_add_tinymce_button( $plugin_array ) {
	$plugin_array['vmeng_button_script'] = get_bloginfo( 'template_url' ) . '/js/buttons.js';
		$plugin_array['highlight'] = get_bloginfo( 'template_url' ) . '/js/highlight.js';
	return $plugin_array;
}

// 添加编辑器快捷按钮
function my_quicktags() {
    global $pagenow;
    if( $pagenow == 'post-new.php' || $pagenow == 'post.php' ){
    wp_enqueue_script('qtag', get_stylesheet_directory_uri() . '/js/qtag.js', array('quicktags'), '1.0', true );
	}
};
add_action('admin_print_scripts', 'my_quicktags');

//折叠
function vmeng_collapse($atts, $content = null){
	extract(shortcode_atts(array("title"=>""),$atts));
	return '<div style="margin: 0.5em 0;background:#f9f9f9;">
		<div class="xControl">
			<a href="javascript:void(0)" class="collapseButton xButton"><h5>'.$title.'</h5></a>
			<div class="xicon"><a href="javascript:void(0)" class="icoButton"><i class="fa fa-plus"></i></a></div>
		</div>
		<div class="xContent" style="display: none;">'.$content.'</div>
	</div>';
}
add_shortcode('collapse', 'vmeng_collapse');

// 维护模式
function wp_maintenance_mode(){
    if(!current_user_can('edit_themes') || !is_user_logged_in()){
        wp_die('<div style="text-align:center"><img src="'.get_template_directory_uri().'/img/logo.png" /><br/>'.get_bloginfo('name').'正在维护中……</div>', get_bloginfo('name').'正在维护中……',array('response' => '503'));
    }
}
if(vm_get_option('maintenance_mode')){
    add_action('get_header', 'wp_maintenance_mode');
}

// 归档
 function vmeng_archives_list() {
     if( !$output = get_option('vmeng_archives_list') ){
         $output = '<div id="archives"><p> <em>注: 点击月份可以展开</em></p>';
         $the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' ); //update: 加上忽略置顶文章
         $year=0; $mon=0; $i=0; $j=0;
         while ( $the_query->have_posts() ) : $the_query->the_post();
             $year_tmp = get_the_time('Y');
             $mon_tmp = get_the_time('m');
             $y=$year; $m=$mon;
             if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
             if ($year != $year_tmp && $year > 0) $output .= '</ul>';
             if ($year != $year_tmp) {
                 $year = $year_tmp;
                 $output .= '<h3 class="al_year">'. $year .' 年</h3><ul class="al_mon_list">'; //输出年份
             }
             if ($mon != $mon_tmp) {
                 $mon = $mon_tmp;
                 $output .= '<li><span class="al_mon">'. $mon .' 月</span><ul class="al_post_list">'; //输出月份
             }
             $output .= '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'">'. get_the_title() .'</a> <em><i class="fa fa-comment-o"></i> '. get_comments_number().'人吐槽</em></li>'; //输出文章日期和标题
         endwhile;
         wp_reset_postdata();
         $output .= '</ul></li></ul></div>';
         update_option('vmeng_archives_list', $output);
     }
     echo $output;
 }
 function clear_zal_cache() {
     update_option('vmeng_archives_list', ''); // 清空 vmeng_archives_list
 }
 add_action('save_post', 'clear_zal_cache'); // 新发表文章/修改文章时
 //短代码
 add_filter ( 'comment_text' , 'do_shortcode' ) ; //评论启用短代码
 //文章链接
 function vemng_shortcode_post( $atts, $content = null ){
    extract( shortcode_atts( array(
        'id' => ''
    ),
        $atts ) );
    global $post;
    $content = '';
    $postid =  explode(',', $id);
    $inset_posts = get_posts(array('post__in'=>$postid));
    foreach ($inset_posts as $key => $post) {
        setup_postdata( $post );
		if ( function_exists(  'the_views'  ) ) {
        $content .=  '<div id="post-='.get_the_ID().'" class="thumbnail">
		<div class="vm-pagelist-img">'. vmeng_thumbnail_p() .' </div>
        <div class="caption">
        <div class="vm-page-title">
		<a href="' . get_permalink() . '">' . get_the_title() . '</a></div>
        <p class="vm-author-info">
		<time><i class="fa fa-clock-o"></i> '. timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ).'</time> &bull; 
        <span><i class="fa fa-user-o"></i> '.get_the_author_posts_link().'</span> &bull; 
		<span><i class="fa fa-list-alt"></i> '.get_category(' | ','single','').'</span> &bull; 
        <span><a herf="'.get_comments_link().'"><i class="fa fa-comment-o"></i> '.get_comments_number().'条评论</a></span>&bull;
		<span><i class="fa fa-eye"></i> '.the_views(false).'</span>
		</p>
        <p class="hidden-xs">'.esc_attr(get_the_excerpt()). '</p>
        <p class="clearfix">
        <a class="hidden-xs pull-right vm-more-link" href="'.get_permalink().'" role="button">前往阅读 &raquo;</a>
        <span class="vm-tags">'.get_the_tags('',' ','').'</span>
        </p>
        </div>
        </div>';	
		}else{	
        $content .=  '<div id="post-='.the_ID().'" class="thumbnail">
		<div class="vm-pagelist-img">'. vmeng_thumbnail_p() .' </div>
        <div class="caption">
        <div class="vm-page-title">
		<a href="' . get_permalink() . '">' . get_the_title() . '</a></div>
        <p class="vm-author-info">
		<time><i class="fa fa-clock-o"></i> '. timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ).'</time> &bull; 
        <span><i class="fa fa-user-o"></i> '.get_the_author_posts_link().'</span> &bull; 
		<span><i class="fa fa-list-alt"></i> '.get_category(' | ','single','').'</span> &bull; 
        <span><a herf="'.get_comments_link().'"><i class="fa fa-comment-o"></i> '.get_comments_number().'条评论</a></span>
		</p>
        <p class="hidden-xs">'.esc_attr(get_the_excerpt()). '</p>
        <p class="clearfix">
        <a class="hidden-xs pull-right vm-more-link" href="'.get_permalink().'" role="button">前往阅读 &raquo;</a>
        <span class="vm-tags">'.get_the_tags('',' ','').'</span>
        </p>
        </div>
        </div>';	
		}
    }
    wp_reset_postdata();
    return $content;
}
add_shortcode('post', 'vemng_shortcode_post');
// 链接按钮
function button_url($atts,$content=null){
	extract(shortcode_atts(array("href"=>'http://'),$atts));
	return '<div class="down down-link"><a href="'.$href.'" rel="external nofollow" target="_blank"><i class="fa fa-cloud-download"></i>'.$content.'</a><div class="clear"></div></div><div class="down-line"></div>';
}
add_shortcode('url', 'button_url');
function shortcode_comments( $atts, $content = null ){  
    extract( shortcode_atts( array(  
        'id' => ''  
    ),$atts ) );  
    $content     = '';  
    $comment_ids = explode(',', $id);  
    $query_args  = array('comment__in'=>$comment_id,);  
    $fa_comments = get_comments($query_args);  
    if ( empty($fa_comments) ) return;  
    foreach ($fa_comments as $key => $fa_comment) {  
        $content .= '<div class="comment-mixtype-embed"><span class="comment-mixtype-embed-avatar">' . get_avatar($fa_comment->comment_author_email,32) . '</span><div class="comment-mixtype-embed-author"><a href="' . get_permalink($fa_comment->comment_post_ID).'#comment-' . $fa_comment->comment_ID . '">' . $fa_comment->comment_author . '</a> - <a href="' . get_permalink($fa_comment->comment_post_ID) . '">' . get_the_title($fa_comment->comment_post_ID) . '</a></div><div class="comment-mixtype-embed-date">' . $fa_comment->comment_date .'</div><div class="comment-mixtype-embed-text">'.  $fa_comment->comment_content . '</div></div>';  
    }  
    return $content;  
}  
add_shortcode('comments', 'shortcode_comments');  
function timeago( $ptime ) {   
    $ptime = strtotime($ptime);   
    $etime = time() - $ptime;   
    if ($etime < 1)
        return '刚刚';
    $interval = array ( 12 * 30 * 24 * 60 * 60 => '年前 ('.date('Y-m-d', $ptime).')', 30 * 24 * 60 * 60 => '个月前 ('.date('m-d', $ptime).')', 7 * 24 * 60 * 60 => '周前 ('.date('m-d', $ptime).')', 24 * 60 * 60 => '天前', 60 * 60 => '小时前', 60 => '分钟前', 1 => '秒前' );   
    foreach ($interval as $secs => $str) {   
    $d = $etime / $secs;   
    if ($d >= 1) {   
        $r = round($d);   
        return $r . $str;   
    }
    }
}  
function reply_read($atts, $content=null) {
	extract(shortcode_atts(array("notice" => '
	<div class="reply-read">
		<div class="reply-ts">
			<div class="read-sm"><i class="fa fa-exclamation-circle"></i>' . sprintf(__( '此处为隐藏的内容！', 'vmeng' )) . '</div>
			<div class="read-sm"><i class="fa fa-spinner"></i>' . sprintf(__( '发表评论并刷新，才能查看', 'vmeng' )) . '</div>
		</div>
		<div class="read-pl"><a href="#respond">' . sprintf(__( '发表评论', 'vmeng' )) . '</a></div>
		<div class="clear"></div>
    </div>'), $atts));
	$email = null;
	$user_ID = (int) wp_get_current_user()->ID;
	if ($user_ID > 0) {
		$email = get_userdata($user_ID)->user_email;
		if ( current_user_can('level_10') ) {
	return '<div class="secret-password"><i class="fa fa-check-square"></i>隐藏的内容：<br />'.do_shortcode( $content ).'</div>';
		}
	} else if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
		$email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);
	} else {
		return $notice;
	}
    if (empty($email)) {
		return $notice;
	}
	global $wpdb;
	$post_id = get_the_ID();
	$query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
	if ($wpdb->get_results($query)) {
		return do_shortcode('<div class="secret-password"><i class="fa fa-check-square"></i>隐藏的内容：<br />'.do_shortcode( $content ).'</div>');
	} else {
		return $notice;
	}
}
add_shortcode('reply', 'reply_read');
// 登录可见
function login_to_read($atts, $content = null) {
	extract(shortcode_atts(array("notice" =>'
	<div class="reply-read">
		<div class="reply-ts">
			<div class="read-sm"><i class="fa fa-exclamation-circle"></i>' . sprintf(__( '此处为隐藏的内容！', 'vmeng' )) . '</div>
			<div class="read-sm"><i class="fa fa-sign-in"></i>' . sprintf(__( '登录后才能查看！', 'vmeng' )) . '</div>
		</div>
		<div class="read-pl"><a href="'. wp_login_url( get_permalink() ).'" class="flatbtn" id="login-see" >'. sprintf(__( '登录', 'vmeng' )) . '</a></div>
		<div class="clear"></div>
	</div>'), $atts));
	if (is_user_logged_in()) {
		return do_shortcode( $content );
	} else {
		return $notice;
	}
}
add_shortcode('login', 'login_to_read');
// 加密内容
function secret($atts, $content=null){
extract(shortcode_atts(array('key'=>null), $atts));
if ( current_user_can('level_10') ) {
	return '<div class="secret-password"><i class="fa fa-check-square"></i>加密的内容：<br />'.do_shortcode( $content ).'</div>';
}
if(isset($_POST['secret_key']) && $_POST['secret_key']==$key){
	return '<div class="secret-password"><i class="fa fa-check-square"></i>加密的内容：<br />'.do_shortcode( $content ).'</div>';
	} else {
		return '
		<form class="post-password-form" action="'.get_permalink().'" method="post">
			<div class="post-secret"><i class="fa fa-exclamation-circle"></i>' . sprintf(__( '输入密码查看加密内容：', 'vmeng' )) . '</div>
			<p>
				<input id="pwbox" type="password" size="20" name="secret_key">
				<input type="submit" value="' . sprintf(__( '提交', 'vmeng' )) . '" name="Submit">
			</p>
		</form>	';
	}
}
add_shortcode('password', 'secret');
// img
function img($atts, $content=null) {
    $return = '<img src="';
    $return .= htmlspecialchars($content);
    $return .= '" alt="" width="100%" height="auto" />';
    return $return;
}
add_shortcode('img' , 'img' );
//  code
function code($atts, $content=null) {
    extract(shortcode_atts(array("lang"=>""),$atts));
    $content = htmlspecialchars($content);
    $return = ' <pre class="line-numbers"><code class="language-' . $lang . '">';
    $return .= ltrim($content, '\n');
    $return .= '</code></pre>';
    return $return;
}
// 图片alt
function image_alt($c) {
	global $post;
	$title = $post->post_title;
	$s = array('/src="(.+?.(jpg|bmp|png|jepg|gif))"/i' => 'src="$1" alt="'.$title.'"');
	foreach($s as $p => $r){
	$c = preg_replace($p,$r,$c);
	}
	return $c;
}
add_filter( 'the_content', 'image_alt' );
if (vm_get_option('lazy_e')) {
	add_filter ('the_content', 'lazyload');
	function lazyload($content) {
		$loadimg_url=get_template_directory_uri().'/img/blank.gif';
		if(!is_feed()||!is_robots) {
			$content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1class=\"lazyload\" data-src=\"\$2\" src=\"$loadimg_url\"\$3>\n",$content);
		}
		return $content;
	}
}
if (vm_get_option('lazy_a')) {
	add_filter ('get_avatar', 'lazyload_avatar');
	function lazyload_avatar($content) {
		$loadimg_url=get_template_directory_uri().'/img/load-avatar.gif';
		if(!is_admin()){
		    $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1class=\"lazyload\" data-src=\"\$2\" src=\"$loadimg_url\"\$3>\n",$content);
		}
		return $content;
	}
}
//登录自定义
function custom_login() {   
echo '<link rel="stylesheet" tyssspe="text/css" href="' . get_bloginfo('template_directory') . '/css/custom_login.css" />'; }   
add_action('login_head', 'custom_login');   
//点赞
add_action('wp_ajax_nopriv_thumbups', 'thumbups');    //校验未登录用户是否点赞
add_action('wp_ajax_thumbups', 'thumbups');    //校验登录用户是否点赞
function thumbups(){
global $wpdb,$post;
$id = $_POST["um_id"];
$action = $_POST["um_action"];
    if ( $action == 'thumbup'){
    $post_thumbup = get_post_meta($id,'like',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('like_cookie'.$id,$expire,'/',$domain,false);
        if (!$post_thumbup || !is_numeric($post_thumbup)) {
            update_post_meta($id, 'like', 1);
        }else{
            update_post_meta($id, 'like', ($post_thumbup + 1));
        } 
        echo '( '.get_post_meta($id,'like',true).' )'; 
    } 
die;
}
// 自动为文章内的标签添加内链
if (vm_get_option('tag_c')) {
    $match_num_from = 1;        //一篇文章中同一个标签少于几次不自动链接
    $match_num_to = vm_get_option('tag_n');      //一篇文章中同一个标签最多自动链接几次
    function tag_sort($a, $b){
        if ( $a->name == $b->name ) return 0;
        return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
    }
    function tag_link($content){
        global $match_num_from,$match_num_to;
            $posttags = get_the_tags();
            if ($posttags) {
                usort($posttags, "tag_sort");
                foreach($posttags as $tag) {
                    $link = get_tag_link($tag->term_id);
                    $keyword = $tag->name;
                    $cleankeyword = stripslashes($keyword);
                    $url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('查看含有[%s]标签的文章'))."\"";
                    $url .= ' target="_blank"';
                    $url .= ">".addcslashes($cleankeyword, '$')."</a>";
                    $limit = rand($match_num_from,$match_num_to);
                    $cleankeyword = preg_quote($cleankeyword,'\'');
                    $regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' ;
                    $content = preg_replace($regEx,$url,$content,$limit);
                }
            }
        return $content;
    }
    add_filter('the_content','tag_link',1);
}
//WP-PostViews启用提示
if ( !function_exists(  'the_views'  ) ) {
    function wp_postviews_click() {
	    echo '<div class="notice notice-success is-dismissible"><p>建议安装WP-PostViews(Vmeng兼容版)并开启AJAX即可使用文章计数</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button></div>';
    }
    add_action( 'admin_notices', 'wp_postviews_click' );
}
//WordPress 文章中英文数字间自动添加空格
if (vm_get_option('post_autospace')) {
    add_filter( 'the_content','vmeng_post_content_autospace' );
    function vmeng_post_content_autospace( $content ) {
        $content = preg_replace('/([\x{4e00}-\x{9fa5}]+)([A-Za-z0-9_]+)/u', '${1} ${2}', $content);
        $content = preg_replace('/([A-Za-z0-9_]+)([\x{4e00}-\x{9fa5}]+)/u', '${1} ${2}', $content);
        return $content;
    }
}
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src($img_src,$img,$siteurl){return get_bloginfo('template_directory').'/lib/OwO'.$img;}
function disable_emojis_tinymce($plugins){return array_diff($plugins,array('wpemoji'));}
function smilies_reset(){
    global $wpsmiliestrans,$wp_smiliessearch,$wp_version;
    if(!get_option('use_smilies')||$wp_version<4.2) return;
    $wpsmiliestrans = array(
    '@(暗地观察)' => '/alu/暗地观察.png',
    '@(便便)' => '/alu/便便.png',
    '@(不出所料)' => '/alu/不出所料.png',
    '@(不高兴)' => '/alu/不高兴.png',
    '@(不说话)' => '/alu/不说话.png',
    '@(抽烟)' => '/alu/抽烟.png',
    '@(呲牙)' => '/alu/呲牙.png',
    '@(大囧)' => '/alu/大囧.png',
    '@(得意)' => '/alu/得意.png',
    '@(愤怒)' => '/alu/愤怒.png',
    '@(尴尬)' => '/alu/尴尬.png',
    '@(高兴)' => '/alu/高兴.png',
    '@(鼓掌)' => '/alu/鼓掌.png',
    '@(观察)' => '/alu/观察.png',
    '@(害羞)' => '/alu/害羞.png',
    '@(汗)' => '/alu/汗.png',
    '@(黑线)' => '/alu/黑线.png',
    '@(欢呼)' => '/alu/欢呼.png',
    '@(击掌)' => '/alu/击掌.png',
    '@(惊喜)' => '/alu/惊喜.png',
    '@(看不见)' => '/alu/看不见.png',
    '@(看热闹)' => '/alu/看热闹.png',
    '@(抠鼻)' => '/alu/抠鼻.png',
    '@(口水)' => '/alu/口水.png',
    '@(哭泣)' => '/alu/哭泣.png',
    '@(狂汗)' => '/alu/狂汗.png',
    '@(蜡烛)' => '/alu/蜡烛.png',
    '@(脸红)' => '/alu/脸红.png',
    '@(内伤)' => '/alu/内伤.png',
    '@(喷水)' => '/alu/喷水.png',
    '@(喷血)' => '/alu/喷血.png',
    '@(期待)' => '/alu/期待.png',
    '@(亲亲)' => '/alu/亲亲.png',
    '@(傻笑)' => '/alu/傻笑.png',
    '@(扇耳光)' => '/alu/扇耳光.png',
    '@(深思)' => '/alu/深思.png',
    '@(锁眉)' => '/alu/锁眉.png',
    '@(投降)' => '/alu/投降.png',
    '@(吐)' => '/alu/吐.png',
    '@(吐舌)' => '/alu/吐舌.png',
    '@(吐血倒地)' => '/alu/吐血倒地.png',
    '@(无奈)' => '/alu/无奈.png',
    '@(无所谓)' => '/alu/无所谓.png',
    '@(无语)' => '/alu/无语.png',
    '@(喜极而泣)' => '/alu/喜极而泣.png',
    '@(献花)' => '/alu/献花.png',
    '@(献黄瓜)' => '/alu/献黄瓜.png',
    '@(想一想)' => '/alu/想一想.png',
    '@(小怒)' => '/alu/小怒.png',
    '@(小眼睛)' => '/alu/小眼睛.png',
    '@(邪恶)' => '/alu/邪恶.png',
    '@(咽气)' => '/alu/咽气.png',
    '@(阴暗)' => '/alu/阴暗.png',
    '@(赞一个)' => '/alu/赞一个.png',
    '@(长草)' => '/alu/长草.png',
    '@(中刀)' => '/alu/中刀.png',
    '@(中枪)' => '/alu/中枪.png',
    '@(中指)' => '/alu/中指.png',
    '@(肿包)' => '/alu/肿包.png',
    '@(皱眉)' => '/alu/皱眉.png',
    '@(装大款)' => '/alu/装大款.png',
    '@(坐等)' => '/alu/坐等.png',
    '@[啊]' => '/paopao/啊.png',
    '@[爱心]' => '/paopao/爱心.png',
    '@[鄙视]' => '/paopao/鄙视.png',
    '@[便便]' => '/paopao/便便.png',
    '@[不高兴]' => '/paopao/不高兴.png',
    '@[彩虹]' => '/paopao/彩虹.png',
    '@[茶杯]' => '/paopao/茶杯.png',
    '@[吃瓜]' => '/paopao/吃瓜.png',
    '@[吃翔]' => '/paopao/吃翔.png',
    '@[大拇指]' => '/paopao/大拇指.png',
    '@[蛋糕]' => '/paopao/蛋糕.png',
    '@[嘚瑟]' => '/paopao/嘚瑟.png',
    '@[灯泡]' => '/paopao/灯泡.png',
    '@[乖]' => '/paopao/乖.png',
    '@[哈哈]' => '/paopao/哈哈.png',
    '@[汗]' => '/paopao/汗.png',
    '@[呵呵]' => '/paopao/呵呵.png',
    '@[黑线]' => '/paopao/黑线.png',
    '@[红领巾]' => '/paopao/红领巾.png',
    '@[呼]' => '/paopao/呼.png',
    '@[花心]' => '/paopao/花心.png',
    '@[滑稽]' => '/paopao/滑稽.png',
    '@[惊恐]' => '/paopao/惊恐.png',
    '@[惊哭]' => '/paopao/惊哭.png',
    '@[惊讶]' => '/paopao/惊讶.png',
    '@[开心]' => '/paopao/开心.png',
    '@[酷]' => '/paopao/酷.png',
    '@[狂汗]' => '/paopao/狂汗.png',
    '@[蜡烛]' => '/paopao/蜡烛.png',
    '@[懒得理]' => '/paopao/懒得理.png',
    '@[泪]' => '/paopao/泪.png',
    '@[冷]' => '/paopao/冷.png',
    '@[礼物]' => '/paopao/礼物.png',
    '@[玫瑰]' => '/paopao/玫瑰.png',
    '@[勉强]' => '/paopao/勉强.png',
    '@[你懂的]' => '/paopao/你懂的.png',
    '@[怒]' => '/paopao/怒.png',
    '@[喷]' => '/paopao/喷.png',
    '@[钱]' => '/paopao/钱.png',
    '@[钱币]' => '/paopao/钱币.png',
    '@[弱]' => '/paopao/弱.png',
    '@[三道杠]' => '/paopao/三道杠.png',
    '@[沙发]' => '/paopao/沙发.png',
    '@[生气]' => '/paopao/生气.png',
    '@[胜利]' => '/paopao/胜利.png',
    '@[手纸]' => '/paopao/手纸.png',
    '@[睡觉]' => '/paopao/睡觉.png',
    '@[酸爽]' => '/paopao/酸爽.png',
    '@[太开心]' => '/paopao/太开心.png',
    '@[太阳]' => '/paopao/太阳.png',
    '@[吐]' => '/paopao/吐.png',
    '@[吐舌]' => '/paopao/吐舌.png',
    '@[挖鼻]' => '/paopao/挖鼻.png',
    '@[委屈]' => '/paopao/委屈.png',
    '@[捂嘴笑]' => '/paopao/捂嘴笑.png',
    '@[犀利]' => '/paopao/犀利.png',
    '@[香蕉]' => '/paopao/香蕉.png',
    '@[小乖]' => '/paopao/小乖.png',
    '@[小红脸]' => '/paopao/小红脸.png',
    '@[笑尿]' => '/paopao/笑尿.png',
    '@[笑眼]' => '/paopao/笑眼.png',
    '@[心碎]' => '/paopao/心碎.png',
    '@[星星月亮]' => '/paopao/星星月亮.png',
    '@[呀咩爹]' => '/paopao/呀咩爹.png',
    '@[药丸]' => '/paopao/药丸.png',
    '@[咦]' => '/paopao/咦.png',
    '@[疑问]' => '/paopao/疑问.png',
    '@[阴险]' => '/paopao/阴险.png',
    '@[音乐]' => '/paopao/音乐.png',
    '@[真棒]' => '/paopao/真棒.png',
    '@[nico]' => '/paopao/nico.png',
    '@[OK]' => '/paopao/OK.png',
    '@[what]' => '/paopao/what.png',
    '@[doge]' => '/paopao/doge.png',
    '@[原谅她]' => '/paopao/原谅她.png'
    );
}
smilies_reset();
//小工具
function Vmeng_posts_list_loop(){
?>
    <li <?php post_class( array( 'span12') ); ?>>
        <article class="panel">
            <div class="panel-header">
                <?php the_title( '<' . Vmeng_get_main_list_title_tag() . ' class="post-title"><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></' . Vmeng_get_main_list_title_tag() . '>' ); ?>
            </div>
        </article>
    </li>
<?php
}

/**
 * 边栏文章列表
 */
function Vmeng_sidebar_posts_list( $query_args ){
    $query = new WP_Query( $query_args );
    if( $query->have_posts() ):
        echo '<ul class="sidebar-posts-list">';
            while( $query->have_posts() ):
                $query->the_post();
                Vmeng_sidebar_posts_list_loop();
            endwhile;
            wp_reset_postdata();
        echo '</ul>';
    else:
?>
        <div class="empty-sidebar-posts-list">
            <p><?php _e( '这里什么都没有，你也许可以使用搜索功能找到你需要的内容：' ); ?></p>
            <?php get_search_form(); ?>
        </div>
<?php
    endif;
}


/**
 * 边栏文章列表样式
 */
function Vmeng_sidebar_posts_list_loop( ){
?>
    <li <?php post_class('thumbnail'); ?>>
        <?php echo vmeng_thumbnail(); ?>
        <div class="right-box">
            <?php the_title( '<h4 class="post-title"><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h4>' ); ?>
        </div>
    </li>
<?php
}

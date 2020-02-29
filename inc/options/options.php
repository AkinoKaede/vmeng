<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {
	$blogpath =  get_stylesheet_directory_uri() . '/img';
	
	// 将所有分类（categories）加入数组
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// 所有分类ID
	$categories = get_categories(); 
	$cats_id= '';
	foreach ($categories as $cat) {
	$cats_id .= '<li>'.$cat->cat_name.' [ '.$cat->cat_ID.' ]</li>';
	}
	
	
	// 将所有标签（tags）加入数组
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// 将所有页面（pages）加入数组
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = '选择页面:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	    // 首页设置

	$options[] = array(
		'name' => '首页设置',
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => '首页页脚链接',
		'desc' => '显示首页页脚链接',
		'id' => 'footer_link',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '可以输入链接分类ID，显示特定的链接在首页，留空则显示全部链接',
		'id' => 'link_f_cat',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '选择友情链接页面',
		'id' => 'link_url',
		'type' => 'select',
		'class' => 'mini',
		'options' => $options_pages
	);
	
		//幻灯设置

	$options[] = array(
		'name' => '幻灯设置',
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯显示篇数',
		'id' => 'slider_n',
		'std' => '0',
		'class' => 'mini',
		'type' => 'text'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '幻灯一',
		'desc' => '幻灯一图片',
		'id' => 'slider_img_1',
        "std" => "",
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯一链接',
		'id' => 'slider_link_1',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '是否blank[新标签打开]',
		'id' => 'slider_blank_1',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '幻灯二',
		'desc' => '幻灯二图片',
		'id' => 'slider_img_2',
        "std" => "",
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯二链接',
		'id' => 'slider_link_2',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '是否blank[新标签打开]',
		'id' => 'slider_blank_2',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '幻灯三',
		'desc' => '幻灯三图片',
		'id' => 'slider_img_3',
        "std" => "",
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯三链接',
		'id' => 'slider_link_3',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '是否blank[新标签打开]',
		'id' => 'slider_blank_3',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '幻灯四',
		'desc' => '幻灯四图片',
		'id' => 'slider_img_4',
        "std" => "",
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯四链接',
		'id' => 'slider_link_4',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '是否blank[新标签打开]',
		'id' => 'slider_blank_4',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '幻灯五',
		'desc' => '幻灯五图片',
		'id' => 'slider_img_5',
        "std" => "",
		'type' => 'upload'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '幻灯五链接',
		'id' => 'slider_link_5',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '是否blank[新标签打开]',
		'id' => 'slider_blank_5',
		'std' => '0',
		'type' => 'checkbox'
	);
	
		// 基本设置

	$options[] = array(
		'name' => '基本设置',
		'type' => 'heading'
	);
	
    $options[] = array(
        'name' => 'Gravatar 头像获取',
        'id' => 'gravatar_url',
        'std' => 'no',
        'type' => 'radio',
        'options' => array(
            'no' => '默认',
            'cn' => '从官方cn服务器获取',
            'ssl' => '从官方ssl获取',
			'loli' => '从Loli Networks镜像获取',
			'qiniu' => '从七牛镜像获取'
        )
    );
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '',
		'desc' => '自动为文章中的关键词添加链接',
		'id' => 'tag_c',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '链接数量',
		'id' => 'tag_n',
		'std' => '2',
		'class' => 'mini',
		'type' => 'text'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '',
		'desc' => '代码高亮显示',
		'id' => 'highlight',
		'std' => '1',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '安全性设置',
		'desc' => '禁用xmlrpc',
		'id' => 'xmlrpc_no',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '禁用REST API',
		'id' => 'restapi_no',
		'std' => '0',
		'type' => 'checkbox'
	);	
		
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => 'ServerChan',
		'desc' => '评论Server酱提醒',
		'id' => 'serverchan',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => 'SCKEY',
		'id' => 'serverchan_sckey',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
    $options[] = array(
        'name' => '打赏',
        'id' => 'rewards_s',
        'desc' => '开启',
        'std' => true,
        'type' => "checkbox"
	);
 
    $options[] = array(
        'name' => '打赏：Logo',
        'id' => 'rewards_logo_src',
        'desc' => '建议尺寸：140*32px',
        'std' => "$blogpath/rweard/rweard.png",
        'type' => 'upload'
	);

    $options[] = array(
        'name' =>  '打赏：宣传文案',
        'id' => 'rewards_slogan',
        'std' => '全年24小时无休要饭ing',
        'type' => 'text'
    );

    $options[] = array(
        'name' => '打赏：支付宝收款二维码',
        'id' => 'rewards_alipay',
        'desc' => '',
        'std' => "$blogpath/rweard/alipay.png",
        'type' => 'upload'
    );

    $options[] = array(
        'name' => '打赏：微信收款二维码',
        'id' => 'rewards_wechat',
        'desc' => '',
        'std' => "$blogpath/rweard/wechatpay.png",
        'type' => 'upload'
    );
 
    $options[] = array(
        'name' => '打赏：显示文字',
        'id' => 'rewards_text',
        'std' => '我要打赏',
        'type' => 'text'
    );
    $options[] = array(
        'name' => '打赏：底部标题',
        'id' => 'rewards_title',
        'std' => '快用软妹币践踏我的尊严吧',
        'type' => 'text'
    );

    $options[] = array(
        'name' => '点赞',
        'id' => 'thumbups_s',
        'desc' => '开启',
        'std' => true,
        'type' => "checkbox"
    );
 
    $options[] = array(
        'name' => '点赞：显示文字',
        'id' => 'thumbups_text',
        'std' => '喜欢',
        'type' => 'text'
     );
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '页面添加.html后缀（更改后需重新保存一下固定链接设置）',
		'id' => 'page_html',
		'std' => '0',
		'type' => 'checkbox'
	);	
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '社交信息',
		'desc' => '微信号',
		'id' => 'wechat_name',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => 'QQ',
		'id' => 'qq_url',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '新浪微博',
		'id' => 'weibo_url',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '腾讯微博',
		'id' => 'tqq_url',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => 'GitHub',
		'id' => 'github_url',
		'std' => '',
		'type' => 'text'
	);

	    // 高级设置

	$options[] = array(
		'name' => '高级设置',
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => 'InstantClick预加载(Pjax)',
		'id' => 'instantclick',
		'std' => '1',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '图片延迟加载',
		'desc' => '启用缩略图延迟加载',
		'id' => 'lazy_t',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '启用正文图片延迟加载',
		'id' => 'lazy_e',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '启用评论头像延迟加载',
		'id' => 'lazy_a',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '一言类型',
		'desc' => '',
		'id' => 'hitokoto_type',
		'std' => 'random',
		'type' => 'radio',
		'options' => array(
		'random' => '随机',
		'a' => 'Anime - 动画',
		'b' => 'Comic – 漫画',
		'c' => 'Game – 游戏',
		'd' => 'Novel – 小说',
		'e' => 'Myself – 原创',		
		'f' => 'Internet – 来自网络',
		'g' => 'Other – 其他'
	)
	);

	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '评论防垃圾(No Spam)',
		'desc' => '评论检查中文',
		'id' => 'refused_spam',
		'std' => '1',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '邮箱验证(小幻)',
		'id' => 'email_check',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '评论屏蔽关键词',
		'id' => 'spam_keywords',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '屏蔽长链接评论',
		'id' => 'spam_long',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '屏蔽昵称评论带链接的评论',
		'id' => 'spam_url',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '禁止冒充管理员留言',
		'id' => 'check_admin',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '管理员名称',
		'id' => 'admin_name',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '',
		'desc' => '管理员邮箱',
		'id' => 'admin_email',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
	    'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '站点维护模式',
		'id' => 'maintenance_mode',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
	    'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '外链图片自动本地化',
		'id' => 'save_image',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '',
		'desc' => '不显示分类链接中的"category"',
		'id' => 'no_category',
		'std' => '0',
		'type' => 'checkbox'
	);

	// 网站标志

	$options[] = array(
		'name' => '网站标志',
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => '自定义Favicon',
		'desc' => '上传favicon.ico，并通过FTP上传到网站根目录',
		'id' => 'favicon',
        "std" => "$blogpath/favicon.ico",
		'type' => 'upload'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '自定义IOS屏幕图标',
		'desc' => '上传苹果移动设备添加到主屏幕图标',
		'id' => 'apple_icon',
        "std" => "$blogpath/favicon.png",
		'type' => 'upload'
	);

	// SEO设置

	$options[] = array(
		'name' => 'SEO设置',
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '启用主题自带SEO功能，如使用其它SEO插件，请取消勾选',
		'id' => 'seo',
		'std' => '1',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => '自定义网站首页title',
		'desc' => '留空则不显示自定义title',
		'id' => 'home_title',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'name' => '自定义网站首页副标题',
		'desc' => '留空则不显示副标题',
		'id' => 'home_info',
		'std' => '',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '站点title连接符',
		'desc' => '修改站点title连接符号',
		'id' => 'connector',
		'std' => '|',
		'class' => 'mini',
		'type' => 'text'
	);
	
    $options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '首页显示站点副标题',
		'id' => 'blog_info',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '首页描述（Description）',
		'desc' => '',
		'id' => 'description',
		'std' => '一般不超过200个字符',
		'type' => 'textarea'
	);

	$options[] = array(
		'name' => '首页关键词（KeyWords）',
		'desc' => '',
		'id' => 'keyword',
		'std' => '一般不超过100个字符',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '流量统计代码',
		'desc' => '用于在页脚添加同步统计代码',
		'id' => 'tongji',
		'std' => '',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '将文章主动推送到百度',
		'desc' => '启用',
		'id' => 'baidu_submit',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '',
		'desc' => '输入百度主动推送token值',
		'id' => 'token_p',
		'class' => 'mini',
		'std' => '',
		'type' => 'text'
	);
	
	$options[] = array(
		'id' => 'clear'
	);
	
	$options[] = array(
		'name' => '',
		'desc' => '文章中英文数字间自动添加空格',
		'id' => 'post_autospace',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	// 定制CSS

	$options[] = array(
		'name' => '定制风格',
		'type' => 'heading'
	);

 
    $options[] = array(
		'name' => '自定义样式',
		'desc' => '例如输入：#navbar {background: #000000;} 将固定的导航背景改为黑色',
		'id' => 'custom_css',
        'std' => '',
		'type' => 'textarea'
    );

	return $options;
}
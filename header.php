<!DOCTYPE HTML>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<?php vmeng_seo();?>
    <link rel="Bookmark" href="<?php echo vm_get_option('favicon'); ?>">
    <link rel="icon" href="<?php echo vm_get_option('favicon'); ?>" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo vm_get_option('apple_icon'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url');?>">
    <?php wp_head();?>
    <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo get_template_directory_uri(); ?>/css/rewrite-bootstrap.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php if (is_singular()) {?>
    <link href="<?php echo get_template_directory_uri(); ?>/css/fancybox.css" rel="stylesheet" type="text/css" data-no-instant />
	<link href="<?php echo get_template_directory_uri(); ?>/lib/OwO/OwO.min.css" rel="stylesheet" type="text/css" data-no-instant />
	<?php if (vm_get_option('highlight')) {?>
	    <link href="<?php echo get_template_directory_uri(); ?>/css/prism.css" rel="stylesheet" type="text/css" data-no-instant />
	<?php }?>
<?php }?>
<div id="bar"></div>
    <header class="vm-header">
        <nav class="navbar navbar-default" data-spy="affix" data-offset-top="15">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#vmenu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                        <h1 class="vm-logo"><?php echo esc_attr(get_bloginfo('name', 'display')); ?></h1>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="vmenu">
                    <span class="vm-nav-search"><i class="fa fa-search"></i></span>
                    <?php wp_nav_menu(array(
    'theme_location' => 'vm_menu', //注册菜单的名称
    'menu_class' => 'nav navbar-nav navbar-right', //主菜单css类名
    'container' => false, //导航容器标签类型
    'fallback_cb' => 'wp_page_menu', //没有设置导航的回调函数
    'walker' => new vmeng_Nav_Walker,
));?>
                    <div class="searchbar">
                        <form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-group vm-form-search">
                                <input type="search" value="<?php the_search_query();?>" name="s" id="s" class="form-control vm-input-search" placeholder="<?php _e('善于搜索...', 'vmeng')?>" required />
                                    <span class="input-group-btn">
                                        <a class="btn vm-btn-search" id="searchsubmit" href="/?s=" ><i class="fa fa-search" aria-hidden="true"></i></a>
                                    </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
<div class="container vm-container">



<?php get_header();?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <section class="error-404 not-found">
                <div class="error-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/404.jpg">
                </div>
                <div class="err-button back">
                    <a id="golast" href=javascript:history.go(-1);>返回上一页</a>
                    <a id="gohome" href="<?php bloginfo('url');?>">返回到主页</a>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer();?>
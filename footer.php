</div>
    <footer class="vm-footer">
    <div class="vm-footer-info">
            <ul class="vm-footer-menu">
                <li><a class="vm-a"><i class="fa fa-weixin" rel="nofollow"></i> <?php echo vm_get_option('wechat_name'); ?></a>
                </li>
				<li><a class="vm-a" target="_blank" href="<?php echo vm_get_option('qq_url'); ?>" rel="nofollow"><i class="fa fa-qq"></i></a>
                </li>
                <li><a class="vm-a" target="_blank" href="<?php echo vm_get_option('weibo_url'); ?>" rel="nofollow"><i class="fa fa-weibo"></i></a>
                </li>
                <li><a class="vm-a" target="_blank" href="<?php echo vm_get_option('tqq_url'); ?>" rel="nofollow"><i class="fa fa-tencent-weibo"></i></a>
                </li>
                <li><a class="vm-a" target="_blank" href="<?php echo vm_get_option('github_url'); ?>" rel="nofollow"><i class="fa fa-github"></i></a>
                </li>
            </ul>
        </div>

        <div class="vm-footer-copyright">
		<div id="hitokoto">
        <span id="hitokoto_p">玩命加载中…</span>
        <a href="javascript:;" title="不喜欢?" id="refresh">
            <img class="refresh" src="<?php echo get_template_directory_uri(); ?>/img/refresh.png" alt="">
        </a>
    </div>
            <div> Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name');?><?php echo '  '; ?><?php echo get_option('zh_cn_l10n_icp_num'); ?>
            </div>
            Theme <a class="vm-a" target="_blank" href="https://github.com/AkinoMaple/vmeng" rel="nofollow">Vmeng</a> by &bull; <a class="vm-a" target="_blank" href="https://iknet.top" rel="nofollow">秋のかえで</a> &amp; <a class="vm-a" target="_blank" href="https://www.wang233.com" rel="nofollow">wang233</a>
        </div>
    </footer>
	<a href="#" class="cd-top"></a>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.lazyload.js" ></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/theia-sticky-sidebar.js"></script>
    <?php if (is_singular()) {?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/lib/OwO/OwO.min.js" data-no-instant></script>
    <?php }?>
    <?php if (is_home() && vm_get_option('slider_n') !== '0') {?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/responsiveslides.min.js" data-no-instant></script>
    <?php }?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js" async='async'></script>
	<?php if (is_singular()) {?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/fancybox.js" data-no-instant></script>
    <?php if (vm_get_option('highlight')) {?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/prism.js" async='async' data-no-instant></script>
	<?php
}}?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-ias.min.js"></script>
<?php wp_footer();?>
	<?php if (vm_get_option('instantclick')) {?>
        <script src="<?php echo get_template_directory_uri(); ?>/js/instantclick.min.js" data-instant-track></script>
        <script data-instant-track>
        InstantClick.on('change', function(isInitialLoad) {
            if (isInitialLoad === false) {
                if (typeof MathJax !== 'undefined') // support MathJax
                    MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
                if (typeof prettyPrint !== 'undefined') // support google code prettify
                    prettyPrint();
                if (typeof _hmt !== 'undefined')  // support Baidu Tongji
                    _hmt.push(['_trackPageview', location.pathname + location.search]);
                if (typeof ga !== 'undefined')  // support google analytics
                    ga('send', 'pageview', location.pathname + location.search);
                if (typeof Prism !== 'undefined') {// support Prism
                     var pres = document.getElementsByTagName('pre');
                    for (var i = 0; i < pres.length; i++){
                        if (pres[i].getElementsByTagName('code').length > 0)
                            pres[i].className  = 'line-numbers';}
                            Prism.highlightAll(true,null);
                    }
	            if (typeof fancybox !== 'undefined') // support Fancybox
	                fancybox.showActivity();
        }});
        InstantClick.init();
    </script>
    <?php }?>

</body>

</html>

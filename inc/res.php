<?php
add_action('wp_footer', 'ajax_comment_script');
  function ajax_comment_script() {
	  if ( is_singular() ) {
    	$ajaxcomment = json_encode(array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
        ));  
		echo '<script type=\'text/javascript\' data-no-instant>',"\n",' var ajaxcomment = ',$ajaxcomment,';',"\n",'</script>',"\n";
    	echo '<script type="text/javascript" src="',get_template_directory_uri(),'/js/ajax-comment.js" data-no-instant></script>',"\n";
  }else{
		  return;
	  }
}
add_action('wp_footer', 'ias_script');
  function ias_script() {
	    if (is_home() || is_archive() || is_search()) {
            echo "<script type=\"text/javascript\" data-no-instant>
     var ias = $.ias({
	    container: \".site-main\",
     	item: \".thumbnail\",
    	pagination: \".pager\",
    	next: \".next>a\",
    });
    ias.extension(new IASTriggerExtension({
	   text: '<i class=\"fa fa-chevron-circle-down\"></i>更多',
    	offset: 3,
    }));
    ias.extension(new IASSpinnerExtension());
    ias.extension(new IASNoneLeftExtension({
	    text: '已是最后',
    }));
    ias.on('rendered', function(items) {
        $(function() {
            Vmeng.IL(); // Lazyload
            });
    })
    </script>\n";
		}else{
			return;
		}
  }
add_action('wp_footer', 'rewards_script');
  function rewards_script() {
	  if( (is_single() && vm_get_option('rewards_s')) && ( vm_get_option('rewards_alipay') || vm_get_option('rewards_wechat') ) ){
		  echo "<div class=\"rewards-popover-mask\" data-event=\"rewards-close\"></div>
    <div class=\"rewards-popover\">
        <div class=\"rewards-popover-logo\">
        <img style=\"height:100%\" src=\"",vm_get_option('rewards_logo_src'),"\">
        </div>
        <p>", vm_get_option('rewards_slogan') ,"</p>";
           if( vm_get_option('rewards_alipay') ){ 
            echo '<div class="rewards-popover-item">
            <img src="', vm_get_option('rewards_alipay') ,'">
            <h4>支付宝打赏</h4>
            </div>';
         } 
        if( vm_get_option('rewards_wechat') ){ 
           echo '<div class="rewards-popover-item">
            <img src="',vm_get_option('rewards_wechat'),'">
            <h4>微信打赏</h4>
            </div>';
            } 
       echo "<h3>", vm_get_option('rewards_title') ,"</h3>
        <span class=\"rewards-popover-close\" data-event=\"rewards-close\"><i class=\"fa fa-close\"></i></span>
    </div>

<script type=\"text/javascript\" data-no-instant>
$('[data-event=\"rewards-open\"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeIn()
})

$('[data-event=\"rewards-close\"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeOut()
})
</script>

<script type=\"text/javascript\" data-no-instant>
$.fn.postLike = function() {
    if ($(this).hasClass('done')) {
        alert(\"你已经赞过这篇文章了，再看看其他文章吧~~~\");
    } else {
        $(this).addClass('done');
        var id = $(this).data(\"id\"),
        action = $(this).data('action'),
        rateHolder = $(this).children('.count');
        var ajax_data = {
            action: \"thumbups\",
            um_id: id,
            um_action: action
        };
    $.post(\"", admin_url( 'admin-ajax.php' ),"\", ajax_data,
        function(data) {
            $(rateHolder).html(data);
        }
    );
    return false;
    }
};
$(document).on(\"click\", \".favorite\",
    function() {
        $(this).postLike();
    }
);
</script>\n";
	  }else{
		  return;
	  }
  }
?>
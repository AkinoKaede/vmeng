<?php if ( is_front_page()){ ?>
<div class="links-box">
	<div id="links">
			<?php wp_list_bookmarks('title_li=&before=<ul class="lx7"><li class="link-f link-name  fadeInUp" data-wow-delay="0.3s">&after=</li></ul>&categorize=0&show_images=0&orderby=rating&order=DESC&category='.vm_get_option('link_f_cat')); ?>	    
				<?php if ( vm_get_option('link_url') !== '' ) { ?><ul class="lx7"><li class="link-f fadeInUp" data-wow-delay="0.3s"style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;"><a href="<?php echo get_permalink( vm_get_option('link_url') ); ?>" target="_blank" title="全部链接">更多伙伴</a></li></ul><?php } ?>
		<div class="clear"></div>
	</div>
</div>
<?php } ?>
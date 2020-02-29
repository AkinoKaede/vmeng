<?php get_header(); ?>
        <div class="row">
            <div class="col-sm-12 col-md-9">
				<?php
				$slider_n = vm_get_option('slider_n');
				if ($slider_n !==0 && $slider_n > 0) { ?>
				<div id="slides" class="slides">
			    	<ul id="slides" class="rslides">
		 <?php for ($n = 1; $n <= $slider_n; $n++) { 
					?>				  
                   <li>
					   <?php if(vm_get_option('slider_link_'.$n) !== '' ) { ?>
					        <a  href="<?php echo vm_get_option('slider_link_'.$n); ?>" <?php if(vm_get_option('slider_blank_'.$n)) { ?>target="_blank"<?php } ?>>
					   <?php } ?>
					   <img src="<?php echo vm_get_option('slider_img_'.$n); ?>" alt="slides">
					   <?php if(vm_get_option('slider_link_'.$n) !== '' ) { ?>
					       </a>
					   <?php } ?>
				  </li>
			   <?php } ?>
				    	</ul>
					</div>
              <?php } ?>
				<main id="main" class="site-main" role="main">
                <?php if(have_posts()): ?>
                <?php while(have_posts()):the_post(); ?>				
                <article id="post-<?php the_ID(); ?>" class="thumbnail">
                    <figure class="vm-pagelist-img">
                         <?php vmeng_thumbnail(); ?>
                    </figure>
                    <div class="caption">
                        <h2 class="vm-page-title"><a href="<?php the_permalink(); ?>"><?php if (is_sticky()) { ?><span class="sticky-icon">置顶</span><?php } ?><?php echo get_the_title(); ?></a></h2>
                        <p class="vm-author-info">
                             <time><i class="fa fa-clock-o"></i> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></time> &bull; 
                            <span><i class="fa fa-user-o"></i> <?php echo get_the_author_posts_link(); ?></span> &bull; 
							 <span><i class="fa fa-list-alt"></i> <?php the_category(' | ','single',''); ?></span> &bull; 
                            <span><?php comments_popup_link( '<i class="fa fa-comment-o"></i> 快来吐槽','<i class="fa fa-comment-o"></i> 1条评论','<i class="fa fa-comment-o"></i> %条评论');?></span> 
							<?php if ( function_exists(  'the_views'  ) ) { ?>
							&bull;<span><i class="fa fa-eye"></i> <?php the_views(); ?></span>
							<?php } ?>	
                        </p>
                        <p class="hidden-xs">
                            <?php echo esc_attr(get_the_excerpt()); ?>
                        </p>
                        <p class="clearfix">
                            <a class="hidden-xs pull-right vm-more-link" href="<?php the_permalink(); ?>" role="button">继续阅读 &raquo;</a>
                            <span class="vm-tags">
                                <?php the_tags('',' ',''); ?>
                            </span>
                        </p>
                    </div>
                </article>
                <?php endwhile; ?>
                <?php endif;?>
				</main>
                <nav>
                  <ul class="pager">
                    <li class="previous">
                       <?php previous_posts_link(__('<i class="fa fa-angle-left"></i> Previous','vmeng')) ?>
                    </li>
                    <li class="next">
                       <?php next_posts_link(__('Next <i class="fa fa-angle-right"></i>','vmeng')) ?>
                    </li>
                  </ul>
                </nav>
            </div>
            <?php get_sidebar(); ?>
        </div>
		<?php if ( is_home() && vm_get_option('footer_link')){
    get_template_part( 'inc/footer-links' ); 
	            } ?>
<?php get_footer(); ?>
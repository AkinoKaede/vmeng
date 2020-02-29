<?php get_header(); ?>
        <div class="row">
            <div class="col-sm-12 col-md-9">
				<div class="post">
               <div class="well well-sm text-center">
                  <?php
    	/* 查询第一个文章，这样我们就知道整个页面的作者是谁。
    	 * 在下面我们使用 rewind_posts() 重置了一下，这样一会儿我们才能正确运行循环。
    	 */
    	the_post();
    ?>
    <?php
    	if ( is_day() ) :
    		printf( __( '日期归档: %s', 'vmeng' ), '<span>' . get_the_date() . '</span>' );
    	elseif ( is_month() ) :
    		printf( __( '按月归档: %s', 'vmeng' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'vmeng' ) ) . '</span>' );
    	elseif ( is_year() ) :
    		printf( __( '按年归档: %s', 'vmeng' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'vmeng' ) ) . '</span>' );
    	elseif ( is_category() ) :
    	  printf( __( '文章分类: %s', 'vmeng' ), '<span>' . single_cat_title( '', false ) . '</span>' );
    	elseif ( is_tag() ) :
    	  printf( __( '标签归档: %s', 'vmeng' ), '<span>' . single_tag_title( '', false ) . '</span>' );
    	elseif ( is_author() ) :
    	  printf( __( '作者归档： %s', 'vmeng' ), '<span>' . get_the_author() . '</span>' );
    	else :
    		_e( '归档', 'vmeng' );
    	endif;
    ?>
    <?php 
      /* 把循环恢复到开始，
       * 这样下面的循环才能正常运行。
       */
      rewind_posts(); 
    ?>
               </div>
					<main id="main" class="site-main" role="main">
                <?php if(have_posts()): ?>
                <?php while(have_posts()):the_post(); ?>
                <article id="post-<?php the_ID(); ?>" class="thumbnail">
                    <figure class="vm-pagelist-img">              
                         <?php vmeng_thumbnail(); ?>
			        </figure>
				<div class="caption">
                        <h2 class="vm-page-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
				</div>
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
<?php get_footer(); ?>
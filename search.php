<?php get_header(); ?>
        <div class="row">
            <div class="col-sm-12 col-md-9">
				<div class="post">
               <div class="well well-sm text-center">
                  搜索关键字：<?php the_search_query(); ?>
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
<?php get_footer(); ?>
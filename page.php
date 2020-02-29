<?php get_header(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-default">
                <?php if(have_posts()): ?>
                <?php while(have_posts()):the_post(); ?>
				<main id="main" class="post-main" role="main">
                <article id="post-<?php the_ID(); ?>" class="vm-blog">
                    <h1 class="vm-blog-title"><?php the_title(); ?></h1>
                    <p class="vm-author-info">
                        <time>
                            <i class="fa fa-clock-o"></i> <?php echo get_the_date( 'Y-m-d'); ?>
                        </time> &bull;
                        <span><i class="fa fa-user-o"></i> <?php echo get_the_author_posts_link(); ?></span> &bull;
                        <span><?php comments_popup_link( '<i class="fa fa-comment-o"></i> 0条评论','<i class="fa fa-comment-o"></i> 1条评论','<i class="fa fa-comment-o"></i> %条评论');?></span> 
							<?php if ( function_exists(  'the_views'  ) ) { ?>
							&bull;<span><i class="fa fa-eye"></i> <?php the_views(); ?></span>
							<?php } ?>	
                    </p>
                    <div class="vm-blog-content">
                        <?php the_content(); ?>
                    </div>
					<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span><i class="fa fa-angle-left"></i></span>', 'nextpagelink' => "")); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => '<span><i class="fa fa-angle-right"></i></span> ')); ?>
                    <span class="vm-tags">
                            <?php the_tags('',' ',''); ?>
                        </span>
                </article>
					</main>
                <?php endwhile; ?>
                <?php endif;?>
            </div>
			<?php comments_template(); ?>
        </div>
    </div>
<?php get_footer(); ?>
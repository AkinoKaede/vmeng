<?php
/*
Template Name: 归档页面
*/
?>
<?php get_header(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-default">
                <?php if(have_posts()): ?>
                <?php while(have_posts()):the_post(); ?>
				<main id="main" class="post-main" role="main">
                <article id="post-<?php the_ID(); ?>" class="vm-blog">
                    <h1 class="vm-blog-title"><?php the_title(); ?></h1>
                    <div class="vm-blog-content">
                        <?php vmeng_archives_list(); ?>
                    </div>
                    <span class="vm-tags">
                            <?php the_tags('',' ',''); ?>
                        </span>
                </article>
					</main>
                <?php endwhile; ?>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
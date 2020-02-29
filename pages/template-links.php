<?php

/**
  * Template Name: links
  */

get_header(); 
?>
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="panel panel-default">
            <?php if(have_posts()): ?>
                <?php while(have_posts()):the_post(); ?>
				<main id="main" class="post-main" role="main">
                <article id="post-<?php the_ID(); ?>" class="vm-blog">
                    <h1 class="vm-blog-title"><?php the_title(); ?></h1>
                    <div class="vm-blog-content">
                        <?php the_content(); ?>
                        <div class="linkpage">
                        <?php if( get_bookmarks() ) { ?>
                        <ul>
                        <?php
                        $bookmarks=get_bookmarks();
                        // Loop through each bookmark and print formatted output
                        foreach ( $bookmarks as $bookmark ) {
                           printf( '<li><a href="%s" target="_blank"><img src="%s"><h4>%s</h4><p>%s</p></a></li>', $bookmark->link_url, $bookmark->link_image ? $bookmark->link_image : get_stylesheet_directory_uri() . '/img/links.jpg', $bookmark->link_name, $bookmark->link_description ? $bookmark->link_description : '这家伙很懒，什么也没有留下……' );
                        }
                        ?>
                        </ul>
                        </div>
                        <?php } ?>
                    </div>
					<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span><i class="fa fa-angle-left"></i></span>', 'nextpagelink' => "")); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => '<span><i class="fa fa-angle-right"></i></span> ')); ?>
                </article>
					</main>
                <?php endwhile; ?>
                <?php endif;?>
            </div>
			<?php comments_template(); ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>
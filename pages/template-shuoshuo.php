<?php
/*
    Template Name: 说说
 */
get_header(); ?> 
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/shuoshuo.css" type="text/css" media="screen" data-no-instant/>

    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="panel panel-default">
				<main id="main" class="post-main" role="main">
                <article id="post-<?php the_ID(); ?>" class="vm-blog">
            <div id="shuoshuo_content">         
                <ul class="cbp_tmtimeline">
                    <?php query_posts("post_type=shuoshuo&post_status=publish&posts_per_page=10");if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <li> <span class="shuoshuo_author_img"><?php echo get_avatar( get_the_author_email(), '48' );?></span>
                        <a class="cbp_tmlabel" href="javascript:void(0)">
                            <p></p>
                            <p><?php the_content(); ?></p>
                            <p></p>
                            <p class="shuoshuo_time"><i class="fa fa-clock-o"></i>
                                <?php the_time('Y年n月j日G:i'); ?>
                            </p>
                        </a>
                        <?php endwhile;endif; ?>
                    </li>
                </ul>
				 	<?php wp_link_pages(array('before' => '<div class="page-links">', 'after' => '', 'next_or_number' => 'next', 'previouspagelink' => '<span><i class="fa fa-angle-left"></i></span>', 'nextpagelink' => "")); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'number', 'link_before' =>'<span>', 'link_after'=>'</span>')); ?>
			        <?php wp_link_pages(array('before' => '', 'after' => '</div>', 'next_or_number' => 'next', 'previouspagelink' => '', 'nextpagelink' => '<span><i class="fa fa-angle-right"></i></span> ')); ?>
	        </div>
				</article>
          </main>
		</div>
			</div>
                <?php get_sidebar(); ?>
    </div>
    <script type="text/javascript" data-no-instant>
        $(function () {
            var oldClass = "";
            var Obj = "";
            $(".cbp_tmtimeline li").hover(function () {
                Obj = $(this).children(".shuoshuo_author_img");
                Obj = Obj.children("img");
                oldClass = Obj.attr("class");
                var newClass = oldClass + " zhuan";
                Obj.attr("class", newClass);
            }, function () {
                Obj.attr("class", oldClass);
            })
        })
    </script>
    <?php get_footer();?>
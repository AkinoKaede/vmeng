<div class="vm-copyright">
	<?php $copy = get_post_meta($post->ID, 'copyright', true); ?>
			<?php if ( get_post_meta($post->ID, 'from', true) ) : ?>
				<?php $original = get_post_meta($post->ID, 'from', true); ?>
	                 文章转载自：
					    <?php if ( get_post_meta($post->ID, 'copyright', true) ) : ?>
				           <strong><a href="<?php echo $copy ?>" rel="nofollow" target="_blank"><?php echo $original ?></a></strong>，
			            <?php else: ?>
				           <?php echo $original ?>，
			            <?php endif; ?>
	                    <?php _e( '于', 'vmeng' ); ?><?php time_ago( $time_type ='posts' ); ?>，<?php _e( '由', 'vmeng' ); ?> <strong><?php the_author_posts_link(); ?></strong> <?php _e( '整理发表', 'vmeng' ); ?>。
	           <?php else: ?>
	                原创文章  <?php _e( '于', 'vmeng' ); ?><?php time_ago( $time_type ='posts' ); ?>，<?php _e( '由', 'vmeng' ); ?> <strong><?php the_author_posts_link(); ?></strong> <?php _e( '发表', 'vmeng' ); ?>。<br>
                    转载请注明：文章转载自：<?php bloginfo( 'name'); ?>（ <a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>）
	           <?php endif; ?>
</div>
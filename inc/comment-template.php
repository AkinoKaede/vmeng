<?php
//自定义评论列表模板 - 移植Simple
function vmeng_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $add_below = 'div-comment';
    ?>
   <li class="comment" id="li-comment-<?php comment_ID();?>" <?php if ($depth > 3) {?>style="margin-left: -60px;"<?php }?>>
   <div id="div-comment-<?php comment_ID();?>">
   		<div class="media">
   			<div class="media-left">
        		<?php if (function_exists('get_avatar') && get_option('show_avatars')) {echo get_avatar($comment, 48);}?>
   			</div>
   			<div class="media-body">
   				<?php printf(__('<p class="author_name">%s</p>'), commentauthor());?>
		        <?php if ($comment->comment_approved == '0'): ?>
		            <em>评论等待审核...</em><br />
				<?php endif;?>
				<?php comment_text();?>
   			</div>
   		</div>
   		<div class="comment-metadata">
   			<span class="comment-pub-time">
   				<?php echo get_comment_time('Y-m-d H:i'); ?>
   			</span>
   			<span class="comment-btn-reply">
 				 <?php comment_reply_link(array_merge($args, array('reply_text' => '<i class="fa fa-reply"></i>回复', 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
   			</span>
   		</div>
	</div>
<?php
}
?>
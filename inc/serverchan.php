<?php
/*
  ServerChan评论提醒-狂放
  https://www.iknet.top/550.html
 */
//评论微信推送  
function kfang_serverchan_send($comment_id)  
{
$comment = get_comment($comment_id);    
$text = ($comment->comment_author).'在'.get_option("blogname").'的文章《'.get_the_title($comment->comment_post_ID).'》 上评论';
$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
$url=$comment->comment_author_url;
if ($url != ''){
$desp = '昵称:'.($comment->comment_author).'  
'.'邮箱:'.($comment->comment_author_email).'  
'.'链接:'.'['.($comment->comment_author_url).']('.($comment->comment_author_url).')'.'  
'.'IP:'.($comment->comment_author_IP).'  
'.'文章:'.'['.get_the_title($comment->comment_post_ID).']('.get_page_link($comment->comment_post_ID).')'.'  
'.'内容:'.($comment->comment_content);  
}else{
$desp = '昵称:'.($comment->comment_author).'  
'.'邮箱:'.($comment->comment_author_email).'  
'.'IP:'.($comment->comment_author_IP).'  
'.'文章:'.'['.get_the_title($comment->comment_post_ID).']('.get_page_link($comment->comment_post_ID).')'.'  
'.'内容:'.'['.($comment->comment_content).']('.htmlspecialchars(get_comment_link($parent_id)).')';  
}
$key = vm_get_option('serverchan_sckey');
$postdata = http_build_query(  
array(  
'text' => $text,  
'desp' => $desp  
)  
);  
   
$opts = array('http' =>  
array(  
'method' => 'POST',  
'header' => 'Content-type: application/x-www-form-urlencoded',  
'content' => $postdata  
)  
);  
$context = stream_context_create($opts);  
return $result = file_get_contents('https://sc.ftqq.com/'.$key.'.send', false, $context);  
}  
add_action('comment_post', 'kfang_serverchan_send', 19, 2);  
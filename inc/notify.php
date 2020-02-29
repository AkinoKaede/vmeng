<?php
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
    $message = '<table cellpadding="0" cellspacing="0" class="email-container" align="center" width="550" style="font-size: 15px; font-weight: normal; line-height: 22px; text-align: left; border: 1px solid rgb(177, 213, 245); width: 550px;"><tbody><tr><td><table cellpadding="0" cellspacing="0" class="padding" width="100%" style="padding-left: 40px; padding-right: 40px; padding-top: 30px; padding-bottom: 35px;"><tbody><tr class="logo"><td align="center"><table class="logo" style="margin-bottom: 10px;"><tbody><tr><td><span style="font-size: 22px;padding: 10px 20px;margin-bottom: 5%;color: #65c5ff;border: 1px solid;box-shadow: 0 5px 20px -10px;border-radius: 2px;display: inline-block;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #65c5ff;">' . get_option("blogname") . '</a></span></td></tr></tbody></table></td></tr><tr class="content"><td><hr style="height: 1px;border: 0;width: 100%;background: #eee;margin: 15px 0;display: inline-block;"><p>Hi ' . trim(get_comment($parent_id)->comment_author) . '!<br>您发表在《' . get_the_title($comment->comment_post_ID) . '》上的评论有人给你回复啦:</p><p>你的评论:</p><p style="background: #eee;padding: 1em;text-indent: 2em;line-height: 30px;">' . nl2br(get_comment($parent_id)->comment_content) . '</p><p>' . trim($comment->comment_author) . ' 回复你说:</p><p style="background: #eee;padding: 1em;text-indent: 2em;line-height: 30px;">' . nl2br($comment->comment_content) . '</p></td></tr><tr><td align="center"><table cellpadding="12" border="0" style="" lucida="lucida" sans="sans" grande="grande" segoeui="segoeui" helvetica="helvetica" neue="neue" arial="arial" sans-serif="sans-serif" font-size:="font-size:" px="px" font-weight:="font-weight:" bold="bold" line-height:="line-height:" color:="color:" text-align:="text-align:" left="left"><tbody><tr><td style="text-align: center;"><a target="_blank" style="color: #fff;background: #65c5ff;box-shadow: 0 5px 20px -10px #44b0f1;border: 1px solid #44b0f1;width: 200px;font-size: 14px;padding: 10px 0;border-radius: 2px;margin: 10% 0 5%;text-align:center;display: inline-block;text-decoration: none;" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">Now Reply</a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table border="0" cellpadding="0" cellspacing="0" align="center" class="footer" style=" max-width: 550px; " lucida="lucida" sans="sans" grande="grande" segoeui="segoeui" helvetica="helvetica" neue="neue" arial="arial" sans-serif="sans-serif" font-size:="font-size:" px="px" line-height:="line-height:" color:="color:" text-align:="text-align:" left="left" padding:="padding:" font-weight:="font-weight:" normal="normal"><tbody><tr><td align="center" style="text-align: center; font-size: 12px; line-height: 18px; color: rgb(163, 163, 163); padding: 5px 0px;width:550px;"></td></tr><tr><td style="text-align: center; font-weight: normal; font-size: 12px; line-height: 18px; color: rgb(163, 163, 163); padding: 5px 0px;"><p>Please do not reply to this message , because it is automatically sent.</p><p>邮件发送于 '.date("Y年m月d日").' | © '.date("Y").' <a name="footer_copyright" href="' . get_option('home') . '" style="color:rgb(163, 163, 163);text-decoration: none;" target="_blank">' . get_option("blogname") . '</a></p></td></tr></tbody></table>';
    $from = "From: \"" . htmlspecialchars(get_option('blogname'),ENT_QUOTES) . "\" <$wp_email>";
    $headers = "$fromnContent-Type: text/html; charset=" . get_option('blog_charset') . "n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
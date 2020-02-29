<?php 
/* Template Name:随机推荐 */ 
?>
<?php $rand_post=get_posts('numberposts=1&orderby=rand'); ?>
<html>
<head>
<<span id="9_nwp" style="width: auto; height: auto; float: none;"><a id="9_nwl" href="http://cpro.baidu.com/cpro/ui/uijs.php?c=news&cf=1001&ch=0&di=128&fv=17&jk=213ae9ee57972c6&k=head&k0=head&kdi0=0&luki=5&n=10&p=baidu&q=06003100_cpr&rb=0&rs=1&seller_id=1&sid=c67279e59eae1302&ssp2=1&stid=0&t=tpclicked3_hc&tu=u1948625&u=http%3A%2F%2Fwuzhuti%2Ecn%2F2134%2Ehtml&urlid=0" target="_blank" mpid="9" style="text-decoration: none;"><span style="color:#0000ff;font-size:12px;width:auto;height:auto;float:none;">head</span></a></span>>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php foreach($rand_post as $post) : ?>
<meta http-equiv="refresh" content="2;url='<?php the_permalink();?>';">
<?php endforeach; ?>
<title>随机推荐中,请稍候...</title>
<style>
body{background:#000}.loading{-webkit-animation:fadein 2s;-moz-animation:fadein 2s;-o-animation:fadein 2s;animation:fadein 2s}@-moz-keyframes fadein{from{opacity:0}to{opacity:1}}@-webkit-keyframes fadein{from{opacity:0}to{opacity:1}}@-o-keyframes fadein{from{opacity:0}to{opacity:1}}@keyframes fadein{from{opacity:0}to{opacity:1}}.spinner-wrapper{position:absolute;top:0;left:0;z-index:300;height:100%;min-width:100%;min-height:100%;background:rgba(255,255,255,0.93)}.spinner-text{position:absolute;top:50%;left:50%;margin-left:-90px;margin-top: 2px;color:#BBB;letter-spacing:1px;font-weight:700;font-size:36px;font-family:Arial}.spinner{position:absolute;top:50%;left:50%;display:block;margin-left:-160px;width:1px;height:1px;border:25px solid rgba(100,100,100,0.2);-webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;border-left-color:transparent;border-right-color:transparent;-webkit-animation:spin 1.5s infinite;-moz-animation:spin 1.5s infinite;animation:spin 1.5s infinite}@-webkit-keyframes spin{0%,100%{-webkit-transform:rotate(0deg) scale(1)}50%{-webkit-transform:rotate(720deg) scale(0.6)}}@-moz-keyframes spin{0%,100%{-moz-transform:rotate(0deg) scale(1)}50%{-moz-transform:rotate(720deg) scale(0.6)}}@-o-keyframes spin{0%,100%{-o-transform:rotate(0deg) scale(1)}50%{-o-transform:rotate(720deg) scale(0.6)}}@keyframes spin{0%,100%{transform:rotate(0deg) scale(1)}50%{transform:rotate(720deg) scale(0.6)}}
</style>
</head>
<body>
<div class="loading">
  <div class="spinner-wrapper">
    <span class="spinner-text">随机推荐，推荐中...</span>
    <span class="spinner"></span>
  </div>
</div>
</body>
</html>
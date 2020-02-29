<?php 
// http://zhangge.net/

$t_url = preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]);
if(!empty($t_url)) {
	preg_match('/(http|https):\/\//',$t_url,$matches);
	if($matches){
		$url=$t_url;
		$title='页面加载中,请稍候...';
	} else {
		$title='加载中...';
		echo "<script>setTimeout(function(){window.opener=null;window.close();}, 3000);</script>";
	}
}
//防止 WordPress 遭受恶意 URL 请求。From：http://blog.wpjam.com/m/block-bad-queries/
if(strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") ||
	strpos($_SERVER['REQUEST_URI'], "base64")) {
		@header("HTTP/1.1 414 Request-URI Too Long");
		@header("Status: 414 Request-URI Too Long");
		@header("Connection: Close");
		@exit;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="1;url='<?php echo $url;?>';">
<meta name="robots" content="noindex, nofollow" />  
<title><?php echo $title;?></title>
<!--加载效果代码来自Emlog-->
<style>
#loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}
#loader {
    display: block;
    position: relative;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #3498db;
    -webkit-animation: spin 2s linear infinite;
    /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 2s linear infinite;
    /* Chrome, Firefox 16+, IE 10+, Opera */
    z-index: 1001;
}
#loader:before {
    content: "";
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #e74c3c;
    -webkit-animation: spin 3s linear infinite;
    /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 3s linear infinite;
    /* Chrome, Firefox 16+, IE 10+, Opera */
}
#loader:after {
    content: "";
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #f9c922;
    -webkit-animation: spin 1.5s linear infinite;
    /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 1.5s linear infinite;
    /* Chrome, Firefox 16+, IE 10+, Opera */
}
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        /* Chrome, Opera 15+, Safari 3.1+ */
        -ms-transform: rotate(0deg);
        /* IE 9 */
        transform: rotate(0deg);
        /* Firefox 16+, IE 10+, Opera */
    }
    100% {
        -webkit-transform: rotate(360deg);
        /* Chrome, Opera 15+, Safari 3.1+ */
        -ms-transform: rotate(360deg);
        /* IE 9 */
        transform: rotate(360deg);
        /* Firefox 16+, IE 10+, Opera */
    }
}
@keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        /* Chrome, Opera 15+, Safari 3.1+ */
        -ms-transform: rotate(0deg);
        /* IE 9 */
        transform: rotate(0deg);
        /* Firefox 16+, IE 10+, Opera */
    }
    100% {
        -webkit-transform: rotate(360deg);
        /* Chrome, Opera 15+, Safari 3.1+ */
        -ms-transform: rotate(360deg);
        /* IE 9 */
        transform: rotate(360deg);
        /* Firefox 16+, IE 10+, Opera */
    }
}
#loader-wrapper .loader-section {
    position: fixed;
    top: 0;
    width: 51%;
    height: 100%;
    background: #fff;
    z-index: 1000;
}
#loader-wrapper .loader-section.section-left {
    left: 0;
}
#loader-wrapper .loader-section.section-right {
    right: 0;
}
/* Loaded styles */
.loaded #loader-wrapper .loader-section.section-left {
    -webkit-transform: translateX(-100%);
    /* Chrome, Opera 15+, Safari 3.1+ */
    -ms-transform: translateX(-100%);
    /* IE 9 */
    transform: translateX(-100%);
    /* Firefox 16+, IE 10+, Opera */
    -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
    /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
    transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
    /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
}
.loaded #loader-wrapper .loader-section.section-right {
    -webkit-transform: translateX(100%);
    /* Chrome, Opera 15+, Safari 3.1+ */
    -ms-transform: translateX(100%);
    /* IE 9 */
    transform: translateX(100%);
    /* Firefox 16+, IE 10+, Opera */
    -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
    /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
    transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
    /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
}
.loaded #loader {
    opacity: 0;
    -webkit-transition: all 0.3s ease-out;
    /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
    transition: all 0.3s ease-out;
    /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
}
.loaded #loader-wrapper {
    visibility: hidden;
    -webkit-transform: translateY(-100%);
    /* Chrome, Opera 15+, Safari 3.1+ */
    -ms-transform: translateY(-100%);
    /* IE 9 */
    transform: translateY(-100%);
    /* Firefox 16+, IE 10+, Opera */
    -webkit-transition: all 0.3s 1s ease-out;
    /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
    transition: all 0.3s 1s ease-out;
    /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
}
</style>
</head>
<body>

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
</body>
</html>
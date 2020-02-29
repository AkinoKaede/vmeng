<?php
if (!vm_get_option('lazy_t')) {
function vmeng_thumbnail() {
	global $post;
	if ( get_post_meta($post->ID, 'thumbnail', true) ) {
		$image = get_post_meta($post->ID, 'thumbnail', true);
		echo '<a href="'.get_permalink().'"><img src=';
		echo $image;
		echo ' alt="'.$post->post_title .'" /></a>';
	} else {
		if ( has_post_thumbnail() ) {
			echo '<a href="'.get_permalink().'">';
			the_post_thumbnail('content', array('alt' => get_the_title()));
			echo '</a>';
		} else {
			$content = $post->post_content;
			preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
			$n = count($strResult[1]);
			if($n > 0){
				echo '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/timthumb.php?src='.$strResult[1][0].'&w=800&h=280&a=&zc=1" alt="'.$post->post_title .'" /></a>';
			} else { 
				$random = mt_rand(1, 10);
				echo '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/img/random/'. $random .'.jpg" alt="'.$post->post_title .'" /></a>';
			}
		}
	}
}
function vmeng_thumbnail_p() {
	global $post;
	if ( get_post_meta($post->ID, 'thumbnail', true) ) {
		$image = get_post_meta($post->ID, 'thumbnail', true);
		echo '<a href="'.get_permalink().'"><img src='.$image.' alt="'.$post->post_title .'" /></a>';
	} else {
		if ( has_post_thumbnail() ) {
			return '<a href="'.get_permalink().'">'.the_post_thumbnail('content', array('alt' => get_the_title())).'</a>';
		} else {
			$content = $post->post_content;
			preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
			$n = count($strResult[1]);
			if($n > 0){
				return '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/timthumb.php?src='.$strResult[1][0].'&w=800&h=280&a=&zc=1" alt="'.$post->post_title .'" /></a>';
			} else { 
				$random = mt_rand(1, 10);
				return '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/img/random/'. $random .'.jpg" alt="'.$post->post_title .'" /></a>';
			}
		}
	}
}
}else{
function vmeng_thumbnail() {
	global $post;
	if ( get_post_meta($post->ID, 'thumbnail', true) ) {
		$image = get_post_meta($post->ID, 'thumbnail', true);
		echo '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load.gif" data-src=';
		echo $image;
		echo ' alt="'.$post->post_title .'" /></a>';
	} else {
		if ( has_post_thumbnail() ) {
			echo '<a href="'.get_permalink().'">';
			the_post_thumbnail('content', array('alt' => get_the_title()));
			echo '</a>';
		} else {
			$content = $post->post_content;
			preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
			$n = count($strResult[1]);
			if($n > 0){
				echo '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load.gif" data-src="'.get_template_directory_uri().'/timthumb.php?src='.$strResult[1][0].'&w=800&h=280&a=&zc=1" alt="'.$post->post_title .'" /></a>';
			} else { 
				$random = mt_rand(1, 10);
				echo '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load.gif" data-src="'.get_template_directory_uri().'/img/random/'. $random .'.jpg" alt="'.$post->post_title .'" /></a>';
			}
		}
	}
}
function vmeng_thumbnail_p() {
	global $post;
	if ( get_post_meta($post->ID, 'thumbnail', true) ) {
		$image = get_post_meta($post->ID, 'thumbnail', true);
		return '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load-p.gif" data-src='.$image.' alt="'.$post->post_title .'" /></a>';
	} else {
		if ( has_post_thumbnail() ) {
			return '<a href="'.get_permalink().'">'.the_post_thumbnail('content', array('alt' => get_the_title())).'</a>';
		} else {
			$content = $post->post_content;
			preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
			$n = count($strResult[1]);
			if($n > 0){
				return '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load-p.gif" data-src="'.get_template_directory_uri().'/timthumb.php?src='.$strResult[1][0].'&w=800&h=280&a=&zc=1" alt="'.$post->post_title .'" /></a>';
			} else { 
				$random = mt_rand(1, 10);
				return '<a href="'.get_permalink().'"><img class="lazyload" src="' . get_template_directory_uri() . '/img/load-p.gif" data-src="'.get_template_directory_uri().'/img/random/'. $random .'.jpg" alt="'.$post->post_title .'" /></a>';
			}
		}
	}
}
}
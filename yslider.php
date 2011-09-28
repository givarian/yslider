<?php
/*
Plugin Name: YSlider
Plugin URI: http://www.micc.unifi.it/ferracani/blog/web-applications/yslider-wordpress-content-slider-plugin/
Description: Content slider Wordpress jQuery Plugin with carousel. You can instantiate the slider putting the [yslider] shortcode in pages or posts.
Version: 1.0
Author: Andrea Ferracani
Author URI: http://www.micc.unifi.it/ferracani/ 
License: GPL
*/
//require_once 'resizelib/ThumbLib.inc.php';
register_deactivation_hook( __FILE__, array( 'YSlider', 'on_deactivate' ) );


class YSlider {
	
	function YSlider() {
			
		//WordPress action hooks
		$this -> addHeadFiles();
		$this -> addCustomStyles();
		$this -> updateOptions();
		$this -> addMenuItem();
		
		$postids = get_option("yccf_postids");
		if ($postids) {
			$postids_array = explode(",", $postids);
			$areNumbers = $this -> checkIfIdsNumeric($postids_array);
		}
	
		$postrecent = get_option("yccf_postrecent");
		
		if ($postrecent == "on") {
			$initArray = array($this, "getRecentPosts");
		} else {
			($postids) ? $initArray = array($this, "getPosts") : $initArray = array($this, "getRecentPosts");
		}
		
		add_shortcode('yslider', $initArray);
	}
	
    function checkIfIdsNumeric($arr) {
		$areNumbers = false;
		foreach ($arr as $value) {
    		if (!is_numeric($value)) { 
				return false;
			} 
		}
		return true;
	}
	
	function on_deactivate() {
		//echo "deactivate";
		
		delete_option('yccf_posttitle');
		delete_option('yccf_postsubtitle');
		delete_option('yccf_postids');
		delete_option('yccf_postrecent');
		
		delete_option('yccf_postwidth'); 
		delete_option('yccf_postimgheight');  
		delete_option('yccf_postthumbheight'); 
		delete_option('yccf_postcontentheight');   
		delete_option('yccf_postcarouselheight');   
		delete_option('yccf_postslideby');
		delete_option('yccf_postspeed');
		delete_option('yccf_postinterval');
		delete_option('yccf_postdelay');
		delete_option('yccf_postcontinuous');
		delete_option('yccf_postautoplay');
		delete_option('yccf_postcss');
	}
	
	

	function addHeadFiles() {
		
	
		
		if (is_admin()) {
			
			wp_enqueue_style("admin", WP_PLUGIN_URL."/yslider/admin-style.css", false, 1);
			if (basename($_SERVER['SCRIPT_FILENAME']) == "admin.php") {
				wp_enqueue_script("reset.js", WP_PLUGIN_URL."/yslider/reset.js", array(), "1.0",0);
				$params = array(
 				'reset_url' =>  WP_PLUGIN_URL . "/yslider/reset.css",
				);
				wp_localize_script("reset.js", "reset_object", $params);
			}
		} else {
			wp_enqueue_style("base", WP_PLUGIN_URL."/yslider/themes/base.css", false, 1);
			wp_enqueue_style("theme", WP_PLUGIN_URL."/yslider/themes/default/theme.css", false, 1);
			//wp_enqueue_style("custom", WP_PLUGIN_URL."/yslider/themes/custom/theme.css", false, 1);
			
			wp_enqueue_script("jquery");
			wp_enqueue_script("jquery.accessible-news-slider", WP_PLUGIN_URL."/yslider/jquery.accessible-news-slider.js", array("jquery"), "2.0",0);
			wp_enqueue_script("css-fix", WP_PLUGIN_URL."/yslider/css-fix.js", array(), "1.0",0); 	
		}
	}
	
	function addStyles() {
		
		$postcss = get_option("yccf_postcss");
		//print_r($postcss);
	    echo '<style type="text/css">' . $postcss . '</style>';
	}
	
	function addCustomStyles() {
		add_action('wp_head', array($this, "addStyles"));
	}
	
	function updateOptions() {
			$posttitle = get_option('yccf_posttitle');
			$postsubtitle = get_option('yccf_postsubtitle');
			$postids = get_option('yccf_postids');
			$postrecent = get_option('yccf_postrecent');
	if (!$posttitle) {
				$posttitle = "Today news";
				update_option('yccf_posttitle', $posttitle);	
			}
			if (!$postsubtitle) {
				$postsubtitle = "2011 May 04";
				update_option('yccf_postsubtitle', $postsubtitle);	
			}  
			if (!$postids) {
				$postids = "1,2,3,4,5,6";
				update_option('yccf_postids', $postids);	
			}
			if (!$postrecent) {
                                //echo "entro in postrecent false e setto on: " . $postrecent;
				$postrecent = 'on';
				update_option('yccf_postrecent', $postrecent);
			}	
			
			
			$postwidth = get_option('yccf_postwidth'); 
			$postimgheight = get_option('yccf_postimgheight');  
			$postthumbheight = get_option('yccf_postthumbheight'); 
			$postcontentheight = get_option('yccf_postcontentheight');   
			$postcarouselheight = get_option('yccf_postcarouselheight');   
			$postslideby = get_option('yccf_postslideby');
			$postspeed = get_option('yccf_postspeed');
			$postinterval = get_option('yccf_postinterval');
			$postdelay = get_option('yccf_postdelay');
			$postcontinuous = get_option('yccf_postcontinuous');
			$postautoplay = get_option('yccf_postautoplay');
			$postcss = get_option('yccf_postcss');
			
			if (!$postwidth) {
				$postwidth = 428;
				update_option('yccf_postwidth', $postwidth);
			}
			if (!$postimgheight) {
				$postimgheight = 154;
				update_option('yccf_postimgheight', $postimgheight);
			}
			if (!$postthumbheight) {
				$postthumbheight = 30;
				update_option('yccf_postthumbheight', $postthumbheight);
			}
			if (!$postcontentheight) {
				$postcontentheight = 200;
				update_option('yccf_postcontentheight', $postcontentheight);
			}
			if (!$postcarouselheight) {
				$postcarouselheight = 90;
				update_option('yccf_postcarouselheight', $postcarouselheight);
			}
			if (!$postslideby) {
				$postslideby = 4;
				update_option('yccf_postslideby', $postslideby);
			}
			if (!$postspeed) {
				$postspeed = 'slow';
				update_option('yccf_postspeed', $postspeed);
			}
			if (!$postinterval) {
				$postinterval = 5000;
				update_option('yccf_postinterval', $postinterval);
			}
			if (!$postdelay) {
				$postdelay = 5000;
				update_option('yccf_postdelay', $postdelay);
			}
			if (!$postcontinuous) {
				$postcontinuos = "off";
				update_option('yccf_postcontinuous', $postcontinuous);
			}
			if (!$postautoplay) {
				$postautoplay = "off";
				update_option('yccf_postautoplay', $postautoplay);
			}
			if (!$postcontentheight) {
				$postcontentheight = false;
				update_option('yccf_postcontentheight', $postcontentheight);
			}
			
		if (!$postcss) {
				$postcss = 
				'
				/* Accessible News Slider : Theme Custom*/


				/* DEFAULT STYLES
				
					#slider-wrapper div.jqans-wrapper.default a > color of links in post text
				
				*/
				
				#slider-wrapper div.jqans-wrapper.default a {
					color:#363636 !important;
				}
				
				
				/* WRAPPER
				
					#slider-wrapper div.jqans-wrapper.default > color of the top, left, right border background color and text color (useful for changing color to subtitle) of the main wrapper
				
				*/
				
				#slider-wrapper div.jqans-wrapper.default {
					border-left: 1px solid #DBE1E6;
					border-right: 1px solid #DBE1E6;
					border-top: 1px solid #DBE1E6; 
					background: #FFF !important; 
					color:inherit; 
				}
				
				/* HEADLINE
				
				#slider-wrapper div.jqans-wrapper.default .jqans-headline strong > aspect of the widget title ("Today news")
				
				*/
				
				#slider-wrapper div.jqans-wrapper.default .jqans-headline strong { 
					text-transform:uppercase; 
					font-weight:bold; 
					color:#000;
				}
				
				/* POST CONTENT
				
				#slider-wrapper div.jqans-wrapper.default img > img dimensions
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content h1 > size of post title
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content h1 a, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:hover, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:active, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:visited > color of post title
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content p > color of post paragraph
				
				*/
				
				#slider-wrapper div.jqans-wrapper.default img {
					max-width:100%;
					margin:0;
					padding:0;
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content h1 {
					font-size: 138% !important; 
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content h1 a, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:hover, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:active, #slider-wrapper div.jqans-wrapper.default .jqans-content h1 a:visited {
					color: #16387C !important; 
					text-decoration:none; 
					background:transparent; 
					border:none;
				}
				
				
				#slider-wrapper div.jqans-wrapper.default .jqans-content p {
					color: #333 !important;
				}
				
				
				/* CAROUSEL
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories > list border bottom color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li > carousel item background color, gradient and border top color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected > carousel item selected background color, gradient and border top color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li img > carousel item image border and background, margin and padding
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected img > carusel item image border when selected
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li h3 > carousel item paragraph font size, color and line height
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected h3 > carousel item paragraph font size and color when selected
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories-selector li.selected div > carousel item arrow color

				#slider-wrapper div.jqans-wrapper.default .jqans-stories-selector ul, #slider-wrapper div.jqans-wrapper.default .jqans-stories-selector li > ensure transparency on selector background
				
				*/
				 
				#slider-wrapper div.jqans-wrapper.default .jqans-stories {
					border-bottom-color:#DBE1E6; 
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li {
					background-color:#FCFCFD;
					background-image:-moz-linear-gradient(center top , #E8EDF0, #FCFCFD);
					border-top-color:#A8B4BF;
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected {
					background-color:#59728B;
					background-image:-moz-linear-gradient(center top , #59728B, #2D4458);
					border-top-color:#59728B;	
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li img {
					border: 1px solid #C5CED7;
					background-color: #fff;
					margin:8px 0 0 0;
					padding:0;
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected img {
					border: 1px solid #000;
				}
				
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li h3 {
					font-size:12px !important;
					color:#59728B !important;
					line-height:14px !important; 
	                text-transform:none;
					background:transparent !important; 
					background-color:transparent !important; 
					background-image:none !important;
					margin:0;
					padding:0;
					text-shadow:none;
					font-weight:normal;
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories li.selected h3 {
					font-size:12px !important;
					color:#FFF !important;
				}
				
				
				#slider-wrapper div.jqans-wrapper.default .jqans-stories-selector li.selected div {
					border-right: 10px solid transparent;
					border-bottom: 10px solid #59728B;
					border-left: 10px solid transparent;
				}

				#slider-wrapper div.jqans-wrapper.default .jqans-stories-selector ul, #slider-wrapper div.jqans-wrapper.default .jqans-stories-selector li {
					background-color: transparent !important;
					background: transparent !important;
				}
				
				/* PAGINATION
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination > border bottom color and backround of the box containing pagination and slider controls
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-back a > previous button control color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-next a > next button control color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-back a span > fake element to make an arrow with pure css: it needs to be the same color as #slider-wrapper div.jqans-wrapper.default .jqans-pagination background color
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-next a span > fake element to make an arrow with pure css: it needs to be the same color as #slider-wrapper div.jqans-wrapper.default .jqans-pagination background color
				
				#slider-wrapper div.jqans-wrapper.default #control-play > play button color
				
				#slider-wrapper div.jqans-wrapper.default #pause-left, #slider-wrapper div.jqans-wrapper.default #pause-right > pause button color
				
				*/
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination {
					border-bottom-color:#DBE1E6;
					background-color:#F9FAFA;
				}
				
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-back a {
					border-right-color: #59728B;
				}
				
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-next a {
					border-left-color: #59728B;
				}
				
	
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-back a span {
					border-right-color: #F9FAFA;	/* it needs to be the same color as #slider-wrapper div.jqans-wrapper.default .jqans-pagination background color*/
				}
				
				#slider-wrapper div.jqans-wrapper.default .jqans-pagination-controls-next a span {
					border-left-color: #F9FAFA; /* it needs to be the same color as #slider-wrapper div.jqans-wrapper.default .jqans-pagination background color*/
				}
				
				
				#slider-wrapper div.jqans-wrapper.default #control-play  {
					border-left-color: #59728B; 
				}
				
				
				#slider-wrapper div.jqans-wrapper.default #pause-left, #slider-wrapper div.jqans-wrapper.default #pause-right {
					background: #59728B;
				}
				';
				update_option('yccf_postcss', $postcss);
			}
		
	}

	function addMenuItem() {
		add_action('admin_menu', array($this, "addMenu"));
		
	}
	
	function addMenu() {
		$appName = "YSlider";
		$appID = "ys-slider";
		add_menu_page($appName, $appName, 'administrator', $appID, array($this, "addScreenInfo"));
		add_submenu_page($appID, $appName . "admin area content", "Content", "administrator", "yslider-admin-area-content", array($this, "addScreenContent"));
		add_submenu_page($appID, $appName . "admin area style", "Style / Behaviours", "administrator", "yslider-admin-area-style-behaviours", array($this, "addScreenStyle"));
	}
	
	function addScreenInfo() {
		include('yslider-config.php');  
	}
	
	function addScreenContent() {
		include('content-config.php');  
	}

	function addScreenStyle() {
		include('style-behaviours-config.php');  
	}
	
	
	function initializePlugin($id, $title, $subtitle, $width, $slideby, $speed, $interval, $delay, $continuous, $autoplay, $contentHeight, $imgHeight, $carouselHeight) {
//echo "initializePlugin width: " . $width;
		($continuous == "on") ? ($continuous = "true") : ($continuous = "false");
		($autoplay == "on") ? ($autoplay = "true") : ($autoplay = "false");
		//echo "AUTOPLAY: " . $autoplay;
		//echo "CONTINUOUS: " . $continuous;
		include('yslider-setup.php');
	}
	
	
	function generateRandom() {
		srand((double)microtime()*1000000);  
		return rand(0,100000);
	}
	
	
	
	
	function getPosts($atts) {
		//echo "getPosts";
		global $wpdb;
		$prefix = $wpdb->prefix;
			
		extract(shortcode_atts( array(
		    'widgetid' => 'default_' . $this -> generateRandom(),
      		'postids' => get_option('yccf_postids'),
			'posttitle' => get_option('yccf_posttitle'),
			'postsubtitle' => get_option('yccf_postsubtitle'),
			'postwidth' => get_option('yccf_postwidth'),
			'postimgheight' => get_option('yccf_postimgheight'),
			'postthumbheight' => get_option('yccf_postthumbheight'),
			'postcontentheight' => get_option('yccf_postcontentheight'),
			'postcarouselheight' => get_option('yccf_postcarouselheight'),
			'postslideby' => get_option('yccf_postslideby'),
			'postspeed' => get_option('yccf_postspeed'),
			'postinterval' => get_option('yccf_postinterval'),
			'postdelay' => get_option('yccf_postdelay'),
			'postcontinuous' => get_option('yccf_postcontinuous'),
			'postrecent' => get_option('yccf_postrecent') == "on" ? "on" : "off",
			'postautoplay' => get_option('yccf_postautoplay'),
      	), $atts ) );
		
	
		
		
		
		if ($postrecent == "on") {
			$retval = $this -> getRecentPosts($atts);
			return $retval;
		}
		
		
		//initialize plugin parameters
		
		$this -> initializePlugin($widgetid, $posttitle, $postsubtitle, $postwidth, $postslideby, $postspeed, $postinterval, $postdelay, $postcontinuous, $postautoplay, $postcontentheight, $postimgheight, $postcarouselheight);
		
		$postids_array = explode(",", $postids);
		$postids_count = count($postids_array);

		$retval = '<ul id="newsslider_'. $widgetid .'">';
		
		for ($i=0; $i<$postids_count; $i++) {
			
			// check post status
			$queryStatus = "SELECT post_status FROM " . $prefix . "posts WHERE ID='" . $postids_array[$i] . "'";
			$post_status = $wpdb->get_var($queryStatus);
			$queryContent = "SELECT post_content FROM " . $prefix . "posts WHERE ID='" . $postids_array[$i] . "'";
			$post_content = $wpdb->get_var($queryContent);
			$queryExcerpt = "SELECT post_excerpt FROM " . $prefix . "posts WHERE ID='" . $postids_array[$i] . "'";
			$post_excerpt = $wpdb->get_var($queryExcerpt);
			
			if ($post_status == "publish" && preg_match('/\[yslider.*\]+/', $post_content) == 0) {
				//Get post title
				$queryTitle = "SELECT post_title FROM " . $prefix . "posts WHERE ID='" . $postids_array[$i] . "'";
				$post_title = $wpdb->get_var($queryTitle);
				$post_image = $this -> getPostImage($queryContent);
				$post_permalink = get_permalink($postids_array[$i]);
				
				$post_image = $this -> getPostImage($post_content);
				
				$imgWidth = (round((int) $postwidth)) - 8;
				$thumbWidth = (round((int) $postwidth / ((int) $postslideby)) - 18);
				
				//Build the HTML code
				$retval .= '<li><a href="' . $post_permalink . '"><img src="' .  WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $thumbWidth . '&amp;height=' . $postthumbheight . '&amp;siteurl=' . site_url() . '" alt="' . $post_title .'" longdesc="' . WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $imgWidth . '&amp;height=' . $postimgheight . '&amp;siteurl=' . site_url() . '"/></a><h3>';
				
				$retval .= $post_title;
				$retval .= '</h3><p>';
				$retval .= $post_excerpt ? $post_excerpt : $this -> teaser(strip_tags($post_content));
				$retval .= '</p></li>';
			}
			
		}
		$retval .= '</ul>';
		
		return $retval;
	}
	
	function getRecentPosts($atts) {
		//echo "getRecentPosts";

		global $wpdb;
		$prefix = $wpdb->prefix;
		
		extract(shortcode_atts( array(
		    'widgetid' => 'default_recent_' . $this -> generateRandom(),
			'posttitle' => get_option('yccf_posttitle'),
			'postsubtitle' => get_option('yccf_postsubtitle'),
			'postwidth' => get_option('yccf_postwidth'),
			'postimgheight' => get_option('yccf_postimgheight'),
			'postthumbheight' => get_option('yccf_postthumbheight'),
			'postcontentheight' => get_option('yccf_postcontentheight'),
			'postcarouselheight' => get_option('yccf_postcarouselheight'),
			'postslideby' => get_option('yccf_postslideby'),
			'postspeed' => get_option('yccf_postspeed'),
			'postinterval' => get_option('yccf_postinterval'),
			'postdelay' => get_option('yccf_postdelay'),
			'postcontinuous' => get_option('yccf_postcontinuous'),
			'postrecent' => get_option('yccf_postrecent') ? "on" : "off",
			'postautoplay' => get_option('yccf_postautoplay'),
      	), $atts ) );
		
		
		
		if ($postrecent == "off") {
			$retval = $this -> getPosts($atts);
			return $retval;
		}
		
		//initialize plugin parameters
		
		$this -> initializePlugin($widgetid, $posttitle, $postsubtitle, $postwidth, $postslideby, $postspeed, $postinterval, $postdelay, $postcontinuous, $postautoplay, $postcontentheight, $postimgheight, $postcarouselheight);
		
		$retval = '<ul id="newsslider_'. $widgetid .'">';
		$args = array( 'numberposts' => 8);

		$recent_posts = wp_get_recent_posts($args);
		
		
		foreach( $recent_posts as $post ){
			$queryStatus = "SELECT post_status FROM " . $prefix . "posts WHERE ID='" . $post["ID"] . "'";
			$post_status = $wpdb->get_var($queryStatus);
			$post_content = $post["post_content"];
			$queryExcerpt = "SELECT post_excerpt FROM " . $prefix . "posts WHERE ID='" . $post["ID"] . "'";
			$post_excerpt = $wpdb->get_var($queryExcerpt);
			
			if ($post_status == "publish" && preg_match('/\[.*\]/', $post_content) == 0) {
				$post_title = $post["post_title"];
				$post_image = $this -> getPostImage($post_content);
				$imgWidth = (round((int) $postwidth)) - 8;
				$thumbWidth = (round((int) $postwidth / ((int) $postslideby)) - 18);
				
				/*$retval .= '<li><a href="' . get_permalink($post["ID"]) . '"><img src="' .  WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $thumbWidth . '&amp;height=' . $postthumbheight . '" alt="' . $post_title .'" longdesc="' . WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $imgWidth . '&amp;height=' . $postimgheight . '"/></a><h3>';*/

$retval .= '<li><a href="' . get_permalink($post["ID"]) . '"><img src="' .  WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $thumbWidth . '&amp;height=' . $postthumbheight . '&amp;siteurl=' . site_url() . '" alt="' . $post_title .'" longdesc="' . WP_PLUGIN_URL. '/yslider/show_image.php?file=' . $post_image . '&amp;width=' . $imgWidth . '&amp;height=' . $postimgheight . '&amp;siteurl=' . site_url() . '"/></a><h3>';
				
				$retval .= $post_title;
				$retval .= '</h3><p>';
				$retval .= $post_excerpt ? $post_excerpt : $this -> teaser(strip_tags($post_content));
				$retval .= '</p></li>';
			}
		}

	 	$retval .= '</ul>';
		return $retval;
	
	}
	
	function getPostImage($post_content) {
		$first_img = '';
		ob_start();
     	ob_end_clean();
    	$outputimg = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
     	
		$first_img = $matches [1] [0];
     	
		if(empty($first_img)){ 
			//Defines a default image
			$first_img = WP_PLUGIN_URL."/yslider/graphics/no-image-available.jpg";
     	}
		return $first_img;
	}
	
	function teaser($text) {
		
		$wordLimit = 55;
		$teaserText = '';
		$words = explode(' ',$text);
		$i = 0;
		while($i < $wordLimit) {
    		$teaserText .= $words[$i]." ";
			$i++;
    	}
		return $teaserText . "...";
		
	}	
}

$YSlider = new YSlider();

?>
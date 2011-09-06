<?php
/*
Plugin Name: YSlider
Plugin URI: http://www.micc.unifi.it/ferracani/ 
Description: Content slider Wordpress jQuery Plugin with carousel
Version: 1.0
Author: Andrea Ferracani
Author URI: http://www.micc.unifi.it/ferracani/ 
License: GPL

*/

class YSlider {
	
	function YSlider() {
			
		//WordPress action hooks
		$this -> addHeadFiles();
		$this -> addCustomStyles();
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
			$queryStatus = "SELECT post_status FROM wp_posts WHERE ID='" . $postids_array[$i] . "'";
			$post_status = $wpdb->get_var($queryStatus);
			$queryContent = "SELECT post_content FROM wp_posts WHERE ID='" . $postids_array[$i] . "'";
			$post_content = $wpdb->get_var($queryContent);
			$queryExcerpt = "SELECT post_excerpt FROM wp_posts WHERE ID='" . $postids_array[$i] . "'";
			$post_excerpt = $wpdb->get_var($queryExcerpt);
			
			if ($post_status == "publish" && preg_match('/\[.*\]+/', $post_content) == 0) {
				//Get post title
				$queryTitle = "SELECT post_title FROM wp_posts WHERE ID='" . $postids_array[$i] . "'";
				$post_title = $wpdb->get_var($queryTitle);
				$post_image = $this -> getPostImage($queryContent);
				$post_permalink = get_permalink($postids_array[$i]);
				
				$post_image = $this -> getPostImage($post_content);
				
				$imgWidth = (round((int) $postwidth)) - 8;
				$thumbWidth = (round((int) $postwidth / ((int) $postslideby)) - 18);
				
				//Build the HTML code
				$retval .= '<li><a href="' . $post_permalink . '"><img src="' .  WP_PLUGIN_URL. '/yslider/timthumb.php?src=' . $post_image . '&amp;w=' . $thumbWidth . '&amp;h='. $postthumbheight . '&amp;zc=1" alt="' . $post_title .'" longdesc="' . WP_PLUGIN_URL. '/yslider/timthumb.php?src=' . $post_image . '&amp;w=' . $imgWidth . '&amp;h=' . $postimgheight . '&amp;zc=1"/></a><h3>';
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
			$queryStatus = "SELECT post_status FROM wp_posts WHERE ID='" . $post["ID"] . "'";
			$post_status = $wpdb->get_var($queryStatus);
			$post_content = $post["post_content"];
			$queryExcerpt = "SELECT post_excerpt FROM wp_posts WHERE ID='" . $post["ID"] . "'";
			$post_excerpt = $wpdb->get_var($queryExcerpt);
			
			if ($post_status == "publish" && preg_match('/\[.*\]/', $post_content) == 0) {
				$post_title = $post["post_title"];
				$post_image = $this -> getPostImage($post_content);
				$imgWidth = (round((int) $postwidth)) - 8;
				$thumbWidth = (round((int) $postwidth / ((int) $postslideby)) - 18);
				//Build the HTML code
				$retval .= '<li><a href="' . get_permalink($post["ID"]) . '"><img src="' .  WP_PLUGIN_URL. '/yslider/timthumb.php?src=' . $post_image . '&amp;w=' . $thumbWidth . '&amp;h='. $postthumbheight . '&amp;zc=1" alt="' . $post_title .'" longdesc="' . WP_PLUGIN_URL. '/yslider/timthumb.php?src=' . $post_image . '&amp;w=' . $imgWidth . '&amp;h=' . $postimgheight . '&amp;zc=1"/></a><h3>';
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
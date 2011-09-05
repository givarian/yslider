<?php
		if($_POST['yccf_hidden_style'] == 'Y') {
			//Form data sent
			
			
			
			$postwidth = $_POST['yccf_postwidth'];
			$postimgheight = $_POST['yccf_postimgheight'];
			$postthumbheight = $_POST['yccf_postthumbheight'];
			$postcontentheight = $_POST['yccf_postcontentheight'];
			$postcarouselheight = $_POST['yccf_postcarouselheight'];
			$postslideby = $_POST['yccf_postslideby'];
			$postspeed = $_POST['yccf_postspeed'];
			$postinterval = $_POST['yccf_postinterval'];
			$postdelay = $_POST['yccf_postdelay'];
			$postcontinuous = isset($_POST['yccf_postcontinuous']) ? "on" : "off";
			$postautoplay = isset($_POST['yccf_postautoplay']) ? "on" : "off";
			$postcss = $_POST['yccf_postcss'];
			
			//echo "DATASENT: autoplay " .  $postautoplay . " continuous " . $postcontinuous;
			
			
			update_option('yccf_postwidth', $postwidth);
			update_option('yccf_postimgheight', $postimgheight);
			update_option('yccf_postthumbheight', $postthumbheight);
			update_option('yccf_postcontentheight', $postcontentheight);
			update_option('yccf_postcarouselheight', $postcarouselheight);
			update_option('yccf_postslideby', $postslideby);
			update_option('yccf_postspeed', $postspeed);
			update_option('yccf_postinterval', $postinterval);
			update_option('yccf_postdelay', $postdelay);
			update_option('yccf_postcontinuous', $postcontinuous);
			update_option('yccf_postautoplay', $postautoplay);
			update_option('yccf_postcss', wp_filter_nohtml_kses($postcss));
			
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php
		} else {
			//Normal page display
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
					font-size:12px;
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
					font-size:12px;
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
?>
<div class="wrap">
	<?php    echo "<h2>" . __( 'YSlider style and behaviours configurations parameters', 'yslider-style-behaviours-config' ) . "</h2>"; ?>
		<form name="yccf_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="yccf_hidden_style" value="Y">
            
            <div id="style-settings">
			<?php echo "<h4>" . __( 'Style Settings', 'yccf_settings' ) . "</h4>"; ?>
			<p><label for="yccf_postwidth"><?php _e("Container width: " ); ?></label><input type="text" name="yccf_postwidth" value="<?php echo $postwidth; ?>" size="20"><?php _e(" ex: 428" ); ?></p>
            <p><label for="yccf_postimgheight"><?php _e("Images height: " ); ?></label><input type="text" name="yccf_postimgheight" value="<?php echo $postimgheight; ?>" size="20"><?php _e(" ex: 154" ); ?></p>
             <p><label for="yccf_postthumbheight"><?php _e("Thumbs height: " ); ?></label><input type="text" name="yccf_postthumbheight" value="<?php echo $postthumbheight; ?>" size="20"><?php _e(" ex: 30" ); ?></p>
             <p><label for="yccf_postcontentheight"><?php _e("Content height: " ); ?></label><input type="text" name="yccf_postcontentheight" value="<?php echo $postcontentheight; ?>" size="20"><?php _e(" ex: 200" ); ?></p>
              <p><label for="yccf_postcarouselheight"><?php _e("Carousel height: " ); ?></label><input type="text" name="yccf_postcarouselheight" value="<?php echo $postcarouselheight; ?>" size="20"><?php _e(" ex: 90" ); ?></p>
            
            </div>
            <div id="css-panel"><p><label for="yccf_postcss"><?php _e("CSS styles: " ); ?></label><textarea name="yccf_postcss" id="textarea-css"><?php echo $postcss; ?></textarea>
            <div id="reset-css">Reset css</div>
            </p></div>
              <br class="clearer" />
            <div id="behaviours-settings">
            <?php echo "<h4>" . __( 'Behaviours Settings', 'yccf_settings' ) . "</h4>"; ?>
            <p><label for="yccf_postslideby"><?php _e("Slide by: " ); ?></label><input type="text" name="yccf_postslideby" value="<?php echo $postslideby; ?>" size="20"><?php _e(" ex: 4" ); ?></p>
             <p><label for="yccf_postspeed"><?php _e("Speed: " ); ?></label><input type="text" name="yccf_postspeed" value="<?php echo $postspeed; ?>" size="20"><?php _e(" ex: slow, normal, fast or 1000 in milliseconds" ); ?></p>
             <p><label for="yccf_postinterval"><?php _e("Slide interval: " ); ?></label><input type="text" name="yccf_postinterval" value="<?php echo $postinterval; ?>" size="20"><?php _e(" ex: 5000 in milliseconds" ); ?></p>
             <p><label for="yccf_postdelay"><?php _e("Delay: " ); ?></label><input type="text" name="yccf_postdelay" value="<?php echo $postdelay; ?>" size="20"><?php _e(" ex: 5000 in milliseconds" ); ?></p>
             <p><input 
    		class="checkbox" 
        	name="yccf_postautoplay"
        	<?php 
			if ($postautoplay == "on") echo "checked=" . $postautoplay; ?>
        	type="checkbox"> 
    		<label for="yccf_postautoplay" class="admin-style-behaviours-check"><?php _e("Autoplay" ); ?></label></p>    
             <p><input 
    		class="checkbox" 
        	name="yccf_postcontinuous"
        	<?php 
			if ($postcontinuous == "on") echo "checked=" . $postcontinuous; ?>
        	type="checkbox"> 
    		<label for="yccf_postcontinuous" class="admin-style-behaviours-check"><?php _e("Continuous paging" ); ?></label></p>    
			</div>
            
            <p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options', 'yccf_settings' ) ?>" />
			</p>
		</form>
</div>
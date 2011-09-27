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
			//echo "postwidth: " . $postwidth;
			
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
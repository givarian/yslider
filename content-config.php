<?php
		if($_POST['yccf_hidden'] == 'Y') {
			//Form data sent
			$posttitle = $_POST['yccf_posttitle'];
			$postsubtitle = $_POST['yccf_postsubtitle'];
			$postids = $_POST['yccf_postids'];
			$postrecent = $_POST['yccf_postrecent'] == "on" ? "on" : "off";
			
			update_option('yccf_posttitle', $posttitle);
			update_option('yccf_postsubtitle', $postsubtitle);
			update_option('yccf_postids', $postids);
			update_option('yccf_postrecent', $postrecent);
			?>
            
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
            
			<?php
		} else {
			//Normal page display
                        //echo "Normal page display" . $postrecent;
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
			
		}
		
		/*
			$postids_array = explode(",", $postids);
			$areNumbers = $this -> checkIfIdsNumeric($postids_array);
			if(!$areNumbers) {
			?>
            <div id="message" class="error"><?php _e('One or more of your ids are not numbers, more recent posts are returned' ); ?></div>
            <?php
			}
		*/
			
?>
<div class="wrap">
	<?php    
//echo $postrecent;
echo "<h2>" . __( 'YSlider content configurations parameters', 'yslider-content-config' ) . "</h2>"; ?>
		<form name="yccf_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="yccf_hidden" value="Y">
			<?php echo "<h4>" . __( 'Post Settings', 'yccf_settings' ) . "</h4>"; ?>
			<div id="content-settings">
            <p><label for="yccf_posttitle"><?php _e("Title: " ); ?></label><input type="text" name="yccf_posttitle" value="<?php echo $posttitle; ?>" size="20"><?php _e(" ex: Today news"); ?></p>
             <p><label for="yccf_postsubtitle"><?php _e("Subtitle: " ); ?></label><input type="text" name="yccf_postsubtitle" value="<?php echo $postsubtitle; ?>" size="20"><?php _e(" ex: 2011 May 04"); ?></p>
            <p><label for="yccf_postids"><?php _e("Post ids: " ); ?></label><input type="text" name="yccf_postids" value="<?php echo $postids; ?>" size="20"><?php _e(" ex: 1,2,3,4,5,6" ); ?></p>
            <p><input 
    		class="checkbox" 
        	name="yccf_postrecent"
        	<?php 
			if ($postrecent == "on") echo "checked=" . $postrecent; ?>
        	type="checkbox"> 
    		<label for="yccf_postrecent" class="admin-content-check"><?php _e("Show recent posts" ); ?></label></p>        
            </div>
			
            <p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options', 'yccf_settings' ) ?>" />
			</p>
		</form>
</div>
	
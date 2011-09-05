// JavaScript Document

jQuery(document).ready(function(){
	function show_confirm() {
		var r=confirm("If you press OK, you will lose all the changes you made to the css! Are you sure?");
		if (r==true) {
			jQuery.ajax({
			url: reset_object.reset_url,
			success:function(data){
				//alert(data);
				 jQuery("#textarea-css").val(data);
				 alert("You successfully resetted your css! You can update the options")
			}
		})
  		} else {
  			alert("You cancelled the operation!");
  		}
	}
	
	
	jQuery("#reset-css").click(function(){
		show_confirm();
	})
	
	
})
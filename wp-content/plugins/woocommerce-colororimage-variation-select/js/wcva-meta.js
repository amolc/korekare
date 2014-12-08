(function($){
$('.wcvaheader').click(function(){

    $(this).nextUntil('tr.wcvaheader').slideToggle(100, function(){
    });
});
$('.subcollapsetr').click(function(){

    $(this).nextUntil('tr.subcollapsetr').slideToggle(100, function(){
    });
});
 $('.wcvaattributecolorselect').wpColorPicker();

 $(function() {
$('.wcvadisplaytype').live('change',function(){
    zvalue= $(this).val();
	if (zvalue == "colororimage") {
      
	 $(this).closest("div").find(".wcvaimageorcolordiv").show();
	 
	} else {
	  $(this).closest("div").find(".wcvaimageorcolordiv").hide();
	}
});
});


	
	  
    	
		 
		 $('.wcvacolororimage').on('change',function(){
        
		
		
		 if (this.value == "Image") {
		 
		  $(this).closest("div").find(".wcvacolordiv").hide();
		  $(this).closest("div").find(".wcvaimagediv").show();
		 
		 } else if (this.value == "Color") {
		  $(this).closest("div").find(".wcvaimagediv").hide();
		  $(this).closest("div").find(".wcvacolordiv").show();
		  
		 }
         
		
		 });
		 
           	 
        $(".image-upload-div").each(function(){
    	    var parentId = $(this).closest('div').prop('id');
		 		 // Only show the "remove image" button when needed
		    var srcvalue    = $('.facility_thumbnail_id_' + parentId + '').val();
				
				if ( srcvalue == "0" ){
				    jQuery('.remove_image_button_' + parentId + ' ').hide();
                }  
				// Uploading files
				var file_frame;

				jQuery(document).on( 'click', '.upload_image_button_' + parentId + ' ', function( event ){
                  
				    
					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: wcvameta.uploadimage,
						button: {
							text: wcvameta.useimage,
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();

						jQuery('.facility_thumbnail_id_' + parentId + '').val( attachment.id );
						jQuery('#facility_thumbnail_' + parentId + ' img').attr('src', attachment.url );
						jQuery('.imagediv_' + parentId + ' img').attr('src', attachment.url );
						jQuery('.remove_image_button_' + parentId + '').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on( 'click', '.remove_image_button_' + parentId + '', function( event ){
				    
					jQuery('#facility_thumbnail_' + parentId + ' img').attr('src', wcvameta.placeholder );
					jQuery('.imagediv_' + parentId + ' img').attr('src', '');
					jQuery('.facility_thumbnail_id_' + parentId + '').val('');
					jQuery('.remove_image_button_' + parentId + '').hide();
					return false;
				});
		 
	});				
		    
	     

})(jQuery); 



(function($){

	/***
	 *	Gallery Manager
	 *
	 */

	$(document).ready(function() {
		mediaUploader();

	});
	
	
	
	function mediaUploader(){

		var custom_file_frame;		// uploading files variable
		var currentUploader = {};	// data for the active uploader
		
		$(document).on('click', '.ADD-GALLERY-SHORTCODE', function(event){
			event.preventDefault();
			
			currentUploader = $(this).data();
			var mult = false;
			if ( currentUploader.multiple == true ){ mult = true; }
			
			//If the frame already exists, reopen it
			if (typeof(custom_file_frame)!=="undefined") {
				custom_file_frame.close();
			}


			//Create WP media frame.
			custom_file_frame = wp.media.frames.customHeader = wp.media({
			
				title: currentUploader.title ? currentUploader.title : 'Uploader Title',				//Title of media manager frame
				library: {
					type: currentUploader.type ? currentUploader.type : 'image'
				},
				button: {
					text: currentUploader.buttontext ? currentUploader.buttontext : 'Button Text'		//Button text
				},
				multiple: currentUploader.multiple ? currentUploader.multiple : false					//Do not allow multiple files, if you want multiple, set true
				
			});


			//callback for selected image
			custom_file_frame.on('select', function(){
				var attachment = custom_file_frame.state().get('selection').toJSON();
				
				var $field = $('#'+currentUploader.target);	//gallery wrapper ID
				if ( $field.length < 0 ) return false;
				
				/* Output the Results */
				var SC = '';
				$.each( attachment, function( index, image ){
					SC += image.id+',';
				});

				if ( SC ) SC = SC.slice(0, -1);

				$field.val(SC);
			});

					
			//Open modal
			custom_file_frame.open();
		});
	}
		

}(jQuery));




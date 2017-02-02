(function($){


	$(document).ready(function() {
		
		var custom_file_frame;		// uploading files variable
		var currentUploader = {};	// data for the active uploader
		
		
		$(document).on('click', '.UPLOAD-MEDIA', function(event){
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
				console.log(attachment);
				
				var output = new Array();
				
				$.each( attachment, function( index, value ){
					var newImageData = value;
					output.push( value.id );
				});
				console.log(output);
				
				
				/* Output the Results */
				
				/* if: GALLERY */
				if ( currentUploader.framework === 'gallery' ) {
					
					var $wrapper 	= $('#'+currentUploader.target);
					var wrapperData = $wrapper.data();
					
					var arrayString = $wrapper.find('.GALLERY-array').val();
					
					if ( arrayString != '' && arrayString ){
						arrayString = arrayString.split(',');
						$.each( arrayString, function(i){
							arrayString[i] = parseInt(arrayString[i]);
						});
						console.log(arrayString);
					}
					
					var newImages = new Array();
					for( var i=0; i<output.length; i++ ) { 
						if( $.inArray( output[i], arrayString ) < 0 ) { 
							newImages.push(output[i]);
							console.log(output[i]);
						}
					}
					
					if ( newImages.length < 1 ) {
						alert('Imigjat tashme jane te insertuar. insertoni te tjere, mundesisht!!');
						return false;
					}
					  
					//prepare data for new list item
					var data = {
							GALLERYadd: 1,
							action: 'gallery_ajaxadd',
							name: currentUploader.target,
							items: newImages.join(',')
						};
					//request for new list item: option-components.php
					$.post( ajaxurl, data, function(response) {
						$wrapper.find('.GALLERY-list').append(response);
						$wrapper.find('.GALLERY-array').change();
					});
				
				/* if: FEATURED VIDEO */
				} else if ( currentUploader.framework === 'featuredvideo' ) {
					
					var $wrapper 	= $('#'+currentUploader.target);
					$wrapper.val( attachment[0].url );
					
				}
				
				
				//do something with attachment variable, for example attachment.filename
				//Object:
				//attachment.alt - image alt
				//attachment.author - author id
				//attachment.caption
				//attachment.dateFormatted - date of image uploaded
				//attachment.description
				//attachment.editLink - edit link of media
				//attachment.filename
				//attachment.height
				//attachment.icon - don't know WTF?))
				//attachment.id - id of attachment
				//attachment.link - public link of attachment, for example ""http://site.com/?attachment_id=115""
				//attachment.menuOrder
				//attachment.mime - mime type, for example image/jpeg"
				//attachment.name - name of attachment file, for example "my-image"
				//attachment.status - usual is "inherit"
				//attachment.subtype - "jpeg" if is "jpg"
				//attachment.title
				//attachment.type - "image"
				//attachment.uploadedTo
				//attachment.url - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
				//attachment.width
			});
	 
			//Open modal
			custom_file_frame.open();
		});
	});
		
	
}(jQuery));




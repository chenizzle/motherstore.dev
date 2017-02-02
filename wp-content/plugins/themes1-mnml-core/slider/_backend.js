(function($){



	//------------------------------------------------------------
	//	Function to hide DOM element when click outside of it
	

	if ( ! $.fn.outside ){ 
    $.fn.outside = function(ename, cb){
        return this.each(function(){
            var $this = $(this),
                self = this;

            $(document).bind(ename, function tempo(e){
                if(e.target !== self && !$.contains(self, e.target)){
                    cb.apply(self, [e]);
                    if(!self.parentNode) $(document.body).unbind(ename, tempo);
                }
            });
        });
    };
	}
	
	
	
//-----------------------------------
//
//	SLIDER MANAGER
//-----------------------------------

	$(document).ready(function() {
		
		var $slidesList = $('#SLIDES-list');
		$slidesList.on( 'click', '.the1icontabs .icontab', function(){
			var $this = $(this);
			var newValue = $this.data().value;
			var $wrapper = $this.closest('.the1icontabs');
			$wrapper.find('.icontab').removeClass('selected');
			$this.addClass('selected');
			$wrapper.find('input').val(newValue);	
			
		});
		
		the1Slider_createNewSlide();
		the1Slider_deleteSlide();
		the1Slider_mediaUploader();
		the1Slider_embedNewVideo();
		the1Slider_clearMedia();
		
		// Add Color Picker to all inputs that have 'color-field' class
		
	});
	
	

//-----------------------------------
//	setup slider backend

	function the1Slider_createNewSlide(){

		var $slidesList = $('#SLIDES-list');
		var $slides = $('#SLIDES-list').children('li.SLIDE');
		var $addSlide = $('#add-new-slide');
		
		$slidesList.sortable({distance: 15});
		
		$addSlide.on( 'click', function(event){
			event.preventDefault();
			
			var currentItems = [];
			var $slidesList = $('#SLIDES-list');
			var $slides = $('#SLIDES-list').children('li.SLIDE');
			$slides.each( function() {
				var $this = $(this);
				currentItems.push( $this.data().id );                                
	        });
			
			var i = 0;
			var newID = false;
			
			while ( !newID ){
				if ( currentItems.indexOf(i) < 0 ) newID = i;
				i++;
			}
			
			var data = {
					action: 'the1_slider_single_slide_html',
					id: newID,
				};
			//prepare data for new slide
			//request for new list item: option-components.php
			$.post( ajaxurl, data, function(response) {
				$slidesList.append(response);
				the1Slider_embedNewVideo();
				$('.the1npc-colorpicker').not('.wp-color-picker').wpColorPicker();
			});
		});

	}


//-----------------------------------
//	insert YouTube/Vimeo video

	function the1Slider_deleteSlide(){
		
		var $slidesList = $('#SLIDES-list');
		$slidesList.on('click','.SLIDE-delete',function(){
			if ( confirm('Delete slide?') ){
				var $slide = $(this).closest('.SLIDE');
				$slide.slideUp(300,function(){ $slide.remove(); });
			}
		});
		
	}


//-----------------------------------
//	insert YouTube/Vimeo video

	function the1Slider_embedNewVideo(){
		
		var $slidesList = $('#SLIDES-list');
		var $slides = $slidesList.children('li.SLIDE').not('.loaded');

		if ( $slides.length < 1 ) return false;

		var $videoFieldContainer = $slides.find('.SLIDE-embed-video-field');
		var $submitVideoButton = $slides.find('.submit-video');
		
		/* show add-video dialog */
		$slides.find('.SLIDE-embed-video').on( 'click', function(event){
			event.preventDefault();
			
			var $this = $(this);
			var $currentSlide = $this.closest('.SLIDE');
			
			var $videoUrlWrapper = $currentSlide.find('.SLIDE-embed-video-field');
			var $videoUrl = $videoUrlWrapper.find('input');

			$videoUrl.val('');
			$videoUrlWrapper.show();
			$videoUrl.focus();
			return false;
		});
		
		/* hide add-video dialog when click outside of it */
		$videoFieldContainer.outside( 'click', function(){
			//event.preventDefault();
			$(this).hide();
		});
		
		/* submit video */
		$slides.find('.submit-video').on( 'click', function(){
			var $this = $(this);
			var $currentSlide = $this.closest('.SLIDE');

			var $videoUrlWrapper = $currentSlide.find('.SLIDE-embed-video-field');
			var $videoUrl = $videoUrlWrapper.find('input');
			
			var $targetUrl = $currentSlide.find('.slide-media-url');
			var $targetThumb = $currentSlide.find('.slide-media-thumb');
			var $targetType = $currentSlide.find('.slide-media-type');
			var $targetPreview = $currentSlide.find('.SLIDE-image');
			
			var URL = $videoUrl.val();
			var linkLabel = $this.text();
			
			if ( !URL ) return false;
			
			$this.text('Loading...');
			//alert(linkLabel);
			
			$.ajax({
				type : "post",
				url : ajaxurl,
				data : { videourl: URL, action: 'video_request', thumb: 'src' },
				success: function(response) {
					
					if ( response == 'Invalid URL' ){
						alert(response);
					} else {
						
						$targetUrl.val(URL);
						$targetThumb.val(response);
						$targetType.val('embededvideo');
						$targetPreview.css('background-image', 'url('+response+')');
						
						$videoUrl.val('');
						$videoUrlWrapper.hide();
					}
					$this.text(linkLabel);
					
				}
			});					
			return false;
		} );

	}
	
	
	
//-----------------------------------
//	Insert slide image

	function the1Slider_mediaUploader(){

		if ( $('#slides-manager').length < 1 ){ return false; }
		
		var $slidesList = $('#SLIDES-list');
		
		var custom_file_frame;		// uploading files variable
		var currentUploader = {};	// data for the active uploader
		
		$slidesList.on('click', '.SLIDE-add-image', function(event){
			event.preventDefault();
			
			var $this = $(this);
			
			currentUploader = $this.data();
			var mult = false;
			if ( currentUploader.multiple == true ){ mult = true; }
			
			/* If the frame already exists, reopen it */
			if (typeof(custom_file_frame)!=="undefined") {
				custom_file_frame.close();
			}


			/* Create WP media frame */
			custom_file_frame = wp.media.frames.customHeader = wp.media({
			
				title: currentUploader.title ? currentUploader.title : 'Uploader Title',			//Title of media manager frame
				library: {
					type: currentUploader.type ? currentUploader.type : 'image'
				},
				button: {
					text: currentUploader.buttontext ? currentUploader.buttontext : 'Button Text'	//Button text
				},
				multiple: currentUploader.multiple ? currentUploader.multiple : false				//Do not allow multiple files, if you want multiple, set true
				
			});


			/* Callback for selected image */
			custom_file_frame.on('select', function(){
				var attachment = custom_file_frame.state().get('selection').toJSON();
				
				console.log(attachment); //selected gallery item [object]
				
				/* if: SLIDES MANAGER */
				if (  currentUploader.framework === 'the1_slider' ){
					var $currentSlide = $this.closest('.SLIDE');
					var $targetId = $currentSlide.find('.slide-media-id');//slide media-thumb container
					var $targetThumb = $currentSlide.find('.slide-media-thumb');//slide media-thumb container
					var $targetUrl 	= $currentSlide.find('.slide-media-url');	//slide media-url container
					var $targetType	= $currentSlide.find('.slide-media-type');	//slide media-type container
					var $targetPreview	= $currentSlide.find('.SLIDE-image');	//slide media-type container
					
					$targetId.val(attachment[0].id);
					$targetThumb.val(attachment[0].url);
					$targetUrl.val(attachment[0].url);
					$targetType.val(attachment[0].type);
					$targetPreview.css('background-image', 'url('+attachment[0].url+')');
					return false;
				}
			});
	 
	 
			/* Open modal */
			custom_file_frame.open();
		});
	}
	
	

//-----------------------------------
//	Clear media from slide
	
	function the1Slider_clearMedia(){
		var $slidesList = $('#SLIDES-list');
		$slidesList.on('click', '.SLIDE-remove-media', function(event){
			event.preventDefault();
			var $this = $(this);
			var $currentSlide = $this.closest('.SLIDE');
			var $targetUrl 	= $currentSlide.find('.slide-media-url');	//slide media-url container
			var $targetType	= $currentSlide.find('.slide-media-type');	//slide media-type container
			var $targetPreview	= $currentSlide.find('.SLIDE-image');	//slide media-type container

			$targetUrl.val('');
			$targetType.val('');
			$targetPreview.css('background-image', 'none');
			
		});
	}
		

}(jQuery));




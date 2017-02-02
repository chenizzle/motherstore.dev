
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ){
		function F(){};
		F.prototype = obj;
		return new F();
	};
};


(function( $, window, document, undefined ){

	var Gallery = {
		
		init: function( options, elem ){
				var self = this;
				

				self.wrapper = elem;		//cache wrapper element
				self.$wrapper = $( elem );	// -- jquery version
				
				self.$slides = self.$wrapper.find('.gall_Slide');
				self.$slidesList = self.$wrapper.find('.gall_Slides');
				
				self.$btnLeft = self.$wrapper.find('.goLeft');
				self.$btnRight = self.$wrapper.find('.goRight');
				
				
				self.totalSlides = self.$slides.length;

				self.currSlide = 0;
				self.prevSlide = 0;
				self.nextSlide = 1;
				self.ready = true;
				
				self.$btnLeft.on( 'click', function(){ self.slideLeft(); });
				self.$btnRight.on( 'click', function(){ self.slideRight(); });

				
				//self.loading();
				//self.swipeSlide();
				self.swipppeSlide();
				self.keyboardEvents();

				self.actionSlide();

				
		},
		
		loading: function(){
				var self = this;
								
				var $slideImageNew = self.$slidesMedia.eq( self.currSlide );
				var slData = $slideImageNew.data();				

				self.$slidesMedia.has('img').each( function(){
					var $this = $(this);
					$this.imagesLoaded( function(){
						$this.find('.sl-loadingscreen').fadeOut();
						self.$thumbs.eq( $this.data().index ).addClass('ready').find('.sl-loadingscreen').fadeOut();
					});
				});
		},
		
		keyboardEvents: function(){
				var self = this;
				
				$(document).bind('keydown',function(evt) {
					var screenHeight = $(window).height();
					var slHeight = self.$wrapper.height();
					
					var slOffset = ( self.$wrapper.offset().top - $(document).scrollTop());
					var topLimit = (screenHeight/2)-slHeight;
					var botLimit = (screenHeight/2);
					
					if ( topLimit > 0 ) topLimit = 0;
					
					$inputs = $(document).find('input:focus').length;
					
					
					
					if ( slOffset > topLimit && slOffset < botLimit && $inputs < 1 ){
						switch(evt.keyCode) {
							case 39: self.slideRight(); break;
							case 37: self.slideLeft(); break;
						}
					}
				});		
		},
		
		slideLeft: function(){
				var self = this;
				
				if ( !self.ready || self.$slides.length < 2 ) return false;
				self.ready = false;
				
				self.prevSlide = self.currSlide;
				self.currSlide--;

				if ( self.currSlide < 0 ) {
					self.currSlide = ( self.totalSlides - 1 );
				}
				self.actionSlide();
				$('#current_slide').html(self.currSlide +1 );
		},
		
		slideRight: function(){
				var self = this;
				
				if ( !self.ready || self.$slides.length < 2 ) return false;
				self.ready = false;
				

				self.prevSlide = self.currSlide;
				self.currSlide++;
				self.nextSlide = self.currSlide+1;

				if ( self.currSlide >= self.totalSlides ) {
					self.currSlide = 0;
					self.nextSlide = 1;
				}
				if ( self.nextSlide >= self.totalSlides ) {
					self.nextSlide = 0;
				}
				
				self.actionSlide();
				$('#current_slide').html( self.currSlide +1 );
		},
		
		slideGoTo: function(i){
				var self = this;
				
				if ( i !== self.currSlide ){
					
					if ( !self.ready ) return false;
					self.ready = false;
										
					self.prevSlide = self.currSlide;
					self.currSlide = i;
					self.actionSlide();
				}
		},
		
		actionSlide: function(){
				var self = this;
				
								
				// check if this is initial Load of slider
				var firstLoad = ( self.prevSlide === self.currSlide ? true : false );
				
			//	Slides
				self.$slidesList.css( 'left', -(self.currSlide*100)+'%' );
				self.ready = true;
				
				// set active control (thumb, dot, ...)
				//self.actionSetActiveControl();
				
		},
		
		actionSetActiveControl : function(){
				var self = this;
				
				if ( self.$thumbs.length > 0 ){
					self.$thumbs.removeClass('active').eq( self.currSlide ).addClass('active');
				}
				if ( self.$dots.length > 0 ){
					self.$dots.removeClass('active').eq( self.currSlide ).addClass('active');
				}
				if ( self.$tabs.length > 0 ){
					self.$tabs.removeClass('active').removeClass('next-active').eq( self.currSlide ).addClass('active');
					self.$tabs.eq( self.nextSlide ).addClass('next-active');
				}

		},
		

		forceFullscreenEmbededVideo: function(){
				var self = this;
				
				var $slideMedia_new = self.$slidesMedia.eq( self.currSlide );
				var $player = $slideMedia_new.find('iframe.vimeo-player, iframe.youtube-player').eq(0);
				
				if ( $player.length > 0 ){

					var playerRatio = $player.attr('height') / $player.attr('width');
					
					var $playerWrapper = $player.parent();
					var wrapperRatio = $playerWrapper.height() / $playerWrapper.width();
					
					if ( playerRatio > wrapperRatio ){
						$player.css('transform','scale('+(playerRatio/wrapperRatio)+')');
					} else {
						$player.css('transform','scale('+(wrapperRatio/playerRatio)+')');
					}
					
				}
				
		},
		
		swipppeSlide: function(){
				var self = this;
				var $sw = self.$wrapper;
				var swipeStartPos;
				
				$sw.on('mousedown',function(e){
					swipeStartPos = e.pageX;
					$(this).addClass('swippping');
				}).on('mouseup',function(){
					$(this).removeClass('swippping');
				}).on('mouseleave',function(){
					$(this).removeClass('swippping');
				});
				
				$sw.parent().on('mousemove','.the1homegallery.swippping',function(e){
					var mousePos =  e.pageX;
					var swipeTravel = Math.abs( swipeStartPos - mousePos );
					if ( swipeTravel > 100 ) {
						if ( swipeStartPos > mousePos ){ 
							// swipe right
							self.slideRight();
							$(this).removeClass('swippping');
						} else {
							// swipe left
							self.slideLeft();
							$(this).removeClass('swippping');
						}
					}
				});
		},
		
		
		/*
		swipeSlide: function(){
				var self = this;
				if ( $.fn.swipe ){
					self.$wrapper.swipe(
						{
							swipeLeft: function(event){
								event.preventDefault();
								self.stopAutoPlay();
								self.slideRight();
								return false;
							},
							swipeRight: function(event){
								event.preventDefault();
								self.stopAutoPlay();
								self.slideLeft();
								return false;
							},
							excludedElements: '',
							threshold: 20
						}
					);
				}
		},
		*/


	}




	$.fn.lookbook = function( options ){

		return this.each(function(){
			var slider = Object.create( Gallery );
			slider.init( options, this );
		});
		
	};
	
	
	// Default Values
	$.fn.lookbook.options = {
		type		: 'fullscreen',
		fx			: 'slide',
		items		: '.ts-items',
		item		: '.ts-item',
		navarrow	: '.ts-navarrow',
		left		: '.ts-goLeft',
		right		: '.ts-goRight',
		thumbnails	: '.ts-thumbnails',
		thumbnailslist	: '.ts-thumbnailslist',
		thumbnail	: '.ts-thumbnail',
		dots		: '.ts-dots',
		dot			: '.ts-dot',
		bottombar	: '.ts-bottombar',
		loading		: '.ts-loadingscreen'
	};



	$(document).ready(function(){ 
		$('.lookbook').lookbook();
	});


})( jQuery, window, document );




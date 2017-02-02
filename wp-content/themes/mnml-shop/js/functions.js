(function($){

	/* jquery plugin to close elements when click outside of it */
	if ( !$.fn.outside ){
	    $.fn.outside = function(ename, cb){
	        return this.each(function(){
	            var $this = $(this), self = this;
	            $(document).bind(ename, function tempo(e){
	                if(e.target !== self && !$.contains(self, e.target)){
	                    cb.apply(self, [e]);
	                    if(!self.parentNode) $(document.body).unbind(ename, tempo);
	                }
	            });
	        });
	    };
    }




	$(document).ready(function(){

			//	mobile menu show/hide 
				mobileMenuToggle();

			//	cart panel show/hide 
				cartPanelToggle();

			//	titles animate on scroll
				titleScrollAnimate();

			//	fade-in images on load (imagesLoaded.js required)
				$('.image-to-load').each(function(){
					var $this = $(this);
					$this.imagesLoaded(function(){
						$this.addClass('loaded');
					});
				});

			//	subscribe popup
				subscribePopup();

			//	owl carousel default init
				$('.owl-carousel').owlCarousel({
				    loop:true,
				    margin:10,
				    responsive:{
				        0:{ items:1 },
				        600:{ items:2 },
				        840:{ items:3, dots:false }
				    }
				});

			// single product

			$('.singleprod__qty__plus').on('click', function(){
				var product_quantity_value = $('#prod-qty').val();
				$('.singleprod__qty__count').html(function(i, val) { return +val+1 });
				$('#prod-qty').attr('value', $('.singleprod__qty__count').html());
			});
			$('.singleprod__qty__minus').on('click', function(){
				var product_quantity_value = $('#prod-qty').val();
				if ($('.singleprod__qty__count').html() > 1){
					$('.singleprod__qty__count').html(function(i, val) { return +val-1 });
					$('#prod-qty').attr('value', $('.singleprod__qty__count').html());
				}
			});
	});




	//	mobile menu open/close
		function mobileMenuToggle(){
			$('#mobile-nav-wrapper').outside('click', function(e){
				//e.preventDefault();
				console.log(e.srcElement.className);
				if ( $.contains( document.getElementById('mobile-nav-toggle'), e.srcElement  ) ) {
					$('body').addClass('mobile-nav-is-open');
				} else {
					if ( $('body').hasClass('mobile-nav-is-open') ){
						$('body').removeClass('mobile-nav-is-open');
						return false;
					}
				}
			});
			$('#mobile-menu-close').on('click', function(){
				$('body').removeClass('mobile-nav-is-open');
			});
		}

	//	cart panel open/close
		function cartPanelToggle(){
			$('#cart-panel').outside('click', function(e){
				//e.preventDefault();
				console.log(e.srcElement.className);
				if ( $.contains( document.getElementById('cart-link-header'), e.srcElement  ) ) {
				//if ( e.srcElement.className === '.cart-link-header' ){
					$('body').addClass('cart-panel-is-open');
				} else {
					if ( $('body').hasClass('cart-panel-is-open') ){
						$('body').removeClass('cart-panel-is-open');
						return false;
					}
				}
			});
			$('.cart-panel__close').on('click', function(){
				$('body').removeClass('cart-panel-is-open');
			});
		}

	//	animate titles on scroll
		function titleScrollAnimate(){
			var $dynaTitles = $('.frontbox__title');
			//var $dynaCats = $('.frontbox__category');
			var $dynaSocial = $('.mainbanner-area__social');
			var winHeight = $(window).height(); 
			var winHalf = winHeight/3;
			$(window).on('scroll', function(){
				var $w = $(this);
				$dynaTitles.each(function(){
					var $this = $(this);
					var $wrap = $this.parent();
					var pos = ( $this.offset().top - $w.scrollTop() - winHalf ) / 6;
					//pos = pos*(-1)
					//$this.html(Math.floor(pos));
					$wrap.css('transform', 'translateY('+Math.floor(pos)+'px)');
				})
				/*
				$dynaCats.each(function(){
					var $this = $(this);
					//var $wrap = $this.parent();
					var pos = ( $this.offset().top - $w.scrollTop() - winHalf ) / 6;
					pos = pos*(-1)
					//$this.html(Math.floor(pos));
					$this.css('transform', 'translateY('+Math.floor(pos)+'px)');
				});
				$dynaSocial.each(function(){
					var $this = $(this);
					//var $wrap = $this.parent();
					var pos = $w.scrollTop() / 2.5;
					//pos = pos*(-1)
					//$this.html(Math.floor(pos));
					$this.css('transform', 'translateY('+Math.floor(pos)+'px) rotate(270deg)');
				});
				*/
			});
		}

	//	subscribe popup
		function subscribePopup(){
			$('#subscribe-link').on('click', function(e){
				e.preventDefault();
				$('#subscribe-popup').fadeIn(250);
			});
			$('#subscribe-popup-close, .subscribe-popup__close').on('click', function(e){
				e.preventDefault();
				$('#subscribe-popup').fadeOut(250);
			});
			
			if ( $('body').hasClass('page-template-template-homepage') ){
				setTimeout( function(){ $('#subscribe-popup').fadeIn(250); }, 2000 );
			}
		}



})(jQuery);
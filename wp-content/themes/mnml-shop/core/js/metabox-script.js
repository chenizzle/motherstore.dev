(function($){
	
	
	$(document).ready(function() {
		
        radioSetup();
		
		radioTabsSetup();
		
		checkboxTabsSetup();
		
		colorPickers();
		
    });
	
	
//---------------------------------------------------
	
	
	function radioSetup(){
		var $radios = $('body').find('.the1_radio');
		var $triggers = $('body').find('.the1_radio_trigger');
		
		$radios.filter(':checked').next('.the1_radio_trigger').addClass('active');
		
		$triggers.on( 'click', function(){
			var $this = $(this);
			var $currentGroup = $this.closest('.the1_radio_group');
			
			$currentGroup.find('.the1_radio_trigger').removeClass('active');
			$this.addClass('active');
			
		});
	}


	function radioTabsSetup(){
		var $radioTabs = $('body').find('.the1_radio_tab');
		
		$radioTabs.filter(':checked').each( function(){
			$('.the1_radio_tab_page.'+$(this).data().tab).addClass('active');
		});
		
		$radioTabs.on( 'click', function(){
			var $this = $(this);
			var $currentGroupTabs = $this.closest('.the1_radio_tab_group').find('.the1_radio_tab_page');
			
			$currentGroupTabs.removeClass('active');
			$currentGroupTabs.filter('.'+$(this).data().tab).addClass('active');
			
		});
	}
	
	
	function checkboxTabsSetup(){
		var $chks = $('body').find('.the1_chk_tab');
		var $pages = $('body').find('.the1_chk_page');
		
		$chks.each( function() {
			var $this = $(this);
			if ( !$this.is(':checked') ){
				$pages.filter( '.'+$this.data().tab ).show().removeClass('initial').addClass('active');
			}
        });

		$chks.on( 'click', function(){
			var $this = $(this);
			var target = $this.data().tab;
			if ( $this.is(':checked') ){
				$pages.filter('.'+target).slideUp().removeClass('active');
			} else {
				$pages.filter('.'+target).slideDown().addClass('active');
			}
		});
	}
	
	
	function colorPickers(){
		var $metaboxPickers = $('.mb-picker');
		$metaboxPickers.wpColorPicker({defaultColor: '#555555'});
	}
	
})(jQuery);
(function($){

/*---------------------------------------------*/
/* 	THEME SPECIFIC FUNCTIONS
/*---------------------------------------------*/

		jQuery(document).ready(function(){
			//switch_patterns();
			//$('#site-style').change(switch_patterns);
			//enableCatColors();
		});
		

// SWITCH PATTERNS
		function switch_patterns(){
			sel = $('#site-style');
			if(sel.val()){
				newValue = sel.val();
				if( newValue=='light' ){
					$('#postbodytitle').removeClass('disabled');
				} else {
					$('#postbodytitle').addClass('disabled');
				}
				$('.IS-wrap', '#background-pattern').hide();				
				$('.IS-wrap.'+newValue, '#background-pattern').fadeIn(200);				
			}
		}

// madson: custom category colors
		function enableCatColors(){
			var $tab = $('#chktrigger_catcolor_use');
			var $chkbox = $('input#catcolor_use');
			
			$chkbox.on( 'click', function(){
				if ( $(this).is(':checked') ){
					$tab.slideDown();
				} else {
					$tab.slideUp();
				}
			});

			if ( $chkbox.is(':checked') ){
				$tab.slideDown();
			} else {
				$tab.slideUp();
			}
			
		}
	


/*---------------------------------------------*/
/*	INTERFACE
/*---------------------------------------------*/

		$(document).ready(function(){
			
			$('.panel-loading').hide();
								   
			importExportThemeSettings();
			importDemoData();

			initBasics();				// Load any basic independent stuff here
			inputtextToCheckbox();  	// Custom Checkboxes
			mainTabs();					// Tabs / primary tabs
			mediaUploader(); 			// Setup "Upload" buttons

			mainNavigation();			// Navigation / secondary tabs
			initFontSelector();			// Font selector
			SORT_sortables();			// init "Sortable" system
			SLIDER_ui();				// UI value sliders
			colorPicker();				// Color pickers
			radioSetup();				// Radio Buttons with Images
			
			saveOptions();				// Process and save theme options

			remoteChanges();			// Various Remote changes made here
			socialIconsDD();			// Social Icons dropdown list
			
			IS_imageSelector();			// IS (ImageSelector) widget
			images_selector();			// IS (ImageSelector) widget
			

			goToPageInit();				// Navigate directly to specific page (requires <input id="goToPage">)






	

			// hide/show checkbox content
			$('#featured-posts-recent').on('click', function(){
				//alert('fff');
				if ( !$(this).hasClass('on') ){
					$('#optID-featured-posts').hide();
				} else {
					$('#optID-featured-posts').show();
				}
			});

			
		});



// SOME INIT ACTIONS
		function initBasics(){
			/*  turn off autocomplete for all form elements */
				$('#options-form').attr('autocomplete','off');
		}


// This function is called whenever an option page has been loaded.. initially or through ajax.
		function onOptionPageLoad(){
			mainNavigation();			// Navigation / secondary tab
			initFontSelector();			// Font selector
			SORT_sortables();			// init "Sortable" system
			SLIDER_ui();				// UI value sliders
			colorPicker();				// Color pickers
			socialIconsDD();
			radioSetup();
		}


// SAVE THEME OPTIONS
		function saveOptions(){
			var $TABCONTENT = $('.the1panel-tabcontent');
			
			/* save options */
			$TABCONTENT.on('click', '.the1-submit-btn', function(e){
				e.preventDefault();
				$(this).closest('form').submit();
				return false;
			});

			/* reset options */
			$TABCONTENT.on('click', '.the1options_resetbtn', function(e){
				e.preventDefault();
				if( !confirm("This will clear current saved settings. Proceed?") ) return false;
				
				var $this = $(this);
				var $FORM = $this.closest('form');

				var optsgroup = $FORM.find('.optionsgroup').eq(0).val();
				var nonce = $FORM.find('#the1options_nonce__'+optsgroup).val();
								
				overlayer('<div id="msg-processing">Reset options...</div>');
				
				$.ajax({
					type : "post",
					url : ajaxurl,
					data : { 
						action: "the1options_reset__"+optsgroup,
						security: nonce
					},
					success: function(response) {
						if( response === 'success' ){
							$('#msg-processing').html('<i class="fa fa-check-circle" style="color:#8AE8A7;"></i>&nbsp;&nbsp;Options has been reset... Reloading!').show();
							//setTimeout( function(){ location.reload() }, 2000 );
							$('#msg-processing').delay(1000).fadeOut(200, function(){closeOverlayer();});

											$('#tab-'+optsgroup).html('loading options...');
											$.ajax({
												type : "post",
												url : ajaxurl,
												data : { 
													action: "mnml_options_page__"+optsgroup,
												},
												success: function(response) {
													$('#tab-'+optsgroup).html(response);
													unsavedOptions_unset();
													onOptionPageLoad();
												}
											});
											return false;	


						} else {
							if ( response < 0 ){
								var msg = '<i class="fa fa-exclamation-triangle" style="color:#E8D292;"></i>&nbsp;&nbsp;Unable to authenticate';
							} else {
								var msg = '<i class="fa fa-exclamation-triangle" style="color:#E8D292;"></i>&nbsp;&nbsp;' + response;
							}
							$('#msg-processing').html(msg).show();
							$('#msg-processing').delay(1000).fadeOut(200, function(){closeOverlayer();});
						}
					}
				});
				return false;	
			});

			
			/* serialize settings on submit */
			$('.the1panel-tabcontent').on( 'submit', 'form.the1panel-optionsform', function() {
				var data = $(this).serialize();
				overlayer('<div id="msg-processing">Saving...</div>');
				
				$.post(ajaxurl, data, function(response) {
					console.log(response);
					$('#msg-processing').html(response).show();
					$('#msg-processing').delay(2000).fadeOut(200, function(){closeOverlayer();});
					unsavedOptions_unset();
				});
				$('.newfeature').fadeOut();
				return false;
			});

			/* indicate unsaved options */
			$('.the1panel-tabcontent').on('change', '.the1panel-optionsform input, .the1panel-optionsform select, .the1panel-optionsform textarea', function(){
				unsavedOptions_set();
			});

	}
	function unsavedOptions_set(){
		$('.the1panel-tab.active').addClass('unsaved');
	};
	function unsavedOptions_unset(){
		$('.the1panel-tab.active').removeClass('unsaved');
	};
		
						


// <SELECT> to CHECKBOXES
		function inputtextToCheckbox(){
			$('.the1panel-tabcontent').on( 'click', 'label', function(e){
				var FOR = $(this).attr('for');
				if ( FOR && $('div#'+FOR).length>0 ){
					$('div#'+FOR).click();
				}
			});
			$('.the1panel-tabcontent').on( 'click', '.inputtextToCheckbox', function(){
				var $wrapper = $(this);
				var $input = $wrapper.find('input');
				if ( $input.val() === 'on' ){
					$input.attr('value','');
					$wrapper.removeClass('on');
				} else {
					$input.attr('value','on');
					$wrapper.addClass('on');
				}
				unsavedOptions_set();
			});
			
		}



// RADIO BUTTONS with IMAGES

	/* 	radioSetup()
	 *
	 *	HTML structure:
	 *	
	 *	<div class="the1_radio_group">
	 *		<label>
	 *			<input type="radio" class="the1_radio" name="[]" value="[]" />
	 *			<img class="the1_radio_trigger" src="[]" />
	 *		</label>
	 *	</div>
	 *		
	 */
	
	function radioSetup(){
		var $radioGroup = $('.the1_radio_group').not('.loaded');
		$radioGroup.addClass('loaded');

		var $radios = $radioGroup.find('.the1_radio');
		var $triggers = $radioGroup.find('.the1_radio_trigger');
		
		$radios.filter(':checked').next('.the1_radio_trigger').addClass('active');
		
		$triggers.on( 'click', function(){
			var $this = $(this);
			var $currentGroup = $this.closest('.the1_radio_group');
			
			$currentGroup.find('.the1_radio_trigger').removeClass('active');
			$this.addClass('active');
		});
	}



// SORTABLE OPTIONS
		function SORT_sortables(){
			
			/*store lists on variable*/
			var $sortables = $('.SORT-wrapper').not('.loaded');
			$sortables.addClass('loaded');

			/*make lists sortable*/
			$sortables.each(function(){
				var $wrapper = $(this);
				$wrapper.find('.SORT-list').sortable({
					handle: '.grip',
					update: function(){ 
								updateSortArray( $wrapper ); 
							}
				});
			});

			/*add new list item*/
			$sortables.find('.SORT-add').on( 'click', function(e){
				e.preventDefault();
				var $wrapper 	= $(this).closest('.SORT-wrapper');
				var wrapperData = $wrapper.data();
				var newItemType = false;
				if ( $(this).attr('data-itemtype') ) newItemType = $(this).data().itemtype;
				console.log(newItemType);
				var $sortArray	= $wrapper.find('.SORT-array');
				
				var sortString	= $sortArray.val();
				var sortArray 	= sortString.split(',');
				var newNumber;
				
				//find lowest available number: from 0-9
				for ( i=0; i<10; i++ ){
					if ( $.inArray( i.toString(), sortArray ) < 0 ) {
						newNumber = i;
						break;
					}
					if ( i == 9 ){ return; }
				}
				//prepare data for new list item
				var data = {
						SORTadd: 1,
						action: 'sortable_ajaxadd',
						name: $wrapper.attr('id'),
						type: wrapperData.type,
						number: newNumber
					};
				//request for new list item: option-components.php
				$.post( ajaxurl, data, function(response) {
					$wrapper.find('.SORT-list').append(response);
					updateSortArray($wrapper);
					var newItemHead = $wrapper.find('.SORT-item-head').last();
					if ( newItemHead.has('.socialdd').length ){
						newItemHead.find('.socialdd').outside('click', function(){
							$(this).find('.socialdd-list').hide();
						});
					}
					if ( newItemHead.has('.expand').length ){
						newItemHead.find('.expand').click();
					} else {
						setTimeout(function(){newItemHead.removeClass('NEWITEM');},500);
					}
				});
			});
			
			/*delete list item*/
			$sortables.on( 'click', '.SORT-item-head .delete', function(){
				var $this	 = $(this);
				var $item	 = $this.closest('.SORT-item');
				var $wrapper = $item.closest('.SORT-wrapper');
				$item.remove();
				updateSortArray($wrapper);
			});

			/*list item edit mode: OPEN*/
			$sortables.on( 'click', '.SORT-item-head .expand', function(){
				var $this	= $(this);
				var $layer 	= $this.closest('.SORT-wrapper').find('.SORT-overlayer');
				var $item	= $this.closest('.SORT-item');
				
				//$('body').css('overflow','hidden');
				$layer.fadeIn(200);
				$item.find('.SORT-item-body').slideDown(150);
			});
			
			/*list item edit mode: CLOSE*/
			$sortables.on( 'click', '.updateitem, .SORT-overlayer', function(e){
				e.preventDefault();
				var $this	= $(this);
				var $wrapper= $this.closest('.SORT-wrapper');
				var $body	= $wrapper.find('.SORT-item-body');
				var $layer	= $wrapper.find('.SORT-overlayer');
				
				$('body').css('overflow','auto');
				$layer.fadeOut(200);
				$body.slideUp(150);
			});

			
			
		}
		
		/*set sorting order in an array*/
		function updateSortArray($wrapper){
			var baseID 		= $wrapper.attr('id');
			var $arrayForm	= $wrapper.find('.SORT-array');
			var $list		= $wrapper.find('.SORT-list');
			var $items		= $list.children('.SORT-item');
			
			var tempArray 	= Array();
			
			if( $items.length > 0 ){
				$items.each(function(){
					var itemID = $(this).attr('id');
					var itemNumber = itemID.replace( 'SORT-ITEM-'+baseID+'-', '' );
					tempArray.push(itemNumber);
				});
			}
			$arrayForm.val( tempArray.join(',') );
			unsavedOptions_set();
			if ( tempArray.length > 0 ){
				$list.find('li.noitems').remove();
			} else {
				$list.html('<li class="noitems">No items available!</li>');
			}
		}
		


// COLOR PICKERS
		function colorPicker(){
			/* wp-color-picker */
			$CPs = $('.CP').not('.loaded');
			$CPs.addClass('loaded');
			if ( $CPs.length ){
				$CPs.each(function(){
					var $this = $(this);
					var defaultValue = $this.val();
					var CPoptions = {
							//defaultColor: defaultValue,
							change: function(event,ui){
								var $this = $(this);
								var $wrapper = $this.closest('.font-option-wrapper');
								if ( $wrapper.length > 0 ) {
									var ID = $this.attr('id');
									// console.log('ajdija:'+ID);
									$wrapper.find('.font-preview').css( "color", ui.color.toString());
									$( '.child-of-' + ID ).find('.font-preview').css( "color", ui.color.toString());
									unsavedOptions_set();
								}
							}
						};
					$this.wpColorPicker(CPoptions);
				});
			}
			/* my-color-palette-picker */
			var $paletteForm = $('.the1-palette-container').not('.loaded');
			$paletteForm.addClass('loaded');
			$paletteForm.find('.the1-palette-result').on( 'click', function(){
				var $this = $(this);
				var $wrapper = $this.parent();
				var $palette = $wrapper.find('.the1-palette-holder');
				$palette.show();
				$this.addClass('wp-picker-open');
			});
			$paletteForm.find('.the1-palette-item').on( 'click', function(){
				var $this = $(this);
				var data = $this.data();
				var $wrapper = $this.closest('.the1-palette-container');
				
				$wrapper.find('.the1-palette-result').css('background-color', data.colorcode);
				$wrapper.find('.CP-colorname').val(data.colorname);
				$wrapper.find('.CP-colorcode').val(data.colorcode);

				unsavedOptions_set();
				
			});
			$paletteForm.each(function(){
				var $this = $(this);
				$this.outside( 'click', function(){
					$this.find('.the1-palette-holder').hide();
					$this.find('.the1-palette-result').removeClass('wp-picker-open');
				});
			});
		}



// SOCIAL ICONS DROPDOWN
	function socialIconsDD(){
		var $wrapper = $('#SORT-LIST-socialprofiles').not('.loaded');
		$wrapper.addClass('loaded');
		//show list
		$wrapper.on('click', '.socialdd-icon', function(){
			var $this = $(this);
			var $list = $this.next('.socialdd-list');
			if ( $list.attr('display') !== 'block' ){
				$list.show();
			}
		});
		//assign value and close list
		$wrapper.on('click', '.socialdd-list a', function(){
			var $this = $(this);
			var value = $this.data().value;
			var $wrapper = $this.closest('.socialdd');
			
			$wrapper.find('.socialdd-icon').attr('class','socialdd-icon '+value);
			$wrapper.find('.socialdd-input').val(value);
			$wrapper.find('.socialdd-list').hide();/**/
			unsavedOptions_set();

		});
		//close list when clicked outside of it
		$wrapper.find('.socialdd').outside('click', function(){
			$(this).find('.socialdd-list').hide();
		});
	}



// SLIDER_ui()
		function SLIDER_ui(){
			var $sliders = $('.SLIDER-wrapper').not('.loaded');
			$sliders.addClass('loaded');
			
			$sliders.each(function(){
								   
				var $wrapper = $(this);
				var $sl = $wrapper.find('.SLIDER');
				var $slVal = $wrapper.find('.SLIDER-value');
				var $slValDisplay = $wrapper.find('.SLIDER-displayvalue');
				
				var dataset = $sl.data();
				
				var units = ( dataset.units ? dataset.units : 'px' );
				
				var initValue = $slVal.val();
				$sl.slider({
					orientation: ( dataset.orientation ? dataset.orientation : "horizontal" ),
					range: ( dataset.range ? dataset.range : 'min' ),
					min: ( dataset.min ? dataset.min : 0 ),
					max: ( dataset.max ? dataset.max : 100 ),
					slide: function(){
						var newVal = $sl.slider('value');
						$slValDisplay.html(newVal+units);
						$slVal.val(newVal);
						unsavedOptions_set();
					},
					change: function(){
						var newVal = $sl.slider('value');
						$slValDisplay.html(newVal+units);
						$slVal.val(newVal);
					}
				});
				$sl.slider( "value", initValue );
				
			});
			
		}		
		
		
		
		
//******************************************************************************************************** IMAGE/PATTERN SELECTOR
		function IS_imageSelector(){
			var $IS_wrappers = $('.IS-wrapper');
			
			/*initialize selected*/
			$IS_wrappers.find('.IS-selected').each(function(){
				var $this	= $(this);
				var orderNr	= $this.val();
				var $target	= $this.closest('.IS-section').find('.IS-patt').eq(orderNr);
				
				$target.addClass('active');
			});
			
			/*select new pattern*/
			$IS_wrappers.find('.IS-patt').on( 'click', function(){
				var $this 		= $(this);
				var $section 	= $this.closest('.IS-section');
				var $input		= $section.find('.IS-input');
				var $selected	= $section.find('.IS-selected');
				var data 		= $this.data();
				$input.val(data.patt);
				$selected.val(data.nr);
				
				$section.find('.IS-patt').removeClass('active');
				$this.addClass('active');
				return false;
			});
		}
		function images_selector(){
			$('.IS-image').click(
				function(){
					isWrap = $(this).closest('.IS-wrap');
					isValue = $(this).attr('href');
					$('.IS-value', isWrap).val(isValue);
					$('.IS-image.active', isWrap).removeClass('active');
					$(this).addClass('active');
					return false;
				}
			)
		}


// FONT SELECTOR
		function initFontSelector(){
			var $FONTTOOL = $('.font-option-wrapper').not('.loaded');

			fontSwitcher();
			fontSizeSwitcher();
			fontSpacingSwitcher();
			fontWeightSwitcher();
			fontTransformSwitcher();

			$FONTTOOL.addClass('loaded');

			function fontSwitcher(){
				$FONTTOOL.find('select.font-switcher').on( 'change', function(){
					var $this = $(this);
					var ID = $this.attr('id'); //looks like this: font-family-OPTION
					var value = $this.val();
					
					$this.parent().find('.font-preview').css( 'font-family', value );
					$('.child-of-'+ID).find('.font-preview').css( 'font-family', value );
					
					updateFontsQuery(ID);
				});
			}
			function fontSizeSwitcher(){
				$FONTTOOL.find('.font-size-switcher').on( 'change', function(){
					var $this = $(this);
					var newValue = $this.val();
					
					var $wrap = $this.closest('.font-option-wrapper');
					$wrap.find( '.font-preview' ).css( 'font-size', newValue+'px' );
					$( '.child-of-'+$this.attr('id') ).find( '.font-preview' ).css( 'font-size', newValue+'px' );
				});
			}
			function fontSpacingSwitcher(){
				$FONTTOOL.find('.font-spacing-switcher').on( 'change', function(){
					var $this = $(this);
					var newValue = $this.val();
					
					var $wrap = $this.closest('.font-option-wrapper');
					$wrap.find( '.font-preview' ).css( 'letter-spacing', newValue+'em' );
					$( '.child-of-'+$this.attr('id') ).find( '.font-preview' ).css( 'letter-spacing', newValue+'em' );
				});
			}
			function fontWeightSwitcher(){
				$FONTTOOL.find('.font-weight-switcher').on( 'change', function(){
					var $this = $(this);
					var newValue = $this.val();
					
					var $wrap = $this.closest('.font-option-wrapper');
					$wrap.find( '.font-preview' ).css( 'font-weight', newValue );
					$( '.child-of-'+$this.attr('id') ).find( '.font-preview' ).css( 'font-weight', newValue );
				});
			}
			function fontTransformSwitcher(){
				$FONTTOOL.find('.font-transform-switcher').on( 'change', function(){
					var $this = $(this);
					var newValue = $this.val();
					
					var $wrap = $this.closest('.font-option-wrapper');
					$wrap.find( '.font-preview' ).css( 'text-transform', newValue );
					$( '.child-of-'+$this.attr('id') ).find( '.font-preview' ).css( 'text-transform', newValue );
				});
			}
		}


		function updateFontsQuery(ID){
			var font = $('#'+ID).val();
			$.ajax({
				type : "post",
				url : ajaxurl,
				data : { action: "the1_google_font_switch", fontdata: font },
				success: function(response) {
 					var response = JSON.parse(response);
					$('#the1-'+ID).attr( 'href', response.query );
					
					var $weight = $('#'+ID.replace('family','weight'));
					var allWeights = response.font.variants;
					$weight.find('option').remove();
					$.each( allWeights, function(i,j){
						var selected = ' selected="selected" ';
						if ( j !== 'normal' ) { selected = ''; }
						var option = '<option '+selected+' value="'+j+'">'+j+'</option>';
						$weight.append(option);
					});

					var $preview = $('#'+ID+'-preview');
					$preview.css('font-weight','normal');
				}
			});		
		 }


// DYNAMIC TITLE TYPING
		function remoteChanges(){
			dynamicTyping();
			dynamicSelect();
			dynamicSelectSocial();
			compSwitch();
			bgImgSwitch();
		}
		function dynamicTyping(){
			$('#the1panel').on( 'keyup', '.dynamictyping', function(){
				var $this = $(this);
				var id = $this.attr('id');
				var target = 'typr-'+id;
				$('#'+target+', .'+target).html($this.val());
			});
		}
		function dynamicSelect(){
			$('#the1panel').on( 'change', '.dynamicselect', function(){
				var $this = $(this);
				var id = $this.attr('id');
				var target = 'selectr-'+id;
				$('#'+target).html( $this.find('option:selected').text() );
			});
		}
		function dynamicSelectSocial(){
			$('#the1panel').on( 'change', '.dynamicselect-social', function(){
				var $this = $(this);
				var id = $this.attr('id');
				var target = 'selectr-'+id;
				$('#'+target).children('div').attr( 'class', $this.val() );
			});
		}
		function compSwitch(){
			$('select.comp-switch').each(function(){
				var $this = $(this);
				var $wrapper = $this.parent().parent();
				var value = $this.val();
				
				var $components = $wrapper.find('div.comp');
				$components.hide().filter('.comp-'+value).show();
			});
			$('#the1panel').on('change load','select.comp-switch',function(){
				var $this = $(this);
				var $wrapper = $this.parent().parent();
				var value = $this.val();
				
				var $components = $wrapper.find('div.comp');
				$components.hide().filter('.comp-'+value).show();
			});
		}
		function bgImgSwitch(){
			$('#the1panel').on('click','input.bg-section-use',function(){
				var $this = $(this);
				var $wrapper = $this.parent().parent();
				var $bgoptions = $wrapper.find('div.bg-section-opts');
				if ( $this.is(':checked') ){
					$bgoptions.show();
				} else {
					$bgoptions.hide();
				}
			});
		}


// GO TO PAGE: enables linking directly to specific option page
		function goToPageInit(){
			var $field = $('#goToPage');

			function goToPage(){
				if ( $field.length < 1 ) return false;

				var add = $field.val();
				if ( !add ) return false;

				add = add.split(',');

				var tabIndex = ( (add[0]-1) < 0 ? 0 : (add[0]-1) );
				var navIndex = ( (add[1]-1) < 0 ? 0 : (add[1]-1) );

				var $tabs = $('.the1panel-tab');

				if ( $tabs.length < tabIndex+1 ) return false;	

				var $tab = $('.the1panel-tab').eq(tabIndex);
				var $tabContent = $('.the1panel-tabcontent').filter( '.'+$tab.data().tabcontent );
				var $navitem = $tabContent.find('.the1panel__navigation').find('a').eq(navIndex);

				$tab.click();
				$navitem.click();
			}

			$('.the1panel .goToPage').on('click', function(){
				$field.val( $(this).data().gotopage );
				goToPage();
			});

			goToPage();

		}


// TABS: primary tabs
		function mainTabs(){
			var $tabs = $('.the1panel-tab');
			mainTabsAction();					
			
			/* marks the clicked nav item as "active" */
			$tabs.on( 'click', function(){
				var $this = $(this);
				if ( !$this.hasClass('active') ) {
					$tabs.removeClass('active');
					$this.addClass('active');
					mainTabsAction();					
				}
			});

			/* detects the "active" nav item and loads the apropriate options page */
			function mainTabsAction(){
				var $activeTabs = $tabs.filter('.active');
				if ( $activeTabs.length > 0 ){
					var $activeTab = $activeTabs.eq(0);
					var page = $activeTab.data().tabcontent;
					$( '.the1panel .the1panel-tabcontent' ).hide().filter('.'+page).show();
				} else {
					var $activeTab = $tabs.eq(0);
					$activeTab.addClass('active');
					var page = $activeTab.data().tabcontent;
					$( '.the1panel .the1panel-tabcontent' ).hide().filter('.'+page).show();
				}
			}
		}
		

// NAVIGATION: secondary tabs
		function mainNavigation(){
			var $menus = $('.the1panel__navigation').not('.loaded');
			$menus.addClass('loaded');

			var $links = $menus.find('a');
			mainNavigationAction();					
			
			/* marks the clicked nav item as "active" */
			$links.on( 'click', function(){
				var $this = $(this);
				var $navWrapper = $this.closest('.the1panel__navigation');
				var $contentWrapper = $this.closest('.the1panel-tabcontent').find('.options-pages');
				if ( !$this.hasClass('active') ) {
					$navWrapper.find('a').removeClass('active');
					$this.addClass('active');
					$contentWrapper.find('.page').hide().filter('.'+$this.data().page).show();
				}
			});

			/* detects the "active" nav item and loads the apropriate options page */
			function mainNavigationAction(){
				var $activeLinks = $links.filter('.active');
				if ( $activeLinks.length > 0 ){
					$activeLinks.each(function(){
						var $this = $(this);
						var page = $this.data().page;
						var $contentWrapper = $this.closest('.the1panel-tabcontent').find('.options-pages');
						$contentWrapper.find('.page').hide().filter('.'+page).show();
					});
				}
			}
		}
		

// UPLOAD MEDIA
		function mediaUploader(){
			
			var custom_file_frame;	// uploading files variable
			var myUploader = {};	// data for the active uploader

			$('.the1panel').on('click','.the1-upload-remove', function(e){
				var $option = $(this).closest('.the1-upload-field-wrapper');
				$option.find('input.the1-upload-field').val('');
				$option.find('input.the1-upload-field-thumb').val('');
				$option.find('.the1-upload-thumbinner').html('');
				unsavedOptions_set();
			});
			
			$('.the1panel').on('click','.the1-upload-btn',function(e){	
				e.preventDefault();
				
				/* If the frame already exists, reopen it */
				if ( typeof(custom_file_frame) !== "undefined" ) { custom_file_frame.close(); }

				var $this = $(this);

				myUploader = $this.data();
				var up_title = 		( myUploader.title ? myUploader.title : 'Image Uploader' );
				var up_type = 		( myUploader.type ? myUploader.type : 'image' );
				var up_buttontext =	( myUploader.buttontext ? myUploader.buttontext : 'Insert Image' );
				var up_multiple = 	( myUploader.multiple == true ? true : false );
				
				/* Create WP media frame */
				custom_file_frame = wp.media.frames.customHeader = wp.media({
					title: up_title,					// title of media manager frame
					library: { type: up_type },			// media type (image, audio, video, ...)
					button: { text: up_buttontext },	// button text
					multiple: up_multiple				// multiple files to be uploaded (boolean)
				});


				/* Callback for selected image */
				custom_file_frame.on( 'select', function(){
					var attachment = custom_file_frame.state().get('selection').toJSON();
					
					//console.log(attachment); //selected gallery item [object]
					
					/* if: SLIDES MANAGER */
					var $option = $this.closest('.the1-upload-field-wrapper');
					$option.find('input.the1-upload-field').val(attachment[0].url);
					$option.find('input.the1-upload-field-thumb').val(attachment[0].url);
					$option.find('.the1-upload-thumbinner').html( '<img src="'+attachment[0].url+'"/>' );
					unsavedOptions_set();
					
					//$targetId.val(attachment[0].id);
					//$targetThumb.val(attachment[0].url);
					//$targetUrl.val(attachment[0].url);
					//$targetType.val(attachment[0].type);
					//$targetPreview.css('background-image', 'url('+attachment[0].url+')');
					return false;
				});
		 
				/* Open modal */
				custom_file_frame.open();
			});
		}


// IMPORT EXPORT THEME SETTINGS
		function importExportThemeSettings(){
			
			$('#SAVEFILE').on( 'click', function(){
				$.ajax({
					type : "post",
					url : ajaxurl,
					data : { action: "savefile_fisniq" },
					success: function(response) {
					}
				});
				return false;	
			});
			
			$('#EXPORT').on( 'click', function(){
				var dataToPost = { action: "the1_export_settings" };
				var fileEmpty = true;
				if (  $('#export__general').is(':checked')  ) { dataToPost.ex_general = 1; fileEmpty = false; }
				if (  $('#export__style').is(':checked')  ) { dataToPost.ex_style = 1; fileEmpty = false; }
				if (  $('#export__presets').is(':checked')  ) { dataToPost.ex_presets = 1; fileEmpty = false; }
				
				if ( fileEmpty === true ) {
					alert('No settings have been chosen to be exported!');
					return false;
				}
				
				overlayer('<div id="msg-processing">Creating Export File...</div>');
				
				$.ajax({
					type : "post",
					url : ajaxurl,
					data : dataToPost,
					success: function(response) {
						console.log(response);
						
						var html = '<a class="clsOverlayer" style="color:#fff;" href="'+response+'" download="themes1_theme_settings.txt">Download File</a>';
							html += '<br />';
							html += '<a href="javascript:void(0);" class="clsOverlayer">close</a>';
						$('#msg-processing').html(html).show();
						
						$('.clsOverlayer').on('click',function(){closeOverlayer();});
						
						//$('#msg-processing').delay(1000).fadeOut(200, function(){closeOverlayer();});
						
					}
				});
				return false;	
			});
			
			$('#import-settings-filebrowser').on('change',function(){
				if ( !$(this).val() ) {
					$('#cont-file-name').text('No file chosen');
				} else {
					var fileName = $(this).val();
					fileName = fileName.replace('C:\\fakepath\\','');
					$('#cont-file-name').text(fileName);
					//alert( $(this).val() );
				}
			});
			$('#cont-submit-btn').on('click', function(){
				if ( $('#import-settings-filebrowser').val() ){
					//alert('submitted');
					$(this).closest('form').submit();
				}
			});
			
			var $importMessages = $('.import-msg');
			if ( $importMessages.length > 0 ){
				overlayer('<div id="msg-processing">'+$importMessages.eq(0).html()+'</div>');
				$('#msg-processing').delay(3000).fadeOut(200, function(){closeOverlayer();});
			}
			
		}
		

// IMPORT DUMMY DATA
		function importDemoData(){
			
			$('.import-demo-data').on( 'click', function(){
				
				if ( !confirm('Doing this will lose any existing theme settings!\n\nIMPORTANT - This may take a while to complete, but do not cancel the process as it may result on a messy installation.\n\nContinue?') ) return false;
				
				var demoversion = $(this).data().demo;
				var msgPending = 	'<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;';
					msgPending += 	'Importing "'+demoversion+'" demo content and settings...<br/><br/><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>IMPORTANT</strong> - This may take a while, but do not cancel the process as it may result on a messy installation</em>';
				
				$('#import-dummy-data-results').html(msgPending);
								
				var data = { 
					action: 'mnml_importer',
					demo: demoversion
				};
				$.post( ajaxurl, data, function(response){
					$('#import-dummy-data-results').html(response);
				});
				
			});
			
		}


// CUSTOM OVERLAY LAYER
		function overlayer(form){
			$('body').append('<div id="overlayer"><div id="overlayer-msg">'+form+'</div></div>');
		}
		function closeOverlayer(){
			$('#overlayer').remove();
		}





})(jQuery);


/* jquery plugin to close elements when click outside of it */
(function($){
	if ( !$.fn.outside ){ 
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
}(jQuery));




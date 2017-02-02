<?php


###		BASIC OPTION WRAPPER CLASS
		if ( !class_exists('mnml_optioncomponent') ) 
		{
			class mnml_optioncomponent
			{
				public $name;			//option "name" and "id" attribute
				public $title;			//title
				public $description;	//description
				public $wrapper_id;		//id attribute of the option wrapper
				public $form_html;		//the html of the option form
				public $echo;			//print or return the results: true if yes
				public $before;			//insert HTML before element
				public $after;			//insert HTML after element


				function __construct( $name, $args = false )
				{	
					$this->name = $name;		//set name
					$this->setup_Data($args);	//set data
					$this->setup_Form_html();	//setup html of the option form
					$this->output();
				}
				
				/*Setup option data*/
				function setup_Data($args)
				{
					$this->title			= ( isset( $args['title'] ) ? $args['title'] : 'Default Title' );
					$this->description		= ( isset( $args['desc'] ) ? $args['desc'] : false );
					$this->wrapper_id		= $this->name;
					$this->echo				= ( isset( $args['echo'] ) ? $args['echo'] : true );
					$this->before			= ( isset( $args['before'] ) ? $args['before'] : '' );
					$this->after			= ( isset( $args['after'] ) ? $args['after'] : '' );
					$this->form_html		= ( isset( $args['html'] ) ? $args['html'] : false );
				}
		
				/*HTML for the header*/
				function setup_Header_html()
				{
					$header =	'<div class="option-header">' .
									( $this->title ? '<div class="title">' . $this->title . '</div>' : '' ) .
									( $this->description ? '<div class="explanation">'.$this->description.'</div>' : '' ) .
								'</div>';
					return $header;
				}

				/*HTML for the form*/
				function setup_Form_html()
				{
					$this->form_html = ( $this->form_html ? $this->form_html : 'this is the RAW html of the form!' );
				}
				
				/*Completed HTML output*/
				function output()
				{
					$before	= 	'<div class="single-option" id="'. esc_attr('optID-'.$this->wrapper_id) .'">';
					$after	= 	'<div class="clear"></div></div>';
					
					$header =	$this->setup_Header_html();
					$form 	=	'<div class="element">' . $this->before.$this->form_html.$this->after . '</div>';
										
					$output =	$before .
									$header .
									$form .
								$after;
					
					if( $this->echo ){
						echo $output;
					} else {
						return $output;
					}
				}
				
			}
		}




/*-------------------------------------
 *		Specific options wrappers
 *------------------------------------------*/


###		UPLOAD FIELD
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_upload') ){
		class mnml_optioncomponent_upload extends mnml_optioncomponent
		{
			/*HTML for the form*/
			function setup_Form_html()
			{
				$opt_image = mnml_themeoption($this->name, 'attr');
				$opt_thumb = ( mnml_themeoption($this->name.'-thumb') ? mnml_themeoption($this->name.'-thumb', 'attr') : $opt_image );

				$html =	'<div class="the1-upload-field-wrapper">' .
							'<input type="hidden" name="'. esc_attr($this->name) .'" value="'.$opt_image.'" class="upload-field the1-upload-field" />' .
							'<input type="hidden" name="'.esc_attr($this->name).'-thumb" value="'.$opt_thumb.'" class="the1-upload-field-thumb" />' .
							'<div style="line-height:0;">' .
								'<div class="the1-upload-thumb">' . 
									'<div class="the1-upload-thumbinner">' . ( $opt_thumb ? '<img src="'.$opt_thumb.'"/>' : '' ) . '</div>' .
									'<div class="the1-upload-remove"></div>' .
								'</div>' .
							'</div>' .
							'<a href="javascript:void(0);" class="the1-btn2 the1-upload-btn">+ Add Image</a>' .
						'</div>';
				
				$this->form_html = $html;
			}
		}
		}


###		INPUT TEXT
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_inputtext') ){
		class mnml_optioncomponent_inputtext extends mnml_optioncomponent
		{
			/*HTML for the form*/
			function setup_Form_html()
			{
				$html =	'<input type="text" name="'. esc_attr($this->name) .'" value="'.mnml_themeoption($this->name, 'attr').'"/>';
				
				$this->form_html = $html;
			}
		}
		}


###		CHECKBOX
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_checkbox') ){
		class mnml_optioncomponent_checkbox extends mnml_optioncomponent
		{
			public $label;

			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->label = ( isset( $args['label'] ) ? $args['label'] : '' );
			}
		  
			/*HTML for the form*/
			function setup_Form_html()
			{
				$this->form_html = mnml_optioncomponent_checkbox( $this->name ) . '<label for="'.$this->name.'">' . $this->label . '</label>';
			}
		}
		}


###		TEXTAREA
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_textarea') ){
		class mnml_optioncomponent_textarea extends mnml_optioncomponent
		{
			/*HTML for the form*/
			function setup_Form_html()
			{
				$html =	'<textarea name="'. esc_attr($this->name) .'">'.mnml_themeoption($this->name,'textarea').'</textarea>';
				
				$this->form_html = $html;
			}
		}
		}


###		COLOR PICKER
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_color') ){
		class mnml_optioncomponent_color extends mnml_optioncomponent
		{
			public $palette;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->palette = ( isset( $args['palette'] ) ? $args['palette'] : false );
			}
			
			/*HTML for the form*/
			function setup_Form_html()
			{
				if ( $this->palette ){
					$html = mnml_optioncomponent_color( $this->name, array('palette'=>$this->palette) );
				} else {
					$html = mnml_optioncomponent_color( $this->name );
				}
				
				$this->form_html = $html;
			}
			
		}
		}


###		FONT SELECTOR
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_font') ){
		class mnml_optioncomponent_font extends mnml_optioncomponent
		{
			public $sample_text;
			public $parent_font;
			public $components;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->sample_text		= ( isset( $args['sampletext'] ) ? $args['sampletext'] : false );
				$this->components		= ( isset( $args['comp'] ) && is_array( $args['comp'] ) && !empty( $args['comp'] ) ? $args['comp'] : false );
				$this->parent_font		= ( isset( $args['parent'] ) ? $args['parent'] : false );
				$this->wrapper_id		= 'font-'.$this->name;
			}
			
			/*HTML for the form*/
			function setup_Form_html()
			{
				$opts = array(
					'sampletext' => $this->sample_text,
					'parent' => $this->parent_font,
					'comp' => $this->components,
				);
				$html = mnml_optioncomponent_font( $this->name, $opts );
				
				$this->form_html = $html;
			}
			
		}
		}


###		IMAGE/PATTERN SELECTOR
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_imageselector') ){
		class mnml_optioncomponent_imageselector extends mnml_optioncomponent
		{
			public $skins;
			public $active;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->skins	= ( isset( $args['skins'] ) ? $args['skins'] : false );
				$this->active	= ( isset( $args['active'] ) ? $args['active'] : false );
			}
			
			/*HTML for the form*/
			function setup_Form_html()
			{
				$opts = array(
					'skins' => $this->skins,
					'active' => $this->active,
				);
				$html = mnml_optioncomponent_imageselector( $this->name, $opts );
				
				$this->form_html = $html;
			}
			
		}
		}


###		SORTABLE
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_sortable') ){
		class mnml_optioncomponent_sortable extends mnml_optioncomponent
		{
			public $type;
			public $noitems;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->type	= ( isset( $args['type'] ) ? $args['type'] : false );
				$this->noitems	= ( isset( $args['noitems'] ) ? $args['noitems'] : false );
			}
			
			/*HTML for the form*/
			function setup_Form_html()
			{
				$html = mnml_optioncomponent_sortable( $this->name, array( 'type' => $this->type, 'noitems' => $this->noitems ) );
				
				$this->form_html = $html;
			}
			
		}
		}


###		IMAGE - GALLERY
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_gallery') ){
		class mnml_optioncomponent_gallery extends mnml_optioncomponent
		{
			public $type;
			public $noitems;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->type	= ( isset( $args['type'] ) ? $args['type'] : false );
				$this->noitems	= ( isset( $args['noitems'] ) ? $args['noitems'] : false );
			}
			
			/*HTML for the form*/
			function setup_Form_html()
			{
				$html = mnml_optioncomponent_gallery( $this->name, array( 'type' => $this->type, 'noitems' => $this->noitems ) );
				
				$this->form_html = $html;
			}
			
		}
		}


###		TWITTER FEED INFO
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_twitterfeed') ){
		class mnml_optioncomponent_twitterfeed extends mnml_optioncomponent
		{				
			/*HTML for the form*/
			function setup_Form_html()
			{
				$html = mnml_optioncomponent_twitterfeed();
				
				$this->form_html = $html;
			}
			
		}
		}


###		CUSTOM HTML
#		[ extended from BASIC OPTION FORM ]
#
		if ( !class_exists('mnml_optioncomponent_custom') ){
		class mnml_optioncomponent_custom extends mnml_optioncomponent
		{
			public $form_html;
			
			function setup_Data($args)
			{
				parent::setup_Data($args);
				$this->form_html = ( isset( $args['html'] ) ? $args['html'] : 'There is no html' );
			}
			
		}
		}


?>
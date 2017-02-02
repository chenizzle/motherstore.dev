<?php function mnml_options_page(){
	
	$theme_name = mnml_themeinfo('name');
	$theme_version = mnml_themeinfo('version');
	$theme_documentation_URL = 'http://themes1.com/files/themes/Mnml/documentation/';

	if ( isset($_GET['nav']) && $_GET['nav'] ){
		echo '<input type="hidden" id="goToPage" value="'.esc_attr($_GET['nav']).'"/>';
	}
	?>



<div id="the1panel" class="the1panel">
	<div class="the1panel__inner">


		<div class="the1panel__top clearfix">

			<!-- Logo and info -->
	    	<div class="the1panel__header">
	            <div class="panel-loading"><i class="fa fa-refresh fa-spin" style="font-size:21px;"></i></div>
	        	<div class="logo"></div>
	            <div class="info georgia">
	            Theme name: <?php echo esc_attr($theme_name);?><br />
	            Version: <?php echo esc_attr($theme_version);?><br />
	            </div>
	        </div>

	        <!-- Header Links -->
	        <div class="the1panel__links georgia">
	            <!-- &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; -->
	            <a href="<?php echo esc_url($theme_documentation_URL);?>" target="_blank"><i class="fa fa-align-left"></i>&nbsp;&nbsp;Theme Documentation</a>
	        </div>

	        <!-- Tabs: Navigation -->
	        <div class="the1panel__tabs">
	        	<div class="the1panel-tab" data-tabcontent="tab-general"><i class="fa fa-sliders"></i>&nbsp;&nbsp;General</div>
	        	<div class="the1panel-tab" data-tabcontent="tab-styling"><i class="fa fa-paint-brush"></i>&nbsp;&nbsp;Styling</div>
	        	<div class="the1panel-tab" data-tabcontent="tab-importexport"><i class="fa fa-arrow-circle-o-down"></i>&nbsp;&nbsp;Import/Export Options</div>
	        	<div class="the1panel-tab" data-tabcontent="tab-oneclick"><i class="fa fa-hand-o-up"></i>&nbsp;&nbsp;One-click setup</div>
	        </div>

		</div>


		<!-- Tabs: Content -->
	    <div class="the1panel-tabcontent clearfix tab-general" id="tab-general"><?php mnml_options_page__general(); ?></div>
	    <div class="the1panel-tabcontent clearfix tab-styling" id="tab-styling"><?php mnml_options_page__styling(); ?></div>
	    <div class="the1panel-tabcontent clearfix tab-importexport" id="tab-importexport"><?php mnml_options_page__importexport(); ?></div>
	    <div class="the1panel-tabcontent clearfix tab-oneclick" id="tab-oneclick"><?php mnml_options_page__oneclickdemo(); ?></div>




	</div>
</div><!--.the1-panel-wrap-->



<?php } ?>
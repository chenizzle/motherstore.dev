<?php function mnml_options_page__oneclickdemo(){ ?>


	<!-- Navigation -->
    <ul class="the1panel__navigation">
    	<li class="nav-section georgia">General</li>
        <li><a data-page="pg-importer" href="#" class="active">Import Dummy Data</a></li>            
    </ul>
    

    <div class="the1panel-right">
    
        <div class="options-pages">
                <!-- PAGE: pick skin -->
                <div class="page pg-importer" style="display:block;">
                    <?php 
                        $ex_the1 = ( function_exists('the1_slider_cpt') ? true : false );
                        
                        if ( $ex_the1 ){
                            ?>
                            <div id="import-dummy-data-results">
                                <a href="#" class="the1-btn import-demo-data" data-demo="default"><span>Import MNML demo content</span></a>
                            </div>
                            <?php   
                        } else {
                            esc_html_e('You need to activate Themes1 Mnml Plugin to import the dummy data','mnml-shop');
                        }
                        
                    ?>
                </div>
        </div><!--.options-pages-->
        
        
        <div class="options-foot">
            <div class="clear"></div>
        </div>
    </div><!--.wrap-right-->
    



<?php } ?>
<?php function mnml_options_page__importexport(){ ?>


    <!-- navigation -->
    <ul class="the1panel__navigation">
    	<li class="nav-section georgia"><?php esc_html_e('Manage Settings','mnml-shop');?></li>
        <li><a data-page="pg-import" href="#" class="active"><?php esc_html_e('Import','mnml-shop');?></a></li>            
        <li><a data-page="pg-export" href="#"><?php esc_html_e('Export','mnml-shop');?></a></li>            
    </ul>
    

        <div class="the1panel-right">
        
            <div class="options-pages">
            
                    <!-- PAGE: export -->
                    <div class="page pg-export">
                    
                    	<div class="single-option" style="border: none;">
                        		
                                <div class="title"><?php esc_html_e('Export Theme Settings','mnml-shop');?></div>
                                
                                <div class="explanation"><?php esc_html_e('"Check" the settings you want to export.','mnml-shop');?></div>
                                <br />
                                
                                <div style="padding:20px; background:#f4f4f4;">
                                    <label style="display:inline-block;">
                                        <input type="checkbox" id="export__general"/>
                                        <span style="display:inline-block;width: 70px;"><?php esc_html_e('General','mnml-shop');?></span>
                                        <span class="explanation"><em>- Covers all options set under <strong>Mnml - Theme Options > General</strong></em></span>
                                    </label>
                                    <br /><br />
                                    <label style="display:inline-block;">
                                        <input type="checkbox" id="export__style"/>
                                        <span style="display:inline-block;width: 70px;"><?php esc_html_e('Style','mnml-shop');?></span>
                                        <span class="explanation"><em>- Covers all options set under <strong>Mnml - Theme Options > Styling</strong></em></span>
                                    </label>
                                    <br /><br />
                                    <br /><hr style="margin:20px 0 17px;" />
                                    <a href="javascript:void(0);" class="the1-btn" id="EXPORT">
                                        <i class="fa fa-arrow-circle-up"></i>&nbsp;&nbsp;
                                        <?php esc_html_e('Export Settings','mnml-shop');?>
                                    </a>
                                </div>
                                <br />
                        </div>
                        
                    </div>

                    <!-- PAGE: import -->
                    <div class="page pg-import" style="display:block;">
                    
                        <div class="single-option" style="border: none;">
                        	<div class="title"><?php esc_html_e('Import Theme Settings','mnml-shop');?></div>
                            <div class="explanation"><?php esc_html_e('Import themes settings from a file','mnml-shop');?></div>
                            <br />
							<?php
							if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
								$uploaddir = get_template_directory().'/core/temp/';
								$uploadfile = $uploaddir . basename( $_FILES['userfile']['name'] );
								if ( move_uploaded_file( $_FILES['userfile']['tmp_name'], $uploadfile) ) {
									if ( $_FILES['userfile']['type'] === 'text/plain' ){
										echo mnml_import_theme_options( $uploadfile );
									} else {
										echo	'<span class="import-msg import-note">' .
													'<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;&nbsp;' .
													esc_html__( 'This is not a valid theme settings file', 'mnml-shop') .
												'</span>';
									}
								} else {
									echo 	'<span class="import-msg import-error">' .
												'<i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;' .
												 esc_html__( 'Failed to upload file', 'mnml-shop' ) .
											'</span>';
								}		
							}
							?>
                            <form id="import-settings-form" enctype="multipart/form-data" action="<?php echo admin_url();?>themes.php?page=themes1_optionspage&amp;nav=3,1" method="POST">
                                <!-- MAX_FILE_SIZE must precede the file input field -->
                            	<input type="hidden" name="MAX_FILE_SIZE" value="50000" />
                                <!-- Name of input element determines name in $_FILES array -->
                                <label id="cont-upload-form">
                                    <span id="cont-pick-btn" class="the1-btn2"><i class="fa fa-folder"></i> ...</span>
                                    <span id="cont-file-name"><?php esc_html_e('No file chosen','mnml-shop');?></span>
                                    <input name="userfile" type="file" id="import-settings-filebrowser" autocomplete="off" />
                                </label>
                                <a href="javascript:void(0);" id="cont-submit-btn" class="the1-btn">
                                	<i class="fa fa-arrow-circle-down"></i>&nbsp;&nbsp;
                                    <?php esc_html_e('Import Settings','mnml-shop');?>
                                    &nbsp;
                                </a>
                            </form>
                        </div>
                        
                    </div>

            </div><!--.options-pages-->
            
            
            <div class="options-foot">
                <div class="clear"></div>
            </div>
        </div><!--.wrap-right-->




<?php } ?>
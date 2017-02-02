<?php
$mnml_left_title 		 = mnml_themeoption('left-title');
$mnml_left_hyperlink 	 = mnml_themeoption('left-hyperlink');
$mnml_right_title		 = mnml_themeoption('right-title');
$mnml_right_hyperlink	 = mnml_themeoption('right-hyperlink');
?>

<div class="sidelink-wrapper sidelink-wrapper--left">
	<div class="mainbanner-area__social mainbanner-area__social--left">
		<a href="<?php echo esc_url($mnml_left_hyperlink);?>"><?php echo $mnml_left_title;?></a>
	</div>
</div>
<div class="sidelink-wrapper sidelink-wrapper--right">
	<div class="mainbanner-area__social mainbanner-area__social--right">
		<a href="<?php echo esc_url($mnml_right_hyperlink);?>"><?php echo $mnml_right_title;?></a>
	</div>
</div>
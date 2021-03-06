<?php 

/*
	Page
	Establishes the iFeature Pro page tempate.
	Version: 3.0
	Copyright (C) 2011 CyberChimps

*/

/* Header call. */

	get_header(); 
	
/* End header. */	

/* Define global variables. */
	global $options, $post, $themeslug;
	$size = get_post_meta($post->ID, 'page_slider_size' , true);
	$nivosize = get_post_meta($post->ID, 'page_nivoslider_size' , true);
	$page_section_order = get_post_meta($post->ID, $themeslug.'_page_section_order' , true);
	if(!$page_section_order) {
		$page_section_order = 'breadcrumbs,page_section';
	}
	
/* End define global variables. */

/* Set slider hook based on page option */

if (preg_match("/page_slider/", $page_section_order ) && $size == "1" ) {
	remove_action ('synapse_page_slider', 'synapse_slider_content' );
	add_action ('synapse_page_content_slider', 'synapse_slider_content' );
}

if (preg_match("/page_nivoslider/", $page_section_order ) && $nivosize == "1" ) {
	remove_action ('synapse_page_nivoslider', 'synapse_nivoslider_content' );
	add_action ('synapse_page_content_slider', 'synapse_nivoslider_content' );
}

/* End set slider hook*/
?>

<div class="container">
	<div class="row"> 
		<?php
		// Checking for password protection.
		if( ! post_password_required() ) {
			foreach(explode(",", $page_section_order) as $key) {
				$fn = 'synapse_' . $key;
				if(function_exists($fn)) {
					call_user_func_array($fn, array());
				}
			}
		}
		else {
		?>
			<!-- Get the form to submit password -->
			<div id="content" class="eight columns">
				<div class="post_container">
					<?php echo get_the_password_form(); ?>
				</div>
			</div>
		<?php
		} ?>
	</div><!--end row-->
</div><!--end container-->

<?php get_footer(); ?>
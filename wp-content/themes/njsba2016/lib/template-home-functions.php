<?php
//This snippet goes in your theme functions.php or plugin
// Remove Editor from page template
/*function hide_editor() {
	
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    if( !isset( $post_id ) ) return;
    $template_file = get_post_meta($post_id, '_wp_page_template', true);
    if($template_file == 'template-home.php'){//change mycustom-page.php to your thing
        remove_post_type_support('page', 'editor');
    }
    
}
add_action( 'admin_init', 'hide_editor' );*/

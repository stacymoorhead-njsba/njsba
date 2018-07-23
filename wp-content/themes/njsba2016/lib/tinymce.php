<?php
// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');


// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        array(  
            'title' => 'Button Small',  
            'selector' => 'a',
            'classes' => 'btn btn--small',
            'wrapper' => false,
        ),

        array(  
            'title' => 'Pull Quote',  
            'block' => 'blockquote',
            'selector' => 'blockquote',
            'classes' => 'pullquote',
            'wrapper' => false,
            
        ),  

        array(  
            'title' => 'Pull Quote By',  
            'block' => 'footer', 
            'classes' => '',
            'wrapper' => true,
        ),

        array(  
            'title' => 'Callout',  
            'block' => 'div', 
            'classes' => 'article__sidebar',
            'wrapper' => true,
        ),
      
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

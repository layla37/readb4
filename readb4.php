<?php
/*
Plugin Name: Read Article Before Commenting
Plugin URI:  https://github.com/layla37
Description: Allows author to write questions about their post that must be answered correctly before someone can comment.
Version:     1.0.0
Author:      Layla Mandella
Author URI:  https://github.com/layla37
License:     GPLv2
*/


/**
 * Register the 'Questions' meta box for the 'Post' post type.
 *
 * @since    1.0.0
 */
function rabc_add_meta_box() {
	
	add_meta_box(
		'rabc_qa_box',            // The ID for the meta box
		'Questions About Post',   // The title of the meta box
		'rabc_display_meta_box',  // The function for rendering the markup
		'post',                   // We'll only be displaying this on post pages
		'side',                   // Where the meta box should appear
		'core'                    // The priority of where the meta box should be displayed
	);
	
}
add_action( 'add_meta_boxes', 'rabc_add_meta_box' );

/**
 * Displays an optional error message and a view for the custom meta box.
 *
 * @param    object    $post    The post object to which this meta box is being displayed.
 * @since    1.0.0
 */
function rabc_display_meta_box( $post ) {
	
	// Define the nonce for security purposes
	wp_nonce_field( plugin_basename( __FILE__ ), 'rabc-nonce-field' );
	
	// Start the HTML string so that all other strings can be concatenated
	$html = '';
	
	// Display the 'First Question' label and its text input element
	$html .= '<label id="first-question" for="first-question">';
		$html .= '1st Question';
	$html .= '</label>';
	$html .= '<input type="text" id="first-question" name="first-question" value="' . get_post_meta( $post->ID, 'first-question', true ) . '" placeholder="What is the dog\'s name?" />';
	
	echo $html;
	
}


<?php
/*
Plugin Name: readb4
Plugin URI:  https://github.com/layla37/readb4
Description: Allows author to write questions about their post that must be answered correctly before someone can comment.
Version:     1.0.0
Author:      Layla Mandella
Author URI:  https://github.com/layla37
License:     GPLv2
*/

/**
 * Adds the stylesheets to the dashboard.
 *
 * @since    1.0.0
 */
function rb4_add_admin_styles() {
	wp_enqueue_style( 'rb4-admin', plugins_url( 'readb4/css/admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'rb4_add_admin_styles' );

/**
 * Adds the plugin's JavaScript to the 'Post' page
 *
 * @since    1.0.0
 */

function rb4_add_scripts() {	
	
	if ( is_single() && comments_open() ) {
		wp_enqueue_script( 'rb4-comments', plugins_url( 'readb4/js/script.js' ), array( 'jquery' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'rb4_add_scripts' );


/**
 * Register the 'Questions' meta box for the 'Post' post type.
 *
 * @since    1.0.0
 */
function rb4_add_meta_box() {
	
	add_meta_box(
		'rb4_qa_box',            // The ID for the meta box
		'Questions About Post',   // The title of the meta box
		'rb4_display_meta_box',  // The function for rendering the markup
		'post',                   // We'll only be displaying this on post pages
		'side',                   // Where the meta box should appear
		'core'                    // The priority of where the meta box should be displayed
	);
	
}
add_action( 'add_meta_boxes', 'rb4_add_meta_box' );

/**
 * Displays an optional error message and a view for the QA meta box.
 *
 * @param    object    $post    The post object to which this meta box is being displayed.
 * @since    1.0.0
 */
function rb4_display_meta_box( $post ) {
	
	// Define the nonce for security purposes
	wp_nonce_field( plugin_basename( __FILE__ ), 'rb4-nonce-field' );
	
	// Start the HTML string so that all other strings can be concatenated
	$html = '';
	
	// Display the 'First Question' label and its text input element
	$html .= '<label id="first-question" for="first-question">';
	$html .= '1st Question';
	$html .= '</label>';
	$html .= '<input type="text" id="first-question" name="first-question" value="' . get_post_meta( $post->ID, 'first-question', true ) . '" placeholder="What is the dog\'s name?" />';
	$html .= '<label id="first-q-option-1" for="first-q-option-1">';
	$html .= 'Answer A ';
	$html .= '</label>';
	$html .= '<input type="text" id="first-q-option-1" class="answer-option" name="first-q-option-1" value="' . get_post_meta( $post->ID, 'first-q-option-1', true ) . '" placeholder="Spot" />';
	$html .= '<label id="first-q-option-2" for="first-q-option-2">';
	$html .= 'Answer B ';
	$html .= '</label>';
	$html .= '<input type="text" id="first-q-option-2" class="answer-option" name="first-q-option-2" value="' . get_post_meta( $post->ID, 'first-q-option-2', true ) . '" placeholder="Rover" />';
	$html .= '<label id="first-q-option-3" for="first-q-option-3">';
	$html .= 'Answer C ';
	$html .= '</label>';
	$html .= '<input type="text" id="first-q-option-3" class="answer-option" name="first-q-option-3" value="' . get_post_meta( $post->ID, 'first-q-option-3', true ) . '" placeholder="Tiger" />';

	echo $html;
	
}

add_filter( 'comment_form_field_comment', 'rb4_show_questions' );

function rb4_show_questions( $comment_form ) {
	// check cookie to see if they already answered question previously

	// if answered, return

	// if not yet answered or answered incorrectly
	rb4_did_not_answer();
	$comment_form = rb4_not_answered( $comment_form );

	return $comment_form;
}


function rb4_not_answered($comment_form) {
	$comment_form = 'Q&A here!!!' . $comment_form;

	return $comment_form;
}


function rb4_did_not_answer() {
	add_filter('wp_footer', 'rb4_footer');
}


function rb4_footer() {

	?><script>
		document.getElementsByClassName('comment-form-comment')[0].style.display = 'none';
		document.getElementsByClassName('form-submit')[0].style.display = 'none';
	</script><?php
}



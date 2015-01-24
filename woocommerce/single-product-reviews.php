<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
global $woocommerce, $product;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! comments_open() )
	return;

?>
<div id="reviews"><?php

	echo '<div id="comments">';
    echo '<h2>'.__( 'Reviews', 'woocommerce' ).'</h2>';

	$title_reply = '';

	if ( have_comments() ) :

		echo '<ul class="commentlist">';
		wp_list_comments( array( 'callback' => 'woocommerce_comments' ) );

		echo '</ul>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Previous', 'woocommerce' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'woocommerce' ) ); ?></div>
			</div>
		<?php endif;

		echo '<div class="add_review">
                <a href="#" id="review_form_launcher" class="button" title="' . __( 'Add Your Review', 'woocommerce' ) . '">' . __( 'Add Review', 'woocommerce' ) . '</a>
              </div>';

		$title_reply = __( 'Add a review', 'woocommerce' );

	else :
        
		$title_reply = __( 'Be the first to review', 'woocommerce' ).' &ldquo;'.$post->post_title.'&rdquo;';

		echo '<div class="add_review">
                <p>' . __( 'There are no reviews yet, would you like to submit yours?', PLSH_THEME_DOMAIN ) . '</p>
                <p><a href="#" id="review_form_launcher" class="button" title="' . __( 'Add Your Review', 'woocommerce' ) . '">' . __( 'Add Review', 'woocommerce' ) . '</a></p>
              </div>';
	endif;

	$commenter = wp_get_current_commenter();

	echo '</div><div id="review_form_wrapper" style="display: none;"><div id="review_form">';

	$comment_form = array(
		'title_reply' => $title_reply,	
	'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'woocommerce' ) . ':</label> ' . '<span class="required">*</span>' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'woocommerce' ) . ':</label> ' . '<span class="required">*</span>' .
			            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
		),
		'label_submit' => __( 'Submit Review', 'woocommerce' ),
		'logged_in_as' => '',
		'comment_field' => ''
	);

	if ( get_option('woocommerce_enable_review_rating') == 'yes' ) {

		$comment_form['comment_field'] = '<div class="comment-form-rating clearfix"><label for="rating">' . __( 'Rating', 'woocommerce' ) .':</label><select name="rating" class="no-uniform" id="rating">
			<option value="">'.__( 'Rate&hellip;', 'woocommerce' ).'</option>
			<option value="5">'.__( 'Perfect', 'woocommerce' ).'</option>
			<option value="4">'.__( 'Good', 'woocommerce' ).'</option>
			<option value="3">'.__( 'Average', 'woocommerce' ).'</option>
			<option value="2">'.__( 'Not that bad', 'woocommerce' ).'</option>
			<option value="1">'.__( 'Very Poor', 'woocommerce' ).'</option>
		</select></div>';

	}

	$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' . wp_nonce_field( 'woocommerce-comment_rating', '_wpnonce', true, false ) . '</p>';

	comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

	echo '</div></div>';

?><div class="clear"></div></div>
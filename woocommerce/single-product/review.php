<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

global $post, $comment_iterator_count;
if(empty($comment_iterator_count))
{
    $comment_iterator_count = 1;
}
else
{
    $comment_iterator_count++;
}
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container clearfix">

        <div class="comment-gravatar"><?php echo get_avatar( $GLOBALS['comment'], $size='60' ); ?></div>

        <div class="comment-text">
            <div class="comment-heading clearfix">
                <?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
                    <div class="meta"><em><?php _e('Your comment is awaiting approval', 'woocommerce'); ?></em></div>
                <?php else : ?>
                    <div class="meta">
                        <strong itemprop="author"><?php comment_author(); ?></strong>
                        <?php

                            if ( get_option('woocommerce_review_rating_verification_label') == 'yes' )
                                if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) )
                                    echo '(' . __('verified owner', 'woocommerce') . ') ';

                        ?>
                    </div>
                <?php endif; ?>

                <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?>">
                    <div class="stars">
                    <?php
                        $rating = get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true );
                        $c = 0;
                        for($i = 1; $rating >= $i; $i++)
                        {
                            echo '<span class="full"></span>';
                            $c++;
                        }
                        
                        while($c < 5)
                        {
                            echo '<span class="empty"></span>';
                            $c++;
                        }
                    ?>
                    </div>
                </div>
            </div>
            
            <time itemprop="datePublished" time datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(__('M jS, Y', 'woocommerce')); ?></time>

            <div itemprop="description" class="description clearfix"><?php comment_text(); ?></div>
            <div class="clear"></div>
        </div>
        <div class="comment-number">
            #<?php echo $comment_iterator_count; ?>
        </div>
	</div>
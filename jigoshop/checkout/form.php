<?php
/**
 * Checkout form template
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package		Jigoshop
 * @category	Checkout
 * @author		Jigowatt
 * @copyright	Copyright (c) 2011-2012 Jigowatt Ltd.
 * @license		http://jigoshop.com/license/commercial-edition
 */
?>

<?php do_action('before_checkout_form');
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'jigoshop_get_checkout_url', jigoshop_cart::get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout clear-children" id="checkout-form" action="<?php echo esc_url( $get_checkout_url ); ?>">


    <?php do_action('jigoshop_checkout_billing'); ?>


	<h3 id="order_review_heading"><?php _e('Your order', 'jigoshop'); ?></h3>

	<?php do_action('jigoshop_checkout_order_review'); ?>

</form>

<?php do_action('after_checkout_form'); ?>
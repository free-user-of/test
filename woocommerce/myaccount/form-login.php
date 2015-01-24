<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<!-- BEGIN .main-login -->
<div class="main-login">
    <div id="login_form">
        <?php if(plsh_get($_GET, 'action', 'login') == 'login') { ?>
            <form method="post" class="login">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
                <p>
                    <label for="username"><?php _e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="text" class="input-text" name="username" id="username" />
                </p>
                <p>
                    <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input class="input-text" type="password" name="password" id="password" />
                </p>
                <?php do_action( 'woocommerce_login_form' ); ?>
                <p>
                    <label></label>
                    <a class="lost_password" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
                </p>
                <?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') { ?>
                    <p>
                        <label></label>
                        <a href="<?php echo plsh_assamble_url(false, array('action=register'), array('action')); ?>"><?php _e("Don't have an account? Register.", PLSH_THEME_DOMAIN); ?></a>
                    </p>
                <?php } ?>
                <p class="sign-in">
                    <?php wp_nonce_field( 'woocommerce-login' ); ?>

                    <label></label>
                    <input type="submit" class="woo-submit" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
                    <b>or <a href="<?php echo home_url(); ?>"><?php _e('Return to store', PLSH_THEME_DOMAIN);?></a></b>
                </p>
                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
        <?php } else if(get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes') { ?>
            <form method="post" class="register">
                <?php do_action( 'woocommerce_register_form_start' ); ?>
                <?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>
                    <p>
                        <label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
                    </p>
                <?php endif; ?>
                    
                <p>
                    <label for="reg_email"><?php _e( 'Email', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
                </p>
                <p>
                    <label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
                </p>
                <p>
                    <label for="reg_password2"><?php _e( 'Re-enter password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
                </p>
                <p>
                    <label></label>
                    <a href="<?php echo plsh_assamble_url(false, array('action=login'), array('action')); ?>"><?php _e("Already have an account? Login.", PLSH_THEME_DOMAIN); ?></a>
                </p>
                <!-- Spam Trap -->
                <div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" /></div>

                <?php do_action( 'woocommerce_register_form' ); ?>
                <?php do_action( 'register_form' ); ?>

                <p class="sign-in">
                    <label></label>
                    <?php wp_nonce_field( 'woocommerce-register'); ?>
                    <input type="submit" class="woo-submit" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
                    <b>or <a href="<?php echo home_url(); ?>"><?php _e('Return to store', PLSH_THEME_DOMAIN);?></a></b>
                </p>
                <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>
        <?php } ?>        
    </div>
<!-- END .main-login -->
</div>
        
<?php do_action('woocommerce_after_customer_login_form'); ?>
<?php
/*
  Plugin Name: Contact Form 7 - Multi-step Forms
  Plugin URI: https://azmarket.net/item/contact-form-7-cf7-multistep-forms
  Description: Contact Form 7 - Multi-step Forms helps you add multi-step for your form. This is the best solution to keep the form as simple as possible to your visitors.
  Version: 1.0.2
  Author: AzMarket
  Author URI: https://azmarket.net/
 */
define('BH_CF7_WPMS_PATH', plugin_dir_path( __FILE__ ));
define('BH_CF7_WPMS_URL', plugin_dir_url( __FILE__ ));
define('BH_CF7_WPMS_UP', 'cf7_wpdb_uploads');

class BH_CF7_WPMS {

    static $plugin_id = 'cf7wpms';

    static $types = array();
    /**
     * Variable to hold the initialization state.
     *
     * @var  boolean
     */
    protected static $initialized = false;
    
    /**
     * Initialize functions.
     *
     * @return  void
     */
    public static function initialize() {
        // Do nothing if pluggable functions already initialized.
        if ( self::$initialized ) {
            return;
        }

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
           add_action( 'admin_notices', array( __CLASS__, 'install_cf7_wpms_admin_notice') );
        }else{
            include BH_CF7_WPMS_PATH .'inc/functions.php';
            if( is_admin() ){
                include BH_CF7_WPMS_PATH .'inc/admin.php';
            }else{
            	include BH_CF7_WPMS_PATH .'inc/frontend.php';
            }
        }
        self::$initialized = true;
    }

    /**
     * Method Featured.
     *
     * @return  array
     */
    public static function install_cf7_wpms_admin_notice() {?>
        <div class="error">
            <p><?php _e( 'CF7 Database plugin is not activated. Please install and activate it to use for plugin <strong>Contact Form 7</strong>.', 'cf7-save2data-pro' ); ?></p>
        </div>
        <?php    
    }
}

add_action('plugins_loaded', 'cf7_wpms_init');

function cf7_wpms_init(){
    BH_CF7_WPMS::initialize();
}
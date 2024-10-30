<?php
class NBT_CF7MS_Admin{

    public function __construct() {
    	add_action( "admin_enqueue_scripts", array( &$this, "admin_enqueue_scripts" ), 0, 0 );
    	add_filter( "wpcf7_editor_panels", array( &$this, "wpcf7_editor_panels" ) );

    	add_action( "wpcf7_save_contact_form", array(&$this, "cf7save_data"), 99, 1 );
    	add_action('admin_print_footer_scripts-toplevel_page_wpcf7', array( &$this, 'cf7wpms_admin_print_footer_scripts'), 20);
    }


    public function wpcf7_editor_panels( $panels ) {
       $panels["form-panel"] = array(
				'title' => __( 'Form', 'contact-form-7' ),
				'callback' => array( &$this, "wpcf7_editor_panel_form_custom") );
        $panels["form-panel-multistep-setting"] = array(
				'title' => __( 'Settings Multistep', 'contact-form-7' ),
				'callback' => array( &$this, "cf7wpms_multistep_setting_form") );

    	return $panels;
    }

    function wpcf7_editor_panel_form_custom($post){
        $desc_link = wpcf7_link(
            __( 'https://contactform7.com/editing-form-template/', 'contact-form-7' ),
            __( 'Editing Form Template', 'contact-form-7' ) );
        $description = __( "You can edit the form template here. For details, see %s.", 'contact-form-7' );
        $description = sprintf( esc_html( $description ), $desc_link );

        include_once BH_CF7_WPMS_PATH . '/inc/tpl/admin-form.php';
    }

    public function cf7wpms_multistep_setting_form($post) {
        include_once BH_CF7_WPMS_PATH . '/inc/tpl/admin-settings.php';
    }

    public function cf7save_data( $contact_form ) {
    	$post_id = $contact_form->id;
        $form_tab = $_POST['wpcf7-form-tab'];
    	$form_content = $_POST['wpcf7-form-content'];  

        if( is_array($form_tab) ) {
            $new = array();
            foreach ($form_tab as $key => $tab) {
                $new[] = array(
                    'tab' => $tab,
                    'content' => base64_encode(trim($form_content[$key]))
                );
            }

            if( isset($_POST['cf7wpms_enable']) && $form_enable = $_POST['cf7wpms_enable'] ) {
                update_post_meta($post_id, '_cf7wpms', $new);
                update_post_meta($post_id, '_cf7wpms_enable', $form_enable);
            }else {
                update_post_meta($post_id, '_cf7wpms_enable', '');
            }

            if( isset($_POST['wpcf7-ms']) && is_array($_POST['wpcf7-ms']) && $wpcf7ms = $_POST['wpcf7-ms']) {
                $save_meta = array();
                foreach ($wpcf7ms as $k_prop => $value_prop) {
                    $save_meta['cf7wpms_' . $k_prop] = $value_prop;
                }
                update_post_meta($post_id, '_cf7wpms_settings', $save_meta);
            }

        }
    }

    public function cf7wpms_admin_print_footer_scripts() {
	    $banner = cf7wpms_premium_only('banner', false);
	    ?>
	    <script type="text/javascript">
	        jQuery(document).ready(function($) {
	            if (jQuery('#postbox-container-1').length) {
	                jQuery('#postbox-container-1').append('<?php echo $banner; ?>');
	            }            
	        });
	    </script>
	    <?php
    }

    public function admin_enqueue_scripts() {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        
    	wp_enqueue_style("cf7ms-pro", BH_CF7_WPMS_URL . "assets/admin/admin.css", array(), '1.0', false );

    	wp_enqueue_script("cf7ms-pro", BH_CF7_WPMS_URL . "assets/admin/admin.js", array(), '1.0', false );
        wp_localize_script( 'cf7ms-pro', 'cf7wpms', array(
            'label' => array(
                'data' => __('Tab', 'cf7-save2data-pro'),
                'count' => __('Count', 'cf7-save2data-pro')
            )
        ));
    }
    
}
new NBT_CF7MS_Admin();
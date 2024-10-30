<?php
class NBT_CF7MS_Frontend{

    private $cf7_id = '';

	private $shortcode_atts = array();

    public function __construct() {
        add_action( 'wpcf7_init', array(&$this, 'wpcf7_init') );
    	add_filter( 'get_post_metadata', array(&$this, 'show_cf7wpms_form'), 10, 4);
    	add_action( "wp_enqueue_scripts", array(&$this, "cf7wpms_enqueue_scripts"), 5 );

    }

    public function wpcf7_init() {
        $this->cf7_id = 3434;
    }

    public function show_cf7wpms_form( $html, $post_id, $meta_key, $single ) {
    	if( !is_admin() ) {

    		if( $meta_key == "_form" && empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
                
    			$cf7wpms = get_post_meta($post_id, '_cf7wpms', true);
    			$cf7wpms_enable = get_post_meta($post_id, '_cf7wpms_enable', true);

                if($cf7wpms && $cf7wpms_enable) {
                    $_cf7wpms_settings = get_post_meta($post_id, '_cf7wpms_settings', true);

                    if($_cf7wpms_settings) {
                        $css = '';
                        if($_cf7wpms_settings['cf7wpms_bg_button']) {
                            $css .= '.cf7wpms-nav .btn  {
                                background-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_button']).';
                                color: '. esc_attr($_cf7wpms_settings['cf7wpms_text_button']).';
                            }';
                        }
                        if($_cf7wpms_settings['cf7wpms_bg_button_hover']) {
                            $css .= '.cf7wpms-nav .btn:hover, .cf7wpms-loading {
                                background-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_button_hover']).';
                                color: '. esc_attr($_cf7wpms_settings['cf7wpms_text_button_hover']).';
                            }';
                        }
                        if($_cf7wpms_settings['cf7wpms_bg_nav']) {
                            $css .= '.cf7wpms-style1 li.active a {
                                background-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_nav']).';
                            }

                            .cf7wpms-style1 li.active a:before {
                                border-top-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_nav']).';
                                border-bottom-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_nav']).';
                            }

                            .cf7wpms-style1 li.active a:after {
                                border-left-color: '.esc_attr($_cf7wpms_settings['cf7wpms_bg_nav']).';
                            }';
                        }
                        if($_cf7wpms_settings['cf7wpms_color_nav']) {
                            $css .= '.cf7wpms-style1 li.active span {
                                color: '. esc_attr($_cf7wpms_settings['cf7wpms_color_nav']) .';
                            }';
                        }
                        echo '<style>'.$css.'</style>';

                    }


                	$total_cf7wpms = count($cf7wpms);
                    $col = 100/$total_cf7wpms;
        			ob_start();
        			?>
    			   <!-- progressbar -->
    				<ul id="cf7wpms-progressbar" class="cf7wpms-style1 clearfix">
    					<?php foreach ($cf7wpms as $key => $wpms) {?>
    					<li style="width: <?php echo  $col;?>%;"<?php if($key == 0) { echo ' class="active"';} ?>>
    						<a id="wizard-t-0" href="#wizard-<?php echo $post_id;?>-<?php echo $key;?>" aria-controls="wizard-p-0"><span class="number"><?php echo ($key + 1);?>.</span> <?php echo $wpms['tab'];?></a>
    					</li>
    					<?php }?>
    				</ul>

    				<div class="cf7wpms-content">
    				<?php
        			foreach ($cf7wpms as $key => $wpms) {
        				$reset_key = $key + 1;
        				$cf7_forms = base64_decode($wpms['content']);

        				?>
        				<div id="wizard-<?php echo $post_id;?>-<?php echo $key;?>" class="cf7wpms-panel<?php if($key == 0) { echo ' active';} ?>">
    	    				<?php echo str_replace('\\', '', preg_replace("#rn#","\n", $cf7_forms));?>
    	    			</div>
    	    			<?php
        			}?>
                        <div class="cf7wpms-nav">
                            <div class="cf7wpms-nav-left"><button type="button" class="btn btn-cf7wpms-left"><?php echo esc_html_e('Previous', '');?><span class="ld ld-ring ld-spin"></span></button></div>

                            <div class="cf7wpms-nav-right">
                                <button type="button" class="btn btn-cf7wpms-right"><?php echo esc_html_e('Next', '');?><span class="ld ld-ring ld-spin"></span></button><button type="button" class="btn btn-cf7wpms-submit"><?php echo esc_html_e('Submit', '');?><span class="ld ld-ring ld-spin"></span></button>
                            </div>
                        </div>
        			</div>
        			<?php

        			$html = ob_get_clean();
                }
    		}
    	}

    	return $html;
    }

    public function cf7wpms_enqueue_scripts() {
        
    	wp_enqueue_style( "cf7wpms", BH_CF7_WPMS_URL."assets/frontend/style.css", array(), '', 'all');

        
        wp_enqueue_script( "cf7wpms", BH_CF7_WPMS_URL."assets/frontend/frontend.js", array(), '', true);
        

        //$_cf7wpms_settings = get_post_meta($post->id, '_cf7wpms_settings', true);

        wp_localize_script( 'cf7wpms', 'cf7wpms', 

        wpcf7_messages() );
    }

}
new NBT_CF7MS_Frontend();

function mang($pre){
    echo '<pre>';
    print_r($pre);
    echo '</pre>';
}
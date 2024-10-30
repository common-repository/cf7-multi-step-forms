<?php
function cf7wpms_premium_only($type, $echo = true)
{
    $link = 'http://bit.ly/2q4FX7B';
    $html = '';
    if ($type == 'button') {
        $html = sprintf(
            '<a href="%1$s" target="_blank" class="cf7mls_premium_btn">%2$s</a>',
            $link,
            __('This options only available for Premium version. <strong>Upgrade Now</strong>', 'cf7mls')
        );
    } elseif ($type == 'banner') {
        $img_url = BH_CF7_WPMS_URL . '/assets/admin/contact-form-7-multi-step-pro.png';
        $html = sprintf(
            '<div class="cf7mls_premium_banner"><a href="%1$s" target="_blank"><img src="%2$s" alt="Contact Form 7 Multi-Step PRO" /></a></div>',
            $link,
            $img_url,
            'cf7mls'
        );
    }
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
    
}
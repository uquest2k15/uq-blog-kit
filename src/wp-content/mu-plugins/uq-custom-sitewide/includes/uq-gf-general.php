<?php

/**
 * uq-gf-general.php
 * 
 * 
 * 
 * 
 */

// hide "*" indicates required fields
add_filter( 'gform_required_legend', '__return_empty_string' );

add_filter( 'gform_phone_formats', 'kr_phone_format' );
function kr_phone_format( $phone_formats ) {
    $phone_formats['kr'] = array(
            'label'       => '###-####-####',
            'mask'        => '999-9999-9999',
            'regex'       => '/^\D?(\d{3})\D?\D?(\d{4})\D?(\d{4})$/',
            'instruction' => '###-####-####',
        );
 
    return $phone_formats;
}
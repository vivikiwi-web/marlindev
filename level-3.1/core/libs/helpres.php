<?php

/**
 * Function that will var_damp $data in <pre> tag and then stop script
 *
 * @param $data
 * @return void
 */
function dd( $data ) {
    echo "<pre>";
    var_dump( $data );
    echo "</pre>";
    die;
}
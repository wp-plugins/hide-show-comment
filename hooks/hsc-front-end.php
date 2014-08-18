<?php

add_action('wp_enqueue_scripts', 'hsc_wp_enqueue_scripts', 100);
function hsc_wp_enqueue_scripts()
{
    HSCGenerate::generate_in_frontend();
}
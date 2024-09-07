<?php
/*
Plugin Name: Elementor Upload Progress
Description: Adds an upload progress bar to Elementor forms.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue the necessary scripts and styles
function euf_enqueue_scripts() {
    wp_enqueue_script('euf-upload-progress', plugin_dir_url(__FILE__) . 'upload-progress.js', array('jquery'), null, true);
    wp_enqueue_style('euf-upload-progress-style', plugin_dir_url(__FILE__) . 'upload-progress.css');
}
add_action('wp_enqueue_scripts', 'euf_enqueue_scripts');

// Add progress bar to Elementor form
function euf_add_progress_bar_to_elementor_form($form) {
    echo '<div id="upload-progress-container">';
    echo '<div id="upload-progress-bar"></div>';
    echo '<div id="upload-progress-text">0%</div>';
    echo '</div>';
}
add_action('elementor_pro/forms/after_fields', 'euf_add_progress_bar_to_elementor_form');

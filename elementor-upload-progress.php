<?php
/*
Plugin Name: Elementor Upload Progress
Description: نمایش نوار پیشرفت برای بارگذاری فایل‌ها در Elementor به همراه پشتیبانی از آپلود چند فایل
Version: 1.2
Author: SAADLINE
*/

if (!defined('ABSPATH')) {
    exit;
}

// بارگذاری فایل‌های استایل و جاوااسکریپت
function enqueue_upload_progress_assets() {
    wp_enqueue_style('upload-progress-css', plugins_url('/upload-progress.css', __FILE__));
    wp_enqueue_script('upload-progress-js', plugins_url('/upload-progress.js', __FILE__), array('jquery'), null, true);

    // برای ارسال اطلاعات آژاکس به جاوااسکریپت
    wp_localize_script('upload-progress-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_upload_progress_assets');

// رندر کردن نوار پیشرفت در فرم‌ها
function render_upload_progress_bar() {
    ?>
    <div id="upload-progress-wrapper">
        <div id="upload-progress-bar"></div>
        <span id="upload-progress-percent">0%</span> <!-- نمایش درصد -->
    </div>
    <input type="file" id="file-upload" multiple /> <!-- آپلود چند فایل -->
    <?php
}
add_action('elementor/widget/render_content', 'render_upload_progress_bar');

// هندلر برای آپلود فایل‌ها
function handle_file_upload() {
    if (!empty($_FILES['file']['name'])) {
        $uploaded_files = $_FILES['file'];
        foreach ($uploaded_files['name'] as $key => $file_name) {
            if (move_uploaded_file($uploaded_files['tmp_name'][$key], wp_upload_dir()['path'] . '/' . $file_name)) {
                wp_send_json_success("فایل {$file_name} با موفقیت آپلود شد.");
            } else {
                wp_send_json_error("خطا در آپلود فایل {$file_name}.");
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_handle_upload', 'handle_file_upload');
add_action('wp_ajax_nopriv_handle_upload', 'handle_file_upload');
?>

<?php
function woo_theme_images_uri($filename) {
    return sprintf('%s/dist/images/%s', get_template_directory_uri(), $filename);
}

function woo_theme_get_css_uri($filename) {
    return sprintf('%s/dist/css/%s.min.css', get_template_directory_uri(), $filename);
}

function woo_theme_get_js_uri($filename) {
    return sprintf('%s/dist/js/%s.min.js', get_template_directory_uri(), $filename);
}

function woo_theme_get_js_path($filename) {
    return sprintf('%s/dist/js/%s.min.js', get_template_directory(), $filename);
}

/**
 * Get file last modified time.
 */
function get_file_version($path) {
    $file_path = get_template_directory() . $path;
    if (file_exists($file_path)) {
        $timestamp = filemtime(get_template_directory() . $path);
        if ($timestamp) {
            return date('Y.m.d.h.m.s', $timestamp);
        }
    }
    return '';
}

/**
 * Return path to assets directory.
 */
function get_assets_dir() {
  return get_template_directory_uri() . '/assets';
}

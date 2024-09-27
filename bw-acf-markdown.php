<?php
/*
Plugin Name: BW ACF Markdown
Description: Adds Markdown support to ACF textarea and WYSIWYG fields.
Version: 1.0
Author: Dein Name
*/

if (!defined('ABSPATH')) exit; // Sicherheit

// Klasse laden
require_once plugin_dir_path(__FILE__) . 'classes/BW_ACF_Markdown_Handler.php';

// Initialisiere das Plugin
function bw_acf_markdown_init() {
    $markdown_handler = new BW_ACF_Markdown_Handler();
    $markdown_handler->init();
}

add_action('plugins_loaded', 'bw_acf_markdown_init');

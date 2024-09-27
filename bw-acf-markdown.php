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
    
    // Lade JavaScript und CSS für Markdown-Vorschau
    add_action('acf/input/admin_enqueue_scripts', 'bw_acf_markdown_enqueue_scripts');
}

add_action('plugins_loaded', 'bw_acf_markdown_init');

// Skripte und Styles für ACF Markdown einfügen
function bw_acf_markdown_enqueue_scripts() {
    // jQuery-Skript für Echtzeit-Markdown-Umwandlung
    wp_enqueue_script(
        'bw-acf-markdown-js',
        plugin_dir_url(__FILE__) . 'assets/bw-acf-markdown.js',
        array('jquery'), // jQuery-Abhängigkeit
        null,
        true
    );

    // CSS für Markdown-Styles
    wp_enqueue_style(
        'bw-acf-markdown-css',
        plugin_dir_url(__FILE__) . 'assets/bw-acf-markdown.css'
    );
}

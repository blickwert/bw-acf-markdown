<?php

class BW_ACF_Markdown_Handler {
    
    public function init() {
        // Einstellungen für ACF-Felder hinzufügen
        add_action('acf/render_field_settings', [$this, 'add_markdown_checkbox']);
        
        // Filter für ACF-Felder anwenden
        add_filter('acf/load_value/type=textarea', [$this, 'apply_markdown_filter'], 10, 3);
        add_filter('acf/load_value/type=wysiwyg', [$this, 'apply_markdown_filter'], 10, 3);
    }

    // Checkbox für Markdown-Option in den ACF-Feld-Einstellungen hinzufügen
    public function add_markdown_checkbox($field) {
        if ($field['type'] == 'textarea' || $field['type'] == 'wysiwyg') {
            acf_render_field_setting($field, array(
                'label' => __('Enable Markdown'),
                'instructions' => __('Check this box to enable Markdown for this field.'),
                'type' => 'true_false',
                'name' => 'enable_markdown',
                'ui' => 1,
            ));
        }
    }

    // Markdown-Filter anwenden
    public function apply_markdown_filter($value, $post_id, $field) {
        // Überprüfen, ob Markdown aktiviert ist
        if (isset($field['enable_markdown']) && $field['enable_markdown']) {
            // Markdown-Syntax zu HTML umwandeln
            $value = $this->convert_markdown_to_html($value);
        }

        return $value;
    }

    // Funktion, um Markdown zu HTML zu konvertieren
    private function convert_markdown_to_html($value) {
        // Überschriften
        $value = preg_replace('/###\s?(.*)/', '<h3>$1</h3>', $value);
        $value = preg_replace('/##\s?(.*)/', '<h2>$1</h2>', $value);
        $value = preg_replace('/#\s?(.*)/', '<h1>$1</h1>', $value);

        // Unsortierte Liste
        $value = preg_replace('/\n-\s?(.*)/', '<li>$1</li>', $value);
        $value = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $value);

        // Fettgedruckter Text
        $value = preg_replace('/\*\*(.*)\*\*/', '<strong>$1</strong>', $value);

        // Kursiver Text
        $value = preg_replace('/\*(.*)\*/', '<em>$1</em>', $value);

        // Zeilenumbrüche durch <br> ersetzen
        $value = nl2br($value);

        return $value;
    }
}

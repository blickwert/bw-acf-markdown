jQuery(document).ready(function($) {
    // Finde alle Textarea-Felder, die die Markdown-Option aktiviert haben
    $('textarea[data-enable-markdown="1"]').on('keyup input', function() {
        var input = $(this).val();

        // Wandle Markdown in Inline-HTML um
        var formatted = input
            .replace(/^### (.*$)/gim, '<div class="bw-inline-markdown-h3">$1</div>') // H3
            .replace(/^## (.*$)/gim, '<div class="bw-inline-markdown-h2">$1</div>')  // H2
            .replace(/^# (.*$)/gim, '<div class="bw-inline-markdown-h1">$1</div>')   // H1
            .replace(/^\- (.*$)/gim, '<div class="bw-inline-markdown-li">$1</div>')  // Listenelement
            .replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>') // Fett
            .replace(/\*(.*?)\*/gim, '<em>$1</em>') // Kursiv
            .replace(/\n/g, '<br>'); // Zeilenumbruch in <br>

        // Setze den formatierten Text direkt ins Textarea-Feld (Vorschau im Editor simulieren)
        $(this).html(formatted);
    });

    // Für WYSIWYG-Felder (TinyMCE)
    tinymce.init({
        selector: '.acf-wysiwyg textarea', // Auswahl des WYSIWYG-Felds
        menubar: false, // Entferne das Menü, falls nicht benötigt
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image', // Toolbar anpassen
        plugins: 'lists link image', // Nutze nur die Plugins, die wirklich benötigt werden
        setup: function(editor) {
            // Verhindere die Standardumwandlung von Markdown-Syntax in HTML durch TinyMCE
            editor.on('keydown', function(e) {
                if (e.key === '#' || e.key === '-' || e.key === '*') {
                    e.preventDefault(); // Stoppe die automatische Konvertierung von TinyMCE
                }
            });

            // Eigene Logik zur Umwandlung von Markdown in HTML bei Eingabe im Editor
            editor.on('keyup input', function(e) {
                var input = editor.getContent({ format: 'text' });

                // Markdown zu Inline-HTML mit Klassen formatieren
                var formatted = input
                    .replace(/^### (.*$)/gim, '<div class="bw-inline-markdown-h3">$1</div>') // H3
                    .replace(/^## (.*$)/gim, '<div class="bw-inline-markdown-h2">$1</div>')  // H2
                    .replace(/^# (.*$)/gim, '<div class="bw-inline-markdown-h1">$1</div>')   // H1
                    .replace(/^\- (.*$)/gim, '<div class="bw-inline-markdown-li">$1</div>')  // Listenelement
                    .replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>') // Fett
                    .replace(/\*(.*?)\*/gim, '<em>$1</em>') // Kursiv
                    .replace(/\n/g, '<br>'); // Zeilenumbruch in <br>

                // Setze den formatierten Inhalt im Editor
                editor.setContent(formatted);
            });
        }
    });
});

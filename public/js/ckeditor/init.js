if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
    CKEDITOR.tools.enableHtml5Elements(document);

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 550;
CKEDITOR.config.width = 'auto';
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.forcePasteAsPlainText = false; // default so content won't be manipulated on load
CKEDITOR.config.basicEntities = true;
CKEDITOR.config.entities = true;
CKEDITOR.config.entities_latin = false;
CKEDITOR.config.entities_greek = false;
CKEDITOR.config.entities_processNumerical = false;
CKEDITOR.config.fillEmptyBlocks = function (element) {
    return true; // DON'T DO ANYTHING!!!!!
};
CKEDITOR.config.allowedContent = true; // don't filter my data



var initCk = (function (id) {
    var wysiwygareaAvailable = isWysiwygareaAvailable(),
        isBBCodeBuiltIn = !!CKEDITOR.plugins.get('bbcode');

    return function (id) {
        var editorElement = CKEDITOR.document.getById(id);

        // :(((
        if (isBBCodeBuiltIn) {
            editorElement.setHtml(
                'Hello world!\n\n' +
                'I\'m an instance of [url=https://ckeditor.com]CKEditor[/url].'
            );
        }

        // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
        if (wysiwygareaAvailable) {
            CKEDITOR.replace(id);
        } else {
            editorElement.setAttribute('contenteditable', 'true');
            CKEDITOR.inline(id);

            // TODO we can consider displaying some info box that
            // without wysiwygarea the classic editor may not work.
        }
    };

    function isWysiwygareaAvailable() {
        // If in development mode, then the wysiwygarea must be available.
        // Split REV into two strings so builder does not replace it :D.
        if (CKEDITOR.revision == ('%RE' + 'V%')) {
            return true;
        }

        return !!CKEDITOR.plugins.get('wysiwygarea');
    }
})();


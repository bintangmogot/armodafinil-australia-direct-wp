(function ($) {
    'use strict';

    if (typeof window.acf === 'undefined') {
        return;
    }

    var queuedFields = new WeakSet();

    function cleanBookmarks(value) {
        return String(value || '').replace(
            /<span\b[^>]*\bdata-mce-type\s*=\s*(["'])bookmark\1[^>]*>(?:[\s\S]*?<\/span>|)/gi,
            ''
        );
    }

    function restoreContent(field, source) {
        var editorId = field.get('id');
        var editor = editorId && window.tinymce ? window.tinymce.get(editorId) : null;

        if (!editor || field.getMode() !== 'visual') {
            return;
        }

        if (!editor.getContent({ format: 'raw' }).trim() && source.trim()) {
            editor.setContent(source);
            editor.save();
        }
    }

    function initializeField(field) {
        if (!field || field.get('type') !== 'wysiwyg' || queuedFields.has(field)) {
            return;
        }

        var $control = field.$control();
        var $input = field.$input();

        if (!$control.length || !$input.length || !field.$el.is(':visible')) {
            return;
        }

        var source = cleanBookmarks($input.val());
        $input.val(source);

        var editorId = field.get('id');
        var editor = editorId && window.tinymce ? window.tinymce.get(editorId) : null;

        if (editor) {
            restoreContent(field, source);
            return;
        }

        queuedFields.add(field);

        if ($control.hasClass('delay')) {
            $control.removeClass('delay');
            $control.find('.acf-editor-toolbar').remove();
        }

        field.initializeEditor();

        window.setTimeout(function () {
            restoreContent(field, source);
            queuedFields.delete(field);
        }, 150);
    }

    function initializeFields(context) {
        var $context = context ? $(context) : $(document);
        var $fields = $context.is('.acf-field[data-type="wysiwyg"]')
            ? $context
            : $context.find('.acf-field[data-type="wysiwyg"]');
        var index = 0;

        function next() {
            if (index >= $fields.length) {
                return;
            }

            initializeField(window.acf.getField($fields.eq(index)));
            index += 1;
            window.setTimeout(next, 100);
        }

        next();
    }

    window.acf.addAction('ready', function () {
        window.setTimeout(function () {
            initializeFields(document);
        }, 100);
    });

    window.acf.addAction('append', function ($el) {
        window.setTimeout(function () {
            initializeFields($el);
        }, 100);
    });

    $(document).on('mousedown', '.acf-field[data-type="wysiwyg"] .switch-tmce', function () {
        var field = window.acf.getField($(this).closest('.acf-field'));
        window.setTimeout(function () {
            initializeField(field);
        }, 0);
    });
})(jQuery);

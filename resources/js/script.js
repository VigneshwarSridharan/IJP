$(document).ready(() => {
    if ($('.select2').length) {
        $('.select2').select2()
    }
    $('.modal').on('hidden.bs.modal',function() {
        $(this).find('form').each((k,form) => {
            $(form).find('select.select2').html('');
            $(form).find('.preview').html('');
            form.reset();
            $(form).find('select.select2').trigger('change');
            $(form).find('.custom-file .custom-file-label').html('Choose file');
            $(form).validate().resetForm();
            $(form).validate().destroy();
            tinyMCE.activeEditor.setContent('');
        })
    })
    tinymce.init({
        selector: '#mytextarea',
        plugins: "wordcount link",
        max_chars: "10",
        setup: function (editor) {
            editor.on('keydown', function (e) {
                if ([8, 9].includes(e.keyCode)) return;
                if (editor.plugins.wordcount.body.getWordCount() >= 10) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $('#mytextarea').val(editor.getContent().trim());
                
            });
        }
    });
    $(document).on('focusin', function(e) {
        if ($(event.target).closest(".tox").length) {
            e.stopImmediatePropagation();
        }
    });

    $('.custom-file input').change(function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    });
})
$(document).ready(() => {
    if ($('.select2').length) {
        $('.select2').select2()
    }

    tinymce.init({
        selector: '#mytextarea',
        plugins: "wordcount link",
        max_chars: "10",
        setup: function (editor) {
            editor.on('keydown', function (e) {
                console.log(editor.getContent())
                if ([8, 9].includes(e.keyCode)) return;
                if (editor.plugins.wordcount.body.getWordCount() >= 10) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }
    });
    $(document).on('focusin', function(e) {
        if ($(event.target).closest(".tox").length) {
            e.stopImmediatePropagation();
        }
    });

    //     var wordcount = tinymce.activeEditor.plugins.wordcount;

    // console.log(wordcount.body.getWordCount());
    // console.log(wordcount.body.getCharacterCount());
    // console.log(wordcount.body.getCharacterCountWithoutSpaces());

    // console.log(wordcount.selection.getWordCount());
    // console.log(wordcount.selection.getCharacterCount());
    // console.log(wordcount.selection.getCharacterCountWithoutSpaces());
})
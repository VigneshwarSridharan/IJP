$(document).ready(() => {
    if ($('.select2').length) {
        $('.select2').select2()
    }
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('form').each((k, form) => {
            $(form).find('select.select2').html('');
            $(form).find('.preview').html('');
            form.reset();
            $(form).find('select.select2').trigger('change');
            $(form).find('.custom-file .custom-file-label').html('Choose file');
            $(form).validate().resetForm();
            // $(form).validate().destroy();
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
    $(document).on('focusin', function (e) {
        if ($(event.target).closest(".tox").length) {
            e.stopImmediatePropagation();
        }
    });

    $('.custom-file input').change(function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    });
    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $('[data-post]').on('click', function () {
        let id = $(this).data('post');
        console.log(id);
        $('#post-' + id).modal('show');
        $.ajax({
            url: `posts/${id}/comments`,
            dataType: 'json',
            success: ({ status, response }) => {
                if (status == 'success') {
                    $('#comments-' + id).html(`
                        <div class="list-group mb-3">
                        ${
                        response.map(item => {
                            return `
                                    <div class="list-group-item d-flex align-items-center justify-content-between">
                                        <div>${item.comment}</div>
                                        <img src="${storage(item.avatar)}" class="rounded-circle" height="40" />
                                    </div>
                                    `
                        }).join('')
                        }
                        </div>`
                    );
                }
                console.log(response);
            }
        })
    })
    $('.add-comment').each((k, el) => {
        $(el).validate({
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: form => {
                let $form = $(form);
                let text = $form.find('[type="submit"]').html();
                $form.find('[type="submit"]').html(`<i class="fas fa-spinner fa-pulse"></i>`).attr('disabled', 'disabled');
                let data = $form.serializeArray();
                let id = $form.find('[name="post_id"]').val();
                $.ajax({
                    url: `posts/${id}/comments`,
                    method: 'POST',
                    dataType: 'json',
                    data,
                    success: ({ status, response }) => {
                        form.reset();
                        if (status == 'success') {
                            $('#comments-' + id + ' .list-group').prepend(`
                            <div class="list-group-item d-flex align-items-center justify-content-between">
                                <div>${response.comment}</div>
                                <img src="${storage(response.avatar)}" class="rounded-circle" height="40" />
                            </div>
                            `)
                            $form.find('[type="submit"]').html(text).removeAttr('disabled');
                            let count = Number($('.post-info .comment-' + id).eq(0).find('span').text())
                            $('.post-info .comment-' + id).addClass('text-primary').find('span').text(count + 1)
                        }
                    }
                });
            }
        })
    })

    $('[data-like-post]').click(function () {
        let post_id = $(this).data('like-post')
        $.ajax({
            url: `posts/${post_id}/like`,
            method: 'POST',
            dataType: 'json',
            data: { _token, post_id },
            success: ({status,response}) => {
                if(status == 'success') {
                    let count = Number($('.post-info .like-' + post_id).eq(0).find('span').text())
                    $('.post-info .like-' + post_id).addClass('text-primary').removeAttr('pointer').find('span').text(count + 1)
                }
            }
        })
    })
})
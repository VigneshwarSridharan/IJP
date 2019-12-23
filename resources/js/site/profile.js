$(document).ready(() => {
    $('[data-edit]').on('click', ({ currentTarget: elm }) => {
        let id = $(elm).data('edit');
        $.ajax({
            url: '/posts/' + id,
            dataType: 'json',
            method: 'POST',
            data: {
                _token
            },
            success: ({ status, response }) => {
                if (status == 'success') {
                    let $form = $('#new-post form');
                    let { title, category_id, body, image, meta_keywords,id } = response;
                    console.log($form.data())
                    $form.find('[name="post_id"]').val(id);
                    $form.find('[name="title"]').val(title);
                    $form.find('[name="category"]').val(category_id);
                    $form.find('#category-' + category_id).prop('checked', true);
                    $form.find('[name="keywords[]"]').html(meta_keywords.split(', ').map(v => `<option selected>${v}</option>`));
                    $form.find('[name="description"]').val(body);
                    tinyMCE.activeEditor.setContent(body);
                    $form.find('.preview').html(`<img src="${storage(image)}" class="mb-2" width="250" />`)
                    $form.find('[name="image"]').prop('required',false)
                    $('#new-post').modal('show')
                }
            }
        })
    })
})
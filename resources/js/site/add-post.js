$('input.featured-image').on('change', function (event) {
    let src = URL.createObjectURL(event.target.files[0])
    $(this).parents('.modal').find('.featured-image-upload').css({
        backgroundImage: `url(${src})`
    })
    $upload.addClass('have-file')
})

$('.featured-image-upload').click(function () {
    $(this).parents('.modal').find('.featured-image').click()
})

var $upload = $('.featured-image-upload');

var droppedFiles = false;

$upload.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
    e.preventDefault();
    e.stopPropagation();
})
    .on('dragover dragenter', function () {
        $upload.addClass('is-dragover');
    })
    .on('dragleave dragend drop', function () {
        $upload.removeClass('is-dragover');
    })
    .on('drop', function (e) {
        droppedFiles = e.originalEvent.dataTransfer.files;
        console.log(droppedFiles);
        let $fileInput = $('input.featured-image');
        var [fileContext] = $fileInput;
        console.log(fileContext);
        fileContext.files = droppedFiles;
        $fileInput.trigger('change')
        if (droppedFiles.length) {
            $upload.addClass('have-file')
        }
        // $('.featured-image').val(droppedFiles)
    });

// $('#new-post .body-content').on('input', function () {
//     this.value = this.value.substr(0, 500);
//     $('#new-post .body-content-count').text(this.value.length + '/500')
// })

$('#new-post .submit').on('click',function() {
    $('#new-post form').find('[name="is_draft"]').val(0)
    $('#new-post form').submit()
})
$('#new-post .draft').on('click',function() {
    $('#new-post form').find('[name="is_draft"]').val(1)
    $('#new-post form').submit()
})

// jQuery.validator.setDefaults({
    
// });

$('#new-post form').validate({
    submitHandler: form => {
        let $form = $(form);
        form.submit();
    },
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
    ignore:[]
});
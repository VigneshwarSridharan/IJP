$(document).ready(function() {
    if('validate' in $.fn && $('#review-comment').length) {
        $('#review-comment').validate({
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
        });
    }

    if('isotope' in $.fn && $('.post-grid-wrppaer').length) {
        $('.post-grid-wrppaer').isotope()
    }
});
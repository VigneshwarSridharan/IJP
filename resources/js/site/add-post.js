$('.featured-image').on('change',function(event) {
    console.log(this)
    let src = URL.createObjectURL(event.target.files[0])
    console.log(src)
    $(this).parents('.modal').find('.featured-image-upload').css({
        backgroundImage:   `url(${src})`
    })
})

$('.featured-image-upload').click(function() {
    $(this).parents('.modal').find('.featured-image').click()
})
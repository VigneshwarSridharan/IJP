let {pathname} = location;
if(pathname == '/login') {
    $('#loginModal').modal('show');
}
if(pathname == '/register') {
    $('#registerModal').modal('show');
}

let loginSubmitHandler = (form) => {
    let $form = $(form);
    $form.find('[type="submit"]').html(`<i class="fas fa-spinner fa-pulse"></i>`).attr('disabled', 'disabled');
    let data = $form.serializeArray();
    $.ajax({
        url: '/checkLogin',
        method: 'POST',
        dataType: 'json',
        data,
        success: (res) => {
            let { data, status } = res;
            if (status == 'success') {
                form.submit();
            }
            else {
                $form.find('[type="submit"]').html(`Login`).removeAttr('disabled')
                let $message = $form.find('.message');
                $message.html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${data}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                `).hide().animate({ height: 'toggle' });
                setTimeout(() => {
                    $message.animate({ height: 'toggle' });
                }, 5000);
            }
        }

    })
}

$.validator.addMethod("pwcheck", function (value) {
    return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /\d/.test(value) // has a digit
});
$('.login-form').validate({
    rules: {
        password: {
            // pwcheck: true,
            minlength: 8
        }
    },
    messages: {
        username: "Please enter your username",
        password: {
            required: "Please enter your password",
            // pwcheck: 'Your password contain at least one number and have a mixture of uppercase and lowercase letters',
            minlength: 'Your password must be at least 8 characters.'
        },
    },
    submitHandler: loginSubmitHandler
});

let registerSubmitHandler = (form) => {
    let $form = $(form);
    let data = $form.serializeArray();
    $form.find('[type="submit"]').html(`<i class="fas fa-spinner fa-pulse"></i>`).attr('disabled', 'disabled');
    $.ajax({
        url: '/checkRegister',
        dataType: 'json',
        method: 'POST',
        data,
        success: ({ status, data }) => {
            if (status === 'success') {
                form.submit();
            }
            else {
                $form.find('[type="submit"]').html('Register').removeAttr('disabled');
                let $message = $form.find('.message');
                $message.html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${data}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `).hide().animate({ height: 'toggle' });
                setTimeout(() => {
                    $message.animate({ height: 'toggle' });
                }, 5000);
            }
        }
    })
}

$('.register-form').validate({
    rules: {
        password: {
            required: true,
            pwcheck: true,
            minlength: 8
        }
    },
    messages: {
        name: 'Please enter your full name',
        email: 'Please enter your email',
        password: {
            required: 'Please Enter your password',
            pwcheck: 'Required number and lower and upper case letters',
            minlength: 'Your password must be at least 8 characters.'
        }
    },
    submitHandler: registerSubmitHandler
})
var Profile = function () {

    var changePasswordHandle = function () {

        $.validator.addMethod("checkCurrentPassword", function (value, element) {

            $("span.loading").html("<img src='"+ getRootWebSitePath() +"/manager/assets/img/loading.gif'>");
            var user_id = $('#change_password_form #user_id').val();
            var datastring = 'check_current_pass=1&user_id=' + user_id + '&password=' + value;
            // console.log(datastring);
            var temp = false;

            $.ajax({
                type: "POST",
                url: "profile.php",
                data: datastring,
                async: false,
                success: function (responseText) {
                    console.log( responseText );
                    if (responseText == 1) {
                        $("span.loading").html("");
                        temp = true;
                    } else {
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Mật khẩu cũ không khớp.");

        $('#change_password_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            rules: {

                password: {
                    required: true,
                    checkCurrentPassword: true
                },
                new_password: {
                    required: true,
                    minlength: 8
                },
                confirm_new_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },

            messages: {

                password: {
                    required: "Bạn phải nhập mật khẩu cũ"
                },
                new_password: {
                    required: "Bạn phải nhập mật khẩu mới",
                    minlength: "Mật khẩu phải dài hơn 8 ký tự"
                },
                confirm_new_password: {
                    required: "Bạn phải xác nhận lại mật khẩu",
                    equalTo: "Mật khẩu không khớp"
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#change_password_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#change_password_form').validate().form()) {
                    $('#change_password_form').submit();
                }
                return false;
            }
        });
    }
    return {

        init: function() {

            changePasswordHandle();
            
            $('#reset-submit').click(function () {

                var user_id = $('#change_password_form #user_id').val();
                var datastring = 'reset_password=1&user_id=' + user_id;

                $.ajax({
                    type: "POST",
                    url: "profile.php",
                    data: datastring,
                    async: false,
                    success: function (responseText) {

                        console.log( responseText );
                        $("span.reset-loading").html("");
                        $('.alert-new-password').text( 'Mật khẩu mới của bạn là: ' + responseText );
                    }
                });
            });
        }
    }
}();
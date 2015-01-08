var Client = function () {

    var askFormHandle = function () {

        // Email đã tồn tại hay chưa
        $.validator.addMethod("isValidCaptcha", function (value, element) {

            $("span.loading").html("<img src='" + getRootWebSitePath() + "/manager/assets/img/loading.gif'>");
            var recaptcha_challenge_field = $('#recaptcha_challenge_field').val();
            var datastring = 'recaptcha_response_field=' + value + '&recaptcha_challenge_field=' + recaptcha_challenge_field;
            var temp = true;

            $.ajax({
                type: "POST",
                url: "ask.php",
                data: datastring,
                async: true,
                success: function (responseText) {
                    console.log(responseText);
                    if (responseText != 1) {

                        $("span.loading").html("");
                        temp = false;
                    } else {

                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Địa chỉ email này đã được sử dụng.");

        $('#submit_question_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            onkeyup: false,
            ignore: "",
            rules: {

                author_stuID: {
                    number: true,
                    minlength: 8
                },
                author_numberY: {
                },
                author_phone_number: {
                    minlength: 10,
                    maxlength: 11,
                    number: true
                },
                author_name: {
                    required: true
                },
                author_email: {
                    required: true,
                    email: true
                },
                title: {
                    required: true,
                    maxlength: 100
                },
                content: {
                    required: true
                }
            },

            messages: {

                author_name: {
                    required: "Bạn phải nhập họ tên"
                },
                author_email: {
                    required: "Bạn phải nhập email để nhận câu trả lời",
                    email: "Email của bạn không đúng"
                },
                title: {
                    required: "Hãy nhập tiêu đề câu hỏi",
                    maxlength: "Tiêu đề chỉ dài 45 ký tự"
                },
                content: {
                    required: "Nhập nội dung câu hỏi"
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

                $("span.loading").html("<img src='" + getRootWebSitePath() + "/manager/assets/img/loading.gif'>");
                var recaptcha_response_field = $('#recaptcha_response_field').val();
                var recaptcha_challenge_field = $('#recaptcha_challenge_field').val();
                var datastring = 'recaptcha_response_field=' + recaptcha_response_field + '&recaptcha_challenge_field=' + recaptcha_challenge_field;

                $.ajax({
                    type: "POST",
                    url: "ask.php",
                    data: datastring,
                    async: true,
                    success: function (responseText) {

                        if (responseText == 1) {

                            $("span.loading").html("");
                            $('.recaptcha_only_if_incorrect_sol').hide();
                            form.submit();
                        } else {

                            $("span.loading").html("");
                            $('.recaptcha_only_if_incorrect_sol').show();
                        }
                    }
                });
            }
        });

        $("#i_am")
            .change(function () {

                var type = $(this).val();
                $('#author_type').removeClass('has-error');
                $('#author_type .help-block').remove();
                if (type === 'parent') {

                    $('#author_phone_number').val('');
                    $('.i_am_label').text('Số điện thoại');
                    $('#author_stuID').hide();
                    $('#author_numberY').hide();
                    $('#author_phone_number').show();

                } else if (type === 'old-student') {

                    $('#author_numberY').val('');
                    $('.i_am_label').text('Niên khóa');
                    $('#author_stuID').hide();
                    $('#author_numberY').show();
                    $('#author_phone_number').hide();
                } else if (type === 'student') {

                    $('#author_stuID').val('');
                    $('.i_am_label').text('MSSV');
                    $('#author_stuID').show();
                    $('#author_numberY').hide();
                    $('#author_phone_number').hide();
                }
            }).trigger("change");
        ;

        $('#submit_question_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#submit_question_form').validate().form()) {
                    $('#submit_question_form').submit();
                }
                return false;
            }
        });
    }
    return {

        init: function () {

            askFormHandle();
        }
    }
}();
var GeneralSetting = function () {

    var handleMailServ = function () {
        $('#mailserv_setting_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                mailserver_url: {
                    required: true
                },
                mailserver_port: {
                    required: true
                },
                mailserver_login: {
                    required: true,
                    email: true
                },
                mailserver_pass: {
                    required: true
                }
            },

            messages: {
                mailserver_url: {
                    required: "Không được bỏ trống mục này"
                },
                mailserver_port: {
                    required: "Không được bỏ trống mục này"
                },
                mailserver_login: {
                    required: "Không được bỏ trống mục này",
                    email: "Tên đăng nhập phải là email hợp lệ"
                },
                mailserver_pass: {
                    required: "Không được bỏ trống mục này"
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

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('#mailserv_setting_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#mailserv_setting_form').validate().form()) {
                    $('#mailserv_setting_form').submit();
                }
                return false;
            }
        });

    }

    return {

        init : function () {

            handleMailServ();
        }
    }
}();
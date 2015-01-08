var Users = function () {

    var handleAddUser = function () {

        // tên đăng nhập chỉ chứa chữ thường, chữ hoa, chữ số, dấu gạch dưới
        $.validator.addMethod("validUsername", function (value, element) {
            return /^[0-9a-zA-Z_.-]+$/.test(value);
        }, "Tên người dùng chỉ chứa chữ hoa, thường, số và dấu gạch dưới.");

        $.validator.addMethod("userPositionCheck", function (value, element) {

            if ( value === '-1' ) {
                console.log( value );
                return true;
            } else {
                return false;
            }
        }, "Hãy chọn chức vụ cho tài khoản");

        // tên đăng nhập đã tồn tại hay chưa
        $.validator.addMethod("existedUsername", function (value, element) {

            $("span.loading").html("<img src='"+ getRootWebSitePath() +"/manager/assets/img/loading.gif'>");
            var datastring = 'username=' + value;
            // console.log(datastring);
            var temp = false;

            $.ajax({
                type: "POST",
                url: "users.php",
                data: datastring,
                async: false,
                success: function (responseText) {
                    console.log( responseText );
                    if (responseText != 1) {
                        $("span.loading").html("");
                        temp = true;
                    } else {
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Tên người dùng đã được sử dụng.");

        // Email đã tồn tại hay chưa
        $.validator.addMethod("existedEmail", function (value, element) {

            $("span.loading").html("<img src='"+ getRootWebSitePath() +"/manager/assets/img/loading.gif'>");
            var datastring = 'email=' + value;
            var temp = false;

            $.ajax({
                type: "POST",
                url: "users.php",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if (responseText != 1) {
                        $("span.loading").html("");
                        temp = true;
                    } else {
                        $("span.loading").html("");
                    }
                }
            });
            return temp;
        }, "Địa chỉ email này đã được sử dụng.");

        $('#add_user_form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            rules: {
                username: {
                    minlength: 5,
                    validUsername: true,
                    existedUsername: true
                },
                email: {
                    required: true,
                    existedEmail: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
                full_name: {
                    required: true
                },
                user_position: {
                    userPositionCheck: false
                }
            },

            messages: {
                username: {
                    required: "Tên đăng nhập không thể bỏ trống",
                    minlength: "Tên đăng nhập dài tối thiểu 5 kỳ tự"
                },
                password: {
                    required: "Mật khẩu không thể bỏ trống",
                    minlength: "Mật khẩu dài tối thiểu 8 ký tự"
                },
                confirm_password: {
                    required: "Nhập lại mật khẩu",
                    equalTo: "Mật khẩu không khớp"
                },
                email: {
                    required: "Nhập email người dùng",
                    email: "Hãy nhập đúng định dạng email"
                },
                full_name: {
                    required: "Nhập họ tên người dùng"
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

        $('#add_user_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#add_user_form').validate().form()) {
                    $('#add_user_form').submit();
                }
                return false;
            }
        });
    }

    var TableManaged = function () {

        // begin first table
        $('#users_management').dataTable({
            "aoColumns": [
                null,
                { "bSortable": false },
                null,
                { "bSortable": false },
                { "bSortable": false }
            ],
            "aLengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 5,
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }
            ]
        });

        jQuery('#users_management_wrapper .dataTables_filter input').addClass("form-control input-medium"); // modify table search input
        jQuery('#users_management_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
        jQuery('#users_management_1_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
    }
    return {

        init: function() {

            TableManaged();
            handleAddUser();
        }
    }
}();
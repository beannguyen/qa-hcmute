var SearchForm = function () {
	
	var formValid = function() {

		$('#search-form').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            rules: {
                keyword: {
	                minlength: 3
                }
            },

            messages: {
                keyword: {
                	minlength: "Từ khóa của bạn quá ngắn"
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

        $('#search-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#search-form').validate().form()) {
                    $('#search-form').submit();
                }
                return false;
            }
        });

        $('#keyword').focusout(function() {

            if ( $('#keyword').val().length != 0 ) {

                var datastring = 'permalink=1&keyword=' + $('#keyword').val();
                $.ajax({
                    type: "POST",
                    url: "",
                    data: datastring,
                    async: false,
                    success: function (responseText) {
                        
                        var res = JSON.parse(responseText);
                        if (res.result.length != 0)
                            $('#keyword').val(res.result);
                    }
                });
            }
        });
	}

    var setSearchValue = function () {
        
        if ( App.getURLParameter("action") === 'search' ) {
            if ( App.getURLParameter('question_type') != null || App.getURLParameter('question_type') !== 'any' ) {
                $('#question_type').val(App.getURLParameter('question_type'));
            } else {
                $('#question_type').val('any');
            }

            if ( App.getURLParameter('question_field') != null || App.getURLParameter('question_field') !== 'any' ) {
                $('#question_field').val(App.getURLParameter('question_field'));
            } else {
                $('#question_field').val('any');
            }

            if ( App.getURLParameter('keyword') != null || App.getURLParameter('keyword') !== '' ) {
                $('#keyword').val(App.getURLParameter('keyword').replace(/([.*+?^=!:${}()|\[\]\/\\])/gi, ' '));
            } else {
                $('#keyword').val('');
            }

            $('.question-type').text($('#question_type option:selected').text());
            $('.question-field').text($('#question_field option:selected').text());
            $('.keyword').text($('#keyword').val());
        }
    }

	return {
		init: function() {
			formValid();
		},
        client: function() {
            setSearchValue();
        }
	}
}();
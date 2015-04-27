
function editField( id )
{
    // set value to edit form
    $('#position_id').val( id );
    $('#position_name').val( $('#position-' + id).text() );
    $('#position_state').val( 0 );
    $('.delete_position').show();

    // uncheck all checkbox
    $('#tab_1_2 .checkbox input').each(function() {

    	if ( $(this).is(":checked") ) {
    		$(this).click();
    	}
    });

    var datastring = "get_permission=1&term_id=" + id;
    $.ajax({
        type: "POST",
        url: "position.php",
        data: datastring,
        async: false,
        success: function (responseText) {

            if (responseText !== '[]') {
                
                var permissions = JSON.parse(responseText);
                for ( var x in permissions ) {

                	$('#' + permissions[x].key).click();
                }
            } else {
                
            }
        }
    });

    $('#submit-btn').text('Sửa');
}

var positionForm = function() {

	var addPositionHandle = function() {

		$('#positionForm').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                position_name: {
                	required: true
                }
            },

            messages: {

                position_name: {
                	required: "Tên chức vụ không thể rỗng"
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

		$('#positionForm input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#positionForm').validate().form()) {
                    $('#positionForm').submit();
                }
                return false;
            }
        });

        $('#delete_this_position').click(function() {
        	if ( $(this).is(":checked") ) {
	    		var c = confirm("Chức vụ sẽ được xóa vĩnh viễn nếu không có thành viên thuộc chức vụ này?");
	    		if ( c ) {
	    			var datastring = "delete_position=1&term_id=" + $('#position_id').val();
				    $.ajax({
				        type: "POST",
				        url: "position.php",
				        data: datastring,
				        async: false,
				        success: function (responseText) {

				        	var res = JSON.parse(responseText);
				            if (res.status === 'cannot_delete') {
				                
				                alert('Thành viên trong nhóm chức vụ này lớn hơn 1');
				            } else if (res.status === 'success') {
				            	location.reload();
				            }
				        }
				    });
	    		}
	    	}
        });
	};

	return {
		init: function() {
			addPositionHandle();
		}
	}
}();
var Inbox = function () {

    var content = $('.inbox-content');
    var loading = $('.inbox-loading');

    var handleReply = function () {

        $('#fileupload').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            rules: {
                message: {
                    required: true
                }
            },

            messages: {
                message: {
                    required: "Bạn chưa nhập nội dung trả lời"
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

        $('#fileupload input').keypress(function (e) {
            if (e.which == 13) {
                if ($('#fileupload').validate().form()) {
                    $('#fileupload').submit();
                }
                return false;
            }
        });
    };

    var loadInbox = function (el, name) {
        var url = 'inbox_inbox.php';
        var title = $('.inbox-nav > li.' + name + ' a').attr('data-title');

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-nav > li.' + name).addClass('active');
                $('.inbox-header > h1').text(title);

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    };

    var loadCategory = function (id, name) {

        var url = 'inbox_inbox.php?field=' + id;

        loading.show();
        content.html('');

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res)
            {
                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
            },
            async: false
        });
    };


    var loadMessage = function (el, id, name, resetMenu) {

        var url = 'inbox_view.php';
        if ( id !== '' )
            var url = 'inbox_view.php?id=' + id;

        loading.show();
        content.html('');
        toggleButton(el);
        
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                if (resetMenu) {
                    $('.inbox-nav > li.active').removeClass('active');
                }
                $('.inbox-header > h1').text('');

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });

    }

    var loadNavigation = function( el, url, name, resetMenu ) {

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res)
            {
                toggleButton(el);

                if (resetMenu) {
                    $('.inbox-nav > li.active').removeClass('active');
                }
                $('.inbox-header > h1').text('');

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var initWysihtml5 = function () {
        $('.inbox-wysihtml5').wysihtml5({
            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    }

    var loadReply = function (el, id) {
        var url = 'inbox_reply.php?id=' + id;

        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Reply');

                loading.hide();
                content.html(res);
                $('[name="message"]').val($('#reply_email_content_body').html());


                initWysihtml5();
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var loadEditReply = function (el, answerId, questionId) {
        var url = 'inbox_edit_reply.php?question_id=' + questionId + '&answer_id=' + answerId;

        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res)
            {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Reply');

                loading.hide();
                content.html(res);
                $('[name="message"]').val($('#reply_email_content_body').html());


                initWysihtml5();
                App.fixContentHeight();
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    var moveToSpam = function ( id ) {

        var conf = confirm( 'Bạn có muốn đánh dấu spam?' );
        if ( conf ) {

            var datastring = 'spam=1&question_id=' + id;
            $.ajax({
                type: "POST",
                url: "questions.php",
                data: datastring,
                async: false,
                success: function (responseText) {
                    console.log( responseText);
                    if ( responseText === '1' ) {

                        $('.reply-btn').addClass('disabled');
                        $('#spam-label').show();
                        $('.spam-alert').show();
                        $('.inbox .spam_btn').remove();
                    }
                }
            });
        }
    }

    var moveToTrash = function ( id ) {

        var conf = confirm( 'Bạn có chắc muốn xóa câu hỏi' );
        if ( conf ) {

            var datastring = 'delete_question=1&question_id=' + id;
            $.ajax({
                type: "POST",
                url: "questions.php",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if ( responseText === '1' ) {

                        window.location = $(location).attr('href');
                    }
                }
            });
        }
    }

    var moveAnswerToTrash = function ( id ) {

        var conf = confirm( 'Bạn có chắc muốn xóa câu trả lời' );
        if ( conf ) {

            var datastring = 'delete_answer=1&answer_id=' + id;
            $.ajax({
                type: "POST",
                url: "questions.php",
                data: datastring,
                async: false,
                success: function (responseText) {

                    if ( responseText === '1' ) {

                        $('#item-' + id).remove();
                    }
                }
            });
        }
    }

    var toggleButton = function(el) {
        if (typeof el == 'undefined') {
            return;
        }
        if (el.attr("disabled")) {
            el.attr("disabled", false);
        } else {
            el.attr("disabled", true);
        }
    }

    return {
        //main function to initiate the module
        init: function () {

            // handle reply and forward button click
            $('.inbox .reply-btn').live('click', function () {
                loadReply($(this), $(this).attr('data-action'));
            });

            $('.inbox .spam_btn').live('click', function () {

                moveToSpam($(this).attr('data-action'));
            });

            $('.inbox .delete_btn').live('click', function () {

                moveToTrash($(this).attr('data-action'));
            });

            $('.inbox .edit_answer').live('click', function() {
                loadEditReply($(this), $(this).attr('data-action'), $(this).attr('data-question'));
            });

            $('.inbox .delete_answer_btn').live('click', function() {

                moveAnswerToTrash( $(this).attr('data-action') );
            });

            // handle view message
            $('.inbox-content .view-message').live('click', function () {

                loadMessage($(this), $(this).attr('data-action'));
            });

            // handle btn-prev navigation
            $('.inbox-content .btn-next, .btn-prev').live('click', function () {

                loadNavigation( $(this), $(this).attr('data-action') );
            });

            // handle inbox listing
            $('.inbox-nav > li.inbox > a').click(function () {
                loadInbox($(this), 'inbox');
            });

            // handle draft listing
            $('.inbox-nav > li.draft > a').click(function () {
                loadInbox($(this), 'draft');
            });

            // handle trash listing
            $('.inbox-nav > li.trash > a').click(function () {
                loadInbox($(this), 'trash');
            });

            handleReply();

            //handle loading content based on URL parameter
            if (App.getURLParameter("a") === "view") {
                loadMessage();
            } else if ( App.getURLParameter('field') != null ) {

                var categoryId = App.getURLParameter('field');
                loadCategory( categoryId );
            } else {
               $('.inbox-nav > li.inbox > a').click();
            }

        }

    };

}();
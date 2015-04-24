var Inbox = function () {

    var content = $('.inbox-content');
    var loading = $('.inbox-loading');
    var typeListing = 'all';

    var handleReply = function () {

        $('#fileupload').validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            onkeyup: false,
            rules: {
                title: {
                    required: true,
                    maxlength: 300
                },
                message: {
                    required: true
                }
            },

            messages: {
                message: {
                    required: "Bạn chưa nhập nội dung trả lời"
                },
                title: {
                    required: "Hãy nhập tiêu đề câu hỏi",
                    maxlength: "Tiêu đề chỉ dài 300 ký tự"
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

    var loadInbox = function (el, name, type, element) {
        var url = '';
        if ( type === 'inbox-listing' ) {

            url = 'inbox_inbox.php?view=all';
            typeListing = 'all';
        }
        else if ( type === 'admin-listing' ) {

            url = 'inbox_inbox.php?type=admin';
            typeListing = 'admin';
        }
        else if ( type === 'field-listing' ) {

            var field = $(element).attr('data-toggle');
            if ( typeListing === 'admin' )
                url = 'inbox_inbox.php?type=admin&field=' + field;
            else
                url = 'inbox_inbox.php?field=' + field;
        }


        if ( App.getURLParameter('page') != null ) {
            url += '&page=' + App.getURLParameter('page');
        }

        var title = $('.inbox-nav > li.' + name + ' a').attr('data-title');

        if ( type === 'field-listing' ) {

            title += " - " + $(element).attr('data-title');
        }

        console.log(url);
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


    var loadMessage = function (el, name, resetMenu) {

        var url = 'inbox_view.php';
        if ( App.getURLParameter('qId') !== null )
            var url = 'inbox_view.php?id=' + App.getURLParameter('qId');

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

    var loadRelatedQuestion = function(el) {

        console.log('clicked');
        var keyword = $('.inbox-content #subject').val();
        var id = $('.inbox-content #question_id').val();
        var url = 'related-question.php?id='+ id +'&keyword=' + keyword;
        toggleButton(el);
        
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);
                $('.related-questions-content').html(res);
                $('.open-modal-cau-hoi-goi-y').click();
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

    var initWysihtml5_2 = function () {
        $('.inbox-wysihtml5-1').wysihtml5({
            "font-styles":  true, //Font styling, e.g. h1, h2, etc
            "color":        false, //Button to change color of font
            "emphasis":     true, //Italics, bold, etc
            "textAlign":    true, //Text align (left, right, center, justify)
            "lists":        true, //(Un)ordered lists, e.g. Bullets, Numbers
            "blockquote":   false, //Button to insert quote
            "link":         false, //Button to insert a link
            "table":        false, //Button to insert a table
            "image":        false, //Button to insert an image
            "video":        false, //Button to insert video
            "html":         false //Button which allows you to edit the generated HTML
        });

        $('.inbox-wysihtml5-2').wysihtml5({
            "font-styles":  true, //Font styling, e.g. h1, h2, etc
            "color":        false, //Button to change color of font
            "emphasis":     true, //Italics, bold, etc
            "textAlign":    true, //Text align (left, right, center, justify)
            "lists":        true, //(Un)ordered lists, e.g. Bullets, Numbers
            "blockquote":   false, //Button to insert quote
            "link":         false, //Button to insert a link
            "table":        false, //Button to insert a table
            "image":        false, //Button to insert an image
            "video":        false, //Button to insert video
            "html":         false //Button which allows you to edit the generated HTML
        });
    }

    var loadReply = function (el, id) {
        var url = 'inbox_reply.php?id=' + App.getURLParameter('qId');

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

    var loadEditQuestion = function(el) {
        var url = 'edit_question.php?id=' + App.getURLParameter('qId');

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

    var loadEditReply = function (el, answerId, questionId) {
        var url = 'inbox_edit_reply.php?question_id=' + App.getURLParameter('qId') + '&answer_id=' + App.getURLParameter('aId');

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
    };

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
                    // console.log( responseText);
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

                    console.log(responseText);
                    if ( responseText === '1' ) {

                        window.location.href = "questions.php?view=all";
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

    var loadSearchResult = function (el) {

        var url = 'search_results.php?action=search';
        if ( App.getURLParameter('question_type') != null ) {
            url += '&question_type='+ App.getURLParameter('question_type');
        } else {
            url += '&question_type=any';
        }
        if ( App.getURLParameter('question_field') != null ) {
            url += '&question_field='+ App.getURLParameter('question_field');
        } else {
            url += '&question_field=any';
        }
        if ( App.getURLParameter('keyword') != null ) {
            url += '&keyword=' + App.getURLParameter('keyword');
        } else {
            url += '&keyword=';
        }
        if ( App.getURLParameter('page') != null ) {
            url += '&page=' + App.getURLParameter('page');
        }
        console.log(url);

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
                $('.inbox-header > h1').text('Search results:');

                loading.hide();
                content.html(res);
                $('[name="message"]').val($('#reply_email_content_body').html());

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
                //loadReply($(this), $(this).attr('data-action'));
                window.location.href = "questions.php?view=reply&qId=" + $(this).attr('data-action');
            });

            $('.inbox .spam_btn').live('click', function () {

                moveToSpam($(this).attr('data-action'));
            });

            $('.inbox .delete_btn').live('click', function () {

                moveToTrash($(this).attr('data-action'));
            });

            $('.inbox .edit_answer').live('click', function() {
                //loadEditReply($(this), $(this).attr('data-action'), $(this).attr('data-question'));
                window.location.href = "questions.php?view=edit_answer&qId=" + $(this).attr('data-question') + "&aId=" + $(this).attr('data-action'); 
            });

            $('.inbox .delete_answer_btn').live('click', function() {

                moveAnswerToTrash( $(this).attr('data-action') );
            });

            // handle view message
            $('.inbox-content .view-message').live('click', function () {

                window.location.href = "questions.php?view=message&qId=" + $(this).attr('data-action');
            });

            // load cau hoi goi y - modal
            $('.inbox-compose .cau-hoi-goi-y').live('click', function() {
                loadRelatedQuestion($(this));
            });

            // handle btn-prev navigation
            $('.inbox-content .btn-next, .btn-prev').live('click', function () {

                loadNavigation( $(this), $(this).attr('data-action') );
            });

            // handle inbox listing
            $('.inbox-nav > li.inbox > a').click(function () {
                loadInbox($(this), 'inbox', 'inbox-listing');
            });

            // handle admin inbox listing
            $('.inbox-nav > li.inbox-admin > a').click(function () {
                loadInbox($(this), 'inbox-admin', 'admin-listing');
            });

            $('.dropdown-menu > li > a').click(function (e) {

                if ( typeListing === 'admin')
                    loadInbox($(this), 'inbox-admin', 'field-listing', e.target);
                else
                    loadInbox($(this), 'inbox', 'field-listing', e.target);
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
            if ( App.getURLParameter("action") === "search" ) {

                loadSearchResult($(this));

                // load current filter
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
            } else if (App.getURLParameter("a") === "view") {
                loadMessage();
            } else if ( App.getURLParameter('field') != null ) {

                var categoryId = App.getURLParameter('field');
                loadCategory( categoryId );
            } else if ( App.getURLParameter('view') === 'all' ) {

                loadInbox($(this), 'inbox', 'inbox-listing');
            } else if ( App.getURLParameter('type') === 'admin' ) {

                loadInbox($(this), 'inbox-admin', 'admin-listing');
            } else if ( App.getURLParameter('view') === 'message') {

                loadMessage($(this));
            } else if ( App.getURLParameter('view') === 'reply' ) {

                loadReply($(this));
            } else if ( App.getURLParameter('view') === 'edit_answer' ) {
                loadEditReply($(this));
            } else if (App.getURLParameter('view') === 'edit') {
                loadEditQuestion($(this));
            } else {
               window.location.href = "questions.php?view=all";
            }

            // load editor toolbar
            if ( $('.wysihtml5-toolbar').length == 0 )
                    initWysihtml5_2();

        }

    };

}();
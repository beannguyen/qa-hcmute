<?php
require_once('config.php');
require_once( 'manager/libs/frontend.class.php' );
$frontend = new Frontend();

$db = $frontend->dbObj();
$db->connect();

$action_status = '';
if ( isset ( $_SESSION['ithcmute']['action-status'] ) ) {

    $action_status = $_SESSION['ithcmute']['action-status'];
    unset( $_SESSION['ithcmute']['action-status'] );
}
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Q&A Management</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="manager/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="manager/assets/plugins/select2/select2_metro.css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="manager/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="manager/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="manager/assets/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"></div>
                    <div id="action-bar" class="actions">
                        <a href="javascript:window.history.back();" class="btn default btn-sm btn-prev yellow-stripe">
                            <i class="icon-angle-left"></i>
                            <span class="hidden-480">
                                Quay lại
                            </span>
                        </a>
                        <a href="ask.php" class="btn btn-sm green"><i class="icon-plus"></i> Thêm câu hỏi</a>
                        <a href="index.php" class="btn btn-sm red"><i class="icon-bullhorn"></i>
                            Tất cả câu hỏi</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <h2>Đặt câu hỏi</h2>
                    <hr/>
                    <?php if ( $action_status !== 'success'): ?>
                    <div class="scroller" data-always-visible="1" data-rail-visible="0">
                    <form id="submit_question_form" class="form-horizontal" action="ask.php" method="post" role="form">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Đối tượng</label>
                                <div class="col-md-9">
                                    <select id="i_am" name="i_am" class="form-control">
                                        <option value="student">Sinh viên</option>
                                        <option value="old-student">Cựu sinh viên</option>
                                        <option value="parent">Phụ huynh</option>
                                    </select>
                                </div>
                            </div>

                            <div id="author_type" class="form-group">
                                <label class="col-lg-3 control-label i_am_label">MSSV</label>

                                <div class="col-lg-9">
                                    <input class="form-control" id="author_stuID" name="author_stuID" type="text">
                                    <input class="form-control display-hide" id="author_numberY" name="author_numberY" type="text">
                                    <input class="form-control display-hide" id="author_phone_number" name="author_phone_number" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Họ tên</label>

                                <div class="col-lg-9">
                                    <input class="form-control" name="author_name" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email</label>

                                <div class="col-lg-9">
                                    <input class="form-control" name="author_email" type="email">
                                    <span class="help-block">Hãy nhập địa chỉ email chính xác để nhận câu trả lời</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label  class="col-md-3 control-label">Lĩnh vực</label>
                                <div class="col-md-9">
                                    <select name="question_field" class="form-control">
                                        <?php
                                        $query = $db->query( "SELECT * FROM terms WHERE type = 'field'" );
                                        while ( $row = $db->fetch( $query ) ) {

                                            ?>
                                            <option value="<?php echo $row['term_id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">Tiêu đề</label>

                                <div class="col-lg-9">
                                    <input class="form-control" name="title" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label  class="col-md-3 control-label">Nội dung</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="content" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Mã xác nhận</label>
                                <div class="col-md-9">

                                    <!-- BEGIN GOOGLE RECAPTCHA -->
                                    <script type="text/javascript">
                                        var RecaptchaOptions = {
                                            theme : 'clean'
                                        };
                                    </script>
                                    <!-- END GOOGLE RECAPTCHA -->
                                    <?php
                                    require_once('manager/libs/recaptchalib.php');
                                    /* BeanNguyen: Update : update public key for recaptcha */
                                    // $publickey = "6LcHX_4SAAAAAAXLip2uWX5ra8Kq-N0r_uQrBceM"; // you got this from the signup page
                                    /* BeanNguyen: Update : update public key for recaptcha */
                                    $publickey = "6LcBY_4SAAAAAJE9y-kqklwKhlgJFsNqrjueAKOz";
                                    echo recaptcha_get_html($publickey);
                                    ?>
                                    <div class="recaptcha_only_if_incorrect_sol display-hide" style="color:red">Mã xác nhận không đúng, vui lòng nhập lại</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9">
                                        <input name="question" type="hidden" value="1" />
                                        <button type="submit" class="btn green"><i class="icon-ok"></i> Gửi <span class="loading"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    <?php else : ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Gửi thành công!</strong> Câu hỏi của bạn đã được gửi, bạn sẽ nhận được thông báo qua email khi chúng tôi trả lời.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="manager/assets/plugins/respond.min.js"></script>
    <script src="manager/assets/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="manager/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="manager/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"
            type="text/javascript"></script>
    <script src="manager/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
    <script src="manager/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="manager/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="manager/assets/plugins/select2/select2.min.js"></script>
    <script src="manager/assets/scripts/app.js" type="text/javascript"></script>
    <script src="manager/assets/scripts/client.js" type="text/javascript"></script>
    <script src="manager/assets/scripts/generic.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            App.init(); // init layout and core plugins
            Client.init();
        });

    </script>

    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
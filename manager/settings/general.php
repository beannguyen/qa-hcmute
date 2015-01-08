<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
$dashboard = new Dashboard();
$db = $dashboard->dbObj();
$db->connect();

$data = array(
    'mailserver_url' => '',
    'mailserver_port' => '',
    'mailserver_login' => '',
    'mailserver_pass' => ''
);

foreach ( $data as $key => $val ) {

    $sql = "SELECT option_value FROM options WHERE option_key = '". $key ."'";
    $query = $db->query( $sql );

    if ( $db->numrows( $query ) > 0 ) {

        $data[$key] = $db->fetch( $query )['option_value'];
    }
}

$action_status = '';
if ( isset( $_SESSION['ithcmute']['action-status'] ) ) {

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
    <link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="../assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2_metro.css"/>
    <link rel="stylesheet" href="../assets/plugins/data-tables/DT_bootstrap.css"/>
    <!-- END PAGE LEVEL STYLES -->
    <link rel="shortcut icon" href="../assets/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="">
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="../assets/img/menu-toggler.png" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <span class="username"><?php echo $_SESSION['ithcmute']['username']; ?></span>
                    <i class="icon-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo BASE_PATH; ?>manager/users/profile.php"><i class="icon-user"></i> My Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="javascript:;" id="trigger_fullscreen"><i class="icon-move"></i> Full Screen</a>
                    </li>
                    <li><a href="../logout.php"><i class="icon-key"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <form class="sidebar-search">
                    <div class="form-container">
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="start ">
                <a href="<?php echo BASE_PATH; ?>manager">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="">
                <a href="<?php echo BASE_PATH; ?>manager/fqa/questions.php">
                    <i class="icon-user"></i>
                    <span class="title">Hỏi đáp</span>
                </a>
            </li>
            <li class="">
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">Tài khoản</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo BASE_PATH; ?>manager/users/users.php">Tất cả tài khoản</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_PATH; ?>manager/users/profile.php">Trang cá nhân</a>
                    </li>
                </ul>
            </li>
            <li class="active">
                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title">Cài đặt</span>
                    <span class="selected "></span>
                </a>
                <ul class="sub-menu">
                    <li class="active">
                        <a href="<?php echo BASE_PATH; ?>manager/settings/general.php">Tổng quan</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_PATH; ?>manager/settings/field.php">Lĩnh vực</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_PATH; ?>manager/settings/position.php">Chức vụ</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Dashboard
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="<?php echo BASE_PATH; ?>manager">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li><a href="#">Quản lý tài khoản</a></li>
                    <li class="pull-right">
                        <div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top"
                             data-original-title="Change dashboard date range">
                            <i class="icon-calendar"></i>
                            <span></span>
                            <i class="icon-angle-down"></i>
                        </div>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption"><i class="icon-reorder"></i>Cấu hình hộp thư</div>
                    </div>
                    <div class="alert alert-info">
                        <strong>Hướng dẫn cấu hình SMTP server cho Gmail:</strong>
                        <p>Sau khi cấu hình xong, đăng nhập vào gmail, nhấn vào Settings > Forwarding/IMAP > enable IMAP.</p>
                        <strong>Lưu ý: </strong> vì vấn đề bảo mật tài khoản, nên khi bạn gửi mail lần đâu tiên sẽ bị chặn và sẽ có email tới thông báo việc bạn có muốn cấp quyền cho ứng dụng này không, đồng ý để ứng dụng được quyền gửi mail từ email của bạn.
                    </div>
                    <hr />
                    <div class="portlet-body form">
                        <form id="mailserv_setting_form" class="form-horizontal" role="form" action="general.php" method="post">
                            <?php if ( $action_status === 'success' ) : ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Cập nhật thành công!</strong>
                            </div>
                            <?php endif; ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Mail Server</label>
                                    <div class="col-md-6">
                                        <input type="text" id="mailserver_url" name="mailserver_url" class="form-control"  placeholder="Nhập địa chỉ máy chủ" value="<?php echo $data['mailserver_url']; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="mailserver_port" name="mailserver_port" class="form-control" placeholder="Port" value="<?php echo $data['mailserver_port']; ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Địa chỉ Email</label>
                                    <div class="col-md-9">
                                        <input type="text" id="mailserver_login" name="mailserver_login" class="form-control" value="<?php echo $data['mailserver_login']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-md-3 control-label">Mật khẩu</label>
                                    <div class="col-md-9">
                                        <input type="text" id="mailserver_pass" name="mailserver_pass" class="form-control" value="<?php echo $data['mailserver_pass']; ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="general" value="1" />
                            </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" id="btn-submit-form" class="btn green" value="Lưu lại" /><span class="process_loading"></span>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS -->
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
    <?php include('../footer.php'); ?>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="../assets/plugins/respond.min.js"></script>
    <script src="../assets/plugins/excanvas.min.js"></script>
    <![endif]-->
    <script src="../assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="../assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"
            type="text/javascript"></script>
    <script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
    <script src="../assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="../assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../assets/plugins/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
    <script src="../assets/scripts/general-setting.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            App.init(); // initlayout and core plugins
            GeneralSetting.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
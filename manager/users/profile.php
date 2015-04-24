<?php
require_once('../../config.php');

require_once('../libs/dashboard.class.php');
$dashboard = new Dashboard();
$db = $dashboard->dbObj();
$db->connect();

// validation method ajax
if ( isset( $_POST['check_current_pass'] ) ) {

    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $password = $dashboard->hashPassword( $password );

    $sql = "SELECT * FROM users WHERE user_id = " . $user_id . " AND password = '" . $password . "'";
    $query = $db->query( $sql );

    if ( $db->numrows( $query ) > 0 ) {

        echo 1;
    } else
        echo 0;

    return;
}
$userID = 0;
if ( isset($_GET['user_id']) ) {
    $userID = $_GET['user_id'];
} else {
    $userID = $_SESSION['ithcmute']['user_id'];
}

// get user information
$sql = "SELECT users.*, terms.*
        FROM users, term_relationships, terms
        WHERE term_relationships.term_id = terms.term_id
        AND users.user_id = term_relationships.object_id
        AND users.user_id = " . $userID;


$query = $db->query( $sql );

if ( $db->numrows( $query ) == 0 ) {

    $userInfo = false;
} else {

    $userInfo = $db->fetch( $query );
}

$action_status = '';
if ( isset ( $_SESSION['ithcmute']['action_status'] ) ) {

    $action_status = $_SESSION['ithcmute']['action_status'];
    unset( $_SESSION['ithcmute']['action_status'] );
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
            <li class="active">
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">Tài khoản</span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="<?php echo BASE_PATH; ?>manager/users/users.php">Tất cả tài khoản</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo BASE_PATH; ?>manager/users/profile.php">Trang cá nhân</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="javascript:;">
                    <i class="icon-cogs"></i>
                    <span class="title">Cài đặt</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
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
                    <li>
                        <a href="users.php">Quản lý tài khoản</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Trang cá nhân</a>
                    </li>
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
        <div class="row profile">
            <div class="col-md-12">

                <?php 
                    if ( !$dashboard->getAction($_SESSION['ithcmute']['user_id'], 'can_edit_own_profile') &&  ($userID == $_SESSION['ithcmute']['user_id']) ) {

                        echo "<h3>Bạn không có quyền truy cập trang này</h3>";
                    } else {

                    if ( !$dashboard->getAction($_SESSION['ithcmute']['user_id'], 'can_edit_all_users_profile') &&  ($userID != $_SESSION['ithcmute']['user_id']) ) {

                        echo "<h3>Bạn không có quyền truy cập trang này</h3>";
                        return false;
                    } else {
                ?>
                <!--BEGIN TABS-->
                <?php if ( $userInfo !== false ) : ?>
                <div class="tabbable tabbable-custom tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1_3" data-toggle="tab">Account</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_3">
                            <div class="row profile-account">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_1-1">
                                                <i class="icon-cog"></i>
                                                Thông tin tài khoản
                                            </a>
                                            <span class="after"></span>
                                        </li>
                                        <li ><a data-toggle="tab" href="#tab_3-3"><i class="icon-lock"></i> Đổi mật khẩu</a></li>
                                        <?php if ( $_SESSION['ithcmute']['user_id'] == 0 ) : ?>
                                            <li ><a id="reset-submit" href="javascript:;"><i class="icon-lock"></i> Reset mật khẩu <span class="reset-loading"></span></a></li>
                                        <?php endif; ?>
                                        
                                        <?php if( isset($_GET['user_id']) ): ?>
                                        <?php if($_SESSION['ithcmute']['user_id'] != $_GET['user_id']): ?>
                                        <li ><a id="delete_this_user" href="javascript:;" data-action="<?php echo $_GET['user_id']; ?>"><i class="icon-camera"></i> Xóa tài khoản</a></li>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <li ><a data-toggle="tab" href="#tab_3-4"><i class="icon-camera"></i> Ảnh đại diện</a></li>
                                        <?php if ( $_SESSION['ithcmute']['user_id'] == 0 ) : ?>
                                        <li ><a data-toggle="tab" href="#tab_4-4"><i class="icon-eye-open"></i> Phân quyền</a></li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <?php if ( $action_status === 'success' ) : ?>
                                            <div class="alert alert-success">
                                                <strong>Cập nhật thành công!</strong>
                                            </div>
                                        <?php elseif ( $action_status === 'failed' ) : ?>
                                            <div class="alert alert-danger">
                                                <strong>Đã xảy ra lỗi!</strong> Vui lòng thử lại.
                                            </div>
                                        <?php endif; ?>
                                        <div class="alert alert-success alert-new-password display-hide"></div>
                                        <div id="tab_1-1" class="tab-pane active">
                                            <form role="form" action="profile.php" method="post">
                                                <div class="form-group">
                                                    <label class="control-label">Họ Tên</label>
                                                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $userInfo['fullname']; ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Tài khoản</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $userInfo['username']; ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $userInfo['email']; ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label  class="control-label">Chức vụ</label>
                                                    <div>
                                                        <select id="user_position" name="user_position" class="form-control">
                                                            <option value="<?php echo $userInfo['term_id']; ?>"><?php echo $userInfo['name']; ?></option>
                                                            <?php
                                                            $sql = "SELECT * FROM terms WHERE type = 'position'";
                                                            $query = $db->query( $sql );

                                                            while ( $row = $db->fetch( $query ) ) {

                                                                if ( $row['term_id'] == $userInfo['term_id'] )
                                                                    continue;
                                                                echo '<option value="' . $row['term_id'] . '">'. $row['name'] .'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="update_info" value="1" />
                                                <input type="hidden" name="user_id" value="<?php echo $userInfo['user_id']; ?>" />
                                                <div class="margiv-top-10">
                                                    <button type="submit" class="btn green">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_3-3" class="tab-pane">
                                            <form id="change_password_form" action="profile.php" method="post">
                                                <div class="form-group">
                                                    <label class="control-label">Mật khẩu hiện tại</label>
                                                    <input type="password" class="form-control" id="password" name="password" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Mật khẩu mới</label>
                                                    <input type="password" class="form-control" id="new_password" name="new_password" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Nhập lại mật khẩu mới</label>
                                                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" />
                                                </div>
                                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $userInfo['user_id'] ?>" />
                                                <input type="hidden" name="change_password" value="1" />
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green">Đổi mật khẩu <span class="loading"></span></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_3-4" class="tab-pane">
                                            <form id="uploadForm" action="profile.php" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="file">Upload</label>
                                                    <div class="review-avatar">
                                                        <?php
                                                        $sql = "SELECT meta_value FROM user_meta WHERE meta_key = 'profile_img' AND user_id = " . $userInfo['user_id'];
                                                        $query = $db->query( $sql );
                                                        $avatar = $db->fetch( $query )['meta_value'];
                                                        ?>
                                                        <img src="<?php echo BASE_PATH . $avatar; ?>" />
                                                    </div>
                                                    <input type="file" id="file" name="file">
                                                    <p class="help-block">Support <em>JPG, JPEG, PNG</em>.</p>
                                                </div>
                                                <input type="hidden" id="user_id" name="user_id" value="<?php echo $userInfo['user_id'] ?>" />
                                                <input type="hidden" name="upload_avatar" value="1" />
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                        <?php if ( $_SESSION['ithcmute']['user_id'] == 0 ) : ?>
                                        <div id="tab_4-4" class="tab-pane">
                                            <form id="restricted_user_form" action="profile.php" method="post" class="">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <td>
                                                            Khóa tài khoản
                                                        </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" name="user_restricted" value="1" /> Yes
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <input type="hidden" name="user_id" value="<?php echo $userInfo['user_id']; ?>">
                                                    <input type="hidden" name="restricted" value="1">
                                                    <button type="submit" class="btn green">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--end col-md-9-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
                <?php else : ?>
                    <div class="alert alert-warning">
                        <strong>Không tìm thấy tài khoản yêu cầu!</strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS -->
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php include('../footer.php'); ?>
    <?php } ?>
    <?php } ?>
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
    <script type="text/javascript" src="../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
    <script src="../assets/scripts/generic.js"></script>
    <script src="../assets/scripts/profile.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            App.init(); // initlayout and core plugins
            Profile.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
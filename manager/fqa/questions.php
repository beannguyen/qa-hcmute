<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');

$dashboard = new Dashboard();
$db = $dashboard->dbObj();
$db->connect();

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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="../assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="../assets/css/pages/inbox.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="../assets/plugins/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5-editor.css" />
    <link href="../assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />


    <script src="../assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
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
                    <li><a href="<?php echo BASE_PATH; ?>manager/profile.php"><i class="icon-user"></i> My Profile</a>
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
            <li class="start">
                <a href="<?php echo BASE_PATH; ?>manager">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="<?php echo BASE_PATH; ?>manager/fqa/questions.php">
                    <i class="icon-user"></i>
                    <span class="title">Hỏi đáp</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="">
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">Tài khoản</span>
                    <span class="arrow "></span>
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
                    Quản lý câu hỏi
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="<?php echo BASE_PATH; ?>manager">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Câu hỏi</a>
                    </li>
                    <li class="category-filter pull-right">
                        <div class="btn-group">
                            <a href="javascript:window.history.back();" class="btn default btn-prev yellow-stripe">
                                <i class="icon-angle-left"></i>
                                <span class="hidden-480">
                                    Quay lại
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row inbox">
            <div class="col-md-2">
                <ul class="inbox-nav margin-bottom-10">
                    <li class="compose-btn">
                    </li>
                    <li class="inbox active">
                        <a href="questions.php?view=all" class="btn" data-title="Tất cả câu hỏi">Tất cả</a>
                        <b></b>
                    </li>
                    <li class="inbox-admin">
                        <a href="questions.php?type=admin" class="btn" data-title="Tất cả câu hỏi nhập">DS câu hỏi nhập</a>
                        <b></b>
                    </li>
                    <?php if ( $dashboard->getAction($_SESSION['ithcmute']['user_id'], 'can_add_admin_question') ): ?>
                    <li class="add">
                        <a href="#add_question" class="btn" data-toggle="modal">Thêm câu hỏi</a>
                        <b></b>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-10">
                <?php
                if ( isset( $_SESSION['ithcmute']['action_status'] ) ) {

                    $status = $_SESSION['ithcmute']['action_status'];
                    if ( $status === 'no-message' ) {
                        ?>
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Lỗi!</strong> Tin nhắn của bạn không được gửi vì nội dung rỗng.
                        </div>
                        <?php
                    } elseif ( $status === 'success' ) {
                        ?>
                        <div id="action_success" class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Thao tác thành công!</strong>
                        </div>
                <?php
                    } elseif ( $status === 'sent' ) {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Đã gửi câu trả lời thành công!</strong>
                        </div>
                <?php
                    }
                    unset( $_SESSION['ithcmute']['action_status'] );
                }
                ?>
                <div class="inbox-header">
                    <?php
                    if ( isset( $_GET['field'] ) ) {
                        $sql = "SELECT name FROM terms WHERE term_id = " . $_GET['field'];
                        $query = $db->query( $sql );

                        $field = $db->fetch( $query )['name'];
                        echo '<h1 class="pull-left">'. $field .'</h1>';
                    } else {
                        ?>
                        <h1 class="pull-left">All</h1>
                    <?php
                    }
                    ?>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="search-tools col-md-12">
                        <form id="search-form" action="questions.php" method="get" class="form">
                            <div class="form-group">
                                <input type="hidden" name="action" value="search" />
                                <div class="col-md-3">
                                    <select name="question_type" id="question_type" class="form-control input-inline input-medium">
                                        <option value="any">Tất cả câu hỏi</option>
                                        <option value="admin">Câu hỏi nhập</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3" style="margin-left:65px;">
                                    <select name="question_field" id="question_field" class="form-control input-inline input-medium">
                                        <option value="any">Lĩnh vực...</option>
                                        <?php
                                            $sql = "SELECT * FROM terms WHERE type = 'field'";
                                            $q12 = $db->query( $sql );
                                            while ( $row = $db->fetch( $q12 ) ) {
                                                
                                                echo "<option value='". $row['term_id'] ."'>". $row['name'] ."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4" style="margin-left:65px;">
                                    <div class="input-group">
                                        <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Keyword...">
                                        <span class="input-group-btn">
                                            <button class="btn blue" type="submit"><i class="icon-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="inbox-loading">Loading...</div>
                <div class="inbox-content"></div>
            </div>
        </div>
    </div>
    <!-- END PAGE -->

    <!-- MODAL -->
    <?php if ( $dashboard->getAction($_SESSION['ithcmute']['user_id'], 'can_add_admin_question') ): ?>
    <div class="modal fade bs-modal-lg in" id="add_question" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Thêm câu hỏi <span class="loading"></span></h4>
                </div>
                <div class="modal-body form">

                    <form class="inbox-compose form-horizontal" id="fileupload" action="questions.php" method="POST">
                        <div class="inbox-compose-btn">
                            <button type="submit" class="btn blue"><i class="icon-check"></i>Submit</button>
                        </div>
                        <div class="inbox-form-group mail-to">
                            <label class="control-label"></label>

                            <div class="controls">
                                <?php
                                $sql = "SELECT count(*) as num FROM questions WHERE i_am = 'admin'";
                                $query = $db->query( $sql );
                                $n = $db->fetch($query)['num'] + 1;
                                ?>
                                <input type="text" class="form-control" name="author_name" value="Câu hỏi <?php echo $n; ?>" disabled>
                            </div>
                        </div>

                        <div class="inbox-form-group">
                            <label  class="control-label">Lĩnh vực</label>
                            <div class="controls">
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

                        <div class="inbox-form-group display-hide">
                            <label class="control-label">Tiêu đề:</label>

                            <div class="controls">
                                <input type="text" class="form-control" name="title" value="">
                            </div>
                        </div>
                        <div class="inbox-form-group">
                            <label class="control-label">Nội dung</label>
                            <div class="controls">
                                <textarea name="content" class="form-control inbox-wysihtml5-1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="inbox-form-group">
                            <label  class="control-label">Chế độ</label>
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="type" id="optionsRadios4" value="public" checked> Công khai
                                </label>
                            </div>
                        </div>
                        <div id="wysihtml5-editor" class="inbox-form-group">
                            <label class="control-label">Trả lời</label>
                            <div class="controls">
                                <textarea class="inbox-editor inbox-wysihtml5-2 form-control" id="message" name="message" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="new-question" value="1" />
                        <div class="inbox-compose-btn">
                            <button type="submit" class="btn blue"><i class="icon-check"></i>Submit</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <?php endif; ?>
    <!-- // MODAL -->
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
<!-- BEGIN: Page level plugins -->
<script src="../assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript" ></script>
<script src="../assets/plugins/bootstrap3-wysihtml5/lib/js/wysihtml5x-toolbar.min.js"></script>
<script src="../assets/plugins/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js"></script>
<script src="../assets/plugins/bootstrap-wysihtml5/advanced.js" type="text/javascript"></script>
<script type="text/javascript" src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- END: Page level plugins -->
<script src="../assets/scripts/app.js"></script>
<script src="../assets/scripts/inbox.js"></script>
<script src="../assets/scripts/generic.js" type="text/javascript"></script>
<script type="text/javascript" src="../assets/scripts/search-form.js"></script>
<script>
    jQuery(document).ready(function () {
        // initiate layout and plugins
        App.init();
        Inbox.init();
        SearchForm.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
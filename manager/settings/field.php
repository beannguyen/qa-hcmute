<?php
require_once('../../config.php');
require_once( '../libs/dashboard.class.php' );
$dashboard = new Dashboard();

$db = $dashboard->dbObj();
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
        <li>
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
        <li class="active">
            <a href="javascript:;">
                <i class="icon-cogs"></i>
                <span class="title">Cài đặt</span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="<?php echo BASE_PATH; ?>manager/settings/general.php">Tổng quan</a>
                </li>
                <li class="active">
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
                <li><a href="#">Quản lý lĩnh vực hỗ trợ</a></li>
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
            <?php 
                if ( !$dashboard->getAction($_SESSION['ithcmute']['user_id'], 'can_manager_fields') ) {
                    echo "<h3>Bạn không có quyền truy cập vào trang này!</h3>";
                    
                } else {
            ?>
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box light-grey">
                <div class="portlet-title">
                    <div class="caption"></div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="btn-group">
                            <a id="add-field-btn" class="btn green" data-toggle="modal" href="#add_user">Thêm <i class="icon-plus"></i></a>
                        </div>
                    </div>
                    <!-- modal -->
                    <div class="modal fade" id="add_user" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title">Thêm lĩnh vực</h4>
                                </div>
                                <div class="modal-body form">
                                    <form class="form-horizontal" action="field.php" method="post" role="form">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Lĩnh vực</label>

                                                <div class="col-md-9">
                                                    <input type="hidden" id="field_id" name="field_id" />
                                                    <input class="form-control" type="text" id="field_name" name="field_name">
                                                    <input type="hidden" id="field_state" name="field" value="1" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Xóa lĩnh vực</label>
                                                <div class="checkbox-list col-md-9">
                                                    <label>
                                                    <input id="delete_field" type="checkbox"> xóa </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button id="submit-btn" type="submit" class="btn green">Tạo</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="table-responsive">
                        <?php if ( $action_status === 'success' ) : ?>
                        <div class="alert alert-success">
                            <strong>Đã cập nhật thành công!</strong>
                        </div>
                        <?php elseif ( $action_status === 'failed' ) : ?>
                        <div class="alert alert-danger">
                            <strong>Đã xảy ra lỗi!</strong> Vui lòng thử lại.
                        </div>
                        <?php endif; ?>
                        <table class="table table-condensed table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Lĩnh vực</th>
                                <th>Số câu hỏi</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $db->query( "SELECT * FROM terms WHERE type = 'field'" );
                                $i = 1;
                                while ( $row = $db->fetch( $query ) ) {

                                    $q = $db->query( "SELECT count(*) as num
                                                        FROM terms, questions, term_relationships
                                                        WHERE terms.term_id = term_relationships.term_id
                                                        AND term_relationships.object_id = questions.id
                                                        AND terms.term_id = " . $row['term_id'] );
                                    $num = $db->fetch( $q )['num'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><a id="field-<?php echo $row['term_id']; ?>" data-toggle="modal" href="#add_user" onclick="editField(<?php echo $row['term_id']; ?>)" > <?php echo $row['name']; ?></a></td>
                                        <td><?php echo $num; ?></td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/scripts/app.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    function editField( id )
    {
        // set value to edit form
        $('#field_id').val( id );
        $('#field_name').val( $('#field-' + id).text() );
        $('#field_state').val( 0 );
        $('#submit-btn').text('Sửa');
    }
    jQuery(document).ready(function () {
        App.init(); // initlayout and core plugins

        $('#add-field-btn').click( function() {

            $('#field_id').val( 0 );
            $('#field_name').val( '' );
            $('#field_state').val( 1 );
            $('#submit-btn').text('Tạo');
        })

        $('#delete_field').click(function() {
                var check = confirm('Bạn có muốn xóa lĩnh vực này?');
                if ( check ) {
                    //$("span.reset-loading").html("<img src='"+ getRootWebSitePath() +"/manager/assets/img/loading.gif'>");
                    var field_id = $('#field_id').val();
                    var datastring = 'delete_field=1&field_id=' + field_id;

                    $.ajax({
                        type: "POST",
                        url: "field.php",
                        data: datastring,
                        async: false,
                        success: function (responseText) {
                            console.log(responseText);
                            if( responseText === 'can_not_delete' ) {
                                alert('Lĩnh vực không thể xóa vì đã hoạt động!');
                                $('#delete_field').click();
                            } else {
                                alert('Lĩnh vực đã được xóa');
                                window.location.reload();
                            }
                        }
                    });
                }
            });
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
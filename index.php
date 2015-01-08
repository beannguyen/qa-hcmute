<?php
require_once('config.php');
require_once( 'manager/libs/frontend.class.php' );
require('manager/libs/westsworld.datetime.class.php');
require('manager/libs/timeago.inc.php');
require_once( 'manager/libs/times.class.php' );
require_once( 'manager/libs/pagenavigations.class.php');
$frontend = new Frontend();

$db = $frontend->dbObj();
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
    <link href="manager/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="manager/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="manager/assets/plugins/select2/select2_metro.css" />
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
                        <a href="ask.php" class="btn btn-sm green"><i class="icon-plus"></i> Thêm câu hỏi</a>
                        <a href="index.php" class="btn btn-sm red"><i class="icon-bullhorn"></i>
                            Tất cả câu hỏi</a>
                        <div class="btn-group">
                            <a class="btn default btn-sm" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                Lọc kết quả
                                <i class="icon-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="index.php"><i class="i"></i> Tất cả câu hỏi</a></li>
                                <li class="divider"></li>
                                <?php
                                $query = $db->query( "SELECT * FROM terms WHERE type = 'field'" );
                                while ( $row = $db->fetch( $query ) ) {

                                ?>
                                    <li><a href="index.php?field=<?php echo $row['term_id']; ?>"><?php echo $row['name']; ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" data-always-visible="1" data-rail-visible="0">
                    <ul class="feeds">
                    <?php
                    $sql = "select questions.*, terms.*
                            from questions, term_relationships, terms, QA_relationships
                            where questions.id = term_relationships.object_id
                            and terms.term_id = term_relationships.term_id
                            and questions.id = QA_relationships.question_id
                            and term_relationships.type = 'field'
                            and questions.type = 'public'";
                    // filter by question field
                    $field = '';
                    if ( isset( $_GET['field'] ) ) {

                        $field = $_GET['field'];
                        $sql .= " and term_relationships.term_id = " . $field;
                    }
                    $sql .= " group by QA_relationships.question_id";
                    $sql .= " order by questions.date desc";

                    /* init page navigation plugin */
                    // current url
                    $url = URL::curURL();
                    // current page
                    if ( isset( $_GET['page'] ) )
                        $page = $_GET['page'];
                    else
                        $page = 1;

                    // add append
                    $append = '';
                    if ( isset( $_GET['field'] ) ) {

                        $append = 'field=' . $field;
                    }
                    // init
                    $pager = new PageNavigation($sql, 20, 5, $url, $page, $append, 'index');

                    // get sql added limit
                    $newSql = $pager->paginate();

                    // no result return
                    if ($newSql == false) {

                        echo '<li>Không có dữ liệu trong mục này</li>';
                        goto jump;
                    }

                    $query = $db->query( $newSql );

                    while ( $row = $db->fetch( $query ) ) {

                        ?>
                        <li>
                            <div class="col1">
                                <div class="cont">
                                    <div class="cont-col1">
                                        <div class="label label-sm label-info">
                                            <i class="icon-paper-clip"></i>
                                        </div>
                                    </div>
                                    <div class="cont-col2">
                                        <div class="desc">
                                            <a href="question-detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="date">
                                    <?php
                                    $timeAgo = new TimeAgo();
                                    $timer = new timer();
                                    echo $timeAgo->inWords($row['date'], $timer->getDateTime());
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    jump:
                    ?>
                    </ul>
                    </div>
                    <div class="scroller-footer">
                        <div class="pull-right">
                            <?php echo $pager->renderFullNav('<i class="m-icon-swapleft m-icon-gray"></i>', '<i class="m-icon-swapright m-icon-gray"></i>'); ?>
                        </div>
                    </div>
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
        <script type="text/javascript" src="manager/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script type="text/javascript" src="manager/assets/plugins/select2/select2.min.js"></script>
        <script src="manager/assets/scripts/app.js" type="text/javascript"></script>
        <script src="manager/assets/scripts/client.js" type="text/javascript"></script>
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
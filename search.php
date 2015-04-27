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
                    <div class="caption">
                    </div>
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
                        <div class="btn-group">
                            <a class="btn default btn-sm" data-toggle="modal" href="#basic">
                                Lọc kết quả
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" data-always-visible="1" data-rail-visible="0">
                    <div class="row">
                        <div class="panel-group accordion" id="accordion3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
                                            Lọc kết quả cho - page: <?php if ( isset($_GET['page']) ) { echo $_GET['page']; } else { echo 1; } ?>
                                        </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_1" class="show-filter panel-collapse in">
                                        <div class="panel-body">
                                            <p>
                                                <strong>Loại câu hỏi</strong>: <span class="text question-type">...</span>
                                            </p>
                                            <p>
                                                <strong>Lĩnh vực</strong>: <span class="text question-field">...</span>
                                            </p>
                                            <p>
                                                <strong>Từ khóa</strong>: <span class="text keyword">...</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <ul class="feeds">
                    <?php
                    /** 
                     *  if isset search action 
                     *  this query will show search result
                     *  if not default is show all questions
                     */
                    if ( isset( $_GET['action'] ) && $_GET['action'] === 'search' ) {

                        $data = array();
                        if ( isset( $_GET['keyword'] ) ) {
                            $data['keyword'] = $frontend->vietnamese_permalink( $_GET['keyword'] );
                        }
                        if ( isset( $_GET['question_type'] ) ) {
                            $data['type'] = $frontend->secure( $_GET['question_type']);
                        }
                        if ( isset( $_GET['question_field'] ) ) {
                            $data['field'] = $frontend->secure( $_GET['question_field'] );
                        }
                        /* Neu nguoi dung tim kiem bang ca keyword va cac filter */
                        $sql = "";

                            if ( $data['keyword'] !== '' ) {
                                $sql = "SELECT *, MATCH (title) AGAINST ('" . stripslashes (str_replace ("&quot;", "\"", ($data['keyword']))) . "' IN BOOLEAN MODE) as score
                                        FROM questions
                                        WHERE MATCH (title) AGAINST ('" . stripslashes (str_replace ("&quot;", "\"", ($data['keyword']))) . "' IN BOOLEAN MODE)";
                                if ( $data['field'] !== 'any' ) {
                                    $sql .= " AND id IN (SELECT tb2.object_id
                                                FROM terms as tb1, term_relationships as tb2
                                                WHERE tb1.term_id = tb2.term_id
                                                AND tb2.type = 'field'
                                                AND tb1.term_id = ". $data['field'] .")";
                                }
                                if ( $data['type'] !== 'any' ) {
                                    $sql .= " AND questions.i_am = 'admin'";
                                }
                                $sql .= " ORDER BY score DESC";
                            }
                        // filter by field

                            if ( $data['field'] !== 'any' && $data['keyword'] === '' ) {

                                $sql = "SELECT tb3.*
                                        FROM terms as tb1, term_relationships as tb2, questions as tb3
                                        WHERE tb1.term_id = tb2.term_id
                                        AND tb2.object_id = tb3.id
                                        AND tb2.type = 'field'
                                        AND tb1.term_id = " . $data['field'];
                                if ( $data['type'] !== 'any' ) {
                                    $sql .= " AND tb3.i_am = '". $data['type'] ."'";
                                }
                            }

                        // only filter by type
                            if ( $data['type'] !== 'any' && $data['field'] === 'any' && $data['keyword'] === '' ) {
                                $sql = "SELECT *
                                        FROM questions
                                        WHERE i_am = 'admin'";
                            }

                            if ( $sql === '' ) {

                                echo "No result found!";
                                return;
                            }

                        /* init page navigation plugin */
                        // current url
                        $url = BASE_PATH . 'search.php';
                        // current page
                        if ( isset( $_GET['page'] ) )
                            $page = $_GET['page'];
                        else
                            $page = 1;

                        //
                        $append = 'action=search';
                        if ( isset( $_GET['question_field'] ) ) {
                            $append .= '&question_field=' . $_GET['question_field'];
                        }
                        if ( isset( $_GET['question_type']) ) {
                            $append .= '&question_type=' . $_GET['question_type'];
                        }
                        if ( isset( $_GET['keyword'] ) ) {
                            $append .= '&keyword=' . $_GET['keyword'];
                        }

                        // init
                        $pager = new PageNavigation($sql, 15, 5, $url, $page, $append, 'backend');

                        // get sql added limit
                        $newSql = $pager->paginate();

                        // no result return
                        if ($newSql == false) {

                            echo '<span>Không tìm thấy kết quả</span>';
                            goto jump;
                        }

                        $query_1 = $db->query( $newSql );


                    while ( $row = $db->fetch( $query_1 ) ) {

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
                    <?php
                    } else {
                        echo "No result found!";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Lọc kết quả</h4> 
                </div>
                <div class="modal-body">
                    <form id="search-form" action="search.php" method="get" class="form">
                        <div class="form-group">
                            <input type="hidden" name="action" value="search" />
                            <div class="col-md-12">
                                <select name="question_type" id="question_type" class="form-control input-inline input-large">
                                    <option value="any">Tất cả câu hỏi</option>
                                    <option value="admin">Câu hỏi nhập</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <select name="question_field" id="question_field" class="form-control input-inline input-large">
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
                            <div class="col-md-12">
                                <input type="text" id="keyword" name="keyword" class="form-control input-inline input-large" placeholder="Keyword...">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn blue">Lọc</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
        <script src="manager/assets/scripts/search-form.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            App.init(); // init layout and core plugins
            SearchForm.init();
            SearchForm.client();
        });

    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
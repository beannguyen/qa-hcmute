<?php
require_once('config.php');
require_once( 'manager/libs/frontend.class.php' );
require('manager/libs/westsworld.datetime.class.php');
require('manager/libs/timeago.inc.php');
require_once( 'manager/libs/times.class.php' );
require_once( 'manager/libs/pagenavigations.class.php');
$frontend = new Frontend();
$timer = new timer();

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
                </div>
            </div>
            <div class="portlet-body" id="chats">
                <div class="scroller" data-always-visible="1" data-rail-visible="0">
                    <ul class="chats">
                        <?php
                        $questionId = $_GET['id'];
                        $sql = "SELECT * FROM questions WHERE id = " . $questionId;
                        $query = $db->query( $sql );

                        if ( $db->numrows( $query ) == 0 ) {

                            echo '<li>Không tìm thấy câu hỏi</li>';
                            goto jump;
                        }

                        $question = $db->fetch( $query );
                        ?>
                        <li class="in">
                            <img class="avatar img-responsive" alt="" src="manager/assets/img/question-icon.png" />
                            <div class="message">
                                <span class="arrow"></span>
                                <strong class="name"><?php echo $question['author_name']; ?></strong>
                                <span class="datetime">lúc <?php echo $timer->timeFormat( $question['date'], 'd-m-Y H:i'); ?></span>
                                 <span class="body">
                                 <strong><em><?php echo $question['title']; ?></em></strong><br />
                                     <?php echo $question['content']; ?>
                                 </span>
                            </div>
                        </li>
                        <?php
                        $sql = "SELECT tb1.*, tb3.*
                                FROM answers as tb1, QA_relationships as tb2, users as tb3
                                WHERE tb1.id = tb2.answer_id
                                AND tb1.author_id = tb3.user_id
                                AND tb2.question_id = " . $question['id'];
                        $query = $db->query( $sql );
                        while ( $row = $db->fetch( $query ) ) {

                            ?>
                            <li class="out">
                                <?php
                                $sql = "SELECT meta_value FROM user_meta WHERE meta_key = 'profile_img' AND user_id = " . $row['author_id'];
                                $q = $db->query( $sql );
                                $avatar = $db->fetch( $q )['meta_value'];
                                ?>
                                <img class="avatar img-responsive" alt="" src="<?php echo $avatar; ?>" />
                                <div class="message">
                                    <span class="arrow"></span>
                                    <a class="name"><?php echo $row['fullname']; ?></a>
                                    <span class="datetime">lúc <?php echo $row['date']; ?></span>
                                 <span class="body">
                                 <?php echo html_entity_decode($row['content']); ?>
                                 </span>
                                </div>
                            </li>
                        <?php
                        }
                        jump:
                        ?>
                    </ul>
                </div>
                <div class="scroller-footer">
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
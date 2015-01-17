<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
require_once( '../libs/times.class.php' );
$dashboard = new Dashboard();
$timer = new timer();
$db = $dashboard->dbObj();
$db->connect();

$sql = "select questions.*
        from questions, term_relationships, terms
        where questions.id = term_relationships.object_id
        and terms.term_id = term_relationships.term_id
        and term_relationships.type = 'field'
        and questions.id = " . $_GET['id'];
$query = $db->query( $sql );
$result = $db->fetch( $query );

?>
<div class="alert alert-success alert-dismissable display-hide spam-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Thao tác thành công!</strong>
</div>
<div class="inbox-header inbox-view-header">
    <h1 class="pull-left"><?php echo $result['title']; ?></h1>
</div>


<div class="inbox-view-info">
    <div class="row">
        <div class="col-md-7">
            <a data-toggle="modal" href="#user_information" class="bold"><?php echo $result['author_name']; ?></a>
            <span>&#60;<?php echo $result['author_email']; ?>&#62;</span> <br />lúc <?php echo $timer->timeFormat( $result['date'], 'H:i A d M Y' ); ?>
            <span id="spam-label" class="label label-default <?php if ( $result['type'] !== 'spam' ) echo 'display-hide'; ?>">Spam</span>
        </div>
        <!-- modal -->
        <div class="modal fade" id="user_information" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true"></button>
                        <h4 class="modal-title">Thông tin</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td>Đối tượng</td>
                                    <td>
                                        <strong>
                                            <?php
                                                if ( $result['i_am'] === 'student' ) {

                                                    echo 'Sinh viên';
                                                } elseif ( $result['i_am'] === 'old-student' ) {

                                                    echo 'Cựu sinh viên';
                                                } else {

                                                    echo 'Phụ huynh';
                                                }
                                            ?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Họ tên</td>
                                    <td><strong><?php echo $result['author_name']; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><strong><?php echo $result['author_email']; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        if ( $result['i_am'] === 'student' ) {

                                            echo 'MSSV';
                                        } elseif ( $result['i_am'] === 'old-student' ) {

                                            echo 'Niên khóa';
                                        } else {

                                            echo 'Số điện thoại';
                                        }
                                        ?>
                                    </td>
                                    <td><strong><?php echo $result['author_stuID']; ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="col-md-5 inbox-info-btn">
            <div class="btn-group">
                <button class="btn blue reply-btn <?php if ( $result['type'] === 'spam' ) echo 'disabled'; ?>" data-action="<?php echo $result['id']; ?>">
                    <i class="icon-reply"></i> Trả lời
                </button>
                <button class="btn blue  dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <?php if ( $result['type'] !== 'spam' ): ?>
                    <li><a href="javascript:;" class="spam_btn" data-action="<?php echo $result['id']; ?>"><i class="icon-ban-circle"></i> Spam</a></li>
                    <?php endif; ?>
                    <li><a href="javascript:;" class="delete_btn" data-action="<?php echo $result['id']; ?>"><i class="icon-trash"></i> Delete Question</a></li>
                 </ul>
            </div>
        </div>
    </div>
</div>
<a id="open_modal" data-toggle="modal" href="#edit_answer"></a>
<!-- modal -->
<div class="modal fade" id="edit_answer" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true"></button>
                <h4 class="modal-title">Chỉnh sửa câu trả lời</h4>
            </div>
            <div class="modal-body form">
                <form id="edit_answer_form" class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label  class="col-md-3 control-label">Nội dung</label>
                            <div class="col-md-9">
                                <textarea class="form-control answer_content" name="answer_content" rows="3"></textarea>
                                <input type="hidden" class="answer_id" />
                            </div>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="col-md-offset-3 col-md-9">
                            <a href="javascript:;" id="submit-btn" class="btn green">Lưu thay đổi</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="inbox-view">
    <?php echo $result['content']; ?>
</div>
<hr>
<div class="inbox-attached">

    <ul class="chats">
    <?php
    $sql = "SELECT tb1.*, tb3.*
            FROM answers as tb1, QA_relationships as tb2, users as tb3
            WHERE tb1.id = tb2.answer_id
            AND tb1.author_id = tb3.user_id
            AND tb2.question_id = " . $result['id'];
    $query = $db->query( $sql );
    while ( $row = $db->fetch( $query ) ) {

        ?>
        <li id="item-<?php echo $row['id']; ?>" class="out">
            <?php
            $sql = "SELECT meta_value FROM user_meta WHERE meta_key = 'profile_img' AND user_id = " . $row['author_id'];
            $q = $db->query( $sql );
            $avatar = $db->fetch( $q )['meta_value'];
            ?>
            <img class="avatar img-responsive" alt="" src="../<?php echo $avatar; ?>" />
            <div class="message">
                <a class="name"><?php echo $row['fullname']; ?></a>
                <span class="datetime">lúc <?php echo $row['date']; ?></span>
                                 <span class="body item-content-<?php echo $row['id']; ?>"><?php echo html_entity_decode($row['content']); ?></span>
                <?php if ( $row['author_id'] == $_SESSION['ithcmute']['user_id'] ) { ?>
                    <br />
                    <span><button class="btn green btn-xs edit_answer" data-action="<?php echo $row['id']; ?>" data-question="<?php echo $result['id']; ?>">Edit</button> | <button class="btn red btn-xs delete_answer_btn" data-action="<?php echo $row['id']; ?>">Delete</button> </span>
                <?php } ?>
            </div>
        </li>
    <?php
    }
    ?>

    </ul>
</div>
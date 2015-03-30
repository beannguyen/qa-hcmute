<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
require_once( '../libs/times.class.php' );
$dashboard = new Dashboard();
$timer = new timer();
$db = $dashboard->dbObj();
$db->connect();

if ( isset( $_GET['question_id'], $_GET['answer_id'] ) ) {

    if ( !is_numeric($_GET['question_id']) || !is_numeric($_GET['answer_id']) ) {
        echo "<h2>Tìm kiếm không hợp lệ.</h2>";
        return;
    }

    $sql = "SELECT * FROM QA_relationships WHERE question_id = ". $_GET['question_id'] ." AND answer_id = " . $_GET['answer_id'];
    $query = $db->query($sql);
    if ( $db->numrows($query) == 0 ) {
        echo "<h2>Không tìm thấy câu hỏi hoặc câu trả lời được yêu cầu!</h2>";
        return;
    }

    $sql = "select questions.*
            from questions, term_relationships, terms
            where questions.id = term_relationships.object_id
            and terms.term_id = term_relationships.term_id
            and term_relationships.type = 'field'
            and questions.id = " . $_GET['question_id'];
    $query = $db->query( $sql );
    $result = $db->fetch( $query );
    ?>
    <form class="inbox-compose form-horizontal" id="fileupload" action="inbox_edit_reply.php" method="POST">
        <div class="inbox-compose-btn">
            <button type="submit" class="btn blue"><i class="icon-check"></i>Send</button>
        </div>
        <div class="inbox-form-group">
            <label class="control-label"><?php echo !( $result['i_am'] == 'admin' ) ? 'Tới:' : ''; ?></label>

            <div class="controls">
                <input type="text" class="form-control" name="to"
                       value="<?php echo $result['author_name']; ?> <?php echo !( $result['i_am'] == 'admin' ) ? '&#60;' . $result['author_email'] . '&#62;' : ''; ?> " disabled>
            </div>
        </div>
        <div class="inbox-form-group">
            <label class="control-label">Tiêu đề:</label>

            <div class="controls">
                <input type="text" class="form-control" name="subject" value="<?php echo $result['title']; ?>" disabled>
            </div>
        </div>
        <div class="inbox-form-group">
            <label class="control-label">Nội dung</label>
            <div class="controls">
                <span style="padding: 5px;"><?php echo html_entity_decode($result['content']); ?></span>
            </div>
        </div>
        <div class="inbox-form-group">
            <label  class="control-label margin-right-20">Chế độ</label>
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="type" id="optionsRadios4" value="public" <?php if ( $result['type'] === 'public' ) echo 'checked'; ?>> Công khai
                </label>
                <label class="radio-inline">
                    <input type="radio" name="type" id="optionsRadios5" value="private" <?php if ( $result['type'] === 'private' ) echo 'checked'; ?>> Riêng tư
                </label>
            </div>
        </div>
        <div class="inbox-form-group">
            <div class="controls-row">
                <?php
                $sql = "SELECT * FROM answers WHERE id = " . $_GET['answer_id'];
                $q = $db->query( $sql );
                $answer = $db->fetch( $q );
                ?>
                <script type="text/javascript" src="../assets/plugins/tinymce/tinymce.min.js"></script>
                <script type="text/javascript">

                    tinymce.init({
                        selector: "textarea.message_edited",
                        theme: "modern",
                        menubar: false,
                        plugins: [
                            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen",
                            "insertdatetime media nonbreaking save table contextmenu directionality",
                            "emoticons template paste textcolor colorpicker textpattern"
                        ],
                        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link preview",
                        setup: function(editor) {
                            editor.on('change', function() {
                                tinyMCE.triggerSave();
                            });
                        }
                    });
                </script>
                <textarea class="inbox-editor form-control message_edited" id="message_edited" name="message_edited" rows="12"><?php echo $answer['content']; ?></textarea>
            </div>
        </div>
        <input type="hidden" name="answer_id" value="<?php echo $answer['id']; ?>">
        <input type="hidden" name="question_id" value="<?php echo $result['id']; ?>">
        <input type="hidden" name="edit_answer" value="1" />
        <div class="inbox-compose-btn">
            <button type="submit" class="btn blue"><i class="icon-check"></i>Send</button>
        </div>
    </form>
<?php } ?>
<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
require_once( '../libs/times.class.php' );
$dashboard = new Dashboard();
$generic = new Generic();
$timer = new timer();
$db = $dashboard->dbObj();
$db->connect();
if ( isset( $_GET['id'] ) ) {

    if ( !is_numeric($_GET['id']) ) {
        echo "<h2>Tìm kiếm không hợp lệ.</h2>";
        return;
    }
    
    $sql = "select questions.*
            from questions, term_relationships, terms
            where questions.id = term_relationships.object_id
            and terms.term_id = term_relationships.term_id
            and term_relationships.type = 'field'
            and questions.id = " . $_GET['id'];
    $query = $db->query( $sql );

    if ( $db->numrows( $query) == 0 ) {
        echo "<h2>Không tìm thấy câu hỏi yêu cầu!</h2>";
        return;
    }
    $result = $db->fetch( $query );
?>

<form class="inbox-compose form-horizontal" id="fileupload" action="inbox_reply.php" method="POST">
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
            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo $result['title']; ?>" >
        </div>
    </div>
    <!-- <div class="inbox-form-group">
        <label class="control-label">Nội dung</label>
        <div class="controls">
            <span style="padding: 5px;"><?php echo html_entity_decode($result['content']); ?></span>
        </div>
    </div> -->
    <div class="inbox-form-group">
        <label  class="control-label margin-right-20">Chế độ</label>
        <div class="radio-list">
            <label class="radio-inline">
                <input type="radio" name="type" id="optionsRadios4" value="public" <?php if ( $result['type'] === 'public' ) echo 'checked'; ?>> Công khai
            </label>
            <?php if ( $result['i_am'] !== 'admin' ) : ?>
            <label class="radio-inline">
                <input type="radio" name="type" id="optionsRadios5" value="private" <?php if ( $result['type'] === 'private' ) echo 'checked'; ?>> Riêng tư
            </label>
            <?php endif; ?>
        </div>
    </div>
    <div class="inbox-form-group">
        <div class="controls-row">
            <textarea class="inbox-editor form-control q_content" id="q_content" name="q_content" rows="12"></textarea>
            <script type="text/javascript" src="../assets/plugins/tinymce/tinymce.min.js"></script>
            <script type="text/javascript">
                tinymce.init({
                    selector: "textarea.q_content",
                    theme: "modern",
                    menubar: false,
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor colorpicker textpattern"
                    ],
                    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link preview",
                    image_advtab: true,
                    setup: function(ed){
                        ed.on("init",
                                function(ed) {
                                tinyMCE.activeEditor.setContent("<?php echo html_entity_decode($result['content']); ?>");
                                tinyMCE.activeEditor.execCommand('mceRepaint');

                                }
                        );
                    }
                });
            </script>
            </div>
        </div>
    </div>
    <input type="hidden" id="question_id" name="question_id" value="<?php echo $result['id']; ?>">
    <input type="hidden" name="edit_question" value="1" />
    <div class="inbox-compose-btn">
        <button type="submit" class="btn blue"><i class="icon-check"></i>Send</button>
    </div>
</form>

    <script type="text/javascript">
        function insertContent(  )
        {
            console.log('loadded');
            var content = "<?php echo html_entity_decode($result['content']); ?>";
            tinyMCE.activeEditor.insertContent("<?php echo html_entity_decode($result['content']); ?>")
        }
    </script>
    <!-- // FORM GOI Y -->
<?php } ?>
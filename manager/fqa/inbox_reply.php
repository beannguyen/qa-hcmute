<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
require_once( '../libs/times.class.php' );
$dashboard = new Dashboard();
$timer = new timer();
$db = $dashboard->dbObj();
$db->connect();
if ( isset( $_GET['id'] ) ) {
    $sql = "select questions.*
            from questions, term_relationships, terms
            where questions.id = term_relationships.object_id
            and terms.term_id = term_relationships.term_id
            and term_relationships.type = 'field'
            and questions.id = " . $_GET['id'];
    $query = $db->query( $sql );
    $result = $db->fetch( $query );
?>
<form class="inbox-compose form-horizontal" id="fileupload" action="inbox_reply.php" method="POST">
    <div class="inbox-compose-btn">
        <button type="submit" class="btn blue"><i class="icon-check"></i>Send</button>
    </div>
    <div class="inbox-form-group mail-to">
        <label class="control-label">Tới:</label>

        <div class="controls controls-to">
            <input type="text" class="form-control" name="to"
                   value="<?php echo $result['author_name']; ?> &#60;<?php echo $result['author_email']; ?>&#62; " disabled>
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
            <textarea class="form-control" rows="3" disabled><?php echo $result['content']; ?></textarea>
        </div>
    </div>
    <div class="inbox-form-group">
        <label  class="control-label">Chế độ</label>
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
            <textarea class="inbox-editor inbox-wysihtml5 form-control" id="message" name="message" rows="12"></textarea>
            <!--blockquote content for reply message, the inner html of reply_email_content_body element will be appended into wysiwyg body. Please refer Inbox.js loadReply() function. -->
            <div id="reply_email_content_body" class="hide">
            </div>
        </div>
    </div>
    <input type="hidden" name="question_id" value="<?php echo $result['id']; ?>">
    <input type="hidden" name="reply" value="1" />
    <div class="inbox-compose-btn">
        <button type="submit" class="btn blue"><i class="icon-check"></i>Send</button>
    </div>
</form>
<?php } ?>
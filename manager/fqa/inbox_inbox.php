<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
require_once( '../libs/urls.class.php' );
require_once( '../libs/pagenavigations.class.php' );
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
        order by questions.date desc";

/* init page navigation plugin */
// current url
$url = BASE_PATH . 'manager/fqa/inbox_inbox.php';
// current page
if ( isset( $_GET['page'] ) )
    $page = $_GET['page'];
else
    $page = 1;

// init
$pager = new PageNavigation($sql, 15, 5, $url, $page, '', 'backend');

// get sql added limit
$newSql = $pager->paginate();

// no result return
if ($newSql == false) {

    echo '<span>Không có dữ liệu</span>';
    goto jump;
}
$query = $db->query( $newSql );
?>
<table class="table table-striped table-advance table-hover">
<thead>
<tr>
    <th colspan="3"></th>
    <th class="pagination-control" colspan="3">
        <span class="pagination-info">Page: <?php echo $page; ?></span>
        <?php echo $pager->renderFullNav(); ?>
    </th>
</tr>
</thead>
<tbody>
<?php
while ( $row = $db->fetch( $query ) ) {

    $sql = "SELECT * FROM QA_relationships WHERE question_id = " . $row['id'];
    $q = $db->query( $sql );
    $nums = $db->numrows( $q );
    ?>
    <tr class="<?php if( $nums == 0 ) echo 'unread'; ?>">
        <td class="inbox-small-cells">
            <input type="checkbox" class="mail-checkbox">
            <input type="hidden" class="question_id" value="<?php echo $row['id']; ?>">
        </td>
        <td class="inbox-small-cells" >
            <?php
            if ( $row['type'] === 'private' )
                echo '<i class="icon-lock"></i>';
            else
                echo '<i class="icon-globe"></i>';
            ?>
        </td>
        <td class="view-message  hidden-xs" data-action="<?php echo $row['id']; ?>"><?php echo $row['author_name']; ?></td>
        <td class="view-message " data-action="<?php echo $row['id']; ?>">
            <?php echo $row['title']; ?>
            <?php if ( $row['type'] === 'spam' ) { ?>
                <span id="spam-label" class="label label-default">Spam</span>
            <?php } elseif ( $nums == 0 ) { ?>
                <span class="badge badge-roundless badge-important">new</span>
            <?php } ?>
        </td>
        <td class="view-message  inbox-small-cells" data-action="<?php echo $row['id']; ?>"></td>
        <td class="view-message  text-right" data-action="<?php echo $row['id']; ?>"><?php echo $timer->timeFormat( $row['date'], 'd/m/Y H:i' ); ?></td>
    </tr>
<?php
}
jump:
?>
</tbody>
</table>
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

/** 
 *  if isset search action 
 *  this query will show search result
 *  if not default is show all questions
 */
if ( isset( $_GET['action'] ) && $_GET['action'] === 'search' ) {

    $data = array();
    if ( isset( $_GET['keyword'] ) ) {
        $data['keyword'] = $dashboard->vietnamese_permalink( $_GET['keyword'] );
    }
    if ( isset( $_GET['question_type'] ) ) {
        $data['type'] = $dashboard->secure( $_GET['question_type']);
    }
    if ( isset( $_GET['question_field'] ) ) {
        $data['field'] = $dashboard->secure( $_GET['question_field'] );
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
    $url = BASE_PATH . 'manager/fqa/questions.php';
    // current page
    if ( isset( $_GET['page'] ) )
        $page = $_GET['page'];
    else
        $page = 1;

    //
    $append = 'action=search';
    if ( isset( $_GET['question_field'] ) && $data['field'] !== 'any' ) {
        $append .= '&question_field=' . $_GET['question_field'];
    }
    if ( isset( $_GET['question_type']) && $data['type'] !== 'any' ) {
        $append .= '&question_type=' . $_GET['question_type'];
    }
    if ( isset( $_GET['keyword'] ) && $data['keyword'] !== '' ) {
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
        while ( $row = $db->fetch( $query_1 ) ) {
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
    <?php
} else {
    echo "No result found!";
}


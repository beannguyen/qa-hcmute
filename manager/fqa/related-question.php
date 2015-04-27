<?php
require_once('../../config.php');
require_once('../libs/dashboard.class.php');
$dashboard = new Dashboard();
$db = $dashboard->dbObj();
$db->connect();
    // get keyword
    $keyword = $_GET['keyword'];
    // search in db
    $sql = "SELECT *, MATCH (title) AGAINST ('" . stripslashes (str_replace ("&quot;", "\"", ($keyword))) . "' IN BOOLEAN MODE) as score
            FROM questions
            WHERE MATCH (title) AGAINST ('" . stripslashes (str_replace ("&quot;", "\"", ($keyword))) . "' IN BOOLEAN MODE)
            AND id != " . $_GET['id'] . "
            AND id IN (select DISTINCT question_id FROM QA_relationships)
            ORDER BY score DESC";
    $query = $db->query( $sql );
?>

<div id="accordion1" class="panel-group">
<?php
    if ( $db->numrows( $query ) > 0 ) {

    $i = 1;
    $j = 0;
    while ( $row = $db->fetch( $query ) ) {
    ?>
    	<div class="panel panel-default">
	    	<div class="panel-heading">
		        <h4 class="panel-title">
		            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_<?php echo $i; ?>">
		            	<?php echo $i; ?>. <?php echo $row['title'] ?> ? 
		            </a>
		        </h4>
	        </div>
            <div id="accordion1_<?php echo $i; ?>" class="panel-collapse <?php if ($i == 1) {
                echo "in";
            } else { echo 'collapse'; } ?>">
                <div class="panel-body">
                    <ul class="chats">
                        <li class="in">
                            <div class="message">
                                <span class="body">
                                    <?php echo html_entity_decode($row['content']); ?>
                                </span>
                            </div>
                        </li>

                        <?php
                            $sql = "SELECT tb1.*, tb3.*
                                                                    FROM answers as tb1, QA_relationships as tb2, users as tb3
                                                                    WHERE tb1.id = tb2.answer_id
                                                                    AND tb1.author_id = tb3.user_id
                                                                    AND tb2.question_id = " . $row['id'];
                                                $q = $db->query( $sql );
                                                if ( $db->numrows( $q ) > 0 ) {

                                                    while ( $r = $db->fetch( $q ) ) {

                                                        ?>
                                                        <li class="out">
                                                            <div class="message">
                                                                <span class="body">
                                                                    <?php echo html_entity_decode($r['content']); ?>
                                                                    <textarea id="copy-me_<?php echo $j; ?>" class="hide"><?php echo ($r['content']); ?></textarea>
                                                                    <br />
                                                                    <!-- <span><button class="btn green btn-xs" id="copy-button_<?php echo $j; ?>" data-clipboard-target="copy-me_<?php echo $j; ?>" title="Click to copy me.">Copy</button></span> -->
                                                                    <span><button class="btn green btn-xs" onclick="insertContent(<?php echo $j; ?>)" title="Nhấn vào để thêm nội dung">Thêm</button></span>

                                                                </span>
                                                            </div>
                                                        </li>
                                                <?php
                                                        $j++;
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        <?php
                                $i++;
                            }
                        } else {

                            echo "Không có câu hỏi tương tự";
                        }
                        ?>
                    </div>
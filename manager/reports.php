<?php
require_once('../config.php');
require_once('libs/dashboard.class.php');
require_once('libs/times.class.php');
$timer = new timer();
$dashboard = new Dashboard();
$db = $dashboard->dbObj();
$db->connect();
?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <?php
        $sql = "SELECT * FROM questions";
        if ( isset( $_GET['start'], $_GET['end'] ) ) {
            $sql .= " WHERE date BETWEEN '". $_GET['start'] ."' AND '". $timer->add( '+1 day', $_GET['end'], 'Y/m/d' ) ."'";
        }
        $query = $db->query($sql);
        ?>
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="icon-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo $db->numrows($query); ?>
                </div>
                <div class="desc">
                    Câu hỏi
                </div>
            </div>
            <a class="more" href="<?php echo BASE_PATH; ?>manager/fqa/questions.php">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>

        <?php
        $sql = "SELECT * FROM users";
        $query = $db->query($sql);
        ?>
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="icon-group"></i>
            </div>
            <div class="details">
                <div class="number"><?php echo $db->numrows($query); ?></div>
                <div class="desc">Thành viên</div>
            </div>
            <a class="more" href="<?php echo BASE_PATH; ?>manager/users/users.php">
                View more <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="icon-bar-chart"></i>Thành viên tích cực</div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên tài khoản</th>
                            <th>Số câu trả lời</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "select users.*, count(answers.id) as nums
                                from users join answers on users.user_id = answers.author_id";

                        if ( isset( $_GET['start'], $_GET['end'] ) )
                            $sql .= " where answers.date between '". $_GET['start'] ."' and '". $timer->add( '+1 day', $_GET['end'], 'Y/m/d' ) ."'";

                        $sql .= " group by answers.author_id
                                order by nums desc
                                limit 10";
                        $query = $db->query($sql);
                        $i = 1;
                        while ($row = $db->fetch($query)) {

                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['nums']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="icon-sitemap"></i>Lĩnh vực phổ biến</div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Lĩnh vực</th>
                            <th>Số câu hỏi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "select t1.name, t2.term_id, count(t2.object_id) as nums
                                from terms as t1, term_relationships as t2, questions as t3
                                where t1.term_id = t2.term_id
                                and t2.object_id = t3.id
                                and t2.type = 'field'";

                        if ( isset( $_GET['start'], $_GET['end'] ) )
                            $sql .= " and t3.date between '". $_GET['start'] ."' and '". $timer->add( '+1 day', $_GET['end'], 'Y/m/d' ) ."'";

                        $sql .= " group by t2.term_id
                                order by nums desc";
                        $query = $db->query($sql);
                        $i = 1;
                        while ($row = $db->fetch($query)) {

                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['nums']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
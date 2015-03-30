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

<link href="manager/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="manager/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
	.title {
		color: #054690;
	    float: left;
	    margin-left: 15px;
	    font: 14px Arial,Helvetica,sans-serif;
	    font-weight: bold;
	    font-family: Tahoma!important;
    	text-transform: uppercase !important;
	}
	.date {
		font-size: 11px;
	    font-style: italic;
	    color: #999;
	}
	ul {
		list-style: none;
	    margin-left: 15px;
	    padding-left: 0;
	}
	li {
		padding-left: 1em;
    	text-indent: -1em;
	}
	li:before {
		content: "►";
    	padding-right: 5px;
	}
</style>
<?php
$sql = "SELECT * FROM questions WHERE questions.type = 'public' AND questions.i_am = 'admin'";
$query = $db->query( $sql );

echo '<div class="col-md-4 col-sm-3">';
echo '<ul>';
$i = 0;
while ($row = $db->fetch($query)) {
	if ( $i == 0 ) {
		?>
			<div class="row">
				<a class="title" href="">Hỏi: <?php echo $row['title'] ?>? - <span class="date"><?php echo $timer->timeFormat($row['date'], 'd/m/Y'); ?></span></a>
				<hr />
			</div>
	<?php
	} else {
		?>
			<li>Hỏi: <a href="#"><?php echo $row['title'] ?>?</a> - <span class="date"><?php echo $timer->timeFormat($row['date'], 'd/m/Y'); ?></span></li>
	<?php 
	}
	?>

<?php
	if ( $i == 6 )
		break;
	else
		$i++;
}
?>
</ul>
</div>

<script src="manager/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="manager/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
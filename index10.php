<?php
require "MySQLConnect.php";
require "PageNavigator.php";

define('PERPAGE', 3);
define('OFFSET', 'offset');

$recordoffset = isset($_GET[OFFSET]) ? $_GET[OFFSET] * PERPAGE : 0 ;
$category = isset($_GET['category']) ? $_GET['category'] : 'LIT';

$strSQL = 'SELECT author, title ' .
            'FROM tblbooks ' .
            "WHERE sold = 0 AND cat = '$category' " .
            "ORDER BY author LIMIT $recordoffset," . PERPAGE;

$con = MySQLConnect::getInstance('localhost', 'root', '');
$rs = $con->createResultSet($strSQL, 'php5book');


/**
 * глава 10 — создаём второе соединение для Exception
 */
//try {
//    $con_die = new MySQLConnect('localhost', 'root', '');
//}
//catch (MySQlException $e) {
//    echo $e;
//    exit();
//}
//catch (Exception $e) {
//    echo $e;
//    exit;
//}


?>

<div style="text-align: center">
    <?php
    foreach ($rs as $row) {
        echo $row[0] . ' - ' . $row[1];
        echo "<br />\n";
    }
    ?>
    <br>
</div>

<?php
$pagename = basename($_SERVER['PHP_SELF']);
$totalrecords = $rs->getUnlimitedNumberRows();
$numpages = ceil($totalrecords / PERPAGE);

$otherparameters = '&amp;category=' . $category;

if ($numpages > 1) {
    $nav = new PageNavigator($pagename, $totalrecords, PERPAGE, $recordoffset, 4, $otherparameters);
    echo $nav->getNavigator();
}

?>

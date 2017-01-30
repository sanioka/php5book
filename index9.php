<?php
require "MySQLConnect.php";
require "PageNavigator.php";

define('PERPAGE', 3);
define('OFFSET', 'offset');
$offset = $_GET[OFFSET];

if (!isset($offset)) {
    $recordoffset = 0;
} else {
    $recordoffset = $offset * PERPAGE;
}

$category = isset($_GET['category']) ? $_GET['category'] : 'LIT';

$strSQL = 'SELECT author, title ' .
            'FROM tblbooks ' .
            "WHERE sold = 0 AND cat = '$category' " .
            "ORDER BY author LIMIT $recordoffset," . PERPAGE;

$con = new MySQLConnect('localhost', 'root', '');
$rs = $con->createResultSet($strSQL, 'php5book');

?>

<div style="text-align: center">
    <?php
    while ($row = $rs->getRow()) {
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

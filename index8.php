<?php
require "PageNavigator.php";
require "ThumbnailImage.php";
require "DirectViewer.php";

define('PERPAGE', 3);
define('OFFSET', 'offset');

if (!isset($_GET[OFFSET])) {
    $totalOffset = 0;
} else {
    $totalOffset = $_GET[OFFSET] * PERPAGE;
}

$directory = 'images';
$di = new DirectViewer($directory);
$filearray = $di->getFileArraySlice($totalOffset, PERPAGE);

echo "<div style=\"text-align: center;\">";
echo "Щелкните по имени файла для полноразмерной картирки
<br />";
$path = '';
$size = 100;
foreach ($filearray as $key => $value) {
    $path = "{$di->getDirectoryName()}/" . $key;
    echo "<img src=\"getthumb.php?path=$path&amp;size=$size\" " .
        "style=\"border: 1px solid black; margin-top: 20px;\" " .
        "alt=\"$value\" /><br />\n";
    echo "<a href=\"$path\" target=\"_blank \" >";
    echo "Заголовок: $value</a> <br />\n";
}
echo "</div><br />";
?>


<?php
/**
 * Блок пагинации
 */
$pagename = basename($_SERVER['PHP_SELF']);
$totalCount = $di->getCount();
$numpages = ceil($totalCount / PERPAGE);

if ($numpages > 1) :
    ?>
    <div style="text-align: center; padding-top: 20px;">
        <?php
        $nav = new PageNavigator($pagename, $totalCount, PERPAGE, $totalOffset);
        $nav->setFirstParamName(OFFSET);
        echo $nav->getNavigator();
        ?>
    </div>
<?php endif; ?>

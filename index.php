<?php

require ('DirectViewer.php');

$directory = 'images';
$directViewer = new DirectViewer($directory);
$filearray = $directViewer->getFileList();

echo "<div style=\"text-align: center;\">";
echo "Щелкните по имени файла для полноразмерной картирки
<br />";
$size = 110;
foreach ($filearray as $key => $value) {
    $path = "$directory/".$key;
    echo "<img src=\"getthumb.php?path=$path&amp;size=$size\" ".
        "style=\"border: 1px solid black; margin-top: 20px;\" ".
        "alt=\"$value\" /><br />\n";
    echo "<a href=\"$path\" target=\"_blank \" >";
    echo "Заголовок: $value</a> <br />\n";
}
echo "</div><br />";


<?php

require ('DirectViewer.php');

$directViewer = new DirectViewer('images');

foreach ($directViewer->getFileList() as $key => $value) {
    echo "$key => $value<br>";
}

<html>
<head>
<title>Images</title>
</head>
<body>
<?php
require 'DirectoryItems.php';
$di =& new DirectoryItems('graphics');
$di->checkAllImages()or die('Not all files are images.');
$di->naturalCaseInsensitiveOrder();
//get portion of array
$filearray = $di->getFileArray();
echo "<div style=\"text-align:center;\">";
foreach ($filearray as $value){
	echo "<img src=\"graphics/$value\" /><br />file name: $value<br />\n";
}
echo "</div><br />";
?>
</body>
</html>

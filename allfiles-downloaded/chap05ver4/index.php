<html>
<head>
<title>Images</title>
</head>
<body>
<?php
require 'DirectoryItems.php';
$di =& new DirectoryItems('graphics');
if(!$di->checkAllImages()){
	$di->imagesOnly();
}
$di->naturalCaseInsensitiveOrder();
//get array
$filearray = $di->getFileArray();
echo "<div style=\"text-align:center;\">";
foreach ($filearray as $key => $value){
	echo "<img src=\"graphics/$key\" /><br />Title: $value<br />\n";
}
echo "</div>";
?>

</body>
</html>

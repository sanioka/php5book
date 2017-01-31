<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Directory Navigation</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="author" content="Peter Lavin" />
<meta http-equiv="Content-Language" content="EN" />
<meta name="copyright" content="copyright softcoded.com" />
<meta name="robots" content="follow, index" />
<meta name="abstract" content="" />
</head>
<body>
<?php
require 'DirectoryItems.php';
$directory = 'graphics';
$di = new DirectoryItems($directory);
$di->imagesOnly();
$di->naturalCaseInsensitiveOrder();
echo "<div style=\"text-align:center;\">";
echo "Click the file name to view full-sized version.<br />";
$filearray = $di->getFileArray();
$path = "";
//specify size of thumbnail
$size = 100;  
foreach ($filearray as $key => $value){
  $path = "$directory/".$key;  
  /*errors in getthumb or in class will result in broken links
  - error will not display*/
  echo "<img src=\"getthumb.php?path=$path&amp;size=$size\" ".
    "style=\"border:1px solid black;margin-top:20px;\" ".
    "alt= \"$value\" /><br />\n";
  echo "<a href=\"$path\" target=\"_blank\" >";
  echo "Title: $value</a> <br />\n";
}
echo "</div><br />";
?>
</body>
</html>

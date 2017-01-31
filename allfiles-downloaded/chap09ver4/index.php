<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Navigator</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="author" content="Peter Lavin" />
<meta http-equiv="Content-Language" content="EN" />
<meta name="copyright" content="copyright softcoded.com" />
<meta name="robots" content="follow, index" />
<meta name="abstract"
content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<!--local style elements here-->
<style type="text/css">
		div.navigator{
			font-size:smaller;
			padding:5px;
			text-align:center;
		}
		div.totalpagesdisplay{
			padding-top:15px;
			font-size:smaller;
			text-align:center;
			font-style:italic;
		}
		.navigator a, span.inactive{
			padding : 0px 5px 2px 5px;
			margin-left:0px;
			border-top:1px solid #999999;
			border-left:1px solid #999999;
			border-right:1px solid #000000;
			border-bottom:1px solid #000000;
		}
			.navigator a:link, .navigator a:visited,
		.navigator a:hover,.navigator a:active{
			color: #3300CC;
			background-color: #FAEBF7;
			text-decoration: none;
		}
		span.inactive{
			background-color :#EEEEEE;
			font-style:italic;
		}
</style>
</head>
<body>
<?php
/*require "connection.php"; put your values in this file
or replace below with literals
 */
require 'connection.php';
require 'MySQLConnect.php';
require 'PageNavigator.php';
//max per page
define("PERPAGE", 5);
define("OFFSET", "offset");
//get query string
$offset=@$_GET[OFFSET];
//check variable
if (!isset($offset)){
	$recordoffset=0;
}else{
	//calc record offset
	$recordoffset=$offset*PERPAGE;
}
$category=@$_GET["category"];
//check variable
if (!isset($category)){
	$category = "LIT";
}
$con = new MySQLConnect($hostname, $username, $password); 
$strsql ="SELECT author, title ".
    "FROM tblbooks ".
    "WHERE sold = 0 AND cat ='$category' ". 
    "ORDER BY author LIMIT $recordoffset,". PERPAGE;
//get recordset
$rs=$con->createResultSet($strsql, $databasename);
echo "<div style=\"text-align:center\">";
while($row = $rs->getRow()){
	echo $row[0]." - ".$row[1];
	echo "<br />\n";
}
echo "<br />";
echo "</div>\n";
$pagename=basename($_SERVER['PHP_SELF']);
//find total number of records
$totalrecords=$rs->getUnlimitedNumberRows();
$numpages = ceil($totalrecords/PERPAGE);
//create category parameter
$otherparameter = "&amp;category=$category";
//create if needed
if($numpages>1){
  //create navigator
  $nav = new PageNavigator($pagename, $totalrecords, PERPAGE, 
	$recordoffset, 4, $otherparameter);
  echo $nav->getNavigator();
}
?>
</body>
</html>

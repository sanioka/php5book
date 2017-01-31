<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>php resources</title>
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="oophp" />
<!--local style elements here-->
<style type="text/css">
</style>
</head>
<body>
<!--resources-->
<h1>php resources</h1>
<div class="sidebar">
<a href =../index.php" >Main</a><br /><br /> 
<a href ="link.php" >Add link</a><br /><br /> 
<a href ="getresources.php" >View Resources</a><br /><br />

</div>
<div class="main">
<?php
//called from link.php
//does add to resources
////////////////////////////////////////////////////////////
function check_third_party($originatingurl, $linkurl){
    //protocol already stripped disregard www.
    if (strpos($linkurl, $originatingurl) !== false ||
        strpos($originatingurl, $linkurl) !== false)
    {
        $error = '';
    }
    else
    {
        $error = ' - No third party links';
    }
    return $error;
}
////////////////////////////////////////////////////////////
function check_listed($url){
    $error = '';
    $db = new SQLiteDatabasePlus('../dbdir/resources.sqlite');
    //remove wildcards and use UDF instead
    $strsql = "SELECT url FROM tblresources ".
              "WHERE url LIKE '%$url%' ";
    $result = $db->query($strsql);
    if ($result->numRows() > 0){
        $error = " - URL already listed";
    }
    return $error;
}
////////////////////////////////////////////////////////////
//main
require '../classes/SQLitedatabasePlus.php';
//try here
try{
    define('TBLNAME','tblresources');
    $db = new SQLiteDatabasePlus('../dbdir/resources.sqlite');
    //ensure field names correct & escape data
    $cleanpost = $db->cleanData($_POST, TBLNAME);
    foreach ($cleanpost as $key=>$value){
        $$key = $value;
    }
    //get url
    $arr = @parse_url($url);
    $url = $arr['host'];
    $error = '';
    if($url != ''){
        $error .= check_listed($url);
    }
    $arr = @parse_url($theirlink);
    $theirlink = $arr['host'];
    if($theirlink != '' ){
        $error .= check_third_party($url, $theirlink);
    }
    //must at least give url and text + no errors
    if ($url != '' && $linktext != '' && $error == '' ){
        //add protocol
        $url = 'http://'. $url;
        $strsql="INSERT INTO ". TBLNAME . " ".
           "(id, url, email, precedingcopy, linktext, ".
           "followingcopy, target, theirlinkpage, reviewed) ".
           "Values(NULL, '$url', '$email', '$precedingcopy', '$linktext', ".
           "'$followingcopy', '_blank', '$theirlinkpage', 0 )";
        //throws exception if unsuccessful
        $db->queryExec($strsql);
        //can't use $db->close();
        $message = "<center>Thank you for your interest in our site.<br />".
            "Your link will be reviewed shortly.</center>";
    }else{
    //ask to retry
        $message = "<center>Thank you for your interest in our site. ".
            "Your url was not added<span style='color:red;'>$error</span>.</center>";
    }
}catch(SQLiteException $e){
    //change for live site
    //Exceptions allow for easier managment
    $message =  $e->getMessage();
}
//not strictly necessary - no OO method
unset($db);
echo $message;
?>
</div>
</body>
</html>


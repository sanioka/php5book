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
<a href ="../index.php" >Main</a><br /><br /> 
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
function check_listed($url, $db){
    $error = '';
    try{
      //remove wildcards and use UDF instead
      $strsql = "SELECT url FROM tblresources ".
              "WHERE url LIKE '%$url%' ";
      $result = $db->query($strsql);
      $row = $result->fetch();      
      if(!empty($row)){
        $error = " - URL already listed";
      }
    }catch(PDOException $e){
      echo $e;
    }
    return $error;
}
////////////////////////////////////////////////////////////
//main
require_once '../includes/dbfunctions.inc';
//try here
try{
    define('TBLNAME','tblresources');
    $db = new PDO('sqlite:resources.sqlite');
    //throw exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //ensure field names correct & escape data
    //not class methods anymore
    setTablenames($db);
    $cleanpost = cleanData($_POST, TBLNAME, $db);
    //quote while looping
    foreach ($cleanpost as $key=>$value){
        $$key = $value;
    }
    //get url
    $arr = @parse_url($url);
    $url = $arr['host'];
    $error = '';
    if($url != ''){
        $error .= check_listed($url, $db);
    }
    $arr = @parse_url($theirlink);
    $theirlink = $arr['host'];
    if($theirlink != '' ){
        $error .= check_third_party($url, $theirlink);
    }    
    //must at least give url and text + no errors
    if ($url != '' && $linktext != '' && $error == '' ){
        //quotes and escapes
        foreach ($cleanpost as $key=>$value){
          $$key = $db->quote($value);
        }
        $strsql="INSERT INTO ". TBLNAME . " ".
           "(id, url, email, precedingcopy, linktext, ".
           "followingcopy, target, theirlinkpage, reviewed) ".
           "Values(NULL, $url, $email, $precedingcopy, $linktext, ".
           "$followingcopy, '_blank', $theirlinkpage, 0 )";
        //throws exception if unsuccessful
        //echo $strsql;
        $db->exec($strsql);
        //can't use $db->close();
        $message = "<center>Thank you for your interest in our site.<br />".
            "Your link will be reviewed shortly.</center>";
    }else{
    //ask to retry
        $message = "<center>Thank you for your interest in our site. ".
            "Your url was not added<span style='color:red;'>$error</span>.</center>";
    }
}catch(PDOException $e){
    //change for live site
    //Exceptions allow for easier managment
    $message = $e;
}
//not strictly necessary - no OO method
unset($db);
echo $message;
?>
</div>
</body>
</html>


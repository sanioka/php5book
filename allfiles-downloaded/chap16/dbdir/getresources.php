<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>php resources</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="oophp" />
<!--local style elements here-->
<style type="text/css">
    ul{
        margin-top: 10px;
        margin-left: 10px;
        padding : 0px 0px 0px 25px;
    }
    div.alphabet{
        padding-bottom:10px;
    }
    div.letter{
        width:1em;
        font-weight:bold;
        background-color:#ddd;
        font-variant : small-caps;
        font-style : italic;
        text-align:center;
        margin:10px 0px 10px 0px;
    }
    span.alpha{
        font-size:8pt;
        background-color:#FAEBF7;
        border-top:1px #ccc solid;
        border-left:1px #ccc solid;
        border-right:1px black solid;
        border-bottom:1px black solid;
    }
    a.alpha{
        font-family: Helvetica, Verdana, Arial, serif;
        font-size: 6pt;
    }
    a.alpha:link, a.alpha:visited, a.alpha:hover
     a.alpha:active{
        color: #3300CC;
        text-decoration: none;
        background-color : transparent;
     }
     a.new:link, a.new:visited, a.new:hover, a.new:active{
        color: #FF0000;
        text-decoration: none;
        background-color : transparent;
    }
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
<div class="main" style="">
<?php
require_once '../includes/dbfunctions.inc';
///////////////////////////////////////////////////////////////////////
function check_when_added($whenadded){
    //less than 2 weeks old
    $type = '';
    if(function_exists('date_default_timezone_set')){
      date_default_timezone_set("Canada/Eastern");
    }
    $diff = floor(abs(strtotime('now') - strtotime($whenadded))/86400);
    if($diff < 15){
        $type = 'new';
    }
    return $type;
}
///////////////////////////////////////////////////////////////////////
function get_alphabet(PDOStatement $result){
    $strtemp = "<div class='alphabet'>";
    foreach ($result as $row){
        $strtemp .= "<span class='alpha'><a class='alpha' ";
        $strtemp .= "href='#$row[0]' >&nbsp;";
        $strtemp .= "$row[0]&nbsp;</a></span>&nbsp;";
    }
    $strtemp .= "</div>\n";
    return $strtemp;
}
////////////////////////////////////////////////////////////////////////
try{
    //change
    $db = new PDO('sqlite:resources.sqlite');
    //change
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    //alphabet view
    $strsql = "SELECT * FROM alphabet";
    $result = $db->query($strsql);
    //change from if($result->rowCount() > 0)
    if(!empty($result)){
      //create alphabet here
      echo get_alphabet($result);
    }
    //register function
    $db->sqliteCreateFunction('cssclass','check_when_added',1);
    $strsql ="SELECT url, precedingcopy, linktext, followingcopy, ".
        "UPPER(SUBSTR(linktext,1,1)) AS letter, ".
        "cssclass(whenadded) AS type, target ".
        "FROM tblresources ".
        "WHERE reviewed = 1 ".
        "ORDER BY letter, UPPER(linktext) ";
    //$result = $db->query($strsql);
    $result = $db->prepare($strsql);
    $result->execute();
    //change from get count
    if(!empty($result)){
        $previous = "";
        foreach ($result as $row){
            foreach ($row as $key => $value){
                $$key = $value;
            }
            if($letter != $previous){
                echo "<p><a id='$letter'></a>".
                "<span class='letter'> ".$letter.
                "</span></p>\n";    
            }
            $strlink = $precedingcopy .
                " <a href='$url' target='$target' class='$type' >".
                 "$linktext</a> $followingcopy<br />\n";
            echo $strlink;
            $previous = $letter;
        }
    }
}catch(PDOException $e){
    //Exceptions allow for easier managment
    echo $e;
}
//no OO method
unset($db); 
?>
</div>
</body>
</html>

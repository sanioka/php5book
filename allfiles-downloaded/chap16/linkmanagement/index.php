<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View all URLs</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="oophp" />
<!--local style elements here-->
<style type="text/css">
thead{
    font-weight:bold;
    padding:10px;
}
#shaded{
    background-color:#ddd;
}
</style>
<script language="JavaScript" type ="text/javascript">
function beforeDelete(idnum, descript){
    var bln = window.confirm("Okay to delete: " + descript + "?");
    //set location if okay
    if(bln){
        location.href = "delete.php?id=" + idnum;
    }
}
</script>
</head>
<body>
<!--resources-->
<h1 style="padding-bottom:30px; border-bottom: 1px dotted black;">URL Update/Removal</h1>
<?php
include "mgmtsidebar.inc";
?>
<div class="main" style="">
<?php
/////////////////////////////////////////////////////////////////////////
//add function to SQLite
function set_class_id(){
    static $x = 0;
    $class = 'unshaded';
    if(($x % 2) == 0){
        $class = "shaded";
    }
    $x++;
    return $class;
}
require '../classes/PageNavigator.php';
//max per page
define("PERPAGE", 10);
//get first parameter
$offset = @$_GET["offset"];
//check variable
if (!isset($offset)){
    $recordoffset = 0;
}else{
    //then calc record offset
    $recordoffset = $offset * PERPAGE;
}
try{
    $db = new PDO('sqlite:../dbdir/resources.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->sqliteCreateFunction('class_id','set_class_id',0);
    $sql = "SELECT id, url, email, ".
        "(precedingcopy || '' || linktext || ' ' || followingcopy) ".
        "AS copy , linktext, reviewed, class_id() AS classid ".
        "FROM tblresources ".
        "ORDER BY id DESC ".
        "LIMIT $recordoffset,". PERPAGE;
    //use arrayQuery
    $stmnt = $db->query($sql);
    $resultarray = $stmnt->fetchAll();
    if(count($resultarray) > 0){
        echo "<table border='0' cellpadding='3' style='width:600px;'>\n".
             "<thead><tr><td>Description</td><td style='width:200px;'>URL</td>".
             "<td>Reviewed</td><td colspan='2'> &nbsp;&nbsp;Action</td></tr></thead>\n".
             "<tr><td colspan='6'><hr /></td></tr>";
        foreach ($resultarray as $row){
            while(list($var, $val)=each($row)) {
                $$var=$val;
            }
            echo "<tr id='$classid'><td>$copy</td><td><a href='$url' ".
                "target='_blank' >$linktext</a></td><td>$reviewed</td>".
                "<td><a href='editurl.php?id=$id'>Edit</a>".
                "</td><td><a href=\"javascript:beforeDelete('$id','$url')\">".
                "Delete</a></td> </tr>\n";
        }
        $pagename = basename($_SERVER['PHP_SELF']);
        //find total number of records
        //get fist column as scalar
        $stmnt = $db->query('Select COUNT(*) FROM tblresources');
        $totalrecords = $stmnt->fetchColumn();
        $numpages = ceil($totalrecords/PERPAGE);
        //create if needed
        if($numpages > 1){
            echo "<tr><td colspan='6'>";
            //create navigator
            $nav = new PageNavigator($pagename, $totalrecords, PERPAGE, $recordoffset );
            $nav->setFirstParamName('offset');
            echo $nav->getNavigator();
            echo '</td></tr>';
        }
        echo '</table>';

    }else{
        echo "Not found!";
    }
}catch(PDOException $e){
    echo "Couldn't connect to database.";
}
catch (Exception $e){
    echo $e;
}
?>
</div>
<?php
$status=@$_GET['status'];
if($status!=""){
    $strscript= "<script type ='text/javascript'>\n".
    "alert('$status');\n".
    "</script>";
    echo $strscript;
}
?>
</body>
</html>


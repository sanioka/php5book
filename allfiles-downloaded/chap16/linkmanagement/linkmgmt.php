<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Link Mgmt</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="template" />
<!--local style elements here-->
<style type="text/css">
</style>
<script language="javascript" type="text/javascript">
</script>
</head>
<body>
<!--resources-->
<h1>URL Update/Removal</h1>
<?php
include "mgmtsidebar.inc";
?>
<div class="main">
<?php
////////////////////////////////////////////////////////////////
$id = @$_GET['id'];
$action = @$_GET['action'];
$pagename = basename($_SERVER['PHP_SELF']);
try{
    $db = new PDO('sqlite:../dbdir/resources.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //choose what to do
    if(empty($action)){
        if(empty($id)){
            //get latest addition
            $sql = 'SELECT MAX(id) FROM tblresources';
            //optimal retrieval with one column
            $stmnt = $db->query($sql);
            $id = $stmnt->fetchColumn();
        }
        //select from view specific link
        $sql = "SELECT * ".
            "FROM specific_link ".
            "WHERE id = '$id'";
        $result = $db->query($sql);
        // must be buffered to get number of rows
        if(!empty($result)){
            $row=$result->fetch();
            $url=$row['url'];
            echo <<<DOC
            <a href='$url' target='_blank'>$url</a> $row[copy]<br /><br />
            <div style ='padding-top:45px:text-align:center;'>
                <a href='$pagename?id=$id&amp;action=ok'>
                Approve</a> &nbsp;<a href='editurl.php?id=$id'>
                Edit</a> &nbsp;<a href='$pagename?id=$id&amp;action=delete'>
                Delete</a>
            </div>\n
DOC;
        }else{
            echo "Not found!";
        }
    //perform action here
    }else{
        echo "<span style='font-size:12pt;font-weight:bold;'>Action taken</span><br />";
        //create sql
        if($action== 'ok'){
            $sql = "UPDATE tblresources SET reviewed = 1 WHERE id = $id";
            $status = "Updated";
        }
        if($action=='delete'){
            //delete from view using trigger
            $sql="DELETE FROM specific_link WHERE id = $id";
            $status="Deleted";
        }
        $db->query($sql);
        unset($db);
        echo "<p>$status</p>";
    }
}catch (PDOException $e){
    echo "Echoing error message: ". $e->getMessage();;
}
?>
</div>
</body>
</html>


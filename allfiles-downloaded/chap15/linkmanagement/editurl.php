<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit/Add URLs</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link rel="stylesheet" type="text/css" href="../style/oophp.css" title="template" />
<!--local style elements here-->
<style type="text/css">
  td{
      vertical-align : top;
  }
  input{
    width:175px;
  }
</style>
</head>
<body>
<!--resources-->
<?php
/////////////////////////////////////
require '../classes/SQLiteDatabasePlus.php';
$id=@$_GET['id'];
//changed to edit if id passed
$type = "Add";
//initialise variables
$url = '';
$precedingcopy = '';
$linktext = '';
$followingcopy = '';
$email = '';
$category = '';
$theirlinkpage = '';
$reviewed = '';
if ($id != ""){
    try{
        $db = new SQLiteDatabasePlus('../dbdir/resources.sqlite');
        $type="Edit";
        //retrieve from db
        $strsql = "SELECT * FROM tblresources ".
            "WHERE id = '$id'";
        //get recordset as row
        $result = $db->unbufferedQuery($strsql);
        $row = $result->fetch();
        //can't use below because returns first column only
        //$row = $db->singleQuery($strsql, false);
        // assume vars same as fields
        while(list($var, $val)=each($row)) {
            $$var=$val;
        }
    }catch(SQLiteException $e){
        //debug msg
        echo  $e->getMessage();
    }
}

?>
<h1><?php echo $type; ?> URL</h1>
<?php
include "mgmtsidebar.inc";
?>
<div class="main" >
<div style="text-align:center; margin:30px; padding:15px;background-color:#eee; width:280px; border:1px black dotted;" >
<form name="frmediturl" action="updateurl.php" method="post" >
<table border="0" cellspacing="0" cellpadding="0" style="width:280px">
<tr>
<td >
<label class="required">URL: </label>
</td>
<td>
<input type="text" name="url" maxlength="150" <?php echo "value='$url'"; ?> />
<br />
</td>
</tr>
<tr  style="text-align:top;">
<td>
<label>Preceding text <br />
(if applicable): </label>
</td>
<td>
<textarea cols="25" rows="3" name = "precedingcopy" ><?php echo $precedingcopy; ?></textarea><br />
</td>
</tr>
<tr>
<td>
<label class="required">Link text: </label>
</td>
<td>
<input type="text" name="linktext" maxlength="150"
<?php echo "value='$linktext'"; ?>
 /><br />
</td>
</tr>
<tr>
<td>
<label>Following text <br />
(if applicable): </label>
</td>
<td>
<textarea cols="25" rows="3" name ="followingcopy" ><?php echo $followingcopy; ?>
</textarea><br />
<br />
</td>
</tr>
<tr>
<td>
<label>Category:</label>&nbsp;&nbsp;&nbsp;
</td><td><select name="category" >
    <option><?php echo $category; ?></option>
    <option>Development</option> 
    <option>Software</option>
    <option>Databases</option>
    <option>Miscellaneous</option> 
</select>
</td>
</tr>
<tr>
<td>
<label>Their Link: &nbsp;</label>
</td>
<td>
<input type="text" name="theirlinkpage"  maxlength="150"
<?php echo "value='$theirlinkpage'"; ?> />
<br />
</td>
</tr>
<tr>
<td>
<label>Contact email: </label>
</td>
<td >
<input type="text" name="email" maxlength="100"  
<?php echo "value='$email'"; ?> />
<br /><br />
</td>
</tr>
<tr style ="height:30px;vertical-align:middle;">
<td colspan ="2" style="text-align:center;">
<label style="width:75px;">Reviewed: </label>
<input type="checkbox" name="reviewed" style="width:25px;"
<?php
if ($reviewed == 1){
  echo "checked";
}
?>
/>
</td>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<input type="hidden" name="id" <?php echo "value='$id'"; ?> />
<input type="submit" value="submit" style="width:50px"   />
<input type="reset" value="clear" style="width:50px"  />
</td>
</tr>
</table>
</form>
</div>
</div>
<?php
$status=@$_GET['status'];
if($status!=""){
    $strscript= "<script type =\"text/javascript\">\n".
        "alert('$status');\n".
        "</script>";
        echo $strscript;
}
?>
</body>
</html>


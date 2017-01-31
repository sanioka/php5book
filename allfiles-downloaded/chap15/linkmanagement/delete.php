<?php
//delete
require '../classes/SQLiteDatabasePlus.php';
$id = $_GET["id"];
$status = 'Deleted';
try{
    $db = new SQLiteDatabasePlus('../dbdir/resources.sqlite');
    $sql="DELETE FROM tblresources ".
         "WHERE id = '$id'";
    $db->query($sql);
}catch(SQLiteException $e){
    $status = $e->getMessage();
}
header("Location:index.php?status=$status.");
?>

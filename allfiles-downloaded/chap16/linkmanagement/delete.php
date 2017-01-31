<?php
//delete
$id = $_GET["id"];
$status = 'Deleted';
try{
    $db = new PDO('sqlite:../dbdir/resources.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="DELETE FROM tblresources ".
         "WHERE id = '$id'";
    $db->query($sql);
}catch(PDOException $e){
    $status = $e->getMessage();
}
header("Location:index.php?status=$status.");
?>

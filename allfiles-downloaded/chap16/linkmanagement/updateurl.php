<?php
////////////////////////////////////////////////////////////
//main
include '../includes/dbfunctions.inc';
try{
    define('TBLNAME','tblresources');
    $db = new PDO('sqlite:../dbdir/resources.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    set_table_names($db);
    $cleanpost = clean_data($_POST, TBLNAME, $db);
    foreach ($cleanpost as $key=>$value){
        $$key = $value;
    }
    //at a minimum the url and linktext must be set
    if($url != '' && $linktext != ''){
        if($reviewed == "on"){
            $reviewed = 1;
        }else{
            $reviewed = 0;
        }
        if ($id != ""){
            $strsql = "UPDATE ". TBLNAME . " ".
                "SET url = '$url', email= '$email', ".
                "precedingcopy = '$precedingcopy', linktext = '$linktext', ".
                "followingcopy= '$followingcopy', target='_blank', ".
                "category='$category', theirlinkpage='$theirlinkpage', ".
                "reviewed=$reviewed ".
                "WHERE id = '$id'";
              $status="Updated.";
        }else{
            $strsql="INSERT INTO ". TBLNAME . " ".
               "(id, url, email, precedingcopy, linktext, ".
               "followingcopy, target, category, theirlinkpage, reviewed) ".
               "Values(NULL, '$url', '$email', '$precedingcopy', ".
               "'$linktext','$followingcopy', '_blank','$category', ".
               "'$theirlinkpage', $reviewed )";
             $status="Added.";
        }
        //not multi-query but can use execute
        $bool = $db->query($strsql);
    }else{
        $status = "Record not altered.";
    }
}catch(PDOException $e){
    //show exception message when debugging
    $status = $e->getMessage();
}
header("Location: index.php?status=$status");
exit;
?>

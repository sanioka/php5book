<?php
////////////////////////////////////////////////////////////
//main
require '../classes/SQLiteDatabasePlus.php';
try{
    define('TBLNAME','tblresources');
    $db = new SQLiteDatabasePlus('../dbdir/resources.sqlite');
    $cleanpost = $db->cleanData($_POST, TBLNAME);
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
        $bool = $db->queryExec($strsql);
    }else{
        $status = "Record not altered.";
    }
}catch(SQLiteException $e){
    //show exception message when debugging
    $status = $e->getMessage();
}
header("Location: index.php?status=$status");
exit;
?>

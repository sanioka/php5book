<?php
//functions for use with PDO sqlite connection
$tablenames = array();
//////////////////////////////////////////////////////////////
/**
 Return clean posted data - check variable names same as field
 names
*/
function clean_data($post, $tablename, $pdo){
  match_names($post, $tablename, $pdo);
  //if on remove slashes
  if(get_magic_quotes_gpc()){
    foreach ($post as $key=>$value){
      $post[$key]=stripslashes($value);
    }
  }
  foreach ($post as $key=>$value){
    $post[$key] = htmlentities($value);
  }
  return $post;
}
//////////////////////////////////////////////////////////////
/**
 Ensure posted form names match table field names
*/
function match_names($post, $tablename, $pdo){
  //check is set
  $fields = get_fields($tablename, $pdo);
  foreach ($post as $name=>$value){
    if (!array_key_exists($name, $fields)){
      $message = "No matching column for $name in table $tablename.";
      throw new PDOException($message);
    }
  }
}
/////////////////////////////////////////////////////////////
/**
 Retrieve field names/types for specified table
 syntax SQLite specific
*/
function get_fields($tablename, $pdo){
  global $tablenames;
  if (!in_array($tablename, $tablenames)){
    throw new PDOException("Table $tablename not in database.");
  }
  $fieldnames = array();
  $sql = "PRAGMA table_info('$tablename')";
  $result = $pdo->query($sql);
  //no error - bad pragma ignored
  //get name and data type as defined upon creation
  foreach ($result as $row){
    $fieldnames[$row['name']] = $row['type'];
  }
  return $fieldnames;
}
//////////////////////////////////////////////////////////////
//
/**
initializes table names array
SQL SQLite specific
*/
function set_table_names($pdo){
  global $tablenames;
  $sql = "SELECT name FROM sqlite_master ".
    "WHERE type = 'table' OR type = 'view'";
  $result = $pdo->query($sql);
  foreach($result as $row){
    $tablenames[] = $row['name'];
  }
}
//end functions
?>
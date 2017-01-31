<?php
//////////////////////////////////////////////////////////////
/**
 Extend SQLiteDatabase and throw exceptions when creating
 result sets - also add utility functions
*/
class SQLiteDatabasePlus extends SQLiteDatabase{
    private $tablenames;
//////////////////////////////////////////////////////////////
//public functions related to queries
/**
Override function
*/
    public function query($strsql, $type = SQLITE_BOTH, &$err_msg = ''){
    //SQLiteResult query ( string query [, int result_type [, string &error_msg]] )
        if ( false === $result = parent::query($strsql, $type, $err_msg)){
            //no sql details with last error
            throw new SQLiteException (sqlite_error_string($this->lastError()));
        }
        return $result;
    }
//////////////////////////////////////////////////////////////
/**
Override function
*/
    public function unbufferedQuery($strsql, $type = SQLITE_BOTH, &$err_msg = ''){
        //SQLiteUnbuffered unbufferedQuery ( string query [, int result_type [, string &error_msg]] )
        if ( false === $result = parent::unbufferedQuery($strsql, $type, $err_msg)){
            throw new SQLiteException (sqlite_error_string($this->lastError()));
        }
        return $result;
    }
//////////////////////////////////////////////////////////////
/**
Override function
*/
   public function singleQuery($strsql, $first_column = true, $bin_decode = false){
       //array sqlite_single_query ( resource db, string query [, bool first_row_only [, bool decode_binary]] )
        if ( false === $result = parent::singleQuery($strsql, $first_column, $bin_decode)){
            throw new SQLiteException (sqlite_error_string($this->lastError()));
        }
        return $result;
    }
//////////////////////////////////////////////////////////////
/**
Override function
*/
   public function queryExec($strsql, &$err_msg = ''){
       //bool queryExec ( string query [, string &error_msg] )
       if ( !parent::queryExec($strsql, $err_msg)){
            throw new SQLiteException (sqlite_error_string($this->lastError()));
       }
       return true;
   }
//////////////////////////////////////////////////////////////
/**
Override function
*/
    public function arrayQuery($strsql, $type = SQLITE_BOTH, $bin_decode = false ){
   //array arrayQuery ( string query [, int result_type [, bool decode_binary]] )
       if ( false === $result = parent::arrayQuery($strsql, $type, $bin_decode)){
            throw new SQLiteException (sqlite_error_string($this->lastError()));
       }
       return $result;
   }
//////////////////////////////////////////////////////////////
/**
 Return clean posted data - check variable names same as field
 names
*/
    public function cleanData($post, $tablename){
        if (!isset($this->tablenames)){
            $this->setTablenames();
        }
        $this->matchNames($post, $tablename);
        //if on remove slashes
        if(get_magic_quotes_gpc()){
            foreach ($post as $key=>$value){
                $post[$key]=stripslashes($value);
            }
        }
        foreach ($post as $key=>$value){
            $post[$key] = htmlentities(sqlite_escape_string($value));
        }
        return $post;
    }
//////////////////////////////////////////////////////////////
/**
 Ensure posted form names match table field names
*/
    public function matchNames($post, $tablename){
        //check is set
        if (!isset($this->tablenames)){
            $this->setTablenames();
        }
        if (count($post) == 0){
            throw new SQLiteException("Array not set.");
        }
        $fields = $this->getFields($tablename);
        foreach ($post as $name=>$value){
            if (!array_key_exists($name, $fields)){
                $message = "No matching column for $name in table $tablename.";
                throw new SQLiteException($message);
            }
        }
    }
//////////////////////////////////////////////////////////////
/**
 Get all table names in database
*/
    public function getTableNames(){
        if (!isset($this->tablenames)){
            $this->setTablenames();
        }
        return $this->tablenames;
    }
/////////////////////////////////////////////////////////////
/**
 Retrieve field names/types for specified table
*/
    public function getFields($tablename){
        if (!isset($this->tablenames)){
            $this->setTablenames();
        }
        if (!in_array($tablename, $this->tablenames)){
            throw new SQLiteException("Table $tablename not in database.");
        }
        $fieldnames = array();
        $sql = "PRAGMA table_info('$tablename')";
        $result = $this->unbufferedQuery($sql);
        //no error - bad pragma ignored
        //get name and data type as defined upon creation
        foreach ($result as $row){
            $fieldnames[$row['name']] = $row['type'];
        }
        return $fieldnames;
    }
//////////////////////////////////////////////////////////////
//private methods
/**
 private method - initializes table names array
*/
    private function setTableNames(){
        $sql = "SELECT name ".
            "FROM sqlite_master ".
            "WHERE type = 'table' ".
            "OR type = 'view'";
        $result = $this->unbufferedQuery($sql);
        foreach  ($result as $row){
            $this->tablenames[] = $row['name'];
        }
    }
}//end class
?>


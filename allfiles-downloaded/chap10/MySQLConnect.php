<?php
require 'MySQLException.php';
require 'MySQLResultSet.php';
////////////////////////////////////////////////////////////////////
class MySQLConnect{
  //data members
  private $connection;
  private static $instances = 0;
  const ONLY_ONE_INSTANCE_ALLOWED = 5000;
////////////////////////////////////////////////////////////////////
//constructor
////////////////////////////////////////////////////////////////////
public function __construct($hostname, $username, $password){
    if(MySQLConnect::$instances == 0){
      if(!$this->connection = mysql_connect($hostname, $username,$password )){
        throw new MySQLException(mysql_error(), mysql_errno());
      }
      MySQLConnect::$instances = 1;
    }else{
      $msg = "Close the existing instance of the ".
        "MySQLConnect class.";
      throw new MySQLException($msg, self::ONLY_ONE_INSTANCE_ALLOWED);
    }
}
////////////////////////////////////////////////////////////////////
//destructor
////////////////////////////////////////////////////////////////////
  public function __destruct(){
    $this->close();
  }
////////////////////////////////////////////////////////////////////
//public methods
////////////////////////////////////////////////////////////////////
  public function createResultSet($strSQL, $databasename){
    $rs = new MySQLResultSet($strSQL, $databasename, $this->connection );
    return $rs;
  }
//////////////////////////////////////////////////////////////////// 
  public function getConnection(){
    return $this->connection;
  }
//////////////////////////////////////////////////////////////////// 
  public function getVersionNumber(){
    //mysql_get_server_info
    return mysql_get_server_info();
  }
////////////////////////////////////////////////////////////////////
  public function close(){
    MySQLConnect::$instances = 0;
    if(isset($this->connection)){
      mysql_close($this->connection);
      unset($this->connection);
    }
  }
}//end class
////////////////////////////////////////////////////////////////////
?>

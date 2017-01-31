<?php
////////////////////////////////////////////////////////////////////
class MySQLException extends Exception{
  //no new data members
  public function __construct($message, $errorno){
    //check for programmer error
    if($errorno >= 5000){
      $message = __CLASS__  ." type. Improper class usage. ". $message;
    }else{
      $message = __CLASS__  . " - ". $message;
    }
    //call the Exception constructor
    parent::__construct($message, $errorno);
  }
  //override __tostring
  public function __toString(){
    return ("Error: $this->code - $this->message");
  }
}
?>

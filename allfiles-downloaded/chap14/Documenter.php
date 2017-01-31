<?php
/**
This class extends ReflectionClass and is used to document classes.
*/
class Documenter extends ReflectionClass{
  //arrays of methods
  private $publicmethods        = array();
  private $protectedmethods     = array();
  private $privatemethods       = array();
  //arrays of data members
  private $publicdatamembers    = array();
  private $protecteddatamembers = array();
  private $privatedatamembers   = array();
///////////////////////////////////////////////////////////////////  
/**
Call methods to set up arrays after constructing parent.
*/
  public function __construct($name){
    parent::__construct($name);
    $this->createDataMemberArrays();
    $this->createMethodArrays();
  }
///////////////////////////////////////////////////////////////////  
/** 
Returns whether class is internal or user-defined. 
*/  
  public function getClassType(){
    if($this->isInternal()){
      $type = "Internal";
    }else{
      $type = "User-defined";
    }
    return $type;
  }
///////////////////////////////////////////////////////////////////  
/** 
Returns description of class and inheritance 
*/
///////////////////////////////////////////////////////////////////   
  public function getFullDescription(){
    $description = "";
    if ($this->isFinal()){
      $description = "final ";
    }
    if($this->isAbstract()){
      $description = "abstract ";
    }
    if($this->isInterface()){
      $description .= "interface ";
    }
    else{
      $description .= "class ";
    }
    $description .= $this->name . " ";
    if($this->getParentClass()){
      $name =  $this->getParentClass()->getName();
      $description .= "extends $name ";
    }
    $interfaces = $this->getInterfaces();
    $number = count($interfaces);
    if( $number > 0){
      $counter = 0;
      $description .= "implements ";
      foreach ($interfaces as $i){        
        $description .= $i->getName();
        $counter ++;
        if($counter != $number){
          $description .= ", ";
        }
      }    
    }
    
    return $description;
  }
///////////////////////////////////////////////////////////////////  
  public function getPublicMethods(){
    return $this->publicmethods;
  }
///////////////////////////////////////////////////////////////////  
  public function getProtectedMethods(){
    return $this->protectedmethods;
  }
///////////////////////////////////////////////////////////////////  
  public function getPrivateMethods(){
    return $this->privatemethods;
  }
///////////////////////////////////////////////////////////////////  
/**
Use the static method of the Reflection class
to get all modifiers - use with both properties 
and methods.
*/
///////////////////////////////////////////////////////////////////  
  public function getModifiers($r){
    if ($r instanceof ReflectionMethod ||
          $r instanceof ReflectionProperty){
      $arr = Reflection::getModifierNames($r->getModifiers());
      $description = implode(" ", $arr );
    }else{
      $msg = "Must be ReflectionMethod or ReflectionProperty";
      throw new ReflectionException( $msg );
    }
    return $description;
  }
///////////////////////////////////////////////////////////////////  
  public function getPublicDataMembers(){
    return $this->publicdatamembers;
  }
///////////////////////////////////////////////////////////////////  
  public function getPrivateDataMembers(){
    return $this->privatedatamembers;
  }
///////////////////////////////////////////////////////////////////  
  public function getProtectedDataMembers(){
    return $this->protecteddatamembers;
  }
///////////////////////////////////////////////////////////////////  
//private methods
///////////////////////////////////////////////////////////////////  
/** create arrays of methods and set modifiers */
  private function createMethodArrays(){
    $methods = $this->getMethods();
    //returns ReflectionMethod array
    foreach ($methods as $m){      
      $name = $m->getName();
      if($m->isPublic()){      
        $this->publicmethods[$name] = $m;
      }
      if($m->isProtected()){
        $this->protectedmethods[$name] = $m;
      }
      if($m->isPrivate()){
        $this->privatemethods[$name] = $m;
      }
    }
  }
///////////////////////////////////////////////////////////////////  
/** Set up data member arrays by type */
  private function createDataMemberArrays(){    
    //ReflectionProperty[] getProperties()
    $properties = $this->getProperties();
    foreach ($properties as $p){      
      $name = $p->getName();
      if($p->isPublic()){      
        $this->publicdatamembers[$name] = $p;
      }
      if($p->isPrivate()){      
        $this->privatedatamembers[$name] = $p;
      }
      if($p->isProtected()){      
        $this->protecteddatamembers[$name] = $p;
      }
    }
  }
}//end of class
/////////////////////////////////////////////////////////////////////
?>

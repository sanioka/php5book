<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Reflection</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="author" content="Peter Lavin" />
<meta http-equiv="Content-Language" content="EN" />
<meta name="robots" content="FOLLOW,INDEX" />
<meta name="abstract"
content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<!--local style elements here-->
<style type="text/css">
body{
  font-family: courier;
  font-size: 10pt;
}
div{
  font-family: verdana, arial, helvetica, sans-serif;
}
h1, h2, h3, h4{
  color:#666;
  font-family: verdana, arial, helvetica, sans-serif;
  background-color:#bbb;
}
h1 { 
  font-size: 170%; 
}
h2 {
  font-size: 150%; 
}
h3 { 
  font-size: 120%; 
}
h4 { 
  font-size: 100%;
}
td.top{
  padding-bottom:5px;
  border-bottom:dotted 1px black;
}
td.centre{
  width:80%;
  vertical-align:top;
  border-left: 1px dotted black; 
  padding-left:15px;padding-top:10px;
}
span.keyword{
  color:blue;
  font-weight: bold;  
}
span.name{
  font-weight: bold;
}
span.comment{
  font-style:italic;
}
span.fulldescription{
  font-size: larger; 
}
label{
  font-family: verdana, arial, helvetica, sans-serif;
}
@media print{
  body{ 
    margin:0px; 
  }
  /* bug in Firefox - span font can't be courier*/
  span{    
    font-family: helvetica;
  }
  td.top{
    border:none;
  }
  td.centre{
    border:none;
  }
  td.sidebar{
    display:none;
  }  
  h1, h2, h3, h4{
    background-color: #fff;
  }
}
</style>
</head>
<body>
<table style="width:770px;">
<tr>
<td colspan="2" class="top" >
<h1 style="background-color:#fff">PHP Classes &amp; Interfaces</h1>
</td>
</tr>
<tr>
<td style="width:20%; vertical-align:top;padding-top:10px;" class="sidebar">
<?php
include 'MySQLException.php';
include 'Documenter.php';
$arr = get_declared_classes();
natcasesort($arr);
$classname = @$_GET["class"];
if(!isset($classname)){
  $classname = current($arr);
}
echo "<h4 style=\"background-color:#fff;\">Classes</h4>";
foreach($arr as $value){
  echo "<a href=\"getclass.php?class=$value\">".
    "$value</a><br />\n";
}
$arr = get_declared_interfaces();
natcasesort($arr);
echo "<h4 style=\"background-color:#fff;\">Interfaces</h4>";
foreach($arr as $key => $value){
  echo "<a href=\"getclass.php?class=$value\">".
    "$value</a><br />\n";
}
?>
</td>
<td class="centre" >
<?php
//////////////////////////////////////////////////////////////////////
function get_params(ReflectionParameter $p){  
  $description = "";
  //is it an object?
  $c = $p->getClass();
  if(is_object($c)){
    $description .= $c->getName() . " ";
  }
  $description .= "\$" . $p->getName();
  //check default
  if ($p->isDefaultValueAvailable()){
    $val = $p->getDefaultValue();
    //could be empty string
    if($val == ""){
      $val = "\"\"";
    }
    $description .= " = $val";
  }  
  return $description;
}
//////////////////////////////////////////////////////////////////////
//Note: type hinting arrays requires ver 5.1 +
//////////////////////////////////////////////////////////////////////
function show_methods(Documenter $d, $type, $arr){
  echo "<h3>$type</h3>";
  foreach($arr as $key => $value){  
    echo "<p><span class=\"keyword\">".
      $d->getModifiers($value). "</span> ".
      "<span class=\"name\">$key</span>\n";
    //add parameters using method of ReflectionMethod
    $params = $value->getParameters();
    $number= $value->getNumberOfParameters();
    $counter = 0;
    echo "( " ; 
    foreach($params as $p){    
      echo get_params($p);
      $counter ++;
      if($counter != $number){
        echo ", ";
      }
    }
    echo " )" ;
    if($value->isUserDefined()){
      echo " user-defined<br />";
    }
    if($value->getDocComment()){
      echo "<span class=\"comment\">";
      echo $value->getDocComment() . "</span><br />";
    }
    echo "</p>";
  }
}
//////////////////////////////////////////////////////////////////////
function show_data_members(Documenter $d, $type, $arr){
  $arrdefaultvalue = $d->getDefaultproperties();
  echo "<h3>$type</h3>\n";
  foreach($arr as $key => $value){  
    $strtemp = "<p><span class=\"keyword\">".
      $d->getModifiers($value) . "</span> ".
      "<span class=\"name\">$key</span>";
    if ( isset($arrdefaultvalue[$key]) ){
      $val = $arrdefaultvalue[$key];
      //note - Boolean values have no value
      if(!is_numeric($val)){
        if (is_array($val)){
          $val = " array()";
        }else{
          $val = "\"$val\"";
        }        
      }
      $strtemp .= " = $val";
      /* getDocComment() for properties was added in PHP 5.1.0. 
      but doesn't work till 5.1.3 */
      /*if($value->getDocComment()){
        $strtemp .= "<br /><span class=\"comment\">";
        $strtemp .= $value->getDocComment() . "</span><br />";
      }*/
    }
    echo $strtemp;
    echo "</p>\n";
  }
}
//////////////////////////////////////////////////////////////////////
//main
try{
  $class = new Documenter($classname);
  echo "<h2>Name: ". $class->getName() . "</h2>\n";
  if(function_exists('date_default_timezone_set')){
    date_default_timezone_set("Canada/Eastern");
  }
  $today = date("M-d-Y");
  echo "<p> Date: $today<br />";
  echo "PHP version: ". phpversion() . "<br />";
  echo "Type: ". $class->getClassType() . "<br /><br />\n";
  echo "<span class=\"fulldescription\">". $class->getFullDescription().
         "</span><br /><br />\n";
  echo "<span class=\"comment\">";
  echo $class->getDocComment() . "</span></p>\n";  
  $arr = $class->getPublicMethods();
  if (count ($arr) > 0){
    show_methods($class, "Public Methods", $arr);
  }
  $arr = $class->getProtectedMethods();
  if (count($arr) > 0){
    show_methods($class, "Protected Methods", $arr);
  }
  $arr = $class->getPrivateMethods();
  if (count($arr) > 0){
    show_methods($class, "Private Methods", $arr);
  }
  //now do data members
  $arr = $class->getPublicDataMembers();
  if (count($arr) > 0){
    show_data_members($class, "Public Data Members", $arr);
  }
  $arr = $class->getProtectedDataMembers();
  if (count($arr) > 0){
    show_data_members($class, "Protected Data Members", $arr);
  }
  $arr = $class->getPrivateDataMembers();
  if (count($arr) > 0){
    show_data_members($class, "Private Data Members", $arr);
  }
  $arr = $class->getConstants();
  if (count($arr) > 0){
    echo "<h3>Constants</h3>\n";
    foreach ($arr as $key => $value){
      echo "<p><span class=\"keyword\">const</span> ".
        "<span class=\"name\">$key</span> = $value <br /></p>\n";
    }
  }
}
catch (ReflectionException $e){
  echo "<div style=\"color:red; font-size: 12pt; font-weight: bold;\">";
  echo "ReflectionException<br /><br /></div>";
  echo $e;
}
?>
</td>
</tr>
</table>
</body>
</html>

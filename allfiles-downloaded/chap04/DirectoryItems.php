<?php
class DirectoryItems{
	//data members
	var $filearray = array();
////////////////////////////////////////////////////////////////////
//constructor
////////////////////////////////////////////////////////////////////
  function DirectoryItems($directory){
		$d = '';
  	if(is_dir($directory))
		{
  		$d = opendir($directory) or die("Couldn't open directory.");
  		while(false !== ($f = readdir($d)))
			{
    		if(is_file("$directory/$f"))
				{
					$this->filearray[]=$f;
    		}
  		}
			closedir($d);
		}else{
			//error
			die('Must pass in a directory.');
		}
	}
////////////////////////////////////////////////////////////////////
//public functions
////////////////////////////////////////////////////////////////////
	function indexOrder(){
		sort($this->filearray);
	}
////////////////////////////////////////////////////////////////////
	function naturalCaseInsensitiveOrder(){
		natcasesort($this->filearray);
	}
////////////////////////////////////////////////////////////////////
	function checkAllImages(){
		$bln=true;
		$extension='';
		$types= array('jpg', 'jpeg', 'gif', 'png');
		foreach ($this->filearray as $value){
			$extension = substr($value,(strpos($value, ".")+1));
			$extension = strtolower($extension);
			if(!in_array($extension, $types)){
				$bln = false;
				break;
			}
		}
		return $bln;
	}
////////////////////////////////////////////////////////////////////
	function getCount() {
		return count($this->filearray);
	}
////////////////////////////////////////////////////////////////////
	function getFileArray(){
		return $this->filearray;
	}
}//end class
////////////////////////////////////////////////////////////////////
?>

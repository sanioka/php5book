<?php

class DirectViewer
{
    private $directory;
    private $filelist;
    private $filerules = ['jpg', 'png', 'gif'];

    public function __construct($directory)
    {
        if (is_dir($directory)) {
            $this->directory = $directory;
            $this->getFilesFromDirectory();
        } else {
            throw new Exception('Не найдена директория '.$directory);
        }
    }



    public function getFilesFromDirectory() {
        if ($handle = opendir($this->directory)) {

            while (false !== ($entry = readdir($handle))) {
                if (is_file("$this->directory/$entry")) {
                    $this->filelist[$entry] = $this->createTitle($entry);
                }
            }

            closedir($handle);

            $this->filterFilesByRules();
        }
    }

    public function getFileList() {
        return $this->filelist;
    }

    private function filterFilesByRules() {

        $temp = [];

        foreach ($this->filelist as $key => $title) {
            foreach ($this->filerules as $rule) {
                if (strpos($key, $rule) != 0) {
                    $temp[$key] = $title;
                    break;
                };
            };
        };

        natcasesort($temp);
        $this->filelist = $temp;
    }

    private function createTitle($value) {
        $title = substr($value,0,strrpos($value,'.'));
        return $title;
    }

}
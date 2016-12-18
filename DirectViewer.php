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
            throw new Exception('Не найдена директория ' . $directory);
        }
    }


    public function getFilesFromDirectory()
    {

        $this->filelist = [];

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

    public function getFileList()
    {
        return $this->filelist;
    }

    private function filterFilesByRules()
    {
        foreach ($this->filelist as $key => $title) {
            $extention = strtolower(substr($key, (strpos($key, '.') + 1)));
            if (!in_array($extention, $this->filerules)) {
                unset($this->filelist[$key]);
            };
        };
        natcasesort($this->filelist);
    }

    private function createTitle($value)
    {
        $title = substr($value, 0, strrpos($value, '.'));
        return $title;
    }

    public function getFileArraySlice($start, $numberitems) {
        return array_slice($this->filelist, $start, $numberitems);
    }

    public function getDirectoryName() {
        return $this->directory;
    }

    public function getCount() {
        return count($this->filelist);
    }
}
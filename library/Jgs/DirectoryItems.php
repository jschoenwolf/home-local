<?php

/**
 * Description of Jgs_DirectoryItems
 *
 * @author John Schoenwolf
 */
class Jgs_DirectoryItems
{
    private $fileArray = array();
    private $replaceCharacter;
    private $directory;

    public function __construct($directory, $replaceCharacter = "_")
    {
        $this->directory        = $directory;
        $this->replaceCharacter = $replaceCharacter;

        $dir = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $it  = new RecursiveIteratorIterator($dir);

        $files = array();
        foreach ($it as $value) {
            $files[$value->getFilename()] = $value;
        }
        return $files;
    }

    public function __destruct()
    {
        unset($this->fileArray);
    }

    public function getDirectoryName()
    {
        return $this->directory;
    }

    public function indexOrder()
    {
        sort($this->fileArray);
    }

    public function naturalCaseInsensitiveOrder()
    {
        natcasesort($this->fileArray);
    }

    public function checkAllImages()
    {
        $boolean = TRUE;
        //$extension = "";
        $types   = array("jpg", "jpeg", "gif", "png");

        foreach ($this->fileArray as $key => $value) {
            $extension = substr($value, (strpos($value, ".") + 1));
            $extension = strtolower($extension);

            if (!in_array($extension, $types)) {
                $boolean = FALSE;
                break;
            }
        }
        return $boolean;
    }

    public function checkAllSpecificType($extension)
    {
        $extension = strtolower($extension);
        $boolean   = TRUE;
        //$ext       = "";

        foreach ($this->fileArray as $key => $value) {
            $extString = substr($key, (strpos($key, ".") + 1));
            $ext       = strtolower($extString);

            if ($extension != $ext) {
                $boolean = FALSE;
                break;
            }
        }
        return $boolean;
    }

    public function getCount()
    {
        return count($this->fileArray);
    }

    public function getFileArray()
    {
        return $this->fileArray;
    }

    public function getFileArraySlice($start, $numberitems)
    {
        return array_slice($this->fileArray, $start, $numberitems);
    }

    public function filter($extension)
    {

        $extension = strtolower($extension);

        foreach ($this->fileArray as $key => $value) {
            $extString = substr($key, (strpos($key, ".") + 1));
            $ext       = strtolower($extString);

            if ($ext != $extension) {
                unset($this->fileArray [$key]);
            }
        }
    }

    public function imagesOnly()
    {
        // $extension = "";
        $types = array("jpg", "jpeg", "gif", "png");

        foreach ($this->fileArray as $key => $value) {
            $ext       = substr($key, (strpos($key, ".") + 1));
            $extension = strtolower($ext);

            if (!in_array($extension, $types)) {
                unset($this->fileArray[$key]);
            }
        }
    }

    public function removeFilter()
    {
        unset($this->fileArray);
        //$dir = "";
        $dir = opendir($this->directory) or die("Couldn't open the directory");

        while (FALSE !== ($file = readdir($dir))) {

            if (is_file("$this->directory/$file")) {
                $title                  = $this->createTitle($file);
                $this->fileArray[$file] = $title;
            }
        }
        closedir($dir);
    }

    private function createTitle($title)
    {
        //strip extension
        $titleNoExt = substr($title, 0, strpos($title, "."));
        // replace seperator
        $title      = str_replace($this->replaceCharacter, " ", $titleNoExt);

        return $title;
    }
}

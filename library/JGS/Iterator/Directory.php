<?php

/**
 * Real Recursive Directory Iterator
 */
class JGS_Iterator_Directory extends RecursiveIteratorIterator {
  /**
   * Creates Real Recursive Directory Iterator
   * @param string $path
   * @param int $flags
   * @return DirectoryIterator
   */
  public function __construct($path, $flags = 0) {
      
    parent::__construct(new RecursiveDirectoryIterator($path, $flags));
  }
}




//Some examples:


/* @var $i DirectoryIterator */

//foreach (new AdvancedDirectoryIterator('.') as $i) echo $i->getPathname() . '<br/>';
// will output all files and directories in CWD

//foreach (new AdvancedDirectoryIterator('-R *.php') as $i) echo $i->getPathname() . '<br/>';
// will output all php files in CWD and all subdirectories

//foreach (new AdvancedDirectoryIterator('-R js/jquery-*.js') as $i) echo $i->getPathname() . '<br/>';
// will output all jQuery versions in directory js, or throw an exception if directory js doesn't exist




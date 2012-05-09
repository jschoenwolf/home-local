<?php

/**
 * Real RecursiveDirectoryIterator Filtered Class
 * Returns only those items which filenames match given regex
 */
class JGS_Iterator_Advanced extends FilterIterator
{
    /**
     * Regex storage
     * @var string
     */
    private $regex;

    /**
     * Creates new AdvancedDirectoryIterator
     * @param string $path, prefix with '-R ' for recursive, postfix with /[wildcards] for matching
     * @param int $flags
     * @return DirectoryIterator
     */
    public function __construct($path, $flags = 0) {

        if (strpos($path, '-R ') === 0) {
            $recursive = true;
            $path = substr($path, 3);
        }
        // matched wildcards in filename
        if (preg_match('~/?([^/]*\*[^/]*)$~', $path, $matches)) {
            // strip wildcards part from path
            $path = substr($path, 0, -strlen($matches[1]) - 1);
            // convert wildcards to regex
            $this->regex = '~^' . str_replace('*', '.*',
                            str_replace('.', '\.', $matches[1])) . '$~';
            // if no path given, we assume CWD
            if (!$path)
                $path = '.';
        }
        parent::__construct($recursive ? new JGS_Iterator_Directory($path, $flags = NULL) : new DirectoryIterator($path));
    }

    /**
     * Checks for regex in current filename, or matches all if no regex specified
     * @return bool
     */
    public function accept() {
        // FilterIterator method
        return $this->regex === null ? true : preg_match($this->regex,
                        $this->getInnerIterator()->getFilename());
    }
}

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * General Purpose Utility Class
 *
 * @author John Schoenwolf
 * @copyright 2012
 */
class Jgs_Application_Utilities
{

    /**
     * Trim leading two path segements off of path uri.
     *
     * @param int $toRemove
     * @param string $path
     * @return string
     */
    public function trimPath($path, $toRemove = 1) {

        $seg = explode('\\', $path);

        for ($i = 1; $i <= $toRemove; $i++) {
            array_shift($seg);
        }

        $result = implode('/', $seg);
        return $result;
    }

    /**
     * recursively trims an array to remove excess whitespace.
     *
     * @param array $array
     * @return array
     */
    public function arrayTrim($array) {
        if (is_string($array)) {
            return trim($array);
        } else if (!is_array($array)) {
            return '';
        }
        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            if (is_array($array[$key])) {
                $array[$key] = trim_r($array[$key]);
            } else if (is_string($array[$key])) {
                $array[$key] = trim($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Write info to file 1 item per line
     *
     * @param string $filename
     * @param string $content
     */
    public function writeToFile($filename, $content) {
        // Let's make sure the file exists and is writable first.
        if (is_writable($filename)) {

            // In our example we're opening $filename in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $somecontent will go when we fwrite() it.
            if (!$handle = fopen($filename, 'a')) {
                echo "Cannot open file ($filename)";
                exit;
            }
            // Write $somecontent to our opened file.
            if (fwrite($handle, $content) === FALSE) {
                echo "Cannot write to file ($filename)";
                exit;
            }
            echo "Success, wrote ($content) to file ($filename) <br />";
            //close file
            fclose($handle);
        } else {
            echo "The file $filename is not writable";
        }
    }

    /**
     * convert a specific .csv file to array.
     *
     * @param type $file
     * @return type array
     */
    public function csvToArray($file) {
        $row = 0;
        $handle = fopen($file, "r");
        $tracks = array();
        if ($handle != FALSE) {
            while ($data = fgetcsv($handle, 1000, ';')) {
                if ($row === 0) {
                    $keys = $data;
                } else {
                    $values = $data;
                }
                $row++;
                if ($row > 1 && count($keys) == count($values)) {

                    $track = array_combine($keys, $values);
                    $tracks[] = $track;
                }
            }
            fclose($handle);
            return $tracks;
        }
    }

    public function time($string) {
        $exp = explode('-', $string);
        $timeString = array();
        foreach ($exp as $value) {
           $timeString[]= $this->normTime($value);
        }
        $time = implode('-', $timeString);
        return $time;
    }

    public function time_to_decimal($time) {
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);

        return $decTime;
    }

    public function normTime($string) {
        $result = preg_replace_callback('~([\d:,.]+)~', function($i) {
                    $i[1] = str_replace(array(',', ':'), '.', $i[1]);
                    if (strpos($i[1], '.') === false) {
                        $i[1] .= '.00';
                    }

                    return $i[1];
                }, $string);
        return $result;
    }
}

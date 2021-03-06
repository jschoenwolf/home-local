<?php

require_once('getid3.php');
/**
 * Description of Music_Model_Mapper_Tag
 *
 * @author John
 */
class Music_Model_Mapper_TagInfo extends Jgs_Model_Mapper_Abstract
{
    protected $fileToScan;
    protected $result = array();
    protected $data;
    protected $getID3 = null;

    public function __construct($file)
    {
        if (is_readable($file)) {
            $this->fileToScan = $file;
        } else {
            throw new InvalidArgumentException('File not readable.');
        }
        if (is_null($this->getID3)) {
            $this->getID3 = new getID3();
        }
    }

    protected function createEntity($row)
    {
        $row  = (object) $row;
        $data = array(
            'id'               => NULL,
            'album'            => $row->album,
            'artist'           => $row->artist,
            'bitrate'          => $row->bitrate,
            'title'            => $row->title,
            'filename'         => $row->filename,
            'format'           => $row->format,
            'genre'            => $row->genre,
            'playtime_seconds' => $row->playtime_seconds,
            'playtime_string'  => $row->playtime_string,
            'track_number'     => $row->track_number,
            'year'             => $row->year,
            'md5'              => $row->md5,
            'path'             => $row->path
        );
        return new Music_Model_TagInfo($data);
    }

    public function getInfo()
    {
        // Analyze file
        $this->data = $this->getID3->analyze($this->fileToScan);
        // Exit here on error
        if (isset($this->data['error'])) {

            return array('error' => $this->data['error']);
        }
        $this->result['filename']         = (isset($this->data['filename']) ? $this->data['filename'] : '' );
        $this->result['album']            = (isset($this->data['tags_html']['id3v2']['album'][0]) ? $this->data['tags_html']['id3v2']['album'][0] : '');
        $this->result['artist']           = (isset($this->data['tags_html']['id3v2']['artist'][0]) ? $this->data['tags_html']['id3v2']['artist'][0] : '');
        $this->result['bitrate']          = (isset($this->data['bitrate']) ? $this->data['bitrate'] : '');
        $this->result['format']           = (isset($this->data['fileformat']) ? $this->data['fileformat'] : '');
        $this->result['genre']            = (isset($this->data['tags_html']['id3v2']['genre'][0]) ? $this->data['tags_html']['id3v2']['genre'][0] : '');
        $this->result['md5']              = md5_file($this->fileToScan);
        $this->result['path']             = (isset($this->data['filepath']) ? $this->data['filepath'] : '');
        $this->result['playtime_seconds'] = (isset($this->data['playtime_seconds']) ? $this->data['playtime_seconds'] : '');
        $this->result['playtime_string']  = (isset($this->data['playtime_string']) ? $this->data['playtime_string'] : '');
        $this->result['title']            = (isset($this->data['tags_html']['id3v2']['title'][0]) ? $this->data['tags_html']['id3v2']['title'][0] : '');
        $this->result['track_number']     = (isset($this->data['tags_html']['id3v2']['track_number'][0]) ? $this->data['tags_html']['id3v2']['track_number'][0] : NULL);
        $this->result['year']             = (isset($this->data['tags_html']['id3v2']['year'][0]) ? $this->data['tags_html']['id3v2']['year'][0] : '');

        $entity = $this->createEntity($this->result);

        return $entity;
    }

    public function getCoverImage($path = 'images/mp3art/')
    {
        $ThisFileInfo = $this->getID3->analyze($this->fileToScan);
        getid3_lib::CopyTagsToComments($ThisFileInfo);
        if (!empty($ThisFileInfo['comments']['picture'])) {
            foreach ($ThisFileInfo['comments']['picture'] as $key => $valuearray) {
                if (isset($valuearray['data']) && isset($valuearray['image_mime'])) {
                    $file = $path . str_replace(':', '', $ThisFileInfo['tags']['id3v2']['album'][0])
                        . '.' . str_replace('image/', '', $valuearray['image_mime']);
                    if (!is_readable($file)) {
                        file_put_contents($file, $valuearray['data']);
                    } else {
                        return true;
                    }
                }
            }
        }
    }
}

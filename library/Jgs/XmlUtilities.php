<?php

/**
 * General Xml utilities
 *
 * @author John Schoenwolf
 * @copyright 2012
 */
class Jgs_XmlUtilities
{

    /**
     * Convert Xml movie list into associative array.
     *
     * @param string $file
     * @return array
     */
    public function xmlMoviesToArray($file)
    {

        /* @var $iterator SimpleXMLElement */
        $iterator = new SimpleXMLElement($file, 0, true);

        /* @var $xpath SimpleXMLElement */
        $xpath = $iterator->xpath('//movie');

        /* @var $array JGS_Application_XmlUtilities */
        $array = array();
        foreach ($xpath as $node) {
            $keys['title'] = (string) $node->origtitle;
            $keys['year'] = (string) $node->year;
            $keys['genre'] = (string) $node->genre;
            $keys['director'] = (string) $node->director;
            $keys['producers'] = (string) $node->producers;
            $keys['actors'] = (string) $node->actors;
            $keys['path'] = (string) $node->path;
            $keys['description'] = (string) $node->description;
            $keys['length'] = (int) $node->length;
            $keys['poster'] = (string) $node->poster;
            $keys['resolution'] = (string) $node->resolution;
            $keys['imdb'] = (string) $node->url;

            /* @var $keys JGS_Application_XmlUtilities */
            $array[] = $keys;
        }
        return $array;
    }
}

<?php

namespace App\Http\Controllers\Services;

class XMLService
{
    public function getArrayFromXML(string $url) : array
    {
      $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));

      $xml = file_get_contents($url, false, $context);
      $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

    //  return dd((string)$xml->channel->item[0]->description);
      $json = json_encode($xml);
      $news = json_decode($json, true)['channel'];
      return $news;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Jobs\FetchNews;
use App\Http\Controllers\Services\XMLService;


// USED FOR TESTING, NOT ACTUALLY REQUIRED FOR PROJECT
class XMLparserController extends Controller
{
  private $xmlService;

  public function __construct(XMLService $xmlService) {
    $this->xmlService = $xmlService;
  }

    public function getXML(Request $request) {
      // FetchNews::dispatch();
      //   $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
       $url = config('XMLconfig.lifehacker');
       $news = $this->xmlService->getArrayFromXML($url);
      //
      //   $xml = file_get_contents($url, false, $context);
      //   $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
      //
      // //  return dd((string)$xml->channel->item[0]->description);
      //   $json = json_encode($xml);
      //   $news = json_decode($json, true)['channel'];

        $latestDate = new Carbon(Storage::disk('local')->get('dates.txt'));
        if(count($news['item']) > 0) {
           $articles = [];
           foreach($news['item'] as $index => $data){
               $pubdate = new Carbon($data['pubDate']);
               if($pubdate->gt($latestDate)) {
                   $articles[] = [
                       "title" => $data['title'],
                       "link" => $data['link'],
                       "description" => $data['description'],
                       "category" => json_encode($data['category']),
                       "pubdate" => $pubdate
                   ];
               }
           }
        }
        News::insert($articles);
        if(count($articles) > 0) {
          Storage::disk('local')->put('dates.txt', $articles[0]['pubdate']);
        }

      return response()->json(['articles' => "success"], 200);
    }
}

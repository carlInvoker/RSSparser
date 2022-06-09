<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\Services\XMLService;

class FetchNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(XMLService $xmlService) :void
    {
        $url = config('XMLconfig.lifehacker');
        $news = $xmlService->getArrayFromXML($url);

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
        return;
    }
}

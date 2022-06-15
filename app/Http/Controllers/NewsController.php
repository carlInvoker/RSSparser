<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Config;

class NewsController extends Controller
{

  public function getNews(NewsRequest $request) {
    $date = $request->input('date');
    $news =  News::select('*')
                    ->when($date, function ($query, $date) {
                              return $query->orderBy('pubdate', $date);
                          })
                    ->simplePaginate(Config::get('pagination.userPage'));
    return response()->json($news, 200);
  }

  public function readArticle(News $news) {
    return response()->json($news, 200);
  }

  public function addArticle(StoreNewsRequest $request) {
    $data = $request->validated();
    $data['pubdate'] = Carbon::now();
    $news = News::create($data);
    if(!isset($data['link'])) {
      $news->link = url('api/news/'.(string)$news->id);
      $news->description = $news->description."<p><a href='".$news->link."' >Read more...</a></p>";
    }
    $news->save();
    return response()->json($news, 200);
  }

  public function updateArticle(StoreNewsRequest $request, News $news) {
    $validated = $request->validated();
    $validated['description'] = $validated['description']."<p><a href='".$news->link."' >Read more...</a></p>";
    $news->update($validated);
    return response()->json($news, 200);
  }

  public function deleteArticle(News $news) {
    $news->delete();
    return response()->json(['message' => ['Article deleted !']], 200);
  }
}

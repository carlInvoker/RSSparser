<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNewsRequest;
use Illuminate\Support\Facades\Config;

class NewsController extends Controller
{

  public function getNews(Request $request) {
    $date = $request->input('date');
    $news =  News::select('*')
                    ->when($date, function ($query, $date) {
                              return $query->orderBy('pubdate', $date);
                          })
                    ->paginate(Config::get('pagination.userPage'))->onEachSide(1);
    return response()->json($news, 200);
  }

  public function readArticle(News $news) {
    return response()->json($news, 200);
  }

  public function addArticle(StoreNewsRequest $request) {
    $data = $request->validated();
    $data['pubdate'] = Carbon::now();
    $news = News::create($data);
    $news->save();
    return response()->json($news, 200);
  }

  public function updateArticle(StoreNewsRequest $request, News $news) {
    $news->update($request->validated());
    return response()->json($news, 200);
  }

  public function deleteArticle(News $news) {
    $news->delete();
    return response()->json(['message' => ['Article deleted !']], 200);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'News';
    public $timestamps = false;
    
    protected $fillable = [
      'title', 'link', 'description','category','pubdate'
    ];
}

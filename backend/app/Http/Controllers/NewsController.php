<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return NewsResource::collection(NewsArticle::all()->sortBy('date', descending: true));
    }

    public function show(NewsArticle $article) {
        return new NewsResource($article);
    }
}

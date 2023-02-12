<?php

namespace App\Http\Controllers;

use App\Models\ImagesNews;
use App\Models\News;
use http\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
class GetParseController extends Controller
{

    public function index()
    {
        $news = News::with('Images')->orderBy('date','desc')->paginate(6);
        return view('welcome',compact('news'));
    }




}

<?php

namespace App\Http\Controllers;

use App\Article;
use App\Client;
use App\Images;
use App\TicketsInfo;
use App\Trainer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {

        $articles = Article::all();

        foreach ($articles as $article) {
            $article_with_img[] = DB::table('articles_images')
                ->join('articles', 'id_article', '=', 'article_id')
                ->where('article_id', $article->id_article)
                ->get();

            $short_desc[] = substr($article->description, 0, 400);
            $article_date[] = Carbon::parse($article->add_date)->format('d.m.Y');

        }

        return view('pages.index')->with([
            'articles' => $article_with_img,
            'short_desc' => $short_desc,
            'article_date' => $article_date
        ]);
    }

    public function tickets()
    {

        $id_client = Auth::user()->id_client;
        $client_info = Client::find($id_client);
        $tickets = TicketsInfo::all();
        return view('pages.tickets')->with([
            'tickets' => $tickets,
            'client_info' => $client_info,
        ]);
    }

    public function personalTraining()
    {

        $id_client = Auth::user()->id_client;
        $client_info = Client::find($id_client);
        $trainers = Trainer::all();
        return view('pages.personalTraining')->with([
            'trainers' => $trainers,
            'client_info' => $client_info
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function article($id_article)
    {

        $article = Article::where('id_article', $id_article)->get();
        $article_images = Images::where('article_id', $id_article)->get();

        return view('pages.article')->with([
            'article' => $article,
            'article_images' => $article_images
        ]);
    }

}

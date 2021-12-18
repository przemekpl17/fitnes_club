<?php

namespace App\Http\Controllers;
use App\Client;
use App\Trainer;
use App\TicketsInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    public function tickets() {
        if (Auth::check()) {
            $id_client = Auth::user()->id_client;
            $client_info = Client::find($id_client);
            $tickets = TicketsInfo::all();
            return view('pages.tickets')->with([
                'tickets' => $tickets,
                'client_info' => $client_info,
            ]);
        } else {
            return redirect('/login')->with('error', 'Zaloguj się, aby kupić karnet.');
        }
    }

    public function personalTraining() {
        if (Auth::check()) {
            $id_client = Auth::user()->id_client;
            $client_info = Client::find($id_client);
            $trainers = Trainer::all();
            return view('pages.personalTraining')->with([
                'trainers' => $trainers,
                'client_info' => $client_info
            ]);
        } else {
            return redirect('/login')->with('error', 'Zaloguj się, aby kupić trening personalny.');
        }
    }

    public function contact(){
        return view('pages.contact');
    }

}

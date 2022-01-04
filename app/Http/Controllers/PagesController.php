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
        if(Auth::user()->account_type == 0) {
            $id_client = Auth::user()->id_client;
            $client_info = Client::find($id_client);
            $tickets = TicketsInfo::all();
            return view('pages.tickets')->with([
                'tickets' => $tickets,
                'client_info' => $client_info,
            ]);
        } else {
            return redirect('/')->with('error', 'Do tej części strony dostęp mają jedynie zalogowani użytkownicy.');
        }
    }

    public function personalTraining() {
        if(Auth::user()->account_type == 0) {
            $id_client = Auth::user()->id_client;
            $client_info = Client::find($id_client);
            $trainers = Trainer::all();
            return view('pages.personalTraining')->with([
                'trainers' => $trainers,
                'client_info' => $client_info
            ]);
        } else {
            return redirect('/')->with('error', 'Do tej części strony dostęp mają jedynie zalogowani użytkownicy.');
        }
    }

    public function contact(){
        return view('pages.contact');
    }

}

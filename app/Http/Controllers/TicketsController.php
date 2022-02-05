<?php

namespace App\Http\Controllers;
use DB;
use App\Client;
use Illuminate\Http\Request;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $id_client = Auth::user()->id_client;
       $client = Client::find($id_client);

       $actualDay = Carbon::parse(Carbon::now());
       $inputDate = $request->input('input_date');
       $idClient = $request->get('id_client');
       $ticketLen = $request->get('ticket_length');
       $ticketPrice = $request->get('price');
       $clientAccountBalance = $request->get('account_balance');
       $ticketType = $request->get('ticket_type');

       $dateTo =  (new Carbon($inputDate))->addDays((int)$ticketLen);

       $actualTicket = DB::table('ticket')
            ->where('id_client_ticket', '=', $idClient)
            ->get();

       if($actualTicket->count()){
            if($inputDate > $actualTicket[0]->date_to && $actualDay >= $actualTicket[0]->date_to) {
                return $this->store($request);
            } else {

                return redirect('/tickets')->with('error', 'Transakcja nie powiodła się. Twój karnet jest ważny do '.$actualTicket[0]->date_to.'.');
            }
        }else {
                if($ticketPrice <= $clientAccountBalance) {

                    $ticket = new Ticket();
                    $ticket->type = $ticketType;
                    $ticket->date_from = $inputDate;
                    $ticket->date_to = $dateTo;
                    $ticket->price = $ticketPrice;
                    $ticket->id_client_ticket = $idClient;

                    $ticket->save();

                    $newAccountBalance = $clientAccountBalance - $ticketPrice;

                    $client->account_balance = $newAccountBalance;
                    $client->save();

                    return redirect('/tickets')->with('success', 'Bilet zakupiony!');

                } else {
                    return redirect('/tickets')->with('error', 'Masz za mało środków na koncie, doładuj konto.');
                }
            }
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_client = Auth::user()->id_client;
        $client = Client::find($id_client);

        $ticketPrice = $request->get('price');
        $clientAccountBalance = $request->get('account_balance');
        $ticketLen = $request->get('ticket_length');
        $dateFrom = $request->input('input_date');
        $dateTo =  (new Carbon($dateFrom))->addDays((int)$ticketLen);

        DB::table('ticket')
            ->where('id_client_ticket', '=', $request->get('id_client'))
            ->update([
                'date_from' => $dateFrom,
                'date_to' => $dateTo
            ]);

        $newAccountBalance = $clientAccountBalance - $ticketPrice;

        $client->account_balance = $newAccountBalance;
        $client->save();

        return redirect('/tickets')->with('success', 'Bilet zakupiony!');

    }

}

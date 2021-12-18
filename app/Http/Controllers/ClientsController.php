<?php

namespace App\Http\Controllers;

use App\GroupActivity;
use App\PersonalTraining;
use App\Ticket;
use App\Trainer;
use DB;
use App\Client;
use App\User;
use App\Clients_GroupActivities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Główny widok po zalogowaniu
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id_client = Auth::user()->id_client;
        $client = Client::find($id_client);

        $ticket = Ticket::where('id_client_ticket', $id_client)->first();

        return view ('clients.index')->with([
            'client' => $client,
            'ticket' => $ticket
        ]);
    }

    //Widok z kalendarzem aktywności użytkownika
    public function clientActivity(){

        $id_client = Auth::user()->id_client;
        $actualDay = Carbon::parse(Carbon::now());
        $actualWeek = Carbon::now()->weekOfMonth;
        $today = today();
        $daysOfMonth = [];
        $weekCounter = 1;

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $rowDate = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
            $fullDate = Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-Y');
            $nameOfDay = Carbon::createFromDate($today->year, $today->month, $i)->format('l');
            $numberOfDay = intval(Carbon::createFromDate($today->year, $today->month, $i)->format('d'));

            $daysOfMonth[$weekCounter][] = [
                'name_of_day' => $nameOfDay,
                'number_of_day' => $numberOfDay,
                'full_date' => $fullDate,
                'personal_training' => PersonalTraining::whereDate('date_time_from', $rowDate)
                    ->leftJoin('trainer', 'personal_training.id_trainer', '=', 'trainer.id_trainer')
                    ->where('id_client', $id_client)
                    ->orderBy('date_time_from','asc')->get(),
                'activities' => DB::table('client_group_activities')
                    ->join('group_activities', 'client_group_activities.id_group_activities', '=', 'group_activities.id_group_activities')
                    ->select('client_group_activities.*', 'group_activities.*')
                    ->where('id_client', $id_client)
                    ->whereDate('date_time_from', $rowDate)
                    ->get()
            ];

            if($nameOfDay == 'Sunday') {
                $weekCounter++;
            }
        }
        //dump($daysOfMonth);
        return view ('clients.clientActivity')->with([
            'id_client' => $id_client,
            'actualDay' => $actualDay,
            'actualWeek' => $actualWeek,
            'daysOfMonth' => $daysOfMonth
        ]);

    }

    //aktualizacja danych użytkownika
    public function clientUpdate(){
        $id_client = Auth::user()->id_client;
        $client = Client::find($id_client);
        return view('clients.clientUpdate')->with('client', $client);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->input('name');
        $client->surname = $request->input('surname');
        $client->gender = $request->input('gender');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telephone');
        $client->city = $request->input('city');
        $client->street = $request->input('street');
        $client->street_number = $request->input('street_number');
        $client->post_code = $request->input('post_code');

        $client->save();

        return redirect('/clientProfile')->with('success', 'Informacje zapisane');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->name = $request->input('name');
        $client->surname = $request->input('surname');
        $client->gender = $request->input('gender');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telephone');
        $client->city = $request->input('city');
        $client->street = $request->input('street');
        $client->street_number = $request->input('street_number');
        $client->post_code = $request->input('post_code');
        $client->account_balance = $request->input('account_balance');

        $client->save();

        return redirect('/clientUpdate')->with('success', 'Informacje zapisane');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

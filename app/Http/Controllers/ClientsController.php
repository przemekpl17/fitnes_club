<?php

namespace App\Http\Controllers;

use App\Client;
use App\PersonalTraining;
use App\Ticket;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jenssegers\Date\Date;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Główny widok po zalogowaniu
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $user = Auth::user();
        $id_client = $user->id_client;
        $client = Client::find($id_client);
        $ticket = Ticket::where('id_client_ticket', $id_client)->first();

        return view('clients.index')->with([
            'client' => $client,
            'ticket' => $ticket
        ]);
    }

    //Widok z kalendarzem aktywności użytkownika
    public function clientActivity()
    {

        Date::setLocale('pl');

        $id_client = Auth::user()->id_client;
        $actualDay = Carbon::parse(Carbon::now());
        $actualWeek = Carbon::now()->weekOfMonth;
        $today = today();
        $daysOfMonth = [];
        $weekCounter = 1;

        for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
            $rowDate = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
            $fullDate = Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-Y');
            $nameOfDay = Carbon::createFromDate($today->year, $today->month, $i)->format('l');
            $numberOfDay = intval(Carbon::createFromDate($today->year, $today->month, $i)->format('d'));


            $daysOfMonth[$weekCounter][] = [
                'name_of_day' => Date::parse($nameOfDay)->format('l'),
                'number_of_day' => $numberOfDay,
                'full_date' => $fullDate,
                'personal_training' => PersonalTraining::whereDate('date_time_from', $rowDate)
                    ->leftJoin('trainer', 'personal_training.id_trainer', '=', 'trainer.id_trainer')
                    ->where('id_client', $id_client)
                    ->orderBy('date_time_from', 'asc')->get(),
                'activities' => DB::table('client_group_activities')
                    ->join('group_activities', 'client_group_activities.id_group_activities', '=', 'group_activities.id_group_activities')
                    ->select('client_group_activities.*', 'group_activities.*')
                    ->where('id_client', $id_client)
                    ->whereDate('date_time_from', $rowDate)
                    ->get()
            ];

            if ($nameOfDay == 'Sunday') {
                $weekCounter++;
            }
        }

        return view('clients.clientActivity')->with([
            'id_client' => $id_client,
            'actualDay' => $actualDay,
            'actualWeek' => $actualWeek,
            'daysOfMonth' => $daysOfMonth
        ]);

    }

    //aktualizacja danych użytkownika
    public function clientUpdate($id_client)
    {

        $client = Client::find($id_client);
        return view('clients.clientUpdate')->with([
            'client' => $client,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $client = Client::find($id);
        $request->validate([
            'name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'surname' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'city' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'street' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'telefon' => 'max:9',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'email' => 'nullable|email|unique:client,email,' . $client->id_client . ",id_client",
        ],
            [
                'name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr lub pozostać puste.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr lub pozostać puste.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $client->name = $request->input('name');
        $client->surname = $request->input('surname');
        $client->gender = $request->input('gender');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telefon');
        $client->city = $request->input('city');
        $client->street = $request->input('street');
        $client->street_number = $request->input('street_number');
        $client->post_code = $request->input('post_code');
        $client->account_balance = $request->input('account_balance');

        $client->save();

        return redirect('/client')->with('success', 'Informacje zapisane');

    }
}

<?php

namespace App\Http\Controllers;

use App\GroupActivity;
use Carbon\Carbon;
use App\Client;
use App\Ticket;
use App\Trainer;
use App\User;
use DB;
use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::user();
        return view('admin.index')->with('admin', $admin);
    }

    //okno z tabelą użytkowników
    public function usersList() {
        $users = DB::table('users')
            ->join('client', 'users.id_client', '=', 'client.id_client')
            ->select('client.*', 'users.*')
            ->get();

        return view('admin.usersList')->with('users', $users);
    }

    //aktualizacja danych użytkownika
    public function updateUserForm($id) {
        $client = Client::find($id);
        $user = User::where('id_client', $id)->get();

        return view('admin.updateUserForm')->with([
            'client' => $client,
            'user' => $user
        ]);
    }

    //okno z formularzem dodania użytkownika
    public function addUserForm()
    {
        return view('admin.addUserForm');
    }

    //tworzenie użytkownika i klienta
    public function createUser(Request $request)
    {

        $request->validate([
            'client_name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'surname' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'city' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'street' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:client',
            'email' => 'email|unique:users'
        ],
            [
                'client_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $client = Client::create([
            'name' => $request->input('client_name'),
            'surname' => $request->input('surname'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'street_number' => $request->input('street_number'),
            'post_code' => $request->input('post_code')
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'id_client' => $client['id_client']
        ]);

        return redirect('/usersList')->with('success', 'Użytkownik stworzony pomyślnie.');
    }

    //aktualizowanie danych użytkownika
    public function updateUser($id_client, $id_user, Request $request){

        $user = User::find($id_user);
        $client = Client::find($id_client);

        $request->validate([
            'name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'client_name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'surname' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'city' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'street' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:client',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'email' => 'nullable|email|unique:client,email,'.$client->id_client.",id_client",
        ],
            [
                'name.regex' => 'Nazwa użytkownika nie może zawierać cyfr lub pozostać puste.',
                'client_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $client->name = $request->input('client_name');
        $client->surname = $request->input('surname');
        $client->gender = $request->input('gender');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telephone');
        $client->city = $request->input('city');
        $client->street = $request->input('street');
        $client->street_number = $request->input('street_number');
        $client->post_code = $request->input('post_code');

        $client->save();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->save();

        return redirect('/usersList')->with('success', 'Dane zostały zaktualizowane.');

    }

    //usuwanie użytkownika
    public function deleteUser($id)
    {
        User::where('id_client', $id)->delete();
        Client::where('id_client', $id)->delete();

        return redirect('/usersList')->with('success', 'Użytkownik usunięty.');
    }

    //okno z tabelą trenerów
    public function trainersList() {

        $trainers = DB::table('users')
            ->join('trainer', 'users.id_trainer', '=', 'trainer.id_trainer')
            ->select('trainer.*', 'users.*')
            ->get();

        return view('admin.trainersList')->with('trainers', $trainers);
    }

    //okno z formularzem dodania trenera
    public function addTrainerForm()
    {
        return view('admin.addTrainerForm');
    }

    //aktualizacja danych tenera
    public function updateTrainerForm($id) {
        $trainer = Trainer::find($id);
        $user = User::where('id_trainer', $id)->get();

        return view('admin.updateTrainerForm')->with([
            'trainer' => $trainer,
            'user' => $user
        ]);
    }

    //usuwanie trenera
    public function deleteTrainer($id)
    {
        User::where('id_trainer', $id)->delete();
        Trainer::where('id_trainer', $id)->delete();

        return redirect('/trainersList')->with('success', 'Trener usunięty.');
    }

    //tworzenie użytkownika i trenera
    public function createTrainer(Request $request)
    {

        $request->validate([
            'trainer_name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'surname' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'city' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'street' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:trainer',
            'email' => 'email|unique:users'
        ],
            [
                'trainer_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $trainer = Trainer::create([
            'name' => $request->input('trainer_name'),
            'surname' => $request->input('surname'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'street_num' => $request->input('street_number'),
            'post_code' => $request->input('post_code')
        ]);

         User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'account_type' => 1,
            'id_trainer' => $trainer['id_trainer'],
        ]);

        return redirect('/trainersList')->with('success', 'Trener utworzony pomyślnie.');
    }

    //aktualizowanie danych trenera
    public function updateTrainer($id_trainer, $id_user, Request $request)
    {
        $user = User::find($id_user);
        $trainer = Trainer::find($id_trainer);

        $request->validate([
            'trainer_name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'surname' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'city' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'street' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:trainer',
            'email' => 'nullable|email|unique:trainer,email,'.$trainer->id_trainer.",id_trainer",
        ],
            [
                'trainer_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $trainer->name = $request->input('trainer_name');
        $trainer->surname = $request->input('surname');
        $trainer->gender = $request->input('gender');
        $trainer->city = $request->input('city');
        $trainer->telephone = $request->input('telephone');
        $trainer->street = $request->input('street');
        $trainer->street_num = $request->input('street_number');
        $trainer->post_code = $request->input('post_code');

        $trainer->save();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect('/trainersList')->with('success', 'Dane zostały zaktualizowane.');
    }

    //okno z tabelą karnetów
    public function ticketsList() {

        $tickets = Ticket::whereMonth('date_from', '=', Carbon::now())->get();
        return view('admin.ticketsList')->with('tickets', $tickets);
    }

    //okno z zajęciami grupowymi
    public function activitiesList() {

        Date::setLocale('pl');

        if(Auth::check()) {

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
                    'name_of_day' => Date::parse($nameOfDay)->format('l'),
                    'number_of_day' => $numberOfDay,
                    'full_date' => $fullDate,
                    'activities' => GroupActivity::whereDate('date_time_from', $rowDate)->orderBy('date_time_from','asc')->get()
                ];
                if($nameOfDay == 'Sunday') {
                    $weekCounter++;
                }

            }

            return view ('admin.activitiesList')->with([
                'actualDay' => $actualDay,
                'actualWeek' => $actualWeek,
                'daysOfMonth' => $daysOfMonth
            ]);

        }else {
            return redirect('/login')->with('error', 'Zaloguj się, aby dołączyć do zajęć grupowych.');
        }
    }

    //okno z formularzem dodania zajęcia grupowego
    public function addActivityForm()
    {
        $trainers = Trainer::all()->pluck('full_name', 'id_trainer');
        return view('admin.addActivityForm')->with('trainers', $trainers);
    }

    //aktualizacja danych zajęcia grupowego
    public function updateActivityForm($id) {
        $activity = GroupActivity::find($id);
        $selected = GroupActivity::select('id_trainer')->where('id_group_activities', $id)->first();
        $trainers = Trainer::all()->pluck('full_name', 'id_trainer');
        return view('admin.updateActivityForm')->with([
            'activity' => $activity,
            'trainers' => $trainers,
            'selectedID' => $selected->id_trainer
        ]);
    }

    //usuwanie zajęcia grupowego
    public function deleteActivity($id)
    {
        GroupActivity::where('id_group_activities', $id)->delete();

        return redirect('/activitiesList')->with('success', 'Zajęcie grupowe usunięte.');
    }

    //tworzenie zajęcia grupowego
    public function createActivity(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:group_activities|max:255',
            'room_number' => 'required',
        ]);

        $dateFrom = Carbon::parse(\request()->get('date_time_from'));
        $dateTo = Carbon::parse(\request()->get('date_time_to'));
        $groupActivities = GroupActivity::all();
        $diffInMin = $dateFrom->diffInMinutes($dateTo);

        $dateCheck = 0;
        foreach ($groupActivities as $groupActivity) {
            $acitivityDates = [
                'date_from' => $groupActivity->date_time_from,
                'date_to' => $groupActivity->date_time_to,
            ];
            $acitivityDates['date_from'] = Carbon::parse($acitivityDates['date_from']);
            $acitivityDates['date_to'] = Carbon::parse($acitivityDates['date_to']);

            if( $dateFrom < $acitivityDates['date_to']  && $dateFrom > $acitivityDates['date_from']->subHour() ) {
                $dateCheck = 1;
            }
        }
        if($diffInMin < 60){
            return redirect('/activitiesList')->with('error', 'Zajęcia muszą trwać minimum godzinę!');
        }
        if($dateCheck != 0) {
            return redirect('/activitiesList')->with('error', 'Zajęcie grupowe w tym czasie już istnieje. Usuń je, aby dodać nowe.');
        }else {
            GroupActivity::create([
                'name' => $request->input('name'),
                'date_time_from' => $dateFrom,
                'date_time_to' => $dateTo,
                'room_number' => $request->input('room_number'),
                'max_participants' => $request->input('max_participants'),
                'id_trainer' => $request->input('id_trainer')
            ]);

            return redirect('/activitiesList')->with('success', 'Zajęcie grupowe utworzone.');
        }
    }

    public function updateActivity($id_activity, Request $request)
    {
        $activity = GroupActivity::find($id_activity);
        $groupActivities = GroupActivity::all();

        $request->validate([
            'name' => 'required|string|max:100|unique:group_activities,name,'.$activity->id_group_activities.",id_group_activities",
            'room_number' => 'required',
        ], [
            'name.unique' => 'Taka nazwa zajęcia grupowego już występuje. Wprowadź inną.',
            'name.required' => 'Pole z nazwą zajęcia grupowego jest wymagane.'
        ]);

        $dateFrom = Carbon::parse(\request()->get('date_time_from'));
        $dateTo = Carbon::parse(\request()->get('date_time_to'));

        $diffInMin = $dateFrom->diffInMinutes($dateTo);
        $dateCheck = 0;
        foreach ($groupActivities as $groupActivity) {
            $acitivityDates = [
                'date_from' => $groupActivity->date_time_from,
                'date_to' => $groupActivity->date_time_to,
            ];
            $acitivityDates['date_from'] = Carbon::parse($acitivityDates['date_from']);
            $acitivityDates['date_to'] = Carbon::parse($acitivityDates['date_to']);

            if ($dateFrom < $acitivityDates['date_to'] && $dateFrom > $acitivityDates['date_from']->subHour()) {
                $dateCheck = 1;
            }
        }
        if ($diffInMin < 60) {
            return redirect('/activitiesList')->with('error', 'Zajęcia muszą trwać minimum godzinę!');
        }
        if ($dateCheck != 0) {
            return redirect('/activitiesList')->with('error', 'Zajęcie grupowe w tym czasie już istnieje. Usuń je, aby dodać nowe.');
        } else {

            $activity->name = $request->input('name');
            $activity->date_time_from = $dateFrom;
            $activity->date_time_to = $dateTo;
            $activity->room_number = $request->input('room_number');
            $activity->max_participants = $request->input('max_participants');
            $activity->id_trainer = $request->input('id_trainer');

            $activity->save();

            return redirect('/activitiesList')->with('success', 'Zajęcie grupowe zaktualizowane.');
        }
    }


}

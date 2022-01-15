<?php

namespace App\Http\Controllers;

use App\PersonalTraining;
use App\Trainer;
use App\User;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date;

class TrainersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $id_trainer = $user->id_trainer;
        $trainer = Trainer::find($id_trainer);

        return view('trainers.index')->with([
            'trainer' => $trainer,
            'user' => $user,
        ]);
    }

    //aktualizacja danych tenera
    public function updatePersonalTrainerForm($id) {
        $trainer = Trainer::find($id);
        $user = User::where('id_trainer', $id)->get();

        return view('trainers.updatePersonalTrainerForm')->with([
            'trainer' => $trainer,
            'user' => $user
        ]);
    }

    //aktualizowanie danych trenera
    public function updatePersonalTrainer($id_trainer, $id_user, Request $request)
    {

        $user = User::find($id_user);

        $request->validate([
            'password' => 'min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'email' => 'nullable|email|string|unique:users,email,'.$user->id_users.",id_users",
            'trainer_name' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'surname' => 'regex:/^[a-zA-Z]+$/u|max:60',
            'city' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'street' => 'nullable|regex:/^[a-zA-Z]+$/u|max:60',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i'
        ],
            [
                'trainer_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___'
            ]);

        $trainer = Trainer::find($id_trainer);
        $trainer->name = $request->input('trainer_name');
        $trainer->surname = $request->input('surname');
        $trainer->gender = $request->input('gender');
        //$trainer->email = $request->input('email');
        $trainer->city = $request->input('city');
        $trainer->street = $request->input('street');
        $trainer->street_num = $request->input('street_number');
        $trainer->post_code = $request->input('post_code');
        $trainer->training_price = $request->input('training_price');

        $trainer->save();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect('/trainer')->with('success', 'Dane zostały zaktualizowane.');
    }

    //Widok z kalendarzem aktywności trenera
    public function trainerActivity(){

        Date::setLocale('pl');

        $id_trainer = Auth::user()->id_trainer;

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
                'personal_training' => PersonalTraining::whereDate('date_time_from', $rowDate)
                    ->where('id_trainer', $id_trainer)
                    ->orderBy('date_time_from','asc')->get(),
                'activities' => DB::table('group_activities')
                    ->where('id_trainer', $id_trainer)
                    ->whereDate('date_time_from', $rowDate)
                    ->get()
            ];

            if($nameOfDay == 'Sunday') {
                $weekCounter++;
            }
        }

        return view ('trainers.trainerActivity')->with([
            'id_trainer' => $id_trainer,
            'actualDay' => $actualDay,
            'actualWeek' => $actualWeek,
            'daysOfMonth' => $daysOfMonth
        ]);

    }
}

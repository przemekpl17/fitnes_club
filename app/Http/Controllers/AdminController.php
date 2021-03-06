<?php

namespace App\Http\Controllers;

use App\Article;
use App\Client;
use App\GroupActivity;
use App\Images;
use App\Ticket;
use App\Trainer;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Date\Date;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Ticket::where('date_to', '<', Carbon::now())->delete();
        $admin = Auth::user();
        return view('admin.index')->with('admin', $admin);
    }

    //okno z tabelą użytkowników
    public function usersList()
    {

        $users = DB::table('users')
            ->join('client', 'users.id_client', '=', 'client.id_client')
            ->select('client.*', 'users.*')
            ->get();

        return view('admin.usersList')->with('users', $users);
    }

    //aktualizacja danych użytkownika
    public function updateUserForm($id)
    {
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
            'client_name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'surname' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'city' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'street' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
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
    public function updateUser($id_client, $id_user, Request $request)
    {

        $user = User::find($id_user);
        $client = Client::find($id_client);

        $request->validate([
            'name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'client_name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'surname' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'city' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'street' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:client',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'email' => 'nullable|email|unique:client,email,' . $client->id_client . ",id_client",
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

        return redirect('/updateUserForm/' . $id_client)->with('success', 'Dane zostały zaktualizowane.');

    }

    //usuwanie użytkownika
    public function deleteUser($id)
    {
        User::where('id_client', $id)->delete();
        Client::where('id_client', $id)->delete();

        return redirect('/usersList')->with('success', 'Użytkownik usunięty.');
    }

    //okno z tabelą trenerów
    public function trainersList()
    {

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
    public function updateTrainerForm($id)
    {
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
            'trainer_name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'surname' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'city' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'street' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'password' => 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            'post_code' => 'nullable|regex:/^([0-9]{2})(-[0-9]{3})?$/i',
            'telephone' => 'nullable|max:9|unique:trainer',
            'email' => 'email|unique:users',
            'training_price' => 'required'
        ],
            [
                'trainer_name.regex' => 'Imię nie może zawierać cyfr lub pozostać puste.',
                'surname.regex' => 'Nazwisko nie może zawierać cyfr lub pozostać puste.',
                'city.regex' => 'Nazwa miasta nie może zawierać cyfr.',
                'street.regex' => 'Nazwa ulicy nie może zawierać cyfr.',
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___',
                'training_price.required' => 'Pole z ceną za trening jest wymagane.'
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
            'post_code' => $request->input('post_code'),
            'training_price' => $request->input('training_price')
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
            'trainer_name' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'surname' => 'regex:/^[\s\p{L}]+$/u|max:60',
            'city' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
            'street' => 'nullable|regex:/^[\s\p{L}]+$/u|max:60',
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
                'post_code.regex' => 'Prawidłowy format kodu pocztowego: __-___',
                'telephone' => 'Numer telefonu jest zajęty.'
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

        return redirect('/updateTrainerForm/' . $id_trainer)->with('success', 'Dane zostały zaktualizowane.');
    }

    //okno z tabelą karnetów
    public function ticketsList()
    {

        $tickets = Ticket::whereMonth('date_from', '=', Carbon::now())->get();
        return view('admin.ticketsList')->with('tickets', $tickets);
    }

    //okno z zajęciami grupowymi
    public function activitiesList()
    {

        Date::setLocale('pl');

        if (Auth::check()) {

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
                    'activities' => GroupActivity::whereDate('date_time_from', $rowDate)->orderBy('date_time_from', 'asc')->get()
                ];
                if ($nameOfDay == 'Sunday') {
                    $weekCounter++;
                }

            }

            return view('admin.activitiesList')->with([
                'actualDay' => $actualDay,
                'actualWeek' => $actualWeek,
                'daysOfMonth' => $daysOfMonth
            ]);

        } else {
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
    public function updateActivityForm($id)
    {
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
            'date_time_from' => 'required',
            'date_time_to' => 'required',
            'max_participants' => 'required',
            'id_trainer' => 'required',
            'name' => 'required|string|max:255',
            'room_number' => 'required',

        ], [
            'name.required' => 'Pole "Nazwa zajęcia grupowego" jest wymagane.',
            'room_number.required' => 'Pole "Numer sali" jest wymagane.',
            'date_time_from.required' => 'Pole "Data rozpoczęcia" jest wymagane.',
            'date_time_to.required' => 'Pole "Data zakończenia" jest wymagane.',
            'max_participants.required' => 'Pole "Maksymalna liczba uczestników" jest wymagane.',
            'id_trainer.required' => 'Przydzielenie trenera do zajęcia grupowego jest wymagane.'
        ]);

        $dateFrom = Carbon::parse(\request()->get('date_time_from'));
        $dateTo = Carbon::parse(\request()->get('date_time_to'));

        //jeżeli wybrane zostaną różne dni
        if($dateFrom->format('d') != $dateTo->format('d')) {
            return redirect('/activitiesList/')->with('error', 'Wybrano niepoprawne daty trwania zajęcia grupowego.');
        }

        //pobranie treningów personalnych trenera oraz porównanie daty każdego treningu z datą podaną przez użytkownika
        $personalTrainings = DB::table('personal_training')->where('id_trainer', $request->input('id_trainer'))->get();

        $temp1 = 0;
        foreach ($personalTrainings as $pTraining) {
            $trainingDates = [
                'date_from' => $pTraining->date_time_from,
                'date_to' => $pTraining->date_time_to
            ];
            $trainingDates['date_from'] = Carbon::parse($trainingDates['date_from']);
            $trainingDates['date_to'] = Carbon::parse($trainingDates['date_to']);

            if( $dateFrom < $trainingDates['date_to']  && $dateFrom > $trainingDates['date_from']->subHour() ) {
                $temp1 = 1;
            }
        }
        //dd($temp1);
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

            if ($dateFrom < $acitivityDates['date_to'] && $dateFrom > $acitivityDates['date_from']->subHour()) {
                $dateCheck = 1;
            }
        }

        if ($diffInMin < 60) {
            return redirect('/activitiesList')->with('error', 'Zajęcia muszą trwać minimum godzinę!');
        }
        if ($dateCheck != 0 || $temp1 != 0) {
            return redirect('/activitiesList')->with('error', 'Zajęcie grupowe w tym czasie już istnieje lub trener personalny ma już zaplanowane zajęcia/trening w tym czasie. Sprawdź i spróbuj ponownie. ');
        } else {
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
            'name' => 'required|string|max:100|unique:group_activities,name,' . $activity->id_group_activities . ",id_group_activities",
            'room_number' => 'required',
        ], [
            'name.unique' => 'Taka nazwa zajęcia grupowego już występuje. Wprowadź inną.',
            'name.required' => 'Pole z nazwą zajęcia grupowego jest wymagane.'
        ]);

        $dateFrom = Carbon::parse(\request()->get('date_time_from'));
        $dateTo = Carbon::parse(\request()->get('date_time_to'));

        //jeżeli wybrane zostaną różne dni
        if($dateFrom->format('d') != $dateTo->format('d')) {
            return redirect('/updateActivityForm/' . $id_activity)->with('error', 'Wybrano niepoprawne daty trwania zajęcia grupowego.');
        }

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
            return redirect('/updateActivityForm/' . $id_activity)->with('error', 'Zajęcia muszą trwać minimum godzinę!');
        }
        if ($dateCheck != 0) {
            return redirect('/updateActivityForm/' . $id_activity)->with('error', 'Zajęcie grupowe w tym czasie już istnieje. Usuń je, aby dodać nowe.');
        } else {

            $activity->name = $request->input('name');
            $activity->date_time_from = $dateFrom;
            $activity->date_time_to = $dateTo;
            $activity->room_number = $request->input('room_number');
            $activity->max_participants = $request->input('max_participants');
            $activity->id_trainer = $request->input('id_trainer');

            $activity->save();

            return redirect('/updateActivityForm/' . $id_activity)->with('success', 'Zajęcie grupowe zaktualizowane.');
        }
    }

    //okno z tabelą artykułów
    public function articlesList()
    {

        $articles = DB::table('articles')->get();

        foreach ($articles as $article)
        {
            $short_desc[] = substr($article->description, 0, 400);
        }

        return view('admin.articlesList')->with([
            'articles' => $articles,
            'short_desc' => $short_desc
        ]);
    }

    //okno z formularzem dodania nowego artykułu
    public function addArticleForm()
    {
        return view('admin.addArticleForm');
    }

    public function createArticle(Request $request)
    {

        $request->validate([
            'title' => 'required|string|unique:articles|max:255',
            'description' => 'required|string',
        ], [
                'title.unique' => 'Taki tytuł artykułu już występuje. Wprowadź inny.',
                'title.required' => 'Pole z tytułem artykułu jest wymagane.',
                'description.required' => 'Pole z treścią artykułu jest wymagane.'
            ]
        );

        $today = Carbon::today();
        $article = new Article();

        $article->title = $request->input('title');
        $article->description = $request->input('description');
        $article->add_date = $today;

        $article->save();

        if ($request->hasFile('article_id')) {
            $files = $request->file('article_id');
            foreach ($files as $file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $name = str_replace(' ', '-', $name);
                $file->move('articles-images', $name);
                $article->image()->create(['name' => $name]);
            }
        }

        return redirect('/articlesList')->with('success', 'Artykuł został dodany.');
    }

    public function updateArticleForm($id_article)
    {

        $article = Article::where('id_article', $id_article)->get();
        $article_images = Images::where('article_id', $id_article)->get();

        return view('admin.updateArticleForm')->with([
            'article' => $article,
            'article_images' => $article_images,
            'image_path' => public_path('articles-images') . '/'
        ]);
    }


    public function updateArticle($id_article, Request $request)
    {

        $article = Article::find($id_article);

        $article->title = $request->input('title');
        $article->description = $request->input('description');

        $article->save();

        if ($request->hasFile('article_id')) {
            $files = $request->file('article_id');
            foreach ($files as $file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $name = str_replace(' ', '-', $name);
                $file->move('articles-images', $name);
                $article->image()->create(['name' => $name]);
            }
        }

        return redirect('/updateArticleForm/' . $article->id_article)->with('success', 'Dane zaktualizowane.');
    }

    public function deleteImage($id_image)
    {
        $image = Images::find($id_image);
        Images::where('id_articles_images', $id_image)->delete();

        return redirect('/updateArticleForm/' . $image->article_id)->with('success', 'Zdjęcie usunięte.');
    }

    //usuwanie artykułu wraz ze zdjęciami
    public function deleteArticle($id)
    {
        //pobranie wszystkich zdjęć artykułu
        $img = Images::where('article_id', $id)->get();

        //pętla usuwająca zdjęcia z folderu
        foreach ($img as $image) {
            $image_path = public_path('articles-images') . '/' . $image->name;
            unlink($image_path);
        }

        //usunięcie artykułu i zdjęć z bazy danych
        Images::where('article_id', $id)->delete();
        Article::where('id_article', $id)->delete();


        return redirect('/articlesList')->with('success', 'Artykuł usunięty.');
    }

}

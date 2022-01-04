<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\GroupActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;

class GroupsActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Date::setLocale('pl');
        if(Auth::user()->account_type == 0) {
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
                    'name_of_day' => Date::parse($nameOfDay)->format('l'),
                    'number_of_day' => $numberOfDay,
                    'full_date' => $fullDate,
                    'activities' => GroupActivity::whereDate('date_time_from', $rowDate)->orderBy('date_time_from','asc')->get()
                ];
                if($nameOfDay == 'Sunday') {
                    $weekCounter++;
                }
            }

            return view ('pages.groupActivities')->with([
                'id_client' => $id_client,
                'actualDay' => $actualDay,
                'actualWeek' => $actualWeek,
                'daysOfMonth' => $daysOfMonth
            ]);
        }else {
            return redirect('/')->with('error', 'Do tej części strony dostęp mają jedynie zalogowani użytkownicy.');
        }

    }
}

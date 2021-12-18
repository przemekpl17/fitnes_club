<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\GroupActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
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
            return redirect('/login')->with('error', 'Zaloguj się, aby dołączyć do zajęć grupowych.');
        }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

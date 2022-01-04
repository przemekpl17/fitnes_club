<?php

namespace App\Http\Controllers;

use DB;
use App\Clients_GroupActivities;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Clients_GroupActivitiesController extends Controller
{
    /**
     * Tworzenie rekordu w tabeli łączącej
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id_client = $request->get('id_client');
        $id_activity = $request->get('id_activity');

        $actualDay = Carbon::parse(Carbon::now())->format('d');
        $exists = Clients_GroupActivities::where('id_group_activities', $request->get('id_activity'))->first();
        $inputDay = $request->get('actual_day');
        $date_from = $request->get('date_from');

        $personalTrainings = DB::table('personal_training')
            ->join('client_group_activities', 'client_group_activities.id_client', '=', 'personal_training.id_client')
            ->select('client_group_activities.*', 'personal_training.*')
            ->get();

        $temp2 = 0;
        foreach ($personalTrainings as $personalTraining) {
            $trainigDates = [
                'date_from' => $personalTraining->date_time_from,
                'date_to' => $personalTraining->date_time_to,
            ];
            $trainigDates['date_from'] = Carbon::parse($trainigDates['date_from']);
            $trainigDates['date_to'] = Carbon::parse($trainigDates['date_to']);

            if( $date_from < $trainigDates['date_to']  && $date_from > $trainigDates['date_from']->subHour() ) {
                $temp2 = 1;
            }
        }


        $actualTicket = DB::table('ticket')
            ->where('id_client_ticket', '=', $request->get('id_client'))
            ->get();

        if($temp2 !=0){
            return redirect('/groupActivities')->with('error', 'masz trening w tym samym czasie, dołącz do innych.');
        }
        if($actualTicket->count()){
            if($inputDay < $actualDay){
                return redirect('/groupActivities')->with('error', 'Te zajęcia już się odbyły, lub masz trening w tym samym czasie, dołącz do innych.');
            }else if($exists !=null){
                return redirect('/groupActivities')->with('error', 'Dołączyłeś już do  tych zajęć. Wybierz inne.');
            }else {

                $client_group_activity = new Clients_GroupActivities();
                $client_group_activity->id_client = $id_client;
                $client_group_activity->id_group_activities = $id_activity;

                $client_group_activity->save();

                return redirect('/groupActivities')->with('success', 'Dołączyłeś do zajęć');

            }
        }else {
            return redirect('/groupActivities')->with('error', 'Aby dołączyć do zajęć grupowych musisz posiadać karnet!');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clients_GroupActivities::where('id_client_group_activities', $id)->delete();

        return redirect('/clientActivity')->with('success', 'Wypisałeś się z zajęć.');
    }
}

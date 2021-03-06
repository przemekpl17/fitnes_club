<?php

namespace App\Http\Controllers;

use App\Clients_GroupActivities;
use App\GroupActivity;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Clients_GroupActivitiesController extends Controller
{
    /**
     * Tworzenie rekordu w tabeli łączącej
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $id_client = $request->get('id_client');
        $id_activity = $request->get('id_activity');
        $max_participants = intval($request->get('max_participants'));
        $enrolled_participants = intval($request->get('enrolled_participants'));
        $actualDay = Carbon::now('Poland')->toDateTimeString();

        //sprawdzenie czy klient nie dołączył już do zajęć
        $exists = Clients_GroupActivities::where('id_group_activities', $request->get('id_activity'))
            ->where('id_client', $request->get('id_client'))->get();

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

            if ($date_from < $trainigDates['date_to'] && $date_from > $trainigDates['date_from']->subHour()) {
                $temp2 = 1;
            }
        }

        //sprawdzenie czy użytkownik posiada karnet - bez karnetu nie może uczestniczyć w zajęciach grupowych
        $actualTicket = DB::table('ticket')
            ->where('id_client_ticket', '=', $request->get('id_client'))
            ->get();

        if ($temp2 != 0) {
            return redirect('/groupActivities')->with('error', 'masz trening w tym samym czasie, dołącz do innych.');
        }
        if ($actualTicket->count()) {
            if ($date_from < $actualDay) {
                return redirect('/groupActivities')->with('error', 'Te zajęcia już się odbyły, lub masz trening w tym samym czasie, dołącz do innych.');
            } else if (!$exists->isEmpty()) {
                return redirect('/groupActivities')->with('error', 'Dołączyłeś już do  tych zajęć. Wybierz inne.');
            } else if ($max_participants > $enrolled_participants) {

                $client_group_activity = new Clients_GroupActivities();
                $client_group_activity->id_client = $id_client;
                $client_group_activity->id_group_activities = $id_activity;

                $client_group_activity->save();

                $groupActivities = GroupActivity::find($id_activity);
                $groupActivities->enrolled_participants += 1;
                $groupActivities->save();

                return redirect('/groupActivities')->with('success', 'Dołączyłeś do zajęć');
            } else {
                return redirect('/groupActivities')->with('error', 'Brak wolnych miejsc!');
            }
        } else {
            return redirect('/groupActivities')->with('error', 'Aby dołączyć do zajęć grupowych musisz posiadać karnet!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function deleteUserActivity($id, Request $request)
    {
        $actualDay = Carbon::now('Poland')->toDateTimeString();

        $clientGrupActivity = Clients_GroupActivities::where('id_client_group_activities', $id)->get();
        $activity = GroupActivity::where('id_group_activities', $clientGrupActivity[0]->id_group_activities)->get();

        if($actualDay > $activity[0]->date_time_from) {
            return redirect('/clientActivity')->with('error', 'To zajęcie grupowe już się odbyło, nie możesz się z niego wypisać.');
        } else {
            Clients_GroupActivities::where('id_client_group_activities', $id)->delete();
            $groupActivities = GroupActivity::find($request->get('id_activity'));
            $groupActivities->enrolled_participants -= 1;
            $groupActivities->save();

            return redirect('/clientActivity')->with('success', 'Wypisałeś się z zajęć.');
        }
    }
}

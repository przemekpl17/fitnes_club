<?php

namespace App\Http\Controllers;
use App\Client;
use App\PersonalTraining;
use Carbon\Carbon;
use DB;
use App\Clients_GroupActivities;
use Illuminate\Http\Request;

class PersonalTrainingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idClient = $request->get('id_client');
        $client = Client::find($idClient);
        $idTrainer = $request->get('id_trainer');
        $date_from = Carbon::parse($request->get('date_time_from'));
        $trainingPrice = $request->get('training_price');
        $clientAccountBalance = $request->get('account_balance');
        $date_to = Carbon::parse($request->get('date_time_from'))->addHour();

        //pobranie treningów personalnych zalogowanego użytkownika oraz porównanie daty każdego treningu z datą podaną przez użytkownika
        $temp1 = 0;
        $personalTrainings = DB::table('personal_training')->where('id_client', $idClient)->get();
        foreach ($personalTrainings as $pTraining) {
            $trainingDates = [
                'date_from' => $pTraining->date_time_from,
                'date_to' => $pTraining->date_time_to
            ];
            $trainingDates['date_from'] = Carbon::parse($trainingDates['date_from']);
            $trainingDates['date_to'] = Carbon::parse($trainingDates['date_to']);

            if( $date_from < $trainingDates['date_to']  && $date_from > $trainingDates['date_from']->subHour() ) {
                $temp1 = 1;
            }
        }

        //pobranie zajęć grupowych na podstawie tabeli łączącej
        $clientActivities = DB::table('client_group_activities')
            ->join('group_activities', 'client_group_activities.id_group_activities', '=', 'group_activities.id_group_activities')
            ->select('client_group_activities.*', 'group_activities.*')
            ->get();

        $temp2 = 0;
        foreach ($clientActivities as $clientActivity) {
            $activityDates = [
                'date_from' => $clientActivity->date_time_from,
                'date_to' => $clientActivity->date_time_to,
            ];
            $activityDates['date_from'] = Carbon::parse($activityDates['date_from']);
            $activityDates['date_to'] = Carbon::parse($activityDates['date_to']);

            if( $date_from < $activityDates['date_to']  && $date_from > $activityDates['date_from']->subHour() ) {
                $temp2 = 1;
            }
        }

        if($temp1 != 0 || $temp2 != 0) {

            return redirect('/personalTraining')->with('error', 'Błąd. Nie możesz zapisać się w tym czasie na trening personalny,
            ponieważ masz w tym czasie zaplanowane zajęcia grupowe lub inny trening!');

        }else {

            if($trainingPrice <= $clientAccountBalance){

                $personalTraining = new PersonalTraining();

                $personalTraining->date_time_from = $date_from;
                $personalTraining->date_time_to= $date_to;
                $personalTraining->id_trainer= $idTrainer;
                $personalTraining->id_client= $idClient;

                $personalTraining->save();

                $newAccountBalance = $clientAccountBalance - $trainingPrice;

                $client->account_balance = $newAccountBalance;
                $client->save();

                return redirect('/personalTraining')->with('success', 'Zakupiłeś trening personalny!');

            }else {

                return redirect('/personalTraining')->with('error', 'Masz za mało środków na koncie, doładuj konto.');
            }
        }
    }
}

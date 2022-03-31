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

        //pobranie treningów personalnych trenera oraz porównanie daty każdego treningu z datą podaną przez użytkownika
        $personalTrainings = DB::table('personal_training')->where('id_trainer', $idTrainer)->get();

        $temp2 = 0;
        foreach ($personalTrainings as $pTraining) {
            $trainingDates = [
                'date_from' => $pTraining->date_time_from,
                'date_to' => $pTraining->date_time_to
            ];
            $trainingDates['date_from'] = Carbon::parse($trainingDates['date_from']);
            $trainingDates['date_to'] = Carbon::parse($trainingDates['date_to']);

            if( $date_from < $trainingDates['date_to']  && $date_from > $trainingDates['date_from']->subHour() ) {
                $temp2 = 1;
            }
        }

        //pobranie zajęć grupowych na podstawie tabeli łączącej
        $clientActivities = DB::table('client_group_activities')
            ->join('group_activities', 'client_group_activities.id_group_activities', '=', 'group_activities.id_group_activities')
            ->select('client_group_activities.*', 'group_activities.*')
            ->get();

        $temp3 = 0;
        foreach ($clientActivities as $clientActivity) {
            $activityDates = [
                'date_from' => $clientActivity->date_time_from,
                'date_to' => $clientActivity->date_time_to,
            ];
            $activityDates['date_from'] = Carbon::parse($activityDates['date_from']);
            $activityDates['date_to'] = Carbon::parse($activityDates['date_to']);

            if( $date_from < $activityDates['date_to']  && $date_from > $activityDates['date_from']->subHour() ) {
                $temp3 = 1;
            }
        }
        //sprawdzenie czy użytkownik posiada karnet - bez karnetu nie może uczestniczyć w zajęciach grupowych
        $actualTicket = DB::table('ticket')
            ->where('id_client_ticket', '=', $idClient)
            ->get();
        
        if(!$actualTicket->count()) {
            return redirect('/personalTraining')->with('error', 'Aby zakupić trening personalny musisz posiadać karnet!');
        }

        if($temp2 != 0 ) {
            return redirect('/personalTraining')->with('error', 'Błąd. Nie możesz zapisać na trening personalny,
            ponieważ twój trener ma w tym czasie inne zajęcia. Wybierz innego trenera lub inny termin.');
        }

        if($temp1 != 0 ||  $temp3) {

            return redirect('/personalTraining')->with('error', 'Błąd. Nie możesz zapisać na trening personalny,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserPersonalTraining($id, $id_client)
    {

        $actualDay = Carbon::now('Poland')->toDateTimeString();

        $training = PersonalTraining::where('id_personal_training', $id)->get();

        $personalTraining = DB::table('personal_training')
            ->join('trainer', 'personal_training.id_trainer', '=', 'trainer.id_trainer')
            ->join('client', 'personal_training.id_client', '=', 'client.id_client')
            ->select('trainer.*', 'personal_training.*', 'client.*')
            ->get();

        if($actualDay > $training[0]->date_time_from) {
            return redirect('/clientActivity')->with('error', 'Ten trening już się odbył, nie możesz się z niego wypisać.');
        } else {
            //zwrócenie pieniędzy za trening na konto
            $newAccountBallance = $personalTraining[$id_client-1]->training_price + $personalTraining[$id_client-1]->account_balance;
            $client = Client::find($personalTraining[$id_client-1]->id_client);
            $client->account_balance = $newAccountBallance;

            $client->save();

            PersonalTraining::where('id_personal_training', $id)->delete();

            return redirect('/clientActivity')->with('success', 'Wypisałeś się z treningu personalnego. Pieniądze zostały zwrócone na twoje konto.');
        }
    }
}

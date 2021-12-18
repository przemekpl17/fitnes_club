<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalTraining extends Model
{
    protected $table = 'personal_training';
    protected $dates = ['date_time_from', 'date_time_to'];
    public $primaryKey = 'id_personal_training';
    public $timestamps = false;

}

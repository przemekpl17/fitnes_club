<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupActivity extends Model
{
    protected $table = 'group_activities';
    protected $dates = ['date_time_from', 'date_time_to'];
    public $primaryKey = 'id_group_activities';
    public $timestamps = false;
    protected $fillable = ['name', 'surname', 'date_time_from', 'date_time_to', 'room_number', 'max_participants', 'id_trainer'];

}

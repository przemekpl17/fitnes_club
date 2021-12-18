<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients_GroupActivities extends Model
{
    protected $table = 'client_group_activities';
    public $timestamps = false;
    public $primaryKey = 'id_client_group_activities';
}

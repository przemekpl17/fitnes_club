<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';
    public $primaryKey = 'id_ticket';
    public $timestamps = false;
    protected $dates = ['date_from', 'date_to'];

}

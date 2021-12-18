<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsInfo extends Model
{
    protected $table ='ticket_info';
    public $primaryKey = 'id_ticket_info';
    public $timestamps = false;
}

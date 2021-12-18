<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'trainer';
    public $primaryKey = 'id_trainer';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'id_client';
    protected $fillable = ['id_client', 'name', 'surname', 'gender', 'email', 'city', 'street', 'street_number', 'post_code'];
    protected $table = 'client';
    public $timestamps = false;
}

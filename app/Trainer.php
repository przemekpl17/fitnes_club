<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'trainer';
    public $primaryKey = 'id_trainer';
    protected $fillable = ['id_trainer', 'name', 'surname', 'gender', 'email', 'city', 'street', 'street_num', 'post_code', 'training_price'];
    public $timestamps = false;

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }
}



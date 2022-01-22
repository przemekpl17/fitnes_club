<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'description'];
    protected $dates = ['add_date'];
    public $timestamps = false;

    public function image() {
        return $this->hasMany(Images::class);
    }
}

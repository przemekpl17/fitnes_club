<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'articles_images';
    protected $primaryKey = 'id_articles_images';
    protected $fillable = ['name', 'article_id',];
    public $timestamps = false;

    public function article() {
        return $this->belongsTo(Article::class, 'id_article');
    }
}

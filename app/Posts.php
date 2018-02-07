<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = "posts";
    protected $primaryKey = "post_id";
    public $timestamps = true;
    public $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}

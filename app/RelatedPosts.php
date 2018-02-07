<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedPosts extends Model
{
    protected $table = "related_posts";
    protected $primaryKey = "related_post_id";
    public $timestamps = true;
    public $guarded = [];
}

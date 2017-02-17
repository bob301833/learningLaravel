<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $date = ['deleted_at'];

    // protected $table = 'posts';

    // protected $primaryKey = 'post_id';
    protected $fillable = [
        'title',
        'content'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function photos() {
        return $this->morphMany('App\Photo', 'imageable');
    }

}

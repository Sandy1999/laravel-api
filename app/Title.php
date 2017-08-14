<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = ['title'];

    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function posts(){
        return $this->hasMany(Post::Class);
    }

    // public static function hasPosts($topic,$post)
    // {
    //     return static::posts()->find($post->id);
    // } 
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar(){
        return 'https://www.gravtar.com/'.md5($this->email).'?s=45&d=mm';
    }
    public function posts(){
        return $this->hasMany(Post::Class);
    }

    public function titles(){
        return $this->hasMany(Title::Class);
    }
    public function ownsTopic($topic)
    {
        return $this->id === $topic->user->id;
    }
    public function ownsPost($post)
    {
        return $this->id === $post->user->id;   
    }
}

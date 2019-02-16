<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to', 'from', 'message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the user associated with the message.
     */
    public function to()
    {
        return $this->hasOne('App\User', 'id', 'to');
    }

    /**
     * Get the user associated with the message.
     */
    public function from()
    {
        return $this->hasOne('App\User', 'id', 'from');
    }
}

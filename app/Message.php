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
    public function toUser()
    {
        return $this->hasOne('App\User', 'id', 'to');
    }

    /**
     * Get the user associated with the message.
     */
    public function fromUser()
    {
        return $this->hasOne('App\User', 'id', 'from');
    }
}

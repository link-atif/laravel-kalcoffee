<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    //protected $guarded = ['*'];
   protected $fillable = ['message', 'mails'];

     public function setmailsAttribute($value)
    {
        $this->attributes['mails'] = json_encode($value);
    }

    public function getmailsAttribute($value)
    {
        return $this->attributes['mails'] = json_decode($value);
    }
}

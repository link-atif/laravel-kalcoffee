<?php

namespace App;
use App\Courses;
use App\Level;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function course(){
       return $this->belongsTo(Courses::class);
    }

    public function level(){
       return $this->belongsTo(Level::class);
    }

     /*public function order(){
       //return $this->hasMany(Order::class,'order_id','user_email');
    }*/
}

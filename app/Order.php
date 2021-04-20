<?php

namespace App;
use App\OrderDetail;
use App\User;
use App\Schedule;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function order_details(){
       return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(){
       return $this->belongTo(User::class, 'id', 'user_id');
    }
    public function schedule(){
     //  return $this->belongTo(Schedule::class, 'id', 'schedule_id');
    }
}

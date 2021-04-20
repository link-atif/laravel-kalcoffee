<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = ['product_id','product_code','product_name', 'session_id', 'quantity','price','course_id','level_id','schedule_id','image','level_name','schedule_date','user_email', 'bag_size', 'type', 'order_type'];
}

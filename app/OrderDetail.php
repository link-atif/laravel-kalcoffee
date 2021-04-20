<?php

namespace App;
use App\Order;
use App\Courses;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	public function order(){
		return $this->belongsTo(Order::class, 'id', 'order_id');
	}    

	public function course()
	{
    	return $this->belongsTo(Courses::class, 'course_id', 'id');
	}
}

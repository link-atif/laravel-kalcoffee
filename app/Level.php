<?php

namespace App;
use App\Courses;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
  	public function course(){
       return $this->belongsTo(Courses::class);
    }
}

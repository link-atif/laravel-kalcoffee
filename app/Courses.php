<?php

namespace App;
use App\Level;
use App\Schedule;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public function level(){
       return $this->hasMany(Level::class, 'course_id');
    }

    public function schedule(){
       return $this->hasMany(Schedule::class, 'course_id');
    }
}

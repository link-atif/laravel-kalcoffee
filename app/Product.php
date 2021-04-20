<?php

namespace App;
use App\Certificate;
use App\Variety;
use App\Process;
use App\Category;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
       return $this->belongsTo(Category::class);
    }

    public function variety(){
       return $this->belongsTo(Variety::class);
    }

    public function certificate(){
       return $this->belongsTo(Certificate::class);
    }

    public function process(){
       return $this->belongsTo(Process::class);
    }
}

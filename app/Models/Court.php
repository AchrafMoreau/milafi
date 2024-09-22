<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Judge;
use App\Models\Cas;


class Court extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id', 'location','isDefault', 'category'];

    public function judge(){
        return $this->hasMany(Judge::class);
    }

    public function cas(){
        return $this->hasMany(Cas::class);
    }

}

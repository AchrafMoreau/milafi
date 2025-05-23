<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Court;
use App\Models\Cas;

class Judge extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'contact_info','user_id', 'isDefault' , 'court_id', 'gender'];

    public function court(){
        return $this->belongsTo(Court::class);
    }
    public function cas(){
        return $this->hasMany(Cas::class);
    }
}

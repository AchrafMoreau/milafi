<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'type', 'title','allDay', 'start', "end", 'location', 'description'];

    public function user(){
        return $this->hasMany(User::class);
    }
}

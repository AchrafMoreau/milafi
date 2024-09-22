<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cas;

class Invoice extends Model
{
    use HasFactory;
    protected $fillabel = ['date', 'amount', 'desc', 'user_id', 'cas_id', 'status'];

    public function cas(){
        return $this->hasMany(Cas::class);
    }
}

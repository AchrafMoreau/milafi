<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cas;

class Procedure extends Model
{
    use HasFactory;
    protected $fillable = ['cas_id', 'date', 'procedure', 'fee', 'invoice'];

    public function cas(){
        return $this->belongsTo(Cas::class);
    }
}

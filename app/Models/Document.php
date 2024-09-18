<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cas_id', 'user_id', 'file_path', 'file_desc'];

    public function cas(){
        return $this->belongsTo(Cas::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}

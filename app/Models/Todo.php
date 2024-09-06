<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cas;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['title', "description", 'dueDate', 'status', 'priority'];


    public function cas(){
        return $this->belongsTo(Cas::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Court;
use App\Models\Client;
use App\Models\Judge;
use App\Models\User;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Procedure;
use App\Models\Todo;


class Cas extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',            
        'serial_number', 
        'title_file', 
        'title_number',
        'status',
        'court_id',
        'judge_id',
        'user_id',
        'report_number',
        'execution_number',
        'report_file',
        'execution_file',
        'opponent'
    ];

    public function court(){
        return $this->belongsTo(Court::class);
    }
    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function user(){
        return $this->hasMany(User::class);
    }

    public function document(){
        return $this->hasMany(Document::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function judge(){
        return $this->belongsTo(Judge::class);
    }
    public function todo(){
        return $this->hasMany(Todo::class);
    }

    public function procedure(){
        return $this->hasMany(Procedure::class);
    }
}

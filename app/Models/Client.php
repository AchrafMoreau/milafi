<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\Models\Cas;

class Client extends Model
{
    use HasFactory;
    use Sortable;
    protected $fillable = ['name', 'contact_info', 'address', 'image', 'CIN', 'gender', 'user_id'];
    protected $table = 'clients';  

    public function cas(){
        return $this->hasMany(Cas::class, 'client_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'mac', 'timer', 'active', 'rule'
    ];

    protected $hidden = [
    	'id', 'create_at', 'updated_at'
    ];

    public function coinlog()
    {
    	return $this->hasMany(CoinLog::class);
    }
}

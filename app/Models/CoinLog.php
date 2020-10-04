<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'active', 'pulse', 'client_id'
    ];

    protected $hidden = [
    	'id', 'client_id', 'create_at'
    ];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }
}

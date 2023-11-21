<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PawnTransactionStatus extends Model
{
    use HasFactory;
    public function pawnTransactionHeaders()
    {
        return $this->hasMany(PawnTransactionHeader::class);
    }
    
}

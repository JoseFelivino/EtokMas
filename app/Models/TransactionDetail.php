<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class TransactionDetail extends Model
{
    use HasFactory;

    public function gold()
    {
        return $this->belongsTo(Gold::class);
    }

    public function transactionHeader()
    {
        return $this->belongsTo(TransactionHeader::class);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(DateHelper::USER_FORMAT);
    }

}

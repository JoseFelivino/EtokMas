<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Helpers\General\DateHelper;

class Shelf extends Model
{
    use HasFactory;
    public function golds()
    {
        return $this->hasMany(Gold::class);
    }

    public function bookKeepingHeaders() {
        return $this->hasMany(BookKeepingHeader::class);
    }

    public function safeDelete() {
        if($this->golds->count() > 0) {
            foreach ($this->golds as $gold) {
                if($gold->stock != null) return Config::get('constants.ERROR_CODES.STOCK_DATA_EXISTS');
                if($gold->bookKeepingDetails->count() > 0) return Config::get('constants.ERROR_CODES.BOOKKEEPING_DATA_EXISTS');
            }
        }
        $this->delete();
        return Config::get('constants.SUCCESS');
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

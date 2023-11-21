<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\General\DateHelper;

class BookKeepingHeader extends Model
{
    use HasFactory;

    protected $casts = [
        'from_date' =>  'datetime:'.DateHelper::USER_FORMAT,
        'to_date' =>  'datetime:'.DateHelper::USER_FORMAT,
    ];

    public function bookKeepingDetails() {
        return $this->hasMany(BookKeepingDetail::class);
    }

    public function shelf() {
        return $this->belongsTo(Shelf::class);
    }
    

    public static function getLatestBookKeepingHeaderValue($shelfId) {
        return BookKeepingHeader::whereHas('shelf', function($query) use($shelfId){
            $query->where('id', $shelfId);
        })->orderBy('to_date', 'desc')->first();
    }

    public static function getBookKeepingHeaderByFilter(
        $shelfId,
        $from_fromDate, 
        $from_toDate,
        $to_fromDate, 
        $to_toDate
        ) {
        return BookKeepingHeader::where( function($query) use(
            $shelfId,
            $from_fromDate, 
            $from_toDate,
            $to_fromDate, 
            $to_toDate
        ) {
            
            if($shelfId) {
                $query->where('shelf_id', $shelfId);
            }

            if($from_fromDate && $from_toDate) {
                $query->whereDate('from_date', '>=', $from_fromDate)
                    ->whereDate('from_date', '<=', $from_toDate);
            }

            if($to_fromDate && $to_toDate) {
                $query->whereDate('to_date', '>=', $to_fromDate)
                    ->whereDate('to_date', '<=', $to_toDate);
            }
        });
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

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class TransactionHeader extends Model
{
    use HasFactory;
    protected $appends = ['totalPriceGold'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function transactionDetails() {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getTotalPriceGoldAttribute(){
        $totalPrice = 0;
        foreach ($this->transactionDetails as $transactionDetail) {
            $totalPrice += ($transactionDetail->price * $transactionDetail->quantity);
        }
        return $totalPrice;
    }

    public static function getTransactionHeaderThisMonth() {
        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();
        return TransactionHeader::getTransactionHeaderFromDateToDate($from, $to);
    }

    public static function getTransactionHeaderThisWeek() {
        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->endOfWeek();
        return TransactionHeader::getTransactionHeaderFromDateToDate($from, $to);
    }

    public static function getTransactionHeaderFromDateToDate($from, $to) {
        return TransactionHeader::whereDate('created_at', '>=', $from)
        ->whereDate('created_at', '<=', $to);
    }

    public static function getTransactionHeaderThisDay() {
        $date = Carbon::today();
        return TransactionHeader::whereDate('created_at', $date);
    }

    public static function getTransactionHeaderByFilter($keyword, $fromDate, $toDate) {
        return TransactionHeader::where( function($query) use(
            $keyword, 
            $fromDate,
            $toDate
        ) {
            if ($keyword) {
                $query->where(function($query) use($keyword) {
                    $query->where('id', $keyword)
                    ->orWhereHas('user', function($query) use($keyword) {
                        $query->where('name', 'like',  '%'. $keyword. '%');
                    })
                    ->orWhereHas('customer', function($query) use($keyword) {
                        $query->where('name', 'like',  '%'. $keyword. '%');
                    });
                });
            }

            if($fromDate && $toDate) {
                $query->whereDate('created_at', '>=', $fromDate)
                    ->whereDate('created_at', '<=', $toDate);
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

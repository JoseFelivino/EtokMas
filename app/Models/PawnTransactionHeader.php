<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\General\DateHelper;
use DateTime;

class PawnTransactionHeader extends Model
{
    use HasFactory;

    protected $casts = [
        'deadline_date' =>  'datetime:'.DateHelper::USER_FORMAT,
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pawnTransactionStatus()
    {
        return $this->belongsTo(PawnTransactionStatus::class);
    }

    private static function getDiffBetweenDate($dateFrom, $dateTo) {
        return $dateTo->diffInDays($dateFrom) + 1;
    }

    public function markAsDone() {
        $this->pawn_transaction_status_id = PawnTransactionStatus::where('status', 'done')->first()->id;
    }

    public function markAsUnDone() {
        $this->pawn_transaction_status_id = PawnTransactionStatus::where('status', 'undone')->first()->id;
    }

    public function getUpdatedAttributeForResolveTransaction() {
        $firstTempo = static::getDiffBetweenDate($this->created_at, $this->deadline_date);
        $currentTempo = static::getDiffBetweenDate($this->created_at, Carbon::today());
        $interest = $this->interest_total / $firstTempo;
        
        $dateDiff = abs($firstTempo - $currentTempo);
        $isLate = Carbon::today()->gt($this->deadline_date);
        $currentTotalInterest = $interest * $currentTempo;

        $returnPrice = $this->loan_price  + ($this->loan_price * ($currentTotalInterest / 100));
        return [
            'customerName' => $this->customer->name,
            'pawnTransactionStatus' => $this->pawnTransactionStatus->status,
            'userName' => $this->user->name,
            'deadlineDate' => DateHelper::changeFormatToFormat(DateHelper::SYSTEM_FORMAT, DateHelper::USER_DATE_FORMAT, $this->deadline_date),
            'loanPrice' => $this->loan_price,
            'returnPrice' => round($returnPrice),
            'totalInterest' => round($currentTotalInterest, 2),
            'created_at' => DateHelper::changeFormatToFormat(DateHelper::SYSTEM_FORMAT, DateHelper::USER_DATE_FORMAT, $this->created_at),
            'firstTempo' => $firstTempo,
            'dateDifferenceBetweenTodayAndDeadline' => $dateDiff,
            'isLate' => $isLate,
            'currentTempo' => $currentTempo,
            'currentDate' => DateHelper::getTodayDateCarbonWithUserDateFormat()
        ];
    }

    public function extendDeadlineDate($updatedDeadlineDate) {
        $formattedUpdatedDeadlineDate = DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, $updatedDeadlineDate);
        $firstTempo = static::getDiffBetweenDate($this->created_at, $this->deadline_date);
        $currentTempo = static::getDiffBetweenDate($this->created_at, $formattedUpdatedDeadlineDate);
        $interest = $this->interest_total / $firstTempo;

        $currentTotalInterest = $interest * $currentTempo;
        $returnPrice = $this->loan_price  + ($this->loan_price * ($currentTotalInterest / 100));

        $this->user_id = Auth::id();
        $this->return_price = $returnPrice;
        $this->interest_total = $currentTotalInterest;
        $this->deadline_date = $formattedUpdatedDeadlineDate;
        $this->markAsUnDone();
        $this->save();
    }

    public static function getPawnTransactionHeaderBasedOnStatus($isDone) {
        $status = $isDone ? 'done' : 'undone';
        $pawnTransactionHeaders =  PawnTransactionHeader::whereHas('pawnTransactionStatus', function($query) use($status) {
            $query->where('status', $status);
        });
        return $pawnTransactionHeaders;
    }

    public static function getPawnTransactionHeaderBasedOnDeadlineDate($from, $to, $isDone) {
        $pawnTransactionHeaders = PawnTransactionHeader::getPawnTransactionHeaderBasedOnStatus($isDone);
        return $pawnTransactionHeaders->whereDate('deadline_date', '>=', $from)
        ->whereDate('deadline_date', '<=', $to);
    }

    public static function getPawnTransactionHeaderDeadlineDateThisWeek($isDone) {
        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->endOfWeek();
        return PawnTransactionHeader::getPawnTransactionHeaderBasedOnDeadlineDate($from, $to, $isDone);
    }

    public static function getPawnTransactionHeaderDeadlineDateThisMonth($isDone) {
        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();
        return PawnTransactionHeader::getPawnTransactionHeaderBasedOnDeadlineDate($from, $to, $isDone);
    }

    public static function getPawnTransactionHeaderDeadlineDateThisDay($isDone) {
        $date = Carbon::today();
        $status = $isDone ? 'done' : 'undone';
        return PawnTransactionHeader::getPawnTransactionHeaderBasedOnStatus($isDone)
        ->whereDate('deadline_date', $date);
    }

    public static function getUndonePawnTransactionHeaderBasedOnDeadlineDateUpcomingOneWeek() {
        $date = Carbon::today()->addWeek();
        return PawnTransactionHeader::getPawnTransactionHeaderBasedOnDeadlineDate($date, $date, false);
    } 

    public static function getUndonePawnTransactionheaderBasedOnDeadlineDateUpcomingTwoDays() {
        $upcomingTwoDayDate = Carbon::today()->addDays(2);
        
         return PawnTransactionHeader::getPawnTransactionHeaderBasedOnDeadlineDate($upcomingTwoDayDate, $upcomingTwoDayDate, false);
    }

    public static function getUndonePawnTransactionheaderBasedOnDeadlineDateTomorrow() {
        $upcomingOneDayDate = Carbon::today()->addDays(1);
        
        return PawnTransactionHeader::getPawnTransactionHeaderBasedOnDeadlineDate($upcomingOneDayDate, $upcomingOneDayDate, false);
    }

    public static function getPawnTransactionHeaderByFilter($keyword, $pawnStatusId, $fromDate, $toDate) {
        return PawnTransactionHeader::where( function($query) use(
                $keyword, 
                $pawnStatusId,
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
            
            if($pawnStatusId) {
                foreach ($pawnStatusId as $id) {
                    $query->orWhere('pawn_transaction_status_id', $id);
                }
            }

            if($fromDate && $toDate) {
                $query->whereDate('deadline_date', '>=', $fromDate)
                    ->whereDate('deadline_date', '<=', $toDate);
            }
        });
    }

    public static function savePawnTransaction(
        $customerId,
        $itemPrice,
        $loanPrice,
        $interestTotal,
        $returnPrice,
        $deadlineDate
    ) {
        
        $pawnTransactionHeader = new PawnTransactionHeader();
        $pawnTransactionHeader->customer_id = $customerId;
        $pawnTransactionHeader->pawn_transaction_status_id = PawnTransactionStatus::where('status', 'undone')->first()->id;
        $pawnTransactionHeader->user_id = Auth::id();
        $pawnTransactionHeader->deadline_date = $deadlineDate;
        $pawnTransactionHeader->loan_price = $loanPrice;
        $pawnTransactionHeader->return_price = $returnPrice;
        $pawnTransactionHeader->interest_total = $interestTotal;
        $pawnTransactionHeader->item_price = $itemPrice;
        $pawnTransactionHeader->save();
        return  $pawnTransactionHeader;
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

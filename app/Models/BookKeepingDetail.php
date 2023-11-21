<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\General\DateHelper;

class BookKeepingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_keeping_header_id',
        'gold_id',
        'quantity',
        'isAddition' 
    ];

    protected $appends = ['totalPrice', 'totalWeight'];

    public function bookKeepingHeader()
    {
        return $this->belongsTo(BookKeepingHeader::class);
    }

    public function gold()
    {
        return $this->belongsTo(Gold::class);
    }

    public function getTotalPriceAttribute() {
        return $this->gold->price * $this->quantity;
    }

    public function getTotalWeightAttribute() {
        return round($this->gold->weight * $this->quantity, 2);
    }

    public function safeDelete(){
        if( $this->gold->stock != null ||
            $this->gold->transactionDetails->count() > 0 ||
            $this->gold->bookkeepingDetails->count() > 1 
            ) {
            $this->delete();
            return false;
        }
        $this->gold->delete();
        $this->delete();
        return true;
    }

    public static function getBookKeepingDetailsBasedOnShelveIdAndDateBetween($shelfId, $dateFrom, $dateTo) {

        return BookKeepingDetail::whereHas('gold', function($query) use($shelfId, $dateFrom, $dateTo) {
            $query->whereHas('shelf', function($query) use($shelfId){
                $query->where('id', $shelfId);
            });
            $query->where('book_keeping_details.created_at', '>', $dateFrom)
                ->where('book_keeping_details.created_at', '<=', $dateTo);
        });
    }

    public static function updateBookKeepingHeaderIdBasedOnShelveIdAndDate(
        $bookKeepingHeaderId, 
        $shelfId,
        $dateFrom,
        $dateTo
    ) {
        return BookKeepingDetail::getBookKeepingDetailsBasedOnShelveIdAndDateBetween($shelfId, $dateFrom, $dateTo)->update([
            'book_keeping_header_id' => $bookKeepingHeaderId
        ]);
    }

    public static function getBookKeepingDetailsWithCalculatedWeightAndPrice($shelfId) {
        $latestBookKeepingHeader = BookKeepingHeader::getLatestBookKeepingHeaderValue($shelfId);
        $to = Carbon::now();
        $calculatedWeight = 0;
        $totalPrice = 0;
        $totalQuantity = 0;
        $totalWeight = 0;
        $bookKeepingDetails = [];
        $fromDate = '';
        $allStockInShelf = [];


        if ($latestBookKeepingHeader == null) {
            $bookKeepingDetails = BookKeepingDetail::getBookKeepingDetailsBasedOnShelveIdAndDateBetween($shelfId, '1990-1-1', $to)->get();
            $firstBookKeepingDetail = BookKeepingDetail::getBookKeepingDetailsBasedOnShelveIdAndDateBetween($shelfId, '1990-1-1', $to)
                ->orderBy('created_at', 'ASC')
                ->first();
            $fromDate = $firstBookKeepingDetail ? $firstBookKeepingDetail->created_at : DateHelper::createCarbonFromFormat(DateHelper::FRONT_END_FORMAT, '1990-1-1');
            $allStockInShelf =  Stock::filterByNameOrIdCategoriesPriceCaratAndWeight(null, null, null, null, null, $shelfId, null, null)->get();
            
            foreach ($allStockInShelf as $stock) {
                $calculatedWeight += $stock->totalWeight;
                $totalPrice += $stock->totalPrice;
                $totalQuantity += $stock->quantity;
                $totalWeight += $stock->totalWeight;
            }
        } else {
    
            $bookKeepingDetails = BookKeepingDetail::getBookKeepingDetailsBasedOnShelveIdAndDateBetween($shelfId, $latestBookKeepingHeader->to_date, $to)->get();
            $fromDate = $latestBookKeepingHeader->to_date;
            $calculatedWeight = $latestBookKeepingHeader->scale_weight;
            $allStockInShelf =  Stock::filterByNameOrIdCategoriesPriceCaratAndWeight(null, null, null, null, null, $shelfId, null, null)->get();
            
            foreach ($bookKeepingDetails as $bookKeepingDetail) {
               
                if($bookKeepingDetail->isAddition)$calculatedWeight += $bookKeepingDetail->gold->weight;
                else $calculatedWeight -= $bookKeepingDetail->gold->weight;
            }

            foreach ($allStockInShelf as $stock) {
                $totalPrice += $stock->totalPrice;
                $totalQuantity += $stock->quantity;
                $totalWeight += $stock->totalWeight;
            }
        }

        return [
            'calculatedWeight' => round($calculatedWeight, 2),
            'totalPrice' => $totalPrice,
            'bookKeepingDetails' => $bookKeepingDetails,
            'fromDate' => $fromDate,
            'toDate' => $to,
            'allStockInShelf' => $allStockInShelf,
            'totalQuantity'=> $totalQuantity,
            'totalWeight'=> round($totalWeight, 2)
        ];
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

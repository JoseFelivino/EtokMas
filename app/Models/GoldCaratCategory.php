<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\General\DateHelper;

class GoldCaratCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'carat',
        'price',
        'fee'
    ];

    public function golds() 
    {
        return $this->hasMany(Gold::class);
    }

    public static function isCaratExist($carat) {
        if(GoldCaratCategory::where('carat', $carat)->exists()) return true;
        return false;
    }

    public static function getAndSaveGoldCaratCategoryInstance($carat, $price, $fee) {
        $newGoldCaratCategory = new GoldCaratCategory();
        $newGoldCaratCategory->carat = $carat;
        $newGoldCaratCategory->price = $price;
        $newGoldCaratCategory->fee = $fee;
        $newGoldCaratCategory->save();
        return $newGoldCaratCategory;
    }

    public function updateWithGoldStockPrice($newCarat, $newPrice, $newFee) {
        $this->update(
                [
                    'carat' => $newCarat,
                    'price' => $newPrice,
                    'fee' => $newFee
                ]
            );
        Stock::join('gold', 'gold.id', '=', 'stocks.id')
        ->where('gold.gold_carat_category_id', $this->id)
        ->update(
            [
                'price' => DB::raw("round($newPrice * round(gold.weight, 1), 0)")
            ]
        );
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

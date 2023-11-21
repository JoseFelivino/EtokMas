<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'gold_id',
        'quantity',
        'price',
        'created_at' ,
        'updated_at' ,
    ];
    protected $appends = ['totalPrice', 'totalWeight'];
    public function gold() {
        return $this->belongsTo(Gold::class);
    }

    public function getTotalPriceAttribute() {
        return $this->gold->price * $this->quantity;
    }

    public function getTotalWeightAttribute() {
        return round($this->gold->weight * $this->quantity, 2);
    }

    public static function getAndSaveNewStockInstanceWithCalculatedPrice(
        $goldId,
        $quantity
    ) {
        $stock = new Stock();
        $stock->gold_id = $goldId;
        $stock->quantity = $quantity;
        $stock->price = Gold::find($goldId)->price;
        $stock->save();
        $newBookKeepingDetail = new BookKeepingDetail();
        $newBookKeepingDetail->gold_id = $goldId;
        $newBookKeepingDetail->quantity = $quantity;
        $newBookKeepingDetail->isAddition = true;
        $newBookKeepingDetail->save();
        return $stock;
    }

    public function updateWithCalculatedPrice(
        $goldCaratCategoryId,
        $userId,
        $shelfId,
        $catagoryIds,
        $name,
        $weight,
        $img_path,
        $quantity
        ) {

        $quantityDiff = $quantity - $this->quantity;
        if($quantityDiff != 0) {
            $newBookKeepingDetail = new BookKeepingDetail();
            $newBookKeepingDetail->gold_id = $this->gold->id;
            $newBookKeepingDetail->quantity = abs($quantityDiff);
            if($quantityDiff > 0) {
                $newBookKeepingDetail->isAddition = true;
            } else {
                $newBookKeepingDetail->isAddition = false;
            }
            
            $newBookKeepingDetail->save();
        }
        

        $this->gold->update(
            [
                'gold_carat_category_id' => $goldCaratCategoryId,
                'user_id' => $userId,
                'shelf_id' => $shelfId,
                'name' => $name,
                'weight' => $weight,
                'img_path' => $img_path,
            ]
        );

        $this->update(
            [
                'quantity' => $quantity,
                'price' => $this->gold->price
            ]
        );

        $this->gold->categories()->sync($catagoryIds);
    }
    
    public function safeDelete() {
        $newBookKeepingDetail = new BookKeepingDetail();
        $newBookKeepingDetail->gold_id = $this->gold->id;
        $newBookKeepingDetail->quantity = $this->quantity;
        $newBookKeepingDetail->isAddition = false;
        $newBookKeepingDetail->save();
        if( 
            $this->gold->transactionDetails->count() > 0 ||
            $this->gold->bookkeepingDetails->count() > 0 
        ) {
            $this->delete();
            return false;
        }
        $this->gold->delete();
        $this->delete();
        return true;
    }

    public static function getStockSearchByNameOrId($nameOrId) {
        return Stock::whereIn('id', $nameOrId)->get();
    }

    public static function filterByNameOrIdCategoriesPriceCaratAndWeight(
        $nameOrId,
        $categories,
        $minPrice,
        $maxPrice,
        $caratId,
        $shelfId,
        $minWeight,
        $maxWeight
        ) {

        return Stock::whereHas('gold', function($query) use(
            $nameOrId,
            $categories,
            $minPrice,
            $maxPrice,
            $caratId,
            $shelfId,
            $minWeight,
            $maxWeight) {
            if($nameOrId) {
                $query->where(function ($query) use($nameOrId) {
                    $query->where('name', 'like',  '%'. $nameOrId. '%')
                    ->orWhere('id',$nameOrId);
                });
            }
            
            if ($categories != null && sizeof($categories) != 0) {
                $query->whereHas('categories', function($query) use($categories) {
                    $query->whereIn('name', $categories);
                });
            }
            
            if($minPrice && $maxPrice) $query->whereBetween('stocks.price',[$minPrice, $maxPrice]);
            elseif ($minPrice) {
                $query->where('stocks.price', '>', $minPrice);
            }
            elseif ($maxPrice) {
                $query->where('stocks.price', '<', $maxPrice);
            }
            
            if($caratId) $query->where('gold.gold_carat_category_id', $caratId);

            if($shelfId) $query->where('gold.shelf_id', $shelfId);
            
            if($minWeight && $maxWeight) $query->whereBetween('weight', [$minWeight, $maxWeight]);
            elseif ($minWeight) {
                $query->where('weight', '>', $minWeight);
            }
            elseif ($maxWeight) {
                $query->where('weight', '<', $maxWeight);
            }
        });
    }

    public static function getStockByCategories($categories) {
        return Stock::whereHas('gold', function($query) use($categories) {
            $query->whereHas('categories', function($query) use($categories) {
                $query->whereIn('name', $categories);
            });
        });
    }

    public static function removeItemInStockById($id, $removeQuantityCount) {
        $stockItem = Stock::all()->find($id);
        
        if($stockItem == null) return false;
        $quantityInStock = $stockItem->quantity;

        $totalQuantityLeft = $quantityInStock - $removeQuantityCount;
        if($totalQuantityLeft < 0) return false;
        if($totalQuantityLeft == 0) {
            $stockItem->safeDelete();
            return true;
        }

        $stockItem->quantity = $totalQuantityLeft;
        $newBookKeepingDetail = new BookKeepingDetail();
        $newBookKeepingDetail->gold_id = $stockItem->gold->id;
        $newBookKeepingDetail->quantity = $removeQuantityCount;
        $newBookKeepingDetail->isAddition = false;
        $newBookKeepingDetail->save();
        $stockItem->save();
        return true;
    }

    public static function getLowestPriceGoldValueInStock() {
        return Stock::min('price');
    }

    public static function getHighestPriceGoldValueInStock() {
        return Stock::max('price');
    }

    public static function getlightestGoldValueInStock() {
        return Stock::join('gold', 'gold.id', '=', 'gold_id')
        ->min('gold.weight');
    }

    public static function getHeaviestGoldValueInStock() {
        return Stock::join('gold', 'gold.id', '=', 'gold_id')
        ->max('gold.weight');
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

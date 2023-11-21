<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class Gold extends Model
{
    use HasFactory;
    protected $appends = ['price'];
    protected $fillable = [
        'gold_carat_category_id',
        'user_id',
        'shelf_id',
        'name' ,
        'weight',
        'img_path' 
    ];

    public function goldCaratCategory() {
        return $this->belongsTo(GoldCaratCategory::class);
    }

    public function stock() {
        return $this->hasOne(Stock::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails() {
        return $this->hasMany(TransactionDetail::class);
    }

    public function bookKeepingDetails() {
        return $this->hasMany(BookKeepingDetail::class);
    }

    public function categories() {
        return $this->belongsToMany(
            Category::class, 
            'gold_categories',
            'gold_id',
            'category_id'
        );
    }

    public function getPriceAttribute() {
        $caratPrice = $this->goldCaratCategory->price;
        $weight = $this->weight;
        return Gold::getPriceGoldBasedOnCaratPrice($caratPrice,$weight);
    }

    public function getWeightAttribute($weight) {
        return round($weight, 2);
    }

    public static function getPriceGoldBasedOnCaratPrice($caratPrice, $weight) {
        $roundedWeight = round($weight, 1);
        $price = round($caratPrice * $roundedWeight);
        return intval($price);
    }

    public static function getAndSaveNewGoldInstance(
        $goldCaratCategoryId,
        $userId,
        $shelfId,
        $categoryIds,
        $name,
        $weight,
        $imgPath
        
    ) {
        $gold = new Gold();
        $gold->gold_carat_category_id = $goldCaratCategoryId;
        $gold->user_id = $userId;
        $gold->shelf_id = $shelfId;
        $gold->name = $name;
        $gold->weight = $weight;
        $gold->img_path = $imgPath;
        
        $gold->save();
        $gold->categories()->attach($categoryIds);
        $gold->save();

        return $gold;
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

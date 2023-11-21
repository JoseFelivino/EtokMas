<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class Category extends Model
{
    use HasFactory;

    public function golds()
    {
        return $this->belongsToMany(
            Gold::class, 
            'gold_categories',
            'category_id',
            'gold_id'
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

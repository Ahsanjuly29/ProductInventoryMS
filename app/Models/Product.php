<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $fillable = ['name', 'description', 'price', 'sku'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

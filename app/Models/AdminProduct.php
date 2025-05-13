<?php

namespace App\Models;

use App\Models\Category;
use App\Models\CollectProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminProduct extends Model
{

    protected $fillable=['product_name','sku','description','categories_id','image','buy_price','sell_price','brand','tags'];
    protected $casts = [
        'tags' => 'array',
        'image'=>'array',
    ];

    public function Categories():BelongsTo
    {

        return $this->belongsTo(Category::class);
    }

    public function collectProductStock()
    {
        return $this->hasMany(CollectProductStock::class);
    }
}

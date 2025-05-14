<?php

namespace App\Models;

use App\Models\CollectProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionUserInfo extends Model
{
protected $table = 'collection_user_infos';
protected $fillable = ['collection_user','collection_id','total_value','quantity'];


    public function collectProductStocks(): HasMany
    {
        return $this->hasMany(CollectProductStock::class, 'unique_number', 'collection_id','buy_price');
    }
}

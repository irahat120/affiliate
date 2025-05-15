<?php

namespace App\Models;

use App\Models\AdminProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectProductStock extends Model
{
    protected $table = 'collect_product_stocks';
    protected $fillable = ['unique_number','admin_product_id','quantity','paid_price','collection_user','created_at','updated_at'];

    public function AdminProduct():BelongsTo
    {

        return $this->belongsTo(AdminProduct::class);
    }

    public function collectionUserInfo()
    {
        return $this->belongsTo(CollectionUserInfo::class, 'unique_number', 'collection_id');

    }

    public function collectproductstocklist()
    {

        return $this->hasMany(collectproductstocklist::class);
    }



}



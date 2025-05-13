<?php

namespace App\Models;

use App\Models\AdminProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectProductStock extends Model
{
    protected $fillable = ['unique_number','admin_product_id','quantity','paid_price','collection_user','created_at','updated_at'];

    public function AdminProduct():BelongsTo
    {

        return $this->belongsTo(AdminProduct::class);
    }

    

}

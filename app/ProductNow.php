<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductNow extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_product_now';

    protected $fillable = ['unit_price', 'delivery_cost', 'is_published', 'product_id', 'organization_id', 'user_id'];

    public static $rules = [
        "unit_price" => "required|numeric",
        "delivery_cost" => "required|numeric",
        "is_published" => "required|boolean",
        "product_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "user_id" => "required|numeric"
	];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
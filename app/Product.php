<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_product';

    protected $fillable = ['molecular_name', 'brand_name', 'pack_size', 'minimum_order_quantity', 'unit_price', 'delivery_cost', 'product_category_id'];

    public static $rules = [
        "molecular_name" => "required",
        "brand_name" => "required",
        "pack_size" => "required",
        "minimum_order_quantity" => "required|numeric",
        "unit_price" => "required|numeric",
        "delivery_cost" => "required|numeric",
        "product_category_id" => "required|numeric"
	];

    public function productcategory()
    {
        return $this->belongsTo('App\ProductCategory');
    }
    
}
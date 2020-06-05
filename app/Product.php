<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_product';

    protected $fillable = ['molecular_name', 'brand_name', 'pack_size', 'product_category_id', 'organization_id'];

    public static $rules = [
        "molecular_name" => "required",
        "brand_name" => "required",
        "pack_size" => "required",
        "product_category_id" => "required|numeric",
        "organization_id" => "required|numeric"
    ];

    public function product_category()
    {
        return $this->belongsTo('App\ProductCategory');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}

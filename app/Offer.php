<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_offer';

    protected $fillable = ['status', 'valid_from', 'valid_until', 'display_url', 'discount', 'min_order_quantity', 'max_discount_amount', 'product_now_id', 'organization_id'];

    public static $rules = [
        "status" => "required",
        "valid_from" => "required",
        "valid_until" => "required",
        "display_url" => "required",
        "discount" => "required|numeric",
        "min_order_quantity" => "required|numeric",
        "product_now_id" => "required|numeric",
        "organization_id" => "required|numeric"
    ];

    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}

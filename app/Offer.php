<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_offer';

    protected $fillable = ['description', 'valid_from', 'valid_until', 'discount', 'max_discount_amount', 'organization_id'];

    public static $rules = [
        "description" => "required",
        "valid_from" => "required",
        "valid_until" => "required",
        "discount" => "required|numeric",
        "max_discount_amount" => "required|numeric",
        "organization_id" => "required|numeric"
	];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_product_category';

    protected $fillable = ['name'];

    public static $rules = [
      "name" => "required|unique:tbl_product_category"
    ];

}
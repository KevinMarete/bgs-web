<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_menu';

    protected $fillable = ['name', 'link'];

    public static $rules = [
        "name" => "required|unique:tbl_menu",
        "link" => "required"
	];

}
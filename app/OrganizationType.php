<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationType extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_organization_type';

    protected $fillable = ['name', 'role_id'];

    public static $rules = [
        "name" => "required",
        "role_id" => "required|numeric"
	];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }

}
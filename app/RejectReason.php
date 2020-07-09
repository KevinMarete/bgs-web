<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RejectReason extends Model
{
  use SoftDeletes;

  protected $table = 'tbl_reject_reason';

  protected $fillable = ['name'];

  public static $rules = [
    "name" => "required|unique:tbl_role"
  ];
}

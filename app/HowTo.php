<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HowTo extends Model
{
  use SoftDeletes;

  protected $table = 'tbl_how_to';

  protected $fillable = ['title', 'link'];

  public static $rules = [
    "title" => "required",
    "link" => "required",
  ];
}

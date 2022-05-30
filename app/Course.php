<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'detail', 'items', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}

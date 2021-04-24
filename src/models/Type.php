<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $connection= 'forms';
    protected $fillable = ['name'];
}

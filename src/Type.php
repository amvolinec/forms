<?php

namespace Avart\Forms;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'av_types';
    protected $fillable = ['name'];
}

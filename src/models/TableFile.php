<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;

class TableFile extends Model
{
    protected $connection= 'forms';
    protected $fillable = ['table_id', 'name', 'uri'];

    public function table(){
        return $this->belongsTo('Avart\Forms\Models\Table');
    }
}

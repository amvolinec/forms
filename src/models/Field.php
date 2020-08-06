<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'av_fields';
    protected $fillable = ['table_id', 'type_id', 'name', 'title', 'fillable', 'nullable', 'inlist', 'default', 'settings'];

    public function table()
    {
        return $this->belongsTo('Avart\Forms\Models\Table');
    }

    public function type(){
        return $this->belongsTo('Avart\Forms\Models\Type');
    }
}

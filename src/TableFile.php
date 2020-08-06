<?php

namespace Avart\Forms;

use Illuminate\Database\Eloquent\Model;

class TableFile extends Model
{
    protected $table = 'av_table_files';
    protected $fillable = ['table_id', 'name', 'uri'];

    public function table(){
        return $this->belongsTo('Avart\Forms\Table');
    }
}

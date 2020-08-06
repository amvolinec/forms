<?php

namespace Avart\Forms;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'av_tables';
    protected $fillable = ['name', 'description', 'route', 'model', 'create_model', 'create_migration', 'create_controller', 'create_views', 'create_permissions'];

    public function fields()
    {
        return $this->hasMany('Avart\Forms\Field');
    }

    public function files()
    {
        return $this->hasMany('Avart\Forms\TableFile');
    }
}

<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $connection= 'forms';
    protected $fillable = ['name', 'description', 'route', 'model', 'create_model', 'create_migration', 'create_controller', 'create_views', 'create_permissions'];

    public function fields()
    {
        return $this->hasMany('Avart\Forms\Models\Field');
    }

    public function files()
    {
        return $this->hasMany('Avart\Forms\Models\TableFile');
    }
}

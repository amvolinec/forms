<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Field extends Model
{
    protected $fillable = ['table_id', 'type_id', 'name', 'title', 'fillable', 'nullable', 'inlist', 'default', 'settings'];
    protected $line = '$table->%2$s(\'%1$s\'%3$s)';
    protected $strings = ['string', 'text', 'char', 'longText', 'date', 'dateTime', 'time', 'json', 'jsonb'];

    public function table()
    {
        return $this->belongsTo('Avart\Forms\Models\Table');
    }

    public function type()
    {
        return $this->belongsTo('Avart\Forms\Models\Type');
    }

    public function getPropAttribute()
    {
        return json_decode($this->settings, ARRAY_FILTER_USE_BOTH);
    }

    public function getMigrationLineAttribute()
    {
        return sprintf($this->line,
            $this->name,
            $this->type->name,
            !empty($this->prop['parameters']) ? ',' . $this->prop['parameters'] : ''
        ).($this->nullable === 1 ? '->nullable()' : '') . $this->getDefault();
    }

    protected function getForeignAttribute() {
        return !empty($this->prop['belongsTo']) ? $this->castRelations() : '';
    }

    protected function getHasForeignAttribute() {
        return !empty($this->prop['belongsTo']);
    }

    protected function getRelatedModelAttribute() {
        if($this->has_foreign){
            return $this->prop['belongsTo'];
        }
    }

    protected function getDefault()
    {
        if($this->default === null){
            return '';
        }
        if (in_array($this->type->name, $this->strings)) {
            $default = sprintf('->default("%s")', $this->default);
        } else {
            $default = sprintf('->default(%s)', $this->default);
        }
        return $default;
    }

    protected function castRelations() {
        return sprintf('$table->foreign(\'%1$s\')->references(\'id\')->on(\'%2$s\')->onDelete(\'set null\');',
                $this->name,
                $this->getTableName()
            ) . PHP_EOL;
    }

    protected function getTableName(){
        $table = substr($this->prop['belongsTo'], 4);
        return Str::plural(strtolower( $table ));
    }
}

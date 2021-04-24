<?php

namespace Avart\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Field extends Model
{
    protected $connection= 'forms';
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
            ) . ($this->nullable === 1 ? '->nullable()' : '') . $this->getDefault();
    }

    protected function getForeignAttribute()
    {
        return $this->has_foreign ? $this->castRelations() : '';
    }

    protected function getHasForeignAttribute()
    {
        return !empty($this->prop['belongsTo']) || !empty($this->prop['belongsToMany']);
    }

    protected function getRelatedModelAttribute()
    {
        if ($this->has_foreign) {
            if($this->prop['belongsTo']){
                return $this->prop['belongsTo'];
            } else {
                return $this->prop['belongsToMany'];
            }
        }
    }

    protected function getDefault()
    {
        if ($this->default === null) {
            return '';
        }
        if (in_array($this->type->name, $this->strings)) {
            $default = sprintf('->default("%s")', $this->default);
        } else {
            $default = sprintf('->default(%s)', $this->default);
        }
        return $default;
    }

    protected function castRelations()
    {
        return sprintf('$table->foreign(\'%1$s\')->references(\'id\')->on(\'%2$s\')->onDelete(\'set null\');',
                $this->name,
                $this->getTableName()
            ) . PHP_EOL;
    }

    protected function getTableName()
    {
        $table = substr(isset($this->prop['belongsTo']) ? $this->prop['belongsTo'] : $this->prop['belongsToMany'], 4);
        return Str::plural(strtolower($table));
    }
}

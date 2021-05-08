<?php


namespace Avart\Forms\Creators;

use Avart\Forms\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ViewCreator implements CreatorInterface
{
    protected $model;
    protected $table;
    protected $route;
    protected $fields;
    protected $inner = '';

    public function __construct($model, $route, $fields, $table)
    {
        $this->model = $model;
        $this->route = $route;
        $this->fields = $fields;
        $this->table = $table;
    }

    public function create()
    {
        if($this->isFileUpload()){
            $content = file_get_contents(__DIR__ . '/../parts/create-fileupload.tmp');
        } else {
            $content = file_get_contents(__DIR__ . '/../parts/create.tmp');
        }

        $content = sprintf($content, $this->model, $this->route, $this->getInner());
        return $content;
    }

    protected function getInner()
    {
        foreach ($this->fields as $field) {
            if ($field->type->class === 'select') {
                try {
                    $content = file_get_contents(__DIR__ . "/../parts/form-group-{$field->type->class}.blade.php");
                    $name = substr($field->name, 0, strlen($field->name) - 3);
                    $this->inner .= sprintf($content, $field->name, $field->title, $this->getAdditional($field), $this->route, Str::plural($name));
                } catch (\Exception $exception) {
                    die($exception->getMessage() . "\n" . $field->type->class);
                }
            } else {
                try {
                    $content = file_get_contents(__DIR__ . "/../parts/form-group-{$field->type->class}.blade.php");
                    $this->inner .= sprintf($content, $field->name, $field->title, $this->getAdditional($field), $this->route);
                } catch (\Exception $exception) {
                    die($exception->getMessage() . "\n" . $field->type->class);
                }
            }
        }
        return $this->inner;
    }

    public function getAdditional($field)
    {
        if ($field->type->class === 'checkbox' && $field->default === '1') {
            return ' checked';
        }
        return '';
    }

    public function isFileUpload(){
        $files = Table::with('fields')
            ->where('name','=', $this->table)
            ->whereHas('fields', function (Builder $query) {
                $query->where('name','=', 'file_uri');
            })->count();
        return $files > 0;
    }
}

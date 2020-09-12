<?php


namespace Avart\Forms\Creators;

use Avart\Forms\Models\Field;
use Avart\Forms\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class ControllerCreator
{
    protected $model;
    protected $router;
    protected $table;
    protected $inner;
    protected $parameters;

    public function __construct($model, $table, $router)
    {
        $this->model = $model;
        $this->table = $table;
        $this->router = $router;
        $this->parameters = $this->getRelations();
    }

    public function create()
    {
        if ($this->isFileUpload()) {
            $content = file_get_contents(__DIR__ . '/../parts/controller-fileupload.stub');
            $content = sprintf($content, $this->model, $this->table, $this->router);
        } else {
            $content = file_get_contents(__DIR__ . '/../parts/controller.stub');
            $content = sprintf($content,
                $this->model,
                $this->table,
                $this->router,
                !empty($this->parameters) ? ',[' . $this->parameters . ']' : '',
                !empty($this->parameters) ? ',' . $this->parameters : ''
            );
        }


        return $content;
    }

    public function isFileUpload()
    {
        $files = Table::with('fields')
            ->where('name', '=', $this->table)
            ->whereHas('fields', function (Builder $query) {
                $query->where('name', '=', 'file_uri');
            })->count();
        return $files > 0;
    }

    public function getRelations()
    {
        $parameters = [];
        $table = Table::where('name', '=', $this->table)->first();

        if (empty($table)) {
            throw new \Exception('Table Not Found');
        }
        $fields = Field::where('table_id', '=', $table->id)->get();

//        Log::info('table_id: ' .$table->id . ' fields: ' . json_encode($fields));

        foreach ($fields as $field) {

//            Log::info('related model: ' . $field->name . ' ' . $field->related_model);

            if (isset($field->related_model)) {
                array_push($parameters, "'{$field->prop['fieldName']}' => \\{$field->prop['belongsTo']}::all()");
            }
        }

        return implode(',', $parameters);
    }

}

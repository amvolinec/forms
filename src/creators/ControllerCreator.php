<?php


namespace Avart\Forms\Creators;

use Avart\Forms\Models\Table;
use Illuminate\Database\Eloquent\Builder;

class ControllerCreator
{
    protected $model;
    protected $router;
    protected $table;
    protected $inner;

    public function __construct($model, $table, $router)
    {
        $this->model = $model;
        $this->table = $table;
        $this->router = $router;
    }

    public function create()
    {
        if($this->isFileUpload()){
            $content = file_get_contents(__DIR__ . '/../parts/controller-fileupload.stub');
        } else {
            $content = file_get_contents(__DIR__ . '/../parts/controller.stub');
        }

        $content = sprintf($content, $this->model, $this->table, $this->router);

        return $content;
    }

    protected function isFileUpload(){
        $files = Table::with('fields')
            ->where('name','=', $this->table)
            ->whereHas('fields', function (Builder $query) {
                $query->where('name','=', 'file_uri');
            })->count();
        return $files > 0;
    }

}

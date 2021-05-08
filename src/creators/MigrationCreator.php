<?php


namespace Avart\Forms\Creators;

class MigrationCreator implements CreatorInterface
{
    protected $fields;
    protected $table;
    protected $inner;

    public function __construct($table, $fields)
    {
        $this->fields = $fields;
        $this->table = $table;
    }


    public function create()
    {
        $content = file_get_contents(__DIR__ . '/../parts/migration.tmp');

        $inner = $this->getInner();

        $content = sprintf($content, $this->table, $inner, ucfirst($this->table));

        return $content;
    }

    protected function getInner()
    {
        foreach ($this->fields as $field) {
            if ($field->inlist) {
                $this->inner .= (!empty($this->inner) ? str_repeat("\t", 3) : '')
                    . $field->migration_line . ";\n"
                    . (!empty($field->foreign) ? "\t\t\t". $field->foreign . ";\n" : '');
            }
        }
        return $this->inner;
    }
}

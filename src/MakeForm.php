<?php

namespace Avart\Forms;

use Avart\Forms\Creators\ControllerCreator;
use Avart\Forms\Creators\MigrationCreator;
use Avart\Forms\Creators\TableCreator;
use Avart\Forms\Creators\ViewCreator;
use Avart\Forms\Models\Table;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Avart\Forms\Models\TableFile;

class MakeForm extends Command
{

    protected $model;
    protected $path;
    protected $fillable = 'protected $fillable = [%s];';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:form {model : The model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create form';

    protected $erase = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = base_path();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model_name = $this->argument('model');
        $this->model = Table::with('files')->where('model', '=', $model_name)->first();

        if (empty($this->model)) {

            $this->info('The model not found in DB');

        } else {

            if ($this->model->files->count() > 0) {
                $this->deleteFiles();
            }

            // Create Model
            if ($this->model->create_model === 1) {
                Artisan::call("make:model {$this->model->model}");
                $path = app_path("{$this->model->model}.php");
                $this->info('Model created ' . $path);

                $this->updateModel($path);
                $this->info('Model updated ' . $path);
                $this->addFile('Model', $path);
            }

            // Create Views
            if ($this->model->create_views === 1) {
                $filename = $this->createView();
                $this->info('Index View created ' . $filename);
                $this->addFile('Index view', $filename);

                $filename = $this->createViewCreate();
                $this->info('Create View created ' . $filename);
                $this->addFile('Crete View', $filename);
            }

            // Create Migration
            if ($this->model->create_migration === 1) {
                $filename = $this->createMigration();
                $this->info('Migration created ' . $filename);
                $this->addFile('Migration', $filename);
            }

            // Create Controller
            if ($this->model->create_controller === 1) {
                $filename = $this->createController();
                $this->info('Controller created ' . $filename);
                $this->addFile('Controller', $filename);
            }

            $this->migrate();

            $this->info($this->addRoute());

        }

    }

    protected function updateModel($path)
    {
        $str = [];
        $fields = $this->model->fields;
        foreach ($fields as $field) {
            if ($field->fillable === 1) {
                array_push($str, '"' . $field->name . '"');
            }
        }
        $content = file_get_contents($path);
        $fillable = sprintf($this->fillable, implode(', ', $str));
        $content = str_replace('//', ($fillable . "\n\n\t//"), $content);
        file_put_contents($path, $content);
    }

    protected function createView()
    {
        $dir = $this->path . '/resources/views/' . $this->model->route;
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                die("'Can't create folder");
            }
        }

        $creator = new TableCreator($this->model->name, $this->model->route, $this->model->fields);

        $fileName = $dir . '/index.blade.php';
        file_put_contents($fileName, $creator->get());
        return $fileName;
    }

    protected function createMigration()
    {
        $fileName = $this->path . '/database/migrations/' . date('Y_m_d_His') . '_create_' . $this->model->name . '_table.php';
        $creator = new MigrationCreator($this->model->name, $this->model->fields);
        file_put_contents($fileName, $creator->create());
        return $fileName;
    }

    protected function createController()
    {
        $fileName = $this->path . '/app/Http/Controllers/' . $this->model->model . 'Controller.php';
        $creator = new ControllerCreator($this->model->model, $this->model->name, $this->model->route);
        file_put_contents($fileName, $creator->create());
        return $fileName;
    }

    protected function createViewCreate()
    {
        $fileName = $this->path . '/resources/views/' . $this->model->route . '/create.blade.php';
        $creator = new ViewCreator($this->model->model, $this->model->route, $this->model->fields);
        file_put_contents($fileName, $creator->create());
        return $fileName;
    }

    protected function addFile($name, $uri)
    {
        $file = TableFile::create([
            'table_id' => $this->model->id,
            'name' => $name,
            'uri' => $uri
        ]);
        $this->model->files->add($file);
    }

    protected function deleteFiles()
    {
        $confirm = $this->ask('Delete existing files ? (y/n)');

        if ($confirm === 'y') {

            $this->erase = true;
            $last_migration = $this->getLastMigrationName();

            foreach ($this->model->files as $file) {

                // Rollback migration if last
                if (basename($file->uri, '.php') == $last_migration) {
                    $this->info("migrate:rollback {$last_migration} successful\n");
                    Artisan::call('migrate:rollback');
                }

                if (is_file($file->uri)) {
                    unlink($file->uri);
                    $this->info('file deleted ' . $file->uri);
                } else {
                    $this->info('file not found ' . $file->uri);
                }
            }

            $this->model->files()->delete();
        }
    }

    protected function getLastMigrationName()
    {
        return DB::table('migrations')->latest('id')->pluck('migration')->first();
    }

    protected function addRoute()
    {
        $file = base_path('routes/web.php');
        $routes = file_get_contents($file);

        $generated = "Route::resource('{$this->model->route}', '{$this->model->model}Controller');";

        if (strpos($routes, $generated) !== false) {
            return "Route already added!";
        }

        $added = "Route::group(['middleware' => ['web', 'auth']], function () {" . "\n    " . $generated;

        if (strpos($routes, "Route::group(['middleware' => ['web', 'auth']], function () {") !== false) {
            $routes = str_replace("Route::group(['middleware' => ['web', 'auth']], function () {", $added, $routes);

            try {
                if (file_put_contents($file, $routes)) {
                    return "Route just added now!";
                }
            } catch (Exception $exception) {
                return $exception->getMessage() . "\n\nAdd to routes/web.php:\n\n" . $generated;
            }

        } else {
            $generated = file_get_contents(__DIR__ . '/parts/web.php.stub');
            $routes = sprintf($generated, $this->model->route, $this->model->model);

            try {
                if (file_put_contents($file, $routes, FILE_APPEND)) {
                    return "Route just added now!";
                }
            } catch (Exception $exception) {
                return $exception->getMessage() . "\n\nAdd to routes/web.php:\n\n" . $generated;
            }
        }

        return "Add to routes/web.php:\n\n" . $generated;
    }

    protected function migrate()
    {
        if (!$this->erase) {
            $confirm = $this->ask('Run migrations ? (y/n)');
            if ($confirm === 'y') {
                Artisan::call('migrate');
                $this->info("Migrated successfully\n");
                return;
            }
        }
        $this->info("\nRun:\n\nphp artisan migrate\n\n");
    }
}

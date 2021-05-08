<?php

namespace Avart\Forms;

use App\Http\Controllers\DumpController;
use Illuminate\Console\Command;

class DbDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!empty(env('DB_PASSWORD'))){
            $cmd = sprintf('mysqldump -u %1$s -p%2$s -R --skip-triggers --no-create-info --no-create-db --ignore-table=%3$s.migrations --databases %3$s %5$s | gzip > %4$s.gz',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                env('DB_DUMP_PATH') . '/' .env('DB_DATABASE'). '_' . date('Ymd_His') . '.sql',
                env('DB_FORMS_DATABASE')
            );
        } else {
            $cmd = sprintf('mysqldump -u %1$s -R --skip-triggers --no-create-info --no-create-db --ignore-table=%2$s.migrations --databases %2$s %4$s | gzip > %3$s.gz',
                env('DB_USERNAME'),
                env('DB_DATABASE'),
                env('DB_DUMP_PATH') . '/' .env('DB_DATABASE'). '_' . date('Ymd_His') . '.sql',
                env('DB_FORMS_DATABASE')
            );
        }

        shell_exec($cmd);
        $this->info('Mysqldump completed');
    }
}

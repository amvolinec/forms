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
            $cmd = sprintf("mysqldump -u %s -p%s -R --skip-triggers --no-create-info --no-create-db %s fields tables > %s",
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                env('DB_DUMP_PATH')
            );
        } else {
            $cmd = sprintf("mysqldump -u %s -R --skip-triggers --no-create-info --no-create-db %s fields tables > %s \n",
                env('DB_USERNAME'),
                env('DB_DATABASE'),
                env('DB_DUMP_PATH')
            );
        }

        shell_exec($cmd);
    }
}

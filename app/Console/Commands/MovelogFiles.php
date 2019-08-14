<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MovelogFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mlf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moves the log files to a different location';

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
        exec('mv ./storage/logs/lara* ./storage/backups/logs');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmptyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:empty-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        //DB::table('locations')->truncate();
    }
}

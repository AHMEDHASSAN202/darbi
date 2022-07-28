<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DarbiResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'darbi:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Application: routes, migrates, seeders, config, cache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call("route:clear");
        $this->call("config:clear");
//        $this->call("module:migrate-refresh");
//        $this->call("module:seed");
        $this->call("cache:clear");
//        $this->call("optimize");
    }
}

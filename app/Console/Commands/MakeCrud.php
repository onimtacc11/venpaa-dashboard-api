<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Model, Migration, Controller, Resource, and Request for a given name';

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
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Create Controller
        $this->call('make:controller', [
            'name' => "{$name}Controller",
            '--api' => true,
        ]);

        // Create Resource
        $this->call('make:resource', [
            'name' => "{$name}Resource",
        ]);

        // Create Request
        $this->call('make:request', [
            'name' => "{$name}Request",
        ]);

        $this->info("✅ CRUD boilerplate for {$name} created successfully!");
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class TestComman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command';

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
        DB::table('access_log')->insert([
            'url' => 'TEST CRON JOB',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $this->info('The successfully!');
    }
}

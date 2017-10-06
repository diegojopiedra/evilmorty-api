<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class Super extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the all super users';

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
      $headers = ['ID', 'Super User'];
      $users = User::where('superUser', '=', true)->get(['email']);
      $this->table($headers, $users);
    }
}

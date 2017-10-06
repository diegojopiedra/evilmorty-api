<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class SuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super:create {email : The email to login in the app} {pwd : The password to login in the app} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create a USER ONE or first SUPER USER';

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
      $user =  new User();
      $user->email = $this->argument('email');
      $user->password = Hash::make($this->argument('pwd'));
      $user->superUser = true;
      $user->save();
      $this->info("Super User created successfully email: " . $user->email);

      $headers = ['ID', 'Super User'];

      $users = User::where('superUser', '=', true)->get(['email']);

      $this->table($headers, $users);
    }
}

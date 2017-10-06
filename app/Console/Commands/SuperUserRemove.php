<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class SuperUserRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super:remove {email : User email to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Super User to DataBase';

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
      $userToDelete = User::where('email', $this->argument("email"))->first();
      if($userToDelete){
        if($userToDelete->superUser){
          $this->info("To delete a Super user (" . $this->argument("email") . ") for the database you first need use your Super user credentials.");
          if($this->credentials(0)){
            if($this->confirm("Are you sure to delete this user?")){
              $userToDelete->delete();
              $this->info("Delete ready!");
              $headers = ['ID', 'Super User'];
              $users = User::where('superUser', '=', true)->get(['email']);
              $this->table($headers, $users);
            }
          }else{
            $this->error("Credentials NO match, :'(");
          }
        }else{
          $this->error("The user email:". $this->argument("email") .", is not a Super User");
        }
      }else{
        $this->error("The user email: " . $this->argument("email") . ", not exist in the data base.");
      }
    }

    private function credentials($times){
      $email = $this->ask("Your email");
      $pwd = $this->secret("Your password");

      $user = User::where('email', $email)->first();

      if($user){
        if($user->superUser){
          if(Hash::check($pwd, $user->password)){
            return true;
          }
        }else{
          $this->error("You are not a Super user");
        }

      }
      if($times == 2){
        return false;
      }else{
        $this->error("Credentials no match, try again!");
        return $this->credentials($times+=1
      );
      }

    }
}

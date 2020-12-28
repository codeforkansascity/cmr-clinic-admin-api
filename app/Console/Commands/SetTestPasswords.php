<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetTestPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:set-test-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set all users passwords to serverisrestored';

    /**
     * @var string Password assigned to all users.
     */
    protected $password = 'secret';

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
        foreach (User::get() as $user) {
            echo $user->email . "\n";
            $user->password = bcrypt(env('TEST_USER_PASSWORD', 'bird-travel-car'));
            $user->save();
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeFirstUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:make-first-user';

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
        echo env('APP_NAME');

        $user_name = 'Paul Barham';
        $user_email = 'paulb@savagesoft.com';

        $user  = \App\User::where('email', $user_email)->first();

        if ( $user ) {
            $this->error( "User |$user_name|$user_email| exists, cannot add");
            die();
        }

        $user = \App\User::create([
            'email' => $user_email,
            'name' => $user_name,
            'password' => bcrypt('secret')
        ]);
    }
}

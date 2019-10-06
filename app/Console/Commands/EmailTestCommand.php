<?php

namespace App\Console\Commands;

use Mail;
use App\Mail\EmailTest;
use Illuminate\Console\Command;


class EmailTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:email-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email';

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
        Mail::to('paulb@savagesoft.com', 'Paul Barham')
            ->send(new EmailTest());

        print "GOOD\n";
    }
}

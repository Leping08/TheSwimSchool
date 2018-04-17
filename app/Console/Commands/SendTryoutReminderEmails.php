<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Library\TryoutReminderEmail;

class SendTryoutReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-tryout-reminder-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send tryout reminder emails if the tryout starts tomorrow.';

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
        Log::info("Starting to send tryout reminder emails.");
        (new TryoutReminderEmail)->sendReminderEmails();
        Log::info("Starting to send tryout reminder emails.");
    }
}

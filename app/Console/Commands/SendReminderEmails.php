<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Library\GroupLessonsReminderEmail;

class SendReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-lesson-reminder-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send lesson reminder emails if the group lesson starts tomorrow.';

    /**
     * Create a new command instance.
     *
     * @return $this
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
        Log::info("Starting to send lesson reminder emails.");
        (new GroupLessonsReminderEmail)->sendReminderEmails();
        Log::info("Finished sending lesson reminder emails.");
    }
}

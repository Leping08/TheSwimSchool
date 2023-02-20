<?php

namespace App\Jobs\NewsLetter;

use App\Library\NewsLetter\NewsLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The emails to remove.
     *
     * @var array
     */
    protected $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->emails)->map(function ($complaintEmail) {
            NewsLetter::unsubscribe($complaintEmail['address']);
        });
    }
}

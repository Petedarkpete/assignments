<?php

namespace App\Jobs;

use App\Mail\AssignmentNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendAssignmentNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $assignment;
    public $email;
    public function __construct($assignment, $email)
    {
        $this->assignment = $assignment;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new AssignmentNotificationMail($this->assignment));
    }
}

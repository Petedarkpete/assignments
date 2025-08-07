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
    public function __construct($assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->assignment->teacher->email)->send(new AssignmentNotificationMail($this->assignment));
    }
}

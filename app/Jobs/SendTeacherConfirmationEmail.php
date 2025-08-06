<?php

namespace App\Jobs;

use App\Mail\TeacherConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTeacherConfirmationEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $teacher;
    public function __construct($teacher)
    {
        //
        $this->teacher = $teacher;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->teacher->email)->queue(new TeacherConfirmationMail($this->teacher));
    }
}

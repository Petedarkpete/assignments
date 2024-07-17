<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Student;
use App\Models\Assignment;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'assignment_id',
        'instructor_id',
        'submission_file',
        'name',
        'grade',
        'feedback',
    ];
    public $timestamps = true;

    public function student()
    {
        return $this->HasMany(User::class);
    }

    public function instructor()
    {
        return $this->BelongsTo(User::class);
    }

    public function assignment()
    {
        return $this->BelongsTo(UploadedAssignment::class);
    }
}

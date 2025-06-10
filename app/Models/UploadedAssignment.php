<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadedAssignment extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'uploaded_assignments';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'external_link',
        'due_date',
        'teacher_id',
        'class_id',
        'subject_id',
    ];

    public $timestamps = true;

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->hasMany(Submission::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

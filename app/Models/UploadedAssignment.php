<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UploadedAssignment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'year',
        'course',
        'deadline',
        'title',
        'details',
        'user_id',
        'file'
    ];

    public $timestamps = true;

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}

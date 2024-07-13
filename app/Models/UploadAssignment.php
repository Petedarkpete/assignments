<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadAssignment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'year',
        'course',
        'deadline',
        'title',
        'details'
    ];

    public $timestamps = true;
}

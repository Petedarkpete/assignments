<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qualification',
        'specialization',
        'is_class_teacher',
        'join_date'

    ];

    public $timestamps = true;

    protected $casts = [
        'is_class_teacher' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function streams()
    {
        return $this->hasOne(Stream::class);
    }
}

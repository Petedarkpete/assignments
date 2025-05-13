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
        'class_assigned',
        'join_date'

    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function streams()
    {
        return $this->hasOne(Stream::class);
    }

    public function clas()
    {
        return $this->hasMany(Clas::class);
    }

    public function teacher()
    {
        return $this->hasMany(Student::class);
    }
}

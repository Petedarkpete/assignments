<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    //
    use HasFactory;

    protected $table = 'class';

    protected $fillable = ['label', 'stream_id', 'teacher_id', 'status'];

    public $timestamps = true;

    public function streams()
    {
        return $this->belongsTo(Stream::class, 'id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'user_id');
    }

    public function students ()
    {
        return $this->hasMany(Student::class);
    }
}

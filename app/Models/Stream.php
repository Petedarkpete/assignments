<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    //
    protected $table = 'streams';

    protected $fillable = ['stream', 'teacher_id', 'status'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function clas()
    {
        return $this->hasMany(Clas::class);
    }

}

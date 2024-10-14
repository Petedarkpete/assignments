<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'is_active',
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function course()
    {
        return $this->hasMany(Course::class);
    }
    public function classroom(){
        return $this->hasMany(Classroom::class);
    }
     
}

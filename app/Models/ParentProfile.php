<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentProfile extends Model
{
    //
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = ['user_id', 'relationship','national_id','passport','occupation'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MClass extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','class','year','user'
    ];
    public $timestamps = true;

    public function Year(){
        return $this -> belongsTo(Year::class);
    }
    public function User(){
        return $this -> hasMany(User::class);
    }
}

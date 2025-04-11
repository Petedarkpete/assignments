<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Module;

class Submodule extends Model
{
    //
    use HasFactory;

    protected $table = 'submodules';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'url',
        'module_id',
        'order',
        'status',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id'); 
    }
}

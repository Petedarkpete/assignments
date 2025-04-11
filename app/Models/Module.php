<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SubModule;

class Module extends Model
{
    //
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'url',
        'order',
        'status',
    ];

    public function submodules()
    {
        return $this->hasMany(Submodule::class, 'module_id'); // One module has many submodules
    }
}

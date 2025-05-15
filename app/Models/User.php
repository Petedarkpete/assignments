<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements LaratrustUser
{
    use HasFactory, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'other_names',
        'email',
        'password',
        'phone',
        'gender',
        'address',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function UploadedAssignment(): HasMany
    {
        return $this->hasMany(UploadedAssignment::class);
    }

    public function submission()
    {
        return $this->hasMany(Submission::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function mclass(){
        return $this->belongsTo(MClass::class);
    }
    public function classroom(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function teachers(){
        return $this->hasMany(Teacher::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }
}

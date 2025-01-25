<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',  'last_name', 'phone_number',
        'location','cv_file_path', 'image', 'certificates', 'languages',
        'portfolio_url', 'presentation', 'experience','desired_job',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCompanyOwner()
    {
        return $this->role === 'company_owner';
    }
}
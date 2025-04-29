<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRole;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'location', 'profile_image', 'bio', 'specialization',
    ];

       protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'specialist_id');
    }public function isSpecialist()
    {
        return $this->role === 'specialist';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function getSpecialization()
    {
        return $this->specialization;
    }

    // Get profile image URL
    public function getProfileImageUrl()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('images/default-profile.png');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'full_name',
        'password_hash',
        'phone',
        'role_id',
        'profile_image_url',
        'status',
        'last_login',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_hash',
        'remember_token',
    ];

    /**
     * Get the password for the user (supports both password and password_hash columns).
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password ?? $this->password_hash;
    }

    /**
     * Accessor for name to match full_name or name.
     */
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? ($this->attributes['full_name'] ?? 'Admin User');
    }

    /**
     * Accessor for full_name to match name.
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['full_name'] ?? ($this->attributes['name'] ?? 'Admin User');
    }

    /**
     * Accessor for username.
     */
    public function getUsernameAttribute()
    {
        return $this->attributes['username'] ?? (isset($this->attributes['email']) ? explode('@', $this->attributes['email'])[0] : 'admin');
    }

    /**
     * Mutator for password to ensure hashing.
     */
    public function setPasswordAttribute($value)
    {
        $hash = \Illuminate\Support\Facades\Hash::needsRehash($value)
            ? \Illuminate\Support\Facades\Hash::make($value)
            : $value;
        $this->attributes['password'] = $hash;
        $this->attributes['password_hash'] = $hash;
    }
}

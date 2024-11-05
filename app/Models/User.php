<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'telp',
        'password',
        'nama',
        'foto',
        'bagian',
        'is_cbt',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function isAdmin()
    {
        if ($this->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function isUser()
    {
        if ($this->role == 'user') {
            return true;
        } else {
            return false;
        }
    }

    public function isTamu()
    {
        if ($this->role == 'tamu') {
            return true;
        } else {
            return false;
        }
    }

    public function isSupport()
    {
        if ($this->bagian == 'support') {
            return true;
        } else {
            return false;
        }
    }

    public function isCbt()
    {
        return $this->is_cbt;
    }
}

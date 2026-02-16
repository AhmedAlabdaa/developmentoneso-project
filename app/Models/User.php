<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, \Laravel\Sanctum\HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'nationality',
        'status_changed',
        'status',
        'api_token',
        'api_token_created_at',
    ];

    protected $hidden = [
        'password',
        'api_token',
    ];

    protected $casts = [
        'api_token_created_at' => 'datetime',
    ];

    public function generateToken(): string
    {
        $this->api_token = Str::random(60);
        $this->api_token_created_at = now();
        $this->save();
        return $this->api_token;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

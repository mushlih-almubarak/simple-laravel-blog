<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Notifications\PasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // Field-field ini bisa diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'ip_address',
        'country',
        'city'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url('/password/reset') . "/$token";
        $this->notify(new PasswordReset($url));
    }
}

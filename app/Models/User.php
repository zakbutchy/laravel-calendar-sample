<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * デフォルトの予定を登録
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->calendars()->createMany([
                [
                    'name' => '仕事',
                    'color' => 'blue',
                    'visibility' => 1,
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'プライベート',
                    'color' => 'green',
                    'visibility' => 1,
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'その他',
                    'color' => 'red',
                    'visibility' => 1,
                    'user_id' => $user->id,
                ],
            ]);
        });
    }

    /**
     * カレンダーとのリレーション
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}

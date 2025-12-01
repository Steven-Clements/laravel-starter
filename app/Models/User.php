<?php

/**
 * Clementine Solutions
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

/**
 * User
 * —————————————————————————————————————————————————————————————————————————————
 * Specifies how properties are treated by the Database Abstraction Layer (DAL).
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasUuids;


    /**
     * @param array $fillable
     * Specifies which properties can be mass assigned.
     */
    protected $fillable = [
        'profile_picture',
        'name',
        'username',
        'email',
        'password',
    ];


    /**
     * @param array $hidden
     * Specifies which properties are hidden by default.
     */
    protected $hidden = [
        'password',
        'secret_pin',
        'enrolled_mfa_methods',
        'remember_token',
        'last_login_ip'
    ];


    /**
     * casts
     * ——————————————————————————————————————————————————————————————————————————
     * Defines how the DAL should cast values before saving them to the database.
     * @return array
     * An associative array of the values which should be casted.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_mfa_enabled' => 'boolean',
            'enrolled_mfa_methods' => 'array',
            'secret_pin' => 'hashed',
            'last_login_at' => 'datetime'
        ];
    }
}

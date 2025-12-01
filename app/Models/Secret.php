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

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Secret
 * —————————————————————————————————————————————————————————————————————————————
 * Specifies how properties are treated by the Database Abstraction Layer (DAL).
 */
class Secret extends Model
{
    use HasFactory, HasUuids;

    /**
     * @param array $fillable
     * Specifies which properties can be mass assigned.
     */
    protected $fillable = [
        'user_id',
        'type',
        'public_key',
        'private_key',
        'recovery_keys',
        'expires_at'
    ];


    /**
     * @param array $hidden
     * Specifies which properties are hidden by default.
     */
    protected $hidden = [
        'private_key',
        'recovery_keys',
        'rotated_at'
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
            'private_key' => 'hashed',
            'expires_at' => 'datetime',
            'rotated_at' => 'datetime',
            'last_used_at' => 'datetime'
        ];
    }
}

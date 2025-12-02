<?php

/**
 * Greenhouse
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Defines the properties comprising the user resource.
 */
return new class extends Migration
{
    /**
     * up
     * ——————————————————————————————————————————————————————————————————————————
     * Run migrations.
     */
    public function up(): void
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Secrets table } —— ⦿ —— ⦿ —— ⦿ —— */
        Schema::create('secrets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(model: User::class);
            $table->enum('type', ['sms-voice', 'totp', 'passkey', 'recovery'])->default('totp');
            $table->text('public_key')->nullable();
            $table->text('private_key')->nullable();
            $table->json('recovery_keys')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('rotated_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * down
     * ——————————————————————————————————————————————————————————————————————————
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secrets');
    }
};

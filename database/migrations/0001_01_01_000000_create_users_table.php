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
        /* —— ⦿ —— ⦿ —— ⦿ —— { Users table } —— ⦿ —— ⦿ —— ⦿ —— */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'locked', 'suspended', 'banned'])->default('active');
            $table->string('profile_picture')->default('profile-picture.png');
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('secretPin')->nullable();
            $table->boolean('is_mfa_enabled')->default(false);
            $table->json('enrolled_mfa_methods')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });


        /* —— ⦿ —— ⦿ —— ⦿ —— { Password reset tokens table } —— ⦿ —— ⦿ —— ⦿ —— */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });


        /* —— ⦿ —— ⦿ —— ⦿ —— { Sessions table } —— ⦿ —— ⦿ —— ⦿ —— */
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * down
     * ——————————————————————————————————————————————————————————————————————————
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

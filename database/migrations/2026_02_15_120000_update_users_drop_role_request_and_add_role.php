<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('remember_token');
            });
        }

        if (Schema::hasColumn('users', 'role_request')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_request');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('users', 'role_request')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_request')->nullable();
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mark all existing users as verified
        // This is for users created before OTP system was implemented
        DB::table('users')->update([
            'is_verified' => true,
            'email_verified_at' => DB::raw('COALESCE(email_verified_at, NOW())'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't reverse this as it would lock out existing users
        // If you need to rollback, manually set is_verified to false for specific users
    }
};

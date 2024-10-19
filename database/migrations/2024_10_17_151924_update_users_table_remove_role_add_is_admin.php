<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableRemoveRoleAddIsAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'role' column if it exists
            $table->dropColumn('role');

            // Add the 'is_admin' column as a boolean with a default value of false
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the 'role' column if rolling back the migration
            $table->string('role')->default('user');

            // Drop the 'is_admin' column
            $table->dropColumn('is_admin');
        });
    }
}

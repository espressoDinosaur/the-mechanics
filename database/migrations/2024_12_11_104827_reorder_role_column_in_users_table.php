<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing column first
            $table->dropColumn('role');
        });

        // Add the 'role' column after the 'password' column
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->after('password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the 'role' column if rolling back
            $table->dropColumn('role');
        });
    }
};

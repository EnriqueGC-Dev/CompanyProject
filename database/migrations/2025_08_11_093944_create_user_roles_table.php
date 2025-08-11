<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id('user_role_id');
            $table->string('user_role_description');
            $table->timestamps();
        });

        // Insert default role
        DB::table('user_roles')->insert([
            'user_role_id' => 1, 'user_role_description' => 'App_Admin',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('user_roles')->insert([
            'user_role_id' => 2, 'user_role_description' => 'Director',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('user_roles')->insert([
            'user_role_id' => 3, 'user_role_description' => 'Manager',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('user_roles')->insert([
            'user_role_id' => 4, 'user_role_description' => 'Empleado',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('user_roles')->insert([
            'user_role_id' => 5, 'user_role_description' => 'RRHH',
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('user_roles')->where('user_role_id', 1)->delete();
        DB::table('user_roles')->where('user_role_id', 2)->delete();
        DB::table('user_roles')->where('user_role_id', 3)->delete();
        DB::table('user_roles')->where('user_role_id', 4)->delete();
        DB::table('user_roles')->where('user_role_id', 5)->delete();
        Schema::dropIfExists('user_roles');
    }
};
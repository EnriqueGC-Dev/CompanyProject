<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('user_photo')->nullable()->unique();
            $table->integer('user_phone')->nullable();
            $table->date('user_birthday')->nullable();
            $table->boolean('user_company_admin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
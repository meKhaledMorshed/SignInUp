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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50)->comment('Users fullname');
            $table->string('email', 50)->comment('Users email address');
            $table->string('password', 100)->comment('Users Password');
            $table->boolean('twoFA')->default(0)->comment('Two FA Status');
            $table->boolean('isActive')->default(0)->comment('User Status');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

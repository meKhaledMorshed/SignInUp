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
        Schema::create('twofatokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uid')->constrained('users', 'id')->onDelete('cascade');
            $table->string('token', 50);
            $table->unsignedBigInteger('expiryTime')->comment('Timestamp in seconds');
            $table->boolean('validity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twofatokens');
    }
};

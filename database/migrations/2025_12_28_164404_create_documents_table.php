<?php

use App\Enums\EnumsStatus;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('link');
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('checked');
            $table->datetime('expires_at');
            $table->string('status')->default(EnumsStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

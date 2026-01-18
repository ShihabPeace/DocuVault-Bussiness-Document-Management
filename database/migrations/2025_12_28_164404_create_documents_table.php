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
            $table->string('link');
            $table->string('filename');
            $table->boolean('is_pending_checked')->default(false);
            $table->boolean('is_quick_checked')->default(false);
            $table->boolean('is_expired_checked')->default(false);
            $table->string('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('expire_date');
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

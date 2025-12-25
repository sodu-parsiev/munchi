<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postbacks', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('offer_id');
            $table->string('goal_id');
            $table->decimal('payout', 10, 2);
            $table->timestamp('click_datetime');
            $table->json('payload');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postbacks');
    }
};

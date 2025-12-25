<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postback_macros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postback_id')->constrained('postbacks')->cascadeOnDelete();
            $table->string('macro_name');
            $table->text('macro_value')->nullable();
            $table->timestamps();

            $table->index('postback_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postback_macros');
    }
};

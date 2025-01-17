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
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('conversation_id')->nullable();
            $table->enum('role', ['user', 'assistant']);
            $table->longText('content')->nullable()->nullable();
            $table->string('intent')->nullable();
            $table->integer('weight')->nullable();
            $table->enum('rating', ['good','bad'])->nullable();
            $table->timestamps();

            // Índices
            // $table->index('conversation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};

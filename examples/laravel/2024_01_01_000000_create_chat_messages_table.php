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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('message_text');
            $table->boolean('is_user_message')->default(true); // true = user, false = bot
            $table->boolean('has_error')->default(false);
            $table->string('session_id')->nullable();
            $table->timestamps();

            // Índices para melhor performance
            $table->index('user_id');
            $table->index('session_id');
            $table->index('created_at');

            // Foreign key (ajuste conforme sua tabela de users)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes para Chat History
|--------------------------------------------------------------------------
|
| Adicione estas rotas ao seu arquivo routes/api.php
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Obter histórico de chat
    Route::get('/chat/history/{userId}', [ChatHistoryController::class, 'getChatHistory']);

    // Salvar mensagem no histórico
    Route::post('/chat/history', [ChatHistoryController::class, 'saveChatMessage']);

    // Limpar histórico de chat
    Route::delete('/chat/history/{userId}', [ChatHistoryController::class, 'clearChatHistory']);
});

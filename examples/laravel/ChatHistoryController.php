<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatHistoryController extends Controller
{
    /**
     * Retorna o histórico de chat do utilizador
     *
     * Endpoint: GET /api/chat/history/{userId}
     */
    public function getChatHistory($userId)
    {
        // Opcional: Verificar se o utilizador autenticado pode acessar este histórico
        if (Auth::id() != $userId && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Buscar mensagens da base de dados
        // Ajuste o nome da tabela e campos conforme sua estrutura
        $messages = DB::table('chat_messages')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'message' => $message->message_text,
                    'isSend' => $message->is_user_message, // true para mensagens do utilizador, false para bot
                    'error' => $message->has_error ?? false,
                ];
            });

        return response()->json($messages);
    }

    /**
     * Salva uma mensagem no histórico
     *
     * Endpoint: POST /api/chat/history
     */
    public function saveChatMessage(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'message_text' => 'required|string',
            'is_user_message' => 'required|boolean',
            'session_id' => 'nullable|string',
        ]);

        $messageId = DB::table('chat_messages')->insertGetId([
            'user_id' => $validated['user_id'],
            'message_text' => $validated['message_text'],
            'is_user_message' => $validated['is_user_message'],
            'session_id' => $validated['session_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message_id' => $messageId
        ]);
    }

    /**
     * Limpa o histórico de chat de um utilizador
     *
     * Endpoint: DELETE /api/chat/history/{userId}
     */
    public function clearChatHistory($userId)
    {
        // Verificar permissões
        if (Auth::id() != $userId && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::table('chat_messages')
            ->where('user_id', $userId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat history cleared'
        ]);
    }
}

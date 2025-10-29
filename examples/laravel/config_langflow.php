<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Langflow Configuration
    |--------------------------------------------------------------------------
    |
    | Configurações para integração com o Langflow Chat Widget
    |
    | Adicione estas variáveis ao seu arquivo .env:
    |
    | LANGFLOW_HOST_URL=https://seu-servidor-langflow.com
    | LANGFLOW_FLOW_ID=seu-flow-id-aqui
    | LANGFLOW_API_KEY=sua-api-key-aqui
    |
    */

    'host_url' => env('LANGFLOW_HOST_URL', 'http://localhost:7860'),

    'flow_id' => env('LANGFLOW_FLOW_ID'),

    'api_key' => env('LANGFLOW_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Chat Widget Configuration
    |--------------------------------------------------------------------------
    */

    'widget' => [
        'window_title' => env('LANGFLOW_WINDOW_TITLE', 'Suporte'),
        'placeholder' => env('LANGFLOW_PLACEHOLDER', 'Digite sua mensagem...'),
        'chat_position' => env('LANGFLOW_CHAT_POSITION', 'bottom-right'),
        'width' => env('LANGFLOW_WIDTH', 400),
        'height' => env('LANGFLOW_HEIGHT', 600),
        'start_open' => env('LANGFLOW_START_OPEN', false),
        'online' => env('LANGFLOW_ONLINE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | History Configuration
    |--------------------------------------------------------------------------
    */

    'history' => [
        // Número máximo de mensagens a carregar do histórico
        'max_messages' => env('LANGFLOW_MAX_HISTORY_MESSAGES', 100),

        // Quantos dias manter mensagens antigas
        'retention_days' => env('LANGFLOW_RETENTION_DAYS', 30),

        // Ativar/desativar salvamento automático de mensagens
        'auto_save' => env('LANGFLOW_AUTO_SAVE', true),
    ],

];

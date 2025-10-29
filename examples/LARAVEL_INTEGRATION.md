# Integração Langflow Chat com Histórico - Laravel + jQuery

Este guia explica como integrar o widget de chat Langflow no seu projeto Laravel com suporte para histórico de conversas armazenado em base de dados.

## 📋 Índice

1. [Funcionalidades](#funcionalidades)
2. [Requisitos](#requisitos)
3. [Instalação](#instalação)
4. [Configuração](#configuração)
5. [Uso](#uso)
6. [Exemplos](#exemplos)
7. [Troubleshooting](#troubleshooting)

## ✨ Funcionalidades

- ✅ Carregar histórico de conversas da base de dados
- ✅ Injetar mensagens antigas ao abrir o chat
- ✅ Salvar novas mensagens automaticamente
- ✅ Session ID único por utilizador
- ✅ Suporte para mensagens de erro
- ✅ Interface customizável

## 📦 Requisitos

- Laravel 8.x ou superior
- PHP 7.4 ou superior
- jQuery 3.6 ou superior
- MySQL/PostgreSQL/SQLite
- Langflow instalado e configurado

## 🚀 Instalação

### Passo 1: Criar a tabela de mensagens

Execute a migration para criar a tabela `chat_messages`:

```bash
php artisan make:migration create_chat_messages_table
```

Copie o conteúdo do arquivo `2024_01_01_000000_create_chat_messages_table.php` para a migration criada e execute:

```bash
php artisan migrate
```

### Passo 2: Criar o Controller

Crie o controller para gerenciar o histórico:

```bash
php artisan make:controller ChatHistoryController
```

Copie o conteúdo do arquivo `ChatHistoryController.php` para o controller criado.

### Passo 3: Adicionar as Rotas

Adicione as rotas ao arquivo `routes/api.php`:

```php
use App\Http\Controllers\ChatHistoryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/history/{userId}', [ChatHistoryController::class, 'getChatHistory']);
    Route::post('/chat/history', [ChatHistoryController::class, 'saveChatMessage']);
    Route::delete('/chat/history/{userId}', [ChatHistoryController::class, 'clearChatHistory']);
});
```

### Passo 4: Configurar o Langflow

Crie o arquivo de configuração `config/langflow.php` com as suas credenciais.

Adicione ao seu `.env`:

```env
LANGFLOW_HOST_URL=https://seu-servidor-langflow.com
LANGFLOW_FLOW_ID=seu-flow-id-aqui
LANGFLOW_API_KEY=sua-api-key-aqui
```

## ⚙️ Configuração

### Estrutura da Base de Dados

A tabela `chat_messages` contém:

- `id` - ID único da mensagem
- `user_id` - ID do utilizador (foreign key para users)
- `message_text` - Texto da mensagem
- `is_user_message` - true = mensagem do utilizador, false = resposta do bot
- `has_error` - Indica se houve erro na mensagem
- `session_id` - ID da sessão do chat
- `created_at` / `updated_at` - Timestamps

### Formato das Mensagens

O histórico deve ser um array JSON com o seguinte formato:

```json
[
  {
    "message": "Olá! Como posso ajudar?",
    "isSend": true,
    "error": false
  },
  {
    "message": "Preciso de suporte técnico",
    "isSend": false,
    "error": false
  }
]
```

Onde:
- `message` (string) - Texto da mensagem
- `isSend` (boolean) - `true` para mensagens do utilizador, `false` para respostas do bot
- `error` (boolean, opcional) - Indica se a mensagem teve erro

## 💻 Uso

### Método 1: HTML Simples + jQuery

```html
<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>
</head>
<body>
    <div id="chat-container"></div>

    <script>
        $(document).ready(function() {
            const userId = "123"; // ID do utilizador

            // Carregar histórico
            $.get('/api/chat/history/' + userId, function(history) {
                const chatElement = document.createElement('langflow-chat');

                chatElement.setAttribute('host_url', 'https://seu-langflow-url.com');
                chatElement.setAttribute('flow_id', 'seu-flow-id');
                chatElement.setAttribute('api_key', 'sua-api-key');
                chatElement.setAttribute('session_id', 'user-' + userId);

                // Injetar histórico
                if (history && history.length > 0) {
                    chatElement.setAttribute('initial_messages', JSON.stringify(history));
                }

                document.getElementById('chat-container').appendChild(chatElement);
            });
        });
    </script>
</body>
</html>
```

### Método 2: Blade Template

Use o template `chat-with-history.blade.php` incluído nos exemplos:

```blade
@extends('layouts.app')

@section('content')
    <h1>Bem-vindo ao Suporte</h1>
    <!-- O chat será carregado automaticamente -->
@endsection
```

### Método 3: Atributo HTML Direto

Se você já tem o histórico disponível como JSON:

```html
<langflow-chat
    host_url="https://seu-langflow-url.com"
    flow_id="seu-flow-id"
    api_key="sua-api-key"
    session_id="user-123"
    initial_messages='[{"message":"Olá!","isSend":true},{"message":"Como posso ajudar?","isSend":false}]'>
</langflow-chat>
```

## 📝 Exemplos

### Exemplo 1: Carregar Histórico do Utilizador Autenticado

```javascript
const userId = {{ auth()->user()->id }};

$.get('/api/chat/history/' + userId)
    .done(function(history) {
        console.log('Carregado:', history.length, 'mensagens');
        initializeChat(history);
    })
    .fail(function() {
        console.error('Erro ao carregar histórico');
        initializeChat([]);
    });
```

### Exemplo 2: Salvar Nova Mensagem

```javascript
function saveMessage(text, isUserMessage) {
    $.post('/api/chat/history', {
        user_id: userId,
        message_text: text,
        is_user_message: isUserMessage,
        session_id: sessionId
    });
}
```

### Exemplo 3: Limpar Histórico

```javascript
function clearHistory() {
    $.ajax({
        url: '/api/chat/history/' + userId,
        method: 'DELETE',
        success: function() {
            console.log('Histórico limpo');
            location.reload();
        }
    });
}
```

### Exemplo 4: Customizar Estilos

```javascript
const chatElement = document.createElement('langflow-chat');

// Estilos customizados
chatElement.setAttribute('bot_message_style', JSON.stringify({
    backgroundColor: '#e3f2fd',
    color: '#1976d2',
    borderRadius: '8px',
    padding: '10px'
}));

chatElement.setAttribute('user_message_style', JSON.stringify({
    backgroundColor: '#1976d2',
    color: '#ffffff',
    borderRadius: '8px',
    padding: '10px'
}));
```

## 🔧 Troubleshooting

### O histórico não carrega

1. Verifique se a rota da API está correta
2. Confirme que o utilizador está autenticado
3. Verifique os logs do Laravel: `tail -f storage/logs/laravel.log`
4. Confirme que a tabela `chat_messages` existe
5. Verifique o console do browser para erros JavaScript

### Mensagens não aparecem formatadas

1. Certifique-se de que o JSON está correto
2. Verifique se `isSend` é boolean, não string
3. Use `JSON.stringify()` ao passar para o atributo

### CORS ou autenticação falha

1. Configure CORS no Laravel: `config/cors.php`
2. Verifique se o token CSRF está sendo enviado
3. Confirme que as rotas estão protegidas corretamente

### Performance com muito histórico

1. Limite o número de mensagens carregadas:
```php
$messages = DB::table('chat_messages')
    ->where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->limit(100) // Últimas 100 mensagens
    ->get();
```

2. Implemente paginação para histórico muito grande

3. Adicione índices na base de dados:
```php
$table->index(['user_id', 'created_at']);
```

## 🔐 Segurança

### Boas Práticas

1. **Sempre valide o user_id**: Certifique-se de que o utilizador só pode acessar seu próprio histórico
2. **Use middleware de autenticação**: Proteja todas as rotas da API
3. **Sanitize inputs**: Valide e limpe todas as entradas do utilizador
4. **Rate limiting**: Configure limites de requisições
5. **HTTPS**: Use sempre conexões seguras em produção

### Exemplo de Validação

```php
public function getChatHistory($userId)
{
    // Verificar se o utilizador pode acessar este histórico
    if (Auth::id() != $userId && !Auth::user()->hasRole('admin')) {
        abort(403, 'Unauthorized');
    }

    // ... resto do código
}
```

## 📚 Recursos Adicionais

- [Documentação Langflow](https://github.com/logspace-ai/langflow)
- [Documentação Laravel](https://laravel.com/docs)
- [jQuery AJAX](https://api.jquery.com/jquery.ajax/)

## 🤝 Contribuições

Encontrou um problema ou tem sugestões? Por favor, abra uma issue no GitHub!

## 📄 Licença

Este exemplo está sob a licença MIT.

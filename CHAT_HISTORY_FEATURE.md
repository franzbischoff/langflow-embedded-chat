# Nova Funcionalidade: Histórico de Chat (initial_messages)

## 🎉 Resumo das Alterações

Foi adicionada uma nova propriedade `initial_messages` ao widget Langflow Chat que permite **injetar mensagens de histórico** diretamente ao carregar o chat.

## 📝 O que foi modificado

### Arquivos alterados:
1. **src/chatWidget/index.tsx** - Adicionada propriedade `initial_messages` e inicialização do estado
2. **src/index.tsx** - Registrada a nova propriedade no web component
3. **README.md** - Documentação da nova propriedade

### Arquivos de exemplo criados:
- **examples/LARAVEL_INTEGRATION.md** - Guia completo de integração com Laravel
- **examples/laravel-jquery-history.html** - Exemplo HTML + jQuery
- **examples/laravel/ChatHistoryController.php** - Controller Laravel
- **examples/laravel/2024_01_01_000000_create_chat_messages_table.php** - Migration
- **examples/laravel/routes_api.php** - Rotas API
- **examples/laravel/config_langflow.php** - Configuração
- **examples/laravel/chat-with-history.blade.php** - Template Blade completo

## 🚀 Como Usar no seu Projeto Laravel + jQuery

### 1. Preparar o histórico da base de dados

O histórico deve estar no formato JSON:

```javascript
[
  {"message": "Olá!", "isSend": true},
  {"message": "Como posso ajudar?", "isSend": false}
]
```

Onde:
- `message` (string) - Texto da mensagem
- `isSend` (boolean) - `true` = mensagem do utilizador, `false` = resposta do bot
- `error` (boolean, opcional) - Indica se houve erro

### 2. Exemplo Rápido - HTML + jQuery

```html
<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./dist/build/static/js/bundle.min.js"></script>
</head>
<body>
    <div id="chat-container"></div>

    <script>
        $(document).ready(function() {
            const userId = "123"; // ID do utilizador

            // Buscar histórico do Laravel
            $.get('/api/chat/history/' + userId, function(history) {

                // Criar o elemento do chat
                const chatElement = document.createElement('langflow-chat');

                // Configurar propriedades básicas
                chatElement.setAttribute('host_url', 'https://seu-langflow.com');
                chatElement.setAttribute('flow_id', 'seu-flow-id');
                chatElement.setAttribute('api_key', 'sua-api-key');
                chatElement.setAttribute('session_id', 'user-' + userId);

                // ⭐ INJETAR HISTÓRICO ⭐
                if (history && history.length > 0) {
                    chatElement.setAttribute('initial_messages', JSON.stringify(history));
                }

                // Adicionar ao DOM
                document.getElementById('chat-container').appendChild(chatElement);
            });
        });
    </script>
</body>
</html>
```

### 3. Exemplo Laravel Controller (Backend)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatHistoryController extends Controller
{
    public function getChatHistory($userId)
    {
        // Buscar mensagens da base de dados
        $messages = DB::table('chat_messages')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'message' => $message->message_text,
                    'isSend' => $message->is_user_message, // true = user, false = bot
                    'error' => $message->has_error ?? false,
                ];
            });

        return response()->json($messages);
    }
}
```

### 4. Estrutura da Tabela (MySQL)

```sql
CREATE TABLE chat_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    message_text TEXT NOT NULL,
    is_user_message BOOLEAN DEFAULT TRUE,
    has_error BOOLEAN DEFAULT FALSE,
    session_id VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_session_id (session_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 🔨 Como Compilar o Projeto

```bash
# Instalar dependências
npm install --legacy-peer-deps

# Compilar
npm run build

# O bundle estará em: dist/build/static/js/bundle.min.js
```

## 📦 Como Testar Localmente

1. Compile o projeto:
```bash
npm install --legacy-peer-deps
npm run build
```

2. Use o arquivo gerado `dist/build/static/js/bundle.min.js` no seu HTML

3. Teste com dados de exemplo:
```html
<langflow-chat
    host_url="http://localhost:7860"
    flow_id="seu-flow-id"
    api_key="sua-api-key"
    initial_messages='[{"message":"Olá!","isSend":true},{"message":"Oi! Como posso ajudar?","isSend":false}]'>
</langflow-chat>
```

## 📚 Documentação Completa

Para um guia completo com todos os exemplos, migrations, controllers e configurações, consulte:

👉 **examples/LARAVEL_INTEGRATION.md**

Este guia inclui:
- ✅ Migration completa para a tabela
- ✅ Controller com todos os métodos (GET, POST, DELETE)
- ✅ Rotas API configuradas
- ✅ Template Blade completo com estilos
- ✅ Configuração do Laravel
- ✅ Exemplos de segurança e boas práticas
- ✅ Troubleshooting

## ⚡ Exemplo Rápido - Direto no HTML (sem AJAX)

Se você já tem o histórico em uma variável PHP (via Blade):

```blade
<langflow-chat
    host_url="{{ config('langflow.host_url') }}"
    flow_id="{{ config('langflow.flow_id') }}"
    api_key="{{ config('langflow.api_key') }}"
    session_id="user-{{ auth()->id() }}"
    initial_messages='@json($chatHistory)'>
</langflow-chat>
```

Onde `$chatHistory` é um array PHP:
```php
$chatHistory = [
    ['message' => 'Olá!', 'isSend' => true],
    ['message' => 'Como posso ajudar?', 'isSend' => false],
];
```

## 🔍 Verificar se Funciona

1. Abra o console do browser (F12)
2. Ao carregar o chat, você deve ver: `"Histórico carregado: X mensagens"`
3. As mensagens antigas devem aparecer automaticamente no chat

## ❓ Problemas Comuns

### O histórico não aparece
- Verifique se o JSON está válido: `JSON.parse(seu_json)`
- Confirme que `isSend` é boolean, não string ("true" vs true)
- Verifique o console do browser para erros

### Formato incorreto
```javascript
// ❌ ERRADO
'[{"message":"Olá","isSend":"true"}]'  // "true" como string

// ✅ CORRETO
'[{"message":"Olá","isSend":true}]'    // true como boolean
```

## 🤝 Contribuir

Esta é uma nova funcionalidade no branch `feat/chat-history`.

Para testar ou contribuir:
```bash
git checkout feat/chat-history
npm install --legacy-peer-deps
npm run build
```

## 📄 Propriedades Disponíveis

| Propriedade | Tipo | Descrição |
|-------------|------|-----------|
| initial_messages | JSON Array | Array de mensagens para pré-carregar o histórico |

Formato de cada mensagem:
```typescript
{
  message: string;      // Texto da mensagem
  isSend: boolean;      // true = user, false = bot
  error?: boolean;      // Opcional, indica erro
}
```

---

**Nota**: Após compilar, use o bundle gerado em `dist/build/static/js/bundle.min.js` no seu projeto Laravel.

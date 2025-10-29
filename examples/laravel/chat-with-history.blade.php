<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat com Histórico - @yield('title', 'Suporte')</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Langflow Chat Widget -->
    <script src="https://cdn.jsdelivr.net/gh/logspace-ai/langflow-embedded-chat@v1.0.7/dist/build/static/js/bundle.min.js"></script>

    @stack('styles')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <!-- Container para o chat -->
    <div id="langflow-chat-container"></div>

    <script>
        $(document).ready(function() {
            // Configurações do chat
            const chatConfig = {
                hostUrl: '{{ config('services.langflow.host_url') }}',
                flowId: '{{ config('services.langflow.flow_id') }}',
                apiKey: '{{ config('services.langflow.api_key') }}',
                userId: '{{ auth()->user()->id ?? "guest" }}',
                userName: '{{ auth()->user()->name ?? "Convidado" }}',
            };

            // Configurar CSRF token para todas as requisições AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Função para carregar histórico
            function loadChatHistory() {
                return $.ajax({
                    url: '/api/chat/history/' + chatConfig.userId,
                    method: 'GET',
                    dataType: 'json'
                });
            }

            // Função para salvar mensagem no histórico
            function saveChatMessage(messageText, isUserMessage, sessionId) {
                return $.ajax({
                    url: '/api/chat/history',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        user_id: chatConfig.userId,
                        message_text: messageText,
                        is_user_message: isUserMessage,
                        session_id: sessionId
                    }
                });
            }

            // Função para inicializar o chat
            function initializeChat(history) {
                const chatElement = document.createElement('langflow-chat');

                // Configurações básicas
                chatElement.setAttribute('host_url', chatConfig.hostUrl);
                chatElement.setAttribute('flow_id', chatConfig.flowId);
                chatElement.setAttribute('api_key', chatConfig.apiKey);

                // Session ID único para o utilizador
                chatElement.setAttribute('session_id', 'user-' + chatConfig.userId);

                // Configurações de interface
                chatElement.setAttribute('window_title', 'Suporte - ' + chatConfig.userName);
                chatElement.setAttribute('placeholder', 'Digite sua mensagem...');
                chatElement.setAttribute('placeholder_sending', 'Enviando...');
                chatElement.setAttribute('chat_position', 'bottom-right');
                chatElement.setAttribute('width', '400');
                chatElement.setAttribute('height', '600');
                chatElement.setAttribute('start_open', 'false');
                chatElement.setAttribute('online', 'true');
                chatElement.setAttribute('online_message', 'Estamos online!');

                // Estilos personalizados (opcional)
                const botMessageStyle = {
                    backgroundColor: '#e3f2fd',
                    color: '#1976d2',
                    borderRadius: '8px',
                    padding: '10px'
                };

                const userMessageStyle = {
                    backgroundColor: '#1976d2',
                    color: '#ffffff',
                    borderRadius: '8px',
                    padding: '10px'
                };

                chatElement.setAttribute('bot_message_style', JSON.stringify(botMessageStyle));
                chatElement.setAttribute('user_message_style', JSON.stringify(userMessageStyle));

                // INJETAR HISTÓRICO
                if (history && history.length > 0) {
                    chatElement.setAttribute('initial_messages', JSON.stringify(history));
                    console.log('Histórico carregado:', history.length, 'mensagens');
                }

                // Adicionar ao DOM
                document.getElementById('langflow-chat-container').appendChild(chatElement);

                // Opcional: Interceptar novas mensagens para salvar no banco
                // Nota: Isto é uma abordagem básica. Para produção, considere
                // usar webhooks ou callbacks do Langflow
                observeNewMessages(chatElement);
            }

            // Função para observar novas mensagens (exemplo básico)
            function observeNewMessages(chatElement) {
                // Esta é uma implementação simplificada
                // Em produção, você pode querer usar MutationObserver ou
                // eventos personalizados do widget

                // Exemplo: Salvar quando detectar mudanças
                setInterval(function() {
                    // Lógica para detectar e salvar novas mensagens
                    // Isto é apenas um placeholder - ajuste conforme necessário
                }, 5000);
            }

            // Inicializar
            loadChatHistory()
                .done(function(history) {
                    console.log('Histórico carregado com sucesso');
                    initializeChat(history);
                })
                .fail(function(xhr, status, error) {
                    console.error('Erro ao carregar histórico:', error);
                    // Inicializar sem histórico em caso de erro
                    initializeChat([]);
                });
        });
    </script>

    @stack('scripts')
</body>
</html>

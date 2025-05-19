@extends('layouts.app')

@section('title', 'Conversation avec ' . $client->Username)

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête de la conversation -->
        <div class="p-4 border-b bg-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $client->Username }}</h3>
                        <p class="text-sm text-blue-100">{{ $client->Email }}</p>
                    </div>
                </div>
                <a href="{{ route('chat.list') }}" class="text-white hover:text-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
            </div>
        </div>

        <!-- Zone des messages -->
        <div class="h-[600px] overflow-y-auto p-4" id="messages-container">
            @foreach($messages as $message)
                <div class="mb-4 {{ $message->SenderID === auth()->id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block max-w-[70%] {{ $message->SenderID === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800' }} rounded-lg px-4 py-2">
                        <p class="text-sm">{{ $message->Message }}</p>
                        <span class="text-xs {{ $message->SenderID === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                            {{ $message->created_at->format('H:i') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Zone de saisie -->
        <div class="p-4 border-t">
            <form id="message-form" class="flex gap-2">
                <input type="text" name="message" placeholder="Écrivez votre message..." class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i>Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Faire défiler jusqu'au dernier message
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Fonction pour charger les nouveaux messages
    function loadNewMessages() {
        fetch(`{{ route('chat.messages') }}?receiver_id={{ $client->UserID }}`)
            .then(response => response.json())
            .then(data => {
                const messagesHtml = data.messages.map(message => `
                    <div class="mb-4 ${message.SenderID === {{ auth()->id() }} ? 'text-right' : 'text-left'}">
                        <div class="inline-block max-w-[70%] ${message.SenderID === {{ auth()->id() }} ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800'} rounded-lg px-4 py-2">
                            <p class="text-sm">${message.Message}</p>
                            <span class="text-xs ${message.SenderID === {{ auth()->id() }} ? 'text-blue-100' : 'text-gray-500'}">
                                ${new Date(message.created_at).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}
                            </span>
                        </div>
                    </div>
                `).join('');
                messagesContainer.innerHTML = messagesHtml;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }

    // Charger les nouveaux messages toutes les 5 secondes
    setInterval(loadNewMessages, 5000);

    // Gérer l'envoi des messages
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = this.querySelector('input[name="message"]');
        const message = messageInput.value.trim();
        
        if (message) {
            // Envoyer le message via AJAX
            fetch('{{ route("chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: message,
                    receiver_id: '{{ $client->UserID }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    loadNewMessages(); // Recharger les messages immédiatement
                }
            });
        }
    });
</script>
@endsection 
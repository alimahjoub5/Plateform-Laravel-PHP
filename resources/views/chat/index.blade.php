@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête du chat -->
        <div class="bg-gray-800 text-white p-4">
            <h1 class="text-xl font-bold">Chat - {{ $project->Title }}</h1>
            <p class="text-sm text-gray-300">Client: {{ $project->client->FirstName }} {{ $project->client->LastName }}</p>
        </div>

        <!-- Zone des messages -->
        <div class="h-[600px] overflow-y-auto p-4 space-y-4" id="messages-container">
            @foreach($messages as $message)
            <div class="flex {{ $message->SenderID === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] rounded-lg p-3 
                    @if($message->SenderID === auth()->id())
                        bg-blue-500 text-white
                    @else
                        @if($message->sender->Role === 'admin')
                            bg-purple-500 text-white
                        @elseif($message->sender->Role === 'developer')
                            bg-green-500 text-white
                        @elseif($message->sender->Role === 'designer')
                            bg-pink-500 text-white
                        @elseif($message->sender->Role === 'chef_projet')
                            bg-yellow-500 text-white
                        @else
                            bg-gray-100 text-gray-800
                        @endif
                    @endif">
                    <div class="flex items-center mb-1">
                        <span class="font-semibold text-sm">
                            {{ $message->sender->FirstName }} {{ $message->sender->LastName }}
                            <span class="text-xs ml-2 opacity-75">
                                ({{ ucfirst($message->sender->Role) }})
                            </span>
                        </span>
                        <span class="text-xs ml-2 {{ $message->SenderID === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                            {{ $message->created_at->format('H:i') }}
                        </span>
                        @if(!$message->IsRead && $message->SenderID !== auth()->id())
                            <span class="ml-2 text-xs bg-red-500 text-white px-2 py-1 rounded-full">Non lu</span>
                        @endif
                    </div>
                    <p class="text-sm">{{ $message->Message }}</p>
                    @if($message->AttachmentURL)
                    <div class="mt-2">
                        <a href="{{ Storage::url($message->AttachmentURL) }}" target="_blank" class="text-sm underline">
                            <i class="fas fa-paperclip mr-1"></i> Pièce jointe
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Formulaire d'envoi de message -->
        <div class="border-t p-4">
            <form action="{{ route('chat.store', $project->ProjectID) }}" method="POST" enctype="multipart/form-data" class="flex space-x-4">
                @csrf
                <div class="flex-grow">
                    <textarea name="message" rows="1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Écrivez votre message..."></textarea>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="cursor-pointer bg-gray-100 hover:bg-gray-200 rounded-lg p-2">
                        <input type="file" name="attachment" class="hidden">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </label>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Faire défiler automatiquement vers le dernier message
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Marquer les messages comme lus
    function markMessagesAsRead() {
        const unreadMessages = document.querySelectorAll('.message:not(.read)');
        unreadMessages.forEach(message => {
            const messageId = message.dataset.messageId;
            fetch(`/chat/messages/${messageId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
        });
    }

    // Vérifier les nouveaux messages toutes les 30 secondes
    setInterval(() => {
        const lastMessageId = document.querySelector('.message:last-child')?.dataset.messageId;
        if (lastMessageId) {
            fetch(`/chat/messages?after=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages.length > 0) {
                        location.reload();
                    }
                });
        }
    }, 30000);

    // Notification sonore pour les nouveaux messages
    const audio = new Audio('/notification.mp3');
    
    function playNotificationSound() {
        audio.play();
    }

    // Écouter les nouveaux messages
    const messagesContainer = document.getElementById('messages-container');
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.addedNodes.length) {
                playNotificationSound();
            }
        });
    });

    observer.observe(messagesContainer, { childList: true });
</script>
@endpush
@endsection 
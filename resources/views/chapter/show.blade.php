<div class="mt-12 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">Comentarios ({{ $chapter->comments->count() }})</h3>

    @auth
        <form action="{{ route('comments.store', $chapter->id) }}" method="POST" class="mb-8">
            @csrf
            <textarea 
                name="content" 
                rows="3" 
                class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                placeholder="Escribe tu opinión sobre este capítulo..."
                required></textarea>
            <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                Publicar Comentario
            </button>
        </form>
    @else
        <p class="mb-8 text-gray-600 italic">
            Para dejar un comentario, <a href="{{ route('login') }}" class="text-blue-600 underline">inicia sesión</a>.
        </p>
    @endauth

    <div class="space-y-6">
        @forelse($chapter->comments as $comment)
            <div class="flex space-x-4 border-b border-gray-100 pb-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-1 text-gray-700 text-sm leading-relaxed">
                        {{ $comment->content }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Aún no hay comentarios. ¡Sé el primero en opinar!</p>
        @endforelse
    </div>
</div>
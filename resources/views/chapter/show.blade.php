<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $story->title }} - <span class="text-gray-500">{{ $chapter->title }}</span>
            </h2>
            <a href="{{ route('stories.show', $story) }}" class="text-sm text-indigo-600 hover:underline font-bold">
                &larr; Volver al índice
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f9f9f9]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Contenido del Capítulo (Como si fuera un libro) -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-8 md:p-14 mb-8 border border-gray-100">
                <h1 class="text-4xl font-black text-gray-900 mb-10 text-center" style="font-family: 'Instrument Sans', sans-serif;">{{ $chapter->title }}</h1>
                
                <!-- nl2br respeta los saltos de línea del textarea -->
                <div class="text-lg text-gray-800 leading-loose space-y-6">
                    {!! nl2br(e($chapter->content)) !!}
                </div>
            </div>

            <!-- SECCIÓN DE COMENTARIOS -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center gap-2">
                    💬 Comentarios del Capítulo
                </h3>

                <!-- Formulario para comentar -->
                @auth
                    <form action="{{ route('stories.comments.store', $chapter) }}" method="POST" class="mb-10 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        @csrf
                        <label class="block text-sm font-bold text-gray-700 mb-2">Añadir un comentario</label>
                        <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#744E36] focus:border-[#744E36]" placeholder="¿Qué te ha parecido este capítulo?" required></textarea>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="bg-[#744E36] text-white px-6 py-2 rounded-full font-bold hover:bg-[#5c3d2a] transition shadow-md">
                                Publicar Comentario
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-10 bg-blue-50 p-4 rounded-lg border border-blue-100 text-center">
                        <p class="text-sm text-blue-800">Debes <a href="{{ route('login') }}" class="font-bold underline">iniciar sesión</a> para comentar.</p>
                    </div>
                @endauth

                <!-- Lista de comentarios -->
                <div class="space-y-6">
                    @forelse($chapter->comments as $comment)
                        <div class="flex space-x-4">
                            <!-- Avatar de usuario con la inicial -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-[#744E36] rounded-full flex items-center justify-center text-white font-bold uppercase text-lg shadow-sm">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            </div>
                            
                            <!-- Burbuja de mensaje -->
                            <div class="flex-grow bg-gray-50 p-5 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm">
                                <div class="flex items-center justify-between mb-2 border-b border-gray-200 pb-2">
                                    <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                                    <span class="text-xs text-gray-500 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <!-- Estado vacío si nadie ha comentado -->
                        <div class="text-center py-10 opacity-60 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-600 italic font-medium">Sé el primero en dejar un comentario sobre este capítulo.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
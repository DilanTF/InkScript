<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between w-full mb-8 px-2">
                @if($previousChapter)
                    <a href="{{ route('stories.chapters.show', [$story, $previousChapter]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-bold text-gray-700 hover:border-[#744E36] hover:text-[#744E36] transition-all shadow-sm hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span class="hidden sm:inline">Anterior</span>
                    </a>
                @else
                    <div class="w-24"></div> @endif

                <a href="{{ route('stories.show', $story) }}" class="flex items-center gap-2 px-6 py-2.5 text-white rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Índice
                </a>

                @if($nextChapter)
                    <a href="{{ route('stories.chapters.show', [$story, $nextChapter]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-bold text-gray-700 hover:border-[#744E36] hover:text-[#744E36] transition-all shadow-sm hover:shadow">
                        <span class="hidden sm:inline">Siguiente</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <div class="w-24"></div> @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 md:p-14 mb-8 border border-gray-100">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 text-center leading-tight" style="font-family: 'Instrument Sans', sans-serif;">
                    {{ $chapter->title }}
                </h1>
                
                <p class="text-center text-sm font-bold uppercase tracking-widest text-gray-400 mb-10 border-b border-gray-100 pb-8">
                    {{ $story->title }}
                </p>
                
                <div class="text-lg md:text-xl text-gray-800 leading-loose space-y-6 font-serif">
                    {!! nl2br(e($chapter->content)) !!}
                </div>
            </div>

            <div class="flex items-center justify-between w-full mb-12 px-2">
                @if($previousChapter)
                    <a href="{{ route('stories.chapters.show', [$story, $previousChapter]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-bold text-gray-700 hover:border-[#744E36] hover:text-[#744E36] transition-all shadow-sm hover:shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span class="hidden sm:inline">Anterior</span>
                    </a>
                @else
                    <div class="w-24"></div>
                @endif

                <a href="{{ route('stories.show', $story) }}" class="flex items-center gap-2 px-6 py-2.5 text-white rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Índice
                </a>

                @if($nextChapter)
                    <a href="{{ route('stories.chapters.show', [$story, $nextChapter]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-bold text-gray-700 hover:border-[#744E36] hover:text-[#744E36] transition-all shadow-sm hover:shadow">
                        <span class="hidden sm:inline">Siguiente</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <div class="w-24"></div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-50 pb-4 flex items-center gap-2" style="font-family: 'Instrument Sans', sans-serif;">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Comentarios del Capítulo
                </h3>

                @auth
                    <form action="{{ route('stories.comments.store', $chapter) }}" method="POST" class="mb-10 bg-[#F9F7F2]/60 p-6 rounded-2xl border border-gray-100 shadow-inner">
                        @csrf
                        <label class="block text-sm font-bold text-gray-700 mb-2">Añadir un comentario</label>
                        <textarea name="content" rows="3" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-[#744E36] focus:border-[#744E36] p-4 transition-colors resize-none" placeholder="¿Qué te ha parecido este capítulo?" required></textarea>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="text-white px-8 py-3 rounded-full font-bold shadow-md hover:shadow-lg transition-all" style="background-color: #744E36;" onmouseover="this.style.backgroundColor='#5c3d2a'" onmouseout="this.style.backgroundColor='#744E36'">
                                Publicar Comentario
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-10 bg-gray-50 p-6 rounded-2xl border border-gray-100 text-center">
                        <p class="text-gray-600 font-medium">Debes <a href="{{ route('login') }}" class="font-bold text-[#744E36] hover:underline">iniciar sesión</a> para participar en la conversación.</p>
                    </div>
                @endauth

                <div class="space-y-6">
                    @forelse($chapter->comments as $comment)
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-full flex items-center justify-center text-gray-600 font-black uppercase text-lg shadow-sm">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            </div>
                            
                            <div class="flex-grow bg-white p-5 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm">
                                <div class="flex items-center justify-between mb-3 border-b border-gray-50 pb-2">
                                    <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                                    <span class="text-xs text-gray-400 font-medium bg-gray-50 px-2 py-1 rounded-full">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-500 font-medium">Sé el primero en dejar un comentario sobre este capítulo.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
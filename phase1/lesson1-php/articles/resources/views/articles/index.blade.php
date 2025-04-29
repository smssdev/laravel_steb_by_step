@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($articles as $article)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}"
                     alt="{{ $article->title }}"
                     class="w-full h-48 object-cover">
            @endif

            <div class="p-4">
                <h2 class="text-xl font-bold mb-2">
                    <a href="{{ route('articles.show', $article) }}"
                       class="text-blue-600 hover:text-blue-800">
                        {{ $article->title }}
                    </a>
                </h2>

                <div class="text-gray-600 text-sm mb-2">
                    <span>بواسطة: {{ $article->author->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $article->created_at->diffForHumans() }}</span>
                </div>

                <p class="text-gray-700 mb-4">
                    {{ Str::limit($article->content, 100) }}
                </p>

                <div class="flex justify-between items-center">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                        {{ $article->status }}
                    </span>

                    @can('update', $article)
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <a href="{{ route('articles.edit', $article) }}"
                               class="text-yellow-600 hover:text-yellow-800">
                                تعديل
                            </a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا المقال؟')"
                                        class="text-red-600 hover:text-red-800">
                                    حذف
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-8">
            <p class="text-gray-600">لا توجد مقالات حتى الآن</p>
        </div>
    @endforelse
</div>

{{ $articles->links() }}
@endsection

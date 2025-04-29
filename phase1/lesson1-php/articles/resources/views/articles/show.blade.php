@extends('layouts.app')

@section('content')
<article class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
    @if($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}"
             alt="{{ $article->title }}"
             class="w-full h-96 object-cover rounded-lg mb-6">
    @endif

    <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>

    <div class="flex items-center text-gray-600 mb-4">
        <img src="{{ $article->author->avatar ? asset('storage/' . $article->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($article->author->name) }}"
             alt="{{ $article->author->name }}"
             class="w-10 h-10 rounded-full ml-3">

        <div>
            <p>{{ $article->author->name }}</p>
            <p class="text-sm">
                نُشر في {{ $article->created_at->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    <div class="prose max-w-none mb-6">
        {!! nl2br(e($article->content)) !!}
    </div>

    @can('update', $article)
        <div class="flex space-x-2 rtl:space-x-reverse mb-6">
            <a href="{{ route('articles.edit', $article) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg">
                تعديل المقال
            </a>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('هل أنت متأكد من حذف هذا المقال؟')"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg">
                    حذف المقال
                </button>
            </form>
        </div>
    @endcan

    <section class="border-t pt-6">
        <h2 class="text-2xl font-bold mb-4">التعليقات ({{ $article->comments->count() }})</h2>

        @forelse($article->comments as $comment)
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <div class="flex items-center mb-2">
                    <img src="{{ $comment->author->avatar ? asset('storage/' . $comment->author->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->author->name) }}"
                         alt="{{ $comment->author->name }}"
                         class="w-8 h-8 rounded-full ml-3">

                    <div>
                        <p class="font-bold">{{ $comment->author->name }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <p>{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-gray-600">لا توجد تعليقات حتى الآن</p>
        @endforelse

        <form action="{{ route('comments.store', $article) }}" method="POST" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-gray-700 mb-2">اكتب تعليقك</label>
                <textarea name="content"
                          id="content"
                          rows="4"
                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                          required></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                إرسال التعليق
            </button>
        </form>
    </section>
</article>
@endsection

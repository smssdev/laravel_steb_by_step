@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>جميع المقالات</h1>

        @foreach($articles as $article)
            <div class="article-card">
                <h2>{{ $article->title }}</h2>
                <p>كتب بواسطة: {{ $article->author->name }}</p>
                <p>{{ Str::limit($article->content, 200) }}</p>
                <a href="{{ route('articles.show', $article->id) }}">قراءة المزيد</a>
            </div>
        @endforeach

        {{ $articles->links() }}
    </div>
@endsection

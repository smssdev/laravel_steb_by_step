@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $article->title }}</h1>

        <div class="article-meta">
            <span>كتب بواسطة: {{ $article->author->name }}</span>
            <span>بتاريخ: {{ $article->published_at }}</span>
        </div>

        <div class="article-content">
            {{ $article->content }}
        </div>

        <h3>التعليقات ({{ $article->comments->count() }})</h3>

        @foreach($article->comments as $comment)
            <div class="comment">
                <p>{{ $comment->content }}</p>
                <small>{{ $comment->user->name }}</small>
            </div>
        @endforeach
    </div>
@endsection


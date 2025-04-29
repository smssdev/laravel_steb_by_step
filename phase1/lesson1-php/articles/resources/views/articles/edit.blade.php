@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">
        {{ isset($article) ? 'تعديل المقال' : 'إنشاء مقال جديد' }}
    </h1>

    <form action="{{ isset($article) ? route('articles.update', $article) : route('articles.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="title" class="block text-gray-700 mb-2">العنوان</label>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $article->title ?? '') }}"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   required>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 mb-2">المحتوى</label>
            <textarea name="content"
                      id="content"
                      rows="6"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      required>{{ old('content', $article->content ?? '') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="featured_image" class="block text-gray-700 mb-2">الصورة الرئيسية</label>
            <input type="file"
                   name="featured_image"
                   id="featured_image"
                   class="w-full px-3 py-2 border rounded-lg">

            @if(isset($article) && $article->featured_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                         alt="الصورة الحالية"
                         class="w-48 h-32 object-cover rounded-lg">
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 mb-2">الحالة</label>
            <select name="status"
                    id="status"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <option value="draft" {{ (isset($article) && $article->status == 'draft') ? 'selected' : '' }}>
                    مسودة
                </option>
                <option value="published" {{ (isset($article) && $article->status == 'published') ? 'selected' : '' }}>
                    منشور
                </option>
                <option value="archived" {{ (isset($article) && $article->status == 'archived') ? 'selected' : '' }}>
                    مؤرشف
                </option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                {{ isset($article) ? 'تحديث المقال' : 'إنشاء المقال' }}
            </button>
        </div>
    </form>
</div>
@endsection

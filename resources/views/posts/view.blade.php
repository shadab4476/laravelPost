@extends('layouts.nav')

@section('content')
    <div class="py-10">
        <div class="mb-10  text-white link_heading flex justify-between items-center">
            <h1 class=" text-4xl font-bold">Post</h1>
            <a class=" bg-blue-500 px-5 py-3 transition-all hover:bg-blue-400" href="{{ route('posts.index') }}">All Posts</a>
        </div>
        <div class="parent_post_view flex justify-between text-white">
            <div class="postName">
                <button class="py-10 px-20 rounded hover:bg-orange-400 bg-orange-600 text-lg"> Name:
                    {{ $post->name }}</button>
            </div>
            <div class="postContent">
                <button class="py-10 px-20 rounded hover:bg-orange-400 bg-orange-600 text-lg">Content:
                    {{ $post->content }}</button>
            </div>
            <div class="postCat">
                <button class="py-10 px-20 rounded hover:bg-orange-400 bg-orange-600 text-lg">Category:
                    {{ $post->category->name }}</button>
            </div>
        </div>
    </div>
@endsection

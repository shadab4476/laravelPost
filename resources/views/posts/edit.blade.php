@extends('layouts.nav')

@section('content')
    <div class="post_parent py-10">

        <div class="mb-10 link_heading flex text-white justify-between items-center">
            <h1 class=" text-4xl  font-bold">Post Create</h1>
            <a class=" bg-blue-500 px-5 py-3 transition-all hover:bg-blue-400" href="{{ route('posts.index') }}">All Posts</a>
        </div>
        <div class="text-white post_form mx-auto p-10 bg-orange-500  w-1/3">
            <form method="POST" class=" w-full " action="{{ route('posts.update', $post->id) }}">
                @csrf
                @method('put')
                <label class="w-full" for="name">Name</label>
                <input autofocus value="{{ $post->name }}" class=" text-black w-full mb-2  focus:outline-0 p-3"
                    placeholder="Name" type="text" id="name" name="name" required>
                @if (session()->has('error'))
                    <div class="text-red-600 font-bold">{{ session()->get('error') }}</div>
                @endif
                @error('name')
                    <div class="text-red-600 font-bold">{{ $message }}</div>
                @enderror
                <label class="w-full" for="content">Content</label>
                <input value="{{ $post->content }}" class="w-full mb-2 text-black   focus:outline-0 p-3" type="content"
                    placeholder="content" id="content" name="content" required>
                @error('content')
                    <div class="text-red-600 font-bold">{{ $message }}</div>
                @enderror

                <label for="category" class="block">Category</label>
                <select required class="bg-neutral-700 mb-2 w-full focus:outline-none px-5 py-3" name="category_id"
                    id="category">
                    <option value="">Select Category</option>
                    @forelse ($categories as $category)
                        <option {{ strtolower($category->id == $post->category_id) ? 'selected' : '' }}
                            value="{{ $category->id }}">
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-red-600 font-bold">{{ $message }}</div>
                @enderror

                <div class="w-1/2 mt-4">
                    <button class="bg-orange-900 hover:opacity-70 transition-all py-3 text-white w-full" type="submit">
                        Create</button>
                </div>

            </form>
        </div>
    </div>
@endsection

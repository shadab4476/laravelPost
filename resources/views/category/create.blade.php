@extends('layouts.nav')

@section('content')
    <div class="category_parent py-10">

        <div class="mb-10 link_heading flex text-white justify-between items-center">
            <h1 class=" text-4xl  font-bold">Category Create</h1>
            <a class=" bg-blue-500 px-5 py-3 transition-all hover:bg-blue-400" href="{{ route('categories.index') }}">All
                Categories</a>
        </div>
        <div class="text-white category_form mx-auto p-10 bg-orange-500  w-1/3">
            <form method="post" class=" w-full " action="{{ route('categories.store') }}">
                @csrf
                <label class="w-full" for="name">Name</label>
                <input autofocus value="{{ old('name') }}"class=" text-black w-full mb-2  focus:outline-0 p-3"
                    placeholder="Name" type="text" id="name" name="name" required>
                @error('name')
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

@extends('layouts.nav')

@section('content')
    <div class="register_form mx-auto mt-10 p-10 bg-blue-400  w-1/3">
        <p>

            @if (session()->has('status'))
                <div class="text-red-600 font-bold">{{ session()->get('status') }}</div>
            @endif
        </p>
        <h1 class="text-3xl font-medium mb-2">Login</h1>
        <form method="POST" class="w-full flex-wrap" action="{{ route('login') }}">
            @csrf
            <label class="w-full" for="email">Email</label>
            <input autofocus class="w-full mb-2 focus:outline-0 p-3" type="email" placeholder="Email" id="email" name="email"
                required>
            @error('email')
                <div class="text-red-600 font-bold">{{ $message }}</div>
            @enderror
            <label class="w-full" for="password">Password</label>
            <input class="w-full focus:outline-0 p-3" type="password" placeholder="Password" id="password" name="password"
                required>
            @error('password')
                <div class="text-red-600 font-bold">{{ $message }}</div>
            @enderror
            <div class="w-1/2 mt-4">
                <button class="bg-green-400 py-3 text-white w-full" type="submit"> Login</button>
            </div>

        </form>
    </div>
@endsection

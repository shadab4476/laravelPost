@extends('layouts.nav')

@section('content')
    <div class="register_form mx-auto mt-10 p-10 bg-blue-400  w-1/3">
        <h1 class="text-3xl font-medium mb-2">Register</h1>
        <form method="POST" class="w-full flex-wrap" action="{{ route('register') }}">
            @csrf
            <label class="w-full" for="name">Name</label>
            <input autofocus class="w-full mb-2 focus:outline-0 p-3" placeholder="Name" type="text" id="name" name="name"
                required>
            @error('name')
                <div class="text-red-600 font-bold">{{ $message }}</div>
            @enderror
            <label class="w-full" for="email">Email</label>
            <input class="w-full mb-2 focus:outline-0 p-3" type="email" placeholder="Email" id="email" name="email"
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
                <button class="bg-green-400 py-3 text-white w-full" type="submit"> Register</button>
            </div>

        </form>
        <div class="mt-4">
            You have already registre <a class="text-blue-900 underline" href="{{ route('login.get') }}">Login</a> now
        </div>
    </div>
@endsection

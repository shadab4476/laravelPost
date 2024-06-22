<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Home</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/web.css') }}"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
    <div
        class="header_parent {{ auth()->check() && session()->has('verified_mobile_otp') ? 'bg-orange-700' : 'bg-black' }}   text-white">
        <div class="px-5 py-2">
            <header>
                <nav class="flex items-center justify-between">
                    <div class="logo w-1/5">
                        <a class="text-xl" href="{{ route('home') }}">LOGO</a>
                    </div>
                    @if (auth()->check() && session()->has('verified_mobile_otp'))
                        <ul class=" w-2/5 gap-x-3 flex">
                            <li><a class="text-lg" href="{{ route('home') }}">Home</a></li>
                            <li><a class="text-lg" href="{{ route('posts.index') }}">Posts</a></li>
                            <li><a class="text-lg" href="{{ route('categories.index') }}">Category</a></li>
                        </ul>
                    @endif

                    @if (auth()->check() && session()->has('verified_mobile_otp'))
                        <div class="w-2/5 logout_parent flex justify-between">
                            <button type="button" class="capitalize text-lg">Hello
                                <i>{{ auth()->user()->name }}</i></button>
                            <a class="text-lg hover:text-gray-300" href="{{ route('logout') }}">Logout</a>
                        </div>
                    @else
                        <div class="w-1/5 logout_parent flex justify-end">
                            <a class="text-lg" href="{{ route('login') }}">Login</a>
                            <a class="text-lg ml-2" href="{{ route('register') }}">Register</a>
                        </div>
                    @endif
                </nav>
            </header>
        </div>
    </div>
    {{-- --}}
    <main
        class="main_web_parent {{ auth()->check() && session()->has('verified_mobile_otp') ? ' bg-neutral-900 ' : '' }}">
        <div class="container mx-auto ">
            @yield('content')
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $(".dataTables_wrapper .dataTables_length select").addClass("!bg-neutral-900");
            $(".dataTables_filter input[type=search]").addClass("focus:outline-0");

            if ("{{ session()->has('status') }}") {
                $(".message_text_show").fadeIn().delay(3000).fadeOut();
            }
        });
    </script>
</body>

</html>

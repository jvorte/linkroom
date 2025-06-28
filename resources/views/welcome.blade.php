<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Βεβαιώσου ότι έχεις αυτό -->
</head>

<body class="relative bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col items-center justify-center p-6 lg:p-8">

    <!-- ΒΙΝΤΕΟ BACKGROUND -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-[-2]">
        <source src="{{ asset('storage/images/video3.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- OVERLAY (για να διαβάζεται καλύτερα το περιεχόμενο) -->
    <div class="fixed inset-0 bg-black/40 z-[-1]"></div>

    <!-- HEADER -->
    <header class="w-full max-w-4xl text-sm mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    {{-- <a href="{{ url('/professionals') }}"
                       class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Find Professionals
                    </a> --}}
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block px-5 py-1.5 text-[#1b1b18] dark:text-[#EDEDEC] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- MAIN CONTENT -->
<main class="w-full max-w-[335px] lg:max-w-4xl flex flex-col items-center justify-center min-h-[300px] lg:min-h-[500px] relative text-center text-white z-10 px-4">
    {{-- <h1 class="text-6xl font-extrabold tracking-wide drop-shadow-lg select-none "> --}}
   <img class="w-3xs" src="{{ asset('storage/images/14.png') }}" alt="Front image">

    {{-- </h1> --}}
    <p class="text-lg lg:text-xl mb-8 drop-shadow-md max-w-xl">
    Find trusted professionals. Get the job done.
    </p>
    <a href="{{ route('professionals.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-semibold transition">
        Find Professionals
    </a>
</main>



    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('messages.app_title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Fade-in animation για το βίντεο */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .video-background {
            animation: fadeIn 1.5s ease-in-out forwards;
            opacity: 0;
            min-height: 100vh;
            width: 100vw;
            object-fit: cover;
        }
    </style>
</head>

<body class="relative bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col items-center justify-center p-6 lg:p-8">

    <!-- Βίντεο Background -->
    <video autoplay muted loop playsinline poster="{{ asset('storage/images/fallback.jpg') }}"
        class="fixed inset-0 z-[-2] video-background">
        <source src="{{ asset('storage/images/video3.mp4') }}" type="video/mp4" />
        {{ __('messages.no_video_support') }}
    </video>

    <!-- Overlay με διακριτικό gradient -->
    <div
        class="fixed inset-0 z-[-1] bg-gradient-to-t from-black/60 via-transparent to-black/40">
    </div>

    <!-- Περιεχόμενο -->
    <main
        class="relative z-10 max-w-7xl mx-auto px-6 py-20 text-center text-white flex flex-col items-center justify-center min-h-[300px] lg:min-h-[500px]">

        <img class="w-40 md:w-60 mb-8" src="{{ asset('storage/images/14.png') }}" alt="Front image" />

        <p class="text-lg lg:text-xl max-w-xl mb-8 drop-shadow-md">
            {{ __('messages.tagline') }}
        </p>

        <a href="{{ route('professionals.index', ['lang' => app()->getLocale()]) }}"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-semibold transition">
            {{ __('messages.find_professionals') }}
        </a>
    </main>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</body>

</html>

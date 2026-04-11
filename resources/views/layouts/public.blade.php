<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Portal Data & Informasi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    {{-- Tailwind CDN (sementara dev) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 font-[Inter] text-gray-800">

{{-- ================= HEADER ================= --}}
<header class="bg-gradient-to-r from-emerald-600 to-teal-500 text-white shadow-md">
    <div class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="/images/logo-kemenag.png"
            alt="Logo"
                class="h-12 w-auto">
            <div>
                <h1 class="text-xl font-semibold tracking-wide">
                    Portal Data & Informasi
                </h1>
                <p class="text-sm text-emerald-100">
                    Kementerian Agama Kabupaten Tuban
                </p>
            </div>
        </div>
        <div>
            <a href="{{route('login')}}"
                class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 px-4 py-2 rounded-xl text-sm font-medium backdrop-blur transition duration-200 shadow-sm">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login Pegawai
            </a>
        </div>
    </div>
</header>

{{-- ================= CONTENT ================= --}}
<main class="max-w-6xl mx-auto px-6 py-10">
    @yield('content')
</main>

@stack('scripts')

</body>
</html>
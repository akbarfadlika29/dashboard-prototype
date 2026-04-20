<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Portal Data & Informasi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-kemenag.png') }}">

    {{-- Google Font Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    {{-- Tailwind CDN (sementara dev) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    {{-- Init Theme --}}
    <script>
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark')
        }
    </script>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-slate-900 dark:text-white font-[Inter] transition-colors duration-300">

{{-- ================= HEADER ================= --}}
<header class="sticky top-0 z-50 backdrop-blur bg-white/80 dark:bg-slate-900/80 border-b border-gray-200 dark:border-slate-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <img src="{{ asset('images/logo-kemenag.png') }}" class="h-11 w-auto">
            <div class="leading-tight hidden sm:block">
                <h1 class="font-bold text-lg">Portal Data & Informasi</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400">Kementerian Agama Kabupaten Tuban</p>
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            {{-- Dark Mode --}}
            <button onclick="toggleTheme()"
                class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-800 hover:scale-105 transition">
                <i class="fa-solid fa-moon dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:inline"></i>
            </button>
            
            <a href="{{route('login')}}"
                class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>
        </div>
    </div>
</header>

{{-- ================= CONTENT ================= --}}
<main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
    @yield('content')
</main>

<script>
function toggleTheme(){
    document.documentElement.classList.toggle('dark')

    if (document.documentElement.classList.contains('dark')) {
        localStorage.theme = 'dark'
    } else {
        localStorage.theme = 'l'
    }
}
</script>

@stack('scripts')

</body>
</html>
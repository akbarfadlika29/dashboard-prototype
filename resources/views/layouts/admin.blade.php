<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-72 bg-green-800 text-white flex flex-col shadow-xl">

        {{-- HEADER --}}
        <div class="px-6 py-6 border-b border-green-700">
            <div class="flex items-center gap-3">
                <img src="/images/logo-kemenag.png" class="w-11 h-11 object-contain">

                <div>
                    <h1 class="font-bold text-lg leading-tight">
                        PUSDATIN
                    </h1>
                    <p class="text-xs text-green-100 leading-tight">
                        Kemenag Tuban
                    </p>
                </div>
            </div>
        </div>

        {{-- USER INFO --}}
        <div class="px-6 py-5 border-b border-green-700">
            <p class="text-sm text-green-100">Login sebagai</p>

            <h2 class="font-semibold mt-1">
                {{ auth()->user()->nama }}
            </h2>

            <div class="mt-2 inline-flex items-center rounded-full bg-green-700 px-3 py-1 text-xs capitalize">
                {{ str_replace('_', ' ', auth()->user()->role) }}
            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('admin.dashboard')
                    ? 'bg-white text-green-800 font-semibold shadow'
                    : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            {{-- DATASET --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'admin_umum', 'admin_seksi']))
                <a href="{{ route('dataset.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('dataset.*') || request()->routeIs('admin-dataset.*')
                        ? 'bg-white text-green-800 font-semibold shadow'
                        : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    <i class="fa-solid fa-database w-5 text-center"></i>
                    <span>Dataset</span>
                </a>
            @endif

            {{-- APPROVAL --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'kepala_seksi']))
                <a href="{{ route('admin.approval.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('admin.approval.*')
                        ? 'bg-white text-green-800 font-semibold shadow'
                        : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    <i class="fa-solid fa-circle-check w-5 text-center"></i>
                    <span>Approval</span>
                </a>
            @endif

            {{-- KATEGORI --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'admin_umum']))
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('admin.kategori.*')
                        ? 'bg-white text-green-800 font-semibold shadow'
                        : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    <i class="fa-solid fa-folder-tree w-5 text-center"></i>
                    <span>Kategori</span>
                </a>
            @endif

            {{-- SEKSI --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.seksi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('admin.seksi.*')
                        ? 'bg-white text-green-800 font-semibold shadow'
                        : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    <i class="fa-solid fa-building-columns w-5 text-center"></i>
                    <span>Seksi</span>
                </a>
            @endif

            {{-- USER --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.user.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                   {{ request()->routeIs('admin.user.*')
                        ? 'bg-white text-green-800 font-semibold shadow'
                        : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>User</span>
                </a>
            @endif

        </nav>

        {{-- FOOTER --}}
        <div class="border-t border-green-700 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 transition text-white py-3 rounded-xl font-medium">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between shadow-sm">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    @yield('title')
                </h2>

                @hasSection('subtitle')
                    <p class="text-sm text-gray-500 mt-1">
                        @yield('subtitle')
                    </p>
                @endif
            </div>

            <div class="text-right">
                <div class="text-sm text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-8">

            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
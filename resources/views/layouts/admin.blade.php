<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
    [x-cloak] {
        display: none !important;
    }
    </style>
    @stack('styles')
</head>

<body
    class="bg-slate-50"
    x-data="{
        sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false'
    }"
    x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
>

<div class="min-h-screen flex">

    {{-- ================= SIDEBAR ================= --}}
    <aside
        :class="sidebarOpen ? 'w-72' : 'w-20'"
        class="fixed left-0 top-0 h-screen bg-green-800 text-white flex flex-col shadow-xl transition-all duration-300 z-50"
    >

        {{-- HEADER --}}
        <div
            :class="sidebarOpen ? 'px-6' : 'px-2'"
            class="py-6 border-b border-green-700 transition-all duration-300"
        >
            <div
                :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3"
            >

                <img
                    src="/images/logo-kemenag.png"
                    class="w-11 h-11 object-contain flex-shrink-0"
                >

                <div
                    x-show="sidebarOpen"
                    x-transition
                    x-cloak
                >
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
        <div
            x-show="sidebarOpen"
            x-transition
            x-cloak
            class="px-6 py-5 border-b border-green-700"
        >
            <p class="text-sm text-green-100">Login sebagai</p>

            <h2 class="font-semibold mt-1">
                {{ auth()->user()->nama }}
            </h2>

            <div class="mt-2 inline-flex items-center rounded-full bg-green-700 px-3 py-1 text-xs capitalize">
                {{ auth()->user()->seksi->pluck('nama')->join(', ') }}
            </div>
        </div>

        @php
        $activeClass = 'bg-white text-green-800 font-semibold shadow';
        $inactiveClass = 'text-green-100 hover:bg-green-700 hover:text-white';
        @endphp
        {{-- MENU --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard.index') }}"
               :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('admin.dashboard.*') ? $activeClass : $inactiveClass }}">

                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span
                    x-show="sidebarOpen"
                    x-transition
                    x-cloak
                >
                    Dashboard
                </span>
            </a>

            {{-- DATASET --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'admin_umum', 'admin_seksi']))
                <a href="{{ route('dataset.index') }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('dataset.*') ? $activeClass : $inactiveClass }}">

                    <i class="fa-solid fa-database w-5 text-center"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                    >
                        Dataset
                    </span>
                </a>
            @endif

            {{-- APPROVAL --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'kepala_seksi']))
                <a href="{{ route('admin.approval.index') }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.approval.*') ? $activeClass : $inactiveClass }}">

                    <i class="fa-solid fa-circle-check w-5 text-center"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                    >
                        Approval
                    </span>
                </a>
            @endif

            {{-- KATEGORI --}}
            @if(in_array(auth()->user()->role, ['superadmin', 'admin_umum']))
                <a href="{{ route('admin.kategori.index') }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.kategori.*') ? $activeClass : $inactiveClass }}">

                    <i class="fa-solid fa-folder-tree w-5 text-center"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                    >
                        Kategori
                    </span>
                </a>
            @endif

            {{-- SEKSI --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.seksi.index') }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.seksi.*') ? $activeClass : $inactiveClass }}">

                    <i class="fa-solid fa-building-columns w-5 text-center"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                    >
                        Seksi
                    </span>
                </a>
            @endif

            {{-- USER --}}
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('admin.user.index') }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->routeIs('admin.user.*') ? $activeClass : $inactiveClass }}">

                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                    >
                        User
                    </span>
                </a>
            @endif

        </nav>

        {{-- FOOTER --}}
        <div class="border-t border-green-700 p-4">

            <form
                method="POST"
                action="{{ route('logout') }}"
                x-data="{ loading:false }"
                @submit="loading = true"
            >
                @csrf

                <button
                    type="submit"
                    :disabled="loading"
                    :class="loading
                        ? 'opacity-70 cursor-not-allowed'
                        : 'hover:bg-red-600'"
                    class="w-full flex items-center justify-center gap-2 bg-red-500 transition text-white py-3 rounded-xl font-medium"
                >

                    {{-- ICON NORMAL --}}
                    <i
                        x-show="!loading"
                        x-transition
                        class="fa-solid fa-right-from-bracket"
                    ></i>

                    {{-- SPINNER --}}
                    <i
                        x-show="loading"
                        x-transition
                        class="fa-solid fa-spinner fa-spin"
                    ></i>

                    {{-- TEXT --}}
                    <span
                        x-show="sidebarOpen"
                        x-transition
                        x-cloak
                        x-text="loading ? 'Logging out...' : 'Logout'"
                    ></span>

                </button>

            </form>

        </div>

    </aside>

    {{-- ================= MAIN CONTENT ================= --}}
    <div
        :class="sidebarOpen ? 'ml-72' : 'ml-20'"
        class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
    >

        {{-- TOPBAR --}}
        <header
            class="fixed top-0 right-0 z-40 bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between shadow-sm transition-all duration-300"
            :class="sidebarOpen ? 'left-72' : 'left-20'"
        >

            <div class="flex items-center gap-4">

                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="relative z-[999] w-10 h-10 rounded-lg hover:bg-gray-100 flex items-center justify-center"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

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

            </div>

            <div class="text-right">
                <div class="text-sm text-gray-500">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-8 pt-28">

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

@stack('scripts')

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Pusdatin Kemenag Tuban</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

    {{-- LOGO --}}
    <div class="text-center mb-6">
        <img src="/images/logo-kemenag.png" class="mx-auto w-20 mb-3">
        <h2 class="text-xl font-semibold text-gray-800">
            PUSDATIN KEMENAG TUBAN
        </h2>
        <p class="text-sm text-gray-500">
            Silakan login untuk melanjutkan
        </p>
    </div>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-600 text-sm p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- FORM --}}
    <form method="POST" action="/login" class="space-y-4">
        @csrf

        {{-- NIP --}}
        <div>
            <label class="text-sm text-gray-600">NIP</label>
            <input type="text" name="nip"
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                   placeholder="Masukkan NIP"
                   required>
        </div>

        {{-- PASSWORD --}}
        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"
                   placeholder="Masukkan Password"
                   required>
        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition">
            Login
        </button>
    </form>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Login - Pusdatin Kemenag Tuban</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>

<body class="font-[Inter] bg-gradient-to-br from-emerald-50 to-teal-100 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md">

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-xl p-8">

        {{-- HEADER --}}
        <div class="text-center mb-6">
            <img src="/images/logo-kemenag.png" class="mx-auto w-20 mb-3">
            <h2 class="text-xl font-semibold text-gray-800">
                Pusdatin Kemenag Tuban
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Silakan login untuk melanjutkan
            </p>
        </div>

        {{-- FORM --}}
        <form id="loginForm" method="POST" action="/login" class="space-y-5">
            @csrf

            {{-- NIP --}}
            <div>
                <label class="text-sm text-gray-600">NIP</label>
                <input type="text" name="nip" id="nip"
                       value="{{ old('nip') }}"
                       class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 
                              focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                       placeholder="Masukkan NIP"
                       required>
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-sm text-gray-600">Password</label>

                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full mt-1 px-4 py-2.5 rounded-xl border border-gray-300 
                                  focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                           placeholder="Masukkan Password"
                           required>

                    {{-- TOGGLE --}}
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <p id="capsWarning" class="text-xs text-red-500 mt-1 hidden">
                    Caps Lock aktif!
                </p>
            </div>

            {{-- REMEMBER --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded">
                    Ingat saya
                </label>
            </div>

            {{-- BUTTON --}}
            <button type="submit" id="loginBtn"
                class="w-full flex items-center justify-center gap-2 
                       bg-emerald-600 hover:bg-emerald-700 
                       text-white py-2.5 rounded-xl font-medium transition">

                <span id="btnText">Login</span>

                <svg id="loadingIcon" class="hidden w-4 h-4 animate-spin"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8z"></path>
                </svg>

            </button>

        </form>

    </div>

</div>

{{-- SCRIPT --}}
<script>

// ===== LOADING + VALIDASI =====
const form = document.getElementById('loginForm');
const btn = document.getElementById('loginBtn');
const text = document.getElementById('btnText');
const loading = document.getElementById('loadingIcon');

form.addEventListener('submit', function(e){

    const nip = document.getElementById('nip').value.trim();
    const password = document.getElementById('password').value.trim();

    if(!nip || !password){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Form belum lengkap',
            text: 'NIP dan Password wajib diisi'
        });

        return;
    }

    text.innerText = 'Memproses...';
    loading.classList.remove('hidden');
    btn.disabled = true;
});


// ===== TOGGLE PASSWORD =====
function togglePassword(){
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');

    if(input.type === 'password'){
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}


// ===== CAPS LOCK DETECTION =====
const passwordInput = document.getElementById('password');
const capsWarning = document.getElementById('capsWarning');

passwordInput.addEventListener('keyup', function(e){
    if (e.getModifierState && e.getModifierState('CapsLock')) {
        capsWarning.classList.remove('hidden');
    } else {
        capsWarning.classList.add('hidden');
    }
});

</script>

{{-- ERROR --}}
@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Login Gagal',
    text: '{{ $errors->first() }}'
});
</script>
@endif

{{-- SUCCESS --}}
@if(session('login_success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Login Berhasil',
    text: 'Selamat datang!',
    timer: 1500,
    showConfirmButton: false
});
</script>
@endif

</body>
</html>
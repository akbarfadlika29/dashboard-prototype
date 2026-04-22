@extends('layouts.public')

@section('title', 'Verifikasi OTP')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center">

    <div class="w-full max-w-md bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8">

        {{-- HEADER --}}
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-kemenag.png') }}" class="mx-auto w-16 mb-3">
            <h2 class="text-xl font-bold">Verifikasi OTP</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
                Masukkan kode OTP yang dikirim ke WhatsApp Anda
            </p>
        </div>

        {{-- ERROR --}}
        @if($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-100 px-4 py-2 rounded-lg text-center">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf

            <input type="hidden" name="otp" id="otpFinal">

            {{-- OTP INPUT --}}
            <div class="flex justify-between gap-2 mb-6">
                @for($i=0; $i<6; $i++)
                    <input type="text" maxlength="1"
                        class="otp-input w-12 h-12 text-center text-lg font-bold border rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none"
                        inputmode="numeric" pattern="[0-9]*">
                @endfor
            </div>

            <p class="text-xs text-gray-400 text-center mb-4">
                OTP berlaku selama 5 menit
            </p>

            <button type="submit" id="btnSubmit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-xl transition flex items-center justify-center gap-2">
                
                <span id="btnText">Verifikasi OTP</span>

                <svg id="btnLoading" class="hidden animate-spin h-5 w-5"
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

@endsection


@push('scripts')
<script>
const inputs = document.querySelectorAll('.otp-input');
const otpFinal = document.getElementById('otpFinal');
const form = document.getElementById('otpForm');
const btnSubmit = document.getElementById('btnSubmit');
const btnText = document.getElementById('btnText');
const btnLoading = document.getElementById('btnLoading');

// AUTO INPUT
inputs.forEach((input, index) => {

    input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '');

        if (input.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }

        updateOTP();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });

});

// GABUNG OTP
function updateOTP(){
    let otp = '';
    inputs.forEach(i => otp += i.value);
    otpFinal.value = otp;

    if (otp.length === 6) {
        form.submit();
    }
}

// LOADING
form.addEventListener('submit', () => {
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    btnSubmit.disabled = true;
});
</script>
@endpush
<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-block p-3 border-2 border-gray-200 rounded-lg mb-4">
            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Verifikasi OTP</h1>
        <p class="text-gray-500 mt-2">Masukkan kode 6 digit yang dikirim ke email Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('otp.verify.submit') }}">
        @csrf

        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="space-y-6">
            <div>
                <label for="email_display" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email_display" value="{{ session('email') }}" disabled
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500">
            </div>

            <div>
                <label for="otp_code" class="block text-sm font-medium text-gray-700">Kode OTP</label>
                <input type="text" id="otp_code" name="otp_code" maxlength="6" placeholder="000000"
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 text-center text-2xl font-mono tracking-widest"
                    required autofocus>
                <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="mt-8">
            <button type="submit"
                class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Verifikasi</button>
        </div>
    </form>

    <!-- Resend OTP -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-500">
            Tidak menerima kode?
        </p>
        <form method="POST" action="{{ route('otp.resend') }}" class="inline">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <button type="submit" class="text-sm font-medium text-red-600 hover:underline">
                Kirim Ulang OTP
            </button>
        </form>
    </div>

    <p class="text-center text-sm text-gray-500 mt-6">
        <a href="{{ route('login') }}" class="font-medium text-red-600 hover:underline">Kembali ke Login</a>
    </p>
</x-guest-layout>
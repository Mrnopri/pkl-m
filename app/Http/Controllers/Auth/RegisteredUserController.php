<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OtpVerificationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'nim' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
            'is_verified' => false,
        ]);

        event(new Registered($user));

        // Send OTP via email
        $user->notify(new OtpVerificationNotification($otpCode));

        // Redirect to OTP verification page
        return redirect()->route('otp.verify')->with([
            'email' => $user->email,
            'status' => 'Kode OTP telah dikirim ke email Anda. Silakan cek inbox atau folder spam.'
        ]);
    }

    /**
     * Display the OTP verification form.
     */
    public function showOtpForm(): View|RedirectResponse
    {
        if (!session('email')) {
            return redirect()->route('register')->with('error', 'Silakan daftar terlebih dahulu.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Handle OTP verification.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Check if OTP is expired
        if ($user->otp_expires_at < now()) {
            return back()->withErrors(['otp_code' => 'Kode OTP telah kadaluarsa. Silakan minta kode baru.']);
        }

        // Verify OTP
        if ($user->otp_code !== $request->otp_code) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        // Mark user as verified
        $user->update([
            'is_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(),
        ]);

        // Login user
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun Anda berhasil diverifikasi!');
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        if ($user->is_verified) {
            return redirect()->route('login')->with('status', 'Akun Anda sudah terverifikasi. Silakan login.');
        }

        // Generate new OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send new OTP
        $user->notify(new OtpVerificationNotification($otpCode));

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}

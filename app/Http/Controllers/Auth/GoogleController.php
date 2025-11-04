<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }

        // cek apakah user dengan google_id sudah ada
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // login
            Auth::login($user, true);
            return redirect()->intended('/dashboard');
        }

        // kalau user dengan email sama sudah ada, hubungkan akun
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // assign google_id lalu login
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
            Auth::login($existingUser, true);
            return redirect()->intended('/dashboard');
        }

        // buat user baru
        $user = User::create([
            'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'User ' . Str::random(6),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(Str::random(16)),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            // tambah field lain sesuai kebutuhan
        ]);

        Auth::login($user, true);

        return redirect()->intended('/')->with('success', 'Berhasil Login');
    }
}

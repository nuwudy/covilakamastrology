@extends('layouts.app')

@section('title', 'Admin Login | Covilakam Astrology')
@section('meta_description', 'Official Administrator Login for Covilakam Astrology portal.')

@section('content')
<div class="pt-32 pb-24 bg-[#0d0716] min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        
        <!-- Logo & Header -->
            <div class="w-20 h-20 rounded-full mx-auto p-1 bg-gradient-to-tr from-amber-600 via-amber-300 to-yellow-500 shadow-2xl gold-glow">
                <img src="{{ asset('images/og-covilakam-512x512.png') }}"
                     alt="Covilakam Astrology Logo"
                     class="w-full h-full rounded-full object-cover shadow-inner">
            </div>
            
            <div>
                <h1 class="font-cinzel text-2xl sm:text-3xl font-black text-white">
                    Administrator Login
                </h1>
                <p class="text-xs text-amber-300/80 font-cinzel mt-1">
                    Covilakam Astrology Portal
                </p>
                <p class="text-[11px] text-amber-100/60 mt-0.5">
                    Dr. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)
                </p>
            </div>
        </div>

        <!-- Login Card -->
        <div class="card-gold-frame rounded-3xl p-8 sm:p-9 shadow-2xl bg-[#160d26]/95 border-2 border-amber-500/40 backdrop-blur-xl">
            
            @if ($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-950/70 border border-rose-500/40 text-xs text-rose-200 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5 text-xs">
                @csrf

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Email Address *</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus autocomplete="email"
                               class="w-full px-4 py-3 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 transition-colors text-xs font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-amber-200 mb-1.5">Password *</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                               placeholder="Enter your password"
                               class="w-full px-4 py-3 rounded-xl bg-[#231538] border border-amber-500/30 text-white placeholder-amber-200/40 focus:outline-none focus:border-amber-400 transition-colors text-xs pr-10">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-3 text-amber-400/70 hover:text-white focus:outline-none">
                            <span x-show="!show">👁️</span>
                            <span x-show="show" x-cloak>🙈</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-amber-200/80 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-[#231538] border-amber-500/30 text-amber-400 focus:ring-0">
                        <span>Remember session</span>
                    </label>

                    <a href="{{ route('home') }}" class="text-amber-400 hover:text-amber-200 underline">
                        Back to Portal
                    </a>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3.5 rounded-xl font-bold text-sm text-[#1a1128] bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-500 hover:from-amber-200 hover:to-yellow-300 shadow-xl hover:shadow-amber-500/30 transition-all">
                        Sign In to Admin Dashboard
                    </button>
                </div>
            </form>

            <!-- Security Notice -->
            <div class="mt-6 pt-5 border-t border-amber-500/20 text-center text-[11px] text-amber-200/50">
                <span>🔒 Secure Administrator Portal • Authorized Access Only</span>
            </div>

        </div>

    </div>
</div>
@endsection

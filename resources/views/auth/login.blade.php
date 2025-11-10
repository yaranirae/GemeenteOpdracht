@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg sm:max-w-xl bg-white/5 backdrop-blur-xl rounded-2xl shadow-2xl p-6 sm:p-8 border border-white/10">
            <div class="text-center mb-6">
                <h1 class="text-3xl sm:text-4xl font-bold text-[#1b4332] leading-tight">{{ __('Welcome Back') }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ __('Please sign in to your account') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                @csrf

                <div class="flex flex-col">
                    <label for="email" class="text-sm font-medium text-gray-800 mb-1">{{ __('Email Address') }}</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="Enter your email"
                           class="w-full px-4 py-3 bg-black/30 border border-gray-700 rounded-lg shadow-sm text-white placeholder-gray-500 focus:ring-2 focus:ring-white focus:border-white transition duration-200 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="password" class="text-sm font-medium text-gray-800 mb-1">{{ __('Password') }}</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="Enter your password"
                           class="w-full px-4 py-3 bg-black/30 border border-gray-700 rounded-lg shadow-sm text-white placeholder-gray-500 focus:ring-2 focus:ring-white focus:border-white transition duration-200 @error('password') border-red-500 @enderror">
                    @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm text-gray-800 mt-1">
                    <label for="remember" class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember"
                               class="text-white bg-black/30 border-gray-600 rounded focus:ring-white focus:ring-2"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('Remember Me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="hover:text-white transition duration-200">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-3 mt-2 bg-white text-black font-semibold rounded-lg shadow-lg hover:bg-gray-200 hover:scale-[1.02] transform transition duration-200">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
    </div>
@endsection

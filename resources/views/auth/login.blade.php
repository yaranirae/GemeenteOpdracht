@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-black to-gray-800">
        <div class="w-full max-w-md bg-white/5 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/10">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white">{{ __('Welcome Back') }}</h1>
                <p class="text-gray-400 mt-2 text-sm">{{ __('Please sign in to your account') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">{{ __('Email Address') }}</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="mt-2 w-full px-4 py-3 bg-black/30 border border-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-white focus:border-white text-white placeholder-gray-500 transition duration-200 @error('email') border-red-500 @enderror"
                           placeholder="Enter your email">

                    @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">{{ __('Password') }}</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="mt-2 w-full px-4 py-3 bg-black/30 border border-gray-700 rounded-lg shadow-sm focus:ring-2 focus:ring-white focus:border-white text-white placeholder-gray-500 transition duration-200 @error('password') border-red-500 @enderror"
                           placeholder="Enter your password">

                    @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center space-x-2 text-sm text-gray-400">
                        <input type="checkbox" name="remember" id="remember"
                               class="text-white bg-black/30 border-gray-600 rounded focus:ring-white focus:ring-2"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('Remember Me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full py-3.5 px-4 bg-white text-black font-semibold rounded-lg shadow-lg hover:bg-gray-200 hover:scale-105 transform transition duration-200">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
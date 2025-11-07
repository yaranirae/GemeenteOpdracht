@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-white to-indigo-200">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-700">{{ __('Welcome Back') }}</h1>
                <p class="text-gray-500 mt-2 text-sm">{{ __('Please sign in to your account') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">

                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">

                    @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me + Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="flex items-center space-x-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" id="remember"
                               class="text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span>{{ __('Remember Me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            @if (Route::has('register'))
                <p class="mt-8 text-center text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">
                        {{ __('Register here') }}
                    </a>
                </p>
            @endif
        </div>
    </div>
@endsection
